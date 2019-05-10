<?php

session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$searchTerm = $_GET["term"];
$codProv = $_SESSION["codprov"];

$query = "
    SELECT MASTERSKU, PRODNAME FROM cat_prod WHERE MASTERSKU LIKE '%$searchTerm%' OR PRODNAME LIKE '%$searchTerm%' AND CODPROV = '$codProv';
";

$result = mysqli_query(conexion($_SESSION["pais"]), $query);

while ($row = mysqli_fetch_array($result)) {
    $data[] = $row['MASTERSKU'] . " - " . $row["PRODNAME"];
}

echo json_encode($data);