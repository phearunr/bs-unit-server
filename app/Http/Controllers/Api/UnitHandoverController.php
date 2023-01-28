<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Comment;
use App\UnitHandoverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\CommentCollection;
use App\Http\Controllers\Controller;

class UnitHandoverController extends Controller
{
    public function getComments(Request $request, $id) {
		$unit_handover = UnitHandoverRequest::findOrFail($id);
		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			return new CommentCollection(
				$unit_handover->comments()
					 ->with($relationships)
					 ->paginate( $request->per_page ?? (New Comment)->getPerPage() )
			);
		}
		return new CommentCollection(
			$unit_handover->comments()
				 ->paginate( $request->per_page ?? (New Comment)->getPerPage() )
		);
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
		$unit_handover = UnitHandoverRequest::find($id);
		try {
			DB::beginTransaction();  
			$unit_handover->comments()->save($comment);
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
}
