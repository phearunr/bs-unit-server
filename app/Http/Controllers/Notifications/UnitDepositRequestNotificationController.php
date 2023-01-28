<?php

namespace App\Http\Controllers\Notifications;

use App\User;
use App\UnitDepositRequest;
use App\Notifications\UnitDepositRequestPending;
use App\Notifications\UnitDepositRequestApproved;
use App\Notifications\UnitDepositRequestRejected;
use App\Notifications\UnitDepositRequestCancelled;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UnitDepositRequestNotificationController extends Controller
{

	/**
     * Send Unit Deposit Pending Notitication to Users.
     *
     * @param Illuminate\Database\Eloquent\Collection $user_collection
     * @param App\UnitDepositRequest $unit_deposit_request
     * @return Illuminate\Database\Eloquent\Collection [user];
     */
    public static function sendUnitDepositPendingRequest(Collection $user_collection, UnitDepositRequest $unit_deposit_request)
    {
    	try {                               
            Notification::send($user_collection, new UnitDepositRequestPending($unit_deposit_request));
            return $user_collection;
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );           
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send Unit Deposit Approved Notitication to Users.
     *
     * @param $user mixed
     * @param App\UnitDepositRequest $unit_deposit_request
     * @return Void
     */
    public static function sendUnitDepositApprovedRequest(
        $user, 
        UnitDepositRequest $unit_deposit_request, 
        $approver_role = '')
    {
        try {                             
            if ( get_class($user) == 'Illuminate\Database\Eloquent\Collection' ) {
                Notification::send($user, new UnitDepositRequestApproved($unit_deposit_request, $approver_role));
            } elseif( get_class($user) == 'App\User' ) {
                $user->notify(new UnitDepositRequestApproved($unit_deposit_request, $approver_role));
            } else {
                throw new \UnexpectedValueException("Uncaught UnexpectedValueException : User Collection or User Model is expected.");
            }   
                         
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send Unit Deposit Approved Notitication to Users.
     *
     * @param App\User $user
     * @param App\UnitDepositRequest $unit_deposit_request
     * @return Void
     */
    public static function sendUnitDepositRejectedRequest(User $user, UnitDepositRequest $unit_deposit_request, $role_name = '')
    {
        try {                             
            $user->notify(new UnitDepositRequestRejected($unit_deposit_request,  $role_name));
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send Unit Deposit Cancel Notitication to Users.
     *
     * @param $user mixed;
     * @param App\UnitDepositRequest $unit_deposit_request
     * @return Illuminate\Database\Eloquent\Collection [user];
     */
    public static function sendUnitDepositCancelledRequest(
        $user, 
        UnitDepositRequest $unit_deposit_request, 
        $canceller_role = "")
    {
        try {                                            
            Notification::send($user, new UnitDepositRequestCancelled($unit_deposit_request, $canceller_role));
            return $user;
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
