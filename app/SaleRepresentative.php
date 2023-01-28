<?php

namespace App;

use App\Helpers\KhmerMonth;
use App\Helpers\NumberFormat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class SaleRepresentative extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name',
    	'name_en',
    	'gender',
    	'birth_date',
    	'national_id',
    	'national_id_issued_date',        
    	'contact_number',
        'national_id_front_attachment_url',
        'national_id_back_attachment_url',
        'authorize_letter_url'
	];

    protected $dates = ['birth_date', 'national_id_issued_date', "deleted_at", "updated_at", "created_at"];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sortByRecent', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

  
    // Model Relationship go here
    public function createdBy() {
        return $this->belongsTo('App\User', 'user_id', "id")->select(['id','name','avatar','phone_number']);
    }
    // End Model Relationship

    public function deleteNationalIdFrontAttachmentUrlImage() 
    {
        Storage::disk('public')->delete($this->getOriginal('national_id_front_attachment_url'));
    }

    public function deleteNationalIdBackAttachmentUrlImage() 
    {
        Storage::disk('public')->delete($this->getOriginal('national_id_back_attachment_url'));
    }

    public function deleteAuthorizeLetterUrlImage() 
    {
        Storage::disk('public')->delete($this->getOriginal('authorize_letter_url'));
    }

    /**
     * Convert to full domain URL base for national_id_front_attachment_url
     *
     * @return string national_id_front_attachment_url
     */
    public function getNationalIdFrontAttachmentUrlAttribute($value)
    {
        if ( is_null($value) OR trim($value) == "" ){
            return null;
        }

        return asset('storage/'.$value);
    }

    /**
     * Convert to full domain URL base for national_id_back_attachment_url
     *
     * @return string national_id_back_attachment_url
     */
    public function getNationalIdBackAttachmentUrlAttribute($value)
    {
        if ( is_null($value) OR trim($value) == "" ){
            return null;
        }

        return asset('storage/'.$value);
    }

    /**
     * Convert to full domain URL base for national_id_front_attachment_url
     *
     * @return string national_id_front_attachment_url
     */
    public function getAuthorizeLetterUrlAttribute($value)
    {
        if ( is_null($value) OR trim($value) == "" ){
            return null;
        }

        return asset('storage/'.$value);
    }

    // << KM language helper
    public function getGenderKmAttribute()
    {        
        if (strtolower($this->gender) == "female") {
            return "ស្រី";
        }
        if (strtolower($this->gender) == "male") {
            return "ប្រុស";
        }
        return "N/A";
    }

    public function getContactNumberKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->contact_number);
    }

    public function getBirthDateDayKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->birth_date->day);
    }

    public function getBirthDateMonthKmAttribute()
    {
        return KhmerMonth::convertToKhmerMonth($this->birth_date->month);
    }

    public function getBirthDateYearKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->birth_date->year);
    }

    public function getNationalIdKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->national_id);
    }

    public function getNationalIdIssuedDayKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->national_id_issued_date->day);
    }

    public function getNationalIdIssuedMonthKmAttribute()
    {
        return KhmerMonth::convertToKhmerMonth($this->national_id_issued_date->month);
    }

    public function getNationalIdIssuedYearKmAttribute()
    {
        return NumberFormat::convertToKhmerNumber($this->national_id_issued_date->year);
    }
    // >>

    // << ZH language helper
    public function getGenderZhAttribute()
    {
        if (strtolower($this->gender) == "female") {
            return "女";
        }
        if (strtolower($this->gender) == "male") {
            return "男";
        }
        return "N/A";
    }
    // >>

}