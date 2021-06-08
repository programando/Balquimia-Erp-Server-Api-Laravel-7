<?php

namespace App\Listeners;

use config;
use Illuminate\Support\Facades\Mail;
use App\Events\InvoiceWasCreatedEvent;
use App\Mail\InvoiceSendToCustomerMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceSendXmlPdfToCustomer
{
    public function handle(InvoiceWasCreatedEvent $event) {
        $EmailSubject   = config('balquimia.NIT').";".config('balquimia.EMPRESA').";".$event->Factura['prfjo_dcmnto'] .$event->Factura['nro_dcmnto'] ;
        $EmailSubject  .= ';01;'.config('balquimia.EMPRESA');
        

        $Emails         =   $event->Factura['emails']->unique('email')  ;     
        $when           = now()->addSeconds(5);
        Mail::to( $Emails )
                  ->later( $when,new InvoiceSendToCustomerMail(
                            $event->Factura ,
                            $event->FilePdf, $event->FileXml, 
                            $event->PathPdf, $event->PathXml,
                            $EmailSubject, 
                            $event->ZipPathFile, $event->ZipFile
                            ));
    }
}
