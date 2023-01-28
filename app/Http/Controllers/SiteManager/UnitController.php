<?php

namespace App\Http\Controllers\SiteManager;

use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function show(Request $request, $id)
    {   

        // $unit = Unit::findOrFail($id);

        $unit = \App\Project::with([ 'units' = ]);
        return view('site_manager.project.unit.single', compact('unit'));
    }
}
