<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractRequestAttachment extends Model
{
	use SoftDeletes;

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];  

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path'];

    public function getPathAttribute($value){
    	return asset('storage/'.$value);
    }

    /**
     * if deleted_at null or empty -> convert it to empty string.
     *
     * @param  string  $value
     * @return string
     */
    public function getDeletedAtAttribute($value)
    {
        if ( is_null($value) ){
            return "";
        }
        return  $value;
    }
}
