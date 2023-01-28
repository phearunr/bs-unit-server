<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $fillable = ['user_id', 'field_name', 'old_value', 'new_value'];
	
	protected $dates = ['updated_at', 'created_at'];

	public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')
                    ->select(['id','name','avatar','phone_number']);
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function trackable()
    {
        return $this->morphTo();
    }
}
