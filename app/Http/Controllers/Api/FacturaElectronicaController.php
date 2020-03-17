<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FacturaElectronica as Facturas;
use App\Http\Controllers\Controller;

class FacturaElectronicaController extends Controller
{
    public function index() {
        //$DiasFinanciacion   = DB::select(' call ped_dias_financiacion() ');
      /**
         * @OA\Info(title="Facturas Electrónicas", version="0.1")
         */

        /**
         * @OA\Get(
         *     path="/api/facturas",
         *     @OA\Response(response="200", description="Listado de facturas creadas ")
         * )
         */
        return Facturas::all();
    }
}
