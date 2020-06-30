<?php

namespace App\Traits;
use Illuminate\Support\Facades\App;

trait PdfsTrait {


private function pdfCreateFileTrait ( $View, $DataFile ) {
   $pdf    = App::make('dompdf.wrapper');
   return  $pdf->loadView($View, $DataFile )->output();
  }

}