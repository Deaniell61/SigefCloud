<?php

/**
 * Class sellercloud
 */
class sellercloud {

    const user = "sigefcloud@sigefcloud.com";

    const pass = "51g3fC10ud";

    const scServiceURL = "http://as.ws.sellercloud.com/scservice.asmx?WSDL";

    const scOrderCreationServiceURL = "http://as.ws.sellercloud.com/OrderCreationService.asmx?WSDL";

    const scPurchaseOrderServiceURL = "http://as.ws.sellercloud.com/POServices.asmx?WSDL";

    const scInventoryServiceURL = "http://as.ws.sellercloud.com/SCInventoryService.asmx?WSDL";

    private $scService;
    private $scOrderCreationService;
    private $scPurchaseOrderService;
    private $scInventoryService;

    /**
     * sellercloud constructor.
     */
    function __construct() {

        $this->scService = new SoapClient(self::scServiceURL);
        $this->scOrderCreationService = new SoapClient(self::scOrderCreationServiceURL);
        $this->scPurchaseOrderService = new SoapClient(self::scPurchaseOrderServiceURL);
        $this->scInventoryService = new SoapClient(self::scInventoryServiceURL);

        $apiauth = ["UserName" => self::user, "Password" => self::pass, "ValidateDeviceID" => true];
        $header = new SoapHeader("http://api.sellercloud.com/", "AuthHeader", $apiauth);
        $this->scService->__setSoapHeaders([$header]);
        $this->scOrderCreationService->__setSoapHeaders([$header]);
        $this->scPurchaseOrderService->__setSoapHeaders([$header]);
        $this->scInventoryService->__setSoapHeaders([$header]);
    }

    public function testArray($mName) {

        return $this->getRequestArray($mName);
    }

    /**
     * @param $module
     * @param string $id
     * @return array
     */
    private function getRequestArray($module, $id = "-999") {

        $response = [];
        session_start();
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $getArrayQuery = "SELECT NOMBRE, VALOR FROM cat_campos_sellercloud WHERE MODULO = '$module' ORDER BY ORDEN;";
        $getArrayResult = mysqli_query(conexion(""), $getArrayQuery);
        if ($getArrayResult) {
            if ($getArrayResult->num_rows > 0) {
                while ($getArrayRow = mysqli_fetch_array($getArrayResult)) {
                    $valueData = explode("|", $getArrayRow[1]);
                    if ($valueData[0] == "var") {
                        $response[$getArrayRow[0]] = $valueData[1];
                    }
                    else if ($valueData[0] == "table") {
                        if ($id != "-999") {
                            $tFilterData = $id;
                        }
                        else {
                            $tFilterData = $valueData[4];
                            $tSession = "";
                            if ($valueData[4] == "" || $valueData[4] == "-1") {
                                $tSession = $valueData[3];
                                $tFilterData = $_SESSION[$tSession];
                            }
                            else if ($valueData[4][0] == "$") {
                                $tSession = substr($valueData[4], 1);
                                $tFilterData = $_SESSION[$tSession];
                            }
                        }
                        $tValue = $this->getDatabaseValue($valueData[1], $valueData[2], $valueData[3], $tFilterData, $valueData[5]);
                        if ($getArrayRow[0] == "OrderDate") {
                            $tValue = str_replace(" ", "T", $tValue);
                        }

                        else if($getArrayRow[0] == "ShipDate"){
                            $tValue = str_replace(" ", "T", $tValue);
                        }
                        /*
                        else if ($getArrayRow[0] == "ShipDate" && $tValue = "0000-00-00 00:00:00") {
                            $tValue = "0001-01-01T00:00:00";
                        }
                        */
                        $response[$getArrayRow[0]] = $tValue;
                    }
                    else if ($valueData[0] == "array") {
                        if ($valueData[1] == "" || $valueData[1] == "-1") {
                            $response[$getArrayRow[0]] = $this->getRequestArray($valueData[6]);
                        }
                        else {
                            $id != "-999" ? $tFilterData = $id : $tFilterData = $valueData[4];
                            $response[$getArrayRow[0]] = $this->getDatabaseArray($valueData[1], $valueData[2], $valueData[3], $tFilterData, $valueData[5], $valueData[6]);
                        }
                    }
                    else if ($valueData[0] == "function") {
                        $response[$getArrayRow[0]] = call_user_func(["sellercloud", $valueData[1]], [""]);
                    }
//                    var_dump($response);
                }
            }
        }
        return $response;
    }

