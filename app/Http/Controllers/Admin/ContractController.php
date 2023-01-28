<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use App\Exports\ContractExports;
use App\Helpers\ContractStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContractController extends Controller
{
    public function index(Request $request)
    {
    	$contracts = Contract::query();
        $statuses = ContractStatus::getStatuses();
        $contracts = $contracts->with([
            'unit' => function ($query) { return $query->without(['action','action.createdBy']); },
            'unit.unitType',
            'unit.unitType.project',
            'createdBy',
            'agent',
            'actionedBy'
        ]);      

    	if ( $request->query('term') ) {   
			$term = $request->query('term');
			$contracts = $contracts->where('customer1_name' , 'LIKE', '%'.$term.'%');     
			$contracts = $contracts->orwhere('customer2_name' , 'LIKE', '%'.$term.'%');
			$contracts = $contracts->orWhere('customer_phone_number' , 'LIKE', '%'.$term.'%');
			$contracts = $contracts->orWhere('customer_phone_number2' , 'LIKE', '%'.$term.'%');
            $contracts = $contracts->orWhereHas('unit' , function ($query) use ($term) {
                $query->where('code', 'LIKE', '%'.$term.'%');
            });
	    }

        if ( $request->query('status') ) {   
            $contracts = $contracts->status($request->query('status'));
        }

        if ( $request->query('deadline') ) {
            $contracts = $contracts->deadline($request->query('deadline'));
        }

        if ( $request->query('from') AND $request->query('to')) {
            $contracts = $contracts->ofCreatedBetweenDate($request->query('from'), $request->query('to'));
        } 

    	$contracts = $contracts->paginate();   
    	return view('admin.contract.index', compact('contracts','statuses'));
    }

    public function export(Request $request) 
    {
        return Excel::download(new ContractExports(), 'contracts.xlsx',\Maatwebsite\Excel\Excel::XLSX);
        // if ( $request->selected_type == 'unit_type' ) {
        //     $unit_type = UnitType::findOrFail($request->selected_id);
        //     return Excel::download(new UnitsExport($request->selected_type, $request->selected_id), strtolower($unit_type->name).'_units.csv',\Maatwebsite\Excel\Excel::CSV);
        // } elseif ( $request->selected_type == 'project' ) {
        //     $project = Project::findOrFail($request->selected_id);
        //     return Excel::download(new UnitsExport($request->selected_type, $request->selected_id), strtolower($project->name_en).'_units.csv',\Maatwebsite\Excel\Excel::CSV);
        // } else {
        //     return back()->withErrors(['export_unit' => __("Unknown Type")]);
        // }
    }
}
