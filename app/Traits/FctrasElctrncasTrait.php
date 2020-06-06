<?php

namespace App\Traits;
 
use App\Models\FctrasElctrnca;
use App\Helpers\NumbersHelper as Numbers;
use App\Helpers\StringsHelper as Strings;
use App\Models\FctrasElctrncasErrorsMessage;

trait FctrasElctrncasTrait {
    

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
        
        protected function traitLegalMonetaryTotals ( $Totals, &$jsonObject  ) {
            $jsonObject['legal_monetary_totals'] =[
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
            $jsonObject [$jsonKey] = $Productos;
        }

        protected function traitUpdateJsonObject ( $Documento ) {
            $id_fact_elctrnca           = $Documento['id_fact_elctrnca']  ;
            $Registro                   = FctrasElctrnca::findOrFail( $id_fact_elctrnca );
            $Registro['json_data']      = $this->jsonObject ;
            $Registro->save();
        }

       protected function traitDocumentSuccessResponse( $id_factelctrnca, $dataResponse ){
            $Registro = FctrasElctrnca::findOrFail( $id_factelctrnca );
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

        protected function traitdocumentErrorResponse ( $id_fact_elctrnca, $dataResponse ){ 
            $errors = $dataResponse['errors_messages'];
            FctrasElctrncasErrorsMessage::where('id_fact_elctrnca', $id_fact_elctrnca)->delete();
            foreach ($errors as $error ) {
                $ErrorResponse = new FctrasElctrncasErrorsMessage();
                $ErrorResponse->id_fact_elctrnca = $id_fact_elctrnca;
                $ErrorResponse->error_message    = $error ;
                $ErrorResponse->save();
            }
        }

}
