<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use App\Http\Resources\PaymentOption;
use App\Http\Resources\Unit;
use App\Http\Resources\Project;
use App\Http\Resources\ContractRequestAttachment;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractRequest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *w
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);  
        $data['created_by'] = User::make($this->whenLoaded('createdBy'));
        // $data['unit_type'] = UnitType::make($this->whenLoaded('unitType'));
        $data['unit'] = Unit::make($this->whenLoaded('unit'));
        $data['payment_option'] = PaymentOption::make($this->whenLoaded('paymentOption'));
        $data['sale_team_leader'] = User::make($this->whenLoaded('saleTeamLeader')); 
        $data['unit_controller_approver'] = User::make($this->whenLoaded('unitControllerApprover'));
        $data['sale_manager_approver'] = User::make($this->whenLoaded('saleManagerApprover'));
        $data['unit_controller_rejector'] = User::make($this->whenLoaded('unitControllerRejector')); 
        $data['sale_manager_rejector'] = User::make($this->whenLoaded('saleManagerRejector'));
        $data['attachments'] = ContractRequestAttachment::collection($this->whenLoaded('attachments'));
        $data['__type'] = "contract_request";
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
