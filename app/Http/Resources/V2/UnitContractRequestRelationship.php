<?php

namespace App\Http\Resources\V2;

use App\Http\Resources\V2\UserIdentifier;
use App\Http\Resources\V2\UnitIdentifier;
use App\Http\Resources\V2\UnitDepositRequestIdentifier;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitContractRequestRelationship extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'unit' => [             
                "data" => new UnitIdentifier($this->unit)
            ],
            'created_by' => [
                "data" => new UserIdentifier($this->createdBy)
            ],
            'unit_deposit_request' => [
                'links' => [
                    'self' => route('api.unit_deposit_request.show', ['id'=> $this->unit_deposit_request_id])
                ],
                "data" => new UnitDepositRequestIdentifier($this->unitDepositRequest)
            ],
            'attachments' => [
                "data" => UnitContractRequestAttachmentIdentifier::collection($this->attachments)
            ],
            'actioned_by' => [
                'data' =>  new UserIdentifier($this->actionedBy)
            ]
        ];
    }
}
