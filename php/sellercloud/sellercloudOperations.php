<?php

include_once ($_SERVER["DOCUMENT_ROOT"] .  "/php/sellercloud/sellercloud.php");
$sellercloud = new sellercloud();

if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "getUser":
            $username = $_POST["username"];
            echo $username;
            getUser($username);
            break;
        case "saveUser":
            $username = $_POST["username"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            saveUser($username, $firstname, $lastname);
            break;
        default:
            break;
    }
}

function getUser($username){
    global $sellercloud;
    echo json_encode($sellercloud->getUser($username));
}

function saveUser($username, $firstname, $lastname){
    global $sellercloud;
    echo $sellercloud->saveUser($username, $firstname, $lastname);
}