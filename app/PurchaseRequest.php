<?php

namespace App;

use Carbon\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PurchaseRequest extends Model implements HasMedia
{
    use HasMediaTrait;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('recent', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }  

    protected $fillable = [
    	'purchase_request_project_id',
    	'department_id',
    	'mrp_no',
    	'shipment_contact_name',
    	'shipment_contact_number',
    	'shipment_address_line1',
    	'shipment_address_line2',
    	'remark'
    ];

    protected $with = [ 'createdBy', 'createdBy.department' ];

    protected $appends = [ 'code' ];

    protected $dates = [ 'created_at', 'updated_at' ];

    public function getCodeAttribute()
    {        
        $formatted_id = $this->id < 1000 ? str_pad($this->id, 3, '0', STR_PAD_LEFT) : $this->id;       
        $department_code = $this->createdBy->department ? $this->createdBy->department->short_code : "NUL";
        
        return "PR-{$department_code}-{$this->created_at->format('Ym')}-{$formatted_id}";
    }

    public function department()
    {
        return  $this->belongsTo('App\Department');
    }

    public function purchaseRequestProject()
    {
        return  $this->belongsTo('App\PurchaseRequestProject');
    }

    public function purchaseRequestDetails()
    {
    	return $this->hasMany('App\PurchaseRequestDetail');
    }

    public function createdBy()
    {
    	return $this->belongsTo('App\User', 'user_id', "id")->select(['id', 'name', 'avatar', 'signature_image','department_id', 'position', 'phone_number']);
    }

    public function approval()
    {
        return $this->belongsTo('App\Approval');
    }

    public function approvals()
    {
        return $this->morphMany('App\Approval', 'approvable', 'model_type', 'model_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // End Model Relationship

    // Model Query Scope
    public function scopeOwner($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function scopePendingMyApproval($query)
    {
        return $query->whereHas('approval', function ($sub_query) {
            $sub_query->where('user_id', Auth::user()->id)
            ->whereNull('action');
        });
    }

    public function scopeCreatedBetweenDate($query, $from = null, $to = null)
    {   
        $date_format = config("app.php_date_format");

        $from   = is_null($from) ? Carbon::today()->firstOfMonth() : Carbon::createFromFormat($date_format, $from)->startOfDay();
        $to     = is_null($to) ? Carbon::today()->lastOfMonth()->addHours(23)->addMinutes(59)->addSeconds(59) : Carbon::createFromFormat($date_format.' H:i:s', $to." 23:59:59");
        return $query->whereBetween('created_at', [$from, $to]);
    }
    // End Model Query Scope


    // hasMediaTrait resize image
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->fit(Manipulations::FIT_FILL, 80, 80)
              ->nonQueued();
        
        $this->addMediaConversion('8x6')
             ->width(301)
             ->height(226);
        
        $this->addMediaConversion('16x9')
             ->width(466)
             ->height(262);
    }

    public function applyApprovalWorkflow()
    {
        $work_flows = \App\ApprovalWorkflow::modelType($this->getMorphClass())->get();

        if ( $work_flows->count() == 0 ) {
            throw new \Exception('There is no approval workflow for this resource.');
        }

        try {            
            DB::beginTransaction();
            
            $previous = null;

            foreach($work_flows as $workflow) {
                $new = $this->approvals()->create([
                    'user_id' => $workflow->user_id,
                   // 'user_id' => $request->user_id,
                    'status' =>  $workflow->status,
                    'action_true' =>  $workflow->action_true,
                    'action_false' =>  $workflow->action_false,
                    'previous_approval_id' => is_null($previous) ? null : $previous->id,
                ]);

                if (is_null($previous)) {
                    $this->status = $new->status_label;
                    $this->approval_id = $new->id;
                    $this->save(); 
                } else {
                    $previous->next_approval_id = $new->id;
                    $previous->save();
                }

                $previous = $new;
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
