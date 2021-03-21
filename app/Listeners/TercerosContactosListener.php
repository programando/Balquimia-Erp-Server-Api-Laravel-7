<?php

namespace App\Listeners;

use App\Mail\TercerosContactosMail;
use Illuminate\Support\Facades\Mail;
use App\Events\TercerosContactosEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TercerosContactosListener
{
    
    public function handle( TercerosContactosEvent $event)
    {
        
        $when           = now()->addSeconds(3); 
         Mail::to( env('EMAILS_CONTACTOS') )
            ->later( $when, new TercerosContactosMail (  $event->email, $event->comentario )); 
    }
}
