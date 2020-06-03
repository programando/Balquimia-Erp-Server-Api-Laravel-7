<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Controllers\ApiController;

use App\Models\FctrasElctrnca   ;
use App\Models\FctrasElctrncasErrorsMessage ;
use App\Models\FctrasElctrncasMcipio;

use App\Helpers\NumbersHelper as Numbers;
use App\Helpers\StringsHelper as Strings;

use App\Librarys\GuzzleHttp;
  
// php artisan code:models --table=fctras_elctrncas_email_sends

/*
    App\Http\Controllers\ApiController:  
            Controlador base desde donde extienden todos los demás controladores
            Centraliza m{etodos de respuesta
*/

class FacturaElectronicaController extends ApiController
{
   private $jsonObject = [] ;
   private $ApiSoenac ;
 
   
    public function __construct ( GuzzleHttp $GuzzleHttps ) {
        $this->ApiSoenac = $GuzzleHttps;
    }

    public function index() {

    }

    public function tables()   {
         $response =    $this->ApiSoenac->getRequest('listings' ) ;
         $Municipios  = $response['municipalities'];
         foreach ($Municipios as $Municipio) {
             $Registro               = new FctrasElctrncasMcipio();
             $Registro['id_mcpio']   = $Municipio['id'];
             $Registro['cod_mcpio']  = $Municipio['code'];
             $Registro['name_mcpio'] = $Municipio['name'];
             $Registro->save();
         }
    }

    public function resolutions() {
         return    $this->ApiSoenac->getRequest('config/resolutions' ) ;
    }

