<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiSoenac;
use App\Librarys\GuzzleHttp;
use Illuminate\Http\Request;

use App\Models\FctrasElctrnca   ;
use Illuminate\Support\Collection;
use App\Jobs\InvoiceDeleteFilesJob;
use Illuminate\Support\Facades\App;
use App\Traits\FctrasElctrncasTrait;

use App\Models\FctrasElctrncasMcipio;
use App\Events\InvoiceWasCreatedEvent;
use App\Http\Controllers\ApiController;
use App\Helpers\FoldersHelper as Folders;
use App\Helpers\GeneralHelper as Generales;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Use Storage;
Use Carbon;
// php artisan code:models --table=fctras_elctrncas_email_sends

/*
    App\Http\Controllers\ApiController:  
            Controlador base desde donde extienden todos los demás controladores
            Centraliza m{etodos de respuesta
*/

class FctrasElctrncasInvoicesController extends ApiController
{
   use FctrasElctrncasTrait, ApiSoenac;

   private $jsonObject = [], $PdfFile, $XmlFile ;
  
 
        public function invoices() {
            $URL = 'invoice/'. env('FACTURA_ELECT_TEST_ID');
            $Documentos = FctrasElctrnca::InvoicesToSend()->get();
            foreach ($Documentos as $Documento ) {
                $this->invoicesToSend ( $Documento) ;
                //return $this->jsonObject ;
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
                $this->traitLegalMonetaryTotals         ( $Others[0]['total']     , $this->jsonObject, 'legal_monetary_totals' );
                $this->traitInvoiceLines                ( $Others[0]['products']  , $this->jsonObject, 'invoice_lines'   );
                unset( $this->jsonObject['billing_reference']);
                unset( $this->jsonObject['discrepancy_response']);// No los necesito para facturas
            }

 
        private  function documentsProcessReponse($Documento,  $response ){
            $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;
            if ( array_key_exists('is_valid',$response) ) {
                if ( $response['is_valid'] == true || is_null( $response['is_valid'] ) ) {
                    $this->traitDocumentSuccessResponse ( $id_fact_elctrnca, $response );             
                     $this->invoiceSendToCustomer ( $id_fact_elctrnca );
                }
            } else {
                $this->traitdocumentErrorResponse( $id_fact_elctrnca, $response ); 
            }
        }
        
       public function invoiceSendToCustomer ( $id_fact_elctrnca ) {
          $Factura      = FctrasElctrnca::with('customer','total', 'products', 'emails','additionals')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
          $Factura      = $Factura[0];  
          $this->getNameFiles($Factura );
          $this->invoiceCreateFilesToSend  ( $id_fact_elctrnca,  $Factura  ); 
          InvoiceWasCreatedEvent::dispatch ( $Factura ) ;  
          //InvoiceDeleteFilesJob::dispatch($this->PdfFile,$this->XmlFile )->delay(now()->addMinutes(5));
       }

        private function invoiceCreateFilesToSend ( $id_fact_elctrnca,  $Factura  ){
            $Resolution   = $this->traitSoenacResolutionsInvoice();                
            $this->saveInvoicePfdFile   ( $Resolution, $Factura );
            $this->saveInvoiceXmlFile   ( $Factura              );
        }

        private function saveInvoicePfdFile  ( $Resolution, $Factura   ){           
            $Fechas       = $this->FechasFactura ( $Factura['fcha_dcmnto'], $Factura['due_date'] );
            $Customer     = $Factura['customer'];
            $Products     = $Factura['products'];
            $Totals       = $Factura['total'];
            $Additionals  = $Factura['additionals'];
            $CantProducts = $Products->count();
            
            $CodigoQR     = QrCode::format('png')->size(330)->encoding('UTF-8')->generate( $Factura['qr_data'] );
            $Data         = compact('Resolution', 'Fechas', 'Factura','Customer', 'Products','CantProducts', 'Totals','CodigoQR', 'Additionals' );
            $pdf          = App::make('dompdf.wrapper');
            $PdfContent   = $pdf->loadView('pdfs.invoice', $Data )->output();
            Storage::disk('Files')->put( $this->PdfFile, $PdfContent);
        }

        private function saveInvoiceXmlFile ( $Factura) {
            $base64_bytes = $Factura['attached_document_base64_bytes'];
            Storage::disk('Files')->put( $this->XmlFile, base64_decode($base64_bytes));
        }

        private function FechasFactura ( $FechaFactura, $FechaVencimiento) {
            $Fechas       = [];
            $FechaFactura = Carbon::createFromFormat('Y-m-d H:i:s', $FechaFactura);
            $FechaVcmto   = Carbon::createFromFormat('Y-m-d H:i:s', $FechaVencimiento);
            $Fechas = [
                'FactDia'   => $FechaFactura->day,
                'FactMes'   => Generales::nameOfMonth( $FechaFactura->month),
                'Factyear'  => $FechaFactura->year,
                'VenceDia'  => $FechaVcmto->day,
                'VenceMes'  => Generales::nameOfMonth( $FechaVcmto->month),
                'VenceYear' => $FechaVcmto->year
            ];
            return $Fechas;
        }


        private function getNameFiles( $Factura) {
                $this->PdfFile     = $Factura['document_number'].'.pdf';
                $this->XmlFile     = $Factura['document_number'].'.xml';
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
