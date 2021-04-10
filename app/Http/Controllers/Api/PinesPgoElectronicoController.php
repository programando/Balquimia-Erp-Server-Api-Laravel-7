<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PinesPgoElectronico as PinPagoOnline;

class PinesPgoElectronicoController extends Controller
{
    public function buscar (Request $FormData ) {
        return PinPagoOnline::BuscarPin($FormData->nro_pin );
    }
}
