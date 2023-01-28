<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestProject extends Model
{
    protected $fillable = [ 'name', 'address_line1', 'address_line2' ];

    public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', "id")->select(['id', 'name', 'avatar', 'phone_number']);
    }
}
