<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PinesPgoElectronico as PinPagoOnline;

class PinesPgoElectronicoController extends Controller
{
    public function buscarPin (Request $FormData ) {
        return PinPagoOnline::BuscarPin($FormData->nro_pin );
    }
    public function buscarPedido (Request $FormData ) {
        return PinPagoOnline::BuscarPedido($FormData->id_ped );
    }
    
    public function buscarFactura (Request $FormData ) {
        return PinPagoOnline::BuscarFactura($FormData->prfjo_rslcion, $FormData->num_fact );
    }

}
