<?php

namespace App\Helpers;

class GeneralHelper {


   public static function nameOfMonth( $NumMes ) {
       $meses = [
           '1'  => 'Enero','2'=>'Febrero', '3'=>'Marzo', '4'=>'Abril', '5'=>'Mayo',
           '6'  => 'Junio','7'=>'Julio', '8'=>'Agosto', '9'=>'Septiembre', '10'=>'Octubre',
           '11' => 'Noviembre', '12'=>'Diciembre'
       ];
        return $meses[$NumMes];
      
      }

  
    
}
?>