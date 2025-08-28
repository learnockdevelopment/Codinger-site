<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\User;
use App\Models\Translation\WebinarTranslation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QrCodeGroupsExport;
use App\Exports\QrCodesExport;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;
use ZipArchive;

class QrCodeController extends Controller
{

public function exportQrCodeAsPdf($qrCodeId)
{
    $qrCode = QrCode::with('user')->findOrFail($qrCodeId);

    // Generate the QR code as a data URL (base64 encoded)
    $qrCodeData = QrCodeFacade::format('png')->size(150)->generate($qrCode->code);
    $qrCodeBase64 = base64_encode($qrCodeData); // Renamed variable

    // Pass the QR code base64 data to the view
    $pdf = Pdf::loadView('admin.financial.qrcodes.pdf', compact('qrCode', 'qrCodeBase64'));
    return $pdf->download('qrcode_' . $qrCode->code . '.pdf');
}

// Delete all vouchers in a specific group (batch_name)
public function deleteGroup($batchName)
{
    \Log::info('Deleting all vouchers for group', ['batch_name' => $batchName]);

    // Delete vouchers that belong to the specified batch group
    $deletedCount = QrCode::where('batch_name', $batchName)->delete();

    \Log::info('Vouchers deleted for batch group', ['batch_name' => $batchName, 'deleted_count' => $deletedCount]);

    // Redirect back with a success message
    return redirect()->back()->with('success', trans('admin/main.vouchers_deleted_success', ['batch_name' => $batchName, 'count' => $deletedCount]));
}
public function exportQrCodesInGroupAsZip($batchName)
{
    Log::info('Started exporting QR codes for batch: ' . $batchName);

    $qrCodeGroup = QrCode::where('batch_name', $batchName)->get();
        Log::info('QR Code Group fetched: ', ['qrCodeGroup' => $qrCodeGroup]);

        $qrCodes = $qrCodeGroup;
        Log::info('Number of QR Codes: ' . count($qrCodes));
foreach ($qrCodes as $qrCode) {
        // Generate the QR code and encode it to base64
        $qrCodeData = QrCodeFacade::format('png')->size(150)->generate($qrCode->code);
        $qrCode->base64Image = base64_encode($qrCodeData);
    }
        // Create the PDF in chunks of 10 QR codes per page
        $pdf = PDF::loadView('admin.financial.qrcodes.group_pdf', [
            'qrCodes' => $qrCodes  // Create chunks of 10 QR codes per page
        ]);
        Log::info('PDF chunks created.');

        
        return $pdf->download('qrcode_' . $batchName . '.pdf');

}

public function index()
{
    \Log::info('Fetching list of QR code groups - Start');

    // Step 1: Eager loading related models
    \Log::info('Loading related models: bundle, category, webinar');

    // Step 2: Building the query
    \Log::info('Building query to select QR code group details and statistics');

    $qrCodeGroupsQuery = QrCode::with(['bundle', 'category', 'webinar']) // Eager load related models
        ->select(
            'batch_name',
            'bundle_id',
            'category_id',
            'webinar_ids',
            \DB::raw('MIN(created_at) as created_at'),
            \DB::raw('COUNT(*) as qrcodes_count'),
            \DB::raw('SUM(CASE WHEN is_used = 1 THEN 1 ELSE 0 END) as used_count'),  // Count used QR codes
            \DB::raw('SUM(CASE WHEN is_used = 0 THEN 1 ELSE 0 END) as unused_count'),  // Count unused QR codes
            \DB::raw('MIN(expiration_date) as expiration_date')  // Fetch the earliest expiration date for the group
        );

    \Log::info('Query built successfully.');

    // Step 3: Grouping and ordering
    \Log::info('Applying group by and order by clauses.');

    $qrCodeGroups = $qrCodeGroupsQuery
        ->groupBy('batch_name', 'bundle_id', 'category_id', 'webinar_ids')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    \Log::info('Query executed and results paginated.', ['total_groups' => $qrCodeGroups]);

    // Step 4: Preparing data for the view
    \Log::info('Preparing data for the view.');

    $data = [
        'pageTitle' => trans('admin/main.qrcodes_title'),
        'qrCodeGroups' => $qrCodeGroups,
    ];

    \Log::info('Data prepared successfully, returning view.');

    return view('admin.financial.qrcodes.lists', $data);
}






    public function exportQrCodesInGroupAsPdf($batchName)
    {
        $qrCodes = QrCode::where('batch_name', $batchName)->get();
        
        if ($qrCodes->isEmpty()) {
            \Log::warning('No QR codes found in group', ['batch_name' => $batchName]);
            return response()->json(['message' => 'No QR codes found in this group.'], 404);
        }

        $pdf = PDF::loadView('admin.financial.qrcodes.group_pdf', compact('qrCodes'));
        return $pdf->download('qrcodes_in_group_' . $batchName . '.pdf');
    }

