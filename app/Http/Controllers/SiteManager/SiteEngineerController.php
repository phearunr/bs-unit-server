<?php

namespace App\Http\Controllers\SiteManager;

use App\User;
use App\Project;
use App\Http\Requests\StoreSiteEngineerRequest;
use App\Http\Requests\UpdateSiteEngineerInformationRequest;
use App\Http\Requests\UpdateSiteEngineerAccountSettingRequest;
use App\Http\Requests\UpdateSiteEngineerManagedZoneRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SiteEngineerController extends Controller
{
    protected $default_role = 'site_engineer';
    
    public function index(Request $request)
    {
        $roles = Role::get(['id','name']);
		$users = User::query()->where('managed_by', $request->user()->id);
		$users = $users->with(['roles']);

		$users = $users->when( $term = $request->query('term'), function ($query, $term){
			return $query->where('name', 'LIKE', "%$term%")
						 ->orWhere('email', 'LIKE', "%$term%")
						 ->orWhere('phone_number', 'LIKE', "%$term%");
		});
		
		if ( $request->query('verified') ) {
			$is_verified = strcasecmp($request->query('verified'), 'true') == 0 ? true : false;
			$users = $users->ofVerified($is_verified);
		}

		if ( $request->query('active') ) {
			$is_active = strcasecmp($request->query('active'), 'true') == 0 ? true : false;
			$users = $users->ofActive($is_active);
		}

		$users = $users->role($this->default_role);

		$users = $users->paginate();

		return view('site_manager.site_engineer.index', compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
		$users = User::all();
        $projects = Auth()->user()->manageProjects->load(['zones']);		
		return view('site_manager.site_engineer.new', compact('users','roles','projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteEngineerRequest $request)
	{	
		try {
			$user = New User();
			$user->fill($this->covertToStandardDateFormat($request->validated(), $user->getDates()));
			$user->forceFill(['managed_by' => $request->user()->id]);
			$user->forceFill(['password' => bcrypt($request->password)]);

			$request->active ? $user->activate($request->user()->id) : $user->deactivate($request->user()->id);
			$request->verified ? $user->verified($request->user()->id) : $user->unverified($request->user()->id);
			
			// Check avatar
            if ( $request->hasFile('avatar') ) {
                $path = $request->file('avatar')->store("user_avatar","public");
                $user->avatar = $path;
			}
			
			DB::beginTransaction();
			
			$user->save();
			$user->assignRole($this->default_role);

			$user->manageZones()->sync($request->zones ?? []);

			DB::commit();

			return redirect()
					->route('site_manager.site_engineers.edit', ['id' => $user->id])
					->with('status', "Site Engineer has been created successfully.");
		} catch (\Exception $e) {
			DB::rollBack();
			return back()->withInput()->withErrors([ 'user' => $e->getMessage()]);
		}
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) 
	{
		$user = User::query();		
		$auth_role = auth()->user()->roles()->first();
	
		return view('site_manager.site_engineer.single', compact('user'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
	{
		$user = User::with(['roles','manageZones'])
					->where('managed_by', $request->user()->id)
					->where('id', $id)
					->firstOrFail();
		
		$projects = Auth::user()->manageProjects->load('zones');
		return view('site_manager.site_engineer.edit', compact('user', 'projects'));
		//return $projects;
	}

	public function updatePersonalInformation(UpdateSiteEngineerInformationRequest $request, $id)
	{
		$validated_data = $request->validated();
		$user = User::findOrFail($id);
		
		$user->fill($validated_data);
		
		if ( $request->hasFile('avatar') ) {
            $path = $request->file('avatar')->store("user_avatar","public");
            $user->deleteOldProfileImage();
            $user->avatar = $path;
		}
		
		$user->save();

		return redirect()
					->route('site_manager.site_engineers.edit', ['id' => $user->id])
					->with('site_engineer_profile_information_status', "Site Engineer Personal Information has been updated successfully.");
    }
    
    public function updateAccountSetting(UpdateSiteEngineerAccountSettingRequest $request, $id) 
	{		
		$user = User::findOrFail($id);

		( $request->active ) ? $user->activate($request->user()->id) : $user->deactivate($request->user()->id);
		( $request->verified ) ? $user->verified($request->user()->id) : $user->unverified($request->user()->id);

		$user->save();

		return redirect()
					->route('site_manager.site_engineers.edit', ['id' => $user->id, '#AccountSettingSection'])
					->with('site_engineer_account_setting_status', "Site Engineer Account Setting has been updated successfully."); 

	}

	public function updateManagedZone(UpdateSiteEngineerManagedZoneRequest $request, $id)
	{
		$user = User::findOrFail($id);

		$user->manageZones()->sync($request->zones ?? []);

		return redirect()
						->route('site_manager.site_engineers.edit', ['id' => $user->id, '#ZoneManagementSection'])
						->with('manage_zone_status', "Zone management has been updated successfully.");
	}

	public function showPasswordForm(Request $request, $id){
		$user = User::where('managed_by', $request->user()->id)
					->where('id', $id)
					->firstOrFail();

		return view('site_manager.site_engineer.password_reset', compact('user'));
	}

	public function resetPassword(Request $request, $id)
	{
		$user = User::findOrFail($id);
	
		$validatedData = $request->validate([
	        'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
	    ]);

	    try {
	    	$user->password = bcrypt($request->password);	    
	    	$user->need_change_password = $request->input('need_change_password') ? 1 : 0;
	    	$user->save();
	    	$user->tokens()->delete();
	    	
	    } catch (\Exception $e) {
	    	return back()->withErrors([ 'password' => $e->getMessage()]);
	    }

		return back()->with('status', "Password has been reset successfully.");
	}

}
