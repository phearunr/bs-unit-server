<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
	protected $guards = ['web', 'admin', 'api'];

    public function index(Request $request)
    {
    	$roles = Role::withCount('users')->paginate(15);
    	return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $guards = $this->getGuards();
        return view('admin.role.new', compact('guards'));
    }

    public function store(Request $request)
    {
        try {
            $role = Role::create($request->only(['name','guard_name']));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['role', $e->getMessage()]);
        }

        return redirect()->route('admin.role.all')->with('status',"Role has been created successfully.");
    }
    
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $guards = $this->getGuards();
        $permissions = Permission::all()
                                 ->groupBy('group')
                                 ->toArray();                                         
        $role_have_permission = $role->permissions->pluck('id')->toArray();

        return view('admin.role.edit', compact('role','guards','permissions','role_have_permission'));
    }
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        try {
            $role->fill( $request->only(['name','guard_name']) );
            $role->save();
            $role->syncPermissions($request->permissions);
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['role', $e->getMessage()]);
        }

        return back()->with('status', 'Role has been updated successfully');
    }

    public function remove($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.remove', compact('role'));
    }

    public function delete($id)
    {
        try {
            Role::destroy($id);
            return redirect()->route('admin.role.all')->with('status', "Role has been deleted successfully.");
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['role', $e->getMessage()]);
        }
    }

    public function getGuards()
    {
        return $this->guards;
    }
}
