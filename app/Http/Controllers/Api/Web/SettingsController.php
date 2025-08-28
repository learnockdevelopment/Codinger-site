<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importing the Log facade

class SettingsController extends Controller
{
    public function getGeneralSettings()
    {
        // Log the start of the method
        Log::info('Fetching general and security settings started.');

        // Call the existing function to retrieve general settings
        $generalSettings = getGeneralSettings(); // Assuming this function exists
        Log::info('General settings retrieved.', ['settings' => $generalSettings]);

        // Call the existing function to retrieve security settings
        $securitySettings = getGeneralSecuritySettings(); // Assuming this function exists
        Log::info('Security settings retrieved.', ['settings' => $securitySettings]);

        // Return both settings in the response
        Log::info('Returning settings in the response.');

        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), [
            'general_settings' => $generalSettings,
            'security_settings' => $securitySettings
        ]);
    }
}
