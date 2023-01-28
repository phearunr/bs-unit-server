<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitHandover extends Model
{
    protected $fillable = [
    	'unit_id',
    	'status',
    	'customer_name',
    	'last_posting_date',
    	'last_payment_date',
    	'late_payment_month',
    	'net_selling_price',
    	'ending_balance',
    	'total_payment',
    	'contract_signed_date',
    	'contract_deadline_date',
    	'late_deadline_month',
    ];

    protected $dates = [
    	'last_posting_date',
    	'last_payment_date',
    	'contract_signed_date',
    	'contract_deadline_date',
    	'created_at',
    	'updated_at'
    ];

    protected $appends = [ 
        'late_payment_color_code', 
        'late_payment_code', 
        'late_deadline_code'
    ];

	// Attribute Mutator
    public function getLatePaymentColorCodeAttribute()
    {
    	if ( $this->late_payment_month <= 0 ) {
    		return "#f7b267";
    	} elseif ( $this->late_payment_month >= 7 ) {
    		return "#f25c54";
    	} elseif ( $this->late_payment_month >= 4 ) {
    		return "#f27059";
    	} elseif ( $this->late_payment_month > 0 ) {
    		return "#f79d65";
    	} else {
    		return "#ccc";
    	}
    }

    public function getLatePaymentCodeAttribute()
    {
        if ( $this->late_payment_month <= 0 ) {
            return "PAYOFF";
        } elseif ( $this->late_payment_month >= 7 ) {
            return "LATE_7_I";
        } elseif ( $this->late_payment_month >= 4 ) {
            return "LATE_4_6";
        } elseif ( $this->late_payment_month > 0 ) {
            return "LATE_0_3";
        } else {
            return "N/A";
        }
    }

    public function getLateDeadlineCodeAttribute()
    {

        if ( is_null($this->late_deadline_month) ) {
            return 'N/A';
        }

    	if ( $this->late_deadline_month >= 7 ) {
    		return "A";
    	} elseif ( $this->late_deadline_month >= 1 ) {          
    		return "B";
    	} elseif ( $this->late_deadline_month >= -6 ) {
    		return "C";
    	} elseif ( $this->late_deadline_month >= -12 ) {
    		return "D";
    	} elseif ( $this->late_deadline_month <= -13 ) {
    		return "E";
    	} else {
    		return 'N/A';
    	} 
    }
	// End Attribute Mutator

	// Model Relationship
    public function unitHandoverBatch() 
    {
    	return $this->belongsTo('App\UnitHandoverBatch', 'unit_handover_batch_id', 'id');
    }

    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }
	// End Model 
}
