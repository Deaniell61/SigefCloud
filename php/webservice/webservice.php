<?php
//http://as.ws.sellercloud.com/
echo "hola mundo";
$client = new SoapClient("http://as.ws.sellercloud.com/scservice.asmx?WSDL");
var_dump($client->__getFunctions());
echo "adios mundo";