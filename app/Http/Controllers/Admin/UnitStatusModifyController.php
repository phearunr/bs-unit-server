<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\UnitBulkModifyStatus;
use App\Http\Controllers\Controller;

class UnitStatusModifyController extends Controller
{
	public function showForm(Request $request) 
	{
		return view('admin.unit.status_modify');
	}

	public function modifyStatus(Request $request) 
	{
		$validatedData = $request->validate([
			'action' => 'required',
			'action_status' => 'required'
		]);

		if ( !$request->hasFile('unit_list') ) {
			return back()->withErrors([ 'unit' => "Please select you CSV file and make you it is in the correct format."]);
		}       
		try {     
			$path = $request->file('unit_list')->store("temp","public");

			Excel::import(
				new UnitBulkModifyStatus($validatedData['action'], $validatedData['action_status']),
				$path,
				"public",
				\Maatwebsite\Excel\Excel::CSV
			);
			return redirect()->route('admin.units.index')
			->with('status', "Units data has been successfully imported.");
		} catch (\Exception $e) {
			return back()->withErrors([ 'unit' => $e->getMessage()]);
		}


		return $request->all();
	}
}