    public function create()
    {
        $data = [
            'pageTitle' => trans('admin/main.new_qrcode_title'),
        ];

        return view('admin.financial.qrcodes.new', $data);
    }

    public function validateQrCode(Request $request)
    {
        $qrCodeValue = $request->get('qrcode');
        if (!$qrCodeValue) {
            \Log::error('QR code value not provided');
            return response()->json([
                'valid' => false,
                'message' => 'QR code value is required.'
            ], 400);
        }

        $qrCode = QrCode::where('code', $qrCodeValue)->first();
        if ($qrCode && !$qrCode->is_used) {
            return response()->json([
                'valid' => true,
                'message' => 'QR code is valid.',
                'amount' => $qrCode->amount
            ]);
        }

        return response()->json(['valid' => false, 'message' => 'Invalid or already used QR code.'], 400);
    }

 public function viewGroup($batchName)
{
    \Log::info('Current locale', ['locale' => app()->getLocale()]);
    \Log::info('Displaying the list of QR codes for group', ['batch_name' => $batchName]);

    $qrCodesQuery = QrCode::where('batch_name', $batchName)
    ->with(['user', 'bundle', 'category', 'used_in_course']) // Eager load the relationships
    ->orderBy('created_at', 'desc'); // Order by creation date

    // Apply search filter
    if (request()->has('search') && !empty(request()->get('search'))) {
        $qrCodesQuery->where('code', 'like', '%' . request()->get('search') . '%');
    }

    // Apply date range filters
    if (request()->has('from') && !empty(request()->get('from'))) {
        $qrCodesQuery->whereDate('expiration_date', '>=', request()->get('from'));
    }
    if (request()->has('to') && !empty(request()->get('to'))) {
        $qrCodesQuery->whereDate('expiration_date', '<=', request()->get('to'));
    }

    // Apply status filter
    if (request()->has('status') && !empty(request()->get('status'))) {
        $status = request()->get('status') === 'active' ? false : true;
        $qrCodesQuery->where('is_used', $status);
    }

    // Apply sorting
    if (request()->has('sort') && !empty(request()->get('sort'))) {
        switch (request()->get('sort')) {
            case 'expiration_date_asc':
                $qrCodesQuery->orderBy('expiration_date', 'asc');
                break;
            case 'expiration_date_desc':
                $qrCodesQuery->orderBy('expiration_date', 'desc');
                break;
            case 'created_at_asc':
                $qrCodesQuery->orderBy('created_at', 'asc');
                break;
            case 'created_at_desc':
                $qrCodesQuery->orderBy('created_at', 'desc');
                break;
            default:
                $qrCodesQuery->orderBy('created_at', 'desc');
                break;
        }
    } else {
        $qrCodesQuery->orderBy('created_at', 'desc');
    }

    // Eager load Bundle and Category relationships
    $qrCodes = $qrCodesQuery->with(['bundle', 'category', 'used_in_course'])->get();

    // Process each QR code for additional data (fetch user name and remove webinar data)
    $qrCodes->each(function ($qrCode) {
        // Get the current locale
        $locale = app()->getLocale();

        // Log the locale
        \Log::info('Fetching user details', ['locale' => $locale]);

        // Fetch user details from user_id
        if ($qrCode->user_id) {
            $user = User::find($qrCode->user_id);
            if ($user) {
                // Set the user's full name
                $qrCode->user_full_name = $user->full_name;
              $qrCode->user_url = $user->getProfileUrl();
            }
        }

        // Remove webinar data processing
        $qrCode->webinar_names = [];  // Ensuring no webinar data is returned

        // Generate the QR code image (base64)
        $qrCodeData = QrCodeFacade::format('png')->size(150)->generate($qrCode->code);
        $qrCode->qr_image = base64_encode($qrCodeData); // Renamed variable
    });

    // Paginate results manually after processing (optional)
    $perPage = 10;
    $currentPage = request()->get('page', 1);
    $paginatedQrCodes = new \Illuminate\Pagination\LengthAwarePaginator(
        $qrCodes->slice(($currentPage - 1) * $perPage, $perPage)->values(),
        $qrCodes->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    \Log::info('QR codes fetched for batch group', ['batch_name' => $batchName, 'count' => $paginatedQrCodes->total()]);

    // Pass data to the view
    $data = [
        'pageTitle' => trans('admin/main.qr_codes_in_group_title', ['batch_name' => $batchName]),
        'qrCodes' => $paginatedQrCodes,
        'batchName' => $batchName,
    ];

    return view('admin.financial.qrcodes.qrcodes', $data);
}



    public function exportQrCodeGroups(Request $request)
    {
        $groups = QrCode::select('batch_name')->distinct()->orderBy('batch_name')->get();
        $export = new QrCodeGroupsExport($groups);
        return Excel::download($export, 'qrcode_groups.xlsx');
    }

    public function exportQrCodes(Request $request, $batchName)
    {
        $qrCodesQuery = QrCode::where('batch_name', $batchName)->with('user')->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $qrCodesQuery->where('code', 'like', '%' . $request->get('search') . '%');
        }
        if ($request->has('from')) {
            $qrCodesQuery->whereDate('created_at', '>=', $request->get('from'));
        }
        if ($request->has('to')) {
            $qrCodesQuery->whereDate('created_at', '<=', $request->get('to'));
        }
        if ($request->has('status')) {
            $status = $request->get('status') === 'active' ? false : true;
            $qrCodesQuery->where('is_used', $status);
        }

        $qrCodes = $qrCodesQuery->get();
        $export = new QrCodesExport($qrCodes);

        return Excel::download($export, 'qrcodes.xlsx');
    }

public function store(Request $request)
{
    // Log the request data for debugging
    \Log::info('Request Data:', $request->all());

    // Retrieve input data from the request
    $bulkQuantity = $request->input('quantity', 1);
    $codeCase = $request->input('code_case', []); // Ensure it's an array
    $codeLength = $request->input('code_length', 8); // Default length
    $amount = $request->input('amount'); // Optional
    $creator = auth()->user()->id; // Logged-in user ID
    $batchName = $request->input('batch_name');

    // Retrieve type and corresponding ID
    $type = $request->input('type'); // 'categories', 'bundles', or 'webinars'
    $categoryId = $type === 'categories' ? $request->input('category_id') : null;
    $bundleId = $type === 'bundles' ? $request->input('bundle_id') : null;
    $webinarId = $type === 'webinars' ? $request->input('webinar_id') : null;

    // Ensure expiration handling
    $expirationDate = $request->input('expiration_date'); // Format 'YYYY-MM-DD'
    $expirationPeriod = $request->input('expiration_period'); // Pre-calculated in days

    for ($i = 0; $i < $bulkQuantity; $i++) {
        // Generate QR code value
        $qrCodeValue = $this->generateQrCodeValue($codeCase, $codeLength);

        // Ensure the QR code value is unique
        while (QrCode::where('code', $qrCodeValue)->exists()) {
            $qrCodeValue = $this->generateQrCodeValue($codeCase, $codeLength);
        }

        // Create the QR code entry
        QrCode::create([
            'code' => $qrCodeValue,
            'is_used' => false,
            'creator' => $creator,
            'batch_name' => $batchName,
            'category_id' => $categoryId, // Save category ID if applicable
            'bundle_id' => $bundleId,     // Save bundle ID if applicable
            'webinar_ids' => $webinarId,   // Save webinar ID if applicable
            'expiration_date' => $expirationDate, // Expiration date
            'expiration_period' => $expirationPeriod, // Expiration period in days
            'created_at' => now(),
        ]);
    }

    return redirect(getAdminPanelUrl() . '/financial/qrcodes')
        ->with('success', trans('admin/main.qrcodes_created_success'));
}


