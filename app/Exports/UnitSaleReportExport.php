<?php

namespace App\Exports;

use App\Unit;
use App\Project;
use App\UnitType;
use App\UnitDepositRequest;
use App\UnitContractRequest;
use App\Contract;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UnitSaleReportExport implements FromQuery, WithMapping, WithHeadings
{
	use Exportable;

	protected $export_field = [ 
        'code',
        'unit_type',
        'project',     
        'price',
        'saleable',
        'active',
        'creation_date',
        'status',
        'status_action',
        'sale_price',
        'deposit_amount',
        'deposited_at',
        'promotional_discount',
        'customer1_name',
		'customer2_name',
		'customer_phone_number',
		'customer_phone_number2',
		'agent_name',
		'sale_team_leader'
    ];

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Unit::query()->withTrashed()->with(['action.actionable' => function (MorphTo $morphTo) {
        	$morphTo->morphWith([
	            UnitDepositRequest::class => [ 'createdBy', 'createdBy.manager' ],
	            UnitContractRequest::class => [ 
	            	'unitDepositRequest', 
	            	'unitDepositRequest.createdBy', 
	            	'unitDepositRequest.createdBy.manager' 
	        	],
	            Contract::class => [ 'agent', 'agent.manager' ],
	        ]);
   		}]);
    }

    /**
    * @var Unit $unit
    */
    public function map($unit): array
    {   
    	$deposit_field = [    		
			'customer1_name' => "",
			'customer2_name' => "",
			'customer_phone_number' => "",
			'customer_phone_number2' => "",
			'deposit_amount' => 0,
			'discount_promotion' => 0,
			'other_discount_allowance' => 0,
			'unit_sale_price' => 0,
			'deposited_at' => ""
	    ];

	    $sale_agent = [
	    	'agent_name' => "",
	    	'sale_team_leader' => ""
	    ];

	    $unit_deposit_request = null;
     	switch ($unit->action->actionable_type) {
     		case 'App\\UnitDepositRequest':
     			$unit_deposit_request = $unit->action->actionable;     		
     			break;
     		case 'App\\UnitContractRequest':
     			$unit_deposit_request = $unit->action->actionable->unitDepositRequest;     			
     			break;
     		case 'App\\Contract':     			
     			$deposit_field['customer1_name'] = utf8_encode($unit->action->actionable->customer1_name);
     			$deposit_field['customer2_name'] = utf8_encode($unit->action->actionable->customer2_name);
     			$deposit_field['customer_phone_number'] = $unit->action->actionable->customer_phone_number;
     			$deposit_field['customer_phone_number2'] = $unit->action->actionable->customer_phone_number2;
     			$deposit_field['deposit_amount'] = $unit->action->actionable->deposited_amount;
     			$deposit_field['discount_promotion'] = $unit->action->actionable->discount_promotion;
     			$deposit_field['other_discount_allowance'] = $unit->action->actionable->other_discount_allowed;
     			$deposit_field['unit_sale_price'] = $unit->action->actionable->unit_sale_price;
     			$deposit_field['deposited_at'] = $unit->action->actionable->deposited_at;
				
				$sale_agent['agent_name'] = $unit->action->actionable->agent->name;
 				$sale_agent['sale_team_leader'] = $unit->action->actionable->agent->manager->name ?? "";
     			break;     		
     		default:
     			$unit_deposit_request = null;
     			break;
     	}

     	if ( $unit_deposit_request instanceof  \App\UnitDepositRequest ) {
 			$deposit_field['customer1_name'] = $unit_deposit_request->customer_name;
 			$deposit_field['customer2_name'] = $unit_deposit_request->customer2_name;
 			$deposit_field['customer_phone_number'] = $unit_deposit_request->customer_phone_number;
 			$deposit_field['customer_phone_number2'] = $unit_deposit_request->customer_phone_number2;
 			$deposit_field['deposit_amount'] = $unit_deposit_request->deposit_amount;
 			$deposit_field['discount_promotion'] = $unit_deposit_request->discount_promotion;
 			$deposit_field['other_discount_allowance'] = $unit_deposit_request->other_discount_allowed;
 			$deposit_field['unit_sale_price'] = $unit_deposit_request->unit_sale_price;
 			$deposit_field['deposited_at'] = $unit_deposit_request->deposited_at;

 			$sale_agent['agent_name'] = $unit_deposit_request->createdBy->name;
 			$sale_agent['sale_team_leader'] = $unit_deposit_request->createdBy->manager->name ?? "";
     	}

        return [ 
        	'code' => $unit->code,
           	'unit_type' => $unit->unitType->name,
        	'project' => $unit->unitType->project->name_en,     
        	'price' => $unit->price,
        	'saleable' => $unit->saleable ? 'Yes' : 'No',
            'active' => $unit->trashed() ? 'No' : 'Yes',
        	'creation_date' => $unit->created_at,
        	'status' => $unit->action->action,
            'status_action' => $unit->action->status_action,
            'sale_price' => $deposit_field['unit_sale_price'],
	        'deposit_amount' => $deposit_field['deposit_amount'],
	        'deposited_at' => $deposit_field['deposited_at'],
	        'promotional_discount' => $deposit_field['discount_promotion'],
	        'customer1_name' => $deposit_field['customer1_name'],
			'customer2_name' => $deposit_field['customer2_name'],
			'customer_phone_number' => $deposit_field['customer_phone_number'],
			'customer_phone_number2' => $deposit_field['customer_phone_number2'],
			'agent_name' => $sale_agent['agent_name'],
			'sale_team_leader' => $sale_agent['sale_team_leader']
        ];
    }

    public function headings(): array
    {
        return $this->export_field;
    }
}
