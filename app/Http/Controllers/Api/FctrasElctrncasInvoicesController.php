<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiSoenac;

use App\Traits\PdfsTrait;
use App\Traits\QrCodeTrait;
use App\Helpers\DatesHelper;
use Illuminate\Http\Request;

use App\Helpers\GeneralHelper  ;
use App\Models\FctrasElctrnca   ;

use App\Traits\FctrasElctrncasTrait;
use App\Models\FctrasElctrncasMcipio;
 
use App\Events\InvoiceWasCreatedEvent;
use App\Http\Controllers\ApiController;
use App\Events\InvoiceWasCreatedEventEmailCopy;

Use Storage;
Use Carbon;
use config;

class FctrasElctrncasInvoicesController  
{
   use FctrasElctrncasTrait, ApiSoenac, QrCodeTrait, PdfsTrait;

   private $jsonObject = [] ;
  
 
        public function invoices() {
            $URL = 'invoice'  ;
            $Documentos = FctrasElctrnca::InvoicesToSend()->get();       
            foreach ($Documentos as $Documento ) {
                $this->invoicesToSend ( $Documento) ;
                //return $this->jsonObject;
                $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject ) ;    
                $this->traitUpdateJsonObject ( $Documento );
                $this->documentsProcessReponse( $Documento, $response ) ;
                 
            }  
        }

        private function invoicesToSend ($Facturas)  {
            $this->jsonObject = [];
            $id_fact_elctrnca = $Facturas['id_fact_elctrnca'];    
            $otherDataInvoice = FctrasElctrnca::with('customer','total', 'products', 'emails')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
            $this-> jsonObjectCreate ($Facturas , $otherDataInvoice     );
        }

        private function jsonObjectCreate ( $invoce,  $Others ) {
                $this->traitDocumentHeader              ( $invoce , $this->jsonObject    );
                $this->traitEmailSend                   ( $Others[0]['emails']    , $this->jsonObject   );
                $this->traitNotes                       ( $invoce    , $this->jsonObject   );
                $this->traitOrderReference              ( $invoce    , $this->jsonObject   );
                $this->traitReceiptDocumentReference    ( $invoce    , $this->jsonObject   );
                $this->traitCustomer                    ( $Others[0]['customer']  , $this->jsonObject   );
                $this->traitPaymentForms                ( $invoce  , $this->jsonObject   );
                $this->traitLegalMonetaryTotals         ( $Others[0]['total']     , $this->jsonObject, 'legal_monetary_totals' );
                $this->traitInvoiceLines                ( $Others[0]['products']  , $this->jsonObject, 'invoice_lines'   );
                unset( $this->jsonObject['billing_reference']);
                unset( $this->jsonObject['discrepancy_response']);// No los necesito para facturas
            }

 
        private  function documentsProcessReponse($Documento,  $response ){
            $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;
            if ( array_key_exists('is_valid',$response) ) {
                $this->responseContainKeyIsValid ( $id_fact_elctrnca, $response );                   
            } else {       
                $this->traitdocumentErrorResponse( $id_fact_elctrnca, $response ); 
            }
        }

    private function responseContainKeyIsValid($idfact_elctrnca , $response ){
        if ( $response['is_valid'] == true || is_null( $response['is_valid'] ) ) {
            $this->traitDocumentSuccessResponse ( $idfact_elctrnca , $response );
            $this->invoiceSendToCustomer  ( $idfact_elctrnca ); 
        }else {
            $this->traitdocumentErrorResponse( $idfact_elctrnca, $response );     
        }
    }

       public function invoiceSendToCustomer ( $id_fact_elctrnca ) {
          $Factura      = $this->invoiceSendGetData ( $id_fact_elctrnca) ; 
          InvoiceWasCreatedEvent::dispatch          ( $Factura ) ; 
          InvoiceWasCreatedEventEmailCopy::dispatch ( $Factura );
       }


        private function invoiceSendGetData ( $id_fact_elctrnca ) {
             $Factura = FctrasElctrnca::with('customer','total', 'products', 'emails','additionals', 'serviceResponse')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
             $Factura = $Factura[0];
            $this->getNameFilesTrait($Factura );
            $this->invoiceCreateFilesToSend  ( $id_fact_elctrnca,  $Factura  );
            return $Factura;
        }

        public function invoiceFileDownload ( $fileType, $id_fact_elctrnca ) {
            $this->invoiceSendGetData ( $id_fact_elctrnca) ;
            if ( strtoupper( $fileType) == 'PDF') {
                return response()->download( Storage::disk('Files')->path( $this->PdfFile ) )->deleteFileAfterSend();
            }else {
                return response()->download( Storage::disk('Files')->path( $this->XmlFile ) )->deleteFileAfterSend();
            }
        }

        private function invoiceCreateFilesToSend ( $id_fact_elctrnca,  $Factura  ){
            $Resolution   = $this->traitSoenacResolutionsInvoice();                
            $this->saveInvoicePfdFile   ( $Resolution, $Factura );
            $this->saveInvoiceXmlFile   ( $Factura              );
        }

        private function saveInvoicePfdFile  ( $Resolution, $Factura   ){           
            $Fechas          = $this->FechasFactura ( $Factura['fcha_dcmnto'], $Factura['due_date'] );
            $Customer        = $Factura['customer'];
            $Products        = $Factura['products'];
            $Totals          = $Factura['total'];
            $Additionals     = $Factura['additionals'];
            $ServiceResponse = $Factura['serviceResponse'];
            $CantProducts    = $Products->count();         
            $CodigoQR        = $this->QrCodeGenerateTrait( $ServiceResponse['qr_data'] );
            $Data            = compact('Resolution', 'Fechas', 'Factura','Customer', 'Products','CantProducts', 'Totals','CodigoQR', 'Additionals' );
            $PdfContent      = $this->pdfCreateFileTrait('pdfs.invoice', $Data);
            Storage::disk('Files')->put( $this->PdfFile, $PdfContent);
        }

        private function saveInvoiceXmlFile ( $Factura) {
            $Factura      = $Factura['serviceResponse'];
            $base64_bytes = $Factura['attached_document_base64_bytes'];
            Storage::disk('Files')->put( $this->XmlFile, base64_decode($base64_bytes));
        }

        private function FechasFactura ( $FechaFactura, $FechaVencimiento) {
            $Fechas       = [];
            $FechaFactura = DatesHelper::DocumentDate( $FechaFactura  );  
            $FechaVcmto   = DatesHelper::DocumentDate( $FechaVencimiento  );
            $Fechas = [
                'FactDia'   => $FechaFactura->day,
                'FactMes'   => GeneralHelper::nameOfMonth( $FechaFactura->month),
                'Factyear'  => $FechaFactura->year,
                'VenceDia'  => $FechaVcmto->day,
                'VenceMes'  => GeneralHelper::nameOfMonth( $FechaVcmto->month),
                'VenceYear' => $FechaVcmto->year
            ];
            return $Fechas;
        }

        public function invoiceAccepted ( $Token ) {          
            $this->customerResponse ( $Token, 'ACEPTADA');
            return redirect('/');
        }

        public function invoiceRejected ( $Token  ){
            $this->customerResponse ( $Token, 'RECHAZADA');
            return redirect('/');
        }
 
 
        private function customerResponse ( $Token, $Reponse ) {
            $Factura      = FctrasElctrnca::where('cstmer_token', "$Token")->first();
            if ( empty( $Factura['cstmer_rspnse'] ) ) {
                $Factura->cstmer_rspnse      = $Reponse;
                $Factura->cstmer_rspnse_date = now();
                $Factura->update();
            } 
        }


 
 
}
