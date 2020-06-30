<?php

namespace App\Helpers;

use Carbon\Carbon;

class DatesHelper {

 
   public static function YMD( $value ) {
        return date_format($value, 'Y-m-d');
   }

   public static function DMY( $value ) {
        return date_format($value, 'd/mm/Y');
   }


    public static function DocumentDate ( $Value ){
      return Carbon::createFromFormat('Y-m-d H:i:s', $Value);  
    }

    private function checkStringDate(  $value){
      if (date('d-m-Y', strtotime( $value )) == $value ) {
        $this->Fecha = $value;
        } else {
            return false;
        }
    }

/* $fecha = "2018-03-29 15:20:40";

$dt = new DateTime($fecha);
print $dt->format('d/m/Y'); // imprime 29/03/2018
 */


     /* ENERO 21 2019
        VALIDA QUE LA FECHA DE DESPACHO SEA VALIDA */
    public static function pedidosFechaDspachoValidar( $FechaDespacho ) {
        $FechaDespacho = Carbon::parse($FechaDespacho)->format('Y-m-d');
        $Hoy           = Carbon::now()->format('Y-m-d');
        if ( $FechaDespacho < $Hoy ){
            $FechaDespacho = $Hoy;
        }
        return Carbon::parse( $FechaDespacho );
    }

    
}
?>