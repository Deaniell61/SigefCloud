<?php
session_start();
if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "sendMails":
            $skuList = "'" . substr($_POST["skuList"], 0, -2);
            echo sendMails($skuList);
            break;
    }
}


function sendMails($skuList){
    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    $query = "
        SELECT 
            prod.prodname, prod.pventa
        FROM
            cat_prod AS prod
                INNER JOIN
            tra_bun_det AS bun ON prod.mastersku = bun.mastersku
        WHERE
            bun.amazonsku IN ($skuList)
        ORDER BY FIELD(bun.amazonsku, $skuList);
    ";

    $result = mysqli_query(conexion($_SESSION["pais"]), $query);

    $productsGrid;

    while($row = mysqli_fetch_array($result)){
        $prodname = $row["prodname"];
        $pventa = number_format($row["pventa"], 2);
        $link = generateLink($prodname);
        $productsGrid .= "
            <div>
                <b>$prodname</b><br>
                Price: $$pventa<br>
                <a href='$link'>Learn more</a>
            </div>
        ";
    }

    $mensaje = "$productsGrid";

    send("TEST", $mensaje);

    return "sm:" . $query;
}

function send($asunto, $mensaje){
    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.phpmailer.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.smtp.php");

    $from="SigefCloud Team Support <support@sigefcloud.com>";

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
    $mail->Subject = $asunto;
    $mail->AltBody = $asunto;
    $mail->MsgHTML($mensaje);

    $mail->IsHTML(true);
    $direcciones[0]="solus.huargo@gmail.com";

    $mail->IsHTML(true);

    foreach($direcciones as $destinoT){
        $mail->AddAddress($destinoT, $destinoT);
        $mail->send();
        $mail->ClearAddresses();
    }
}

function generateLink($prodname){

    $response = strtolower($prodname);
    $response = str_replace("/", "-", $response);
    $response = str_replace("&", "-", $response);
    $response = str_replace(".", "-", $response);
    $response = str_replace(" ", "-", $response);
    $response = preg_replace('/([-])\1+/', '$1', $response);

    $response = "http://www.guatedirect.com/" . $response . ".html";

    echo $response;
    return $response;
}