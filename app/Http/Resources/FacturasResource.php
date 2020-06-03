<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacturasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
/*         $lineas = [];

        $lineas[0]['nombre_producto'] = 'Test';
        $lineas[0]['impuesto'][0]['id_impuesto'] = 1;
        $lineas[0]['impuesto'][0]['porcentaje'] = 19;
        $lineas[0]['impuesto'][0]['test'][0]['prueba'] = [];
        $lineas[0]['impuesto'][1]['id_impuesto'] = 2;
        $lineas[0]['impuesto'][2]['id_impuesto'] = 3;
 */
        

/*         $test = [];
        $test['number'] = 990000096;
        $test['type_document_id'] = 1;
        
        $test['customer'] = [
            'identification_number' => 1234567890,
            'name' => 'Test',
            'phone' => 1234567,
        ];

        $test['legal_monetary_totals'] => [
            'line_extension_amount' => '300000.00',
            ''
        ]; */





        return  [
            "number"   => $this->resource->number,
            "sync"     => true,
            "send"     => $this->when( $this->resource->send,true ),
            "cc"        => [
                        array( 
                            "email"=>$this->when( $this->resource->cc_email,$this->resource->cc_email )
                            )
                            ],
            "bc"    => [
                        array(
                            $this->when( $this->resource->cc_bc,$this->resource->cc_bc )
                            )
                            ],
            "notes"    => [
                            array(
                                "text" => $this->resource->notes 
                                )
                         ],
            "customer" => array(
                "identification_number" => '9454554',
                "name" => "pedro perez",
                "email" => "pedro@perez.com"
            ),
            
        ];
    }
}
