<?php

namespace App\Mixins\Logs;

use App\Models\UserLoginHistory;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;

class UserLoginHistoryMixin
{
    protected $browser;
    protected $deviceType;
    protected $os;
    protected $macAddress;

    public function __construct()
    {
        $agent = new Agent();

        // Retrieve browser and device type
        $this->browser = $agent->browser();
        Log::info('Browser detected', ['browser' => $this->browser]);

        $this->deviceType = $agent->deviceType();
        Log::info('Device type detected', ['device_type' => $this->deviceType]);

        // Retrieve the User-Agent string
        $userAgentString = $agent->getUserAgent();
        Log::info('User-Agent string', ['user_agent' => $userAgentString]);

        // Fetch MAC address from the User-Agent
        $this->macAddress = $this->getMacAddress($userAgentString);
        Log::info('MAC address extracted', ['mac_address' => $this->macAddress]);

        // Get platform and version
        $platform = $agent->platform();
        $version = $agent->version($platform);
        $this->os = "$platform-$version";
        Log::info('Operating system detected', ['os' => $this->os]);
    }

    protected function getMacAddress($userAgent)
    {
        // Look for the position of '(MAC: ' in the User-Agent string
        $start = strpos($userAgent, '(MAC: ');

        // If the '(MAC: ' substring is found
        if ($start !== false) {
            $macSubstring = substr($userAgent, $start);
            $end = strpos($macSubstring, ')');
            if ($end !== false) {
                $macAddress = trim(substr($macSubstring, 6, $end - 6));
                Log::info('MAC address found in User-Agent', ['mac_address' => $macAddress]);
                return $macAddress;
            }
        }

        Log::warning('No MAC address found in User-Agent');
        return null; // Return null if no MAC address is found
    }

    public function storeUserLoginHistory($user, $deviceType = null)
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        Log::info('IP address retrieved', ['ip_address' => $ipAddress]);
		Log::info('Preparing to store user login history', ['user_data' => $deviceType]);

        $country = null;
        $city = null;
        $location = null;

        // Get user location based on IP address
        $locationData = $this->getUserLocation($ipAddress);
        if (!empty($locationData) && !empty($locationData['status']) && $locationData['status'] == "success") {
            $country = $locationData['country'] ?? null;
            $city = $locationData['city'] ?? null;
            $location = (!empty($locationData['lat']) && !empty($locationData['lon'])) ? "{$locationData['lat']},{$locationData['lon']}" : null;

            Log::info('Location data retrieved', [
                'country' => $country,
                'city' => $city,
                'location' => $location,
            ]);
        } else {
            Log::warning('Failed to retrieve location data for IP address', ['ip_address' => $ipAddress]);
            $ipAddress = null; // Reset IP address if location lookup fails
        }

        // Build the User-Agent string
        $userAgent = sprintf(
            '%s (MAC: %s)', 
            $this->browser, 
            $this->macAddress ?? 'N/A'
        );

        Log::info('User-Agent string built', ['user_agent' => $userAgent]);

        $userSession = session()->getId();
        Log::info('User session ID retrieved', ['session_id' => $userSession]);

        // Store the login history
        UserLoginHistory::query()->create([
            'user_id' => $user->id,
            'browser' => $userAgent,
            'device' => $deviceType ?? $this->deviceType,
            'os' => $this->os,
            'ip' => $ipAddress,
            'country' => $country,
            'city' => $city,
            'location' => !empty($location) ? DB::raw("point({$location})") : null,
            'session_id' => $userSession,
            'session_start_at' => time(),
            'session_end_at' => null,
            'created_at' => time(),
        ]);

        Log::info('User login history stored', [
            'user_id' => $user->id,
            'session_id' => $userSession,
            'browser' => $userAgent,
        ]);
    }

    public function storeUserLogoutHistory($userId)
    {
        Log::info('Storing user logout history.', ['user_id' => $userId]);

        $session = UserLoginHistory::query()
            ->where('user_id', $userId)
            ->whereNull('session_end_at')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!empty($session)) {
            Log::info('Found active session for user.', [
                'user_id' => $userId,
                'session_id' => $session->session_id,
                'created_at' => $session->created_at,
            ]);

            $session->update([
                'session_end_at' => time(),
                'end_session_type' => 'default',
            ]);

            Log::info('Updated session with end time and type.', [
                'user_id' => $userId,
                'session_id' => $session->session_id,
                'end_time' => time(),
            ]);

            $sessionManager = app('session');
            $sessionManager->getHandler()->destroy($session->session_id);
            Log::info('Session destroyed.', ['session_id' => $session->session_id]);
        } else {
            Log::warning('No active session found for user.', ['user_id' => $userId]);
        }
    }

    private function getUserLocation($ipAddress)
    {
        Log::info('Fetching user location based on IP address', ['ip_address' => $ipAddress]);

        $response = Http::get("http://ip-api.com/json/{$ipAddress}");
        $locationData = $response->json();

        Log::info('User location data received', ['location_data' => $locationData]);

        return $locationData;
    }
}
