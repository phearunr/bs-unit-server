<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ContractAttachment extends Model
{
    use SoftDeletes;

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];  

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path','type'];

    public function getPathAttribute($value){
    	return asset('storage/'.$value);
    }
}
