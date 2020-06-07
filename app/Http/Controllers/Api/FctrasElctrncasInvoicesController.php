<?php

namespace App\Http\Controllers\Api;

use App\Events\InvoiceWasCreated;
use App\Helpers\DatesHelper as Fecha;
use App\Helpers\FoldersHelper as Folders;
use App\Helpers\GeneralHelper as Generales;
use App\Http\Controllers\ApiController;
use App\Librarys\GuzzleHttp;
use App\Models\FctrasElctrnca   ;
use App\Models\FctrasElctrncasMcipio;
use App\Traits\ApiSoenac;
use App\Traits\FctrasElctrncasTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
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

   private $jsonObject = [] ;
  
 
        public function resolutions() {
            return  $this->traitSoenacResolutions();
        }

        public function invoices() {
            $URL = 'invoice/'. env('FACTURA_ELECT_TEST_ID');
            $Documentos = FctrasElctrnca::InvoicesToSend()->get();
            foreach ($Documentos as $Documento ) {
                $this->invoicesToSend ( $Documento) ;
                return $this->jsonObject ;
                $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject ) ;
                $this->traitUpdateJsonObject ( $Documento );
                $this->documentsProcessReponse( $Documento, $response ) ;
            }  
        }

        private function invoicesToSend ($Facturas)  {
            $this->jsonObject = [];
            $id_fact_elctrnca = $Facturas['id_fact_elctrnca'];    
            $otherDataInvoice = FctrasElctrnca::with('customer','total', 'products', 'emails')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
            $Customer         = $otherDataInvoice[0]['customer'];
            $Total            = $otherDataInvoice[0]['total'];
            $Products         = $otherDataInvoice[0]['products'];
            $Emails           = $otherDataInvoice[0]['emails'];
            $this-> jsonObjectCreate ($Facturas , $Customer, $Total , $Products , $Emails  );
        }

        private function jsonObjectCreate ( $invoce, $Customer, $Total , $Products, $Emails  ) {
                $this->headerInvoice                    ( $invoce    );
                $this->traitEmailSend                   ( $Emails    , $this->jsonObject   );
                $this->traitNotes                       ( $invoce    , $this->jsonObject   );
                $this->traitOrderReference              ( $invoce    , $this->jsonObject   );
                $this->traitReceiptDocumentReference    ( $invoce    , $this->jsonObject   );
                $this->traitCustomer                    ( $Customer  , $this->jsonObject   );
                $this->traitLegalMonetaryTotals         ( $Total     , $this->jsonObject );
                $this->traitInvoiceLines                ( $Products  , $this->jsonObject, 'invoice_lines'   );
            }

        private function headerInvoice( $invoce ) {        
            $this->jsonObject= [
                'number'            => $invoce["number"],
                'sync'              => true,
                'send'              => true,
                'type_document_id'  => $invoce["type_document_id"],
                'type_operation_id' => $invoce["type_operation_id"],
                'resolution_id'     => $invoce["resolution_id"],
                'due_date'          => Fecha::YMD ( $invoce["due_date"] ),
                'type_currency_id'  => $invoce["type_currency_id"],
                'payment_form_id'   => $invoce["payment_form_id"],
                'payment_method_id' => $invoce["payment_method_id"],
                'payment_due_date'  => Fecha::YMD($invoce["due_date"]),
                'duration_measure'  => $invoce["duration_measure"],
                'cc'                => [],
                ] ;
        }
  
        private  function documentsProcessReponse($Documento,  $response ){
            $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;  
            if ( $response['is_valid'] == true ) {
                $this->traitDocumentSuccessResponse ( $id_fact_elctrnca, $response );             
                $this->invoiceSendToCustomer ( $id_fact_elctrnca );
            } else {
                $this->traitdocumentErrorResponse( $id_fact_elctrnca, $response ); 
            }
        }
       public function invoiceSendToCustomer ( $id_fact_elctrnca ) {
          $Factura      = FctrasElctrnca::with('customer','total', 'products', 'emails')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
          $Factura      = $Factura[0];
          $this->invoiceCreateFilesToSend  ( $id_fact_elctrnca,  $Factura  ); 
          InvoiceWasCreated::dispatch( $Factura  ) ; // Disparo evento para el evío de correos con archivos creados.
       }

        private function invoiceCreateFilesToSend ( $id_fact_elctrnca,  $Factura  ){
                $Resolution   = $this->traitSoenacResolutionsInvoice();
                $this->saveInvoicePfdFile ( $Resolution, $Factura );
                $this->saveInvoiceXmlFile ( $Factura );
        }

        private function saveInvoicePfdFile  ( $Resolution, $Factura   ){
            $FileName     = $Factura['xml_file_name'].'.pdf';
            $Fechas       = $this->FechasFactura ( $Factura['fcha_dcmnto'], $Factura['due_date'] );
            $Customer     = $Factura['customer'];
            $Products     = $Factura['products'];
            $Totals       = $Factura['total'];
            $CantProducts = $Products->count();
            $CodigoQR     = QrCode::format('png')->size(330)->encoding('UTF-8')->generate($Factura['qr_data']);
            $Data         = compact('Resolution', 'Fechas', 'Factura','Customer', 'Products','CantProducts', 'Totals','CodigoQR' );
            $pdf          = App::make('dompdf.wrapper');
            $PdfContent   = $pdf->loadView('pdfs.invoice', $Data )->output();
            Storage:: disk('Files')->put( $FileName, $PdfContent);
        }

        private function saveInvoiceXmlFile ( $Factura) {
            $base64_bytes = $Factura['attached_document_base64_bytes'];
            $FileName = $Factura['xml_file_name'].'.xml'; 
            Storage::disk('Files')->put( $FileName, base64_decode($base64_bytes));
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



    

 
 

 
   
 

   


}
