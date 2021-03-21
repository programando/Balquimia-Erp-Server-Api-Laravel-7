<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BtcraVta as Ventas;

class BtcraVtasController extends Controller
{
    public function ventasVendedorUltimosDosAnios( Request $FormData ) {
        return Ventas::vendedorUltimosDosAnios ( $FormData->idTercVendedor);
    }
    
}
