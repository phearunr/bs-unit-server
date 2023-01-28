<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitHandoverBatch extends Model
{
    protected $fillable = [ 'data_updated_on' ];

    protected $dates = ['created_at', 'updated_at', 'data_updated_on'];

    // Model Relationship
    public function createdBy()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id')->select(\App\User::getCreatedByFields());
    }

    public function unitHandover()
    {
    	return $this->hasMany('App\UnitHandover');
    }
    // End Model Relationship
}
