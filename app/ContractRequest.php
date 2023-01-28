<?php

namespace App;

use App\Helpers\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ContractRequest extends Model
{   
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            if (is_null($model->customer2_name)) {
                $model->customer2_name = "";
            }
            if (is_null( $model->customer2_gender )) {
                $model->customer2_gender = 0;
            }
            if (is_null( $model->customer_phone_number2 )) {
                $model->customer_phone_number2 = "";
            }
            if (is_null( $model->agent_remark )) {
                $model->agent_remark = "";
            }
            if (is_null( $model->unit_remark )) {
                $model->unit_remark = "";
            }
            if (is_null( $model->discount_promotion )) {
                $model->discount_promotion = 0;
            }
            if (is_null( $model->other_discount_allowed )) {
                $model->other_discount_allowed = 0;
            }
        });

        static::updating(function($model) {
            // $model->updated_at = \Carbon\Carbon::now();
            if (is_null($model->customer2_name)) {
                $model->customer2_name = "";
            }
            if (is_null( $model->customer2_gender )) {
                $model->customer2_gender = 0;
            }
            if (is_null( $model->customer_phone_number2 )) {
                $model->customer_phone_number2 = "";
            }
            if (is_null( $model->agent_remark )) {
                $model->agent_remark = "";
            }
            if (is_null( $model->unit_remark )) {
                $model->unit_remark = "";
            }
            if (is_null( $model->discount_promotion )) {
                $model->discount_promotion = 0;
            }
            if (is_null( $model->other_discount_allowed )) {
                $model->other_discount_allowed = 0;
            }
        });

        static::addGlobalScope('recent', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

	protected $dates = [
        'customer1_birthdate',
        'customer1_nid_issued_date',
        'customer2_birthdate',
        'customer2_nid_issued_date',
        'sign_date',
		'created_at', 
		'updated_at', 
		'deleted_at',
		'unit_sold_date',
		'deposited_date',
        'start_payment_date',
        'unit_controller_approved_date',
        'unit_controller_rejected_date',
        'sale_manager_approved_date',
        'sale_manager_rejected_date'
	];

	/**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    	'unit_controller_approved',
    	'unit_controller_approved_date',
    	'sale_manager_approved',
    	'sale_manager_approved_date',
    	'unit_controller_rejected',
        'unit_controller_rejected_date',
        'sale_manager_rejected',
        'sale_manager_rejected_date',
    ];

    /**
     * The User's attributes that will be return on this's model's attribute that reference to User Model.
     *
     * @var array
     */
    protected $userVisibleAttributes = ['id', 'name', 'avatar', 'phone_number'];

    /**
     * The attributes that visible to to JSON Response.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'customer1_name',
        'customer1_gender',
        'customer2_name',
        'customer2_gender',
        'customer_phone_number',
        'customer_phone_number2',
        'agent_name',
        'agent_gender',
        'agent_phone_number',
        'agent_remark',
        'sale_team_leader_id',
        'unit_sold_date',      
        'unit_id',
        'unit_code',
        'unit_sold_price',
        'discount_promotion',
        'other_discount_allowed',
        'unit_remark',
        'deposited_amount',
        'deposited_date',
        'payment_option_id',
        'loan_duration',
        'interest',
        'special_discount',
        'is_first_payment',
        'first_payment_duration',
        'first_payment_percentage',
        'first_payment_amount',
        'start_payment_date',
        'sign_date',
        'unit_controller_status',
        'sale_manager_status',
        'editable',        
        'unit_controller_approved_date',        
        'sale_manager_approved_date',       
        'unit_controller_rejected_date',        
        'sale_manager_rejected_date',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that appended to to JSON Response.
     *
     * @var array
     */
    protected $appends = ['unit_controller_status', 'sale_manager_status','editable'];

    /**
     * The relationship which should be autoload when query
     *
     * @var array
     */
    protected $with = [
        'createdBy',
        'saleTeamLeader',
        'unitControllerApprover',
        'saleManagerApprover',
        'unitControllerRejector',
        'saleManagerRejector',
        'attachments',
        'paymentOption',
        'unit',
        'unit.unitType',
        'unit.unitType.project'
    ];

    protected $casts = [
        'is_first_payment' => 'boolean',
    ];

    
    // Model Relationship
    public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', 'id')->select($this->getUserVisibleAttributes());
    }

    public function saleTeamLeader()
    {
        return $this->belongsTo('App\User', 'sale_team_leader_id', 'id')->select($this->getUserVisibleAttributes());
    }

    public function unitControllerApprover()
    {
        return $this->belongsTo('App\User', 'unit_controller_approved', 'id')->select($this->getUserVisibleAttributes());
    }

    public function saleManagerApprover()
    {
        return $this->belongsTo('App\User', 'sale_manager_approved', 'id')->select($this->getUserVisibleAttributes());
    }

    public function unitControllerRejector()
    {
        return $this->belongsTo('App\User', 'unit_controller_rejected', 'id')->select($this->getUserVisibleAttributes());
    }
    
    public function saleManagerRejector()
    {
        return $this->belongsTo('App\User', 'sale_manager_rejected', 'id')->select($this->getUserVisibleAttributes());
    }

    public function attachments()
    {
        return $this->hasMany('App\ContractRequestAttachment');
    }

    public function paymentOption()
    {   
        return $this->belongsTo('App\PaymentOption');
    }

    // public function unitType()
    // {
    //     return $this->belongsTo('App\UnitType');
    // }

    public function unit()
    {
        return $this->belongsTo("App\Unit");
    }

    // End Model Relationship

    public function getUnitControllerStatusAttribute(){
        if (!(is_null($this->getOriginal('unit_controller_rejected')))){
            return "REJECTED";    
        }

        if (is_null($this->getOriginal('unit_controller_approved'))){
            return "PENDING";    
        } else { 
            return "APPROVED";
        }
    }

    public function getSaleManagerStatusAttribute(){
        if (!(is_null($this->getOriginal('sale_manager_rejected')))){
            return "REJECTED";    
        }
        
        if (is_null($this->getOriginal('sale_manager_approved'))){
            if (is_null($this->getOriginal("payment_option_id")) OR $this->getOriginal("other_discount_allowed") > 0 ) {
                return "PENDING";        
            } else {
                return "NOT_REQUIRED";
            }            
        } else { 
            return "APPROVED";
        }
    }

    public function getUnitControllerApprovedAttribute( $value )
    {
        if ( is_null($value) ){
            return 0;
        }
        return $value;
    }
    
    public function getUnitControllerApprovedDateAttribute( $value )
    {
        if ( is_null($value) ){
            return "";
        }
        return $value;
    }

    public function getSaleManagerApprovedAttribute( $value )
    {
        if ( is_null($value) ){
            return 0;
        }
        return $value;
    }
    
    public function getSaleManagerApprovedDateAttribute($value)
    {
        if ( is_null($value) ){
            return "";
        }
        return $value;
    }
    
    public function getUnitControllerRejectedDateAttribute($value) 
    {
        if ( is_null($value) ){
            return "";
        }
        return $value;
    }

    public function getSaleManagerRejectedDateAttribute($value) 
    {
        if ( is_null($value) ){
            return "";
        }
        return $value;
    }

    public function getDeletedAtAttribute($value)
    {
        if (is_null($value)){
            return "";
        }
        return $value;
    }

    public function getUpdatedAtAttribute($value)
    {
        if (is_null($value)){
            return "";
        }
        return $value;
    }

    public function getEditableAttribute()
    {
        return $this->isEditable();
    }

    public function isEditable() 
    {
        if ( Auth::check() ) {
            if ( Auth::user()->hasRole(UserRole::AGENT."|".UserRole::SALE_MANAGER."|".UserRole::SALE_TEAM_LEADER) ){
                if ( Auth::user()->hasRole(UserRole::SALE_MANAGER) ) {                
                    if ( is_null($this->getOriginal('unit_controller_rejected'))
                         AND is_null($this->getOriginal('sale_manager_approved'))
                         AND is_null($this->getOriginal('sale_manager_rejected')) ) {
                        
                        return true;
                    }
                }
                if ( is_null($this->getOriginal('unit_controller_approved')) 
                         AND is_null($this->getOriginal('unit_controller_rejected'))
                         AND is_null($this->getOriginal('sale_manager_approved'))
                         AND is_null($this->getOriginal('sale_manager_rejected')) ) {
                    
                    return true;
                }
            }
            return false;
            
        }
        return false;
    }

    public function isUpdatable()
    {
        if ( ! $this->isEditable() ) {
            return false;
        }

        if ( ! $this->isOwner() ) {
            return false;
        }

        return true;
    }

    public function isUnitControllerApproved()
    {
        return !is_null($this->getOriginal('unit_controller_approved'));
    }

    public function isSaleManagerApproved()
    {
        if ( $this->sale_manager_status  == "NOT_REQUIRED" || $this->sale_manager_status == "APPROVED") {
            return true;
        }
        return false;
        // return !is_null($this->getOriginal('sale_manager_approved'));
    }

    public function allowCreateContract()
    {
        return ( $this->isSaleManagerApproved() && $this->isUnitControllerApproved() );
    }

    public function getUnitControllerStatusCssTextStyle() 
    {
        if ( $this->unit_controller_status == 'APPROVED' ) 
        {
            return "text-success";
        } elseif ( $this->unit_controller_status == 'REJECTED' ) {
            return "text-danger";
        } else {
            return "text-secondary";
        }
    }

    public function getSaleManagerStatusCssTextStyle() 
    {
        if ( $this->sale_manager_status == 'APPROVED' || $this->sale_manager_status == 'NOT_REQUIRED' ) 
        {
            return "text-success";
        } elseif ( $this->sale_manager_status == 'REJECTED' ) {
            return "text-danger";
        } else {
            return "text-secondary";
        }
    }

    public function getUserVisibleAttributes()
    {
        return $this->userVisibleAttributes;
    }

    public function isOwner()
    {
        return $this->user_id == Auth::id() ;
    }

    public function getCustomer1GenderFormatted() {
        if ( $this->customer1_gender == 1 ){
            return "Male";
        } elseif ( $this->customer1_gender == 2 ) {
            return "Female";
        } else {
            return "N/A";
        }
    }

    public function getCustomer2GenderFormatted() {
        if ( $this->customer2_gender == 1 ){
            return "Male";
        } elseif ( $this->customer2_gender == 2 ) {
            return "Female";
        } else {
            return "N/A";
        }
    }
   
    public function getAgentGenderFormatted() {
        if ( $this->agent_gender == 1 ){
            return "Male";
        } elseif ( $this->agent_gender == 2 ) {
            return "Female";
        } else {
            return "N/A";
        }
    }

    // Query Scope 
    public function scopeOwnerOnly($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('unit_controller_approved')
                     ->whereNotNull('sale_manager_approved');
    }

    public function scopeOfSaleManagerStatus($query, $status = '') {
        switch ($status) {
            case 'pending':
                return $query->whereNull('sale_manager_approved')
                             ->whereNull('sale_manager_rejected');
                break;            
            case 'approved':
                return $query->whereNotNull("sale_manager_approved")
                             ->whereNull('sale_manager_rejected');
                break;
            case 'rejected':
                return $query->whereNotNull('sale_manager_rejected')
                             ->whereNull("sale_manager_approved");
                break;
            case '':
            case 'all':
            default:
                return $query;
                break;
        }
    }

    public function scopeOfUnitControllerStatus($query, $status = '') {
        switch ($status) {
            case 'pending':
                return $query->whereNull('unit_controller_approved')
                             ->whereNull('unit_controller_rejected');
                break;            
            case 'approved':
                return $query->whereNotNull("unit_controller_approved")
                             ->whereNull("unit_controller_rejected");
                break;
            case 'rejected':
                return $query->whereNotNull('unit_controller_rejected')
                             ->whereNull("unit_controller_approved");
                break;
            case '':
            case 'all':
            default:
                return $query;
                break;
        }
    }

    public function scopeOfCreatedBetweenDate($query, $from = null, $to = null)
    {
        $from   = is_null($from) ? \Carbon\Carbon::today()->firstOfMonth()->toDateString() : $from;
        $to     = is_null($to) ? \Carbon\Carbon::today()->lastOfMonth()->addHours(23)->addMinutes(59)->addSeconds(59)->toDateString() : \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $to." 23:59:59");

        return $query->whereBetween('created_at', [$from, $to]);
    }
    // End Query Scope 

    // Payment Schedule Helper Function 

    public function getUnitSoldPriceAfterDiscount() 
    {
        return $this->unit_sold_price - $this->discount_promotion - $this->other_discount_allowed;
    }

    public function getDiscountAmountByPaymentOption()
    {
        $payment_option = $this->paymentOption;
        $price_after_discount = $this->getUnitSoldPriceAfterDiscount();
        return ( $price_after_discount * $payment_option->special_discount / 100 );
    }
    
    public function getUnitSoldPriceAfterAllDiscount() 
    {
        $payment_option = $this->paymentOption;        
        if ( ! $payment_option ) {
            throw new \Exception("No Payment Option Selected.");
        } 
        $balance = $this->getUnitSoldPriceAfterDiscount();
        $balance = $balance - ( $balance * $payment_option->special_discount / 100);

        return $balance;
    }

    public function getFirstPaymentAmountPerMonth()
    {
        $payment_option = $this->paymentOption;
        return  $this->getUnitSoldPriceAfterAllDiscount() *  $payment_option->first_payment_percentage / 100;
    }

    public function getFirstPaymentTotalAmount()
    {
        $payment_option = $this->paymentOption;
        if ( ! $payment_option ) {
            throw new \Exception("No Payment Option Selected.");
        }

        if (!$payment_option->is_first_payment) {
            return 0;
        }

        return $this->getFirstPaymentAmountPerMonth() * $payment_option->first_payment_duration;
    }

    public function getPaymentDate() 
    {
        $payment_date = $this->deposited_date;
        
        if ( $this->deposited_date->day > $this->payment_day ) {
            $payment_date = \Carbon\Carbon::createMidnightDate($this->deposited_date->year,$this->deposited_date->month + 1, $this->payment_day);
        } else {
            $payment_date = \Carbon\Carbon::createMidnightDate($this->deposited_date->year,$this->deposited_date->month, $this->payment_day);
        }

        return $payment_date;
    }

    public function firstPaymentCollection() 
    {
        $payment_option = $this->paymentOption;      

        if ( !$payment_option->is_first_payment ) {
            return [];
        }

        $balance = $this->getUnitSoldPriceAfterAllDiscount();
        $first_payment_duration = $payment_option->first_payment_duration;
        $first_payment_percentage = $payment_option->first_payment_percentage;    

        $result = [] ;
        $first_row = [
            "payment_date" => $this->deposited_date->toDateString(),
            "beginning_balance" => $balance,
            "amount_to_pay" => $this->deposited_amount,
            "ending_balance" => ($balance - $this->deposited_amount),
            "note" => "Deposited Amount"
        ];      
        $result[0] = $first_row;

        $payment_date = $this->getPaymentDate();

        $monthly_payment_amount = $balance * $payment_option->first_payment_percentage / 100;        
        for ($i = 1 ; $i <= $payment_option->first_payment_duration ; $i++) {
            if ($i==1) {
                $row = [
                    "payment_date" => $payment_date->toDateString(),
                    "beginning_balance" => $balance - $this->deposited_amount,
                    "amount_to_pay" => $monthly_payment_amount - $this->deposited_amount,
                    "ending_balance" => ($balance = $balance - $monthly_payment_amount),
                    "note" => \App\Helpers\NumberFormat::str_ordinal($i,true)." Month Payment"
                ];
            } else {              
                $row = [
                    "payment_date" => $payment_date->toDateString(),
                    "beginning_balance" => $balance,
                    "amount_to_pay" => $monthly_payment_amount,
                    "ending_balance" => ($balance = $balance - $monthly_payment_amount),
                    "note" => \App\Helpers\NumberFormat::str_ordinal($i,true)." Month Payment"
                ];
            }           
            array_push($result,  $row);
            if ( $this->payment_day == 31) {
                $payment_date->modify("last day of next month");
            } else {
                if ( $payment_date->month == 1 AND $this->payment_day >=28) {
                    $payment_date->modify('last day of next month');
                }else {
                    $payment_date = \Carbon\Carbon::createMidnightDate($payment_date->year, $payment_date->month + 1, $this->payment_day);    
                }
            }
        } 
        return $result;  
    }

    public function loanPaymentCollection() 
    {
        $payment_option = $this->paymentOption;
        if ( ! $payment_option ) {
            throw new \Exception("No Payment Option Selected.");
        }

        $beginning = $this->getUnitSoldPriceAfterAllDiscount() - $this->getFirstPaymentTotalAmount();       
        $number_of_payment = $payment_option->loan_duration;
        $interest_rate = $payment_option->interest;
        $payment_date = $this->getPaymentDate()->addMonthsNoOverflow($payment_option->first_payment_duration);      
        $montly_payment = $this->pmt($interest_rate, $number_of_payment, $beginning);
        $result = [] ;
        for ($i = 1 ; $i <= $number_of_payment ; $i++) {            
            $interest = $beginning * $interest_rate / 100;
            $principle = $montly_payment - $interest;
            $row = [
                "payment_date" => $payment_date->toDateString(),
                "beginning_balance" => $beginning,
                "monthly_payment" => $montly_payment,
                "principle" => $principle,
                "interest" => $interest,
                "ending_balance" => ($beginning = $beginning - $principle)
            ];
            array_push($result,  $row);
            if ( $this->payment_day == 31) {
                $payment_date->modify("last day of next month");
            } else {
                if ( $payment_date->month == 1 AND $this->payment_day >=28) {
                    $payment_date->modify('last day of next month');
                }else {
                    $payment_date = \Carbon\Carbon::createMidnightDate($payment_date->year, $payment_date->month + 1, $this->payment_day);    
                }
            }            
        } 
        return $result;  
    }

    private function pmt($interest, $months, $loan) 
    {
        if ($interest == 0) {
            return $loan / $months;
        }
        $months = $months;
        $interest = $interest / 100;
        $amount = $interest * -$loan * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
        return number_format($amount, 2);
    }
    // End Payment Schedule Helper Function 
}

 