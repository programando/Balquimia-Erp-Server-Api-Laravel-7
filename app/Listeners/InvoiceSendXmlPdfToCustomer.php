<?php

namespace App\Listeners;

use App\Events\InvoiceWasCreated;
use App\Mail\InvoiceSendToCustomerMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use Storage;
class InvoiceSendXmlPdfToCustomer implements ShouldQueue
{
 
    public function handle(InvoiceWasCreated $event) {
           
        Mail::to('jhonjamesmg@hotmail.com')
                  ->queue(new InvoiceSendToCustomerMail(
                            $event->Factura ,
                            $event->FilePdf, $event->FileXml, 
                            $event->PathPdf, $event->PathXml
                            ));

    }
}
