<?php

namespace App\Exports;

use App\UnitHandover;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UnitHandoversExport implements FromQuery, WithMapping, WithHeadings
{
	use Exportable;
    
    protected $project_id;
    protected $batch_id;

    protected $export_field = [
    	'id',
     	'unit_handover_batch_id',
      	'unit_id',
     	'status',
     	'customer_name',
     	'last_posting_date',
     	'last_payment_date',
        'late_payment_month',
     	'net_selling_price',
     	'ending_balance',
     	'total_payment',
     	'contract_signed_date',
     	'contract_deadline_date',
        'late_deadline_month'
    ];

    public function __construct(int $id = null, int $batch_id = null)
    {
       $this->project_id = $id;
       $this->batch_id = $batch_id;
    }

    /**
     * @return Builder
     */
    public function query() 
    {
        if ( $this->project_id != null && $this->batch_id != null ) {
            return UnitHandover::where('project_id', $this->project_id)
                               ->where('unit_handover_batch_id', $this->batch_id);
        } else {
             return collect(new UnitHandover);
        }
    }

    /**
    * @var UnitHandover $unit_handover
    */
    public function map($unit_handover): array
    {   
        // return array_flatten($unit->only($this->export_field));
        return [
			'id' => $unit_handover->id,
			'unit_handover_batch_id' => $unit_handover->unit_handover_batch_id,
			'unit_id' => $unit_handover->unit_id,
			'status' => $unit_handover->status,
			'customer_name' => $unit_handover->customer_name,
			'last_posting_date' => $unit_handover->last_posting_date,
			'last_payment_date' => $unit_handover->last_payment_date,
			'net_selling_price' => $unit_handover->net_selling_price,
			'ending_balance' => $unit_handover->ending_balance,
			'total_payment' => $unit_handover->total_payment,
			'contract_signed_date' => $unit_handover->contract_signed_date,
			'contract_deadline_date' => $unit_handover->contract_deadline_date,
            'late_deadline_month' => $unit_handover->late_deadline_month,
        ];
    }

    public function headings(): array
    {
        return $this->export_field;
    }
}
