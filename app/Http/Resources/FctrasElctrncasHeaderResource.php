<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FctrasElctrncasHeaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return  [
            "number"   => $this->resource->number,
            'customer' => FctrasElctrncasCustomerResource::collection($this->whenLoaded('customer')),
        ];
    }
}
