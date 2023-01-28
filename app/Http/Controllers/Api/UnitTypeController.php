<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\UnitType;
use App\Project;
use App\Unit;
use App\DiscountPromotion;
use Illuminate\Http\Request;
use App\Http\Resources\UnitType as UnitTypeResource;
use App\Http\Resources\UnitCollection;
use App\Http\Resources\UnitTypeCollection;
use App\Http\Resources\DiscountPromotion as DiscountPromotionResource;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UnitTypeController extends Controller
{    

	protected $validationRules =  [
	    'project_id'	=> 'required|integer|exists:projects,id', 
        'name' 			=> "required|string|max:255",				        
        'short_code'  	=> "required|string|min:7|max:7|unique:unit_types,short_code"
	];

	public function all(Request $request)
	{		
		$unit_types = UnitType::query();
		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );		
			$unit_types = $unit_types->with($relationships)	;
		}
		return new UnitTypeCollection( $unit_types->paginate() );
	}

	public function create(Request $request) 
	{	
		$validator = Validator::make( $request->all(), $this->getValidationRules() );

		if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        try {
        	$unit_type = UnitType::create($data);	
        } catch (Exception $e) {
        	$this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
        }
        return new UnitTypeResource( $unit_type );
	}

	public function get(Request $request, $id)
	{
		$unit_type = UnitType::where('id', $id)->firstOrFail();

		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			$unit_type->load($relationships);
		}
		return new UnitTypeResource( $unit_type );
	}

	public function update(Request $request, $id)
	{
		$unit_type = UnitType::where('id', $id)->firstOrFail();

		$rules = $this->getValidationRules();
		// Tweak the short_code Uniqe validation problem on update
		$rules['short_code'] = $rules['short_code'].','.$unit_type->id;

		$validator = Validator::make( $request->all(), $rules);

		if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        try {
        	$unit_type->fill($data);	
        	if ( ! $unit_type->save() ){
	            $this->sendErrorJsonResponse(__('There are some problems while trying to updating your request'), 500);			
			}

        } catch (Exception $e) {
        	$this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
        }

        return new UnitTypeResource( $unit_type );
	}

	public function remove(Request $request, $id)
	{
		$unit_type = UnitType::where('id', $id)->firstOrFail();
		try {
			$unit_type->user_id = $request->user()->id;
			$unit_type->deleted_at = \Carbon\Carbon::now();
			$unit_type->save();
		} catch (Exception $e) {
			return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
		}	
		return $this->sendSuccessResponse( __("Delete Successful.") , 200);
	}

	public function getByProjectId(Request $request, $project_id ){

		$project = Project::findOrFail($project_id);

		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			return new UnitTypeCollection( UnitType::where('project_id', $project_id)->with($relationships)->get() );
		}
		return new UnitTypeCollection( UnitType::where('project_id', $project_id)->get() );
	}

	public function getUnits(Request $request, $id) 
	{
		$units = Unit::query();

		$units = $units->where("unit_type_id", $id);

   		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			$units = $units->with($relationships);
		}

		if ( $request->input("term") ) {		
			$units = $units->where('code' , 'LIKE', '%'. $request->input("term").'%'); 
		}

		if ( $request->input('status') ) {
			$actions = explode(',', trim($request->input('status')));
			$units = $units->whereHas('action', function ($query) use ($actions) {
                $query->whereIn('action', $actions );            
            });
		}

		return new UnitCollection( $units->paginate(50) );
	}

	public function getDiscountPromotion(Request $request, $id)
	{
		$unit_type = UnitType::findOrFail($id);		

		$validator = Validator::make( $request->all(), [
			"date" => "nullable|date",
		]);

		if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $date = $request->query('date') ?
        		Carbon::createFromFormat('Y-m-d', $request->query('date')) 
        		: Carbon::today();
        
		$discount_promotion  = $unit_type->discountPromotion()
		                                 ->where("discount_promotions.start_date", "<=", $date->toDateString())
		                                 ->where('discount_promotions.end_date', ">=", $date->toDateString())
		                                 ->first();
	
		if ( is_null($discount_promotion) ) {
			return $this->sendErrorJsonResponse("Resource not found.", 404);
		} 

		return new DiscountPromotionResource( $discount_promotion );
	}

	public function getValidationRules(){
	  	return $this->validationRules;
	}
}
