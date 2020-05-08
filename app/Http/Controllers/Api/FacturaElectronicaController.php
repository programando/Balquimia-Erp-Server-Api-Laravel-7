<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\FacturaElectronica as Facturas;
use Illuminate\Support\Collection;

use DB;

/*
    App\Http\Controllers\ApiController:  
            Controlador base desde donde extienden todos los demás controladores
            Centraliza m{etodos de respuesta
*/

class FacturaElectronicaController extends ApiController
{
    public function index() {
        //$DiasFinanciacion   = DB::select(' call ped_dias_financiacion() ');
      /**
         * @OA\Info(title="Facturas Electrónicas", version="0.1")
         */

        /**
         * @OA\Get(
         *     path="/facturas",
         *     @OA\Response(response="200", description="Listado de facturas creadas ")
         * )
         */
        //$Facturas = Facturas::all()->take(10);
        //$Facturas =    Facturas::all()->take(10)->first() ;
        //$Facturas =    Facturas::where('id_fact_elctrnca','<','10')->first() ;
        $Facturas = DB::select(' call fact_01_enc_errores_envio_dian() ');
         
         return  $this->showAll(   collect( $Facturas )   );
        //return collect($Facturas );
    }
}
