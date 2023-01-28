<?php

namespace App\Http\Controllers\Notifications;

use App\User;
use App\UnitContractRequest;
use App\Notifications\UnitContractRequestOpen;
use App\Notifications\UnitContractRequestCancelled;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class UnitContractRequestNotificationController extends Controller
{
    /**
     * Send Unit Contract Open Notitication to User.
     *
     * @param App\User $user
     * @param App\UnitContractRequest $unit_contract_request
     * @return Void
     */
    public static function notifyRequestOpen($user, UnitContractRequest $unit_contract_request) 
    {
    	try {                   
    		return $user->notify(new UnitContractRequestOpen($unit_contract_request));
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );  
            throw new \Exception($e->getMessage(), $e->getCode());         
        }
    }

    /**
     * Send Unit Contract Open Notitication to User.
     *
     * @param $user mixed
     * @param App\UnitContractRequest $unit_contract_request
     * @return Void
     */
    public static function notfiyRequestCancelled($user, UnitContractRequest $unit_contract_request, $approver_role = '')
    {
        try {
            if ( get_class($user) == 'Illuminate\Database\Eloquent\Collection' ) {
                Notification::send($user, new UnitContractRequestCancelled($unit_contract_request, $approver_role));
            } elseif( get_class($user) == 'App\User' ) {
                $user->notify(new UnitContractRequestCancelled($unit_contract_request, $approver_role));
            } else {
                throw new \UnexpectedValueException("Uncaught UnexpectedValueException : User Collection or User Model is expected.");
            }
        } catch (\Exception $e) {
            Log::error( $e->getMessage() );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
