<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Unit;
use App\Comment;
use App\UnitAction;
use Illuminate\Http\Request;
use App\Http\Resources\Unit as UnitResource;
use App\Http\Resources\UnitCollection;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\UnitConstruction as UnitConstructionResource;
use App\Http\Resources\UnitConstructionCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
	public function all(Request $request) 
	{
		$units = Unit::query();
		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			$units = $units->with($relationships);
		}

		if ( $request->input("term") ) {		
			$units = $units->where('code' , 'LIKE', '%'. $request->input("term").'%'); 
		}

		if ( $request->input('unit_type_id') ) {
			$units = $units->where('unit_type_id', $request->input('unit_type_id'));
		} elseif( $request->input('project_id') ) {
			$unit_type_in_array = \App\UnitType::where('project_id', $request->input('project_id'))->get()->pluck('id');
			$units = $units->whereIn('unit_type_id', $unit_type_in_array);
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

	public function show(Request $request, $id)
	{
		$unit = Unit::findOrFail($id);
		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			$unit->load($relationships);
		}

		return new UnitResource($unit);
	}

	public function storeComment(Request $request, $id)
	{
		$validator = Validator::make($request->all(), 
			[
				'content' => 'required|string|max:250',
            	'media.*' => 'required|mimes:jpg,jpeg,png,gif,webp,bmp|max:2048'
        	], 
        	[           
	            'media.*.max' => __("Image should not be greater than :max KB."),
    	    ]
    	);

        if ($validator->fails()) {
        	return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

		$comment = new Comment;
		$comment->content = $request->content;
		$comment->commentor()->associate($request->user());

		$unit = Unit::find($id);

		try {
			DB::beginTransaction();  

			$unit->comments()->save($comment);

			if ( $request->file('media') ) {
				foreach($request->file('media') as $file) {
		            $filename = md5(time()).'.'.$file->getClientOriginalExtension();
		            $comment->addMedia($file)
		                    ->usingFileName($filename)
		                    ->toMediaCollection();
		        }
	        }

	        DB::commit();
	        return new CommentResource($comment->fresh()->loadMissing(['commentor', 'media']));

		} catch (\Exception $e) {
			DB::rollBack();
			return $this->sendErrorJsonResponse( $e->getMessage(), 500);
		}
	}

	public function getComments(Request $request, $id) {
		$unit = Unit::findOrFail($id);

		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			return new UnitCollection(
				$unit->comments()
					 ->with($relationships)
					 ->paginate( $request->per_page ?? (New Comment)->getPerPage() )
			);			
		}

		return new UnitCollection(
			$unit->comments()
				 ->paginate( $request->per_page ?? (New Comment)->getPerPage() )
		);
	}

	public function getUnitConstruction(Request $request, $id)
	{
		$unit_construction = \App\UnitConstruction::where('unit_id', $id)->with('createdBy')->firstOrFail();
		return new UnitConstructionResource($unit_construction);
	}

	public function storeUnitConstruction(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'foundation' => 'nullable|integer|min:0|max:100',
			'structure' => 'nullable|integer|min:0|max:100',
			'finishing' => 'nullable|integer|min:0|max:100',
			'infrastructure' => 'nullable|integer|min:0|max:100',
			'mep' => 'nullable|integer|min:0|max:100',
			'estimate_completed_at' => 'nullable|date'
        ]);

        if ($validator->fails()) {
        	return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

		$unit = Unit::find($id);
		$unit_construction = New \App\UnitConstruction();
		
		if ( $unit->construction ) {
			$unit_construction = $unit->construction;
		} else {
			$unit_construction->unit()->associate($unit);
		}	

		$unit_construction->fill($validator->validated());

		try {
			if ( $unit_construction->isDirty() ) {
				DB::beginTransaction();
				Auth::user()->UnitConstructions()->save($unit_construction);
				DB::commit();
			}
	        return new UnitConstructionResource($unit_construction->fresh()->loadMissing(['createdBy']));

		} catch (\Exception $e) {
			DB::rollBack();
			return $this->sendErrorJsonResponse($e->getMessage(), 500);
		}
	}

	public function getAvailabilityStatistic(Request $request) 
	{
		$unit_table_name = with(new Unit)->getTable();
		$unit_action_table_name = with(new UnitAction)->getTable();
		try {
			$query = DB::table($unit_table_name)
			->join($unit_action_table_name, $unit_table_name.'.unit_action_id', '=', $unit_action_table_name.'.id' )
			->groupBy($unit_action_table_name.'.action')
			->select(DB::raw('count(units.id) as count'), 'unit_actions.action');

			return response()->json([ 
				'data' => $query->get(),
				'code' => 200,
				'message' => __('Success')
			]);
		} catch (\Exception $e) {
			return $this->sendErrorJsonResponse( __('There are some problems while trying to updating your request'), 500);
		}
	}
}
