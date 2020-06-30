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

class NoteWasCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Note, $FileXml, $FilePdf, $PathPdf, $PathXml ;
 
    public function __construct( $Note )  {
         $this->Note = $Note ;
         $this->getFileNames();
    }

    private function getFileNames(){     
         $this->FilePdf = $this->Note['prfjo_dcmnto']. $this->Note['document_number']. '.pdf' ;
         $this->FileXml = $this->Note['prfjo_dcmnto'].$this->Note['document_number']. '.xml' ;
         $this->PathPdf = Storage::disk('Files')->path( $this->FilePdf  );
         $this->PathXml = Storage::disk('Files')->path( $this->FileXml );
    }

  
}
