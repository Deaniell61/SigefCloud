<?php
echo "paypal payments<br>";

//config
session_start();
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',     // ClientID
        'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL'      // ClientSecret
    )
);

//start
$balanceCode = getBalanceCode();
echo "BALANCE CODE:$balanceCode<br>";

$getCountriesQuery = "
    SELECT 
        dir.nomPais, dir.CODIGO
    FROM
        direct AS dir
            INNER JOIN
        cat_empresas AS emp ON dir.codPais = emp.pais
    WHERE
        emp.companyid != '0'
        AND emp.companyid != '163';
";

$getCountriesResult = mysqli_query(conexion(""), $getCountriesQuery);

//process countries
while ($getCountriesRow = mysqli_fetch_array($getCountriesResult)) {
    global $balanceCode;
    $tPais = $getCountriesRow[0];
    $provs = getProvs($tPais);
//    var_dump($provs);

    //get new
    $balancesQuery = "
        SELECT 
            *
        FROM
            tra_balances
        WHERE
            CODIGOBAL = '$balanceCode'
                AND SALDO > 0
                AND VALPAGO = 0
                AND isnull(VALID);
    ";
    $balancesResult = mysqli_query(conexion($tPais), $balancesQuery);

    $mailMessage = "Pagos a validar<br>";
    while ($balancesRow = mysqli_fetch_array($balancesResult)){
        $tCodigo = $balancesRow["CODBALCOM"];
        $tNombre = $provs[$balancesRow["CODPROV"]]["NOMBRE"];
        $tSaldo = $balancesRow["SALDO"];
        $mailMessage .= "CODIGO:$tCodigo, EMPRESA: $tNombre, SALDO:$tSaldo<br>";
    }
    //mail("solus.huargo@gmail.com","Validar pagos paypal",$mailMessage);
    sendMail($mailMessage);
    echo "$mailMessage<br>";

    //pay validated
    $balancesQuery = "
        SELECT 
            *
        FROM
            tra_balances
        WHERE
            CODIGOBAL = '$balanceCode'
                AND SALDO > 0
                AND VALPAGO = 1
                AND isnull(VALID);
    ";
    $balancesResult = mysqli_query(conexion($tPais), $balancesQuery);
    echo "pago a realizar<br>";
    while ($balancesRow = mysqli_fetch_array($balancesResult)){
        $tCodigo = $balancesRow["CODBALCOM"];
        $tNombre = $provs[$balancesRow["CODPROV"]]["NOMBRE"];
        $tMail = $provs[$balancesRow["CODPROV"]]["PAYPALMAIL"];
        $tSaldo = $balancesRow["SALDO"];
        $mailMessage = "CODIGO:$tCodigo, EMPRESA: $tNombre, MAIL:$tMail, SALDO:$tSaldo<br>";
        $tSys = sys2015();
        $query = "
            UPDATE tra_balances SET VALID = '$tSys' WHERE CODBALCOM = '$tCodigo'; 
        ";
        echo "$query<br>";
        //processPayPalPayment($tMail, $tSaldo);
//        mysqli_query(conexion($tPais), $query);
    }
}

function getProvs($mPais) {

    $provs = null;

    $provsQuery = "
        SELECT 
            CODPROV, NOMBRE, PAYPALMAIL, CODEMPRESA
        FROM
            cat_prov;
    ";

    $provsResult = mysqli_query(conexion($mPais), $provsQuery);

    while ($provsRow = mysqli_fetch_array($provsResult)) {
        $provs[$provsRow[0]] = [
            "NOMBRE" => $provsRow[1],
            "PAYPALMAIL" => $provsRow[2],
            "CODPROV" => $provsRow[0],
            "CODEMPRESA" => $provsRow[3]
        ];
    }

    return $provs;
}

function getBalanceCode() {

    $balanceCodeQuery = "
        SELECT 
            CODIGO
        FROM
            cat_bal_cobro
        WHERE
            ESTATUS = '1'
        ORDER BY TERMINA DESC
        LIMIT 1;
    ";

    $balanceCodeResult = mysqli_query(conexion(""), $balanceCodeQuery);
    $balanceCode = mysqli_fetch_array($balanceCodeResult)[0];

    return $balanceCode;
}

function processPayPalPayment($email, $amount) {

    global $apiContext;
    $payouts = new \PayPal\Api\Payout();
    $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();
    $senderBatchHeader->setSenderBatchId(uniqid())
        ->setEmailSubject("Tienes un pago de GuateDirect");
    $senderItem1 = new \PayPal\Api\PayoutItem();
    $senderItem1->setRecipientType('Email')
        ->setNote('Muchas gracias!')
        ->setReceiver($email)
        ->setSenderItemId("item_1" . uniqid())
        ->setAmount(new \PayPal\Api\Currency('{
                        "value":"' . $amount . '",
                        "currency":"USD"
                    }'));
    $payouts->setSenderBatchHeader($senderBatchHeader)
        ->addItem($senderItem1);

    try {
        $output = $payouts->create(null, $apiContext);
        echo "S:<br>$output";
    }
    catch (Exception $ex) {
        echo "E:<br>$ex";
    }
}

function sendMail($mMessage){
    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.phpmailer.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.smtp.php");
    $destino ="solus.huargo@gmail.com";
    $from="sigefcloud";

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "srv70.hosting24.com";
    $mail->Port = 465;
    $mail->Username = "support@sigefcloud.com";
    $mail->Password = "5upp0rt51g3fCl0ud";
    $mail->From = "support@sigefcloud.com";
    $mail->FromName = $from;
    $mail->Subject = "Validar pagos de PayPal";

    $mail->MsgHTML($mMessage);
    $mail->IsHTML(true);

    $mail->AddAddress($destino, $destino);
    $mail->addCC("solus.huargo@gmail.com");
//            echo "<br>enviando mail<br>$mensaje";
    $mail->Send();
}