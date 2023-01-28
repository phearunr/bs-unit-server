<?php

namespace App\Http\Controllers\Admin;

use App\AppVersion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AppVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app_versions = AppVersion::query();
        $app_versions =  $app_versions->paginate();
        return view('admin.app_version.index', compact('app_versions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $platforms = AppVersion::getPlatforms();
        return view('admin.app_version.new', compact('platforms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "platform" =>  ['required', Rule::in(AppVersion::getPlatforms())],
            "build" => "required|integer|min:0",
            "version" => "required|string|max:50",           
            "description" => "nullable|string|max:1000",
            "released_at" => "required|date"
        ]);
        try {
            $app_version = New AppVersion();
            $validatedData = $this->covertToStandardDateFormat($request->input(), $app_version->getDates());
            $validatedData['forced_update'] = isset($request->forced_update) ? 1 : 0;
             $validatedData['user_id'] = Auth::id();
            if ( !$request->description ) {
                $validatedData['description']  = "";
            }

            $app_version = $app_version->fill($validatedData);
            $app_version->save();
            return redirect()->route('admin.app_versions.edit', ['id' => $app_version->id])
                             ->with('status', __("Mobile App Version").__(" has been created successfully."));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'app_version' => $e->getMessage()]);
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
        $app_version = AppVersion::findOrFail($id);
        $platforms = AppVersion::getPlatforms();
        return view('admin.app_version.edit', compact('app_version','platforms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $app_version = AppVersion::findOrFail($id);
        $validatedData = $request->validate([
            "platform" =>  ['required', Rule::in(AppVersion::getPlatforms())],
            "build" => "required|integer|min:0",
            "version" => "required|string|max:50",           
            "description" => "nullable|string|max:1000",
            "released_at" => "required|date"
        ]);       
        try {            
            $validatedData = $this->covertToStandardDateFormat($request->input(), $app_version->getDates());
            $validatedData['forced_update'] = isset($request->forced_update) ? 1 : 0;
            $validatedData['user_id'] = Auth::id();
            if ( !$request->description ) {
                $validatedData['description']  = "";
            }
           
            $app_version = $app_version->fill($validatedData);
            $app_version->save();
            return redirect()->route('admin.app_versions.edit', ['id' => $app_version->id])
                             ->with('status', __("Mobile App Version").__(" has been updated successfully."));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'app_version' => $e->getMessage()]);
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

    private function getValidationRules()
    {
        return $this->validationRules;
    }
}
