<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceSendToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $Factura;
    public $subject ='Nuevo documento electrónico';
    public $FilePdf, $FileXml, $PathPdf, $PathXml;
    
    public function __construct( $DatosToEmail, $FilePdf, $FileXml, $PathPdf, $PathXml ) {
        $this->Factura = $DatosToEmail;
        $this->FilePdf = $FilePdf;
        $this->FileXml = $FileXml;
        $this->PathPdf = $PathPdf;
        $this->PathXml = $PathXml;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()  {
         
         return $this->view('mails.facturacion.InvoiceToCustumer')
                    ->attach($this->PathPdf, [ 'as' => $this->FilePdf, 'mime' => 'application/pdf'])
                    ->attach($this->PathXml, [ 'as' => $this->FileXml, 'mime' => 'application/xml']);
                
    }
}
