<?php 
namespace App\Librarys;

use GuzzleHttp\Client;

class GuzzleHttp {
    protected $url;
    protected $Guzzle;
    protected $headers;

    public function __construct( ) {
        $this->Guzzle = new Client([
            'base_uri' => env('FACTURA_ELECT_URL_BASE'),
        ]);
         $this->headers     = [
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Connection'      => 'keep-alive',
                'http_errors'     => true,
                'Authorization'   => env('FACTURA_ELECT_TOKEN'),
         ];  
      }

      public  function getRequest ( $URL ) {
         $response = $this->Guzzle->request(
            'GET', $URL, [ 'headers' => $this->headers 
                  ]);
         return    json_decode($response->getBody()->getContents(), true) ;  
      }

    public function postRequest ( $URL,$Body){
         
         $response = $this->Guzzle->request(
            'POST', $URL, [ 
               'headers' => $this->headers ,
               'json'    => $Body
            ]); 
            return json_decode($response->getBody()->getContents(),true);
      
            return $response;
            //return    $response->getBody()->getContents() ; 
            
/*             $response = $response ? $response->getBody()->getContents() : null;
            $status = $response ? $response->getStatusCode() : 500;

            if ($response && $status === 200 && $response !== 'null') {
               return $status ;
            }
            return null; */

    }
 
 
}