<?php

namespace App\Http\Controllers\Api;
use Storage;
use App\Traits\ApiSoenac;

use App\Traits\PdfsTrait;
use App\Traits\QrCodeTrait;
use Illuminate\Http\Request;
use App\Helpers\DatesHelper ;

use App\Models\FctrasElctrnca;
use App\Helpers\GeneralHelper  ;
use App\Events\NoteWasCreatedEvent;
use App\Http\Controllers\Controller;
use App\Traits\FctrasElctrncasTrait;

class FctrasElctrncasNotesCrController  
{
    use FctrasElctrncasTrait,  ApiSoenac, QrCodeTrait, PdfsTrait;

    private $jsonObject = [] ;
    private  $keyMonetary ,$keyLines ;
    
    public function notes( $TipoNota ) {
          $URL = $this->getNotesUrl($TipoNota );
           
          if ( $URL == 'NoUrl') return ;
            $Documentos = FctrasElctrnca::CreditNotesToSend()->get();  
             
            foreach ($Documentos as $Documento ) {
               $this->notesToSend ( $Documento, $TipoNota) ;
               $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject ) ;  
               $this->traitUpdateJsonObject ( $Documento );
               $this->documentsProcessReponse( $Documento, $response ) ;  
            }  
      }

     private function getNotesUrl ($TipoNota) {
            if ( $TipoNota  == 'cr')  return 'credit-note';
            if ( $TipoNota  == 'db')  return 'debit-note' ;
            return 'NoUrl';
        }

      private function notesToSend ( $Notes, $TipoNota ){
        $this->jsonObject = [];
        $id_fact_elctrnca = $Notes['id_fact_elctrnca'];    
        $otherDataNote = FctrasElctrnca::with('customer','total', 'products', 'emails','noteBillingReference','noteDiscrepancy')->where('id_fact_elctrnca', $id_fact_elctrnca)->get();   
        $this->jsonObjectCreate ($Notes , $otherDataNote, $TipoNota  );           
      }


        private function jsonObjectCreate ( $Note, $Others, $TipoNota  ) { 
            $this->getKeyToCreate($TipoNota );
            $this->traitDocumentHeader           ( $Note , $this->jsonObject  );
            $this->billingReference              ( $Others[0]['noteBillingReference'] );
            $this->discrepancy                   ( $Others[0]['noteDiscrepancy']      ) ;
            $this->traitEmailSend                ( $Others[0]['emails']    , $this->jsonObject  );
            $this->traitNotes                    ( $Note      , $this->jsonObject  );
            $this->traitOrderReference           ( $Note      , $this->jsonObject  );
            $this->traitReceiptDocumentReference ( $Note      , $this->jsonObject  );
            $this->traitCustomer                 ( $Others[0]['customer']  , $this->jsonObject  );
            //$this->traitCharges                  ( $Others[0]['charges']  , $this->jsonObject  );
            $this->traitLegalMonetaryTotals      ( $Others[0]['total']     , $this->jsonObject, $this->keyMonetary  );
            $this->traitInvoiceLines             ( $Others[0]['products']  , $this->jsonObject, $this->keyLines  );  
        }
      
     private function getKeyToCreate ( $TipoNota)  {
        if ( $TipoNota=='cr')  {
            $this->keyMonetary ='legal_monetary_totals';
            $this->keyLines    ='credit_note_lines';
        }
        if ( $TipoNota=='db')  { 
            $this->keyMonetary ='requested_monetary_totals';              
            $this->keyLines    ='debit_note_lines';
        }
     }

     private function billingReference ( $BillingRef ){
            $this->jsonObject['billing_reference'] =[
                'number'       => (string)$BillingRef['number'],
                'uuid'         => $BillingRef['uuid'],
                'issue_date'   => DatesHelper::YMD($BillingRef['issue_date'])
            ];
     }
     
     private function discrepancy ( $Discrepancy  ){
           $this->jsonObject['discrepancy_response'] =[
                'number'                => $Discrepancy['reference'],
                'correction_concept_id' => $Discrepancy['correction_concept_id'],
                'description'           => $Discrepancy['description'],
            ];
     }

     private  function documentsProcessReponse( $Documento,  $response ){      
            $idfact_elctrnca     = $Documento['id_fact_elctrnca']  ;       
            if ( array_key_exists('is_valid',$response) ) {
                $this->responseContainKeyIsValid($idfact_elctrnca, $response );  
            } else {
                 $this->traitdocumentErrorResponse( $idfact_elctrnca, $response ); 
            } 
    } 

    private function responseContainKeyIsValid($idfact_elctrnca , $response ){
        if ( $response['is_valid'] == true || is_null( $response['is_valid'] ) ) {
            $this->traitDocumentSuccessResponse ( $idfact_elctrnca , $response );
            $this->noteSendToCustomer  ( $idfact_elctrnca ); 
        }else {
            $this->traitdocumentErrorResponse( $idfact_elctrnca, $response );     
        }
    }

    public function noteSendToCustomer ( $id_fact_elctrnca ) {
        $Note = FctrasElctrnca::with('customer','total', 'products', 'emails', 'Additionals', 'noteBillingReference','noteDiscrepancy','serviceResponse')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
        $Note = $Note[0];
        $this->getNameFilesTrait($Note, true );
        $this->noteCreateFilesToSend ( $id_fact_elctrnca, $Note);
        NoteWasCreatedEvent::dispatch ($Note);
    } 

    private function noteCreateFilesToSend ( $id_fact_elctrnca, $Note){
     $Resolution = $this->traitSoenacResolutionsNotes();
     $this->saveNotePdfFile ($Resolution, $Note );
     $this->saveNoteXmlFile ( $Note             );
    }

    private function saveNotePdfFile ($Resolution , $Note ) {
        $Fecha            = $this->FechaNota ( $Note['fcha_dcmnto'] );
        $Customer         = $Note['customer'];
        $Products         = $Note['products'];
        $CantProducts     = $Products->count();
        $Totals           = $Note['total'];
        $BillingReference = $Note['noteBillingReference'];
        $Discrepancy      = $Note['Discrepancy'];
        $Additionals      = $Note['Additionals'];
        $ServiceResponse  = $Note['serviceResponse'];
        $CodigoQR         = $this->QrCodeGenerateTrait( $ServiceResponse['qr_data'] );
        $DocumentNumber   = $this->DocumentNumber;
        $Data             = compact('Resolution', 'Fecha', 'Note','Customer', 'Products','CantProducts', 'Totals','CodigoQR','Additionals','DocumentNumber' );
        $PdfContent       = $this->pdfCreateFileTrait('pdfs.credit-note', $Data);
        Storage::disk('Files')->put( $this->PdfFile, $PdfContent);
    }

        private function FechaNota ( $FechaFactura ) {
            $Fechas       = [];
            $FechaFactura = DatesHelper::DocumentDate( $FechaFactura  );
            $Fechas = [
                'FactDia'   => $FechaFactura->day,
                'FactMes'   => GeneralHelper::nameOfMonth( $FechaFactura->month),
                'Factyear'  => $FechaFactura->year,
            ];
            return $Fechas;
        }

        private function saveNoteXmlFile ( $Note ) {
            $Note         = $Note['serviceResponse'];
            $base64_bytes = $Note['attached_document_base64_bytes'];
            Storage::disk('Files')->put( $this->XmlFile, base64_decode($base64_bytes));
        }

}
