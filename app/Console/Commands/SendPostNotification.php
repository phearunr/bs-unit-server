<?php

namespace App\Console\Commands;

use App\User;
use App\Post;
use App\Helpers\UserRole;
use App\Notifications\PostPublished;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Console\Command;

class SendPostNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:publishpost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notificaiton to users when the post\'s publish date is reached';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = Post::unnotified()->get([
            'id',
            'title',         
            'short_description',
            'status',
            'type',
            'has_notified',
            'published_at',
            'featured_image_url'
        ]);

        $roles_to_be_notified = [
            UserRole::AGENT,
            UserRole::SALE_TEAM_LEADER,
            UserRole::UNIT_CONTROLLER,
            UserRole::SALE_MANAGER
        ];

        foreach( $posts as $post ) {
            $users = User::role($roles_to_be_notified)->get();
            Notification::send($users, new PostPublished($post));
            $post->has_notified = true;
            $post->save();
        }
    }
}

