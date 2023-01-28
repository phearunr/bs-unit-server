<?php

namespace App;

use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
	protected $appends = ['url', 'thumbnail_url', 'type', 'human_readable_size'];

	public function getUrlAttribute() 
	{
		return $this->getFullUrl();
	}

	public function getThumbnailUrlAttribute() 
	{
		return $this->getFullUrl('thumb');
	}
}
