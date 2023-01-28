<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	public function index(Request $request)
	{
		$auth_user = Auth::user();
		$announcements = $this->getAnnouncements($request);

		// get unread_notification_count
		$last_notification_read_at = $auth_user->metadata['last_notification_read_at'] ?? '1990-01-01 00:00:00';
		$unread_notification_count = $auth_user->unreadNotifications()
											   ->where('created_at', '>', $last_notification_read_at)->count();

		if ( $request->has('page') AND $request->page > 1 ) {
			return response()
            		->json(['announcements' => $announcements]);
		} else {
			$banners = $this->getBanners($request);
			return response()
            ->json([
            	'banners' => $banners,
            	'announcements' => $announcements,
            	'unread_notification_count' => $unread_notification_count
            ]);
		}
	}

	private function getBanners(Request $request)
	{
		return Banner::active()
   				  	->orderBy('order')
   				  	->get();
	}

	private function getAnnouncements(Request $request) 
	{
		return Post::published()->whereHas('categories', function ($query) {
			$query->where('slug', 'announcement');
   		})->simplePaginate($request->per_page ?? 10, Post::getCollectionFields());
	}
}