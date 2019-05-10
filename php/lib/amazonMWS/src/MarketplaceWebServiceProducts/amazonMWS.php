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
    }

    public function getPriceForSKU($skus) {

        $request = new MarketplaceWebServiceProducts_Model_GetMyPriceForSKURequest();
        $request->setSellerId(MERCHANT_ID);
        $request->setMarketplaceId(MARKETPLACE_ID);
        $skuList = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
        $skuList->setSellerSKU($skus);
        $request->setSellerSKUList($skuList);
        $array = null;
        try {
            $response = $this->service->GetMyPriceForSKU($request);
            $data = $response->toXML();
            $sxml = new SimpleXMLElement($data);
            $index = 0;
            foreach ($sxml as $product) {
                $product = $product->Product;
                echo "<br>";
                var_dump($product);
                echo "<br>";
                if (count($product->Offers->Offer) > 0) {
                    $offer = $product->Offers->Offer;
                    if (count($product->Offers->Offer) > 1) {
                        foreach ($product->Offers->Offer as $tOffer) {
                            if ($skus[$index] == $tOffer->SellerSKU) {
                                $offer = $tOffer;
                            }
                        }
                    }
                    $listingAmount = $offer->BuyingPrice->ListingPrice->Amount;
                    $array[$skus[$index]] = $listingAmount;
                }
                $index += 1;
            }
        }
        catch (MarketplaceWebServiceProducts_Exception $exception) {
//            echo "error";
        }
        return $array;
    }

    public function getASINForSKU($skus) {
        $request = new MarketplaceWebServiceProducts_Model_GetMyPriceForSKURequest();
        $request->setSellerId(MERCHANT_ID);
        $request->setMarketplaceId(MARKETPLACE_ID);
        $skuList = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
        $skuList->setSellerSKU($skus);
        $request->setSellerSKUList($skuList);
        $array = null;
        try {
            $response = $this->service->GetMyPriceForSKU($request);
            $data = $response->toXML();
            $sxml = new SimpleXMLElement($data);
            $index = 0;
            foreach ($sxml as $product) {
//                var_dump($product);
//                echo "<br><br>";
                return  $product->Product->Identifiers->MarketplaceASIN->ASIN;
            }
        }
        catch (MarketplaceWebServiceProducts_Exception $exception) {
            echo "error: $exception<br>";
        }
        return $array;
    }

    public function syncProduct($sku) {

        $request = new MarketplaceWebServiceProducts_Model_Product();

        /*
        $request = new MarketplaceWebServiceProducts_Model_GetMyPriceForSKURequest();
        $request->setSellerId(MERCHANT_ID);
        $request->setMarketplaceId(MARKETPLACE_ID);
        $skuList = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
        $skuList->setSellerSKU($skus);
        $request->setSellerSKUList($skuList);
        $array = null;
        try {
            $response = $this->service->GetMyPriceForSKU($request);
            $data = $response->toXML();
            $sxml = new SimpleXMLElement($data);
            $index = 0;
            foreach ($sxml as $product) {
                $product = $product->Product;
                echo "<br>";
                var_dump($product);
                echo "<br>";
                if (count($product->Offers->Offer) > 0) {
                    $offer = $product->Offers->Offer;
                    if (count($product->Offers->Offer) > 1) {
                        foreach ($product->Offers->Offer as $tOffer) {
                            if ($skus[$index] == $tOffer->SellerSKU) {
                                $offer = $tOffer;
                            }
                        }
                    }
                    $listingAmount = $offer->BuyingPrice->ListingPrice->Amount;
                    $array[$skus[$index]] = $listingAmount;
                }
                $index += 1;
            }
        }
        catch (MarketplaceWebServiceProducts_Exception $exception) {
//            echo "error";
        }
        return $array;
        */
    }
}