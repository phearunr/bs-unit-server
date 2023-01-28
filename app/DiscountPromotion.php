<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class DiscountPromotion extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
           $model->percentage = 0;
        });

        static::addGlobalScope('sortByStartDate', function (Builder $builder) { 
            $builder->orderBy('start_date', 'desc');         
           
        });
    }

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'amount',
        'percentage'
    ]; 

    // Model Relationship go here
    public function discountPromotionItems()
    {
        return $this->hasMany('App\DiscountPromotionItem');
    }

    public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', "id")->select(User::getCreatedByFields());
    }

    public function items() {
        return $this->belongsToMany('App\UnitType', "discount_promotion_items","discount_promotion_id","unit_type_id");
    }
    // End Model Relationship

    public function isEffective()
    {
        return  today()->greaterThanOrEqualTo($this->start_date) 
                AND 
                today()->lessThanOrEqualTo($this->end_date) ;
    }

    public function effectiveHtmlText()
    {
        if ( $this->isEffective() ) {
            return '<span class="text-success"><i class="fas fa-check-circle"></i></span>';
        } else {
            return '<span class="text-danger"><i class="fas fa-times-circle"></i></span>';
        }
    }
}
