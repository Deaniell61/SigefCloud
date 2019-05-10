<?php

session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$method = $_POST["method"];

switch ($method) {
    case "checkMasterSKU":
        $masterSKU = $_POST["masterSKU"];
        checkMasterSKU($masterSKU);
        break;
}

function checkMasterSKU($masterSKU){
    $query = "SELECT count(*) FROM cat_prod WHERE MASTERSKU = '$masterSKU';";
    $result = mysqli_query(conexion($_SESSION["pais"]), $query);
    echo mysqli_fetch_array($result)[0];
}