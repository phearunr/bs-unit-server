<?php

namespace App;

use App\PurchaseRequest;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetail extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'item_code',
		'description',
		'unit_of_measurement',
		'quantity',
		'expected_arrival_date', 
		'purpose',
		'staff_id'
	];

	protected $dates = [ 'expected_arrival_date' ];

	public function purchaseRequest()
	{
		return $this->belongsTo(PurchaseRequest::class);
	}

}
