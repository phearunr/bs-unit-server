<?php

namespace App\Http\Resources;

use App\Http\Resources\IdentificationImage;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $data = parent::toArray($request);        
        $data['__type'] = "user";
        $data['identifications'] = IdentificationImage::collection($this->whenLoaded('identifications'));
        $data['manager'] = $this->make($this->whenLoaded('manager'));          

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
