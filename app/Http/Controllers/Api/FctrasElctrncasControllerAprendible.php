<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FctrasElctrnca   ;
use App\Http\Resources\ModelManyRecordsCollection as RecordCollection;
use App\Http\Resources\ModelSimpleRecordsResource as RecordSimple;

class FctrasElctrncasController extends Controller
{
    public function index() {
        $FctrasElctrnca = FctrasElctrnca::applyFilters()->applySorts()->jsonPaginate();
        return RecordCollection::make( $FctrasElctrnca );
    }

    public function show(FctrasElctrnca $FctrasElctrnca ) {
        return RecordSimple::make( $FctrasElctrnca);
    }
}
