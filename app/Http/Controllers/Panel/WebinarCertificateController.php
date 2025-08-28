<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mixins\Certificate\MakeCertificate;
use App\Models\Bundle;
use App\Models\Certificate;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\Webinar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebinarCertificateController extends Controller
{

    public function index(Request $request)
    {
        Log::info("Index method called.");

        $this->authorize("panel_certificates_course_certificates");
        Log::info("Authorization passed for user.", ['user_id' => auth()->id()]);

        $user = auth()->user();
        Log::info("Authenticated user fetched.", ['user' => $user]);

        $webinars = $this->calculateCoursesCertificates($user);
        Log::info("Courses certificates calculated.", ['count' => count($webinars)]);

        $bundles = $this->calculateBundlesCertificates($user);
        Log::info("Bundles certificates calculated.", ['count' => count($bundles)]);

        $query = Certificate::query()->where('student_id', $user->id);
        Log::info("Certificate query initialized.", ['student_id' => $user->id]);

        $query->where(function (Builder $query) {
            $query->where(function (Builder $query) {
                $query->whereNotNull('webinar_id')
                    ->where('type', 'course');
            });

            $query->orWhere(function (Builder $query) {
                $query->whereNotNull('bundle_id')
                    ->where('type', 'bundle');
            });
        });
        Log::info("Certificate query conditions applied.");

        $certificates = $this->handleFilters($query, $request)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        Log::info("Certificates fetched and paginated.", ['count' => $certificates->total()]);

        $data = [
            'pageTitle' => trans('update.course_certificates'),
            'certificates' => $certificates,
            'userWebinars' => $webinars,
        ];

        Log::info("Data prepared for the view.", ['data' => $data]);

        return view('web.default.panel.certificates.webinar_certificates', $data);
    }

    private function handleFilters($query, $request)
    {
        Log::info("Handling filters for the certificates.");

        $from = $request->get('from');
        $to = $request->get('to');
        $webinar_id = $request->get('webinar_id');

        Log::info("Filter inputs received.", ['from' => $from, 'to' => $to, 'webinar_id' => $webinar_id]);

        fromAndToDateFilter($from, $to, $query, 'created_at');
        Log::info("Date filter applied.");

        if (!empty($webinar_id)) {
            $query->where('webinar_id', $webinar_id);
            Log::info("Webinar ID filter applied.", ['webinar_id' => $webinar_id]);
        }

        return $query;
    }

    private function calculateCoursesCertificates($user)
    {
        Log::info("Calculating courses certificates.", ['user_id' => $user->id]);

        $webinars = Webinar::where('status', 'active')
            ->where('certificate', true)
            ->whereHas('sales', function ($query) use ($user) {
                $query->where('buyer_id', $user->id);
                $query->whereNull('refund_at');
                $query->where('access_to_purchased_item', true);
            })
            ->get();

        Log::info("Webinars fetched for certificates.", ['count' => count($webinars)]);

        foreach ($webinars as $webinar) {
            Log::info("Generating certificate for webinar.", ['webinar_id' => $webinar->id]);
            $webinar->makeCertificateForUser($user);
        }

        return $webinars;
    }

    private function calculateBundlesCertificates($user)
    {
        Log::info("Calculating bundles certificates.", ['user_id' => $user->id]);

        $bundles = Bundle::query()->where('status', 'active')
            ->where('certificate', true)
            ->whereHas('sales', function ($query) use ($user) {
                $query->where('buyer_id', $user->id);
                $query->whereNull('refund_at');
                $query->where('access_to_purchased_item', true);
            })
            ->get();

        Log::info("Bundles fetched for certificates.", ['count' => count($bundles)]);

        foreach ($bundles as $bundle) {
            Log::info("Processing bundle.", ['bundle_id' => $bundle->id]);

            if (count($bundle->bundleWebinars)) {
                $allCoursesPass = true;

                foreach ($bundle->bundleWebinars as $bundleWebinar) {
                    $webinar = $bundleWebinar->webinar;

                    if ($webinar->getProgress(true) < 100) {
                        //$allCoursesPass = false;
                    }
                }

                if ($allCoursesPass) {
                    Log::info("Generating certificate for bundle.", ['bundle_id' => $bundle->id]);
                    $bundle->makeCertificateForUser($user);
                }
            }
        }

        return $bundles;
    }

    public function showCourseCertificate($certificateId)
    {
        Log::info("Showing course certificate.", ['certificate_id' => $certificateId]);

        $user = auth()->user();

        $certificate = Certificate::where('id', $certificateId)
            ->where('student_id', $user->id)
            ->whereNotNull('webinar_id')
            ->first();

        if (!empty($certificate)) {
            Log::info("Certificate found.", ['certificate_id' => $certificate->id]);

            $makeCertificate = new MakeCertificate();

            return $makeCertificate->makeCourseCertificate($certificate);
        }

        Log::warning("Certificate not found or unauthorized access.", ['certificate_id' => $certificateId]);
        abort(404);
    }

    public function showBundleCertificate($certificateId)
    {
        Log::info("Showing bundle certificate.", ['certificate_id' => $certificateId]);

        $user = auth()->user();

        $certificate = Certificate::where('id', $certificateId)
            ->where('student_id', $user->id)
            ->whereNotNull('bundle_id')
            ->first();

        if (!empty($certificate)) {
            Log::info("Certificate found.", ['certificate_id' => $certificate->id]);

            $makeCertificate = new MakeCertificate();

            return $makeCertificate->makeBundleCertificate($certificate);
        }

        Log::warning("Certificate not found or unauthorized access.", ['certificate_id' => $certificateId]);
        abort(404);
    }
}
