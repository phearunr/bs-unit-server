<?php

namespace App;

use App\Helpers\UnitContractStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UnitContractRequest extends Model
{   
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sortByCreatedAt', function (Builder $builder) { 
            $builder->orderBy('created_at', 'DESC');         
           
        });
    }

    protected $fillable = [
    	'user_id',
    	'unit_id',
    	'unit_deposit_request_id',
        'status',
        'remark',
        'signed_at',
        'start_payment_date',
    ];

    protected $dates = [
    	'created_at',
    	'updated_at',
    	'deleted_at',
    	'signed_at',
    	'start_payment_date',
    	'actioned_at'
    ];

    protected $appends = [
        'contract_pdf_url'
    ];

    /**
     * The User's attributes that will be return on this's model's attribute that reference to User Model.
     *
     * @var array
     */
    protected $userVisibleAttributes = ['id', 'name', 'avatar', 'phone_number', 'managed_by'];

   	// Model Relationship
    public function unit()
    {
    	return $this->belongsTo("App\Unit")->withTrashed();
    }

    public function unitDepositRequest()
    {
    	return $this->belongsTo("App\UnitDepositRequest", 'unit_deposit_request_id', 'id');
    }

    public function contract()
    {
        return $this->hasOne('App\Contract');
    }

    public function attachments()
    {
        return $this->hasMany('App\UnitContractRequestAttachment');
    }

    public function createdBy()
    {
    	return $this->belongsTo("App\User",'user_id', 'id')->select($this->getUserVisibleAttributes());
    }

    public function actionedBy()
    {
        return $this->belongsTo('App\User','actioned_user_id', 'id')->select($this->getUserVisibleAttributes());
    }

    public function scopeOfCountStatistic($query, $from = null , $to = null, $group_by = 'DAY') {
        $sql_format = '';
        switch ($group_by) {          
            case 'MONTH':
                $sql_format = 'DATE_FORMAT(created_at, "%Y-%m")';
                break;
            case 'YEAR':
                $sql_format = 'DATE_FORMAT(created_at, "%Y")';
                break;
            default:
                $sql_format = 'DATE_FORMAT(created_at, "%Y-%m-%d")';
                break;
        }       
        return DB::table($this->getTable())             
               ->groupBy('date')
               ->whereBetween('created_at', [$from, $to])
               ->select(DB::raw('count(id) as count'), DB::raw($sql_format. ' `date`'));
    }
   	// End Model Relationship

    // Query Scope
    public function scopeByUserId($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeAgents($query, $agents)
    {
        return $query->whereIn('user_id', $agents);
    }

    public function scopeOfCreatedBetweenDate($query, $from = null, $to = null)
    {   
        $date_format = config("app.php_date_format");

        $from   = is_null($from) ? Carbon::today()->firstOfMonth() : Carbon::createFromFormat($date_format, $from)->startOfDay();
        $to     = is_null($to) ? Carbon::today()->lastOfMonth()->addHours(23)->addMinutes(59)->addSeconds(59) : Carbon::createFromFormat($date_format.' H:i:s', $to." 23:59:59");

        return $query->whereBetween('created_at', [$from, $to]);
    }
    // End Query Scope

    // Helper Function
    public function isEditable()
    {
        return strcasecmp($this->status, UnitContractStatus::PENDING) == 0 ;
    }

    public function isOwner($user_id)
    {
        return $this->user_id === $user_id;
    }

    public function isStatus($status)
    {
        return strcasecmp($this->status, $status) === 0;
    }

    public function setAction($action_status, $action_reason = '') 
    {
        $this->status = $action_status;
        $this->action_reason = $action_reason;
        $this->actioned_user_id = Auth::user()->id;
        $this->actioned_at = now();   
    }

    public function getStatusHtml()
    {
        $result = "";
        switch ($this->status) {
            case 'PENDING':
                $result = '<span class="badge badge-pill badge-warning">';
                break;
            case 'APPROVED':
                $result = '<span class="badge badge-pill badge-success">';
                break;
            case 'OVERDUE':
                $result = '<span class="badge badge-pill badge-danger">';
                break;
            case 'RELEASE':
                $result = '<span class="badge badge-pill badge-primary">';
                break;    
            default:
                $result = '<span class="badge badge-pill badge-secondary">';
                break;
        }

        return $result.$this->status."</span>";
    }

    // Model Mutator
    public function getRemarkAttribute($value)
    {
        if ( is_null($value) ) {
            return "";
        } 
        return $value;
    }

    public function getContractPdfUrlAttribute()
    {
        if ( is_null($this->contract_id) ) {
            return null;
        }
        return route('api.contract.view.pdf', ['id' => $this->contract_id ]);
    }
    // End Model Mutator

    // End Helper Function 

   	private function getUserVisibleAttributes()
    {
        return $this->userVisibleAttributes;
    }
}
