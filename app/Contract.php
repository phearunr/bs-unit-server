<?php

namespace App;

use App\Helpers\NumberFormat;
use App\Helpers\ContractStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Contract extends Model
{
	use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('recent', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }    

	protected $fillable = [
		"user_id",
		"unit_contract_request_id",
		"customer1_name",
		"customer1_gender",
		"customer1_birthdate",
        "customer1_nationality",
		"customer1_nid",
		"customer1_nid_issued_date",
		"customer2_name",
		"customer2_gender",
		"customer2_birthdate",
        "customer2_nationality",
		"customer2_nid",
		"customer2_nid_issued_date",
		"customer_phone_number",
		"customer_phone_number2",
        "customer_address_line1",
        "customer_address_line2",
		"customer_house_no",
		"customer_street",
		"customer_phum",
		"customer_commune",
		"customer_district",
		"customer_city",
        "sale_representative_id",
        "agent_id",
		"agent_remark",	
		"unit_id",
        "service_fee",
		"unit_sold_at",
		"signed_at",
		"unit_remark",
		"unit_sale_price",
		"discount_promotion",
		"other_discount_allowed",
		"deposited_amount",
		"deposited_at",
        "start_payment_date",
        "payment_option_id",
		"loan_duration",
		"interest",
		"special_discount",
		"is_first_payment",
		"first_payment_duration",
		"first_payment_percentage",
        "first_payment_amount",
        "loan_result_rounding",
        "start_payment_number",        
        "annual_management_fee",
        "contract_transfer_fee",
        "management_fee_per_square",
        "deadline",
        "extended_deadline",
        "title_clause_kh",
        "management_service_kh",
        "equipment_text"
	];

    protected $dates = [
        'customer1_birthdate',
        'customer1_nid_issued_date',
        'customer2_birthdate',
        'customer2_nid_issued_date',
        'signed_at',
        'deadline_at',
		'created_at', 
		'updated_at',
		'deleted_at',
		'unit_sold_at',
		'deposited_at',
        'start_payment_date',
        'actioned_at'
    ];
    
    protected $appends = [ 'deadline_at' ];

    protected $casts = [
        'loan_result_rounding' => 'boolean'
    ];

    /**
     * The User's attributes that will be return on this's model's attribute that reference to User Model.
     *
     * @var array
     */
    protected $userVisibleAttributes = ['id', 'name', 'avatar', 'phone_number','gender', 'managed_by'];

	// Model Relationship
	public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', 'id')->select($this->getUserVisibleAttributes());
    }

    public function saleTeamLeader()
    {
        return $this->belongsTo('App\User', 'sale_team_leader_id', 'id')->select($this->getUserVisibleAttributes());
    }

	public function attachments()
    {
        return $this->hasMany('App\ContractAttachment');
    }

    public function unit()
    {
        return $this->belongsTo("App\Unit")->withTrashed();
    }

    public function agent()
    {
        return $this->belongsTo('App\User', 'agent_id', 'id')->select($this->getUserVisibleAttributes());
    }

    public function unitContractRequest()
    {
        return $this->belongsTo('App\UnitContractRequest', 'unit_contract_request_id', 'id');
    }

    public function actionedBy()
    {
        return $this->belongsTo('App\User', 'actioned_user_id', 'id')->select($this->getUserVisibleAttributes());
    }

    public function saleRepresentative()
    {
        return $this->belongsTo('App\SaleRepresentative');
    }

    public function paymentOption()
    {
        return $this->belongsTo('App\PaymentOption', 'payment_option_id', 'id');
    }
	// End Model Relationship

    // Query Scope
    public function scopeOfCreatedBetweenDate($query, $from = null, $to = null)
    {   
        $date_format = config("app.php_date_format");

        $from   = is_null($from) ? Carbon::today()->firstOfMonth() : Carbon::createFromFormat($date_format, $from)->startOfDay();
        $to     = is_null($to) ? Carbon::today()->lastOfMonth()->addHours(23)->addMinutes(59)->addSeconds(59) : Carbon::createFromFormat($date_format.' H:i:s', $to." 23:59:59");
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeStatus($query, $status) 
    {
        if ( is_array($status) ) {
            return $query->whereIn('status', $status);
        }

        return $query->where('status', $status);
    }

    public function scopeDeadline($query, $day) 
    {          
        $raw =  'DATEDIFF(DATE_ADD(signed_at, INTERVAL (deadline + extended_deadline) MONTH), CURDATE()) <= ?';
        return $query->whereRaw($raw, [$day]);
    }
    // End Query Scope

	public function getUnitSoldPriceAfterDiscount() 
    {
        return $this->unit_sale_price - $this->discount_promotion - $this->other_discount_allowed;
    }

    // << Appended Attribute
    public function getDeadlineAtAttribute()
    {       
        return $this->signed_at->addMonths( ($this->deadline ?? 0) + ($this->extended_deadline ?? 0) );
    }
    // >>

    // << KM language helper
    public function getUnitSalePriceAfterDiscountKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber(number_format($this->getUnitSoldPriceAfterDiscount()));    
    }

    public function getUnitSalePriceAfterDiscountInWordKmAttribute()
    {
        return numfmt_create('km', \NumberFormatter::SPELLOUT)->format($this->getUnitSoldPriceAfterDiscount());       
    }

    public function getContractTransferFeeKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->contract_transfer_fee);
    }

    public function getContractTransferFeeInWordKmAttribute()
    {
        return numfmt_create('km', \NumberFormatter::SPELLOUT)->format($this->contract_transfer_fee); 
    }

    public function getCustomerPhoneNumberKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->customer_phone_number);
    }

    public function getCustomerPhoneNumber2KmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->customer_phone_number2);
    }

    public function getManagementFeePerSquareKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->management_fee_per_square);
    }

    public function getManagementFeePerSquareInWordKmAttribute()
    {       
        return numfmt_create('km', \NumberFormatter::SPELLOUT)->format($this->management_fee_per_square);
    }

    public function getDeadlineKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->deadline);
    }

    public function getDeadlineInWordKmAttribute()
    {
        return numfmt_create('km', \NumberFormatter::SPELLOUT)->format($this->deadline);
    }

    public function getExtendedDeadlineKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->extended_deadline);
    }

    public function getExtendedDeadlineInWordKmAttribute()
    {
        return numfmt_create('km', \NumberFormatter::SPELLOUT)->format($this->extended_deadline);
    }

    public function getTotalManagmentFeeKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->getTotalManagementFee());
    }

    public function getTotalManagementFeeInWordKmAttribute()
    {
        return numfmt_create('km', \NumberFormatter::SPELLOUT)->format($this->getTotalManagementFee());
    }

    public function getAnnualManagementFeeKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->annual_management_fee);
    }

    public function getAnnualManagementFeeInWordKmAttribute()
    {
        return NumberFormat::covertUsdToKhmerWordFloat($this->annual_management_fee);
    }
    // >>

    // << Zh helper
    public function getUnitSalePriceAfterDiscountZhAttribute()
    {   
        return number_format($this->getUnitSoldPriceAfterDiscount());
    }

    public function getUnitSalePriceAfterDiscountInWordZhAttribute()
    {
        return numfmt_create('zh', \NumberFormatter::SPELLOUT)->format($this->getUnitSoldPriceAfterDiscount());
    }

    public function getTotalManagementFeeInWordZhAttribute()
    {
        return numfmt_create('zh', \NumberFormatter::SPELLOUT)->format($this->getTotalManagementFee());
    }

    // >>

    public function getformattedIdAttribute()
    {
       return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getDiscountAmountByPaymentOption()
    {        
        $price_after_discount = $this->getUnitSoldPriceAfterDiscount();
        return ( $price_after_discount * $this->special_discount / 100 );
    }

    public function getUnitSoldPriceAfterAllDiscount() 
    {       
        $balance = $this->getUnitSoldPriceAfterDiscount();
        $balance = $balance - ( $balance * $this->special_discount / 100);
        return $balance;
    }

    public function getTotalFirstPaymentAmount()
    {
    	$unit_price_after_all_discount = $this->getUnitSoldPriceAfterAllDiscount();
        $total_down_payment = 0; 
    	if ( $this->is_first_payment ) {
            if ( $this->first_payment_percentage && $this->first_payment_percentage > 0 ) {
                $total_down_payment = $unit_price_after_all_discount  * $this->first_payment_duration * $this->first_payment_percentage / 100;
            } else {
                $total_down_payment = $this->first_payment_duration * $this->first_payment_amount;
            }
    	
    	} 
    	return $total_down_payment;
    }

    public function getPrincipalAmount() 
    {
        return $this->getUnitSoldPriceAfterAllDiscount() - $this->getTotalFirstPaymentAmount();
    }

    public function getTotalManagementFee()
    {
        return number_format( ( $this->unit->building_area ?? 0 ) * $this->management_fee_per_square , 2);
    }

    public function isCancellable()
    {
        return ( $this->status != ContractStatus::CANCELLED );
    }

    public function isVoidable()
    {
        return ( $this->status != ContractStatus::VOIDED );
    }

    public function isEditable()
    {
        return ( $this->status == ContractStatus::OPEN );
    }

    public function isOwner($user_id) {
        return ($this->user_id == $user_id);
    }

    public function isAgent($user_id) 
    {
        return ($this->agent_id == $user_id);
    }

    public function setAction($action_status, $action_reason = '') 
    {
        $this->status = $action_status;
        $this->reason = $action_reason;
        $this->actioned_user_id = Auth::user()->id;
        $this->actioned_at = now();   
    }

    public function getStatusHtml()
    {
        $result = "";
        switch ($this->status) {
            case ContractStatus::OPEN:
                $result = '<span class="badge badge-pill badge-secondary">';
                break;         
            case ContractStatus::CANCELLED:
                $result = '<span class="badge badge-pill badge-danger">';
                break;
            case ContractStatus::VOIDED:
                $result = '<span class="badge badge-pill badge-danger">';
                break;
            case ContractStatus::RELEASED:
                $result = '<span class="badge badge-pill badge-primary">';
                break;    
            default:
                $result = '<span class="badge badge-pill badge-secondary">';
                break;
        }

        return $result.$this->status."</span>";
    }

    public function getActionType()
    {
        return $this->status;
    }

    // convert the eloquent and relation Attactment to Array
    public function getAttachmentsArrayWithTypeKey() 
    {
    	$attachments = $this->attachments;

    	$group_with_Type_key = $attachments->mapWithKeys(function ($item, $key){
    		return [$item['type'] => $item];
    	});

    	return $group_with_Type_key->toArray();
    }

    public function getUserVisibleAttributes()
    {
        return $this->userVisibleAttributes;
    }

}	
