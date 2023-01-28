<?php

use Illuminate\Database\Seeder;

class ContractTemplateV1TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$contract_types = [
    		"land",
    		"condo",
    		"house",
            'shop',
            'condo-ecc'
    	];

    	foreach( $contract_types as $contract_type) {
            if ( !\App\ContractTemplate::where('name', $contract_type)->first() ) {
    			\App\ContractTemplate::create([
    	        	'name' => $contract_type,
    	        	'template_path' => str_replace("-","_",strtolower($contract_type))
    	        ]);
            }
    	}
    }
}