    /**
     * @param $table
     * @param $field
     * @param $filter
     * @param $filterValue
     * @param $connectionType
     * @return string
     */
    private function getDatabaseValue($table, $field, $filter, $filterValue, $connectionType) {

        session_start();
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $getValueQuery = "SELECT $field FROM $table WHERE $filter = '$filterValue';";

        $result = null;
        if ($connectionType == 1) {
            $result = mysqli_query(conexion($_SESSION["pais"]), $getValueQuery);
        }
        else if ($connectionType == 2) {
            $result = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getValueQuery);
        }
        else {
            $result = mysqli_query(conexion(""), $getValueQuery);
        }
        $response = "-999";
        if ($field == "ShippingLocationID" || $field = "StationID") {
            $response = "0";
        }
        if ($result) {
            if ($result->num_rows > 0) {
                $response = mysqli_fetch_array($result)[0];
            }
        }
//        echo "$getValueQuery<br>";
//        echo "$response<br>";
        return $response;
    }

    /**
     * @param $table
     * @param $field
     * @param $filter
     * @param $filterValue
     * @param $connectionType
     * @param $module
     * @return array
     */
    private function getDatabaseArray($table, $field, $filter, $filterValue, $connectionType, $module) {

        session_start();
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        if ($filterValue[0] == "$") {
            $tSession = substr($filterValue, 1);
            $filterValue = $_SESSION[$tSession];
        }
        $getValueQuery = "SELECT $field FROM $table WHERE $filter = '$filterValue';";
        $result = null;
        if ($connectionType == 1) {
            $result = mysqli_query(conexion($_SESSION["pais"]), $getValueQuery);
        }
        else if ($connectionType == 2) {
            $result = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getValueQuery);
        }
        else {
            $result = mysqli_query(conexion(""), $getValueQuery);
        }
        $response = [];
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $response[] = $this->getRequestArray($module, $row[0]);
                }
            }
        }
        return $response;
    }

    /*
     * seller cloud methods
     * */

    public function getUser($username) {

        return $result = $this->scOrderCreationService->Customer_Get(["UserName" => $username]);
    }

    public function saveUser($username, $firstname, $lastname) {

        session_start();
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $companyId = "-1";
        $tCodEmpresa = $_SESSION["codEmpresa"];
        $query = "SELECT companyid from cat_empresas WHERE CODEMPRESA = '$tCodEmpresa';";

        $result = mysqli_query(conexion(""), $query);

        if ($result) {
            if ($result->num_rows > 0) {
                $companyId = mysqli_fetch_array($result)[0];

                try {
                    $result = $this->scOrderCreationService->Customer_AddNew([
                        "CompanyID" => $companyId,
                        "Email" => $username,
                        "FirstName" => $firstname,
                        "LastName" => $lastname,
                        "IsWholeSaleCustomer" => "false",
                        "TaxExempt" => 'false',
                    ]);
                } catch (SoapFault $error) {
                    $result = $error->faultstring;
                }
            }
        }
        return $result;
    }

    public function createNewOrder() {

        $array = $this->getRequestArray("CreateNewOrder");
//        var_dump($array);

        $path = $_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/csv/sellercloudNewOrders.csv";
        $file = fopen($path,"a");
        fwrite($file, "");
        fwrite($file, date("Ymd-h:m:s"));
        fwrite($file, "");
        fwrite($file, print_r($array, TRUE));
        fclose($file);

        try {
            $result = $this->scOrderCreationService->CreateNewOrder($array);
        } catch (SoapFault $error) {
            echo $error->faultstring;
            $result = $error->faultstring;
            $result = explode("System.Exception: ",$result)[1];
            $result = explode(" at",$result)[0];
            $result = trim(preg_replace('/\s+/', ' ', $result));
            $result = [
                "error" => $result,
            ];
        }
        return $result;
    }

    public function getOrders($companyId, $startDate, $endDate, $pages) {

        try {
            $result = $this->scOrderCreationService->ListOrders([
                "CompanyID" => $companyId,
                "startDate" => $startDate,
                "EndDate" => $endDate,
                "PageNumber" => $pages,
            ]);
        } catch (SoapFault $fault) {
            $result = "E:" . $fault->faultstring;
        }
        return $result;
    }

    public function getOrderFull($orderId) {

        try {
            $result = $this->scOrderCreationService->GetOrderFull([
                "OrderID" => $orderId,
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function getPackageTypes() {

        try {
            $result = $this->scService->GetPackageTypes();
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function getProduct($productId) {

        try {
            $result = $this->scService->GetProduct([
                "ID" => $productId,
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function getZipCode($zipCode) {

        try {
            $result = $this->scOrderCreationService->ZipCodeSearch([
                "ZipCode" => $zipCode,
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function bulkUpdate($file) {

        try {
            $result = $this->scService->BulkUpdateFieldsQueueSmart([
                "contents" => $file,
                "isUPCFirst" => false,
                "subtractUnExportedOrderInventoryQty" => false,
                "CreateNewProducts" => false,
                "subtractUnshippedOrderInventoryQty" => false,
                "options" => [
                    "OnlyUpdateProductsForCompany" => 163,
                    "CustomCompanyID" => 163,
                    "CompanyIDForNewProducts" => 163,
                    "UsePlugin" => false,
                    "PluginName" => ""
                ]
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function updateInventory($data, $country) {

        try {
            foreach ($data as $product) {
                $request[] = $entry["UpdateInventoryRequest"] = [
                    "ProductID" => $product["ProductID"],
                    "WarehouseName" => $product["WarehouseName"],
                    "Qty" => $product["Qty"],
                    "InventoryDate" => $product["InventoryDate"],
                ];
                $codprod = $product["codProd"];
                $updateQuery = "
                UPDATE 
                    sageinventario 
                SET 
                    actualiza = '0'
                WHERE
                    codprod = '$codprod';
                 
            ";
                mysqli_query(conexion($country), $updateQuery);
            }
            $result = $this->scInventoryService->UpdateInventory([
                "req" => $request
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
//            var_dump($data);
//            echo "<br><br>";
            var_dump($result);
//            echo "<br><br>";
        }
        return $result;
    }

    public function createNewProduct($productData) {

        try {
            $result = $this->scService->CreateNewProduct([
                "newTypeID" => "705",
                "productID" => $productData["productId"],
                "productName" => $productData["productName"],
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function createProductFullInfo($productData) {

        try {

            $tManufacturerID = "";

            $result = $this->scService->CreateProductFullInfo([
                "info" => [
                    "ID" => $productData["productId"],
                    "ProductName" => $productData["productName"],
//                    "ManufacturerSKU" => $productData["manufacturerSKU"],
                    "ManufacturerID" => $tManufacturerID,
                    "ListPrice" => $productData["listPrice"],
                    "StorePrice" => $productData["storePrice"],
                    "SitePrice" => $productData["sitePrice"],
                    "SiteCost" => $productData["siteCost"],
                    "LastCost" => $productData["lastCost"],
                    "TaxExempt" => $productData["taxExempt"],
//                    "ShortDescription" => $productData["shortDescription"],
//                    "LongDescription" => $productData["longDescription"],
//                    "UPC" => $productData["UPC"],
                    "CompanyID" => $productData["companyID"],
                    "ProductTypeID" => "705",
                    "ProductSource" => $productData["productSource"],
//                    "ProductSourceSKU" => $productData["productSourceSKU"],
//                    "ProductMasterSKU" => $productData["productMasterSKU"],
                    "Qty" => $productData["qty"],
//                    "VendorName" => $productData["vendorName"],
                    "VendorCost" => $productData["vendorCost"],
                    "BuyerID" => $productData["buyerID"],
                ]
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function getPickListDetailedInfo($pickListID) {

        try {
            $result = $this->scService->PickList_GetDetailedInfo([
                "PickListID" => $pickListID,
            ]);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function markShipped($data) {

        $a = [
            "OrderID" => $data["OrderID"],
            "ShipDate" => $data["ShipDate"],
            "ShippingCarrier" => $data["ShippingCarrier"],
            "ShippingService" => $data["ShippingService"],
            "ShippingCost" => $data["ShippingCost"],
            "TrackingNumber" => $data["TrackingNumber"],
        ];

        try {
            $result = $this->scOrderCreationService->Orders_MarkShipped($a);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    public function markCompleted($data) {

        $a = [
            "OrderID" => $data["OrderID"],
            "StatusCode" => "Completed",
        ];

        try {
            $result = $this->scOrderCreationService->Orders_UpdateStatus($a);
        } catch (SoapFault $fault) {
            $result = $fault->faultstring;
        }
        return $result;
    }

    /*
     * aux mehtods
     * */
    public function getIP() {

        return $_SERVER['REMOTE_ADDR'];
    }
}