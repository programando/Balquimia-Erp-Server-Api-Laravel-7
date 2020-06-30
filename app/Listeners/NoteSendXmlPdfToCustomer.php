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
        $Emails =   $event->Note['emails']->unique('email')  ;     
        $when   = now()->addSeconds(5);
        Mail::to( $Emails )
                  ->cc('auxcontable@balquimia.com')
                  ->later( $when,new CreditNoteSentToCustomerMail(
                            $event->Note ,
                            $event->FilePdf, $event->FileXml, 
                            $event->PathPdf, $event->PathXml
                            ));
    }
}
