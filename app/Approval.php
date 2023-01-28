<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
	protected $fillable = [
		'user_id',
		'status',
		'action_true',
		'action_false',
		'previous_approval_id',
		'next_approval_id'
	];

	protected $dates = [ 'actioned_at' ];
	
	public $timestamps = false;

	// Computed Property
	public function getStatusLabelAttribute()
	{
		if ( is_null($this->action) ) {
			return 'PENDING '.$this->status;			
		}

		return $this->action ? $this->action_true : $this->action_false;
	}

	// End Computed Property

	// Model Relationship
    public function approvable()
    {
        return $this->morphTo();
    }

    public function approver()
    {
    	return $this->belongsTo('App\User', 'user_id', "id")->select(['id', 'name', 'avatar', 'signature_image', 'email', 'phone_number']);
    }

   	// End Model Relationship

   	public function approved()
   	{
   		return $this->action == true;
   	}
}
