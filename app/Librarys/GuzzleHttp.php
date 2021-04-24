<?php 
namespace App\Librarys;

use config;
use GuzzleHttp\Client;

class GuzzleHttp {
    protected $url;
    protected $Guzzle;
    protected $headers;

    public function __construct( ) {      
        $this->Guzzle = new Client([
            'base_uri' => config('company.FACTURA_ELECT_URL_BASE'),
            'exceptions' => false,
        ]);
         $this->headers     = [
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Connection'      => 'keep-alive',
                'http_errors'     => true,
                'Authorization'   => config('company.FACTURA_ELECT_TOKEN'),
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
    }
 
 
}