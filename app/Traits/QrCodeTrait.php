<?php

namespace App\Traits;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait QrCodeTrait {

   public function QrCodeGenerateTrait ( $DataCode ){
      if ( empty($DataCode )) {
         $DataCode ='QrCode is empty';
      }
      return  QrCode::format('png')->size(330)->encoding('UTF-8')->generate( $DataCode );

   }

}