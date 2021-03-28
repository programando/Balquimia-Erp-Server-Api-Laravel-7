<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CarteraFactura as Cartera;

class CarteraFacturasController extends Controller
{
    public function clientesCxcPorVendedor (Request $formData) { 
        return Cartera::ClientesPorVendedor ( $formData->idTercVendedor );
    }

    public function facturasPorNit (Request $formData) {
        return Cartera::FacturasPorNit ( $formData->nitCliente);
    }

    public function totalPorVendedor (Request $formData) {
        return Cartera::TotalPorVendedor (  $formData->idTercVendedor );
    }


}
