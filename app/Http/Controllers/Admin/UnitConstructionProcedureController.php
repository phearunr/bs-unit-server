<?php

namespace App\Http\Controllers\Admin;

use App\Unit;
use App\Helpers\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitConstructionProcedureController extends Controller
{

	protected $unit = null;

	public function __construct(Request $request)
	{		
		$this->unit = Unit::where('id', $request->id)->first();
	}
	
	public function index(Request $request, $id)
	{
		$unit = $this->unit->load('constructionProcedures');		
		return view('admin.unit.construction.index', compact('unit'));
	}
}
