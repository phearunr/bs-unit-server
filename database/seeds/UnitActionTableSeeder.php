<?php

use App\Unit;
use App\UnitAction;
use App\UnitContractRequest;
use App\UnitDepositRequest;
use App\UnitHoldRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UnitActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Unit::whereNotNull('unit_action_id')->update(['unit_action_id' => null]);
        UnitAction::truncate();
        UnitContractRequest::truncate();
        UnitDepositRequest::truncate();
        UnitHoldRequest::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
       	
        $units = Unit::all();       	
       	foreach( $units as $unit ) {
       		$action = UnitAction::create([
       			'user_id' =>  config('app.default_system_user_id'),
       			'unit_id' => $unit->id,
       			'action' => "AVAILABLE",
       			'status_action' => "",
                'actionable_type' => "",
                'actionable_id' => 0
       		]);
       	}
    }
}
