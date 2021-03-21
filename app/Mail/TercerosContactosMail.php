<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TercerosContactosMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre, $email,$telefono,$celular  , $comentario ,  $empresa, $ciudad ; 
    public function __construct( $email, $comentario  )
    {
/*         $this->nombre     = $formDataContact['nombre'];
        $this->email      = $formDataContact['email'];
        $this->telefono   = $formDataContact['telefono'];
        $this->celular    = $formDataContact['celular'];
        $this->comentario = $formDataContact['comentario'];
        $this->empresa    = $formDataContact['empresa'];  */ 
        $this->email      =  $email;
        $this->comentario      = $comentario;
         
    }
    

    public function build()
    {   
        $customerName   = 'Contactar a : James'  ;
        $subject        = 'Contacto comercial';
        return $this->view('mails.terceros.contactos')
                ->from( $this->email , 'Contactar a : James' )
                ->subject($subject) ;
    }
}
