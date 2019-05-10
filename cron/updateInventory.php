<?php

echo "update inventory.<br>";

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

$connectionPath = $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";
$sellercloudPath = $_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php";
$walmartPath = $_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php";
$mailPath = $_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/PHPMailerAutoload.php";

include_once($connectionPath);
include_once($sellercloudPath);
include_once($walmartPath);
include_once($mailPath);

$sellercloud = new sellercloud();
$walmart = new walmart(false);

$errors[] =  "SKU,AMAZONSKU,UNITBUNDLE,BUNDLEQUANTITY";
$updated[] = "SKU,AMAZONSKU,UNITBUNDLE,BUNDLEQUANTITY";

$getCountriesQuery = "
    SELECT 
        dir.nomPais
    FROM
        direct AS dir
            INNER JOIN
        cat_empresas AS emp ON dir.codPais = emp.pais
    WHERE
        emp.companyid != '0';
";

$getCountriesResult = mysqli_query(conexion(""), $getCountriesQuery);

while ($getCountriesRow = mysqli_fetch_array($getCountriesResult)) {
    $getInventoryQuery = "
        SELECT 
            inv.codprod,
            productid,
            wharehouse,
            PHYSICALIN,
            InventoryD,
            estatus
        FROM
            sageinventario AS inv
        WHERE
            actualiza = '1'
        ORDER BY InventoryD ASC
        LIMIT 10;
     "; // actualiza = '1' AND productid = '502300489'
//echo "$getInventoryQuery<br>";
    $counter = 0;
    $getInventoryResult = mysqli_query(conexion($getCountriesRow[0]), $getInventoryQuery);
    for ($index = 0; $index < $getInventoryResult->num_rows; $index++) {
        echo "!!!$index<br>";
        $getInventoryRow = mysqli_fetch_array($getInventoryResult);
        $tCodProd = $getInventoryRow["codprod"];
        $tEstatus = $getInventoryRow["estatus"];
        $tProductId = $getInventoryRow["productid"];
        $tWarehouse = $getInventoryRow["wharehouse"];
        $tQuantity = ($tEstatus == "A") ? explode(".", $getInventoryRow["PHYSICALIN"])[0] : "0";
        $tInventoryDate = str_replace(" ", "T", $getInventoryRow["InventoryD"]);
        if($tInventoryDate = "0000-00-00T00:00:00"){
            $tInventoryDate = date("c");
        }
        if($tEstatus == "B"){
//            echo "$tCodProd esta de baja<br>";
        }

        $data[] = [
            "codProd" => $tCodProd,
            "ProductID" => $tProductId,
            "WarehouseName" => $tWarehouse,
            "Qty" => $tQuantity,
            "InventoryDate" => $tInventoryDate,
        ];

        if (($index + 1) % 20 == 0) {
            $result = $sellercloud->updateInventory($data, $getCountriesRow[0]);
//            echo "batch transaction: " . $result->UpdateInventoryResult . "<br>";

            $data = null;
        }
        echo "$tProductId<br>";
        walmartUpdate($tProductId, $tQuantity);
    }

    if (count($data) > 0) {
        $result = $sellercloud->updateInventory($data, $getCountriesRow[0]);
//        echo "batch transaction: " . $result->UpdateInventoryResult . "<br>";

//        walmartUpdate($tProductId, $tQuantity);
        $data = null;
    }

    echo $getCountriesRow[0] . ": $counter<br>";
}

$date = date("Ymd");
//var_dump($errors);
//var_dump($updated);
if(!empty($errors)){
//        echo "ERRORS<br>";
    $path = dirname(__FILE__) . "/walmartInventoryCSV/updateInventoryWalmart-Errors-$date.csv";
    $file = fopen($path,"w");
//    fputcsv($file,explode(',',"SKU,AMAZONSKU,UNITBUNDLE,BUNDLEQUANTITY"));
    foreach ($errors as $line){
        fputcsv($file,explode(',',$line));
    }
    fclose($file);

    /*
    $recipient = "romalch@gmail.com";
//    $recipient = "solus.huargo@gmail.com";
    $subject = "Walmart Update Inventory Errors $date";
    $message = "CSV attachement";
    $cc = "jonatan.catalan@sigefcloud.com";
    $mail = new PHPMailer(true);
    try{
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "srv70.hosting24.com";
        $mail->Port = 465;
        $mail->Username = "support@sigefcloud.com";
        $mail->Password = "5upp0rt51g3fCl0ud";
        $mail->setFrom("sigefcloud@sigefcloud.com", "SigefCloud");
        $mail->addAddress($recipient, $recipient);
        $mail->addCC("$cc", "$cc");
        $mail->addAttachment($path);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    }catch (phpmailerException $e){
//            echo $e->errorMessage();
    }
    */
}

