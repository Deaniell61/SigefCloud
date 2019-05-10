<?php
require_once(".config.inc.php");

class amazonMWS {

    private $serviceUrl;
    private $config;
    private $service;

    function __construct() {

        $this->serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";

        $this->config = array(
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'ProxyUsername' => null,
            'ProxyPassword' => null,
            'MaxErrorRetry' => 3,
        );
        $this->service = new MarketplaceWebServiceProducts_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            APPLICATION_NAME,
            APPLICATION_VERSION,
            $this->config);

        var_dump($this->service);
    }

    public function getPriceForSKU($skus) {

        return "success";
    }
}

$t = new amazonMWS();