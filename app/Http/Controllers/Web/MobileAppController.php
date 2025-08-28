<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileAppController extends Controller
{
    public function index()
    {
        /*if (empty(getFeaturesSettings('mobile_app_status')) or !getFeaturesSettings('mobile_app_status')) {
            return redirect('/');
        }*/


        $data = [
            'pageTitle' => trans('update.download_mobile_app_and_enjoy'),
            'pageRobot' => getPageRobotNoIndex()
        ];

        return view('web.default.mobile_app.index', $data);
    }
  public function downloadFile($iconPath)
{
    // Sanitize the input to prevent path traversal attacks
    $iconPath = basename($iconPath);

    // Define the full path to the icon directory
    $iconFullPath = public_path('path/to/icons/' . $iconPath);

    // Check if the file exists
    if (file_exists($iconFullPath)) {
        $extension = pathinfo($iconFullPath, PATHINFO_EXTENSION);
        $fileName = pathinfo($iconPath, PATHINFO_FILENAME) . '.' . $extension;

        $headers = [
            'Content-Type' => mime_content_type($iconFullPath),
        ];

        // Serve the file for download
        return response()->download($iconFullPath, $fileName, $headers);
    }

    // If the file does not exist, return an error
    return back()->with('error', 'Icon not found.');
}

}
