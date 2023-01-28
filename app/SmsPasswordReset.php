<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsPasswordReset extends Model
{
    protected $fillable = [
    	"phone_number",
    	"verification_code",    	
    	"created_at"
    ];

    protected $hidden = ['token'];
	
	protected $dates = ["created_at"];

	protected $keyType = 'string';

	protected $primaryKey = 'phone_number';

	public $timestamps = false;

	public $incrementing = false;
}
