<?php

namespace App\Listeners;

use App\Events\InvoiceWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendXmlPdfToCustomer
{
     
 
    /**
     * Handle the event.
     *
     * @param  InvoiceWasCreated  $event
     * @return void
     */
    public function handle(InvoiceWasCreated $event)
    {
        dd( $event->Factura);
    }
}
