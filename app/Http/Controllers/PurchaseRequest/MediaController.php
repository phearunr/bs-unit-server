<?php

namespace App\Http\Controllers\PurchaseRequest;

use Validator;
use App\PurchaseRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{

	protected $purchase_request = null;
	
	public function __construct(Request $request)
	{		
		$this->purchase_request = PurchaseRequest::where('id', $request->purchase_request_id)->first();		
	}

	public function store(Request $request)
	{		
        if ( $request->user()->id != $this->purchase_request->user_id ) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [          
            'media.*' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $data = null;

        foreach($request->file('media') as $file) {
            $filename = md5(time()).'.'.$file->getClientOriginalExtension();
            $data[] = $this->purchase_request->addMedia($file)
                                ->usingFileName($filename)
                                ->toMediaCollection();
        }

        return $data;
	}

    public function destroy(Request $request, $purchase_request_id, $media_id) {
        if ( $request->user()->id != $this->purchase_request->user_id ) {
            abort(403);
        }
        try {
        	if ( $request->wantsJson() ) {
        		return $this->purchase_request->deleteMedia($media_id);
        	}

        	$this->purchase_request->deleteMedia($media_id);

      		return back()->with('status', "The media has been deleted successfully.");

        } catch (\Exception $e) {
        	if ( $request->wantsJson() ) {
        		return response()->json(['message' => __('Internal Server Error!')], 500);        		
        	}

      		return back()->withErrors([ 'purchase_request' => $e->getMessage() ]);
        }    
    }
}
