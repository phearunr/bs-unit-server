<?php
namespace App\Helpers;
 
use GuzzleHttp\Client as HttpClient;

class MsNavBridge {

    // this variable store odata Server Url
    protected $odata_server_url = "";

    // this variable store base64 encoded string of Nav username:password
    protected $odata_auth_key = "";   

    public function __construct($server_url, $auth_key)
    {    
        $this->odata_server_url = $server_url;
        $this->odata_auth_key = $auth_key;
    }

    public function request($request_type = 'GET', $resource, $query) 
    {        
        $http_client = New HttpClient(['verify' => false]);

        $headers = $this->getHeader([]);

        $response = $http_client->request($request_type, 
            $this->odata_server_url.$resource, 
            [
                'headers' => $headers, 'query' => $query
            ]
        );

        return $response;
    }

    private function getHeader(Array $header = [])
    {       
        $default = [
            'Authorization' => "Basic ".$this->odata_auth_key,
            'Accept-Charset' => "utf-8"
        ];

        return array_merge($default, $header);
    }   
  
}