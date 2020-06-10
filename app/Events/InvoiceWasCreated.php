<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvoiceWasCreated
{
    use Dispatchable,  SerializesModels;
    
    public $Factura, $FileXml, $FilePdf, $PathPdf, $PathXml ;
 
    public function __construct( $Factura )  {
         $this->Factura = $Factura ;
         $this->getFileNames();
         
    }

    private function getFileNames(){     
         $this->FilePdf = $this->Factura['xml_file_name']. '.pdf' ;
         $this->FileXml = $this->Factura['xml_file_name']. '.xml' ;
         $this->PathPdf = Storage::disk('Files')->path( $this->FilePdf  );
         $this->PathXml = Storage::disk('Files')->path( $this->FileXml );
    }
 
}
