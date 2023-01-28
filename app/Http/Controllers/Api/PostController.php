<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Category;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Request $request)
    {
    	$posts = Post::query();

    	if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')));
			$posts = $posts->with($relationships) ; 
		}

		if ( $request->input('categories') ) {
			$categories = explode(',', trim($request->input('categories')));
			$posts = $posts->whereHas('categories', function ($query) use ($categories) {
				$query->whereIn('slug',$categories);
			});
		}
		return new PostCollection($posts->published()->paginate());    	
    }

    public function get(Request $request, $id)
    {
    	$post = Post::findOrFail($id);
        if ( $request->input("embed") ) {           
            $relationships = explode(',', trim($request->input('embed')) );
            $post->load($relationships);
        }

        if ( $request->input("append_fields") ) {           
            $append_field = explode(',', trim($request->input('append_fields')) );
            $post->append($append_field);
        } 
        
        return new PostResource($post);
    }
}
