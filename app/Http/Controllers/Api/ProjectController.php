<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\UnitCollection;
use App\Http\Controllers\Controller;


class ProjectController extends Controller
{
	protected $validationRules =  [	   
        'name' 			=> "required|string|max:255",				        
        'short_code'  	=> "required|string|min:4|max:4|unique:projects,short_code",
        'payment_option_image_url' => 'image|dimensions:max_width=1920,max_height=1920'
	];
	
    public function all(Request $request) 
    {
    	$projects = Project::query();

    	if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			$projects = $projects->with($relationships) ; 
		}

		return new ProjectCollection( $projects->ofPublished(true)->paginate() );
    }

    public function get(Request $request, $id)
    {
    	$project = Project::where('id', $id)->firstOrFail();
		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			$project->load($relationships);
		}
		return new ProjectResource( $project );
    }

    public function getUnits(Request $request, $id) 
    {
    	$units = Project::findOrFail($id)->units();
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

 		return new UnitCollection( $units->saleable()
 									     ->publishedProject()
 								         ->paginate($request->input('per_page')) );
    }

    public function getUnitsForFloorPlan(Request $request, $id)
    {    	
    	// To Fix the bug in iOS App
    	// Removing the eager load of unitTypes.media
    	// $project = Project::with([ 'unitTypes', 'unitTypes.media', 'unitTypes.activeDiscountPromotions',
    	// 	'units' => function ($query) {
    	// 	$query->without(['unitTypes', 'action.createdBy','unitType','unitType.project']);    		      
    	// }])->where('id', $id)->firstOrFail();
    	$project = Project::with([ 'unitTypes', 'unitTypes.activeDiscountPromotions',
    		'units' => function ($query) {
    		$query->without(['unitTypes', 'action.createdBy','unitType','unitType.project']);    		      
    	}])->where('id', $id)->firstOrFail();
    	$response = [];
    	$response['data']['units'] = $project->units->makeHidden(['action'])->groupBy('availability_status');
    	$response['data']['unit_types']  = $project->unitTypes;    
    	$response['code'] = 200;
    	$response['message'] = __('success');
    	return response()->json($response, $response['code']);
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
	        if ( $request->hasFile('payment_option_image_url') ) {	        	
	    		$path = $request->file('payment_option_image_url')->store("payment_option_image","public");  
	    		$data['payment_option_image_url'] = $path;
	    	}	    	
        	$project = Project::create($data);	
        } catch (Exception $e) {
        	$this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
        }
        return new ProjectResource( $project );
	}

	public function update(Request $request, $id)
	{
		$project = Project::where('id', $id)->firstOrFail();

		$rules = $this->getValidationRules();
		// Tweak the short_code Uniqe validation problem on update
		$rules['short_code'] = $rules['short_code'].','.$project->id;

		$validator = Validator::make( $request->all(), $rules);

		if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        try {
        	if ( $request->hasFile('payment_option_image_url') ) {
        		$project->deleteOldImage();
	    		$path = $request->file('payment_option_image_url')->store("payment_option_image","public");  
	    		$data['payment_option_image_url'] = $path;
	    	}	  
        	$project->fill($data);	
        	if ( ! $project->save() ){
	            $this->sendErrorJsonResponse(__('There are some problems while trying to updating your request'), 500);			
			}

        } catch (Exception $e) {
        	$this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
        }
        return new ProjectResource( $project );
	}

	public function remove(Request $request, $id)
	{
		$project = Project::where('id', $id)->firstOrFail();
		try {
			$project->user_id = $request->user()->id;
			$project->deleted_at = \Carbon\Carbon::now();
			$project->save();
		} catch (Exception $e) {
			return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
		}	
		return $this->sendSuccessResponse( __("Delete Successful.") , 200);
	}

	public function getValidationRules(){
		return $this->validationRules;
	}
}
