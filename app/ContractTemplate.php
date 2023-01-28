<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractTemplate extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];  

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','template_path'];

    protected $appends =[
    	'url',
    ];


    public function getUrlAttribute()
    {          
        return route('admin.contract_templates.preview',['template_path' => $this->template_path]);    
    }
}
