<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitConstruction extends JsonResource
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
        
        $data['__type'] = "unit_construction";
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
