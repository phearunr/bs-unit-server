<?php

namespace App\Http\Controllers\Api;

use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
	public function index(Request $request)
	{
		return new RoleCollection( Role::paginate() );
	}
}
