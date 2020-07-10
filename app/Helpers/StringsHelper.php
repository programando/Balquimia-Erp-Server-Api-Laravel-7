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

    public static function UpperTrim( $String, $Long ) {
        $String = trim( $String );
        $String = preg_replace('/\s\s+/', ' ', $String  );
        $String = substr($String, 0, $Long  );
        $String = mb_strtoupper( $String,'UTF-8');
        return $String;
    }
    
    public static function LowerTrim ( $String) {
           $String = trim( $String );
           return mb_strtolower( $String,'UTF-8'); 
    }
    
}
?>