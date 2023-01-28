<?php

namespace App\Http\Controllers\HandoverOfficer;

use App\UnitType;
use App\Project;
use App\ContractTemplate;
use App\PaymentOption;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class UnitTypeController extends Controller
{
    public function show(Request $request, $id)
    {
        if ( $request->ajax() ) {
            $unit_type = UnitType::where('id', $id)->first();
            return $unit_type->makeVisible($unit_type->getHidden());
            // return UnitType::findOrFail($id);
        }
        
        $unit_type = UnitType::find($id);
                     
        $unit_type = UnitType::withCount([
            'units',
            'units as available_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'available');
                });
            },
            'units as unavailable_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'unavailable');
                });
            },
            'units as hold_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'hold');
                });
            },
            'units as deposit_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'deposit');
                });
            },
            'units as contract_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'contract');
                });
            }
        ])->with(['project', 'media'])->findOrFail($id);

            $payment_options = PaymentOption::query();
            $payment_options = $payment_options->with(['unitType','unitType.project']);
            $payment_options = $payment_options->where('unit_type_id',$id)->paginate(10);


        return view('handover_officer.project.unit_type.single', compact('unit_type','payment_options'));
    }
}
