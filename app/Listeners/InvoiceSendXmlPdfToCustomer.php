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
        $Emails = $this->getAcountsToSendEmail ( $event->Factura['emails'] );
        $when   = now()->addSeconds(5);
        Mail::to( $Emails )
                  ->cc('jhonjamesmg@hotmail.com')
                  ->later( $when,new InvoiceSendToCustomerMail(
                            $event->Factura ,
                            $event->FilePdf, $event->FileXml, 
                            $event->PathPdf, $event->PathXml
                            ));
    }

    private function getAcountsToSendEmail( $Emails ) {
        //$Emails  = array_values(array_unique($Emails ));
         foreach ($Emails as $email) {
             $Enviar[]=$email['email'];
         }
         return $Enviar;
    }

}
