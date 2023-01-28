<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use App\Http\Resources\UnitAction;
use App\Http\Resources\UnitActionCollection;
use App\Http\Resources\UnitType;
use App\Http\Resources\ConstructionProcedureCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class Unit extends JsonResource
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
        $data['created_by'] = User::make($this->whenLoaded('createdBy'));
        $data['action'] =  UnitAction::make($this->whenLoaded('action'));
        $data['actions'] =  UnitActionCollection::collection($this->whenLoaded('actions'));
        $data['unit_type'] = UnitType::make($this->whenLoaded('unitType'));
        $data['construction_procedures'] = ConstructionProcedureCollection::collection($this->whenLoaded('constructionProcedures'));
        $data['__type'] = "unit";
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
