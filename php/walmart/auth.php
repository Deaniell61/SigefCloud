<?php

class auth{

    private $consumerId = "03c36faf-e595-49f9-95aa-980183803460";

    private $url;
    private $method;
    private $timestamp;
    private $debug;

    public function __construct($mDebug = false){

        $this->debug = $mDebug;

        $this->debugMessage("walmart auth object");
    }

    public function getSignature($mUrl, $mMethod = "GET"){

        $this->url = $mUrl;
        $this->method = $mMethod;
        $this->timestamp = $this->getTimestamp();

        $authData = $this->consumerId ."\n";
        $authData .= $this->url ."\n";
        $authData .= $this->method ."\n";
        $authData .= $this->timestamp ."\n";

        $privateKey = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/php/walmart/privateKey");

        $Hash = defined("OPENSSL_ALGO_SHA256") ? OPENSSL_ALGO_SHA256 : "sha256";
        if (!openssl_sign($authData, $signature, $privateKey, $Hash)){
            return null;
        }

        $response = [
            "timestamp" => $this->timestamp,
            "signature" => base64_encode($signature),
        ];

        return $response;
    }

    public function refreshSignature(){

        return $this->getSignature($this->url, $this->method);
    }

    private function getTimestamp(){

        return round(microtime(true) * 1000);
    }

    private function debugMessage($mMessage){

        if($this->debug){
            echo "$mMessage<br>";
        }
    }
}
