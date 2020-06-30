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
    public $subject ='Nota crédito';
    public $FilePdf, $FileXml, $PathPdf, $PathXml;

    public function __construct($DatosToEmail, $FilePdf, $FileXml, $PathPdf, $PathXml ) {
        $this->Note    = $DatosToEmail;
        $this->FilePdf = $FilePdf;
        $this->FileXml = $FileXml;
        $this->PathPdf = $PathPdf;
        $this->PathXml = $PathXml;
    }

    public function build(){
        return $this->view('mails.notes.ToCustomer')
                    ->attach($this->PathPdf, [ 'as' => $this->FilePdf, 'mime' => 'application/pdf'])
                    ->attach($this->PathXml, [ 'as' => $this->FileXml, 'mime' => 'application/xml']);
    }
}
