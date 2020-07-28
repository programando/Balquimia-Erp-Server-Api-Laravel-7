<?php

namespace App\Listeners;

 
use App\Mail\UserPaswordResetMail;
use Illuminate\Support\Facades\Mail;
use App\Events\UserPasswordResetEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPasswordReset
{
    public $from;
    
    public function handle(UserPasswordResetEvent $event)    {
         //$this->from ='sistemas@balquimia.com';
         
         Mail::to( $event->Email)
            ->queue( new UserPaswordResetMail (  $event->Email, $event->Token  ));
    }
}
