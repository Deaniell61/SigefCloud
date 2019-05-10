<?php

if(isset($_POST["method"])){
    $method = $_POST["method"];

    switch ($method){
        case "insertKit":
            echo '';
            break;

        default:
            echo "invalid method";
            break;
    }
}

else{
    echo "no mehtod";
}

function insertKit(){

}