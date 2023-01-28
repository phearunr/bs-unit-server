<?php

namespace App\Notifications;

use App\UnitHoldRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class UnitHoldRequestCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The UnitHoldRequest instance.
     *
     * @var unit_hold_request
     */
    public $unit_hold_request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UnitHoldRequest $unit_hold_request)
    {
        $this->unit_hold_request = $unit_hold_request;
        $this->unit_hold_request->loadMissing(['unit', 'actionedBy']);
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
            'id' => $this->unit_hold_request->id,
            'action' => 'Cancelled',
            'type' => 'unit_hold_request',
            'additional_data' => [
                'unit_code' => $this->unit_hold_request->unit->code,
                'user_name' => $this->unit_hold_request->actionedBy->name,
                'role' => $this->unit_hold_request->actionedBy->roles->first()->name,
                'user_avatar_url' => $this->unit_hold_request->actionedBy->roles->first()->name == "unit_controller" ? 
                                     null : $this->unit_hold_request->actionedBy->avatar_url
            ]
        ];
    }

    public function toOneSignal($notifiable)
    {         
        return OneSignalMessage::create()
            ->subject("សម្នើរព្យួរត្រូវបានលុបចោល")
            ->body("សម្នើរព្យួរលើអចលនទ្រព្យ ".$this->unit_hold_request->unit->code." ត្រូវបានលុបចោល")
            ->icon('ic_logo_gray')
            ->setData('notification_id', $this->id)
            ->setData('id', $this->unit_hold_request->id)
            ->setData('type', "unit_hold_request_cancelled");
    }
}
