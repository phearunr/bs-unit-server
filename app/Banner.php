<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->deleteImageUrl();
        });
    }   

	protected $fillable = [
	    'user_id',
	    'image_url',
		'url',
        'order',
		'expired_at'
	];

	protected $dates = ['created_at', 'updated_at', 'expired_at'];  

    // Model Scope 
    public function scopeActive($query)
    {
        return $query->where('expired_at', '>=', date('Y-m-d'));
    }

    public function scopeExpired($query)
    {
        return $query->where('expired_at', '<', date('Y-m-d'));
    }
    // End Model Scope

	public function deleteImageUrl() 
    {
    	$file_path = $this->getOriginal('image_url');
    	$path_array = explode('/', $file_path);    	
        $thumbnail_path = 'thumbnail_'.array_pop($path_array);
        $dir_path = implode('/',$path_array).'/';
        
        // remove main image
        Storage::disk('public')->delete($file_path);
        // remove thumbnail
        Storage::disk('public')->delete($dir_path.$thumbnail_path);
    }

    public function getImageThumbnailUrlAttribute() {
    	$file_path = $this->getOriginal('image_url');
    	$path_array = explode('/', $file_path);    	
        $thumbnail_path = 'thumbnail_'.array_pop($path_array);
        $dir_path = implode('/',$path_array).'/';

        if ( is_null($this->getOriginal('image_url')) 
        	 OR trim($this->getOriginal('image_url')) == "" ){
            return asset('img/no_image_preview.jpg');
        }
        return asset('storage/'.$dir_path.$thumbnail_path);        
    }	

    public function getImageUrlAttribute($value)
    {
    	if ( is_null($value) OR trim($value) == "" ){
            return asset('img/no_image_preview.jpg');
        }

        return asset('storage/'.$value);
    }

    public function isExpired()
    {	    	
    	return $this->expired_at->addSeconds(24*60*60-1)->lessThan(now()) ;
	}
}