if(!empty($updated)){
//        echo "UPDATES<br>";
    $path = dirname(__FILE__) . "/walmartInventoryCSV/updateInventoryWalmart-Updated-$date.csv";
    $file = fopen($path,"w");
//    fputcsv($file,explode(',',"SKU,AMAZONSKU,UNITBUNDLE,BUNDLEQUANTITY"));
    foreach ($updated as $line){
        fputcsv($file,explode(',',$line));
    }
    fclose($file);

    /*
    $recipient = "romalch@gmail.com";
//    $recipient = "solus.huargo@gmail.com";
    $subject = "Walmart Update Inventory $date";
    $message = "CSV attachement";
    $cc = "jonatan.catalan@sigefcloud.com";
    $mail = new PHPMailer(true);
    try{
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "srv70.hosting24.com";
        $mail->Port = 465;
        $mail->Username = "support@sigefcloud.com";
        $mail->Password = "5upp0rt51g3fCl0ud";
        $mail->setFrom("sigefcloud@sigefcloud.com", "SigefCloud");
        $mail->addAddress($recipient, $recipient);
        $mail->addCC("$cc", "$cc");
        $mail->addAttachment($path);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    }catch (phpmailerException $e){
//            echo $e->errorMessage();
    }
    */
}

function walmartUpdate($sku, $qty){
    global $walmart;
    global $errors;
    global $updated;
    $skuPrefix = substr($sku, 0, 3);
    $tCountry = ($skuPrefix == "506") ? "Costa Rica" : "Guatemala";
//    echo "PREFIX:$skuPrefix COUNTRY:$tCountry<br>";

    $bundlesQ = "
        SELECT
            AMAZONSKU, UNITBUNDLE
        FROM
            tra_bun_det
        WHERE
            mastersku = '$sku'
        ORDER BY unitbundle;
    ";
//    echo $bundlesQ . "<br><br>";
    $bundelsR = mysqli_query(conexion($tCountry), $bundlesQ);

    while ($bundelsRow = mysqli_fetch_array($bundelsR)){
        echo "<br><br>";
        $amazonSku = $bundelsRow["AMAZONSKU"];
        $unitBundle = $bundelsRow["UNITBUNDLE"];

//        echo "AMAZONSKU:$amazonSku - UNITBUNDLE:$unitBundle - QTY:$qty<br>";

        $bundleQuantity = floor($qty/$unitBundle);

//        echo "BUNDLEQUANTITY:$bundleQuantity<br>";

        $tTest = $walmart->updateInventoryQuantity($amazonSku, $bundleQuantity);

        echo "<br>NEW:<br>SKU:$amazonSku, Q:$bundleQuantity<br>";

        echo "<br><pre>$tTest</pre><br>";

        if (strpos($tTest, "CONTENT_NOT_FOUND") !== false) {
            echo "ERROR: SKU:$sku - AMAZONSKU:$amazonSku - UNITBUNDLE:$unitBundle - BUNDLEQUANTITY:$bundleQuantity<br>";
            $errors[] = "$sku,$amazonSku,$unitBundle,$bundleQuantity";
        }
        else{
            echo "SUCCESS: SKU:$sku - AMAZONSKU:$amazonSku - UNITBUNDLE:$unitBundle - BUNDLEQUANTITY:$bundleQuantity<br>";
            $updated[] = "$sku,$amazonSku,$unitBundle,$bundleQuantity";
        }
//        echo htmlentities($tTest) . "<br><br>";
    }
}
