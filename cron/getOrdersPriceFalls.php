<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/cron/cronHelper.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/channels/sellercloud/sellercloud.php");

//download file
$url = "ftp.pricefalls.com";
$username = "pfguatedirect";
$password = "U9RHnmUe7h";
$connection = ftp_connect($url);
$login = ftp_login($connection, $username, $password);
$date = date("Ymd-His");
$file = "Pricefalls_Orders_$date.txt";
$localFile = dirname(__FILE__) . "/files/priceFallsOrders/$file";
$serverFile = "Orders\Pricefalls_Orders.txt";
$download = ftp_get($connection, $localFile, $serverFile, FTP_ASCII);
ftp_close($connection);
if (!$download) {
    mail("mauricio.aldana@guatedirect.com", "PriceFall Orders File Not Found", "PriceFall Orders Not Found");
    die("FILE NOT FOUND");
}

//get order data
$csv = array();
$loadedFile = fopen($localFile, 'r');
$lineCont = 0;
while (($result = fgetcsv($loadedFile)) !== false) {
    if ($lineCont > 0) {
        $line = explode("\t", $result[0]);
        $orderIds[] = $line[0];
        $orderInfo[$line[0]] = [
            "transactionTime" => $line[3],
            "shipByDate" => $line[22],
            "deliverByDate" => $line[23],
            "client" => $line[29] . " " . $line[30],
            "sku" => $line[9],
            "product" => $line[4],
            "quantity" => $line[12],
            "total" => $line[18],
        ];
    }
    $lineCont += 1;
}
fclose($loadedFile);

//get countries
$countries = getCountries();
$countries = json_decode($countries);

//step 1
foreach ($orderIds as $orderId) {
    echo "<br><br>ORDERS:";
    var_dump($orderIds);
    echo "<br>";
    echo "PROCESSING ORDER:$orderId<br>";

    //search order in each country
    foreach ($countries as $country) {
        echo "SEARCHING ORDER IN:$country<br>";
        $existsInOrdersQ = "
            SELECT 
                *
            FROM
                tra_ord_enc
            WHERE
                ORDSOUORDI = '$orderId';
        ";

        $existsInOrdersR = mysqli_query(conexion($country), $existsInOrdersQ);

        if ($existsInOrdersR->num_rows > 0) {
            echo "ORDER FOUND IN:$country<br>";
            updateQueue($orderId);

            $orderIds = array_diff($orderIds, array($orderId));
            break;
        } else {
            echo "ORDER NOT FOUND IN:$country<br>";
        }
    }
}

//step 2 and 3 orders not found in sigefcloud
foreach ($orderIds as $orderId) {
    echo "<br><br>PROCESSING NOT FOUND ORDER:$orderId<br>";

    $sellercloud = new \channels\sellercloud(false);
    $orderFull = $sellercloud->getOrderFromOrderSourceOrderId($orderId);

    //step 2 if found in sellercloud
    if (gettype($orderFull) == "object") {
        echo "ORDER EXISTS IN SELLERCLOUD:$orderId<br>";
        updateQueue($orderId);
    } //step 3 not found in sellercloud
    else {
        echo "ORDER DOES NOT EXISTS IN SELLERCLOUD:$orderId<br>";
        $existsInQueueQ = "
            SELECT 
                *
            FROM
                tra_ord_dwn_pending
            WHERE
                orderid = '$orderId';
        ";

        $existsInQueueR = mysqli_query(conexion(""), $existsInQueueQ);

        //add or update queue
        if ($existsInQueueR->num_rows > 0) {
            $existsInOrdersRow = mysqli_fetch_array($existsInQueueR);
            $tCodpendwn = $existsInOrdersRow["codpendwn"];
            $tChecks = intval($existsInOrdersRow["checks"]) + 1;
            echo "UPDATING QUEUE INFO<br>";
            $updateChecksQ = "
                UPDATE tra_ord_dwn_pending 
                SET 
                    checks = checks + 1
                WHERE
                    codpendwn = '$tCodpendwn';
            ";
            echo "$updateChecksQ<br>";
            mysqli_query(conexion(""), $updateChecksQ);

            sendMail($orderId, $orderInfo, $tChecks);
        } else {
            echo "ADDING ORDER TO QUEUE<br>";
            $tCodpendwn = sys2015();
            $tDate = date("Y-m-d H:i:s");
            $tDescarga = false;
            $tChecks = 1;
            $addInQueueQ = "
                INSERT INTO tra_ord_dwn_pending
                    (codpendwn,
                    orderid,
                    fecha,
                    descarga,
                    checks) 
                VALUES
                    ('$tCodpendwn',
                    '$orderId',
                    '$tDate',
                    '$tDescarga',
                    '$tChecks');            
            ";
            echo "$addInQueueQ<br>";
            mysqli_query(conexion(""), $addInQueueQ);
        }
    }
}

