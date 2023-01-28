<?php

namespace App\Http\Controllers\Api;

use App\ContractRequest;
use App\Http\Resources\ContractRequestAttachment as ContractRequestAttachmentResource;
use App\Http\Resources\ContractRequestAttachmentCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractRequestAttachmentController extends Controller
{
    public function getByContractRequestId(Request $request, $contract_request_id)
    {
    	$contract_request = ContractRequest::findOrFail($contract_request_id);

    	return new ContractRequestAttachmentCollection( $contract_request->attachments );
    }
}
