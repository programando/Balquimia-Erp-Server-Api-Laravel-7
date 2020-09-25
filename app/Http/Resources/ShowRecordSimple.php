<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowRecordSimple extends JsonResource
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
                'type'       => $this->resource->type,
                'id'         => (string) $this->resource->getRouteKey(),
                'attributes' => $this->resource->fields(),
                'links'      => [
                    'self'   => route($this->resource->type.'.show', $this->resource),
                ]
            
        ];
    }
}
