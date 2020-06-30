<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Events\InvoiceWasCreatedEvent;
use App\Mail\InvoiceSendToCustomerMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceSendXmlPdfToCustomer
{
    public function handle(InvoiceWasCreatedEvent $event) {
        $Emails =   $event->Factura['emails']->unique('email')  ;     
        $when   = now()->addSeconds(5);
        Mail::to( $Emails )
                  ->later( $when,new InvoiceSendToCustomerMail(
                            $event->Factura ,
                            $event->FilePdf, $event->FileXml, 
                            $event->PathPdf, $event->PathXml
                            ));
    }
 

}
