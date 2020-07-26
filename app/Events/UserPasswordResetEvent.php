<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPasswordResetEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Email, $Token  ;

    public function __construct ( $Email, $Token )
    {
        $this->Email = $Email ;
        $this->Token = $Token;
         
    }

}
