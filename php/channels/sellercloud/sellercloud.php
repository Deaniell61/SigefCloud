<?php

namespace channels;

class sellercloud
{
    const user = "sigefcloud@sigefcloud.com";
    const pass = "51g3fC10ud";

    const scServiceURL = "http://as.ws.sellercloud.com/scservice.asmx?WSDL";
    const scOrderCreationServiceURL = "http://as.ws.sellercloud.com/OrderCreationService.asmx?WSDL";
    const scPurchaseOrderServiceURL = "http://as.ws.sellercloud.com/POServices.asmx?WSDL";
    const scInventoryServiceURL = "http://as.ws.sellercloud.com/SCInventoryService.asmx?WSDL";

    const MSG_INVALID_PRODUCT = "invalid product.<br>";

    private $scService;
    private $scOrderCreationService;
    private $scPurchaseOrderService;
    private $scInventoryService;

    public function __construct($debug = false)
    {
        $this->scService = new \SoapClient(self::scServiceURL, ["trace" => 1]);
        $this->scOrderCreationService = new \SoapClient(self::scOrderCreationServiceURL);
        $this->scPurchaseOrderService = new \SoapClient(self::scPurchaseOrderServiceURL);
        $this->scInventoryService = new \SoapClient(self::scInventoryServiceURL);

        $apiauth = ["UserName" => self::user, "Password" => self::pass, "ValidateDeviceID" => true];
        $header = new \SoapHeader("http://api.sellercloud.com/", "AuthHeader", $apiauth);
        $this->scService->__setSoapHeaders([$header]);
        $this->scOrderCreationService->__setSoapHeaders([$header]);
        $this->scPurchaseOrderService->__setSoapHeaders([$header]);
        $this->scInventoryService->__setSoapHeaders([$header]);
    }

