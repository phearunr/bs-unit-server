<?php

namespace App\Notifications;

use App\SmsPasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ResetPasswordSms extends Notification
{
    use Queueable;


    protected $sms_password_reset;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SmsPasswordReset $sms_password_reset)
    {       
        $this->sms_password_reset = $sms_password_reset;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }   

    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage)
                    ->content("Your BS Units verification code is ".$this->sms_password_reset->verification_code.".");
    }
}
