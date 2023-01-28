<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::paginate();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        $banner = New Banner();
        $data = $request->validated();
        $data = $this->covertToStandardDateFormat($data, $banner->getDates());

        try {
            // File Upload
            $directory = "banner";
            $path = $request->file('image_url')->store($directory,"public");
            $path_array = explode('/', $path);
            $filename = end($path_array);
            // create image thumbnail
            Image::make('storage/'.$path)->fit(150)->save('storage/'.$directory.'/thumbnail_'.$filename);
            $data['image_url'] = $path;
            $data['user_id'] = $request->user()->id;

            // fill data to model and save to database
            $banner->fill($data);
            $banner->save();
            return redirect()->route('admin.banners.edit', ['id' => $banner->id])
                          ->with('status', __("Banner has been successfully created."));

        }catch (\Intervention\Image\Exception\NotReadableException $e){
            Storage::disk('public')->delete($path);
            return back()->withInput()->withErrors([ 'banner' => $e->getMessage()]);
        }catch (\Exception $e) {          
            return back()->withInput()->withErrors([ 'banner' => $e->getMessage()]);
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
        $banner = Banner::findOrfail($id);

        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = $request->validated();        
        $data['user_id'] = $request->user()->id;        
        $data = $this->covertToStandardDateFormat($data, $banner->getDates());

        if ( $request->file('image_url')) {
            // deletel old image file;
            $banner->deleteImageUrl();

            // store new file
            $directory = 'banner';            
            $path = $request->file('image_url')->store($directory,"public");

            // create image thumbnail
            $path_array = explode('/', $path);
            $filename = end($path_array);            
            Image::make('storage/'.$path)->fit(150)->save('storage/'.$directory.'/thumbnail_'.$filename);
            
            $data['image_url'] = $path;
           
        } 

        try {
            $banner->fill($data);
            $banner->save();
            return redirect()->route('admin.banners.edit', ['id' => $banner->id])
                          ->with('status', __("Banner has been successfully updated."));     
        } catch (\Intervention\Image\Exception\NotReadableException $e){
            Storage::disk('public')->delete($path);
            return back()->withInput()->withErrors([ 'banner' => $e->getMessage()]);
        } catch (\Exception $e) {          
            return back()->withInput()->withErrors([ 'banner' => $e->getMessage()]);
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
        $result = Banner::destroy($id);

        if ( $result == 0 ) {
            return response()->json([
                "message" => __("Invalid object!"),
            ], 404); 
        } else {
            return response()->json([
                "message" => __("Resource has been successfully removed.")
            ], 200);
        }
    }
}
