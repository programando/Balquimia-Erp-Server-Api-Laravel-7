<?php

namespace App\Helpers;

class StringsHelper {


   public static function isEmptyOrNull( $value ) {
       $value  = trim($value );
      if ( empty($value) or is_null( $value )  ) {
                return true;
            }else {
                return false;
            }
      }


}
?>