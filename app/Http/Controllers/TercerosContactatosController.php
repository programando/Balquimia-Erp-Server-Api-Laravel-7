<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TercerosContactosMail;

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
         TercerosContactosEvent::dispatch( $formDataContact->all());
         return 'emailSendOk';
    }
}
