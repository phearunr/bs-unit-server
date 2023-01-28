<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountPromotionItem extends Model
{
	protected $fillable = [
		'discount_promotion_id', 'unit_type_id'
	];

	public $timestamps = false;

	// Model Relationship	
	public function discountPromotion()
	{
		return $this->belongsTo('App\DiscountPromotion');
	}

	public function unitType()
	{
		return $this->belongsTo("App\UnitType");
	}
	// End Model Relationship
}
