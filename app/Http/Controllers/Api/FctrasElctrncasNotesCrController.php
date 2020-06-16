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
    private $ApiSoenac, $keyMonetary ,$keyLines ;
    
                

        public function __construct ( GuzzleHttp $GuzzleHttps ) {
            $this->ApiSoenac = $GuzzleHttps;
        }

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
            if ( $TipoNota  == 'cr')  return 'credit-note/'. env('FACTURA_ELECT_TEST_ID');
            if ( $TipoNota  == 'db')  return 'debit-note/' . env('FACTURA_ELECT_TEST_ID');
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
                'issue_date'   => Fecha::YMD($BillingRef['issue_date'])
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
                if ( $response['is_valid'] == true || is_null( $response['is_valid'] ) ) {
                    $this->traitDocumentSuccessResponse ( $idfact_elctrnca , $response );
                    $this->noteSendToCustomer  ( $idfact_elctrnca ); }
            } else {
                 $this->traitdocumentErrorResponse( $idfact_elctrnca, $response ); 
            } 
    } 

    private function noteSendToCustomer () {
        dd('noteSendToCustomer...'. now() );
    } 

}