    protected function generateQrCodeValue(array $codeCase, int $codeLength): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $qrCodeValue = '';

        for ($i = 0; $i < $codeLength; $i++) {
            $qrCodeValue .= $chars[random_int(0, strlen($chars) - 1)];
        }

        if (in_array('uppercase', $codeCase)) {
            $qrCodeValue = strtoupper($qrCodeValue);
        } elseif (in_array('lowercase', $codeCase)) {
            $qrCodeValue = strtolower($qrCodeValue);
        } elseif (in_array('mixed', $codeCase)) {
            $qrCodeValue = $this->mixCase($qrCodeValue);
        }

        return $qrCodeValue;
    }

    protected function mixCase(string $code): string
    {
        $result = '';
        foreach (str_split($code) as $char) {
            $result .= random_int(0, 1) ? strtoupper($char) : strtolower($char);
        }
        return $result;
    }

    public function redeemQrCode(Request $request)
    {
        $qrCode = QrCode::where('code', $request->input('code'))->first();

        if ($qrCode && !$qrCode->is_used) {
            $qrCode->update(['is_used' => true]);
            return response()->json(['message' => 'QR code redeemed successfully']);
        }

        return response()->json(['message' => 'Invalid or already used QR code'], 400);
    }

    public function destroy($id)
    {
        QrCode::find($id)->delete();
        return redirect()->route('admin.qrcodes.index');
    }
}
