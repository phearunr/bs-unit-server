<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RemoveUnusedPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	$permission_to_delete = [
       		'view-contract-request',
       		'create-contract-request',
       		'update-contract-request',
       		'delete-contract-request',
       		'approve-contract-request'
       	];

       	foreach( $permission_to_delete as $permission ) {
       		$permission = Permission::where('name', $permission)->first();
       		if ( $permission ) {
       			$permission->delete();
       		}
       	}
    }
}
