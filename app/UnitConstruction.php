<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UnitConstruction extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;

	protected static function boot()
    {
    	parent::boot();

    	static::saving( function ($model) {
    		if ( $model->actual_completed_at ) {
				throw new \Exception( "Data could not be edited when the construction is completed.");
			}

			if ( $model->id != null 
				AND $model->isDirty('estimate_completed_at') ) {
				
				throw new \Exception('Estimate Completed Date can not be changed once it contain value');
			}

			$dirty = $model->getDirty();

			foreach( $dirty as $key => $val ) {
				if ( $val < $model->getOriginal($key) ) { 
					throw new \Exception('Data could not be updated when the new value is less than the old value.');
				}
			}
			
			//Assign the actual_completed_at attribute when all construction is 100
			if ( $model->foundation == 100 
    			AND $model->structure  == 100
    			AND $model->finishing  == 100
    			AND $model->infrastructure  == 100
    			AND $model->mep  == 100
    		) {
    			$model->actual_completed_at = now();
    		}
    	});
    }

	protected $fillable = [
		'foundation',
		'structure',
		'finishing',
		'infrastructure',
		'mep',
		'estimate_completed_at'
	];

	/**
     * Auditable events.
     *
     * @var array
     */
    protected $auditEvents = [
        'updated',
    ];

	protected $dates = ['estimate_completed_at', 'actual_completed_at', 'created_at', 'updated_at'];

	// Model Relationship
	public function createdBy() 
	{	
		return $this->belongsTo('App\User', 'user_id', 'id')->select(User::getCreatedByFields());
	}

	public function unit()
	{
		return $this->belongsTo('App\Unit', "unit_id", "id")->withTrashed();
	}

	// End Model Relationship
}
