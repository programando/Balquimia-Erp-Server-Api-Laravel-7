<?php

namespace App\Traits;

use App\Librarys\GuzzleHttp;
use App\Models\FctrasElctrncasMcipio;
 
use Cache;
trait ApiSoenac {
   public $ApiSoenac ;

      public function __construct ( GuzzleHttp $GuzzleHttps ) {
         $this->ApiSoenac = $GuzzleHttps;
      }

      public function traitSoenacResolutions() {
         $Resoluciones = Cache::tags('Resoluciones')
                      ->rememberForEver('Resoluciones', function() {
                             return $this->ApiSoenac->getRequest('config/resolutions' ) ; 
                        }
                      );
         return  $Resoluciones  ;
      }

      public function traitSoenacResolutionsInvoice() {
         $Resolutions =   $this->ApiSoenac->getRequest('config/resolutions' ) ; 
         foreach ($Resolutions as $Resolution) {
            if ( $Resolution['id'] === 4 ){
               return $Resolution;
            }
         }
      }


        public function traitSoenacTables()   {
            $response =    $this->ApiSoenac->getRequest('listings' ) ;
            $Municipios  = $response['municipalities'];
            foreach ($Municipios as $Municipio) {
                $Registro               = new FctrasElctrncasMcipio();
                $Registro['id_mcpio']   = $Municipio['id'];
                $Registro['cod_mcpio']  = $Municipio['code'];
                $Registro['name_mcpio'] = $Municipio['name'];
                $Registro->save();
            }
        }


}
