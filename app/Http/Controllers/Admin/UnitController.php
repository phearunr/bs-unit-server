<?php

namespace App\Http\Controllers\Admin;

use App\Unit;
use App\Activity;
use App\UnitType;
use App\UnitAction;
use App\Project;
use App\Helpers\UnitStatus;
use App\Exports\UnitsExport;
use App\Exports\UnitSaleReportExport;
use App\Imports\UnitsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UnitTransactionController;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    protected $validationRules =  [
        'unit_type_id' => "required|exists:unit_types,id",   
        "code" => "required|string|max:200",
        "price" => "required|numeric|min:0",
        "street" => "nullable|string|max:200",
        "street_corner" => "nullable|string|max:200",
        "street_size" => "nullable|numeric|min:0",
        "floor" => "nullable|string|max:200",
        "land_size_width" => "nullable|numeric|min:0",
        "land_size_length" => "nullable|numeric|min:0",
        'land_area' => "nullable|required_without_all:land_size_width,land_size_length|numeric|min:0",
        "building_size_width" => "nullable|numeric|min:0",
        "building_size_length" => "nullable|numeric|min:0",
        'building_area' => "nullable|required_without_all:building_size_width,building_size_length|numeric|min:0",     
        'gross_area' => "nullable|numeric|min:0",     
        "living_room" => "nullable|integer|min:0",
        "kitchen" => "nullable|integer|min:0",
        "bedroom" => "nullable|integer|min:0",
        "bathroom" => "nullable|integer|min:0",
        "swimming_pool" => "nullable|integer|min:0",        
        'code_from' => "required_if:is_bulk_create,on|nullable|integer|min:1",
        'code_to' => "required_if:is_bulk_create,on|nullable|integer|gte:code_from",
        'format' => "required_if:is_bulk_create,on|nullable"
    ];

    public function index(Request $request) 
    {
        if ( $request->ajax() ) {
            return $this->getUnitsAjaxResponse($request);
        }

        if ( $request->query('active') ) {           
            if ( $request->query('active') == 'yes' ) {
                $units = Unit::query();
            } elseif  ($request->query('active') == 'no') {                
                $units = Unit::onlyTrashed();
            } else {
                 $units = Unit::withTrashed();
            }
        } else {
            $units = Unit::withTrashed();
        }
      

        $projects = Project::with(['unitTypes'])->get();
        $statuses = \App\Helpers\UnitStatus::getUnitStatuses();

        if ( $request->query('status') ) {
            // $units = $units->ofStatus($request->query('status'));\
            $action = $request->query('status');
            $status_action = "RELEASE";
            $units = $units->whereHas('action', function ($query) use ($action, $status_action) {
                                $query->where('action', $action );
                                // ->where('status_action', $status_action);
            });
        } else {
             $units = $units->ofStatus();
        }

        if ( $request->query('term') ) {
            $term = $request->query('term');
            $units = $units->where('code' , 'LIKE', '%'.$term.'%');      
        }

        if ( $request->query('unit_type') ) {          
            $units = $units->where('unit_type_id' , $request->query('unit_type'));      
        }
        
    	$units = $units->with([
            'action',
            'action.createdBy',
            'unitType',
            'unitType.project'
        ])->paginate(10);

    	return view('admin.unit.index', compact('units','projects','statuses'));
    }

    public function show(Request $request, $id)
    {
        if ( $request->ajax() ) {
            return $this->getUnitAjaxResponse($id, $request);
        }

        return redirect()->action([UnitTransactionController::class, 'index'], ['id'=>$id]);
        
        // $unit = Unit::findOrFail($id);

        // return view('admin.unit.single', compact('unit'));
    }

    public function getUnitByCode(Request $request, $code)
    {
        $unit = Unit::withTrashed();
        $unit = $unit->without(['action','action.createdBy','unitType','unitType.project']);
        $unit = $unit->where('code', $code)                     
                     ->firstOrFail();
        if ( $request->query('embed') ) {         
            $relationships = explode(',', trim($request->query('embed')) );
            $unit->load($relationships);
        }

        if ( $request->wantsJson() ) {
           return response()->json($unit);   
        }
        abort(404);
    }

    public function create()
    {
    	$projects = Project::with(['unitTypes'])->get();
    	return view('admin.unit.new',compact('projects'));
    }

    public function store(Request $request) 
    {
        $validatedData = $request->validate($this->getValidationRules());
        $validatedData["user_id"] = Auth::id();        
        try {
            if ( $request->is_bulk_create ) { 

                if (strlen($request->code_to) > $request->format) {
                    return back()->withInput()->withErrors([ 'unit' => "Bulk Creation : the format digit is less than the length [to] field"]);
                }

                $str_format = str_repeat("0",$request->format);
                DB::beginTransaction();
                for ( $i = $request->code_from; $i <= $request->code_to; $i++ ) {
                    $validatedData['code'] = $request->code.substr($str_format.$i,  $request->format * -1);
                    $unit = Unit::create($validatedData);                           
                }
                DB::commit();
                return redirect()->route('admin.units.index')
                                 ->with('status', "[".($request->code_to - $request->code_from + 1)."] Units has been created successfully.");            
            } 

            DB::beginTransaction();
            $unit = Unit::create($validatedData);
            DB::commit();

            return redirect()->route('admin.units.edit', ['id' => $unit->id])
                             ->with('status', "Unit has been created successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([ 'unit' => $e->getMessage()]);
        }
    }

    public function edit($id) 
    {
        $unit = Unit::withTrashed()->findOrFail($id);
        $unit = $unit->load(['actions','action.actionable','action.actionable.createdBy','action.createdBy']);
        
        $projects = Project::with(['unitTypes'])->get();        
        return view('admin.unit.edit',compact('unit','projects'));
    }

    public function update(Request $request, $id) 
    {      
        $validatedData = $request->validate($this->getValidationRules());
        
        $unit = Unit::withTrashed()->findOrFail($id);

        $validatedData["user_id"] = Auth::id();

        try {           
            $unit = $unit->fill($validatedData);            
            $unit->save();
            return redirect()->route('admin.units.edit', ['id' => $unit->id])
                             ->with('status', "Unit has been updated successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'unit' => $e->getMessage()]);
        }
    }

    public function showImportForm() 
    {        
    	return view("admin.unit.import");
    }

    public function showExportForm() 
    {
        $projects = Project::with('unitTypes')->get();
        return view("admin.unit.export", compact("projects"));
    }

    public function showChangeStatusForm($id)
    {
        $unit = Unit::withTrashed()->findOrFail($id);
        // $statuses = Unit::getStatuses();
        $statuses = UnitStatus::getUnitStatuses();
        return view("admin.unit.status", compact("unit","statuses"));
    }

    public function changeStatus(Request $request, $id) {
        $unit = Unit::withTrashed()->findOrFail($id);
        
        if ( !in_array($request->status, UnitStatus::getUnitStatuses()) ) {   
            return back()->withErrors([ 'unit' => "Invalid Status."]);
        }       
        try {
            $unit_action =  UnitAction::create([
                'user_id' =>  Auth::id(),
                'unit_id' => $unit->id,
                'action' => $request->status,
                'status_action' => "",
                'description' => $request->description,
                'meta_data' => "",
                'actionable_type' => "",
                'actionable_id' => 0
            ]);
            return redirect()->route('admin.units.index')
                             ->with('status', "Unit's status has been modified successfully.");
        } catch (\Exception $e) {
             return back()->withErrors([ 'unit' => $e->getMessage() ]);
        }
    }

    public function updateSaleableStatus(Request $request, $id)
    {
        $request->validate([ "saleable" => "required|boolean" ]);
        $unit =  Unit::withTrashed()->findOrFail($id);
        try {
            $unit->saleable = $request->saleable;
            $unit->save();
            return response()->json([
                'status' => "success",
                'code' => "200",
                'mesasge' => __("Resource has been updated successfully."),
                'data' => $unit
            ], 200); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => "error",
                'code' => $e->getCode(),
                'mesasge' => $e->getMessage()              
            ], 422); 
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $request->validate([ "active" => "required|boolean" ]);
        $unit =  Unit::withTrashed()->findOrFail($id);
        try {            
            $request->active ? $unit->restore() : $unit->delete();         
            return response()->json([
                'status' => "success",
                'code' => "200",
                'mesasge' => __("Resource has been updated successfully."),
                'data' => $unit
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "error",
                'code' => $e->getCode(),
                'mesasge' => $e->getMessage()              
            ], 422);
        }
    }

    public function import(Request $request)
    {
        if ( !$request->hasFile('unit_import') ) {
            return back()->withErrors([ 'unit' => "Please select you CSV file and make you it is in the correct format."]);
        }       
        try {     
            $path = $request->file('unit_import')->store("temp","public");
            Excel::import(new UnitsImport, $path, "public", \Maatwebsite\Excel\Excel::CSV);
            
            return redirect()->route('admin.units.index')
                             ->with('status', "Units data has been successfully imported.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'unit' => $e->getMessage()]);
        }
    }

    public function export(Request $request)
    {           
        if ( $request->selected_type == 'unit_type' ) {
            $unit_type = UnitType::findOrFail($request->selected_id);
            return Excel::download(new UnitsExport($request->selected_type, $request->selected_id), strtolower($unit_type->name).'_units.csv',\Maatwebsite\Excel\Excel::CSV);
        } elseif ( $request->selected_type == 'project' ) {
            $project = Project::findOrFail($request->selected_id);
            return Excel::download(new UnitsExport($request->selected_type, $request->selected_id), strtolower($project->name_en).'_units.csv',\Maatwebsite\Excel\Excel::CSV);
        } else {
            return back()->withErrors(['export_unit' => __("Unknown Type")]);
        }
    }

    public function exportSaleReport()
    {
        return Excel::download(new UnitSaleReportExport(), 'unit_sale_report.csv', \Maatwebsite\Excel\Excel::TSV);
    }

    public function getImportTemplate() 
    {
    	return Excel::download(new UnitsExport, 'units.csv',\Maatwebsite\Excel\Excel::CSV);
    }
  
    protected function getUnitsAjaxResponse(Request $request) 
    {
        $units = Unit::query();
        // excluded autoload relationship
        $units = $units->without(['action.createdBy']);

        if ( $request->query('unit_type') ) {
            $units = $units->where('unit_type_id',$request->query('unit_type'));
        }

        if ( $request->query('term') ) {
            $term = $request->query('term');
            $units = $units->where('code' , 'LIKE', '%'.$term.'%');      
        }

        return response()
            ->json($units->simplePaginate());
    }

    protected function getUnitAjaxResponse($id, Request $request)
    {
        $unit = Unit::withTrashed();
        $unit = $unit->without(['action','action.createdBy','unitType','unitType.project']);
        $unit = $unit->where("id", $id)
                     ->firstOrFail();
        if ( $request->query('embed') ) {         
            $relationships = explode(',', trim($request->query('embed')) );
            $unit->load($relationships);
        }
        return response()->json($unit);
    }

    public function getActions(Request $request, $id) 
    {
        $data = Unit::withTrashed()->findOrFail($id)->actions()->with(['createdBy'])->latest()->paginate();
        return response()->json($data);
    }

    public function getActivities(Request $request, $id)
    {
        $unit = Unit::withTrashed()->findOrFail($id);
        return response()->json(
            $unit->activities()
                 ->with(['user'])
                 ->latest()
                 ->paginate($request->per_page ?? (New Activity)->getPerPage())
        );
    }

    public function getValidationRules(){
        return $this->validationRules;
    }
}
