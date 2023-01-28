<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{	
	protected static function boot()
    {
        parent::boot();

        static::saving( function($model){
        	if ( $model->published_at->lessThan(now()) ) {
        		$model->has_notified = true;
        	} else {
        		$model->has_notified = false;
        	}
        });

        static::addGlobalScope('sortByPublishedAt', function (Builder $builder) {          
            $builder->orderBy('published_at','DESC')
            		->orderBy('posts.id','DESC');
        });
    }

	protected $fillable = [
		'title',
		'content',
		'short_description',
		'status',
		'type',
		'has_notified',
		'published_at',
		'thumbnail_image_url',
		'featured_image_url'
	];

	static $collection_field = [
		'id', 'user_id', 'title', 'short_description', 'thumbnail_image_url',
		'featured_image_url', 'status', 'type', 'published_at', 'created_at', 'updated_at'
	];

	protected $dates = [
		'published_at', 'created_at', 'updated_at'
	];

	protected $casts = [
		'has_notified' => 'boolean'
	];

	// Post status
	const STATUSES = [
		'published',
		'draft'
	];

	// Post status
	const TYPES = [
		'standard'
	];	

	public static function getStatuses()
	{
		return self::STATUSES;
	}

	public static function getTypes()
	{
		return self::TYPES;
	}

	// << Model Relationship
	public function categories()
	{
		return $this->belongsToMany('App\Category');
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'user_id', 'id')->select(User::getCreatedByFields());
	}

	// >>

	// << Attribute Mutator
	public function getFeaturedImageUrlAttribute($value)
	{		
        if ( is_null($value) OR trim($value) == "" ){
            return null;
        }
        return asset('storage/'.$value);  
	}

	public function getThumbnailImageUrlAttribute($value)
	{		
        if ( is_null($value) OR trim($value) == "" ){
            return null;
        }
        return asset('storage/'.$value);  
	}

	public function getCssStyleAttribute()
	{
		return '<style>'.file_get_contents(asset('css/post.css')).'</style>';
	}
	// >>

	// << Query Scope
	public function scopePublished($query)
    {
        return $query->where('published_at', '<', now())
                     ->where('status', 'published');
    }

    public function scopeUnnotified($query)
    {
    	return $query->published()
    				->where('has_notified', false);
    }
	// >>

	// << Helper function

	public function deleteFeaturedImage(){
        Storage::disk('public')->delete($this->featured_image_url);
    }
    
    public function deleteThumbnailImage(){
        Storage::disk('public')->delete($this->thumbnail_image_url);
    }

	public function publishTime()
	{
		return $this->published_at->format('H:i:s');
	}

	public function publishDate()
	{
		return $this->published_at->format(config('app.php_date_format'));
	}

	public static function getCollectionFields()
	{
		return self::$collection_field;
	}
	// >> 
}
