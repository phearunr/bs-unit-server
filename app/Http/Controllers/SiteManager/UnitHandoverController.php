<?php

namespace App\Http\Controllers\SiteManager;

use Validator;
use App\Unit;
use App\User;
use App\Approval;
use App\Project;
use App\UnitAction;
use App\UnitHandoverRequest;
use App\Helpers\UnitStatus;
use App\Exports\UnitHandoversExport;
use App\Imports\UnitHandoversImport;
use App\Http\Requests\ApprovalRequest;
use App\Http\Requests\StoreUnitHandOverRequest;
use App\Http\Requests\UpdateUnitHandOverRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitHandoverController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $view = $request->view;
        $handovers = null;
        
        switch ($view) {
            case 'all':
                $handovers = UnitHandoverRequest::query();             
                break;
             case 'pending_my_approval':
                $handovers = UnitHandoverRequest::pendingMyApproval();            
                break;
            default:
                $handovers = UnitHandoverRequest::owner();               
                break;
        }

        if ( $request->query('term') ) {
			$term = $request->query('term');
            $handovers = $handovers->where('customer_name' , 'LIKE', '%'.$term.'%');
			$handovers = $handovers->orWhere('status' , 'LIKE', '%'.$term.'%');
            $handovers = $handovers->orWhereHas('unit' , function ($query) use ($term) {
                $query->where('code', 'LIKE', '%'.$term.'%');
            });
           
		}

        $handovers = $handovers->with(['createdBy', 'Unit'])
                               ->orderBy('updated_at', 'desc')
                               ->paginate();

        return view('site_manager.unit_handover.index',compact('handovers','projects'));
    }

    public function create(Request $request,$id) 
    {
        $users = User::where('approvable', true)->get();
        $unit = Unit::findOrFail($id);
        $unit_handover_request = UnitHandoverRequest::where('unit_id', $id)->latest('id')->first();
    
        if ( $unit->action->action != UnitStatus::CONTRACT AND $unit->action->action != 'OPEN' ) {
            // Should display the error message regarding unit's status
            return Redirect::back()->withErrors(["The unit's status is not allowed to create handover request."]);
        }

        if ( $unit_handover_request AND $unit_handover_request->status == 'Draft' ) {
            // Show error 
            return Redirect::back()->withErrors(["The unit handover request for this unit had been created in draft."]);
        }
        
        if ( $unit_handover_request AND $unit_handover_request->status == 'PENDING APPROVE' ) {
            // Show error 
            return Redirect::back()->withErrors(["The unit handover request for this unit had been created in draft PENDING CHECK."]);
        }
       
        return view('site_manager.unit_handover.new', compact('unit','users'));

    }

    public function store(StoreUnitHandOverRequest $request)
    {
        $data = $request->validated();
       
        try {          
            if ( $request->hasFile('appointment_image_url') ) {
                $path = $request->file('appointment_image_url')->store("appointment_image_url","public");  
                $data['appointment_image_url'] = $path;
            }

            if ( $request->hasFile('handover_letter_image_url') ) {
                $path = $request->file('handover_letter_image_url')->store("handover_letter_image_url","public");
                $data['handover_letter_image_url'] = $path;
            }

            if ( $request->hasFile('lor_image_url') ) {
                $path = $request->file('lor_image_url')->store("Assignment_of_Real_Estate_image_url","public");
                $data['lor_image_url'] = $path;
            }   

            $data = $this->covertToStandardDateFormat($data, ['date', 'agreement_date']);

            $handover = $request->user()->handovers()->create($data);
           
            return redirect()->route('site_manager.unit_handovers.edit',['id'=>$handover->id])
                             ->with('status', 'Unit handover has been created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'unit' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $unit_handover = UnitHandoverRequest::where('id', $id)
                            ->firstOrFail()
                            ->load(['approvals', 'approvals.approver']);

        return view('site_manager.unit_handover.single',compact('unit_handover'));
    }

    public function edit($id)
    {
        $handover = UnitHandoverRequest:: where('id', $id)
                            ->firstOrFail()
                            ->load(['approvals', 'approvals.approver']);

        $users = User::where('approvable',true)->get();

        $approval_workflows = \App\ApprovalWorkflow::modelType($handover->getMorphClass())->get();
       
        if( $handover->status != "Draft") {
            return abort(403);
        }

        return view('site_manager.unit_handover.edit',compact('handover','users','approval_workflows'));
    }

    public function update(UpdateUnitHandOverRequest $request, $id)
    {
        $unit_handover =UnitHandoverRequest::find($id);

        if ( $request->user()->id != $unit_handover->user_id ) {
    		return abort(403);
    	}

    	if ( $unit_handover->status != 'Draft' ) {
    	    return back()->withInput()->withErrors([ 'unit_handover' => 'Handover request can not be edited when the status is difference from Contract']);
        }

        $data = $request->validated();
        $data = $this->covertToStandardDateFormat($data, ['date', 'agreement_date']);

        try {          
            if ( $request->hasFile('appointment_image_url') ) {
                $path = $request->file('appointment_image_url')->store("appointment_image_url","public");  
                $data['appointment_image_url'] = $path;
            }

            if ( $request->hasFile('handover_letter_image_url') ) {
                $path = $request->file('handover_letter_image_url')->store("handover_letter_image_url","public");
                $data['handover_letter_image_url'] = $path;
            }

            if ( $request->hasFile('lor_image_url') ) {
                $path = $request->file('lor_image_url')->store("Assignment_of_Real_Estate_image_url","public");
                $data['lor_image_url'] = $path;
            }
            $unit_handover->fill($data);            
            $unit_handover->save();
            
            return redirect()->route('site_manager.unit_handovers.edit',['id'=>$unit_handover->id])
                             ->with('status', "Unit handover has been updated successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'unit' => $e->getMessage()]);
        }
    }

    public function applyApprovalWorkflow(Request $request, $id)
    {
        $handover_request = UnitHandoverRequest::findOrFail($id);

        if ( $request->user()->id !=   $handover_request->user_id ) {
            return abort(403);
        }

        if (  $handover_request->status != 'Draft' ) {
            return back()->withInput()->withErrors([ 'handover_request' => 'Handover request can not be edited when the status is difference from Draft']);
        }

        try {
            DB::beginTransaction();

            $previous = null;
            $work_flows = \App\ApprovalWorkflow::whereIn('id', Arr::pluck($request->workflow, 'workflow_id'))->get();
            foreach($work_flows as $index => $workflow) {
                $new = $handover_request->approvals()->create([
                    'user_id' => $request->workflow[$index]['user_id'],
                    'status' =>  $workflow->status,
                    'action_true' =>  $workflow->action_true,
                    'action_false' =>  $workflow->action_false,
                    'previous_approval_id' => is_null($previous) ? null : $previous->id,
                ]);
                if (is_null($previous)) {
                   
                    $handover_request->status = $new->status_label;
                    $handover_request->approval_id = $new->id;
                    $handover_request->save(); 
                } else {
                    $previous->next_approval_id = $new->id;
                    $previous->save();
                }

                 $previous = $new;
            }
            DB::commit();
            return redirect()->route('site_manager.unit_handovers.index')
                             ->with('status', "Approval Workflow has been sent successfully.");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors([ 'purchase_request' => $e->getMessage() ]);
        }
    }
    public function approve(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
             'remark' => 'required|max:500',
         ]);
         if ( $validator->fails() ) {
            return back()->withErrors($validator, 'approval-confirm')
                        ->withInput();
        }
        $unit_handover= UnitHandoverRequest::findOrFail($id);
        
        if ( !is_null($unit_handover->approval->action) ) {
            return back()->withErrors([ 'purchase_request' => 'Bad Request. You have already taken action on the request.']);
        }

        if ( $request->user()->id !=  $unit_handover->approval->user_id ) {
            return back()->withErrors([ 'purchase_request' => 'You are not authorized to process the request.']);
        }
        try {
            DB::beginTransaction();
            $approval = $unit_handover->approval;
            $approval->action = true;
            $approval->remark = $request->remark;
            $approval->actioned_at = now();
            $approval->save();
            if ($approval->next_approval_id != null) {
                $next_approval = Approval::find($approval->next_approval_id);
                $unit_handover->approval_id = $approval->next_approval_id;
                $unit_handover->status = $next_approval->status_label;
                $unit_handover->save();
            } else {
                $unit_handover->Unit->actions()->create([
                                'user_id'=>Auth::user()->id,
                                'action'=>'HANDOVERED',
                                'status_action'=>'RELEASE',
                                'actionable_id'=>'0',
                                'actionable_type'=>''
                            ]);
                $unit_handover->status = $approval->status_label;
                $unit_handover->save();
            }
            // Log as Comment
            $unit_handover->comments()->create([
                'user_id' => config('app.default_system_user_id'),
                'content' =>  "{$request->user()->name} has ".strtolower($approval->action_true)." the request on {$approval->actioned_at}.\nRemark: {$request->remark}"
            ]);
            DB::commit();
            // Notification Implementation
            return back()->with('status', "You have ".$approval->action_true." the request successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([ 'unit_handover' => $e->getMessage() ]);
        }
    }
    
    public function reject(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'remark' => 'required|max:500',
        ]);

        if ( $validator->fails() ) {
            return back()->withErrors($validator, 'approval-reject')
                        ->withInput();
        }

        $unit_handover= UnitHandoverRequest::findOrFail($id);
        if ( !is_null($unit_handover->approval->action) ) {
            return back()->withErrors([ 'purchase_request' => 'Bad Request. You have already taken action on the request.']);
        }

        if ( $request->user()->id !=  $unit_handover->approval->user_id ) {
            return back()->withErrors([ 'purchase_request' => 'You are not authorized to process the request.']);
        }

        try {
            DB::beginTransaction();

            $approval =  $unit_handover->approval;

            $approval->action = false;
            $approval->remark = $request->remark;
            $approval->actioned_at = now();
            $approval->save();

            $unit_handover->status = $approval->status_label;
            
            $unit_handover->save();
           
           // Log as Comment
            $unit_handover->comments()->create([
                'user_id' => config('app.default_system_user_id'),
                'content' =>  "{$request->user()->name} ".strtolower($approval->action_false)." the request on {$approval->actioned_at}.\nRemark: {$request->remark}"
            ]);

            DB::commit();

            // Notification Implementation

            return back()->with('status', "You have ".$approval->action_false." the request successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([ 'purchase_request' => $e->getMessage() ]);
        }
    }

    public function sendBack(Request $request, $id) 
    {   
        $validator = Validator::make($request->all(), [
            'remark' => 'required|max:500',
        ]);

        if ( $validator->fails() ) {           
            return back()->withErrors($validator)
                        ->withInput();
        }
        $unit_handover_request = UnitHandoverRequest::findOrFail($id);

        if ( $request->user()->id != $unit_handover_request->approval->user_id ) {
            return back()->withErrors([ 'purchase_request' => 'You are not authorized to process the request.']);
        }

        if ( !is_null($unit_handover_request->approval->action) ) {
            return back()->withErrors([ 'purchase_request' => 'You can not send back the approval when you have already take action on the request.']);
        }

        if ( is_null($unit_handover_request->approval->previous_approval_id) ) {
            try {
                DB::beginTransaction();
                $unit_handover_request->approvals()->delete();
                $unit_handover_request->approval_id = NULL;
                $unit_handover_request->status = 'Draft';
                $unit_handover_request->save();                
                DB::commit();
                // Notify $purchase_request's user_id
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors([ 'unit_handover_request' => $e->getMessage() ]);
            }
        } else {
            try {
                DB::beginTransaction(); 
                $previous_approval = Approval::find($unit_handover_request->approval->previous_approval_id);
                $previous_approval->action = NULL;
                $previous_approval->actioned_at = NULL;
                $previous_approval->remark = "";
                $previous_approval->save();

                $unit_handover_request->approval_id = $previous_approval->id;
                $unit_handover_request->status = $previous_approval->status_label;
                $unit_handover_request->save();
                DB::commit();
                // Notify $previous_approval->user_id
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors([ 'unit_handover_request' => $e->getMessage() ]);
            }        
        }
        // Log as Comment
        $unit_handover_request->comments()->create([
            'user_id' => config('app.default_system_user_id'),
            'content' =>  "{$request->user()->name} has sent back the request to review on ".now().".\nRemark: {$request->remark}"
        ]);    

        return back()->with('status', "You have sent back the request successfully.");
    }

    public function showImportForm()
    {
        $projects = Project::all();
        return view('admin.unit_handover.import', compact(['projects']));
    }
    
    public function getImportTemplate() 
    {
        return Excel::download(new UnitHandoversExport, 'unit_handovers.csv',\Maatwebsite\Excel\Excel::CSV);
    }

    public function import(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'data_updated_on' => 'required|date'
        ]);

        if ( !$request->hasFile('unit_handover_list') ) {
            return back()->withErrors([ 'unit_handover' => "Please select you CSV file and make you it is in the correct format."]);
        }

        try {     
            $path = $request->file('unit_handover_list')->store("temp","public");
            
            Excel::import(
                new UnitHandoversImport($validatedData['project_id'], $validatedData['data_updated_on']),
                $path,
                "public",
                \Maatwebsite\Excel\Excel::CSV
            );

            return redirect()->route('admin.units.index')
            ->with('status', "Unit Handover data has been successfully imported.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'unit_handover' => $e->getMessage()]);
        }
    }
}