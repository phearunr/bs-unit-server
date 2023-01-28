<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SubConstructorUnit extends Pivot
{
    protected $table = 'sub_constructor_units';

    public function createdBy()
    {
        return $this->belongsTo('App\User', "user_id", "id")->select(['id','name','avatar','phone_number']);
    }
}
