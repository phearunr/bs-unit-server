<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Project;
use App\UnitType;
use App\ContractTemplate;
use App\SaleRepresentative;
use App\Bank;
use App\UnitHandover;
use App\Http\Requests\ProjectRequest;
use App\Helpers\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-project')->only('index');
        $this->middleware('permission:create-project')->only(['create','store']);
        $this->middleware('permission:update-project')->only(['edit','update']);
        $this->middleware('permission:delete-project')->only(['showDeleteForm','showRetoreForm','destroy','restore']);

        $this->middleware(['permission:view-project', 'project_manager'])->only('show');

        $this->middleware(['permission:view-master-plan-project', 'project_manager'])->only([
            'showMasterPlan',
            'showAvailabilityMasterPlan',
            'showConstructionMasterPlan'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $projects = Project::query();
        $companies = Company::all();
        
        $projects = $projects->when( $request->user()->hasRole(UserRole::SITE_MANAGER), function ( $query ) use ($request) {
            return $request->user()->manageProjects();
        });

        $company = $request->company;    
        $proejcts = $projects->when($company, function ($query, $company) {
            return $query->where('company_id', $company);
        });

        $projects = $projects->search($request->query('term'))
                           ->ofStatus($request->query('status') ?? 'all');

        $projects = $projects->paginate($request->query('per_page') ?? 20);
        return view('admin.project.index', compact('projects', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        $sale_representatives = SaleRepresentative::all();
        $banks =  Bank::all();
        return view('admin.project.new', compact("sale_representatives","banks",'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {      
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        try {
            if ( $request->hasFile('logo_url') ) {                                        
                $path = $request->file('logo_url')->store("project_logo","public");
                Image::make('storage/'.$path)->resize(200, 200)->save('storage/'.$path); 
                $data['logo_url'] = $path;
            }

            if ( $request->hasFile('feature_image_url') ) {                                        
                $path = $request->file('feature_image_url')->store("project_feature_image","public");
                $data['feature_image_url'] = $path;
            }

            if ( $request->hasFile('master_plan_url') ) {                                        
                $path = $request->file('master_plan_url')->storeAs("master_plans",md5(time()).'.svg',"public");              
                $data['master_plan_url'] = $path;
            }

            $project = Project::create($data);
            return redirect()->route('admin.projects.edit', ['id' => $project->id])
                             ->with('status', "Project has been created successfully.");
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'project' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
        $project = Project::withCount([
            'units',
            'units AS progress_average' => function ($query) {
                $query->select(DB::raw('AVG(construction_overall_progress) as progress_average'));
            },           
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
            },
            'units as handovered_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'handovered');
                });
            }
        ])
        ->with([ 
            'unitTypes' => function ($query) { 
                $query->withCount('units'); 
            },
            'unitTypes.activeDiscountPromotions',
            'zones' => function ( $query ) {
                $query->withCount('units');
                $query->withCount('managedUsers');
                $query->withCount([ 'units AS progress_average' => function ($query) {
                    $query->select(DB::raw('AVG(construction_overall_progress) as progress_average'));
                }]);
            },
        ])
        ->findOrFail($id);

        return view('admin.project.single', compact('project'));
    }

    /**
     * Display project's masterplan page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMasterPlan($id)
    {
        $project = Project::findOrFail($id);        
        return view('admin.project.master_plan', compact('project'));
    }

    /**
     * Display project's masterplan page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAvailabilityMasterPlan($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.project.availability_masterplan', compact('project'));
    }

    /**
     * Display project's masterplan page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showConstructionMasterPlan($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.project.construction_masterplan', compact('project'));
    }

    public function getUnits(Request $request, $id) 
    {   
        $status = $request->query('status') ?? null;
        $group_by =  $request->query('group_by') ?? null;
        $unit_type_id = $request->unit_type_id ?? null;
        
        $project = Project::findOrFail($id)->load([
            'units' => function ($query) use ($status, $unit_type_id) {
                if ( !is_null($status) ) {
                    $query->whereHas('action', function ($sub_query) use ($status) {
                        $sub_query->where('action', $status);
                    });
                }
                if (!is_null($unit_type_id)) { 
                    $query->where('unit_type_id', $unit_type_id);
                }                
                $query->without(['action.createdBy','unitType','unitType.project'])
                ->select(['units.id', 'unit_type_id', 'unit_action_id', 'code', 'price']);
            },
            'units.action' => function ($query) {
                $query->select(['id', 'action']);
            }
        ]);

        if ( $request->wantsJson() ) {
            return $project->units;
        }
    }

    public function getUnitHandovers(Request $request, $id) 
    {
        $batch_id = $request->query('batch_id') ?? null;
        $project = Project::where('id', $id)->firstOrFail();

        $project = Project::findOrFail($id)->load([
            'units' => function ($query) {        
                $query->without(['action.createdBy','unitType','unitType.project'])
                ->has('unitHandover')
                ->with('unitHandover')
                ->select(['units.id', 'unit_type_id', 'unit_action_id', 'code', 'price']);
            },
            'units.action' => function ($query) {
                $query->select(['id', 'action']);
            }
        ]);

        if ( $request->wantsJson() ) {            
            return $project->units;
        }
        
        return abort(404);
    }

    public function getUnitTypes(Request $request, $id) 
    {
        $unit_types = Project::findOrFail($id)->unitTypes();
        if ( $request->fields ) {
            $fields = explode(',', $request->fields );
         
            $unit_types = $unit_types->select( (is_array($fields) ? $fields : '*' ) );           
        }

        if ( $request->wantsJson() ) {
            return $unit_types->get();
        }
        // return view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $companies = Company::all();
        $project = Project::findOrFail($id);
        $unit_types = UnitType::where('project_id',$id)->withCount(['paymentOptions','contractTemplate'])->get();
        $contract_templates = ContractTemplate::get(['id','name']);
        $sale_representatives = SaleRepresentative::all();
        $banks =  Bank::all();
        return view('admin.project.edit',compact("project","unit_types","contract_templates","sale_representatives","banks",'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);      
        $data = $request->validated();
        $data['user_id'] = Auth::id();     
        try {           
            if ( $request->hasFile('logo_url') ) {
                $project->deleteLogoUrl();
                $path = $request->file('logo_url')->store("project_logo","public");                
                Image::make('storage/'.$path)->resize(200, 200)->save('storage/'.$path);
                $data['logo_url'] = $path;
            }

            if ( $request->hasFile('feature_image_url') ) {
                $project->deleteFeatureImageUrl();
                $path = $request->file('feature_image_url')->store("project_feature_image","public");  
                $data['feature_image_url'] = $path;
            }

            if ( $request->hasFile('master_plan_url') ) {
                $project->deleteMasterPlanUrl();
                $path = $request->file('master_plan_url')->storeAs("master_plans",md5(time()).'.svg',"public");
                $data['master_plan_url'] = $path;
            }

            $project = $project->fill($data);
            $project->save();
            return redirect()->route('admin.projects.edit', ['id' => $project->id])
                             ->with('status', "Project has been updated successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'project' => $e->getMessage()]);
        }
    }

    public function showDeleteForm($id) 
    {
        $project = Project::findOrFail($id);
        return view('admin.project.delete',compact("project"));
    }

    public function showRestoreForm($id) 
    {
        $project = Project::withTrashed()->findOrFail($id);
        return view('admin.project.restore',compact("project"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        try {       
            $project->delete();
            return redirect()->route('admin.projects.index')->with('status', "Project : $project->name has been successfully deleted.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'project' => $e->getMessage()]);
        }       
    }

    public function restore($id) 
    {
        $project = Project::withTrashed()->findOrFail($id);
        try {         
            $project->restore();
            return redirect()->route('admin.projects.index')->with('status', "Project : $project->name has been successfully restored.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'project' => $e->getMessage()]);
        }
    }

    public function deleteMedia(Request $request, $id) {
        $project = Project::withTrashed()->findOrFail($id);

        try {
            $media_type  = $request->media_type ?? "master_plan_url";
            switch ($media_type) {
                case 'master_plan_url':
                    $project->master_plan_url  = null;
                    $project->save();
                    $project->deleteMasterPlanUrl();
                    break;                
                default:
                    return response()->json([ 'message' => __('Incorrect media type!') ], 422);
            }
            return response()->json([ 'message' => __('Media has been removed successfully.') ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([ 'message' => __('Internal Server Errors!') ], 500);
        }
    }
}
