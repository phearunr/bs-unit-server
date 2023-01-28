<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubConstructorSkill extends Model
{
    protected $fillable = [
        'name',
        'name_en',
    ]; 

    public function subConstructorSkills()
    {
        return $this->hasMany(Contact::class); 
    }
   
}