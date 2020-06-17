<?php
namespace App\Helpers;

class FoldersHelper {

     /** * MARZO 18 2018.  Retorna ruta base para el almacenamiento de imagenes */
    public static function UserImages() {
       return   asset('storage/images/users/');
    }

    public static function Images ( $Archivo ) {
       return   asset('storage/images/'.$Archivo);
    }

    public static     function ImagesApp( ) {
       return    asset('storage/images/app/');
   }

   public static function cssFile( $archivo ) {
       return    asset('public/storage/css/'.$archivo) ;
   }

   

}