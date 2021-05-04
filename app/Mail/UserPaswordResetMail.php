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

    public $from , $Email, $Token , $urlClient ;

    public function __construct( $Email, $Token )
    {
        $this->Email     = $Email;
        $this->Token     = $Token;
        $this->from      = ['address'=> config('balquimia.EMAIL_SISTEMAS'), 'name' => config('balquimia.EMPRESA' )];
        $this->urlClient = config('balquimia.APP_URL_CLIENT') . config('balquimia.URL_USER_PASSWORD_RESET').$Token;
    }

  
    public function build()
    {
    
        return $this->view('mails.terceros.users-password-reset')
                    ->from( $this->from )
                    ->subject('Cambio de contraseña') ;
                    
                    
    }
}
