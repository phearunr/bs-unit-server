<?php

namespace App;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model implements HasMedia
{	
    use HasMediaTrait;
	
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByCreatedAt', function (Builder $builder) { 
            $builder->orderBy('created_at', 'DESC');
            $builder->orderBy('id', 'DESC');
           
        });
    }
    protected $guarded = [];
    
    // Model Relationship
    public function commentor()
    {
        return $this->belongsTo('App\User', 'user_id', 'id')->select(User::getCreatedByFields());
    }
    // End Model Relationship

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->width(120)
              ->height(120)
              ->nonQueued();
        
        $this->addMediaConversion('8x6')
             ->width(301)
             ->height(226);
        
        $this->addMediaConversion('16x9')
             ->width(466)
             ->height(262);
    }
}
