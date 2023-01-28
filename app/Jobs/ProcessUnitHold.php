<?php

namespace App\Jobs;

use App\UnitAction;
use App\UnitHoldRequest;
use App\Helpers\UnitHoldStatus;
use App\Http\Controllers\Notifications\UnitHoldRequestNotificationController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class ProcessUnitHold implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $unit_hold_request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UnitHoldRequest $unit_hold_request)
    {
        $this->unit_hold_request = $unit_hold_request;     
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $unit_hold_request = $this->unit_hold_request;
        try {           
            if ( strcasecmp($unit_hold_request->status, "APPROVED") == 0 OR strcasecmp($unit_hold_request->status, "PENDING") == 0 ) {
                DB::beginTransaction();           
                $unit_hold_request->status = UnitHoldStatus::OVERDUE;
                $unit_hold_request->actioned_user_id = config('app.default_system_user_id');
                $unit_hold_request->actioned_at = now();

                $user = $unit_hold_request->createdBy;

                $overdue_action = UnitAction::create([
                    'user_id'       => config('app.default_system_user_id'),
                    'unit_id'       => $unit_hold_request->unit_id,
                    'action'        => 'HOLD',
                    'status_action' => UnitHoldStatus::OVERDUE,
                    'description'   => "The unit was automatically made available.",
                    "actionable_type" => "App\UnitHoldRequest",
                    'actionable_id' => $unit_hold_request->id
                ]);

                $available_action = UnitAction::create([
                    'user_id'       => config('app.default_system_user_id'),
                    'unit_id'       => $unit_hold_request->unit_id,
                    'action'        => 'AVAILABLE',                    
                    'status_action' => '',
                    'description'   => "The unit was automatically made available.",
                    "actionable_type" => "App\UnitHoldRequest",
                    'actionable_id' => $unit_hold_request->id
                ]);

                UnitHoldRequestNotificationController::notifyRequestOverdue($user, $unit_hold_request);

                $unit_hold_request->save();
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unit Holding Queue Error\n. '.$e->getMessage());
        }
    }
}
