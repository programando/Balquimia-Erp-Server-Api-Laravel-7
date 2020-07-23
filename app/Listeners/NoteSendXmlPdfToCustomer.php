<?php

namespace App\Listeners;

use App\Events\NoteWasCreatedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\CreditNoteSentToCustomerMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class NoteSendXmlPdfToCustomer
{
     
    public function handle(NoteWasCreatedEvent $event) {
        
        // $EmailSubject  .= ';91;' => Tipo documento nota crédito según tabla de la DIAN. Juio 24 2020

        $EmailSubject   = config('balquimia.NIT').";".config('balquimia.EMPRESA').";".$event->Note['prfjo_dcmnto'] .$event->Note['nro_dcmnto'] ;
        $EmailSubject  .= ';91;'.config('balquimia.EMPRESA');

        $Emails =   $event->Note['emails']->unique('email')  ;     
        $when   = now()->addSeconds(5);
        Mail::to( $Emails )
                  ->cc('auxcontable@balquimia.com')
                  ->later( $when,new CreditNoteSentToCustomerMail(
                            $event->Note ,
                            $event->FilePdf, $event->FileXml, 
                            $event->PathPdf, $event->PathXml,
                            $EmailSubject, 
                            $event->ZipPathFile, $event->ZipFile
                            ));
    }
}
