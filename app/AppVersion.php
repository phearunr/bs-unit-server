<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AppVersion extends Model
{

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sortByCreatedAt', function (Builder $builder) { 
            $builder->orderBy('created_at', 'DESC');         
           
        });
    }

    protected $fillable = [
    	"user_id", 
    	"platform",
    	"build",
    	"version",
    	"forced_update",
    	"description",
    	"released_at"
    ];
	
	protected $dates = ["released_at", "updated_at", "created_at"];

    protected $casts = [
        'forced_update' => 'boolean',
    ];

    protected static $platforms = ['ios', "android" ];


    // Model Relationship
    public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', "id")->select(\App\User::getCreatedByFields());
    }
    // End Model Relationship

    // Query Scope
    public function scopeLatestBuild($query, $platform)
    {
        if ( !in_array(strtolower($platform), array_map('strtolower',self::$platforms)) ) {
            throw new \UnexpectedValueException("The [platform]'s value is invalid", 0);            
        }
        return $query->where("platform",'like', '%'.$platform.'%')->orderBy('build','DESC');
    }

    // End Query Scope

    // Attributes Mutator

    // End Attributes Mutator
    public function getPlatformAttribute($value)
    {
       return strtolower($value);
    }
    public function setPlatformAttribute($value)
    {
        $this->attributes['platform'] = strtolower($value);
    }
    // Helpers function 
    public function getForcedUpdateHtml()
    {
        return $this->forced_update ? 
               '<i class="fas fa-check-circle text-success"></i>' : 
               '<i class="fas fa-times-circle text-danger"></i>';
    }
    // End Helpers function 

    public static function getPlatforms()
    {
        return self::$platforms;
    }
}