<?php

namespace App\Http\Resources;

use App\Http\Resources\ShowRecordSimple;
 
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShowRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          
         return [
            'data' => ShowRecordSimple::collection ( $this->collection),
        ];
    }
}
