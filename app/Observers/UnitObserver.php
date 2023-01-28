<?php

namespace App\Observers;
use Auth;
use App\Unit;
use App\Activity;

class UnitObserver
{
	public function updated(Unit $unit)
	{
		if ($unit->isDirty('price')) {
			$unit->activities()->create([
				'user_id' => Auth::id(),
				'field_name' => 'price',
				'old_value' => $unit->getOriginal('price'),
				'new_value' => $unit->price
			]);
		}
	}
}
