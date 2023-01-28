<?php

namespace App;

use App\Unit;
use Illuminate\Database\Eloquent\Relations\Pivot;
use OwenIt\Auditing\Contracts\Auditable;

class UnitConstructionProcedure extends Pivot implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected static function boot()
    {
        parent::boot();

        static::saving( function ($model) {
            if ( $model->actual_completed_at ) {
                throw new \Exception( "Data could not be edited when the construction is completed.");
            }

            if ( $model->getOriginal('estimate_completed_at') != null 
                AND $model->isDirty('estimate_completed_at') ) {
                
                throw new \Exception('Estimate Completed Date can not be changed once it contain value');
            }

            if (  $model->progress < $model->getOriginal('progress') ) {
                throw new \Exception('Data could not be updated when the new value is less than the old value.');
            }           
            
            //Assign the actual_completed_at attribute when all construction is 100
            if ( $model->progress == 100 ) {
                $model->actual_completed_at = now();
            }

           
        });

        static::saved( function ($model) {
            // caculate avg progress and save to construction_overall_progress attribute
            $unit = Unit::where('id', $model->unit_id)->without(['action','action.createdBy','unitType','unitType.project'])->first();
            if ( $unit ) {
                $unit->construction_overall_progress = $unit->constructionProcedures()->avg('progress');
                $unit->save();
            }
        });
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit_construction_procedures';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

	protected $fillable = ['progress', 'estimate_completed_at', 'actual_completed_at', 'order'];
	
	protected $dates = ['estimate_completed_at', 'actual_completed_at', 'updated_at', 'created_at'];

    /**
     * Auditable events.
     *
     * @var array
     */
    protected $auditEvents = [
        'created',
        'updated'
    ];

	public function createdBy()
    {
    	return $this->belongsTo('App\User', "user_id", "id")->select(\App\User::getCreatedByFields());
    }

    /**
     * Get the Progress.
     *
 	 */
    public function getProgressAttribute($value)
    {
        return $value * 100;
    }

    /**
     * Set the Progress.
     *
     * @param  integer $value
     * @return void
     */
    public function setProgressAttribute(float $value)
    {
        $this->attributes['progress'] = $value / 100;
    }
}
