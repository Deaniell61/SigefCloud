<?php
/**
 * Webhook for Time Bot- Facebook Messenger Bot
 */

$hub_verify_token = null;
include 'config.php';
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";

if (isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
if ($hub_verify_token === $verify_token) {
    echo $challenge;
}
$input = json_decode(file_get_contents('php://input'), true);
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$message_to_reply = '';
/**
 * Some Basic rules to validate incoming messages
 */
if (preg_match('[time|current time|now|время|час]', strtolower($message))) {
    $time = getdate();
    $hours = $time['hours'];
    if ($time['minutes'] < 10) {
        $minutes = "0" . $time['minutes'];
    } else {
        $minutes = $time['minutes'];
    }
    $response = $hours . ":" . $minutes;
    if ($response != '') {
        $message_to_reply = $response;
    } else {
        $message_to_reply = "Sorry, I don't know.";
    }
//    sendResponse($sender, $message_to_reply);
    //API Url
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
//Initiate cURL.
    $ch = curl_init($url);
//The JSON data.
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
    },
    "message":{
        "text":"' . $message_to_reply . '"
    }
}';
//Encode the array into JSON.
    $jsonDataEncoded = $jsonData;
//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
//Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//Execute the request
    if (!empty($input['entry'][0]['messaging'][0]['message'])) {
        $result = curl_exec($ch);
    }
} else if (preg_match('[tienen]', strtolower($message))) {
    $prod = explode("tienen ", $message)[1];
    $q = "
        SELECT 
            PRODNAME
        FROM
            cat_prod
        WHERE
            PRODNAME LIKE '%$prod%'
        LIMIT 5;
    ";

    $r = mysqli_query(conexion("Guatemala"), $q);

    if ($r->num_rows > 0) {
//        sendResponse($sender, "encontramos estos productos:");
    }

    $message_to_reply = "encontramos estos productos: ";
    //API Url
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
    //Initiate cURL.
    $ch = curl_init($url);
    //The JSON data.
    $jsonData = '{
            "recipient":{
                "id":"' . $sender . '"
            },
            "message":{
                "text":"' . $message_to_reply . '"
            }
        }';
    //Encode the array into JSON.
    $jsonDataEncoded = $jsonData;
    //Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    //Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    //Execute the request
    if (!empty($input['entry'][0]['messaging'][0]['message'])) {
        $result = curl_exec($ch);
    }
    while ($row = mysqli_fetch_array($r)) {
        $message_to_reply = $row["PRODNAME"];
//        sendResponse($sender, $tProd);

        //API Url
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
        //Initiate cURL.
        $ch = curl_init($url);
        //The JSON data.
        $jsonData = '{
            "recipient":{
                "id":"' . $sender . '"
            },
            "message":{
                "text":"' . $message_to_reply . '"
            }
        }';
        //Encode the array into JSON.
        $jsonDataEncoded = $jsonData;
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        //Execute the request
        if (!empty($input['entry'][0]['messaging'][0]['message'])) {
            $result = curl_exec($ch);
        }
    }
}else if (preg_match('[gracias]', strtolower($message))) {
    $message_to_reply = "de nada!";
//        sendResponse($sender, $tProd);

    //API Url
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
    //Initiate cURL.
    $ch = curl_init($url);
    //The JSON data.
    $jsonData = '{
            "recipient":{
                "id":"' . $sender . '"
            },
            "message":{
                "text":"' . $message_to_reply . '"
            }
        }';
    //Encode the array into JSON.
    $jsonDataEncoded = $jsonData;
    //Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    //Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    //Execute the request
    if (!empty($input['entry'][0]['messaging'][0]['message'])) {
        $result = curl_exec($ch);
    }

}else if (preg_match('[hola]', strtolower($message))) {
    $message_to_reply = "hola, en que podemos ayudarte?";
//        sendResponse($sender, $tProd);

    //API Url
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
    //Initiate cURL.
    $ch = curl_init($url);
    //The JSON data.
    $jsonData = '{
            "recipient":{
                "id":"' . $sender . '"
            },
            "message":{
                "text":"' . $message_to_reply . '"
            }
        }';
    //Encode the array into JSON.
    $jsonDataEncoded = $jsonData;
    //Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    //Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    //Execute the request
    if (!empty($input['entry'][0]['messaging'][0]['message'])) {
        $result = curl_exec($ch);
    }

} else {
//    $message_to_reply = 'Sorry, I don\'t understand you. I can only tell what time it is now.';
}


