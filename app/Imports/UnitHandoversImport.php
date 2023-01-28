<?php

namespace App\Imports;

use App\Project;
use App\UnitHandoverBatch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class UnitHandoversImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
	protected $project_id;
	protected $data_updated_on;

	public function __construct($project_id = null, $data_updated_on = null) 
	{
		if ( $project_id == null ) {
			throw new \InvalidArgumentException('Project id could not be null', 0);			
		}

		if ( $data_updated_on == null && strtotime($data_updated_on) ) {
			throw new \InvalidArgumentException('Data updated on argument must be date format', 0);
		}

		$this->project_id = $project_id;
		$this->data_updated_on = $data_updated_on;
	}

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $user = Auth::user();
        $project = Project::where('id', $this->project_id)->firstOrFail();
       
       	try {
            $date_format = config('app.php_date_format');
            $data_updated_on = \Carbon\Carbon::createFromFormat($date_format, $this->data_updated_on)->startOfDay()->format('Y-m-d');
            $unit_handover_batch = $user->unitHandoverBatch()->create(['data_updated_on' => $data_updated_on]);
            foreach ($collection as $row) {
                $unit_handover_batch->unitHandover()->create([
                    'unit_id' => $row['unit_id'],
                    'status' => ( isset($row['status']) ) ? $row['status'] : NULL,
                    'customer_name' => ( isset($row['customer_name']) ) ? $row['customer_name'] : NULL,
                    'last_posting_date' => ( isset($row['last_posting_date']) ) ? $row['last_posting_date'] : NULL,
                    'last_payment_date' => ( isset($row['last_payment_date']) ) ? $row['last_payment_date'] : NULL,
                    'late_payment_month' => ( isset($row['late_payment_month']) ) ? $row['late_payment_month'] : NULL, 
                    'net_selling_price' => ( isset($row['net_selling_price']) ) ? $row['net_selling_price'] : NULL,
                    'ending_balance' => ( isset($row['ending_balance']) ) ? $row['ending_balance'] : NULL,
                    'total_payment' => ( isset($row['total_payment']) ) ? $row['total_payment'] : NULL,
                    'contract_signed_date' => ( isset($row['contract_signed_date']) ) ? $row['contract_signed_date'] : NULL,
                    'contract_deadline_date' => ( isset($row['contract_deadline_date']) ) ? $row['contract_deadline_date'] : NULL, 
                    'late_deadline_month' => ( isset($row['late_deadline_month']) ) ? $row['late_deadline_month'] : NULL
                ]);
            }
            $project->unitHandoverBatch()->associate($unit_handover_batch);
            $project->save();
        } catch (\Exception $e) {
            Log::error("Importing Unit Handover failure: ".$e->getMessage());
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function batchSize(): int
    {
    	return 50;
    }
}
