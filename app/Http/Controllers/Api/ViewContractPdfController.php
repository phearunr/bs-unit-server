<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Contract;
use App\Helpers\UserRole;
use App\Http\Controllers\Admin\ContractPdfController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewContractPdfController extends Controller
{
   	public function get(Request $request, $id)
    {
    	$auth_user = $request->user();    	
    	$contract = Contract::findOrFail($id);

    	// check Ownership
    	if ( $auth_user->hasRole(UserRole::SALE_TEAM_LEADER) ) {
    		$agent = User::findOrFail($contract->agent_id);
    		if ( $agent->managed_by != $auth_user->id ) {
    			return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 422 );
    		}
        } elseif ( $auth_user->hasRole(UserRole::AGENT) ) {
        	if ( !$contract->isAgent(Auth::id()) ) {
	    		return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 422 );
	    	}
        }

        $contract_pdf = New ContractPdfController($contract);

        $language = $request->language ?? 'km';
        $version = $request->version ?? 'v2';
        return $contract_pdf->getContractPdf($language, $version);
    }
}
