<?php

namespace App\Http\Controllers\PurchaseRequest;

use App;
use App\User;
use App\Approval;
use App\Department;
use App\PurchaseRequest;
use App\PurchaseRequestDetail;
use App\PurchaseRequestProject;
use Carbon\Carbon;
use App\Http\Requests\CreatePurchaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalRequest;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        // data need to be passed to view 
    	$purchase_request_projects = PurchaseRequestProject::all();
        $departments = Department::all();

        $purchase_requests = null;
        $view = $request->view;

        switch ($view) {
            case 'all':
                $purchase_requests = PurchaseRequest::query();
                break;
            case 'pending_my_approval':
                $purchase_requests = PurchaseRequest::pendingMyApproval();
                break;
            default:
                $purchase_requests = PurchaseRequest::owner();
                break;
        }

        $purchase_requests->when( (int) $code = $request->code, function ($query, $code) {
            return $query->where('id', 'LIKE', "%$code%");
        });

        $purchase_requests->when( $project_id = $request->project_id, function ($query, $project_id) {
            return $query->where('project', $project_id);
        });

        $purchase_requests->when( $department_id = $request->department_id, function ($query, $department_id) {
            return $query->where('department_id', $department_id);
        });

        $purchase_requests->when( $created_from = $request->created_from, function ($query, $created_from) {
            return $query->orWhereDate('created_at', '>=' ,  Carbon::createFromFormat(config('app.php_date_format'), $created_from));
        });

        if ( $request->created_from AND $request->created_to ) {
            $purchase_requests->createdBetweenDate($request->created_from, $request->created_to);
        }

        $purchase_requests->with(['purchaseRequestProject', 'department', 'createdBy', 'approval']);
      
        $purchase_requests = $purchase_requests->paginate();

        return view("purchase_request.index",compact('purchase_requests','purchase_request_projects','departments'));
    }

    public function show($id) 
    {
    	$purchase_request = PurchaseRequest::where('id', $id)
                            ->firstOrFail()
                            ->load(['purchaseRequestDetails', 'approvals', 'approvals.approver', 'media']);

        return view("purchase_request.single", compact('purchase_request'));
    }

    public function print($id)
    {
        $purchase_request = PurchaseRequest::where('id', $id)
                            ->firstOrFail()
                            ->load(['purchaseRequestDetails', 'approvals', 'approvals.approver']);

        $pdf = App::make('snappy.pdf.wrapper'); 
        $html = View::make("purchase_request.print", compact('purchase_request'));        
        $pdf->loadHTML($html)
            ->setOption('margin-top', '10mm')
            ->setOption('margin-bottom', '10mm')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('footer-font-name', 'Times New Roman')
            ->setOption('footer-font-size', '6')
            ->setOption('footer-right', 'Page: [page] of [topage]');        
        return $pdf->inline('PR - '.$purchase_request->code.'.pdf');
    }

    public function create()
    {
    	$departments = Department::all();
        $purchase_request_projects = PurchaseRequestProject::all();

        return view("purchase_request.new",compact('departments','purchase_request_projects'));
    }

    public function store(CreatePurchaseRequest $request) 
    {
    	$data = $request->validated();
        $purchase_request_data = Arr::except($data, ['purchase_request_details']);
        $staff_ids = Arr::pluck($data['purchase_request_details'], 'staff_id');
        $count = PurchaseRequestDetail::whereIn('staff_id', $staff_ids)
        ->get()
        ->countBy( function ($obj) { 
            return $obj->staff_id; 
        });       
       
        try {
    		DB::beginTransaction();
    		
            $purchase_request = $request->user()->purchaseRequests()->create($purchase_request_data);

    		foreach($data['purchase_request_details'] as $key => $obj) {
    			$purchase_request_detail = New PurchaseRequestDetail();
    			$obj = $this->covertToStandardDateFormat($obj, $purchase_request_detail->getDates());
    			$purchase_request->purchaseRequestDetails()->create($obj);
    		}

            if ( $request->attachments ) {
                foreach($request->file('attachments') as $file) {
                    $filename = md5(time()).'.'.$file->getClientOriginalExtension();
                    $purchase_request->addMedia($file)
                            ->usingFileName($filename)
                            ->toMediaCollection();
                }
            }   

    		DB::commit();           
    		return redirect()->route('purchase_requests.edit', ['id' => $purchase_request->id])
                             ->with('status', "Purchase Request has been created successfully.")->with(compact('count'));
    	} catch (\Exception $e) {
    		DB::rollback();
    		return back()->withInput()->withErrors([ 'purchase_request' => $e->getMessage()]);
    	}  
    }

    public function edit($id) 
    {
        $users =User::where('approvable',true)->get();
        $departments = Department::all();
        $purchase_request_projects = PurchaseRequestProject::all();
        
        $purchase_request = PurchaseRequest::where('id', $id)
                            ->firstOrFail()
                            ->load(['purchaseRequestDetails', 'approvals', 'approvals.approver', 'media']);
        
        $approval_workflows = \App\ApprovalWorkflow::modelType($purchase_request->getMorphClass())->get();
        if ( $purchase_request->status != 'Draft' ) {
            return back()->withErrors([ 'purchase_request' => 'Purchase request can not be edited when the status is difference from Draft']);
        }

        return view("purchase_request.edit",compact('purchase_request','purchase_request_projects','departments','users', 'approval_workflows'));
    }

    public function update(CreatePurchaseRequest $request, $id)
    {
    	$purchase_request = PurchaseRequest::findOrFail($id);

    	if ( $request->user()->id !=  $purchase_request->user_id ) {
    		return abort(403);
    	}

    	if ( $purchase_request->status != 'Draft' ) {
    		return back()->withInput()->withErrors([ 'purchase_request' => 'Purchase request can not be edited when the status is difference from Draft']);
    	}

		$data = $request->validated();
    	$purchase_request_data = Arr::except($data, ['purchase_request_details']);
    
        try {
            DB::beginTransaction();
           	
            $purchase_request->fill($purchase_request_data);            
            $purchase_request->save();

            $purchase_request->purchaseRequestDetails()->delete();
           	foreach($data['purchase_request_details'] as $key => $obj) {
    			$purchase_request_detail = New PurchaseRequestDetail();
    			$obj = $this->covertToStandardDateFormat($obj, $purchase_request_detail->getDates());
    			$purchase_request->purchaseRequestDetails()->create($obj);
    		}

            DB::commit();
            return back()->with('status', "Updated successfully.");

        } catch( \Exception $e ) {
            DB::rollBack();
           	return back()->withInput()->withErrors([ 'purchase_request' => $e->getMessage()]);
        } 
    }
   
    public function applyApprovalWorkflow(Request $request, $id)
    {
        $purchase_request = PurchaseRequest::findOrFail($id);
        // $data = $request->validated();
        
        if ( $request->user()->id !=  $purchase_request->user_id ) {
            return abort(403);
        }

        if ( $purchase_request->status != 'Draft' ) {
            return back()->withInput()->withErrors([ 'purchase_request' => 'Purchase request can not be edited when the status is difference from Draft']);
        }

        try {

            DB::beginTransaction();
            
            $previous = null;
            $work_flows = \App\ApprovalWorkflow::whereIn('id', Arr::pluck($request->workflow, 'workflow_id'))->get();
          
            foreach($work_flows as $index => $workflow) {
                $new = $purchase_request->approvals()->create([
                    'user_id' => $request->workflow[$index]['user_id'],
                    'status' =>  $workflow->status,
                    'action_true' =>  $workflow->action_true,
                    'action_false' =>  $workflow->action_false,
                    'previous_approval_id' => is_null($previous) ? null : $previous->id,
                ]);

                if (is_null($previous)) {
                    $purchase_request->status = $new->status_label;
                    $purchase_request->approval_id = $new->id;
                    $purchase_request->save(); 
                } else {
                    $previous->next_approval_id = $new->id;
                    $previous->save();
                }

                $previous = $new;
            }

            DB::commit();

            return redirect()->route('purchase_requests.show', ['id' => $purchase_request->id])
                            ->with('status', "Approval Workflow has been sent successfully.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'purchase_request' => $e->getMessage() ]);
        }
    }

    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'remark' => 'required|max:500',
        ]);

        if ( $validator->fails() ) {
            return back()->withErrors($validator, 'approval-confirm')
                        ->withInput();
        }

        $purchase_request = PurchaseRequest::findOrFail($id);
        
        if ( !is_null($purchase_request->approval->action) ) {
            return back()->withErrors([ 'purchase_request' => 'Bad Request. You have already taken action on the request.']);
        }

        if ( $request->user()->id != $purchase_request->approval->user_id ) {
            return back()->withErrors([ 'purchase_request' => 'You are not authorized to process the request.']);
        }

        try {
            DB::beginTransaction();
 
            $approval = $purchase_request->approval;
            $approval->action = true;
            $approval->remark = $request->remark;
            $approval->actioned_at = now();
            $approval->save();

            if ($approval->next_approval_id != null) {
                $next_approval = Approval::find($approval->next_approval_id);
                $purchase_request->approval_id = $approval->next_approval_id;
                $purchase_request->status = $next_approval->status_label;
                $purchase_request->save();
            } else {
                $purchase_request->status = $approval->status_label;
                $purchase_request->save();
            }

            // Log as Comment
            $purchase_request->comments()->create([
                'user_id' => config('app.default_system_user_id'),
                'content' =>  "{$request->user()->name} has ".strtolower($approval->action_true)." the request on {$approval->actioned_at}.\nRemark: {$request->remark}"
            ]);

            DB::commit();

            // Notification Implementation
           
            return back()->with('status', "You have ".$approval->action_true." the request successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([ 'purchase_request' => $e->getMessage() ]);
        }
        
    }

    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'remark' => 'required|max:500',
        ]);

        if ( $validator->fails() ) {
            return back()->withErrors($validator, 'approval-reject')
                        ->withInput();
        }

        $purchase_request = PurchaseRequest::findOrFail($id);

        if ( !is_null($purchase_request->approval->action) ) {
            return back()->withErrors([ 'purchase_request' => 'Bad Request. You have already taken action on the request.']);
        }
        
        if ( $request->user()->id != $purchase_request->approval->user_id ) {
            return back()->withErrors([ 'purchase_request' => 'You are not authorized to process the request.']);
        }

        try {
            DB::beginTransaction();

            $approval = $purchase_request->approval;

            $approval->action = false;
            $approval->remark = $request->remark;
            $approval->actioned_at = now();
            $approval->save();

            $purchase_request->status = $approval->status_label;
            $purchase_request->save();

            // Log as Comment
            $purchase_request->comments()->create([
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

        $purchase_request = PurchaseRequest::findOrFail($id);

        if ( $request->user()->id != $purchase_request->approval->user_id ) {
            return back()->withErrors([ 'purchase_request' => 'You are not authorized to process the request.']);
        }

        if ( !is_null($purchase_request->approval->action) ) {
            return back()->withErrors([ 'purchase_request' => 'You can not send back the approval when you have already take action on the request.']);
        }

        if ( is_null($purchase_request->approval->previous_approval_id) ) {
            try {
                DB::beginTransaction();
                $purchase_request->approvals()->delete();
                $purchase_request->approval_id = NULL;
                $purchase_request->status = 'Draft';
                $purchase_request->save();                
                DB::commit();
                // Notify $purchase_request's user_id
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors([ 'purchase_request' => $e->getMessage() ]);
            }
        } else {
            try {
                DB::beginTransaction(); 
                $previous_approval = Approval::find($purchase_request->approval->previous_approval_id);
                $previous_approval->action = NULL;
                $previous_approval->actioned_at = NULL;
                $previous_approval->remark = "";
                $previous_approval->save();

                $purchase_request->approval_id = $previous_approval->id;
                $purchase_request->status = $previous_approval->status_label;
                $purchase_request->save();
                DB::commit();
                // Notify $previous_approval->user_id
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors([ 'purchase_request' => $e->getMessage() ]);
            }        
        }
        // Log as Comment
        $purchase_request->comments()->create([
            'user_id' => config('app.default_system_user_id'),
            'content' =>  "{$request->user()->name} has sent back the request to review on ".now().".\nRemark: {$request->remark}"
        ]);    

        return back()->with('status', "You have sent back the request successfully.");
    }    
}
