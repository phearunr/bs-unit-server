<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalWorkflow extends Model
{
	public $timestamps = false;

	public function scopeModelType($query, $model_type, $condition = null)
	{
		return $query->where('model', $model_type);
	}
}
