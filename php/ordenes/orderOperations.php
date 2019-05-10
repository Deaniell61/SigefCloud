<?php

session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

if (isset($_POST["method"])) {
    $method = $_POST["method"];

    switch ($method) {
        case "getUser":
            $username = $_POST["username"];
            getUser($username);
            break;
        case "saveUser":
            $username = $_POST["username"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            saveUser($username, $firstname, $lastname);
            break;
        case "orderToSellercloud":
            include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
            $sellercloud = new sellercloud();
            time_nanosleep(1, 250000000);
//            echo $_SESSION["CODORDEN"]." - ".$_SESSION["CODBODEGA"]."<br>";
            $r = $sellercloud->createNewOrder();
            echo json_encode($r);
            break;

        case "updateOrderId":
            $old = $_POST["oldOI"];
            $new = $_POST["newOI"];
            echo updateOrderId($old, $new);
            break;

        case "getProvsDrop":
            $country = $_POST["country"];
            $_SESSION["lastFactCountry"] = $country;
            echo getProvsDrop($country);
            break;
    }
}

function getUser($username) {
    $query = "SELECT count(*) FROM cat_customer WHERE EMAIL = '$username';";
    $result = mysqli_query(conexion($_SESSION["pais"]), $query);
    $row = mysqli_fetch_array($result);
    echo $row[0];
}

function saveUser($username, $firstname, $lastname){
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
    $id = sys2015();
    $query = "INSERT INTO cat_customer (CODCUSTO, EMAIL, FNAME, LNAME) value ('$id', '$username', '$firstname', '$lastname');";
    mysqli_query(conexion($_SESSION["pais"]), $query);
}

function updateOrderId($old, $new){
    $query = "UPDATE tra_ord_enc SET ORDERID = '$new' WHERE ORDERID = '$old'";
    mysqli_query(conexion($_SESSION["pais"]), $query);
    return $query;
}

function getProvsDrop($country){
    $query = "
        SELECT 
            codprov, nombre
        FROM
            cat_prov order by nombre;
    ";

    $r = mysqli_query(conexion($country), $query);

    while ($row = mysqli_fetch_array($r)){
        $value = $row["codprov"];
        $name = limpiar_caracteres_sql($row["nombre"]);
        $data .= "<option value='$value'>$name</option>";
    }

    $response = "<select id='prov' class='entradaTexto' style='width: 100%'>$data</select>";

    return $response;
}