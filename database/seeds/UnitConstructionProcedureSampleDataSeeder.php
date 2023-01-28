<?php

use Illuminate\Database\Seeder;

class UnitConstructionProcedureSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $short_code = $this->command->ask('What is project short code?', 'DEMO-PROJECT');

    	$units = \App\Project::where('short_code', $short_code)->first()->units;
    	$construction_procedures = \App\ConstructionProcedure::all();

    	foreach( $units->chunk(50) as $chunk ) {
    		foreach($chunk as $unit) {
    			foreach($construction_procedures as $c) {
	    			\App\UnitConstructionProcedure::create([
	    				'unit_id' => $unit->id,
	    				'construction_procedure_id' => $c->id,
	    				'user_id' => 1,
	    				'progress' => 0, 
	    				'estimate_completed_at' => null, 
	    				'actual_completed_at' => null, 
	    				'order' => $c->id,
	    			]);
    			}
    		}
    	}
    }
}
