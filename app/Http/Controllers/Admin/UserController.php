<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Project;
use App\Helpers\UserRole;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserInformationRequest;
use App\Http\Requests\UpdateUserAccountSettingRequest;
use App\Http\Requests\UpdateUserRoleAndPermissionRequest;
use App\Traits\UserActiveStatusNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
	use UserActiveStatusNotification;

	protected $validationRules =  [
		'name' 				=> 'required|string|min:6|max:191', 
		'phone_number'  	=> "required|regex:^0\d{8,9}^|unique:users,phone_number",
		'email' 			=> "nullable|email|unique:users,email",
		'gender' 			=> 'in:Male,Female',
		'birthdate' 	    => 'date',                  
		'managed_by'        => "integer|min:0",
		'avatar'			=> 'nullable|mimes:jpg,jpeg,png|dimensions:min_width=256,min_height=256,max_width=1028,max_height=1028',
		'identification_id' => 'exists:user_identifications,id',
		'password'			=> 'required|string|min:6|confirmed|',
								
	];

	public function index(Request $request)   
	{
		$roles = Role::get(['id','name']);
		$users = User::query();
		$users = $users->with(['roles']);

		if ( $request->query('term') ) {
			$term = $request->query('term');
			$users = $users->where('name' , 'LIKE', '%'.$term.'%');
			$users = $users->orWhere('email' , 'LIKE', '%'.$term.'%');
			$users = $users->orWhere('phone_number' , 'LIKE', '%'.$term.'%');
		}

		if ( $request->query("role") AND $request->query("role") != "" ) {
			$users = $users->role($request->query("role"));
		}

		if ( $request->query('verified') ) {
			$is_verified = strcasecmp($request->query('verified'), 'true') == 0 ? true : false;
			$users = $users->ofVerified($is_verified);
		}

		if ( $request->query('active') ) {
			$is_active = strcasecmp($request->query('active'), 'true') == 0 ? true : false;
			$users = $users->ofActive($is_active);
		}

		if ( auth()->user()->hasRole(UserRole::SALE_MANAGER) ) {
			$users = $users->role([UserRole::SALE_TEAM_LEADER, UserRole::AGENT]);
		}

		$users = $users->paginate(10);

		return view('admin.user.index', compact('users','roles'));
	}

	public function edit(Request $request, $id)
	{
		$user = User::with(['roles', 'manageProjects', 'manageZones'])->findOrFail($id);		
		$roles = Role::all();
		$projects = Project::with(['zones'])->get();
		return view('admin.user.edit', compact('user','roles','projects'));
	}

	public function create()
	{
		$roles = Role::all();
		$users = User::all();
		$projects = Project::with(['zones'])->get();
		return view('admin.user.new',compact('roles', 'users', 'projects'));
	}

	public function show(Request $request, $id) 
	{
		// It is used on Contract Page.
		if ($request->ajax()) {
			return $this->getUserAjaxResposne($id);
		}

		$user = User::query();		
		$auth_role = auth()->user()->roles()->first();
	
		switch ($auth_role->name) {
			case UserRole::ADMINISTRATOR:
				$user = User::findOrFail($id);				
				break;
			case UserRole::SALE_MANAGER:
				$user = User::role([UserRole::AGENT, UserRole::SALE_TEAM_LEADER])
						->where('id', $id)
						->firstOrFail();
				break;
			default:
				return abort(404);
				break;
		}

		return view('admin.user.single', compact('user'));
	}

	public function store(StoreUserRequest $request)
	{	
		try {			
			$user = New User();
			$user->fill($this->covertToStandardDateFormat($request->validated(), $user->getDates()));
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
			$user->assignRole($request->role);
			if ( $user->hasRole(UserRole::HANDOVER_OFFICER) ) {
				$user->manageProjects()->sync($request->projects ?? []);
			}

			if ( $user->hasRole(UserRole::SITE_MANAGER) ) {
				$user->manageProjects()->sync($request->projects ?? []);
			}

			if ( $user->hasRole(UserRole::SITE_ENGINEER) ) {
				$user->manageZones()->sync($request->zones ?? []);
			}

			DB::commit();

			return redirect()
					->route('admin.user.edit', ['id' => $user->id])
					->with('status', "User has been created successfully.");
		
		} catch (\Exception $e) {
			DB::rollBack();
			return back()->withInput()->withErrors([ 'user' => $e->getMessage()]);
		}
	}

	public function update(Request $request, $id)
	{
		$user = User::findOrFail($id);
		$role = Role::findOrFail($request->role);
		$phone_number_changed = false;

		$validation_rule = $this->getValidationRules();
		$validation_rule['phone_number'] = "required|regex:/0[0-9]{8,9}/|between:9,10|unique:users,phone_number,".$user->id;
		$validation_rule['email'] = "nullable|email|unique:users,email,".$user->id;

		if ( strcmp( $request->phone_number, $user->phone_number ) != 0 ) {
			$phone_number_changed = true;
		}

		$validatedData = $erquest->validate($validation_rule);

		try {
			$user->fill($request->all());			
			$user->active = $request->active ? 1 : 0;
			$user->verified = $request->verified ? 1 : 0;

			if ( $user->isDirty('active') ) {			
				$this->sendUserActiveStatusNotification($user);
			}

			$user->save();
			if ( $phone_number_changed ) {
				$user->tokens()->delete();
			}

			if ( !$user->hasRole($role) ){
				$user->tokens()->delete();
				$user->syncRoles($role);
			}
		} catch (\Exception $e) {
			return back()->withInput()->withErrors(['user' => $e->getMessage()]);
		}
		return back()->with('status', 'User has been updated successfully');
	}

	public function updatePersonalInformation(UpdateUserInformationRequest $request, $id)
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
					->route('admin.user.edit', ['id' => $user->id])
					->with('user_profile_information_status', "User Personal Information has been updated successfully.");
	}

	public function updateSignatureImage(Request $request, $id)
	{		
		$user = User::findOrFail($id);		
		$user->approvable = $request->approvable ? true : false;

		if ($user->approvable 
			&& $user->signature_image == null 
			&& ($request->hasFile('signature_image') == false)
		) {
			return back()
					->withInput()
					->with(['#SignatureSection'])
					->withErrors(['user_signature_setting' => "User's signature is required when Approvable is checked"]);
		}

		if ($request->hasFile('signature_image')) {
			$path = $request->file('signature_image')->store("user_signatures","public");
			$user->deleteSignaturePhoto();
			$user->signature_image = $path;
		}

		$user->save();

		return redirect()
				->route('admin.user.edit', ['id' => $user->id ,'#SignatureSection'])
				->with("SignatureSection", " The signature image and approval field is required.");	
	}

	public function updateAccountSetting(UpdateUserAccountSettingRequest $request, $id) 
	{		
		$user = User::findOrFail($id);

		( $request->active ) ? $user->activate($request->user()->id) : $user->deactivate($request->user()->id);
		( $request->verified ) ? $user->verified($request->user()->id) : $user->unverified($request->user()->id);

		$user->save();

		return redirect()
					->route('admin.user.edit', ['id' => $user->id, '#AccountSettingSection'])
					->with('user_account_setting_status', "User Account Setting has been updated successfully."); 

	}

	public function updateRoleAndPermission(UpdateUserRoleAndPermissionRequest $request, $id)
	{
		$user = User::findOrFail($id);
		try {
			DB::beginTransaction();

			if ( $request->role ) {			
				if ( !$user->hasRole($request->role) ){
					$user->tokens()->delete();
					$user->manageProjects()->detach();
					$user->manageZones()->detach();
					$user->syncRoles($request->role);
				}
			}

			if ( $user->hasRole([UserRole::AGENT, UserRole::SITE_ENGINEER]) ) {
				$user->managed_by = $request->managed_by ?? null;
				$user->save();
			}
			if ( $user->hasRole(UserRole::HANDOVER_OFFICER) ) {
				$user->manageProjects()->sync($request->projects ?? []);
			}

			if ( $user->hasRole(UserRole::SITE_MANAGER) ) {
				$user->manageProjects()->sync($request->projects ?? []);
			}

			if ( $user->hasRole(UserRole::SITE_ENGINEER) ) {
				$user->manageZones()->sync($request->zones ?? []);
			}

			DB::commit();

			return redirect()
						->route('admin.user.edit', ['id' => $user->id, '#RoleAndPermissionSection'])
						->with('role_and_permission', "User's role and permission has been updated successfully."); 

		} catch (\Exception $e) {
			DB::rollBack();
			return back()
					->withInput()
					->with(['#RoleAndPermissionSection'])
					->withErrors(['user_role_and_permission_setting' => $e->getMessage()]);
		}
	}

	public function showPasswordForm($id){
		$user = User::findOrFail($id);
		return view('admin.user.password_reset', compact('user'));
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

	public function getValidationRules(){
		return $this->validationRules;
	}

	public function getAgents(Request $request) 
	{		
		$agents = User::role([UserRole::AGENT,UserRole::SALE_TEAM_LEADER])->with(['manager']);
		if ( $request->ajax() ) {
			if ( $request->query('term') ) {
	            $term = $request->query('term');
	            $agents = $agents->where('name' , 'LIKE', '%'.$term.'%');      
	        }		
			return response()->json( $agents->simplePaginate() );
		}
		return $agents->get();
	}

	private function assignProjectsToUser(User $user, $projects = []) {
		foreach($projects as $project) {
			$project = Project::find($project);
			$user->manageProjects()->attach($project);
		}
	}
	private function getUserAjaxResposne($id) {
		return response()
            ->json(User::findOrFail($id));
	}
}

  