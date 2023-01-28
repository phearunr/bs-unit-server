<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class IdentityDocument extends Model implements HasMedia
{
    use HasMediaTrait;
   
    protected $fillable = [
        'type',
        'reference_no',
        'metatdata',
        'issue_date',
        'expiration_date',
        'media',
    ]; 

    protected $dates = [
        'issue_date',
        'expiration_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'issue_date' => "date:config('app.php_date_format')",
        'expiration_date' => "date:config('app.php_date_format')",
        'created_at' => "datetime:config('app.php_datetime_format')",
        'updated_at' => "datetime:config('app.php_datetime_format')",
    ];

    // Model Relationship go here

    public function subConstructor()
    {
        return $this->belongsTo('App\SubConstructor');
    }

    public function identityDocuments()
    {
        return $this->morphTo();
    } 

    // End Model Relationship
   
}
