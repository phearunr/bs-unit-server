<?php

namespace App\Http\Controllers\Admin;

use App;
use PDF;
use App\User;
use App\Contract;
use App\Project;
use App\UnitDepositRequest;
use App\UnitContractRequest;
use App\Helpers\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\PaymentOptionController;

class UnitContractRequestController extends Controller
{
    public function index(Request $request)
    {
    	$unit_contract_requests = UnitContractRequest::query();
        $unit_contract_requests = $unit_contract_requests->with([
        								"unitDepositRequest",
        								"unitDepositRequest.paymentOption",
        								"unit"
        							]);  

        if ( $request->query('term') ) {   
            $term = $request->query('term');
            $unit_contract_requests = $unit_contract_requests->orWhereHas('unit' , function ($query) use ($term) {
                $query->where('code', 'LIKE', '%'.$term.'%');
            });
            $unit_contract_requests = $unit_contract_requests->orWhereHas('unitDepositRequest' , function ($query) use ($term) {
                $query->where('customer_name', 'LIKE', '%'.$term.'%');
            });
            $unit_contract_requests = $unit_contract_requests->orWhereHas('unitDepositRequest' , function ($query) use ($term) {
                $query->where('customer_phone_number', 'LIKE', '%'.$term.'%');
            });
            $unit_contract_requests = $unit_contract_requests->orWhereHas('unitDepositRequest' , function ($query) use ($term) {
                $query->where('customer_phone_number2', 'LIKE', '%'.$term.'%');
            });
        }      

        if ( $request->query('from') AND $request->query('to')) {
            $unit_contract_requests = $unit_contract_requests->ofCreatedBetweenDate($request->query('from'), $request->query('to'));
        } 

        $unit_contract_requests = $unit_contract_requests->paginate();
        return view('admin.unit_contract_request.index', compact('unit_contract_requests'));
    }

    public function show($id)
    {
    	$unit_contract_request = UnitContractRequest::findOrFail($id)->load([
        								"unitDepositRequest",
        								"unitDepositRequest.paymentOption",
        								"unit"
        							]);
        $contract_template_name = $unit_contract_request->unit->unitType->contractTemplate->name;
        $agent = User::find($unit_contract_request->user_id);
        $manager = User::find($agent->managed_by);

        $payment_option_array = PaymentOptionController::getPaymentOptionArray($unit_contract_request->unitDepositRequest);

        return view('admin.unit_contract_request.single', compact(
            'unit_contract_request',
            'payment_option_array',
            'contract_template_name', 
            'agent',
            'manager')
        );
    }

    public function printRequest($id)
    {
        App::setLocale('km');
        $unit_contract_request = UnitContractRequest::findOrFail($id)->load([
                                        "unitDepositRequest",
                                        "unitDepositRequest.paymentOption",
                                        "unit",
                                        "createdBy"
                                    ]);
        $unit_deposit_request = $unit_contract_request->unitDepositRequest;
        $unit = $unit_contract_request->unit;
        $payment_option_array = PaymentOptionController::getPaymentOptionArray($unit_deposit_request);
        $agent = $unit_contract_request->createdBy;
        $sale_team_leader = $agent->manager;

        $pdf = App::make('snappy.pdf.wrapper');

        $html = View::make('admin.contract.template.agent_request_form', compact(
            'unit_contract_request',
            'unit_deposit_request',
            'unit',
            'payment_option_array',
            'agent',
            'sale_team_leader'
        ));
       
        $pdf->loadHTML($html)
            ->setOption('margin-left', '15mm')
            ->setOption('margin-right', '15mm')
            ->setOption('footer-font-name', 'Times New Roman')
            ->setOption('footer-font-size', '6')
            ->setOption('footer-right', 'Page: [page] of [topage]');
        return $pdf->inline($unit->code." - ".$unit_deposit_request->customer1_name.'.pdf');
    }

    public function showCreateContractForm($id)
    {
        $contract = Contract::where("unit_contract_request_id", $id)->first();
        if ( $contract ) {
            return back()->withErrors([ 'contract' => __("Sorry, the contract for this request already have been created.")]);
        }

        $unit_contract_request = UnitContractRequest::findOrFail($id)->load([
                                        "unitDepositRequest",
                                        "unitDepositRequest.paymentOption",
                                        "unit",
                                        "createdBy"
                                    ]);

        if ( $unit_contract_request->unit->unitType->is_contractable == FALSE ) {
            return back()->withErrors([ 'unit_contract_request' => __("Sorry, System does not allow you to create the contract for this specific unit yet.")]);
        }
        $unit_deposit_request = $unit_contract_request->unitDepositRequest;
        $agent = User::find($unit_contract_request->user_id);
        $manager = User::find($agent->managed_by);
     
        $projects = Project::with(['unitTypes'])->get();

        $unit = $unit_contract_request->unit;
        $payment_option = $unit_contract_request->paymentOption;
        $unit_type =  $unit->unitType;
        $unit_type =  $unit_type->makeVisible($unit_type->getHidden());
        $payment_option_array = PaymentOptionController::getPaymentOptionArray($unit_deposit_request);
        
        return view('admin.unit_contract_request.new_contract', compact(
            "unit_contract_request", 
            "unit_deposit_request", 
            "unit", 
            "projects", 
            "unit_type", 
            "payment_option_array",
            'agent',
            'manager')
        );
    }
}
