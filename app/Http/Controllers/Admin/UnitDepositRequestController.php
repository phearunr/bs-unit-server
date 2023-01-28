<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UnitDepositRequest;
use App\UnitAction;
use App\Helpers\UnitDepositStatus;
use App\Helpers\UserRole;
use App\Helpers\MsNavBridge;
use App\Http\Requests\ActionUnitDepositRequest;
use App\Http\Controllers\Notifications\UnitDepositRequestNotificationController;
use App\Http\Controllers\Admin\PaymentOptionController;
use App\Http\Controllers\Controller;
use App\Notifications\UnitDepositRequestVoided;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class UnitDepositRequestController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = $request->user();
    	$unit_deposit_requests = UnitDepositRequest::query();
        $statuses = UnitDepositStatus::getDepositStatuses();
        $payment_statuses = UnitDepositRequest::getPaymentStatuses();

        if ($auth_user->hasRole(UserRole::ACCOUNTANT)) {
            $statuses =  array_diff($statuses, [
                UnitDepositStatus::PENDING,
                UnitDepositStatus::CHANGED,
                UnitDepositStatus::REJECTED
            ]);
        }

    	if ( $request->query('term') ) {
            $term = $request->query('term');           
            $unit_deposit_requests = $unit_deposit_requests->orWhereHas('unit' , function ($query) use ($term) {
                $query->where('code', 'LIKE', '%'.$term.'%');
            });
            $unit_deposit_requests = $unit_deposit_requests->orWhere('customer_name', 'LIKE', '%'.$term.'%');
            $unit_deposit_requests = $unit_deposit_requests->orWhere('customer2_name', 'LIKE', '%'.$term.'%');
            $unit_deposit_requests = $unit_deposit_requests->orWhere('customer_phone_number', 'LIKE', '%'.$term.'%');
            $unit_deposit_requests = $unit_deposit_requests->orWhere('customer_phone_number2', 'LIKE', '%'.$term.'%');         
        } 

    	if ( $request->query('from') AND $request->query('to') ) {
    		$unit_deposit_requests = $unit_deposit_requests->ofCreatedBetweenDate($request->query('from'), $request->query('to'));
    	}
        
        if ( $request->query('status') ) {
            $unit_deposit_requests = $unit_deposit_requests->ofStatus($request->query('status'));
        } else {
            $unit_deposit_requests = $unit_deposit_requests->ofStatus($statuses);
        }      

        if ( $request->query('payment_status') ) {          
            $unit_deposit_requests = $unit_deposit_requests->OfReceivingAmount($request->query('payment_status'));         
        }

	    $unit_deposit_requests = $unit_deposit_requests->with(['unit','createdBy'])->paginate();

	    return view('admin.unit_deposit_request.index', compact('unit_deposit_requests','statuses','payment_statuses'));
    }

    public function show(Request $request, $id) 
    {
    	$unit_deposit_request = UnitDepositRequest::findOrFail($id);
    	$contract_template_name = $unit_deposit_request->unit->unitType->contractTemplate->name;
   		$payment_option_array = PaymentOptionController::getPaymentOptionArray($unit_deposit_request);
    	return view('admin.unit_deposit_request.single', compact('unit_deposit_request','contract_template_name','payment_option_array'));
    }

    public function showUpdateReceivingAmountForm(Request $request, $id)
    {
        $unit_deposit_request = UnitDepositRequest::findOrFail($id);
        return view('admin.unit_deposit_request.receving_amount', compact('unit_deposit_request'));
    }

    public function getPayment(Request $request, $id)
    {    
        if ( !$request->ajax() ) {
            abort(404);
        }

        $unit_deposit_request = UnitDepositRequest::findOrFail($id);   
        $unit = $unit_deposit_request->unit;
        $variant_code = $unit->code;
        $company = $unit->unitType->project->nav_company_code;


        $nav_client = New MsNavBridge(config('app.nav_odata_server_url'), config('app.nav_odata_auth_key'));

        $resource = "Company('$company')/CustomerLedgerEntries";
        $query = [
            '$format' => 'json',
            '$top' => 50,
            '$orderby' => 'Posting_Date desc',
            '$filter' => "Variant_Code eq '$variant_code' and Reversed eq false and Document_Type eq 'Payment'",
        ];

        // Psr7 Response;
        $response = $nav_client->request("GET", $resource, $query);

        return $response;
    }

    public function UpdateReceivingAmount(Request $request, $id)
    {
        $unit_deposit_request = UnitDepositRequest::findOrFail($id);
        $validatedData = $request->validate([
            "receiving_amount" => "required|numeric|min:0",    
            "document_no" => "nullable|string|max:191",
            "entry_no" => "nullable|string|max:191",
        ]);

        try {
            $unit_deposit_request->receiving_amount = $validatedData['receiving_amount'];
            $unit_deposit_request->received_at = now();
            $unit_deposit_request->receiver_id = Auth::id();
            $unit_deposit_request->document_no = $validatedData['document_no'];
            $unit_deposit_request->entry_no = $validatedData['entry_no'];
            $unit_deposit_request->save();
            if ( $request->ajax() ) {
                return response()->json([
                    'status' => __('success'), 
                    'message' => __('Deposit request has been cancelled successfully.')
                ], 200);
            }
            return redirect()->route('admin.unit_deposit_requests.update.receving_amount', ['id' => $unit_deposit_request->id])
                             ->with('status', __("Receving amount has been updated successfully."));

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['unit_deposit_request' => $e->getMessage()]);
        }
    }

    public function cancel(ActionUnitDepositRequest $request, $id) 
    {
        $validated_data = $request->validated();
        $unit_deposit_request = UnitDepositRequest::findOrFail($id);

        if ( !$unit_deposit_request->isCancellable() ) {
            return response()->json([
                'status' => __('Error'), 
                'message' => __('The deposit request is not in the status which allow you to cancel.')
            ], 422);
        }

        try {  
            DB::beginTransaction();
            $unit_deposit_request->setAction(UnitDepositStatus::CANCELLED, $validated_data['action_reason']);  
            $unit_deposit_request->save();
            // add Action history to Unit Object
            UnitAction::create([
                'user_id' => Auth::user()->id,
                'unit_id' => $unit_deposit_request->unit_id,
                'action' => UnitDepositStatus::DEPOSIT,
                'status_action' =>  UnitDepositStatus::CANCELLED,          
                'actionable_type' => $unit_deposit_request->getMorphClass(),
                'actionable_id' => $unit_deposit_request->id
            ]);
            UnitAction::makeUnitAvailableBySystem($unit_deposit_request->unit_id); 
            // notification
            $agent = User::where('id', $unit_deposit_request->user_id)->first();          
            UnitDepositRequestNotificationController::sendUnitDepositCancelledRequest(
                $agent, 
                $unit_deposit_request, 
                $request->user()->roles()->first()->name
            );
            DB::commit();
            return response()->json([
                'status' => __('success'), 
                'message' => __('Deposit request has been cancelled successfully.')
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => __('Error'), 
                'message' => __('Internal Server Error!').$e->getMessage()
            ], 500);
        }
    }

    public function void(ActionUnitDepositRequest $request, $id) 
    {
        $validated_data = $request->validated();
        $unit_deposit_request = UnitDepositRequest::findOrFail($id);

        if ( !$unit_deposit_request->isVoidable() ) {
            return response()->json([
                'status' => __('Error'), 
                'message' => __('The deposit request is not in the status which allow you to void.')
            ], 422);
        }

        try {  
            DB::beginTransaction();
            $unit_deposit_request->setAction(UnitDepositStatus::VOIDED, $validated_data['action_reason']);  
            $unit_deposit_request->save();
            // add Action history to Unit Object
            UnitAction::create([
                'user_id' => Auth::user()->id,
                'unit_id' => $unit_deposit_request->unit_id,
                'action' => UnitDepositStatus::DEPOSIT,
                'status_action' =>  UnitDepositStatus::VOIDED,          
                'actionable_type' => $unit_deposit_request->getMorphClass(),
                'actionable_id' => $unit_deposit_request->id
            ]);
            UnitAction::makeUnitAvailableBySystem($unit_deposit_request->unit_id); 
            // notification
            $agent = User::where('id', $unit_deposit_request->user_id)->first();          
            $agent->notify(new UnitDepositRequestVoided(
                $unit_deposit_request, 
                $request->user()->roles()->first()->name
            ));
            DB::commit();
            return response()->json([
                'status' => __('success'), 
                'message' => __('Deposit request has been cancelled successfully.')
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => __('Error'), 
                'message' => __('Internal Server Error!').$e->getMessage()
            ], 500);
        }
    }
}