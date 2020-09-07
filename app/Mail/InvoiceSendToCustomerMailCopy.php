<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceSendToCustomerMailCopy extends Mailable
{
    use Queueable, SerializesModels;

    public $Factura;
    public $FilePdf, $FileXml, $PathPdf, $PathXml ;
    public $subject;
 
    public function __construct( $DatosToEmail, $FilePdf, $FileXml, $PathPdf, $PathXml, $subject ) {
        $this->Factura     = $DatosToEmail;
        $this->FilePdf     = $FilePdf;
        $this->FileXml     = $FileXml;
        $this->PathPdf     = $PathPdf;
        $this->PathXml     = $PathXml;
        $this->subject     = $subject;
    }

     public function build()  {        
         return $this->subject( $this->subject)->view('mails.invoices.ToCustomer')
                     ->attach(  $this->PathPdf, [ 'as' => $this->FilePdf, 'mime' => 'application/pdf'])
                     ->attach(  $this->PathXml, [ 'as' => $this->FileXml, 'mime' => 'application/xml']);
    }

}
