<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use App\Http\Resources\Unit;
use App\Http\Resources\UnitContractRequestAttachment;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitContractRequest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['attachments'] = UnitContractRequestAttachment::collection($this->whenLoaded('attachments'));
        $data['unit'] = Unit::make($this->whenLoaded('unit'));
        $data['unit_deposit_request'] = UnitDepositRequest::make($this->whenLoaded('unitDepositRequest'));
        $data['created_by'] = User::make($this->whenLoaded('createdBy'));
        $data['actioned_by'] = User::make($this->whenLoaded('actionedBy'));
        $data['__type'] = "unit_contract_request";
        return $data;
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'code' => 200,
            'message' => __("Success")
        ];
    }
}
