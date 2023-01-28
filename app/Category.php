<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
	use NodeTrait, HasSlug;

	protected $fillable = ['name', 'description', 'slug'];

	protected $visible = [
        'name', 'description', 'slug', 'created_at', 'updated_at', 'parent_id'
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

	/**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // << Model Relationship
    public function posts() 
    {
        return $this->belongsToMany('App\Post');
    }
    // >>
}
