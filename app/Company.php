<?php

namespace App;

use App\Helpers\KhmerMonth;
use App\Helpers\NumberFormat;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
   	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name_km',
        'address_line1',
        'address_line2',
        'name_en',
        'address_line1_en',
        'address_line2_en',
        'name_zh',
        'address_line1_zh',
        'address_line2_zh',
        'contact_phone_number',
        'email_address',
        'website',
        'tax_no',
        'tax_issued_date',
        'commercial_license_no',
        'commercial_license_issued_date',
        'nav_company_code'
    ]; 

    protected $dates = [
        'created_at',
        'updated_at',
        'tax_issued_date',
        'commercial_license_issued_date'
    ];

    // Model Relationship go here
    public function createdBy()
    {
    	 return $this->belongsTo('App\User', 'user_id', "id")->select(\App\User::getCreatedByFields());
    }

    public function projects()
    {
    	return $this->hasMany('App\Project');
    }
    // End Model Relationship

    // << km language helper
    public function getCommercialLicenseNoKmAttribute() 
    {
        return NumberFormat::convertToKhmerNumber($this->commercial_license_no);
    }

    public function getCommercialLicenseIssuedDayKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->commercial_license_issued_date->day);
    }

    public function getCommercialLicenseIssuedMonthKmAttribute()
    {
        return KhmerMonth::convertToKhmerMonth($this->commercial_license_issued_date->month);
    }

    public function getCommercialLicenseIssuedYearKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->commercial_license_issued_date->year);
    }
    // >>
}
