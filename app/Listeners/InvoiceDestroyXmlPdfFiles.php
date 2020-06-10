<?php

namespace App\Listeners;

use App\Events\InvoiceWasCreated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceDestroyXmlPdfFiles implements ShouldQueue
{

    public function handle(InvoiceWasCreated $event) {      
        /* Storage::disk('Files')->delete( $event->FilePdf);
        Storage::disk('Files')->delete( $event->FileXml);   */
    }
}
