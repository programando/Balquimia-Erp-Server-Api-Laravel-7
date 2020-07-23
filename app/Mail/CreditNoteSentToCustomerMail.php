<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreditNoteSentToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $Note;
    public $subject ;
    public $FilePdf, $FileXml, $PathPdf, $PathXml, $ZipFile, $ZipPathFile;

    public function __construct($DatosToEmail, $FilePdf, $FileXml, $PathPdf, $PathXml, $subject, $ZipPathFile, $ZipFile ) {
        $this->Note        = $DatosToEmail;
        $this->FilePdf     = $FilePdf;
        $this->FileXml     = $FileXml;
        $this->PathPdf     = $PathPdf;
        $this->PathXml     = $PathXml;
        $this->subject     = $subject;
        $this->ZipFile     = $ZipFile;
        $this->ZipPathFile = $ZipPathFile;
    }

    public function build(){
        return $this->subject( $this->subject)->view('mails.notes.ToCustomer')
                     ->attach(  $this->ZipPathFile, [ 'as' => $this->ZipFile, 'mime' => 'application/zip']);

/*         return $this->view('mails.notes.ToCustomer')
                    ->attach($this->PathPdf, [ 'as' => $this->FilePdf, 'mime' => 'application/pdf'])
                    ->attach($this->PathXml, [ 'as' => $this->FileXml, 'mime' => 'application/xml']); */
    }
}
