<?php

namespace App\Notifications;

use App\UnitDepositRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class UnitDepositRequestPending extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The UnitDepositRequest instance.
     *
     * @var unit_deposit_request
     */
    public $unit_deposit_request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UnitDepositRequest $unit_deposit_request)
    {
        $this->unit_deposit_request = $unit_deposit_request;
        $this->unit_deposit_request->loadMissing(['unit','createdBy']);
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
            'action' => 'Pending',
            'type' => 'unit_deposit_request',
            'additional_data' => [
                'unit_code' => $this->unit_deposit_request->unit->code,
                'user_name' => $this->unit_deposit_request->createdBy->name,
                'user_avatar_url' => $this->unit_deposit_request->createdBy->avatar_url,
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
            ->subject("មានសម្នើរកក់ប្រាក់")
            ->body($this->unit_deposit_request->createdBy->name ."​ បានស្នើរកក់ប្រាក់លើអចលនទ្រព្យ ". $this->unit_deposit_request->unit->code)
            ->icon('ic_logo_gray')
            ->setData('notification_id', $this->id)
            ->setData('id', $this->unit_deposit_request->id)
            ->setData('type', "unit_deposit_request_pending");
    }
}
