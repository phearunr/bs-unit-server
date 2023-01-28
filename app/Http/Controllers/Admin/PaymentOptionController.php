<?php

namespace App\Http\Controllers\Admin;

use App\PaymentOption;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PaymentOptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-payment-option')->only('index');
        $this->middleware('permission:create-payment-option')->only(['create','store']);
        $this->middleware('permission:update-payment-option')->only(['edit','update']);
        $this->middleware('permission:delete-payment-option')->only(['showDeleteForm','showRetoreForm','destroy','restore']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_options = PaymentOption::query();
        $payment_options = $payment_options->with(['unitType','unitType.project']);
        $projects = Project::with('unitTypes')->get();

        if ( $request->query('status') ) {
            $payment_options = $payment_options->ofStatus($request->query('status'));
        } else {
             $payment_options = $payment_options->ofStatus();
        }

        if ( $request->query('term') ) {
            $term = $request->query('term');
            $payment_options = $payment_options->where('name' , 'LIKE', '%'.$term.'%');      
        }

        if ( $request->query('unit_type') ) {          
            $payment_options = $payment_options->where('unit_type_id' , $request->query('unit_type'));      
        }

        $payment_options = $payment_options->paginate(10);

        return view('admin.payment_option.index', compact('payment_options','projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::with(['unitTypes'])->get();
        return view('admin.payment_option.new',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $rules = [
            "name" => "required|string|max:255",
            "deposit_amount" => "required|numeric|min:0",
            "unit_type_id" => "required|exists:unit_types,id",
            "loan_duration" => "required|integer|min:0",
            "interest" => "required|numeric|min:0|max:100"         
        ];

        if ( $request->input('is_first_payment') ) {
            $rules['first_payment_duration'] = 'required|integer|min:0';
            $rules['first_payment_percentage'] = 'required|integer|min:0|max:100';
        }

        $validatedData = $request->validate($rules);

        $data = $request->only(["name","unit_type_id",'deposit_amount',"loan_duration","interest"]);
        if ( $request->input('is_first_payment') ) {
            $data['is_first_payment'] = true;
            $data['first_payment_duration'] = $request->first_payment_duration;
            $data['first_payment_percentage'] = $request->first_payment_percentage;
        } else {
             $data['is_first_payment'] = false;
            $data['first_payment_duration'] = 0;
            $data['first_payment_percentage'] = 0;
        }
        $data['user_id'] = Auth::id();

        try {          
            $payment_option = PaymentOption::create($data);         
            return redirect()->route('admin.payment_options.edit', ['id' => $payment_option->id])
                             ->with('status', "Payment Option has been created successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'payment_option' => $e->getMessage()]);
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
            return PaymentOption::findOrFail($id);
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment_option = PaymentOption::findOrFail($id);
        $projects = Project::with(['unitTypes'])->get();
        return view('admin.payment_option.edit',compact("payment_option","projects"));
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
            "deposit_amount" => "required|numeric|min:0",
            "unit_type_id" => "required|exists:unit_types,id",
            "loan_duration" => "required|integer|min:0",
            "interest" => "required|numeric|min:0|max:100",
            "special_discount" => "required|numeric|min:0|max:100",
            "first_payment_duration" => "required_if:is_first_payment,on|integer|min:0",
            "first_payment_percentage" => "required_if:is_first_payment,on|integer|min:0|max:100"
        ]);

        $payment_option = PaymentOption::findOrFail($id);

        $data = $request->all();
        $data['is_first_payment'] = false;
        $data['user_id'] = Auth::id();
        if ( $request->input('is_first_payment') ) {
            $data['is_first_payment'] = true;
        } else {
            $data['first_payment_duration'] = 0;
            $data['first_payment_percentage'] = 0;
        }
        
        try {          
            $payment_option = $payment_option->fill($data);
            $payment_option->save();
            return redirect()->route('admin.payment_options.edit', ['id' => $payment_option->id])
                             ->with('status', "Payment Option has been updated successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'payment_option' => $e->getMessage()]);
        }
    }

    public function showDeleteForm($id) 
    {
        $payment_option = PaymentOption::findOrFail($id);
        return view('admin.payment_option.delete',compact("payment_option"));
    }

    public function showRestoreForm($id) 
    {
        $payment_option = PaymentOption::withTrashed()->findOrFail($id);
        return view('admin.payment_option.restore',compact("payment_option"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment_option = PaymentOption::findOrFail($id);
        try {           
            $payment_option->delete();
            return redirect()->route('admin.payment_options.index')->with('status', "Payment Option : $payment_option->name has been successfully deleted.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'payment_option' => $e->getMessage()]);
        }   
    }

    public function restore($id) 
    {
        $payment_option = PaymentOption::withTrashed()->findOrFail($id);
        try {           
            $payment_option->restore();
            return redirect()->route('admin.payment_options.index')->with('status', "Project : $payment_option->name has been successfully restored.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'payment_option' => $e->getMessage()]);
        }
    }

    public static function getPaymentOptionArray(\App\UnitDepositRequest $unit_deposit_request)
    {
        $payment_option =  $unit_deposit_request->paymentOption;
        $payment_option_array = [
            "id" => null,
            "payment_option_id" => null,
            "loan_duration" => 0,
            "interest" => 0,
            "special_discount" => 0,
            "is_first_payment" => false,
            "first_payment_duration" => 0,
            "first_payment_percentage" => 0,
            "first_payment_amount" => 0,
        ];
        if ( is_null($payment_option) ) {
            $payment_option_array = array_merge($payment_option_array, $unit_deposit_request->only('payment_option_id','loan_duration','interest','special_discount','is_first_payment','first_payment_duration','first_payment_percentage','first_payment_amount'));
        } else {
            $payment_option_array = array_merge($payment_option_array, $payment_option->getAttributes());
        } 
        return $payment_option_array;
    }
}
