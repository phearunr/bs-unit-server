<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{   
    use SoftDeletes;

    protected $perPage = 30;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sortByName', function (Builder $builder) { 
            $builder->orderBy('name_en', 'asc');         
           
        });
    }

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

   	/**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'user_id',
        'company_id',
        'is_published',
        'name',
        'name_en',
        'name_zh',
        'address',
        'address_en',
        'address_zh',
        'short_code',
        'nav_company_code',
        'sale_representative_id',
        'bank_id',
        'logo_url',
        'feature_image_url',
        'master_plan_url'
    ]; 

    protected $hidden = [
        'address',
        'address_en',
        'sale_representative_id',
        'bank_id'
    ];

    protected $casts = [
        'is_published' => "boolean"
    ];

    // Model Relationship go here

    public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', "id")->select(['id', 'name', 'avatar', 'phone_number']);
    }

    public function unitTypes() {
        return $this->hasMany('App\UnitType');
    }

    public function units()
    {
        return $this->hasManyThrough('App\Unit', 'App\UnitType');
    }

    public function saleRepresentative() {
        return $this->belongsTo("App\SaleRepresentative", "sale_representative_id", "id");
    }

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
    
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function unitHandoverBatch()
    {
        return $this->belongsTo('App\UnitHandoverBatch');
    }

    public function managedUsers()
    {
        return $this->morphToMany(
            'App\User', 
            'model',
            'user_manages_constructions', 
            'model_id',
            'user_id'
        );
    }
    
    public function zones()
    {
        return $this->hasMany('App\Zone');
    }
    // End Model Relationship     
 
    public function getLogoUrlAttribute($value)
    {
        return is_null($value) ? null : asset('storage/'.$value);
        if ( is_null($value) OR trim($value) == "" ){
            return asset('img/no_logo.png');
        }

        return asset('storage/'.$value);
    }    

    public function deleteLogoUrl()
    {
        Storage::disk('public')->delete($this->getOriginal('logo_url'));
    }

    public function getFeatureImageUrlAttribute($value)
    {
        if ( is_null($value) OR trim($value) == "" ){
            return asset('img/no_image_preview.jpg');
        }
        return asset('storage/'.$value);
    }

    public function deleteFeatureImageUrl()
    {
        Storage::disk('public')->delete($this->getOriginal('feature_image_url'));
    }

    public function getMasterPlanUrlAttribute($value) 
    {
        return is_null($value) ? null : asset('storage/'.$value);
    }

    public function deleteMasterPlanUrl()
    {
        Storage::disk('public')->delete($this->getOriginal('master_plan_url'));
    }

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

    public function scopeOfPublished($query, $is_published = true)
    {
        return $query->where('is_published', $is_published);
    }

    public function scopeSearch($query, $term = null)
    {
        if ( !empty($term) ) {          
            $query = $query->where('name' , 'LIKE', '%'.$term.'%')
                           ->orWhere('name_en' , 'LIKE', '%'.$term.'%')
                           ->orWhere('short_code' , 'LIKE', '%'.$term.'%');
        }
        return $query;
    }
    // End Query Scope

    // helper function 
    public function getPublishedHtmlStatus()
    {
        if ( $this->is_published ) {
            return '<span class="text-success"><i class="fas fa-check-circle"></i></span>';
        } else {
            return '<span class="text-danger"><i class="fas fa-times-circle"></i></span>';
        }
    }
    // end helper
}
