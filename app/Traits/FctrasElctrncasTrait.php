<?php

namespace App\Traits;
 
use Illuminate\Support\Str;
use App\Models\FctrasElctrnca;
use App\Models\FctrasElctrncasDataResponse;
use App\Models\FctrasElctrncasErrorsMessage;
use Illuminate\Support\Facades\Hash;
use App\Helpers\DatesHelper as Fecha;
use App\Helpers\NumbersHelper as Numbers;
use App\Helpers\StringsHelper as Strings;



trait FctrasElctrncasTrait {
    
    protected $PdfFile, $XmlFile, $DocumentNumber;
     
      protected function traitEmailSend ( $Emails, &$jsonObject ) {
         $emails=[] ;
         foreach ($Emails as $Cuenta ) {
               $emails = ['email' => $Cuenta['email'] ];
               $jsonObject['cc'][]  = $emails ;
         }
      }

      protected function traitNotes( $invoce , &$jsonObject  ) {        
         if ( !Strings::isEmptyOrNull($invoce ['notes']) ) {
               $notes = ['text'=> $invoce ['notes']]  ;
               $jsonObject['notes'][] = $notes ; 
         }
      }


      protected function traitOrderReference ( $invoce , &$jsonObject  ) {
               $OrderCpra = $invoce['order_reference']; 
               if ( !Strings::isEmptyOrNull( $OrderCpra  ) ) {   
                  $OrderCpra = ['id' => $OrderCpra]; 
                  $jsonObject['order_reference'] =  $OrderCpra;
               }
         }
         
      protected function traitReceiptDocumentReference ($invoce, &$jsonObject  ) {
               $Despacho = $invoce['receipt_document_reference']; 
               if ( !Strings::isEmptyOrNull( $Despacho ) ) {
                  $Despacho = ['id' => $Despacho];
                  $jsonObject['receipt_document_reference'] =  $Despacho;
               }
         }

      protected function traitDocumentHeader($Document , &$jsonObject ) {      
            $jsonObject= [
                'billing_reference'    => [],
                'discrepancy_response' => [],
                'number'               => $Document["number"],
                'sync'                 => true,
                'send'                 => false,
                'type_document_id'     => $Document["type_document_id"],
                'type_operation_id'    => $Document["type_operation_id"],
                'resolution_id'        => $Document["resolution_id"],
                'due_date'             => Fecha::YMD ( $Document["due_date"] ),
                'type_currency_id'     => $Document["type_currency_id"],
                'cc'                   => [],
                ] ;
      }

