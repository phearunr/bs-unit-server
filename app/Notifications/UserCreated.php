<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class UserCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The User instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'id' => $this->user->id,
            'action' => 'Created',
            'type' => 'users',
            'additional_data' => [
                'user_name' => $this->user->name,
                'user_id' => $this->user->id,
                'user_avatar_url' => $this->user->avatar_url          
            ]
        ];
       
    }

    // /**
    //  * Get the OneSignal representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return OneSignalMessage
    //  */
    // public function toOneSignal($notifiable)
    // {         
    //     return OneSignalMessage::create()
    //         ->subject("មានភ្នាក់ងារលក់ថ្មី")
    //         ->body("ភ្នាក់ងារលក់ឈ្មោះ ".$this->user->name." បានសូមចុះឈ្មោះធ្វើជាតំណាងលក់របស់ក្រុមអ្នក")
    //         ->icon('ic_logo_gray')
    //         ->setData('id', $this->user->id)
    //         ->setData('type', "user_created");
    // }
}
