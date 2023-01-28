<?php

namespace App;

use App\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zone extends Model
{
    protected $fillable = [
        'project_id',
        'name'
    ];

    protected $dates = ['created_at', 'updated_at'];

    // Model Relationship
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function units() 
    {
    	return $this->hasMany(Unit::class);
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
    // End Model Relationship

}
