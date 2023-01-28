<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\UnitType;
use App\Project;
use App\ContractTemplate;
use App\PaymentOption;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class UnitTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-unit-type')->only('index');
        $this->middleware('permission:create-unit-type')->only(['create','store']);
        $this->middleware('permission:update-unit-type')->only(['edit','update']);
        $this->middleware('permission:delete-unit-type')->only(['showDeleteForm','showRetoreForm','destroy','restore']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        if ( $request->ajax() ) {
            return $this->getUnitTypesAjaxResponse($request);
        }

        $unit_types = UnitType::query();
        $unit_types = $unit_types->with(['activeDiscountPromotions']);
        $unit_types = $unit_types->withCount(['project','paymentOptions','units']);
        $projects = Project::withTrashed()->get();

        if ( $request->query('status') ) {
            $unit_types = $unit_types->ofStatus($request->query('status'));
        } else {
            $unit_types = $unit_types->ofStatus();
        }

        if ( $request->query('project') ) {
            $unit_types = $unit_types->where('project_id', $request->query('project'));
        }

        if ( $request->query('term') ) {
            $term = $request->query('term');
            $unit_types = $unit_types->where('name' , 'LIKE', '%'.$term.'%');
        }

        $unit_types = $unit_types->paginate(20);
        return view('admin.unit_type.index', compact('unit_types','projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::get(['id','name',"name_en"]);
        $contract_templates = ContractTemplate::get(['id','name']);
        return view('admin.unit_type.new',compact('projects','contract_templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string|max:255",
            "project_id" => "required|exists:projects,id",
            "short_code" => "required|string|max:200",    
            "annual_management_fee" => "nullable|numeric|min:0",
            "contract_transfer_fee" => "nullable|numeric|min:0",
            "management_fee_per_square" => "nullable|numeric|min:0",
            "deadline" => "nullable|integer|min:0",
            "extended_deadline" => "nullable|integer|min:0",
            "title_clause_kh" => "nullable|string",
            "title_clause_en" => "nullable|string",
            "title_clause_zh" => "nullable|string",
            "management_service_kh" => "nullable|string",
            "management_service_en" => "nullable|string",
            "management_service_zh" => "nullable|string",
            'contract_template_id' => "required|exists:contract_templates,id",
            "equipment_text" => "nullable",
            "equipment_text_en" => "nullable",
            "equipment_text_zh" => "nullable",
            "feature_image_url" => "nullable|mimes:jpg,jpeg,png,bmp,gif|dimensions:max_width:1920"
        ]);

        $data = $validatedData;
        $data['is_contractable'] = $request->is_contractable ? true : false;
        $data['user_id'] = Auth::id();

        try {          
            if ( $request->hasFile('payment_option_image') ) {
                $path = $request->file('payment_option_image')->store("payment_option_image","public");  
                $data['payment_option_image_url'] = $path;
            }

            if ( $request->hasFile('feature_image_url') ) {
                $path = $request->file('feature_image_url')->store("unit_type_feature_image","public");
                $data['feature_image_url'] = $path;
            }
            
            $unit_type = UnitType::create($data);
            if ( $request->input('referee')) {
                return back()->with('status',"Unit Type has been successfully created");
            }
            return redirect()->route('admin.unit_types.edit', ['id' => $unit_type->id])
                             ->with('status', "Unit Type has been created successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'unit_type' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ( $request->ajax() ) {
            $unit_type = UnitType::where('id', $id)->first();
            return $unit_type->makeVisible($unit_type->getHidden());
            // return UnitType::findOrFail($id);
        }

        $unit_type = UnitType::find($id);
                     
        $unit_type = UnitType::withCount([
            'units',
            'units as available_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'available');
                });
            },
            'units as unavailable_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'unavailable');
                });
            },
            'units as hold_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'hold');
                });
            },
            'units as deposit_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'deposit');
                });
            },
            'units as contract_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'contract');
                });
            }
        ])->with(['project', 'media'])->findOrFail($id);
 
        return view('admin.unit_type.single', compact('unit_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit_type = UnitType::findOrFail($id);
        $unit_type->load(['media']);        
        $projects = Project::get(["id","name","name_en"]);
        $contract_templates = ContractTemplate::get(["id","name"]);
        return view('admin.unit_type.edit',compact("unit_type","projects","contract_templates"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "name" => "required|string|max:255",
            "project_id" => "required|exists:projects,id",
            "short_code" => "required|string|max:200",
            "annual_management_fee" => "nullable|numeric|min:0",
            "contract_transfer_fee" => "nullable|numeric|min:0",
            "management_fee_per_square" => "nullable|numeric|min:0",
            "deadline" => "nullable|integer|min:0",
            "extended_deadline" => "nullable|integer|min:0",
            "title_clause_kh" => "nullable|string",
            "title_clause_en" => "nullable|string",
            "title_clause_zh" => "nullable|string",
            "management_service_kh" => "nullable|string",
            "management_service_en" => "nullable|string",
            "management_service_zh" => "nullable|string",   
            "contract_template_id" => "required|exists:contract_templates,id",
            "equipment_text" => "nullable|string",
            "equipment_text_en" => "nullable",
            "equipment_text_zh" => "nullable",
            "feature_image_url" => "nullable|mimes:jpg,jpeg,png,bmp,gif|dimensions:max_width:1920"
        ]);

        $unit_type = UnitType::findOrFail($id);        

        $data = $validatedData;
        $data['is_contractable'] = $request->is_contractable ? true : false;
        $data['user_id'] = Auth::id();

        try {
            
            if ( $request->hasFile('payment_option_image') ) {
                $unit_type->deletePaymentOptionImage();
                $path = $request->file('payment_option_image')->store("payment_option_image","public");  
                $data['payment_option_image_url'] = $path;
            }

            if ( $request->hasFile('feature_image_url') ) {
                $unit_type->deleteFeatureImageUrlImage();              
                $path = $request->file('feature_image_url')->store("unit_type_feature_image","public");
                $data['feature_image_url'] = $path;
            }
          
            $unit_type = $unit_type->fill($data);
            $unit_type->save();
            return redirect()->route('admin.unit_types.edit', ['id' => $unit_type->id])
                             ->with('status', "Unit Type has been updated successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'unit_type' => $e->getMessage()]);
        }
    }

    public function showDeleteForm($id) 
    {
        $unit_type = UnitType::findOrFail($id);
        return view('admin.unit_type.delete',compact("unit_type"));
    }

    public function showRestoreForm($id) 
    {
        $unit_type = UnitType::withTrashed()->findOrFail($id);
        return view('admin.unit_type.restore',compact("unit_type"));
    }

    public function showSetSaleableStatusForm($id) 
    {
        $unit_type = UnitType::findOrFail($id);
        return view('admin.unit_type.set_saleable_status',compact("unit_type"));
    }

    public function setSaleableStatus(Request $request, $id) 
    {
        $unit_type = UnitType::findOrFail($id);
        try {       
            Unit::where('unit_type_id', $unit_type->id)
                ->update(["saleable" => $request->saleable]);
            return redirect()->route('admin.unit_types.index')->with('status', "All units in $unit_type->name has been set saleable status successfully.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'unit_type' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit_type = UnitType::findOrFail($id);
        try {           
            $unit_type->delete();
            return redirect()->route('admin.unit_types.index')->with('status', "Unit Type : $unit_type->name has been successfully deleted.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'unit_type' => $e->getMessage()]);
        }
    }

    public function restore($id) 
    {
        $unit_type = UnitType::withTrashed()->findOrFail($id);
        try {           
            $unit_type->restore();
            return redirect()->route('admin.unit_types.index')->with('status', "Unit Type : $unit_type->name has been successfully restored.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'unit_type' => $e->getMessage()]);
        }
    }

    public function getPaymentOption(Request $request, $id)
    {
        if ( $request->ajax() ){
            return PaymentOption::where('unit_type_id', $id)->get();
        }
    }

    public function getClonePaymentOptionForm($id) 
    {
        $unit_type = UnitType::withTrashed()->findOrFail($id);
        $projects = Project::with(['unitTypes'])->get();
        return view('admin.unit_type.clone',compact("unit_type","projects"));
    }

    public function clone(Request $request, $id)
    {
        $parent_unit_type = UnitType::withTrashed()->findOrFail($id);
        $child_unit_type = UnitType::withTrashed()->findOrFail($request->unit_type_id);

        try {
            $child_unit_type->paymentOptions()->delete();
            foreach( $parent_unit_type->paymentOptions AS $payment_option ){
                $child_unit_type->paymentOptions()->create([
                    'user_id' => Auth::id(),            
                    'name' => $payment_option->name,
                    'deposit_amount' => $payment_option->deposit_amount,
                    'loan_duration' =>  $payment_option->loan_duration, 
                    'interest' => $payment_option->interest, 
                    'special_discount' => $payment_option->special_discount,
                    'is_first_payment' => $payment_option->is_first_payment,
                    'is_first_payment' => $payment_option->is_first_payment,
                    'first_payment_duration' => $payment_option->first_payment_duration,
                    'first_payment_percentage' => $payment_option->first_payment_percentage
                ]);
            }
            return redirect()->route('admin.unit_types.index',['project' => $child_unit_type->project->id ])->with('status', "Payment option has been clone successfully"); 
        } catch (\Illuminate\Database\QueryException $e) {           
            return back()->withErrors([ 'unit_type' => "Can not clone due to the existing payment option is related with other records."]);
        } catch (\Exception $e) {
            return back()->withErrors([ 'unit_type' => $e->getMessage()]);
        }        
    }

    protected function getUnitTypesAjaxResponse(Request $request) 
    {
        $unit_types = UnitType::query();
        // excluded autoload relationship
        $unit_types = $unit_types->without(['contractTemplate']);
        $unit_types = $unit_types->with(['project']);
      
        if ( $request->query('term') ) {
            $term = $request->query('term');
            $unit_types = $unit_types->where('name' , 'LIKE', '%'.$term.'%');      
        }

        return response()->json($unit_types->simplePaginate());
    }


    public function addMedia(Request $request, $id) 
    {
        $unit_type = UnitType::findOrFail($id);

        $permit_media_collection = $unit_type->getMediaCollection();

        $validator = Validator::make($request->all(), [
            'media_collection' => [
                'required',
                Rule::in($permit_media_collection)
            ],           
            'media.*' => 'required|mimes:jpg,jpeg,png,bmp,gif|dimensions:min_width=512'
        ],[           
            'media.*.dimensions' => __('Sorry! Image should be at least 512px in width'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $data = null;

        foreach($request->file('media') as $file) {
            $filename = md5(time()).'.'.$file->getClientOriginalExtension();
            $data[] = $unit_type->addMedia($file)
                                ->usingFileName($filename)
                                ->toMediaCollection($request->media_collection);
        }

        return $data;
    }

    public function deleteMedia(Request $request, $id)
    {
        $unit_type = UnitType::findOrFail($id);
        try {
            return $unit_type->deleteMedia($request->media_id);
        } catch (\Exception $e) {
            return response()->json(['message' => __('Internal Server Error!')], 500);
        }       
    }
}
