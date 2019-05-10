<?php
require_once(".config.inc.php");

class amazonMWS {

    private $serviceUrl;
    private $config;
    private $service;

    function __construct() {

        $this->serviceUrl = "https://mws.amazonservices.com/FulfillmentInventory/2010-10-01";

        $this->config = array(
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'ProxyUsername' => null,
            'ProxyPassword' => null,
            'MaxErrorRetry' => 3,
        );

        $this->service = new FBAInventoryServiceMWS_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            $this->config,
            APPLICATION_NAME,
            APPLICATION_VERSION
        );
    }

    public function getStockForSKU($skus) {
        $request = new FBAInventoryServiceMWS_Model_ListInventorySupplyRequest();
        $request->setSellerId(MERCHANT_ID);
        $request->setMarketplaceId(MARKETPLACE_ID);
        $skuList = new FBAInventoryServiceMWS_Model_SellerSkuList();
        $skuList->setmember($skus);
        $request->setSellerSkus($skuList);

        $array = null;
        try {
            $response = $this->service->ListInventorySupply($request);
            $data = $response->toXML();
            $sxml = new SimpleXMLElement($data);
            $index = 0;
            foreach ($sxml as $product) {
                var_dump($product);
                echo "<br><br>";
                return  "";
            }
        }
        catch (FBAInventoryServiceMWS_Exception $exception) {
            echo "error: $exception<br><br>";
        }

        return $array;
    }
}