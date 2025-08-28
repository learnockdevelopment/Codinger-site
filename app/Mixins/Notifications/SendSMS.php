<?php

namespace App\Mixins\Notifications;
use Illuminate\Support\Facades\Log;
use Craftsys\Msg91\Facade\Msg91;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Http;
use Kavenegar;
use Msegat;
use Twilio\Rest\Client;
use Vonage\Laravel\Facade\Vonage;

class SendSMS
{
    protected $to;
    protected $content;
	// Declare the property
    protected $verification;

    const TWILIO = 'twilio';
    const MSEGAT = 'msegat';
    const VONAGE = 'vonage';
    const MSG91 = 'msg91';
    const TWO_FACTOR = '2factor';
    const SMS_MISR = 'smsmisr';  // Add SMS Misr constant

    const allChannels = [
        self::TWILIO,
        self::MSEGAT,
        self::VONAGE,
        self::MSG91,
        self::TWO_FACTOR,
        self::SMS_MISR,  // Include SMS Misr in the list of channels
    ];


    public function __construct($to, $content)
    {
        $this->to = $to;
        $this->content = $content;
      // Initialize the VerificationController instance
        $this->verification = new VerificationController();
    }

    public function send()
    {
        $smsSendingChannel = getSMSChannelsSettings("sms_sending_channel");

        if (!empty($smsSendingChannel)) {
            if ($smsSendingChannel == self::TWILIO) {
                $this->sendByTwilio();
            } else if ($smsSendingChannel == self::MSEGAT) {
                $this->sendByMsegat();
            } else if ($smsSendingChannel == self::VONAGE) {
                $this->sendByVonage();
            } else if ($smsSendingChannel == self::MSG91) {
                $this->sendByMsg91();
            } else if ($smsSendingChannel == self::TWO_FACTOR) {
                $this->sendByTwoFactor();
            } 
        }

        return false;
    }

    private function sendBySmsMisr()
    {
        // Retrieve SMS Misr settings from your database or config
        $settings = getSMSChannelsSettings();
        $smsMisrUrl = !empty($settings['smsmisr_url']) ? $settings['smsmisr_url'] : 'https://smsmisr.com/api/SMS/?';
        $smsMisrApiKey = !empty($settings['smsmisr_api_key']) ? $settings['smsmisr_api_key'] : null;
        $smsMisrUsername = !empty($settings['smsmisr_username']) ? $settings['smsmisr_username'] : null;
        $smsMisrPassword = !empty($settings['smsmisr_password']) ? $settings['smsmisr_password'] : null;
        $smsMisrSender = !empty($settings['smsmisr_sender']) ? $settings['smsmisr_sender'] : null;

        // Validate that all required settings are available
        if (empty($smsMisrUsername) || empty($smsMisrPassword) || empty($smsMisrSender)) {
            Log::error('SMS Misr Configuration Missing', [
                'api_key' => $smsMisrApiKey,
                'username' => $smsMisrUsername,
                'password' => $smsMisrPassword,
                'sender' => $smsMisrSender,
            ]);
        }

        // Prepare the SMS data
        $data = [
            'environment' => 1,  // Use 2 for testing (1 for live)
            'username' => $smsMisrUsername,
            'password' => $smsMisrPassword,
            'sender' => $smsMisrSender,
            'mobile' => $this->to, // Recipient phone number(s)
            'message' => urlencode($this->content), // URL encode the message
            'language' => 3, // 1 for English, 2 for Arabic, 3 for Unicode
        ];
        // Optional: Set delay until (if needed)
        // 'delayUntil' => 'yyyyMMddHHmm' for scheduling

        try {
            // Make the POST request to the SMS Misr API
            $response = \Http::post($smsMisrUrl, $data);

            // Check if the response is successful
            $result = $response->json();

            if (isset($result['code']) && $result['code'] == '1901') {
                // Successfully sent SMS
                Log::info('SMS Sent via SMS Misr', ['to' => $this->to, 'message' => $this->content, 'sms_id' => $result['SMSID']]);
            } else {
                // Handle errors based on the API response code
                $this->handleSmsMisrError($result);
            }
        } catch (\Exception $e) {
            // Log any exceptions that occur during the API request
            Log::error('Exception while sending SMS via SMS Misr', ['error' => $e->getMessage()]);
        }
    }

