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
use Request;

class EmailLoginNotification extends Notification
{
    use Queueable;

    public $verification ='';
    public function __construct($request)
    {
        $this->verification =$request;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $array['view'] = 'emails.email_login';
        $array['subject'] = translate('Hello User
        Your OTP for the Sadar24 Login is '.$this->verification.'. Use this to Login your account. The OTP is valid for 10 minutes only. ');
        $array['content'] = translate('Please Note: This is confidential information and Sadar24 customer support never asks for your login credentials or OTP. Do not share it with anyone!');

        return (new MailMessage)
            ->view('emails.email_login', ['array' => $array])
            ->subject(translate('Email Login OTP - ').env('APP_NAME'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
