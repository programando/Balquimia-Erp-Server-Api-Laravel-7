<?php

namespace App\Helpers;

class NumbersHelper {


   public static function jsonFormat( $value, $decimals) {
      return number_format ( $value, $decimals, '.', '');
   }



}
?>