echo "END<br>";

function updateQueue($orderId)
{
    $existsInQueueQ = "
        SELECT 
            *
        FROM
            tra_ord_dwn_pending
        WHERE
            orderid = '$orderId';
    ";

    $existsInQueueR = mysqli_query(conexion(""), $existsInQueueQ);

    if ($existsInQueueR->num_rows > 0) {
        echo "ORDER $orderId IS QUEUED<br>";
        $tDescarga = true;
        $tFechadwn = date("Y-m-d H:i:s");
        $tMedio = "SigefCloud";
        $updateQueueQ = "
            UPDATE tra_ord_dwn_pending 
            SET 
                descarga = '$tDescarga',
                fechadwn = '$tFechadwn',
                medio = '$tMedio'
            WHERE
                orderid = '$orderId';
        ";

        mysqli_query(conexion(""), $updateQueueQ);
    } else {
        echo "ORDER IS NOT QUEUED YET<br>";
    }
}

function sendMail($orderId, $orderInfo, $tChecks)
{
    $tTransactionTime = trim($orderInfo[$orderId]['transactionTime'], '"');
    $tShipByDate = trim($orderInfo[$orderId]['shipByDate'], '"');
    $tDeliveryByDate = trim($orderInfo[$orderId]['deliverByDate'], '"');
    $tClient = $orderInfo[$orderId]['client'];
    $tSku = $orderInfo[$orderId]['sku'];
    $tProduct = trim($orderInfo[$orderId]['product'], '"');
    $tQuantity = $orderInfo[$orderId]['quantity'];
    $tTotal = $orderInfo[$orderId]['total'];

    //send mail
    $to = "customerservice@guatedirect.com,rosamaria.rangel@worldirect.com";
    $subject .= "PRICEFALLS - Orden no Descargada $orderId";
    $headers .= "Cc: paulo.armas@worldirect.com,franscisco.sandoval@worldirect.com,mauricio.aldana@guatedirect.com,soporte@sigefcloud.com\r\n";
    $headers .= "Bcc: andres.chang@sigefcloud.com\r\n";
    $headers .= "From: support@sigefcloud.com\r\n" .
        "X-Mailer: php";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = '<html><body>';
    $message .= "
Se han hecho la revision y esta orden aún no aparece en los sistemas.<br>
<br>
<b>REVISION:</b>  $tChecks<br>
<b>ORDEN:</b>     $orderId<br>
<b>FECHA:</b>     $tTransactionTime<br> 
<b>ENVIO:</b>     $tShipByDate<br>
<b>ENTREGA:</b>   $tDeliveryByDate<br>	
<b>CLIENTE:</b>   $tClient<br>
<b>MASTERSKU:</b> $tSku<br>
<b>PRODUCTO:</b>  $tProduct<br>
<b>CANTIDAD:</b>  $tQuantity<br>
<b>VALOR:</b>	   $tTotal<br>
<br>
SigefCloud Team
            ";

    echo "$message<br>";
    if (mail($to, $subject, $message, $headers)) {
        echo "EMAIL SENT<br>";
    } else {
        echo "EMAIL NOT SENT<br>";
    }
}
