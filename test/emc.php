<?php

echo encondedPass("9DC9*()/");

function encondedPass($pass){
    $response = "";
    $pass = str_split($pass);
    foreach ($pass as $char){
        $encodedChar = chr(ord($char) + 8);
        $response .= $encodedChar;
    }
    return $response;
}