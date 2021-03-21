<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Prdcto as Prdctos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\PrdctosResource;
use App\Http\Resources\ShowRecordSimple;
use App\Http\Resources\ShowRecordCollection;

class PrdctoController extends Controller
{
    public function listaPrecios() {

        $ProductosPrecios = Cache::tags('ProductosPrecios')->rememberForever('ProductosPrecios', function()  {
              return     DB::select(' call prdctos_erp_lista_precios_all ()');
        });
        return $ProductosPrecios;

       
    }

    public function show( $idproducto  ){
         $Prdcto = Prdctos::findOrFail( $idproducto )   ;
         return ShowRecordSimple::make( $Prdcto);
    }


}
