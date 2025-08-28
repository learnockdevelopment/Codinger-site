<?php

namespace App\Models;

use App\Mixins\Notifications\SendSMS;
use App\Notifications\SendVerificationEmailCode;
use App\Notifications\SendVerificationSMSCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class Verification extends Model
{
    use Notifiable;

    protected $table = 'verifications';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    protected $sendOtpSms;

    const EXPIRE_TIME = 3600; // second => 1 hour

    public function __construct()
    {
        parent::__construct();

        // Assuming $this->mobile and $this->code are available in the context
        $this->sendOtpSms = new SendSMS($this->mobile, $this->code);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sendEmailCode()
    {
        $this->notify(new SendVerificationEmailCode($this));
    }

    public function sendSMSCode()
    {
        // Log the data being sent for SMS
        Log::info('Sending SMS verification code', [
            'verification_data' => $this->toArray(), // Log the verification data
            'user' => $this->user,                    // Log user info if needed
        ]);

        // Send OTP SMS code
        $this->sendOtpSms->sendBySmsMisrOtp($this->code, $this->mobile); // Pass the verification code to the SMS function

        // Send the SMS notification
        $this->notify(new SendVerificationSMSCode($this));
    }
}
