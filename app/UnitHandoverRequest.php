<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class UnitHandoverRequest extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'date',
        'approval_id',
        'status',
        'appointment_image_url',
        'handover_letter_image_url',
        'lor_image_url',
        'customer_name',
        'customer_relationship',
        'customer_name2',
        'customer_relationship2',
        'agreement_date'
    ]; 

    protected $dates = ['date', 'agreement_date'];

    public function createdBy()
    {
    	return $this->belongsTo('App\User', 'user_id', "id");
    }

    public function unit()
    {
    	return $this->belongsTo('App\Unit', 'unit_id', "id");
    }

    public function scopeOwner($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function scopePendingMyApproval($query)
    {
        return $query->whereHas('approval', function ($sub_query) {
            $sub_query->where('user_id', Auth::user()->id)
            ->where('status','!=','Draft');
        });
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

}
