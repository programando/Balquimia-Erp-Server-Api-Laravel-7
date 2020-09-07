<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvoiceWasCreatedEventEmailCopy
{
    use Dispatchable,  SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $Factura, $FileXml, $FilePdf, $PathPdf, $PathXml, $ZipPathFile, $ZipFile ;
 
    public function __construct( $Factura )  {
         $this->Factura = $Factura ;
         $this->getFileNames();
    }

    private function getFileNames(){     
         $this->FilePdf = $this->Factura['document_number']. '.pdf' ;  //document_number
         $this->FileXml = $this->Factura['document_number']. '.xml' ;
         $this->ZipFile = $this->Factura['uuid'].'.zip';
         $this->PathPdf = Storage::disk('Files')->path( $this->FilePdf  );
         $this->PathXml = Storage::disk('Files')->path( $this->FileXml );
    }


}
