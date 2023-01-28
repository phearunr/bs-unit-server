<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Post;
use App\Category;
use App\Jobs\ProccessPostNotification;
use App\Http\Requests\StorePost;
use App\Notifications\AnnouncementPublished;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::query();  
        $posts = $posts->with(['author']);       

        if ( $request->query('term') ) {
            $term = $request->query('term');
            $posts = $posts->where('title' , 'LIKE', '%'.$term.'%');
        }

        $posts = $posts->paginate($request->per_page ?? 10);
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $statuses = Post::getStatuses();
        $types = Post::getTypes();
        return view('admin.post.new', compact('categories','statuses', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {      
        $auth_user = Auth::user();
        $post = New Post();

        $validatedData = $request->validated();
        // Date Convert
        $validatedData = $this->covertToStandardDateFormat($validatedData, $post->getDates());
        $validatedData['published_at'] = $validatedData['published_at'].' '.$validatedData['publish_time'];  
        $validatedData['featured_image_url'] = $this->uploadFeaturedImage($request, 'featured_image_url', 'post_featured_image');
        $validatedData['thumbnail_image_url'] = $this->uploadFeaturedImage($request, 'thumbnail_image_url', 'post_thumbnail_image');

        try {
            DB::beginTransaction();     
            $post->fill($validatedData);
            $post = $auth_user->posts()->save($post);
            $post->categories()->attach($validatedData['category']);            
            DB::commit();    
            return redirect()->route('admin.posts.edit', ['id' => $post->id])
                             ->with('status', __("Post has been created successfully."));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([ 'post' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $categories = Category::all();
        $statuses = Post::getStatuses();
        $types = Post::getTypes();

        $post_category_array = $post->categories->pluck('id')->toArray();

        return view('admin.post.edit', compact('post','categories','statuses','types','post_category_array'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePost  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $auth_user = Auth::user();
        $post = Post::findOrFail($id);

        $validatedData = $request->validated();
        // Date Convert
        $validatedData = $this->covertToStandardDateFormat($validatedData, $post->getDates());
        $validatedData['published_at'] = $validatedData['published_at'].' '.$validatedData['publish_time'];  

        try {                       
            $post->fill($validatedData);
            $post->author()->associate($auth_user);

            if ( $request->hasFile('featured_image_url') ) {
                $post->deleteFeaturedImage();
                $post->featured_image_url = $this->uploadFeaturedImage($request, 'featured_image_url', 'post_featured_image');
            }

             if ( $request->hasFile('thumbnail_image_url') ) {
                $post->deleteThumbnailImage();
                $post->thumbnail_image_url = $this->uploadFeaturedImage($request, 'thumbnail_image_url', 'post_thumbnail_image');
            }

            $post->save();
            $post->categories()->sync($validatedData['category']);

            return redirect()->route('admin.posts.edit', ['id' => $post->id])
                             ->with('status', __("Post has been updated successfully."));            
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'post' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function uploadFeaturedImage($request, $input_file_name, $path = '') 
    {
        try {            
            if ( $request->hasFile($input_file_name) ) {
                list($width, $height, $type, $attr) = getimagesize($request->{$input_file_name}->path());
                return $request->file($input_file_name)->storeAs(
                    $path,
                    $width.'x'.$height.'_'.$request->{$input_file_name}->hashName(), 
                    "public"
                );
            }
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
