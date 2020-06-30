<?php

namespace App\Traits;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait QrCodeTrait {

   public function QrCodeGenerateTrait ( $DataCode ){
      return  QrCode::format('png')->size(330)->encoding('UTF-8')->generate( $DataCode );

   }

}