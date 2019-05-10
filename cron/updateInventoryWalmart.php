<?php
//echo "update inventory walmart<br>";

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

$connectionPath = $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";
$walmartPath = $_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php";
$mailPath = $_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/PHPMailerAutoload.php";

include_once($connectionPath);
include_once($walmartPath);
include_once($mailPath);

$walmart = new walmart(false);

$productsQ = "
    SELECT 
        productid, physicalin
    FROM
        sageinventario
    WHERE
      productid = '506300250'
    ORDER BY inventoryD DESC
    LIMIT 5;
";

$productsR = mysqli_query(conexion("Guatemala"), $productsQ);

//echo $productsR->num_rows . "<br>";

$cont = 0;

while ($productsRow = mysqli_fetch_array($productsR)){

    /*
    $cont += 1;
    if($cont > 4){
        echo "$cont<br>";
        break;
    }
    */

    $sku = $productsRow["productid"];
    $quantity = $productsRow["physicalin"];

//    echo "SKU:$sku - QUANTITY:$quantity<br>";
    echo "SKU:$sku - QUANTITY:$quantity<br><br><br>";

    $skuPrefix = substr($sku, 0, 3);

//    echo "PREFIX:$skuPrefix<br>";

    $tCountry = ($skuPrefix == "506") ? "Costa Rica" : "Guatemala";

    $bundlesQ = "
        SELECT
            AMAZONSKU, UNITBUNDLE
        FROM
            tra_bun_det
        WHERE
            mastersku = '$sku'
        ORDER BY unitbundle;
    ";

//    echo "$bundlesQ<br>";

    $bundelsR = mysqli_query(conexion($tCountry), $bundlesQ);

    echo "";
    while ($bundelsRow = mysqli_fetch_array($bundelsR)){
        echo "<br><br>";
        $amazonSku = $bundelsRow["AMAZONSKU"];
        $unitBundle = $bundelsRow["UNITBUNDLE"];

        echo "AMAZONSKU:$amazonSku - UNITBUNDLE:$unitBundle<br>";

        $bundleQuantity = floor(($quantity/$unitBundle));

        echo "BUNDLEQUANTITY:$bundleQuantity<br>";

        $tTest = $walmart->updateInventoryQuantity($amazonSku, $bundleQuantity);

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

$date = date("Ymd");

if(!empty($errors)){
    $path = dirname(__FILE__) . "/walmartInventoryCSV/updateInventoryWalmart-Errors-$date.csv";
    $file = fopen($path,"w");
    fputcsv($file,explode(',',"SKU,AMAZONSKU,UNITBUNDLE,BUNDLEQUANTITY"));
    foreach ($errors as $line){
        fputcsv($file,explode(',',$line));
    }
    fclose($file);

    $recipient = "romalch@gmail.com";
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
//        echo $e->errorMessage();
    }
}

if(!empty($updated)){
    $path = dirname(__FILE__) . "/walmartInventoryCSV/updateInventoryWalmart-Updated-$date.csv";
    $file = fopen($path,"w");
    fputcsv($file,explode(',',"SKU,AMAZONSKU,UNITBUNDLE,BUNDLEQUANTITY"));
    foreach ($updated as $line){
        fputcsv($file,explode(',',$line));
    }
    fclose($file);

    $recipient = "romalch@gmail.com";
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
//        echo $e->errorMessage();
    }
}

