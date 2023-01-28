<?php

namespace App\Http\Controllers\Admin;

use App\ContractAttachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractAttachmentController extends Controller
{

	public function delete(Request $request, $id) {
		try {
			ContractAttachment::destroy($id);
			if ($request->ajax()) {
				return response()->json([
				    'status' => 'success',
				    'message' => 'Contract attachment has been deleted successfully'
				]);
			}
			return back()->with('status',"Contract attachment has been deleted successfully");
		} catch (\Exception $e) {
			if ( $request->ajax() ) {
				return response()->json([
				    'status' => 'error',
					'message' => $e->getMessage()
				]);
			}
			return back()->withInput()->withErrors([ 'contract_attachment' => $e->getMessage()]);			
		}
	}
}
