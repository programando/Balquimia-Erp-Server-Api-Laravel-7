<?php

namespace App\Mail;

use config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPaswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $from;
    public $Email, $Token  ;

    public function __construct( $Email, $Token )
    {
        $this->Email = $Email;
        $this->Token = $Token;
        $this->from = ['address'=>'sistemas@balquimia.com', 'name' => config('balquimia.EMPRESA' )];

    }

  
    public function build()
    {
        return $this->view('mails.users.password-reset')
                    ->from( $this->from )
                    ->subject('Cambio de contraseña') ;
                    
                    
    }
}