    private function handleSmsMisrError($response)
    {
        // Log or handle different response codes
        switch ($response['code']) {
            case '1902':
                Log::error('Invalid Request');
                break;
            case '1903':
                Log::error('Invalid Username or Password');
                break;
            case '1904':
                Log::error('Invalid Sender');
                break;
            case '1905':
                Log::error('Invalid Mobile Number');
                break;
            case '1906':
                Log::error('Insufficient Credit');
                break;
            case '1907':
                Log::error('Server Under Updating');
                break;
            case '1908':
                Log::error('Invalid Date & Time Format');
                break;
            case '1909':
                Log::error('Invalid Message');
                break;
            case '1910':
                Log::error('Invalid Language');
                break;
            case '1911':
                Log::error('Text Too Long');
                break;
            case '1912':
                Log::error('Invalid Environment');
                break;
            default:
                Log::error('Unknown Error', ['response' => $response]);
        }
    }
public function sendBySmsMisrOtp($otp, $mobile)
{
    // Retrieve SMS Misr OTP settings from your database or config
    $settings = getSMSChannelsSettings();
    $smsMisrUrl = !empty($settings['smsmisr_url']) ? $settings['smsmisr_url'] : 'https://smsmisr.com/api/OTP/?';
    $smsMisrApiKey = !empty($settings['smsmisr_api_key']) ? $settings['smsmisr_api_key'] : null;
    $smsMisrUsername = !empty($settings['smsmisr_username']) ? $settings['smsmisr_username'] : null;
        $smsMisrPassword = !empty($settings['smsmisr_password']) ? $settings['smsmisr_password'] : null;
        $smsMisrSender = !empty($settings['smsmisr_sender']) ? $settings['smsmisr_sender'] : null;
    $smsMisrTemplate = !empty($settings['smsmisr_template']) ? $settings['smsmisr_template'] : '0f9217c9d760c1c0ed47b8afb5425708da7d98729016a8accfc14f9cc8d1ba83';

    // Validate that all required settings are available
    if (empty($smsMisrApiKey) || empty($smsMisrUsername) || empty($smsMisrPassword) || empty($smsMisrSender) || empty($smsMisrTemplate)) {
        Log::error('SMS Misr OTP Configuration Missing', [
            'api_key' => $smsMisrApiKey,
            'username' => $smsMisrUsername,
            'password' => $smsMisrPassword,
            'sender' => $smsMisrSender,
            'template' => $smsMisrTemplate,
        ]);
    }

    // Prepare the OTP data
    $data = [
        'environment' => 1,  // Use 2 for testing (1 for live)
        'username' => $smsMisrUsername,
        'password' => $smsMisrPassword,
        'sender' => $smsMisrSender,
        'mobile' => $mobile, // Recipient phone number
        'template' => $smsMisrTemplate,
        'otp' => $otp, // OTP code, should be a string max 10 characters
    ];

    try {
        // Make the POST request to the SMS Misr OTP API
        $response = \Http::post($smsMisrUrl, $data);

        // Check if the response is successful
        $result = $response->json();
        Log::info('OTP Sent via SMS Misr OTP API', $result);

        if (isset($result['Code']) && $result['Code'] == '4901') {
            // Successfully sent OTP
            Log::info('OTP Sent via SMS Misr OTP API', ['to' => $this->to, 'otp' => $this->content, 'sms_id' => $result['SMSID']]);
        } else {
            // Handle errors based on the API response code
            $this->handleSmsMisrOtpError($result);
        }
    } catch (\Exception $e) {
        // Log any exceptions that occur during the API request
        Log::error('Exception while sending OTP via SMS Misr OTP API', ['error' => $e->getMessage()]);
    }
}

private function handleSmsMisrOtpError($response)
{
    // Check if the 'code' key exists to avoid undefined index error
    $code = $response['code'] ?? null;

    // Log or handle different response codes
    switch ($code) {
        case '4903':
            Log::error('Invalid Username or Password');
            break;
        case '4904':
            Log::error('Invalid Sender');
            break;
        case '4905':
            Log::error('Invalid Mobile Number');
            break;
        case '4906':
            Log::error('Insufficient Credit');
            break;
        case '4907':
            Log::error('Server Under Updating');
            break;
        case '4908':
            Log::error('Invalid OTP');
            break;
        case '4909':
            Log::error('Invalid Template Token');
            break;
        case '4912':
            Log::error('Invalid Environment');
            break;
        default:
            Log::error('Unknown Error', ['response' => $response]);
    }
}