    public function invoices() {
        $URL = 'invoice/'. env('FACTURA_ELECT_TEST_ID');
        $Documentos = FctrasElctrnca::InvoicesToSend()->get();
        foreach ($Documentos as $Documento ) {
           $this->invoicesToSend ( $Documento) ;
           //return $this->jsonObject ;
           $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject ) ;
           $this->updateJsonObject ( $Documento );
           $this->documentsProcessReponse( $Documento, $response ) ;
        }
         
    }

    private function updateJsonObject ( $Documento ) {
        $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;
        $Registro                   = FctrasElctrnca::findOrFail( $id_fact_elctrnca );
        $Registro['json_data']      = $this->jsonObject ;
        $Registro->save();
    }
    private  function documentsProcessReponse($Documento,  $response ){
        $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;
        FctrasElctrncasErrorsMessage::where('id_fact_elctrnca', $id_fact_elctrnca)->delete();

        if ( $response['is_valid'] == true ) {
            $this->documentSuccessResponse( $id_fact_elctrnca, $response );
        } else {
           $this->documentErrorResponse( $id_fact_elctrnca, $response ); 
        }
    }

    private function documentErrorResponse($id_fact_elctrnca, $dataResponse ){ 
        $errors = $dataResponse['errors_messages'];
        foreach ($errors as $error ) {
            $ErrorResponse = new FctrasElctrncasErrorsMessage();
            $ErrorResponse->id_fact_elctrnca = $id_fact_elctrnca;
            $ErrorResponse->error_message    = $error ;
            $ErrorResponse->save();
        }
    }
 
    private function documentSuccessResponse($id_fact_elctrnca, $dataResponse ){
        $Registro = FctrasElctrnca::findOrFail( $id_fact_elctrnca );
        $Registro['rspnse_dian']                       = true;
        $Registro['is_valid']                          = $dataResponse['is_valid'];
        $Registro['document_number']                   = $dataResponse['number'];
        $Registro['uuid']                              = $dataResponse['uuid'];
        $Registro['issue_date']                        = $dataResponse['issue_date'];
        $Registro['status_code']                       = $dataResponse['status_code'];
        $Registro['status_description']                = $dataResponse['status_description'];
        $Registro['status_message']                    = $dataResponse['status_message'];
        $Registro['xml_file_name']                     = $dataResponse['xml_file_name'];
        $Registro['zip_name']                          = $dataResponse['zip_name'];
        $Registro['qr_data']                           = $dataResponse['qr_data'];
        $Registro['application_response_base64_bytes'] = $dataResponse['application_response_base64_bytes'];
        $Registro['attached_document_base64_bytes']    = $dataResponse['attached_document_base64_bytes'];
        $Registro['pdf_base64_bytes']                  = $dataResponse['pdf_base64_bytes'];
        $Registro['zip_base64_bytes']                  = $dataResponse['zip_base64_bytes'];
        $Registro['dian_response_base64_bytes']        = $dataResponse['dian_response_base64_bytes'];
        $Registro->save();
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
        $this->jsonObject ;
    }

    private function jsonObjectCreate ( $invoce, $Customer, $Total , $Products, $Emails  ) {
            $this->headerInvoice               ( $invoce    );
            $this->emailSend                   ( $Emails    );
            $this->notes                       ( $invoce    );
            $this->orderReference              ( $invoce    );
            $this->receiptDocumentReference    ( $invoce    );
            $this->customer                    ( $Customer  );
            $this->legalMonetaryTotals         ( $Total     );
            $this->invoiceLines                ( $Products  );

        }

        private function headerInvoice( $invoce ) {
            
            $this->jsonObject= [
                'number'            => $invoce["number"],
                'sync'              => true,
                'send'              => true,
                'type_document_id'  => $invoce["type_document_id"],
                'type_operation_id' => $invoce["type_operation_id"],
                'resolution_id'     => $invoce["resolution_id"],
                'due_date'          => date_format($invoce["due_date"], 'Y-m-d'),
                'type_currency_id'  => $invoce["type_currency_id"],
                'payment_form_id'   => $invoce["payment_form_id"],
                'payment_method_id' => $invoce["payment_method_id"],
                'payment_due_date'  => date_format($invoce["due_date"], 'Y-m-d'),
                'duration_measure'  => $invoce["duration_measure"],
                'cc'                => [],
                ] ;
        }

 

        private function emailSend ( $Emails ) {
            $emails=[] ;
            foreach ($Emails as $Cuenta ) {
                $emails = ['email' => $Cuenta['email'] ];
                $this->jsonObject['cc'][]  = $emails ;
            }
        
         } 

        private function notes( $invoce  ) {        
            if ( !Strings::isEmptyOrNull($invoce ['notes']) ) {
                $notes = ['text'=> $invoce ['notes']]  ;
                $this->jsonObject['notes'][] = $notes ; 
            }
        }

        private function orderReference ( $invoce ){
            $OrderCpra = $invoce['order_reference']; 
            if ( !Strings::isEmptyOrNull( $OrderCpra  ) ) {   
                $OrderCpra = ['id' => $OrderCpra]; 
                $this->jsonObject['order_reference'] =  $OrderCpra;
            }
        }

        private function receiptDocumentReference ($invoce ){
            $Despacho = $invoce['receipt_document_reference']; 
            if ( !Strings::isEmptyOrNull( $Despacho ) ) {
                $Despacho = ['id' => $Despacho];
                $this->jsonObject['receipt_document_reference'] =  $Despacho;
            }
        }

        private function customer( $Customer ) {
            $this->jsonObject['customer'] =[
                'identification_number'           => $Customer['identification_number'],
                'type_document_identification_id' => $Customer['type_document_identification_id'],
                'type_organization_id'            => $Customer['type_organization_id'],
                'language_id'                     => $Customer['language_id'],
                'country_id'                      => $Customer['country_id'],
                'municipality_id'                 => $Customer['municipality_id'],
                'type_regime_id'                  => $Customer['type_regime_id'],
                'type_liability_id'               => $Customer['type_liability_id'],
                'tax_detail_id'                   => $Customer['tax_detail_id'],
                'name'                            => $Customer['name'],
                'phone'                           => $Customer['phone'],
                'address'                         => $Customer['address'],
                'email'                           => $Customer['email'],
                'merchant_registration'           => $Customer['merchant_registration']
            ];
        }

 
        private function legalMonetaryTotals ( $Totals ) {
            $this->jsonObject['legal_monetary_totals'] =[
                'line_extension_amount'  => Numbers::jsonFormat($Totals['line_extension_amount'],2),
                'tax_exclusive_amount'   => Numbers::jsonFormat($Totals  ['tax_exclusive_amount'],2),
                'tax_inclusive_amount'   => Numbers::jsonFormat($Totals  ['tax_inclusive_amount'],2),
                'allowance_total_amount' => Numbers::jsonFormat($Totals  ['allowance_total_amount'],2),
                'charge_total_amount'    => Numbers::jsonFormat($Totals  ['charge_total_amount'],2),
                'payable_amount'         => Numbers::jsonFormat($Totals  ['payable_amount'],2),

            ];      
        }


        private function invoiceLines( $Products ) {
            $Productos = [];          
            foreach ($Products as $Product) {
             $Producto = [
                 'unit_measure_id'             => $Product['unit_measure_id'],
                 'invoiced_quantity'           => Numbers::jsonFormat ( $Product['invoiced_quantity'], 6),
                 'line_extension_amount'       => Numbers::jsonFormat ($Product['line_extension_amount'], 2),
                 'free_of_charge_indicator'    => $Product['free_of_charge_indicator'],
                 'description'                 => $Product['description'],
                 'brand_name'                  => $Product['brand_name'],
                 'model_name'                  => $Product['model_name'],
                 'code'                        => $Product['code'],
                 'type_item_identification_id' => $Product['type_item_identification_id'],
                 'price_amount'                => Numbers::jsonFormat ($Product['price_amount'],2),
                 'base_quantity'               => Numbers::jsonFormat ($Product['base_quantity'],2)
               ];     
             $Productos[] = $Producto ;
            }
            $this->jsonObject['invoice_lines'] = $Productos;
        }

 

    






 

    /*

https://medium.com/zero-equals-false/using-laravel-5-5-resources-to-create-your-own-json-api-formatted-api-2c6af5e4d0e8

    {
  
    $sql = "call my_procedure(?,?)";
    DB::select($sql,array(1,20)); // retorna un array de objetos.

    $db = DB::connection();
    $stmt = $db->getPdo()->prepare("CALL my_procedure(?,?)");
    $stmt->execute(['buscar',5]);
    $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass');

    */

}
