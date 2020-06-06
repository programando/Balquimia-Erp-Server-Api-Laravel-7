<?php

namespace App\Http\Controllers\Api;

use App\Librarys\GuzzleHttp;
use Illuminate\Http\Request;

use App\Models\FctrasElctrnca;
use App\Http\Controllers\Controller;
use App\Traits\FctrasElctrncasTrait;

use App\Helpers\DatesHelper as Fecha;

class FctrasElctrncasNotesCrController extends Controller
{
    use FctrasElctrncasTrait;

    private $jsonObject = [] ;
    private $ApiSoenac ;
    
   
        public function __construct ( GuzzleHttp $GuzzleHttps ) {
            $this->ApiSoenac = $GuzzleHttps;
        }

        public function creditNotes() {
            $URL = 'credit-note/'. env('FACTURA_ELECT_TEST_ID');
            $Documentos = FctrasElctrnca::CreditNotesToSend()->get();
            foreach ($Documentos as $Documento ) {
                $this->creditNotesToSend ( $Documento) ;
                //return $this->jsonObject ;
                $response   = $this->ApiSoenac->postRequest( $URL, $this->jsonObject ) ;
                
                $this->traitUpdateJsonObject ( $Documento );
                $this->documentsProcessReponse( $Documento, $response ) ; 
        }  
      }

      private function creditNotesToSend ( $Notes ){
        $this->jsonObject = [];
        $id_fact_elctrnca = $Notes['id_fact_elctrnca'];    
        $otherDataNote = FctrasElctrnca::with('customer','total', 'products', 'emails','noteBillingReference','noteDiscrepancy')->where('id_fact_elctrnca','=', $id_fact_elctrnca)->get();
        $Customer         = $otherDataNote[0]['customer'];
        $Total            = $otherDataNote[0]['total'];
        $Products         = $otherDataNote[0]['products'];
        $Emails           = $otherDataNote[0]['emails'];
        $BillingReference = $otherDataNote[0]['noteBillingReference'];
        $Discrepancy      = $otherDataNote[0]['noteDiscrepancy'];
         
        $this->jsonObjectCreate ($Notes , $Customer, $Total , $Products , $Emails, $BillingReference , $Discrepancy   );           
      }

        private function jsonObjectCreate ( $Note, $Customer, $Total , $Products, $Emails, $BillingReference,  $Discrepancy  ) {
            $this->headerNote                    ( $Note );
            $this->billingReference              ( $BillingReference );
            $this->discrepancy                   ( $Discrepancy      ) ;
            $this->traitEmailSend                ( $Emails    , $this->jsonObject  );
            $this->traitNotes                    ( $Note      , $this->jsonObject  );
            $this->traitOrderReference           ( $Note      , $this->jsonObject  );
            $this->traitReceiptDocumentReference ( $Note      , $this->jsonObject  );
            $this->traitCustomer                 ( $Customer  , $this->jsonObject  );
            $this->traitLegalMonetaryTotals      ( $Total     , $this->jsonObject  );
            $this->traitInvoiceLines             ( $Products  , $this->jsonObject, 'credit_note_lines'  );  
        }

     private function headerNote( $Note  ) {        
            $this->jsonObject= [
                'billing_reference'    => [],
                'discrepancy_response' => [],
                'number'               => $Note["number"],
                'sync'                 => true,
                'send'                 => true,
                'type_document_id'     => $Note["type_document_id"],
                'type_operation_id'    => $Note["type_operation_id"],
                'resolution_id'        => $Note["resolution_id"],
                'due_date'             => Fecha::FormatYMD($Note["due_date"]),
                'type_currency_id'     => $Note["type_currency_id"],
                'payment_form_id'      => $Note["payment_form_id"],
                'payment_method_id'    => $Note["payment_method_id"],
                'payment_due_date'     => Fecha::FormatYMD($Note["due_date"]),
                'duration_measure'     => $Note["duration_measure"],
                'cc'                   => [],
                ] ;
        }

     private function billingReference ( $BillingRef ){
            $this->jsonObject['billing_reference'] =[
                'number'       => "$BillingRef[0]['number']",
                'uuid'         => $BillingRef[0]['uuid'],
                'issue_date'   => Fecha::FormatYMD($BillingRef[0]['issue_date'])
            ];
     }
     
     private function discrepancy ( $Discrepancy  ){
           $this->jsonObject['discrepancy_response'] =[
                'number'                => $Discrepancy[0]['reference'],
                'correction_concept_id' => $Discrepancy[0]['correction_concept_id'],
                'description'           => $Discrepancy[0]['description'],
            ];
     }

     private  function documentsProcessReponse( $Documento,  $response ){
        $idfact_elctrnca           = $Documento['id_fact_elctrnca']  ;       
        if ( $response['is_valid'] == true ) {
            $this->traitDocumentSuccessResponse ( $idfact_elctrnca , $response );
            $this->noteSendToCustomer  ( $idfact_elctrnca ); 
        } else {
            $this->traitdocumentErrorResponse( $idfact_elctrnca, $response ); 
        }
    } 

    private function noteSendToCustomer () {

        
    } 

}
