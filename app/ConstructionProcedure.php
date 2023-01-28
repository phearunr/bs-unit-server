<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class ConstructionProcedure extends Model
{
    use SoftDeletes, EagerLoadPivotTrait;

    protected $fillable = ['code', 'name', 'name_km'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    // Model Relationship
    public function createdBy()
    {
    	return $this->belongsTo('App\User', 'user_id', "id")->select(\App\User::getCreatedByFields());
    }

    public function units()
    {
    	return $this->belongsToMany('App\Unit', 'units');
    }
    // End Model Relationship
}