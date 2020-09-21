<?php

namespace App\Http\Resources;

use App\Http\Resources\ModelSimpleRecordsResource as SimpleRecord;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ModelManyRecordsCollection extends BaseResourceCollection
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
            'data' => SimpleRecord::collection ( $this->collection),
        ];
    }
}
