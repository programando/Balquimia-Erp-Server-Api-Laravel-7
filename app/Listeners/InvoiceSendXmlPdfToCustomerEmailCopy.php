<?php

namespace App\Listeners;

use config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\InvoiceSendToCustomerMailCopy;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\InvoiceWasCreatedEventEmailCopy;

class InvoiceSendXmlPdfToCustomerEmailCopy
{
    public function handle(InvoiceWasCreatedEventEmailCopy $event) {
        $EmailSubject   = config('balquimia.NIT').";".config('balquimia.EMPRESA').";".$event->Factura['prfjo_dcmnto'] .$event->Factura['nro_dcmnto'] ;
        $EmailSubject  .= ';01;'.config('balquimia.EMPRESA');
        $Emails         =   $event->Factura['emails']->unique('email')  ;     
        $when           = now()->addSeconds(15);
        Mail::to( $Emails )
                  ->later( $when,new InvoiceSendToCustomerMailCopy(
                            $event->Factura ,
                            $event->FilePdf, $event->FileXml, 
                            $event->PathPdf, $event->PathXml,
                            $EmailSubject
                            ));
    }
}
