<?php

namespace App\Listeners;

 
use App\Mail\UserPaswordResetMail;
use Illuminate\Support\Facades\Mail;
use App\Events\UserPasswordResetEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPasswordReset
{
 
    
    public function handle(UserPasswordResetEvent $event)    {
       
         Mail::to( $event->Email)
            ->queue( new UserPaswordResetMail (  $event->Email, $event->Token  ));
    }
}
