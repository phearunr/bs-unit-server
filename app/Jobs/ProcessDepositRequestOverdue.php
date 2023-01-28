<?php

namespace App\Jobs;

use App\User;
use App\Unit;
use App\UnitAction;
use App\UnitDepositRequest;
use App\Helpers\UnitDepositStatus;
use App\Notifications\UnitDepositRequestOverdue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ProcessDepositRequestOverdue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $unit_deposit_request;

    public $tries = 5;

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
        try {
            if ( $this->unit_deposit_request->isStatus(UnitDepositStatus::APPROVED) ) {             
                DB::beginTransaction();
                // Setting the Unit Deposit Request to Overdue
                $this->unit_deposit_request->status = UnitDepositStatus::OVERDUE;
                $this->unit_deposit_request->save();

                UnitAction::create([
                    'user_id' => config('app.default_system_user_id'),
                    'unit_id' => $this->unit_deposit_request->unit_id,
                    'action'  => UnitDepositStatus::DEPOSIT,
                    'status_action'  => UnitDepositStatus::OVERDUE,
                    'actionable_type' => $this->unit_deposit_request->getMorphClass(),
                    'actionable_id' => $this->unit_deposit_request->id
                ]);

                DB::commit();
                Notification::send(
                User::find($this->unit_deposit_request->user_id), 
                    new UnitDepositRequestOverdue($this->unit_deposit_request)
                );          
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
