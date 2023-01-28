<?php

namespace App\Http\Resources;

use App\Http\Resources\Project;
use App\Http\Resources\ContractTemplate;
use App\Http\Resources\User;
use App\Http\Resources\PaymentOption;
use App\Http\Resources\Unit;
use App\Http\Resources\Media;
use App\Http\Resources\DiscountPromotion;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitType extends JsonResource
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
        $data['contract_template'] = ContractTemplate::make($this->whenLoaded('contractTemplate'));        
        $data['project'] = Project::make($this->whenLoaded('project'));
        $data['payment_options'] = PaymentOption::collection($this->whenLoaded('paymentOptions'));
        $data['units'] = Unit::collection($this->whenLoaded('units'));
        $data['created_by'] = User::make($this->whenLoaded('createdBy'));
        $data['media'] = Media::collection($this->whenLoaded('media'));
        $data['active_discount_promotions'] = DiscountPromotion::collection($this->whenLoaded('activeDiscountPromotions'));
        $data['__type'] = "unit_type";
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
