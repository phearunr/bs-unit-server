<?php

namespace App\Http\Controllers\SubConstructor;

use App\User;
use App\Unit;
use App\Contact;
use App\SubConstructor;
use App\SubConstructorSkill;
use App\IdentityDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubConstructorRequest;
use App\Http\Requests\UpdateSubConstructorInformationRequest;

class SubConstructorController extends Controller
{
    public function index(Request $request)
    {  
        $sub_constructors = SubConstructor::query()
        ->with(['contacts', 'skills', 'createdBy'])
        ->withCount(['contacts', 'skills', 'units']);

        $sub_constructors->when( $term = $request->term, function( $query, $term ) { 
            return $query->where('name', 'LIKE', "%$term%");
        });

        $sub_constructors = $sub_constructors->paginate();
        
        return view('sub_constructor.index', compact('sub_constructors'));
    }
    
    public function create()
    {
        $sub_constructors = SubConstructor::all();
        $sub_constructor_skills = SubConstructorSkill::get();

        return view('sub_constructor.new', compact('sub_constructors','sub_constructor_skills'));
    }

    public function store(StoreSubConstructorRequest $request)
    {                
        $validated_data = $request->validated();
        $validated_data["user_id"] = Auth::id(); 
        $contacts = $validated_data['contact'];
        $identity_documents = $validated_data['identity_document'];
        $sub_constructor_skills = $validated_data['sub_constructor_skill'];
    
        // Check avatar
        $file_path = null;
        if ( $request->hasFile('avatar') ) {
            $file_path = $request->file('avatar')->store('sub_constructor_avatar', 'public');
            $validated_data['avatar'] = $file_path;
        }

        try {
            DB::beginTransaction();
            // Create Sub Constructor;
            $sub_constructor = New SubConstructor();
            $sub_constructor->fill($validated_data);
            $sub_constructor->save();

            // Create Contacts
            foreach($contacts as $contact) {
                $sub_constructor->contacts()->create($contact);
            }

            // Create IdentityDocument
            foreach($identity_documents as $key => $data) {
                $data = $this->covertToStandardDateFormat($data, ['issue_date','expiration_date']);
                $identity_document = $sub_constructor->identityDocuments()->create($data);

                if ( isset($data['attachment']) ) {
                    $identity_document->addMedia($data['attachment'])->toMediaCollection();
                }
            }

            //Create SubConstructorSkills
            $sub_constructor->skills()->sync($sub_constructor_skills);

            DB::commit();
        } 
        catch (\Exception $e) {
            DB::rollBack();
            if ( $file_path != null ) { Storage::delete($file_path); }            
            return back()->withInput()->withErrors([ 'sub_constructor' => $e->getMessage()]);
        }

        return redirect()
                ->route('sub_constructors.edit', ['id' => $sub_constructor->id])
                ->with('create_sub_constructor_information', __("Sub Constructor Information has been create successfully."));
    }

    public function edit($id)
    {
        $sub_constructor = SubConstructor::findOrFail($id)->load(['skills','identityDocuments', 'identityDocuments.media']);
        $sub_constructor_skills = SubConstructorSkill::get();

        return view('sub_constructor.edit', compact('sub_constructor', 'sub_constructor_skills'));
       
    }

    public function updatePersonalInformation(UpdateSubConstructorInformationRequest $request, $id)
    {
        $sub_constructor = SubConstructor::findOrFail($id);
        $validated_data = $request->validated();
        $sub_constructor->fill($validated_data);
      

        if ( $request->hasFile('avatar') ) {
            $path = $request->file('avatar')->store("sub_constructor_avatar","public");
            $sub_constructor->deleteOldAvatarImage();
            $sub_constructor->avatar = $path;
        }

        $sub_constructor->save();

        return redirect()
                ->route('sub_constructors.edit', ['id' => $sub_constructor->id])
                ->with('update_sub_constructor_profile_information', __("Sub Constructor Personal Information has been updated successfully."));
    } 

    public function showAddUnitForm(Request $request, $sub_constructor_id) 
    {
        $sub_constructor = SubConstructor::where('id', $sub_constructor_id)
        ->withCount(['contacts', 'skills', 'units'])->firstOrFail();
        
        $units = $sub_constructor->units()->paginate();
        return view('sub_constructor.unit.index', compact('sub_constructor', 'units'));
    }

    public function addUnit(Request $request, $sub_constructor_id) 
    {

        $validated_data["user_id"] = Auth::id();
        $unit = Unit::where('code', $request->unit_code)->first();
        $projects = Auth::user()->manageProjects()->pluck('id')->toArray();

        //check unit code 
        if ( !$unit ) {
           return back()->withInput()->withErrors(['unit' => "Unit code is not exist in the system."]);
        }

        //check unit code under manage or not
        if ( !in_array($unit->unitType->project->id, $projects) ) {
            return back()->withInput()->withErrors(['unit' => "Unit code is not available."]);
        }

        $sub_constructor = SubConstructor::where('id', $sub_constructor_id)->firstOrFail();
        if ( $sub_constructor->units()->where('unit_id', $unit->id)->first() ) {
            return back()->withInput()->withErrors(['unit' => "Unit was already assigned to this Sub Construtor"]);
        }

        try {
            // $sub_constructor->units()->attach($unit);
            $sub_constructor->units()->save($unit,[
                'user_id' => Auth::id(),
            ]);

        return redirect()
                ->route('sub_constructors.units.index', ['sub_constructor_id' => $sub_constructor_id])
                ->with('status', "Unit has been added successfully.");
            
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['unit' => $e->getMessage()]);
        }
    }

    public function removeUnit(Request $request, $sub_constructor_id, $unit_id)
    {
        $sub_constructor = SubConstructor::where('id', $sub_constructor_id)->firstOrFail();
        try {
        
            $sub_constructor->units()->detach($unit_id);

            if ( $request->wantsJson() ) {
                return response()->json([
                    'status' => __('success'), 
                    'message' => "Unit has been removed from Sub Constructor successfully."
                ], 200);
            }
                
        } catch (\Exception $e) {

            if ( $request->wantsJson() ) {
                return response()->json([
                    'status' => __('error'), 
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }

}
