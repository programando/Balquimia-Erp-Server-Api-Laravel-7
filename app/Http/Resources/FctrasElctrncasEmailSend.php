<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\FctrasElctrncasEmailSendSimpleRecord;

class FctrasElctrncasEmailSend extends ResourceCollection
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
            'data' =>    FctrasElctrncasEmailSendSimpleRecord::collection ( $this->collection),
        ];
    }
}
