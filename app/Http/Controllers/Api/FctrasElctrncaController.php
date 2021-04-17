<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FctrasElctrnca;

 
use App\Http\Controllers\ApiController;
use App\Http\Resources\ShowRecordSimple;
use App\Http\Resources\ShowRecordCollection;

class FctrasElctrncaController extends ApiController
{
 
    public function index()
    {
        $FctrasElctrnca = FctrasElctrnca::with('customer','emails')->applySorts()->jsonPaginate();
        //$FctrasElctrnca = FctrasElctrnca::with('customer','emails')->get();
        // return $FctrasElctrnca ;
        return ShowRecordCollection::make( $FctrasElctrnca );
    }

 
    public function show($idfcatura)    {
       $FctrasElctrnca = FctrasElctrnca::findOrFail( $idfcatura);
        return ShowRecordSimple::make( $FctrasElctrnca);
    }
 
 
}
