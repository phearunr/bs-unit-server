<?php

namespace App\Jobs;

use App\UnitDepositRequest
use App\Helpers\UnitDeposiStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessUnitDeposit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $unit_deposit_request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UnitDepositRequest $unit_deposit_request)
    {
        $this->unit_deposit_request = $unit_deposit_request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $unit_deposit_request = $this->unit_deposit_request;

        try {
            if (strcasecmp($unit_deposit_request->status, UnitDeposiStatus::PENDING) == 0 ) {
                DB::beginTransaction();
                $unit_deposit_request->status = UnitDeposiStatus::OVERDUE;

                $overdue_action = UnitAction::create([
                    'user_id'       => config('app.default_system_user_id'),
                    'unit_id'       => $unit_deposit_request->unit_id,
                    'action'        => "DEPOSIT",                    
                    'status_action' => UnitDeposiStatus::OVERDUE,
                    'description'   => 'The unit deposit request is overdue',
                    'actionable_type' => $unit_deposit_request->getMorphClass(),
                    'actionable_id' => $unit_deposit_request->id
                ]);

                $unit_deposit_request->save();
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unit Deposit Request Queue Error\n. '.$e->getMessage());
        }
    }
}
