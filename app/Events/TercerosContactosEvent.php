<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TercerosContactosEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $formDataContact ;
    public $email, $comentario;

    public function __construct( $email, $comentario)
    {
        //$this->formDataContact       = $formDataContact ;
        $this->email = $email;
        $this->comentario = $comentario;
        
    }  
}
