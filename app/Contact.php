<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{   
    protected static $CONTACT_TYPE = [
        'MOBILE_PHONE_NUMBER',
        'OFFICE_PHONE_NUMBER'
    ];
    
    protected $fillable = [
        'type',
        'value',
        'metatdata'
    ]; 
    
    public static function getContactType()
    {
        return self::$CONTACT_TYPE;
    }

    // Attribute Mutator
    public function getDisplayTypeAttribute()
    {
        return ucwords(strtolower(str_replace('_', ' ', $this->type)));
    }

    public function subConstructor()
    {
        return $this->belongsTo('App\SubConstructor');
    }

    public function contactable()
    {
        return $this->morphTo();
    }
}