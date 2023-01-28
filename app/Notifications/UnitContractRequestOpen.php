<?php

namespace App\Notifications;

use App\UnitContractRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class UnitContractRequestOpen extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The UnitContractRequest instance.
     *
     * @var unit_contract_request
     */
    public $unit_contract_request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UnitContractRequest  $unit_contract_request)
    {
        $this->unit_contract_request = $unit_contract_request;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->unit_contract_request->id,
            'action' => 'Open',
            'type' => 'unit_contract_request',
            'additional_data' => [
                'unit_code' => $this->unit_contract_request->unitDepositRequest->unit->code,
            ]
        ];
    }

    public function toOneSignal($notifiable)
    {         
        return OneSignalMessage::create()
            ->subject("កុងត្រារួលរាល់")
            ->body("កុងត្រាសម្រាប់អចលនទ្រព្យ ".$this->unit_contract_request->unit->code." ត្រូវបានរៀបចំរួចរាល់។")
            ->icon('ic_logo_gray')
            ->setData('notification_id', $this->id)
            ->setData('id', $this->unit_contract_request->id)
            ->setData('type', "unit_contract_request_open");
    }
}
