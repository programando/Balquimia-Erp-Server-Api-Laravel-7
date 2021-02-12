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
    public function __construct( $formDataContact  )
    {
        $this->nombre     = $formDataContact['nombre'];
        $this->email      = $formDataContact['email'];
        $this->telefono   = $formDataContact['telefono'];
        $this->celular    = $formDataContact['celular'];
        $this->comentario = $formDataContact['comentario'];
        $this->empresa    = $formDataContact['empresa'];  
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $customerName   = 'Contactar a :' . $this->nombre;
        $subject        = 'Contacto comercial';
        return $this->view('mails.terceros.contactos')
                ->from( $this->email , $customerName)
                ->subject($subject) ;
    }
}
