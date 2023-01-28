<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UnitHoldRequest;
use App\UnitAction;
use App\Helpers\UnitHoldStatus;
use App\Helpers\UserRole;
use App\Helpers\MsNavBridge;
use App\Http\Requests\ActionUnitHoldRequest;
use App\Http\Controllers\Notifications\UnitHoldRequestNotificationController;
use App\Http\Controllers\Admin\PaymentOptionController;
use App\Http\Controllers\Controller;
use App\Notifications\UnitHoldRequestVoided;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UnitHoldRequestController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = $request->user();
        $unit_hold_requests = UnitHoldRequest::query();
        $statuses = UnitHoldStatus::toArray();
        // $payment_statuses = UnitHoldRequest::getPaymentStatusHtml();

        if ($auth_user->hasRole(UserRole::ACCOUNTANT)) {
            $statuses =  array_diff($statuses, [
                UnitHoldStatus::PENDING,
                UnitHoldStatus::OVERDUE,
                UnitHoldStatus::RELEASE
            ]);
        }

        if ( $request->query('term') ) {
            $term = $request->query('term');           
            $unit_hold_requests = $unit_hold_requests->orWhereHas('unit' , function ($query) use ($term) {
                $query->where('code', 'LIKE', '%'.$term.'%');
            });
        }

        if ( $request->query('from') AND $request->query('to') ) {
            $unit_hold_requests = $unit_hold_requests->ofCreatedBetweenDate($request->query('from'), $request->query('to'));
        }
        
        if ( $request->query('status') ) {
            $unit_hold_requests = $unit_hold_requests->where('status', $request->query('status'));
        } else {
            $unit_hold_requests = $unit_hold_requests->whereIn('status', $statuses);
        }

        $unit_hold_requests = $unit_hold_requests->with(['unit','createdBy'])->paginate();

        return view('admin.unit_hold_request.index', compact('unit_hold_requests','statuses'));
    }
}
