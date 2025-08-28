<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log; // Import Log facade

class SendVerificationEmailCode extends Notification
{
    private $notifiable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifiable)
    {
        // Log the creation of the notification
        Log::info('Creating SendVerificationEmailCode notification', [
            'notifiable' => $notifiable
        ]);

        $this->notifiable = $notifiable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        Log::info('Determining delivery channels for notification', [
            'notifiable' => $notifiable
        ]);

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Log::info('Preparing mail for SendVerificationEmailCode notification', [
            'notifiable' => $notifiable
        ]);

        // Fetch general settings
        $generalSettings = getGeneralSettings();
        Log::info('Fetched general settings', ['generalSettings' => $generalSettings]);

        $subject = trans('auth.email_confirmation');
        Log::info('Email subject determined', ['subject' => $subject]);

        $confirm = [
            'title' => $subject . ' ' . trans('auth.in') . ' ' . $generalSettings['site_name'],
            'message' => trans('auth.email_confirmation_template_body', [
                'email' => $notifiable->email,
                'site' => $generalSettings['site_name']
            ]),
            'code' => $notifiable->code
        ];
        Log::info('Confirmation details prepared', $confirm);

        return (new MailMessage)
            ->subject($subject)
            ->from(
                !empty($generalSettings['site_email']) ? $generalSettings['site_email'] : env('MAIL_FROM_ADDRESS'),
                env('MAIL_FROM_NAME')
            )
            ->view('web.default.emails.confirmCode', [
                'confirm' => $confirm,
                'generalSettings' => $generalSettings
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // Log the array representation request
        Log::info('Getting array representation of notification', [
            'notifiable' => $notifiable
        ]);

        return [
            // You may add data to be included in the array representation
        ];
    }
}