        protected function traitCustomer( $Customer, &$jsonObject  ) {
            $jsonObject['customer'] =[
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

        protected function traitPaymentForms( $Document, &$jsonObject  ) {
            $payment = [
                'payment_form_id'   => $Document["payment_form_id"],
                'payment_method_id' => '75',
                'payment_due_date'  => Fecha::YMD($Document["due_date"]),
                'duration_measure'  => $Document["duration_measure"] 
            ];
            $jsonObject['payment_forms'][] =$payment;
        }

        protected function traitCharges( $Document, &$jsonObject  ) {
            $charges = [
                'charge_indicator'        => $Document["charge_indicator"],
                'discount_id'             => $Document["discount_id"],
                'allowance_charge_reason' => $Document["allowance_charge_reason"],
                'amount'                  => $Document["amount"],
                'base_amount'             => $Document["base_amount"],
            ];
            $jsonObject['allowance_charges'][] =$charges;
        }

 

        protected function traitLegalMonetaryTotals ( $Totals, &$jsonObject, $key  ) {
            $jsonObject[$key] =[
                'line_extension_amount'  => Numbers::jsonFormat($Totals['line_extension_amount'],2),
                'tax_exclusive_amount'   => Numbers::jsonFormat($Totals  ['tax_exclusive_amount'],2),
                'tax_inclusive_amount'   => Numbers::jsonFormat($Totals  ['tax_inclusive_amount'],2),
                'allowance_total_amount' => Numbers::jsonFormat($Totals  ['allowance_total_amount'],2),
                'charge_total_amount'    => Numbers::jsonFormat($Totals  ['charge_total_amount'],2),
                'payable_amount'         => Numbers::jsonFormat($Totals  ['payable_amount'],2),
            ];      
        }

 
        protected function traitInvoiceLines( $Products, &$jsonObject, $jsonKey  ) {
            $Productos = [];          
            foreach ($Products as $Product) {
             $ProductToCreate = [
                 'unit_measure_id'             => $Product['unit_measure_id'],
                 'invoiced_quantity'           => Numbers::jsonFormat ( $Product['invoiced_quantity'], 6),
                 'line_extension_amount'       => Numbers::jsonFormat ($Product['line_extension_amount'], 2),
                 'free_of_charge_indicator'    => $Product['free_of_charge_indicator'],
                 'tax_totals'                  =>[],
                 'description'                 => $Product['description'],
                 'brand_name'                  => $Product['brand_name'],
                 'model_name'                  => $Product['model_name'],
                 'code'                        => $Product['code'],
                 'type_item_identification_id' => $Product['type_item_identification_id'],
                 'price_amount'                => Numbers::jsonFormat ($Product['price_amount'],2),
                 'base_quantity'               => Numbers::jsonFormat ($Product['base_quantity'],2)
               ];  
                $this->productTaxAmount( $Product, $ProductToCreate  );
                $Productos[] = $ProductToCreate ;
            }
            $jsonObject [$jsonKey] = $Productos;
        }

        private function productTaxAmount( &$Product, &$ObjProducto ){
            if ( $Product['tax_amount'] > 0 ) {
                $Impuestos = [ 
                    'tax_id'         => 1,
                    'tax_amount'     => Numbers::jsonFormat ($Product['tax_amount'], 2),
                    'taxable_amount' => Numbers::jsonFormat ($Product['taxable_amount'], 2),
                    'percent'        => Numbers::jsonFormat ($Product['percent'], 2)];
                $ObjProducto['tax_totals'][] =  $Impuestos; 
            }
        }

        protected function traitUpdateJsonObject ( $Documento ) {
            $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;
            $Registro                   = FctrasElctrnca::findOrFail( $id_fact_elctrnca );
            $Registro['rspnse_dian']    = true;
            $Registro['json_data']      = $this->jsonObject ;
            $Registro->save();
        }

       protected function traitDocumentSuccessResponse( $id_factelctrnca, $dataResponse ){
            $Registro = FctrasElctrnca::findOrFail( $id_factelctrnca );
            $Registro['is_valid']                          = $dataResponse['is_valid'];
            $Registro['document_number']                   = $dataResponse['number'];
            $Registro['uuid']                              = $dataResponse['uuid'];
            $Registro['issue_date']                        = $dataResponse['issue_date'];
            $Registro['status_code']                       = $dataResponse['status_code'];
            $Registro['status_description']                = $dataResponse['status_description'];
            $Registro['status_message']                    = $dataResponse['status_message'];
            $Registro['xml_file_name']                     = $dataResponse['xml_file_name'];
            $Registro['zip_name']                          = $dataResponse['zip_name'];
            $Registro['cstmer_token']                      = Str::random(60); 
            $Registro->save();

            // Almacena respuesta de la factura
            $FctrasDataReponse = new FctrasElctrncasDataResponse;
            $FctrasDataReponse->id_fact_elctrnca                   = $id_factelctrnca;
            $FctrasDataReponse->qr_data                            = $dataResponse['qr_data'];
            $FctrasDataReponse->application_response_base64_bytes  = $dataResponse['application_response_base64_bytes'];
            $FctrasDataReponse->attached_document_base64_bytes     = $dataResponse['attached_document_base64_bytes'];
            $FctrasDataReponse->pdf_base64_bytes                   = $dataResponse['pdf_base64_bytes'];
            $FctrasDataReponse->save(); 
            
        }

        protected function traitdocumentErrorResponse ( $id_fact_elctrnca, $dataResponse ){ 
            FctrasElctrncasErrorsMessage::where('id_fact_elctrnca', $id_fact_elctrnca)->delete();
             
            if ( array_key_exists('errors',$dataResponse) ) {
                $this->validationErrorResponse ($dataResponse , $id_fact_elctrnca );
            }
            if ( array_key_exists('errors_messages',$dataResponse) ) {
                $this->validationDianErrorResponse ($dataResponse , $id_fact_elctrnca );
            }         
        }

        private function validationErrorResponse (  $dataResponse, $id_fact_elctrnca ){
            $errors = $dataResponse['errors'];
            foreach ($errors as $error ) {
                $ErrorResponse = new FctrasElctrncasErrorsMessage();
                $ErrorResponse->id_fact_elctrnca = $id_fact_elctrnca;
                $ErrorResponse->error_message    = $error[0] ;
                $ErrorResponse->save();
            }
        }
        
        private function validationDianErrorResponse (  $dataResponse, $id_fact_elctrnca ){
            $errors = $dataResponse['errors_messages'];
            
            foreach ($errors as $error ) {
                $ErrorResponse = new FctrasElctrncasErrorsMessage();
                $ErrorResponse->id_fact_elctrnca = $id_fact_elctrnca;
                $ErrorResponse->error_message    = $error ;
                $ErrorResponse->save();
            }
        }
    
        private function getNameFilesTrait( $Document, $addPrefijo=false ) {  
                $documentNumber = $Document['document_number'];
                $documentNumber = $addPrefijo== true ? $Document['prfjo_dcmnto'].$documentNumber : $documentNumber;
                $this->PdfFile  = $documentNumber.'.pdf';
                $this->XmlFile  = $documentNumber.'.xml';
                $this->DocumentNumber = $documentNumber;
        }


}
