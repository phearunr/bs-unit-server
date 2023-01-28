<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class PaymentOption extends Model
{
    use SoftDeletes;


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('unit_type_id', 'asc');
            $builder->orderBy('name', 'asc');
        });
    }

	/**
     * The attributes that need to be cast to Carbon DateTime Object
     *
     * @var array
    */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [ 
        'user_id', 
        'unit_type_id', 
        'name',
        'deposit_amount',
        'loan_duration', 
        'interest', 
        'special_discount',
        'is_first_payment',
        'first_payment_duration',
        'first_payment_percentage'
    ];

    protected $casts = [
        'is_first_payment' => 'boolean',
        
    ];

    // Model Relationship go here
    public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', "id")->select(['id', 'name', 'avatar', 'phone_number']);
    }

    public function unitType() {
        return $this->belongsTo('App\UnitType')->select(['id','project_id','name','short_code']);
    }
    // End Model Relationshipa   

    // Query Scope
    public function scopeOfStatus($query, $status = '' ) 
    {
        switch ($status) {
            case 'all':
                return $query->withTrashed();                
                break;
            case 'removed': 
                return $query->onlyTrashed();                     
                break;
            case 'active':
                return $query;
            default:   
                return $query->withTrashed();
                break;
        }     
    }
    // End Query Scope
}   
