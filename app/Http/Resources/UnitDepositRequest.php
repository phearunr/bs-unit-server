<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitDepositRequest extends JsonResource
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
        $data['unit_controller'] = User::make($this->whenLoaded('unitController'));
        $data['sale_manager'] = User::make($this->whenLoaded('saleManager'));
        $data['created_by'] = User::make($this->whenLoaded('createdBy'));
        $data['unit'] = Unit::make($this->whenLoaded('unit'));
        $data['payment_option'] = PaymentOption::make($this->whenLoaded('paymentOption'));
        $data['change_from'] = $this::make($this->whenLoaded('changeFrom'));
        $data['change_to'] = $this::make($this->whenLoaded('changeTo'));
        $data['__type'] = "unit_deposit_request";
        return $data;     
    }
}
