<?php

namespace App\Http\Resources\V2;

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
        return [
            'type' => 'unit_contract_request',
            'id' => (string)$this->id,
            'attributes' => array_except($this->attributesToArray(),['id']),  
            'relationships' => new UnitContractRequestRelationship($this),
            'links' => [
                'self' => route('api.unit_contract_request.show', ['id' => $this->id]),                
            ],
        ];
    }
}