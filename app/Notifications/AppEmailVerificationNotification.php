<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use App\Mail\EmailManager;
use Auth;
use App\User;

class AppEmailVerificationNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $array['view'] = 'emails.app_verification';
        $array['subject'] = translate('Hello User
        Your OTP for the Sadar24 App is '.$notifiable->verification_code.'. Use this to reset your password. The OTP is valid for 10 minutes only. ');
        $array['content'] = translate('Please Note: This is confidential information and Sadar24 customer support never asks for your login credentials or OTP. Do not share it with anyone!');

        return (new MailMessage)
            ->view('emails.app_verification', ['array' => $array])
            ->subject(translate('Email Verification - ').env('APP_NAME'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
