<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TercerosContactosMail;

use Illuminate\Support\Facades\Mail;
use App\Events\TercerosContactosEvent;
use App\Http\Requests\TercerosContactosRequest;


class TercerosContactatosController extends Controller
{
    public function saveContacto ( TercerosContactosRequest $formDataContact)  { 
        $nombre     = $formDataContact['nombre'];
        $email      = $formDataContact['email'];
        $telefono   = $formDataContact['telefono'];
        $celular    = $formDataContact['celular'];
        $comentario = $formDataContact['comentario'];
        $empresa    = $formDataContact['empresa'];
         //TercerosContactosEvent::dispatch( $email,$comentario  );
         Mail::to( $email  )->send(new TercerosContactosMail( $email  , $comentario ));

         return $email;
    }
}
