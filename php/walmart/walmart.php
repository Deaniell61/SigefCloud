<?php

class walmart{

    private $auth;
    private $urlBuilder;
    private $debug;

    public function __construct($mDebug = false){

        $this->debug = $mDebug;

        $this->debugMessage("walmart object");

        include_once ("auth.php");
        include_once ("urlBuilder.php");

        $this->auth = new auth($this->debug);
        $this->urlBuilder = new urlBuilder();
    }

    public function feeds(){

        $this->debugMessage("feeds method");

        $tURL = $this->urlBuilder->feeds();
        $this->debugMessage("test url:$tURL");
        $response = $this->call($tURL);

        return $response;
    }

    public function ordersReleased(){

        $this->debugMessage("orders released method");

        $tURL = $this->urlBuilder->ordersReleased();
        $this->debugMessage("test url:$tURL");
        $response = $this->call($tURL);
        $response = $this->simpleJson($response);

        return $response;
    }

    public function orders($mNextCursor){

        $this->debugMessage("orders method");

        $tURL = $this->urlBuilder->orders($mNextCursor);
        $this->debugMessage("test url:$tURL");
        $response = $this->call($tURL);
        $response = $this->simpleJson($response);

        return $response;
    }

    public function order($order){

        $this->debugMessage("order method");

        $tURL = $this->urlBuilder->order($order);
        $this->debugMessage("test url:$tURL");
        $response = $this->call($tURL);
//        var_dump($response);
        $response = $this->simpleJson($response);

        return $response;
    }

    public function item(){

        $this->debugMessage("item method");

        $tURL = $this->urlBuilder->item();
        $this->debugMessage("test url:$tURL");
        $response = $this->call($tURL);
        $response = $this->simpleJson($response);

        return $response;
    }

    public function updateInventory($sku, $country){

        $tXML = $this->generateUpdateInventoryXML($sku, $country);
        $this->debugMessage("update inventory method");

        $tURL = $this->urlBuilder->updateInventory();
        $this->debugMessage("test url:$tURL");
        $response = $this->callWithXMLPut($tURL, $tXML);

        return $response;
    }

    public function updateInventoryQuantity($sku, $quantity){

        $tXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<ns2:inventory
xmlns:ns2=\"http://walmart.com/\">
<ns2:sku>$sku</ns2:sku>
<ns2:availabilityCode>AC</ns2:availabilityCode>
<ns2:quantity>
<ns2:unit>EACH</ns2:unit>
<ns2:amount>$quantity</ns2:amount>
</ns2:quantity>
<ns2:fulfillmentLagTime>4</ns2:fulfillmentLagTime>
<ns2:minfulfillmentLagTime>1</ns2:minfulfillmentLagTime>
</ns2:inventory>";

        $this->debugMessage("update inventory method");

        $tURL = $this->urlBuilder->updateInventory();
        $this->debugMessage("test url:$tURL");
        $response = $this->callWithXMLPut($tURL, $tXML);

        return $response;
    }

    public function shipping($purchaseOrderId, $country){

        $tXML = $this->generateShippingXML($purchaseOrderId, $country);

//        $tRequest = str_replace("ns2:", "", $tXML);
        $tRequest = htmlentities($tXML);
        echo "<br>REQUEST:<br><pre>";
        echo $tRequest;
        echo "</pre>";

        $this->debugMessage("update shipping");

        $tURL = $this->urlBuilder->shipping($purchaseOrderId);
        $this->debugMessage("test url:$tURL");
        $response = $this->callWithXML($tURL, $tXML);

//        $tResponse = str_replace("ns4:", "", $response);
        $tResponse = htmlentities($response);
        echo "<br>RESPONSE:<br><pre>";
        echo $tResponse;
        echo "</pre><br>";

//        if (strpos($response, "ERROR") !== false) {
            $mail = "<br>REQUEST:<br><pre>$tRequest</pre><br>RESPONSE:<br><pre>$tResponse</pre><br>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            mail("mauricio.aldana@guatedirect.com", "WALMART SHIPPING WS RESPONSE - $purchaseOrderId", "$mail", $headers);

//        }

        return $response;
    }

