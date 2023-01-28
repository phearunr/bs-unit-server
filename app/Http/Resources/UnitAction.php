<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use App\Http\Resources\Unit;
use App\Http\Resources\UnitHoldRequest;
use App\Http\Resources\UnitDepositRequest;
use App\Http\Resources\UnitContractRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitAction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $actionable_type = $this->actionable_type;
        $data = parent::toArray($request);
        $data['unit'] = Unit::make($this->whenLoaded('unit'));
        $data['created_by'] = User::make($this->whenLoaded('createdBy'));
        $data['actionable'] = $this->when($actionable_type != '', function () use ($actionable_type) {
            switch ($actionable_type) {
                case 'App\UnitDepositRequest':
                    return UnitDepositRequest::make($this->whenLoaded('actionable'));
                    break;
                case 'App\UnitHoldRequest':
                    return UnitHoldRequest::make($this->whenLoaded('actionable'));
                    break;
                case 'App\UnitHoldRequest':
                    return UnitHoldRequest::make($this->whenLoaded('actionable'));
                    break;
                case 'App\UnitContractRequest':
                    return UnitContractRequest::make($this->whenLoaded('actionable'));
                    break;
                default:
                    return null;
                    break;  
            }         
        });        
        $data['__type'] = "unit_action";
        return $data;
    }
}
