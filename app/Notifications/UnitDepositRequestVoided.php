<?php

namespace App\Notifications;

use App\UnitDepositRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;


class UnitDepositRequestVoided extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The UnitDepositRequest instance.
     *
     * @var unit_deposit_request
     */
    public $unit_deposit_request;

    /**
     * String.
     *
     * @var user_role
     */
    public $user_role;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UnitDepositRequest $unit_deposit_request, $user_role = "")
    {
        $this->unit_deposit_request = $unit_deposit_request;
        $this->user_role = $user_role;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', OneSignalChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->unit_deposit_request->id,
            'action' => 'Voided',
            'type' => 'unit_deposit_request',
            'additional_data' => [
                'unit_code' => $this->unit_deposit_request->unit->code,
                'role' => $this->user_role
            ]
        ];
    }

    /**
     * Send OneSignal notification
     *
     *
     */
    public function toOneSignal($notifiable)
    {         
        return OneSignalMessage::create()
            ->subject("សម្នើរកក់ប្រាក់ត្រូវបានធ្វើឲ្យមោឃៈ")
            ->body("សម្នើរកក់ប្រាក់លើអចលនទ្រព្យ ".$this->unit_deposit_request->unit->code." ត្រូវបានធ្វើឱ្យមោឃៈ")
            ->icon('ic_logo_gray')
            ->setData('notification_id', $this->id)
            ->setData('id', $this->unit_deposit_request->id)
            ->setData('type', "unit_deposit_request_voided");
    }
}
