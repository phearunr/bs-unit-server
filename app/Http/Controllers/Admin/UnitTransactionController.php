<?php

namespace App\Http\Controllers\Admin;

use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitTransactionController extends Controller
{

    public function index(Request $request, $unit_id)
    {
    	$unit = Unit::findOrFail($unit_id);
    	return view('admin.unit.transaction.index', compact('unit'));
    }
}