    public function cancelOrder($purchaseOrderId, $country){

        $tXML = $this->generateCancelOrderXML($purchaseOrderId, $country);
        $this->debugMessage("cancel order method");

        $tURL = $this->urlBuilder->cancelOrder($purchaseOrderId);
        $this->debugMessage("test url:$tURL");
        $response = $this->callWithXML($tURL, $tXML);

        // var_dump($response);

        return $response;
    }

    //

    private function call($mURL){

        $tAuth = $this->auth->getSignature($mURL);

        $tTimestamp = $tAuth["timestamp"];
        $tSignature = $tAuth["signature"];
        $tCorrelationId = $this->getCorrelationId();
        $this->debugMessage("correlation id:$tCorrelationId");

        $this->debugMessage("timestamp:$tTimestamp<br>signature:$tSignature");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $mURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/xml",
                "wm_consumer.channel.type: d62e611e-606e-41b9-96cf-38ee37331c47",
                "wm_consumer.id: 03c36faf-e595-49f9-95aa-980183803460",
                "wm_qos.correlation_id: $tCorrelationId",
                "wm_sec.auth_signature: $tSignature",
                "wm_sec.timestamp: $tTimestamp",
                "wm_svc.name: Drop Ship Vendor Services",
            ),
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
//        $this->debugMessage("STATUS:$httpcode<br>");
//        $this->debugMessage("response:$response<br>");
        return $response;
    }

    private function callWithXML($mURL, $mXML){

        $tAuth = $this->auth->getSignature($mURL, "POST");

        $tTimestamp = $tAuth["timestamp"];
        $tSignature = $tAuth["signature"];
        $tCorrelationId = $this->getCorrelationId();
        $this->debugMessage("correlation id:$tCorrelationId");

        $this->debugMessage("timestamp:$tTimestamp<br>signature:$tSignature");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $mURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $mXML,
            CURLOPT_HTTPHEADER => array(
                "accept: application/xml",
                "Content-Type: application/xml",
                "wm_consumer.channel.type: d62e611e-606e-41b9-96cf-38ee37331c47",
                "wm_consumer.id: 03c36faf-e595-49f9-95aa-980183803460",
                "wm_qos.correlation_id: $tCorrelationId",
                "wm_sec.auth_signature: $tSignature",
                "wm_sec.timestamp: $tTimestamp",
                "wm_svc.name: Walmart Gateway API",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    private function callWithXMLPut($mURL, $mXML){

        $tAuth = $this->auth->getSignature($mURL, "PUT");

        $tTimestamp = $tAuth["timestamp"];
        $tSignature = $tAuth["signature"];
        $tCorrelationId = $this->getCorrelationId();
        $this->debugMessage("correlation id:$tCorrelationId");

        $this->debugMessage("timestamp:$tTimestamp<br>signature:$tSignature");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $mURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $mXML,
            CURLOPT_HTTPHEADER => array(
                "accept: application/xml",
                "Content-Type: application/xml",
                "wm_consumer.channel.type: d62e611e-606e-41b9-96cf-38ee37331c47",
                    "wm_consumer.id: 03c36faf-e595-49f9-95aa-980183803460",
                "wm_qos.correlation_id: $tCorrelationId",
                "wm_sec.auth_signature: $tSignature",
                "wm_sec.timestamp: $tTimestamp",
                "wm_svc.name: Walmart Gateway API",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    private function getCorrelationId(){

        $response = "";
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for($index = 0; $index < 9; $index++){
            $response .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $response;
    }

    private function debugMessage($mMessage){

        if($this->debug){
            echo "$mMessage<br>";
        }
    }

    private function simpleJson($string){

        $string = preg_replace("/ns.:/", "", $string);
        $xml = new SimpleXMLElement($string);
        $json = json_encode($xml);

        return $json;
    }

    private function generateShippingXML($purchaseOrderId, $country){

//        $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $dataQuery = "
            SELECT 
                shi.linenumber, shi.sku, shi.oluniofmea, shi.olamount, shi.shidattim, shi.carrier, shi.methodcode, shi.tranum, shi.traurl, enc.shipdate, enc.tranum, enc.shicar, enc.shimetsel, shi.oricarmet, shi.shipmethod
            FROM
                tra_ord_enc AS enc
                    INNER JOIN
                tra_ord_det AS det ON enc.codorden = det.codorden
                    INNER JOIN
                tra_ord_shi AS shi ON det.coddetord = shi.codorddet
            WHERE
                orderid = '$purchaseOrderId';
        ";

        $dataResult = mysqli_query(conexion($country), $dataQuery);

        $data = "";

        while($dataRow = mysqli_fetch_array($dataResult)){

            $lineNumber = $dataRow["linenumber"];
            $sku = $dataRow["sku"];
            $unitOfMeasurement = $dataRow["oluniofmea"];
            $amount = explode(".", $dataRow["olamount"])[0];
            $shipDateTime = date("Y-m-d\TH:i:s\Z", strtotime($dataRow["shipdate"]));
            $trackingNumber = $dataRow["tranum"];
            $carrierName = $dataRow["shicar"];
            $carrierName = $this->cleanCarrierName($carrierName);
            $carrierMethod = $this->getCarrierMethod($carrierName, $dataRow["shimetsel"]);
            $trackingURL = $this->getTrackingURL(strtolower($carrierName), $trackingNumber);

            $data .= $this->shippingOrderLine($lineNumber, $sku, $unitOfMeasurement, $amount, $shipDateTime, $carrierName, $carrierMethod, $trackingNumber, $trackingURL);
        }

        $response = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
<ns2:orderShipment 
xmlns:ns2=\"http://walmart.com/mp/v3/orders\" 
xmlns:ns3=\"http://walmart.com/\">
<ns2:orderLines>
$data
</ns2:orderLines>
</ns2:orderShipment>";

        return $response;
    }

    private function generateCancelOrderXML($purchaseOrderId, $country){

//        $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
        include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";

        $dataQuery = "
            SELECT 
                shi.linenumber, det.qty, shi.oluniofmea
            FROM
                tra_ord_enc AS enc
                    INNER JOIN
                tra_ord_det AS det ON enc.codorden = det.codorden
                    INNER JOIN
                tra_ord_shi AS shi ON det.coddetord = shi.codorddet
            WHERE
                enc.orderid = '$purchaseOrderId';
        ";

        $dataResult = mysqli_query(conexion($country), $dataQuery);

        $data = "";
        if (mysqli_num_rows($dataResult) > 0) {
            while($value = mysqli_fetch_assoc($dataResult)){
                $lineNumber = $value["linenumber"];
            $amount = $value["qty"];
            $unitOfMeasurement = $value["oluniofmea"];
            $data .="<ns2:orderLine>
                        <ns2:lineNumber>".$lineNumber."</ns2:lineNumber>
                        <ns2:orderLineStatuses>
                            <ns2:orderLineStatus>
                                <ns2:status>Cancelled</ns2:status>
                                <ns2:cancellationReason>SUPPLIER_CANCEL_CUSTOMER_REQUEST</ns2:cancellationReason>
                                <ns2:statusQuantity>
                                    <ns2:unitOfMeasurement>".$unitOfMeasurement."</ns2:unitOfMeasurement>
                                    <ns2:amount>".$amount."</ns2:amount>
                                </ns2:statusQuantity>
                            </ns2:orderLineStatus>
                        </ns2:orderLineStatuses>
                    </ns2:orderLine>";
            }   
        } else {
            die("Error: No hay datos en la tabla seleccionada");
        }
        

        $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                        <ns2:orderCancellation
                            xmlns:ns2=\"http://walmart.com/mp/v3/orders\"
                            xmlns:ns3=\"http://walmart.com/\">
                                <ns2:orderLines>
                                    $data
                                </ns2:orderLines>
                        </ns2:orderCancellation>";
            // echo "<script>console.log('".$response." line number')</script>";
            return $response;
    }

    private function generateUpdateInventoryXML($sku, $country){

//        $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $dataQuery = "
            SELECT 
                physicalin
            FROM
                sageinventario
            WHERE
                productid = '$sku';
        ";

        $dataResult = mysqli_query(conexion($country), $dataQuery);

        $data = "";

        while($dataRow = mysqli_fetch_array($dataResult)){

            $amount = $dataRow["physicalin"];

            $data .= $this->updateInventoryLine($sku, $amount);
        }

        $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<ns2:inventory
xmlns:ns2=\"http://walmart.com/\">
$data 
</ns2:inventory>";

        return $response;
    }

    private function shippingOrderLine($lineNumber, $sku, $unitOfMeasurement, $amount, $shipDateTime, $carrierName, $carrierMethod, $trackingNumber, $trackingURL){

//        echo "LN:$lineNumber, SKU:$sku, UOM:$unitOfMeasurement, A:$amount, :SD$shipDateTime, CN:$carrierName, CM:$carrierMethod, TN:$trackingNumber, TU:$trackingURL<br><br>";

        return "<ns2:orderLine>
<ns2:lineNumber>$lineNumber</ns2:lineNumber>
<ns2:orderLineStatuses>
<ns2:orderLineStatus>
<ns2:status>Shipped</ns2:status>
<ns2:statusQuantity>
<ns2:unitOfMeasurement>$unitOfMeasurement</ns2:unitOfMeasurement>
<ns2:amount>$amount</ns2:amount>
</ns2:statusQuantity>
<ns2:trackingInfo>
<ns2:shipDateTime>$shipDateTime</ns2:shipDateTime>
<ns2:carrierName>
<ns2:carrier>$carrierName</ns2:carrier>
</ns2:carrierName>
<ns2:methodCode>$carrierMethod</ns2:methodCode>
<ns2:trackingNumber>$trackingNumber</ns2:trackingNumber>
<ns2:trackingURL>$trackingURL</ns2:trackingURL>
</ns2:trackingInfo>
</ns2:orderLineStatus>
</ns2:orderLineStatuses>
</ns2:orderLine>";
    }

    private function cancelOrderLine($lineNumber, $amount, $unitOfMeasurement){

        return "<ns2:orderLine>
<ns2:lineNumber>".$lineNumber."</ns2:lineNumber>
<ns2:orderLineStatuses>
<ns2:orderLineStatus>
<ns2:status>Cancelled</ns2:status>
<ns2:cancellationReason>SUPPLIER_CANCEL_CUSTOMER_REQUEST</ns2:cancellationReason>
<ns2:statusQuantity>
<ns2:unitOfMeasurement>".$unitOfMeasurement."</ns2:unitOfMeasurement>
<ns2:amount>".$amount."</ns2:amount>
</ns2:statusQuantity>
</ns2:orderLineStatus>
</ns2:orderLineStatuses>
</ns2:orderLine>";
    }

    private function updateInventoryLine($sku, $amount){

        return "<ns2:sku>$sku</ns2:sku>
<ns2:availabilityCode>AC</ns2:availabilityCode>
<ns2:quantity>
<ns2:unit>EACH</ns2:unit>
<ns2:amount>$amount</ns2:amount>
</ns2:quantity>
<ns2:fulfillmentLagTime>4</ns2:fulfillmentLagTime>
<ns2:minfulfillmentLagTime>1</ns2:minfulfillmentLagTime>";
    }

    public function getTrackingURL($carrier, $trackingNumber){
        return "https://track.walmart.com/walmart/tracking/$carrier?tracking_numbers=$trackingNumber";
    }

    public function getCarrierMethod($carrier, $method){

        if($carrier == strtolower("fedex") && $method == strtolower("expedited")){
            return "Express";
        }
        else if($carrier == strtolower("ups") && $method == strtolower("rush")){
            return "OneDay";
        }
        else{
            return "Standard";
        }
    }

    private function cleanCarrierName($carrierName){
        switch ($carrierName){
            case "USPS Priority Mail":
                return "USPS";
            default:
                return $carrierName;
        }
    }
}

/*
 *
<ns2:asn>
<ns2:packageASN>$sku</ns2:packageASN>
<ns2:palletASN>$sku</ns2:palletASN>
</ns2:asn>

 * */