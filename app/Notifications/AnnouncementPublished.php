<?php

namespace App\Notifications;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AnnouncementPublished extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Post instance.
     *
     * @var post
     */
    public $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
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
            //
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->post->id,
            'action' => 'Published',
            'type' => 'post',
            'additional_data' => [
                'post_title' => $this->post->title,              
            ]
        ];
    }

    /**
     * Get the OneSignal representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal($notifiable)
    {                 
        return OneSignalMessage::create()
            ->subject("សេចក្តីប្រកាស")
            ->body($this->post->title)
            ->icon('ic_logo_gray')
            ->setData('notification_id', $this->id)
            ->setData('id', $this->post->id)
            ->setData('type', "post_published");
    }
}
