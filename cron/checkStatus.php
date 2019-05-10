<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/PHPMailerAutoload.php");

$urls = [
    "https://sigefcloud.com",
    "https://desarrollo.sigefcloud.com",
    "https://www.guatedirect.com",
    "http://mayaland.us",
    "www.worldirect.com"
];

foreach ($urls as $url) {
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the HTML or whatever is linked in $url. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    echo "$url<br>$httpCode<br>";
    /*
    if($httpCode == 404) {

    }
    */

    curl_close($handle);

    if(!$response){
        $flag = true;
        $message .= "$url - CODE:$code<br>";
    }else{
        $messageLive .= "$url - LIVE\r\n";
    }
}

if($flag == true){
    sendMail("WEBSITE DOWN", $message);
    echo "<br>$message<br>";
}else{
    echo "ALL SITES LIVE " . date("H");
    if(date("H") == "00"){
//        sendMail("ALL WEBSITES LIVE", $messageLive);
    }
}

function sendMail($subject, $message)
{
    $recipient = "solus.huargo@gmail.com";
    $cc = "romalch@gmail.com";
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
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    }catch (phpmailerException $e){
        echo $e->errorMessage();
    }
}

/*
$headers = get_headers($url);

    if(!$headers){
        $flag = true;
        $message .= "$url<br>";
    }
    $code = $headers[0];

    $code = explode(" ", $headers[0])[1];
    echo "<br>H:$url<br>";
//    echo "$url - $code";
    var_dump($headers);
    echo "<br><br>";
    $response = ($code === 200) ? true : false;

    echo "$url - $response<br>";

    $flag = false;
 * */
