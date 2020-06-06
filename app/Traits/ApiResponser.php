<?php

namespace App\Traits;
use Illuminate\Support\Collection;

trait ApiResponser {

   private function succesReponse ( $data, $code ){
      return response()->json( $data, $code );
   }

   protected function errorResponse ( $message, $code ) {
      return response()->json(['error' => $message, 'code' => $code], $code );
   }
   
   /*    Marzo 30 2020
      Retorna una colleccion de datos 
   */
   protected function showAll( Collection $collection, $code = 200){
      return $this->succesReponse(['data' => $collection, 'code' => $code],  $code );
   }
   /*    Marzo 30 2020
      Retorna un solo dato 
   */
   protected function showOne( Model $instance, $code = 200){
      return $this->succesReponse(['data' => $instance], $code );
   }

}
