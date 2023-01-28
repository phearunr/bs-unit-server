<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $fillable = ['name', 'short_code'];

	public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', "id")->select(['id', 'name', 'avatar', 'phone_number']);
    }
}
