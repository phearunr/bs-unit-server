<?php

namespace App\Http\Controllers\Notifications;

use App\User;
use App\UnitHoldRequest;
use App\Notifications\UnitHoldRequestPending;
use App\Notifications\UnitHoldRequestApproved;
use App\Notifications\UnitHoldRequestRejected;
use App\Notifications\UnitHoldRequestCancelled;
use App\Notifications\UnitHoldRequestOverdue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class UnitHoldRequestNotificationController extends Controller
{
   	/**
     * Send Unit Hold Pending Notitication to Users.
     *
     * @param Illuminate\Database\Eloquent\Collection $user_collection
     * @param App\UnitHoldRequest $unit_hold_request
     * @return Illuminate\Database\Eloquent\Collection [user];
     */
    public static function notifyRequestPending(Collection $user_collection, UnitHoldRequest $unit_hold_request) 
    {
    	try {                               
            Notification::send($user_collection, new UnitHoldRequestPending($unit_hold_request));
            return $user_collection;
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send Unit Hold Approved Notitication to Users.
     *
     * @param App\User $user
     * @param App\UnitHoldRequest $unit_hold_request
     * @return Illuminate\Database\Eloquent\Collection [user];
     */
    public static function notifyRequestApproved($user, UnitHoldRequest $unit_hold_request) 
    {
    	try {                   
    		$user->notify(new UnitHoldRequestApproved($unit_hold_request));
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );  
            throw new \Exception($e->getMessage(), $e->getCode());         
        }
    }

    /**
     * Send Unit Hold Rejected Notitication to Users.
     *
     * @param App\User $user
     * @param App\UnitHoldRequest $unit_hold_request
     * @return Illuminate\Database\Eloquent\Collection [user];
     */
    public static function notifyRequestRejected($user, UnitHoldRequest $unit_hold_request) 
    {
    	try {                   
    		$user->notify(new UnitHoldRequestRejected($unit_hold_request));
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );  
            throw new \Exception($e->getMessage(), $e->getCode());         
        }
    }

    /**
     * Send Unit Hold Pending Notitication to Users.
     *
     * @param Illuminate\Database\Eloquent\Collection $user_collection
     * @param App\UnitHoldRequest $unit_hold_request
     * @return Illuminate\Database\Eloquent\Collection [user];
     */
    public static function notifyRequestCancelled(Collection $user_collection, UnitHoldRequest $unit_hold_request) 
    {
    	try {                               
            Notification::send($user_collection, new UnitHoldRequestCancelled($unit_hold_request));
            return $user_collection;
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send Unit Hold Overdue Notitication to Users.
     *
     * @param App\User $user
     * @param App\UnitHoldRequest $unit_hold_request
     * @return void;
     */
    public static function notifyRequestOverdue(User $user, UnitHoldRequest $unit_hold_request) 
    {
        try {                               
            return $user->notify(new UnitHoldRequestOverdue($unit_hold_request));           
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
