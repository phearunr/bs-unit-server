<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class SubConstructor extends Model 
{
    protected $fillable = [
        'user_id',
        'name',
        'join_date',
        'avatar',
        'worker',
    ]; 

    /**
     * Attribute which need to cast to Carbon Date Object
     *
     * @var array
     */
    protected $dates = [
        'join_date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar_url'];  

    /**
     * Append the avatar_url attribute.
     *
     * @return string (avatar url)
     */
    public function getAvatarUrlAttribute()
    {     
        if ( is_null($this->avatar) OR trim($this->avatar) == "" ){
            return asset('img/default_user_avatar.png');
        }
        
        return asset('storage/'.$this->avatar);
    }

    public function deleteOldAvatarImage(){
        Storage::disk('public')->delete($this->avatar);
    }

    public function setJoinDateAttribute($value)
    {
        $this->attributes['join_date'] = \Carbon\Carbon::createFromFormat(config('app.php_date_format'), $value);
    }

    // Model Relationship
    public function createdBy()
    {
        return $this->belongsTo('App\User', "user_id", "id")->select(['id','name','avatar','phone_number']);
    }

    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable', 'model_type', 'model_id');
    }

    public function identityDocuments(){
        
        return $this->morphMany('App\IdentityDocument', 'identity_documents', 'model_type', 'model_id');

    }

    public function skills()
    {
        return $this->belongsToMany('App\SubConstructorSkill', 'sub_constructor_has_skills', 'sub_constructor_id', 'sub_constructor_skill_id');
    }

    public function units()
    {
        return $this->belongsToMany('App\Unit', 'sub_constructor_units')
        ->as('SubConstructorUnit')
        ->withTimestamps();
    }
}
