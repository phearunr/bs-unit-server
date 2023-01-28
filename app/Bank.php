<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
	use SoftDeletes;

	protected $fillable = ['name', 'short_name', 'account_name', 'account_number'];
	
	protected $dates = ['deleted_at', 'updated_at', 'created_at'];

	// << Model Relationship

	// >>
}
