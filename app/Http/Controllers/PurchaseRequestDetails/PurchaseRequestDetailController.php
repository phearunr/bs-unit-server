<?php

namespace App\Http\Controllers\PurchaseRequestDetails;

use App\PurchaseRequestDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class PurchaseRequestDetailController extends Controller
{
    public function index(Request $request)
    {
        $purchase_request_details = PurchaseRequestDetail::query()->with(['purchaseRequest']);

        if( $request->staff_id) {
            $purchase_request_details = $purchase_request_details->where('staff_id', $request->staff_id);
        }

        $purchase_request_details->when( $search = $request->search, function ($query, $search) {
            return $query->where( function (Builder $q) use ($search) {
                return $q->where('item_code', 'LIKE', "%$search%")
                ->orwhere('unit_of_measurement', 'like', "%$search%")
                ->orwhere('quantity', 'like', "%$search%")
                ->orwhere('purpose', 'like', "%$search%");
            });
        });

        $purchase_request_details = $purchase_request_details->paginate();
        return view('purchase_request.purchase_request_details.index',compact('purchase_request_details'));
    }
}
