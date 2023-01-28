<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        if ( Cache::get('spatie.permission.cache') ) {
        	Cache::forget('spatie.permission.cache');
        }

      	// getting Roles from permission config file
	    $roles = config( 'permission.available_roles' , null );
	    $permissions = config( 'permission.available_permissions' , null );

	    // Create all permssion from config file
	    if ( !is_null($permissions) ){
	    	foreach( array_keys($permissions) as $permission ){
	        	$permission_name = $permission;
	          	foreach( $permissions[$permission] as $item ){
	            	$name =  $item.'-'.$permission_name;
	            	$permission = Permission::where('name',$name)->first();
	            	if ( $permission ) {
	            		// $permission->group = $permission_name;
	            		// $permission->save();
	            	} else {
	            		Permission::create(['name' => $name, 'group' => $permission_name ]);
	            	}
	          	}
	        }
	    }

	    //Create all Role from config file and assign corresponding permission
		if ( !is_null($roles) ){
			foreach( array_keys($roles) as $role ) {				
				$role_obj = Role::findOrCreate($role);
				foreach( $roles[$role] as $key => $permission_obj_item ) {
					if( is_array($permission_obj_item) ) {
						foreach( $permission_obj_item as $item ) {
							$role_obj->givePermissionTo( $item .'-'.$key );
						}
					} else {
						$permission_array = $permissions[ $permission_obj_item ];
						foreach( $permission_array as $permission ) {						
							$role_obj->givePermissionTo( $permission.'-'.$permission_obj_item );
						}
					}
				}
			}
		}
    }
}
