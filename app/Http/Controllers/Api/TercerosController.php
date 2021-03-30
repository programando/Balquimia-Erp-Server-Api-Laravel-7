<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tercero as Terceros;

class TercerosController extends Controller
{
       public function clientesBuscarNomSucNitNomCcial(Request $FormData ){    
          $Clientes = Terceros::clientesActivosPorVendedor( $FormData->idTercVendedor )
                      ->clientesBuscarNomSucNitNomCcial( $FormData->filtroBusqueda)
                      ->select('nro_identif','id_terc','nom_full','nom_suc')
                      ->orderBy('nom_full')->get();
                                 
        return  $Clientes;
        //  \Log::info("mensaje");
    }
}