    public function createProduct($sku, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $productQ = "
            SELECT 
                PRODNAME
            FROM
                cat_prod
            WHERE
                mastersku = '$sku';
        ";

        $productR = mysqli_query(conexion($country), $productQ);

        if (!$productR || $productR->num_rows != 1) {
            echo self::MSG_INVALID_PRODUCT;
            return;
        }

        $product = mysqli_fetch_array($productR);

        $productId = $sku;
        $productName = $product["PRODNAME"];

        $data = [
            "newTypeID" => "705",
            "productID" => $productId,
            "productName" => $productName,
        ];

        try {
            $result = $this->scService->CreateNewProduct(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;
        }

        var_dump($result);

        return $result;
    }

    public function updateProductFull($sku, $country)
    {
        include_once ("saveProductData.php");

        $data = saveProductData($sku, $country);
//        echo "<br><pre>";
//        print_r($data);
//        echo "</pre><br><br>";

        try {
            $result = $this->scService->SaveProduct([
                "Product" => $data
            ]);
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;
            $number = explode("(2, ", $result)[1];
            $number = explode(")", $number)[0];
            $req = ($this->scService->__getLastRequest());
            $req = str_replace(" ", "", $req);
            echo htmlspecialchars(substr($req,  ($number - 55), 55));

            echo "<br>E:$fault->faultstring<br><pre>";
            echo htmlspecialchars($this->scService->__getLastRequest());
            echo "</pre><br><br>";

            $result = [
                "status" => "ERROR",
                "message" => $fault->faultstring,
            ];

            return json_encode($result);
        }

//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";

        $result = [
            "status" => "SUCCESS",
            "message" => "SUCCESS",
        ];

        return json_encode($result);
    }

    public function updateName($sku, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $productQ = "
            SELECT 
                PRODNAME
            FROM
                cat_prod
            WHERE
                mastersku = '$sku';
        ";

        $productR = mysqli_query(conexion($country), $productQ);

        if (!$productR || $productR->num_rows != 1) {
            echo self::MSG_INVALID_PRODUCT;
            return;
        }

        $product = mysqli_fetch_array($productR);

        $productId = $sku;
        $productName = $product["PRODNAME"];

        $data = [
            "ProductID" => $productId,
            "ProductName" => $productName,
        ];

        try {
            $result = $this->scService->UpdateProductShortInfo(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;
        }

        var_dump($result);

        return $result;
    }

    public function updateDescriptions($sku, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $productQ = "
            SELECT 
                DESCSIS
            FROM
                cat_prod
            WHERE
                mastersku = '$sku';
        ";

        $productR = mysqli_query(conexion($country), $productQ);

        if (!$productR || $productR->num_rows != 1) {
            echo self::MSG_INVALID_PRODUCT;
            return;
        }

        $product = mysqli_fetch_array($productR);

        $productId = $sku;
        $productDescription = $product["DESCSIS"];

        $data = [
            "info" => [
                "ID" => $productId,
                "ShortDescription" => $productDescription,
                "LongDescription" => $productDescription,
            ]
        ];

        try {
            $result = $this->scService->UpdateProductFullInfo(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;
        }

        var_dump($result);

        return $result;
    }

    public function updateDimensions($sku, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $productQ = "
            SELECT 
                ALTO, ANCHO, PROFUN
            FROM
                cat_prod
            WHERE
                mastersku = '$sku';
        ";

        $productR = mysqli_query(conexion($country), $productQ);

        if (!$productR || $productR->num_rows != 1) {
            echo self::MSG_INVALID_PRODUCT;
            return;
        }

        $product = mysqli_fetch_array($productR);

        $productId = $sku;
        $productHeight = $product["ALTO"];
        $productWidth = $product["ANCHO"];
        $productLenght = $product["PROFUN"];

        $data = [
            "ID" => $productId,
            "height" => $productHeight,
            "width" => $productWidth,
            "length" => $productLenght,
        ];

        try {
            $result = $this->scService->SetProductDimensions(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;
        }

        return $result;
    }

    public function updateWeight($sku, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $productQ = "
            SELECT 
                ((PESO_LB * 16) + PESO_OZ) AS PESO
            FROM
                cat_prod
            WHERE
                mastersku = '$sku';
        ";

        $productR = mysqli_query(conexion($country), $productQ);

        if (!$productR || $productR->num_rows != 1) {
            echo self::MSG_INVALID_PRODUCT;
            return;
        }

        $product = mysqli_fetch_array($productR);

        $productId = $sku;
        $productWeight = $product["PESO"];

        $data = [
            "ID" => $productId,
            "weightOz" => $productWeight,
        ];
        try {
            $result = $this->scService->SetProductWeight(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;
        }

        return $result;
    }

    public function getOrderFromOrderSourceOrderId($orderSourceOrderId)
    {
//        $orderSourceOrderId = 2711692;
        try {
            $result = $this->scOrderCreationService->GetOrderFromOrderSourceOrderID([
                "OrderSource" => "PriceFalls",
                "OrderSourceOrderId" => $orderSourceOrderId
            ]);
        } catch (\SoapFault $fault) {
            $result = "E:" . $fault->faultstring;
        }
        return $result;
    }

    public function getBrandByName($brand){

        $data = [
            "BrandName" => $brand
        ];

        try {
            $result = $this->scService->Brands_GetByName(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;

            $response = [
                "status" => "error",
                "message" => $result,
            ];

            return $response;
        }

        $isEmpty = empty((array) $result);

        if($isEmpty){
            $response = [
                "status" => "error",
                "message" => "empty",
            ];
            return $response;
        }

        $response = [
            "status" => "success",
            "result" => $result,
        ];
        return $response;
    }

    public function createBrand($brand){

        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

        $data = [
            "BrandName" => $brand
        ];
        try {
            $result = $this->scService->Brands_CreateNew(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;

            $response = [
                "status" => "error",
                "message" => $result,
            ];

            return $response;
        }

        $response = [
            "status" => "success",
            "result" => $result,
        ];
        return $response;
    }

    public function addKitItem($sku, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $productQ = "
            SELECT 
                mastersku, unitbundle
            FROM
                tra_bun_det
            WHERE
                amazonsku = '$sku';
        ";

        $productR = mysqli_query(conexion($country), $productQ);

        if (!$productR || $productR->num_rows != 1) {
            echo self::MSG_INVALID_PRODUCT;
            return;
        }

        $product = mysqli_fetch_array($productR);

        $productId = $sku;
        $masterSKU = $product["mastersku"];
        $unitbundle = $product["unitbundle"];

        $data = [
            "MainProductID" => $productId,
            "KitProductId" => $masterSKU,
            "KitQty" => $unitbundle,
            "Sequence" => 1,
            "IsMainItem" => 1,
        ];

        try {
            $result = $this->scService->ProductKit_AddKitItem(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;

            $result = [
                "status" => "ERROR",
                "message" => $fault->faultstring,
            ];

            return json_encode($result);
        }
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";

        $result = [
            "status" => "SUCCESS",
            "message" => "SUCCESS",
        ];

        return json_encode($result);
    }

    public function addImage($sku, $imageID, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

        $imagesName = [
            "ad1" => "Aditional 1",
            "AD2" => "Aditional 2",
            "BACK" => "Back",
            "CODBAR" => "UPC",
            "fro" => "Front",
            "FRONT" => "Front",
            "ingi" => "Ingredients",
            "INSIDE" => "Inside",
            "notfretch" => "Nutrition Facts",
            "PERFIL" => "Side",
            "PERFILDER" => "Right Side",
            "perfiliz" => "Left Side"
        ];

        //get image to upload
        $imageQ = "
            SELECT 
                *
            FROM
                cat_prod_img  
            WHERE
                CODIMAGE = '$imageID';
        ";

        $imageR = mysqli_query(conexion($country), $imageQ);

        if (!$imageR || $imageR->num_rows != 1) {
            echo self::MSG_INVALID_PRODUCT;
            return;
        }

        $image = mysqli_fetch_array($imageR);

        $productId = $sku;
        $tCara = $imagesName[$image["CARA"]];
        $tFile = $image["FILE"];
        $tCodProd = $image["CODPROD"];

        //get emp name to build the image path
        $tImagePath = $this->getImagePath($sku, $country);
        $tImagePath .= $tFile;

        //get the image
        $tImage = file_get_contents($tImagePath);

        $data = [
            "ProductID" => $productId,
            "image" => $tImage,
            "Caption" => $tCara,
            "OriginalFileName" => $tFile,
            "fileType" => "Image",
        ];

        try {
            $result = $this->scService->AddImage(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = [
                "status" => "ERROR",
                "message" => $fault->faultstring,
            ];

            return json_encode($result);
        }

        //if success get the image sellercloud codes
        $imageInfo = getSingleValue("SELECT SCCOD FROM cat_prod_img WHERE CODIMAGE = '$imageID';", $country);

        //add the sku and sc image cod
        if($imageInfo == ""){
            $imageInfo = array($sku => $result->AddImageResult);
        }
        else{
            $imageInfo = json_decode($imageInfo, true);
            $imageInfo[$sku] = $result->AddImageResult;
        }
        $imageInfo = json_encode($imageInfo);

        //update sccodes
        $imageInfoU = "UPDATE cat_prod_img SET SCCOD = '$imageInfo' WHERE CODIMAGE = '$imageID';";
        mysqli_query(conexion($country), $imageInfoU);

        //build result
        $result = [
            "status" => "SUCCESS",
            "message" => $result->AddImageResult,
        ];

        //return result
        return json_encode($result);
    }

    public function updateImage($imageCode, $scImageCode, $country)
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $imageQ = "SELECT * FROM cat_prod_img WHERE CODIMAGE = '$imageCode';";
        $imageR = mysqli_query(conexion($country), $imageQ);
        $imageRow = mysqli_fetch_array($imageR);
        $tCodProd = $imageRow["CODPROD"];
        $tFile = $imageRow["FILE"];

        $sku = getSingleValue("SELECT mastersku FROM cat_prod WHERE codprod = '$tCodProd';", $country);

        //get emp name to build the image path
        $tImagePath = $this->getImagePath($sku, $country);
        $tImagePath .= $tFile;

        //get the image
        $tImage = file_get_contents($tImagePath);

        $data = [
            "id" => $scImageCode,
            "bytes" => $tImage,
            "fileType" => "Image",
        ];
        try {
            $result = $this->scService->UpdateImageBytes(
                $data
            );
        } catch (\SoapFault $fault) {

            $response = [
                "status" => "ERROR",
                "message" => $fault->faultstring,
            ];

            return json_encode($response);
        }

        $response = [
            "status" => "SUCCESS",
            "result" => $result,
        ];
        return json_encode($response);
    }

    public function listProductImages($sku){

        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

        $data = [
            "ProductID" => $sku
        ];
        try {
            $result = $this->scService->ListProductImages(
                $data
            );
        } catch (\SoapFault $fault) {
            $result = $fault->faultstring;

            $response = [
                "status" => "error",
                "message" => $result,
            ];

            return json_encode($response);
        }

        $response = [
            "status" => "success",
            "result" => $result->ListProductImagesResult,
        ];
        return json_encode($response);
    }

    function deleteImage($scImageID){

        $data = [
            "id" => $scImageID,
        ];

        try {
            $result = $this->scService->DeleteImage(
                $data
            );
        } catch (\SoapFault $fault) {

            $result = [
                "status" => "ERROR",
                "message" => $fault->faultstring,
            ];

            return json_encode($result);
        }
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";

        $result = [
            "status" => "SUCCESS",
            "message" => "SUCCESS",
        ];

        return json_encode($result);
    }

    function getImagePath($sku, $country){

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        $tCodEmpresa = getSingleValue("
            SELECT 
                prod.CODEMPRESA
            FROM
                cat_prod AS prod
                    INNER JOIN
                tra_bun_det AS bun ON prod.mastersku = bun.mastersku
            WHERE
                (prod.mastersku = '$sku'
                    || bun.amazonsku = '$sku')
            ORDER BY bun.unitbundle
            LIMIT 1;
        ", $country);

        $tEmpresa = getSingleValue("
            SELECT 
                NOMBRE
            FROM
                cat_empresas
            WHERE
                codempresa = '$tCodEmpresa';
        ");

        //build the image path
        return $tImagePath = "https://sigefcloud.com/imagenes/media/cache/" . limpiar_caracteres_especiales(strtolower($tEmpresa)) . "/";
    }
}
