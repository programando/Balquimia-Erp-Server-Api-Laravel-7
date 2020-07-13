<?php

namespace App\Listeners;

use App\Events\UserPasswordResetEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserPasswordReset
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserPasswordResetEvent  $event
     * @return void
     */
    public function handle(UserPasswordResetEvent $event)
    {
        //
    }
}
