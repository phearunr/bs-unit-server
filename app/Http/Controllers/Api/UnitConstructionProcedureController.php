<?php

namespace App\Http\Controllers\Api;

use App\Unit;
use App\UnitConstructionProcedure;
use App\Http\Resources\ConstructionProcedureCollection;
use App\Http\Requests\UpdateUnitConstructionProcedureRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitConstructionProcedureController extends Controller
{	
	protected $unit = null;

	public function __construct(Request $request)
	{
		$this->unit = Unit::where('id', $request->unit_id)->first();
	}

    public function get(Request $request) 
    {
    	$construction_procedures = $this->unit
                                        ->constructionProcedures()
                                        ->with(['pivot.createdBy'])
                                        ->orderBy('order')->get();

        return new ConstructionProcedureCollection( $construction_procedures );
    }

    public function update(UpdateUnitConstructionProcedureRequest $request, $unit_id, $id)
    {
        try {
            // Laravel Auditing not surpport this method updateExistingPivot
            // return $this->unit->constructionProcedures()->updateExistingPivot($id, [
            //     'user_id' => $request->user()->id,
            //     'progress' => $request->progress,
            //     'estimate_completed_at' => $request->estimate_completed_at
            // ]);

            $unit_construction_procedure = UnitConstructionProcedure::where('construction_procedure_id', $id)
                                                                    ->where('unit_id', $unit_id)
                                                                    ->first();
            
            if ( $unit_construction_procedure instanceof UnitConstructionProcedure ) {
                $unit_construction_procedure->user_id = $request->user()->id;
                $unit_construction_procedure->progress = $request->progress;
                $unit_construction_procedure->estimate_completed_at = $request->estimate_completed_at;
                $unit_construction_procedure->save();

                return $unit_construction_procedure->fresh()->loadMissing(['createdBy']);
            } else {
                return $this->sendErrorJsonResponse('Requested resource was not found.', 404); 
            }

        } catch (\Exception $e) {
            return $this->sendErrorJsonResponse($e->getMessage(), 500); 
        }
    }
}
