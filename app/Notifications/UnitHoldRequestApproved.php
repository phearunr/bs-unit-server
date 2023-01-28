<?php

namespace App\Notifications;

use App\UnitHoldRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class UnitHoldRequestApproved extends Notification implements ShouldQueue
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
            'action' => 'Approved',
            'type' => 'unit_hold_request',
            'additional_data' => [
                'unit_code' => $this->unit_hold_request->unit->code,
                'role' => $this->unit_hold_request->actionedBy->roles->first()->name
            ]
        ];
    }

    public function toOneSignal($notifiable)
    {         
        return OneSignalMessage::create()
            ->subject("សម្នើរព្យួរត្រូវបានអនុម័ត")
            ->body("សម្នើរព្យួរលើអចលនទ្រព្យ ".$this->unit_hold_request->unit->code." ត្រូវបានអនុម័ត")
            ->icon('ic_logo_gray')
            ->setData('notification_id', $this->id)
            ->setData('id', $this->unit_hold_request->id)
            ->setData('type', "unit_hold_request_approved");
    }
}