    /**
     *
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    private function sendByTwilio()
    {
        $settings = getSMSChannelsSettings();

        $account_sid = !empty($settings['twilio_sid']) ? $settings['twilio_sid'] : '';
        $auth_token = !empty($settings['twilio_auth_token']) ? $settings['twilio_auth_token'] : '';
        $twilio_number = !empty($settings['twilio_number']) ? $settings['twilio_number'] : '';

        $twilio = new Client($account_sid, $auth_token);


        $twilio->messages->create($this->to,
            [
                'from' => $twilio_number,
                'body' => $this->content
            ]
        );

    }


    private function sendByKavenegar()
    {
        // https://github.com/KaveNegar/kavenegar-laravel

        $settings = getSMSChannelsSettings();
        $kavenegarUrl = !empty($settings['kavenegar_url']) ? $settings['kavenegar_url'] : null;
        $kavenegarApiKey = !empty($settings['kavenegar_api_key']) ? $settings['kavenegar_api_key'] : null;
        $kavenegarNumber = !empty($settings['kavenegar_number']) ? $settings['kavenegar_number'] : null;

        if (!empty($kavenegarUrl) and !empty($kavenegarApiKey) and !empty($kavenegarNumber)) {
            \config()->set('kavenegar.apikey', $kavenegarApiKey);

            try {
                $result = Kavenegar::Send($kavenegarNumber, $this->to, $this->content);
            } catch (\Exception $e) {
                dd($e);
            }

        }

    }

    private function sendByMsegat()
    {
        // https://github.com/Moemen-Gaballah/laravel-msegat

        $settings = getSMSChannelsSettings();

        $username = !empty($settings['msegat_username']) ? $settings['msegat_username'] : null;
        $user_sender = !empty($settings['msegat_user_sender']) ? $settings['msegat_user_sender'] : null;
        $api_key = !empty($settings['msegat_api_key']) ? $settings['msegat_api_key'] : null;

        if (!empty($username) and !empty($user_sender) and !empty($api_key)) {
            \config()->set('msegat.MSEGAT_USERNAME', $username);
            \config()->set('msegat.MSEGAT_USER_SENDER', $user_sender);
            \config()->set('msegat.MSEGAT_API_KEY', $api_key);


            try {
                $msg = Msegat::sendMessage($this->to, $this->content);

            } catch (\Exception $e) {
                dd($e);
            }

        }

    }

    private function sendByVonage()
    {
        // https://github.com/Vonage/vonage-laravel

        $settings = getSMSChannelsSettings();

        $number = !empty($settings['vonage_number']) ? $settings['vonage_number'] : null;
        $key = !empty($settings['vonage_key']) ? $settings['vonage_key'] : null;
        $secret = !empty($settings['vonage_secret']) ? $settings['vonage_secret'] : null;
        $application_id = !empty($settings['vonage_application_id']) ? $settings['vonage_application_id'] : null;
        $private_key = !empty($settings['vonage_private_key']) ? $settings['vonage_private_key'] : null;

        if (!empty($key) and !empty($secret)) {
            \config()->set('vonage.api_key', $key);
            \config()->set('vonage.api_secret', $secret);
            \config()->set('vonage.private_key', $private_key);
            \config()->set('vonage.application_id', $application_id);

            try {
                $text = new \Vonage\SMS\Message\SMS($this->to, $number, $this->content);
                Vonage::sms()->send($text);
            } catch (\Exception $e) {
                dd($e);
            }

        }

    }

    private function sendByMsg91()
    {
        // https://github.com/craftsys/msg91-laravel

        $settings = getSMSChannelsSettings();

        $key = !empty($settings['msg91_key']) ? $settings['msg91_key'] : null;
        $flowId = !empty($settings['msg91_flow_id']) ? $settings['msg91_flow_id'] : null;

        if (!empty($key) and !empty($flowId)) {
            \config()->set('services.msg91.key', $key);

            try {

                $res = Msg91::sms()
                    ->to($this->to)
                    ->flow($flowId)
                    ->content($this->content)
                    ->send();

                dd($res);
            } catch (\Exception $e) {
                dd($e);
            }

        }

    }

    private function sendByTwoFactor()
    {
        // https://documenter.getpostman.com/view/301893/TWDamFGh#726383fc-97cb-4355-b6c3-4041adbf0ddd

        $settings = getSMSChannelsSettings();

        $api_key = !empty($settings['2factor_api_key']) ? $settings['2factor_api_key'] : null;

        if (!empty($api_key)) {

            try {
                /*$response = Http::post('https://2factor.in/API/R1/', [
                    'module' => 'TRANS_SMS',
                    'apikey' => $api_key,
                    'to' => "{$this->to}",
                    'from' => 'HEADER',
                    'msg' => "{$this->content}",
                ]);*/

                $url = "https://2factor.in/API/V1/{$api_key}/SMS/{$this->to}/{$this->content}/OTP1";

                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])->get($url);


                if ($response->successful()) {

                } else {
                    dd($response,$response->body());
                }
            } catch (\Exception $e) {
                dd($e);
            }

        }

    }

}
