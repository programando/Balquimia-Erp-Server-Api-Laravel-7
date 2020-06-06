<?php
namespace App\Helpers;

use Cache;
class FilesHelper {

 

 /*        if (!function_exists('FileName')) { */
            /** * MARZO 18 2018
             * Retorna un nombre unico de archivo*/
            function FileName( $File, $Hach ) {
                 return 'file_' . $Hach.'.'.$File->getClientOriginalExtension();
            }
        
         
            /** * MARZO 18 2018
             * Retorna un nombre unico de archivo*/
            function FileExtension( $File ) {
                 return $File->getClientOriginalExtension();
            }
        


       
            /** MARZO 18 2018
             * Retorna un nombre unico de archivo */
            function FileUnqName( $File ) {
                return  'file_' . time().'.'.$File->getClientOriginalExtension();
            }
         

}