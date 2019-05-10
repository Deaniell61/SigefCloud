<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "getCargoValues":
            $amazonSKU = $_POST["amazonSKU"];
            echo getCargoValues($amazonSKU);
            break;
        case "getUtilidadValues":
            $amazonSKU = $_POST["amazonSKU"];
            echo getUtilidadValues($amazonSKU);
            break;
        default:
            echo "UNKNOWN METHOD";
            break;
    }
}
else{
    echo "NO METHOD";
}

function getCargoValues($amazonSKU){
    $query = "
        SELECT 
            FBAORDHANF,
            FBAPICPACF,
            FBAWEIHANF,
            FBAINBSHI,
            PACMAT,
            FBAREFOSSP
        FROM
            tra_bun_det
        WHERE
            amazonsku = '$amazonSKU';
    ";

    $result = mysqli_query(conexion($_SESSION["pais"]), $query);
    $row = mysqli_fetch_array($result);
    $FBAORDHANF = ($row["FBAORDHANF"] != 0.00000) ? "$" . number_format($row["FBAORDHANF"], 2, ".", "") : "-";
    $FBAPICPACF = ($row["FBAPICPACF"] != 0.00000) ? "$" . number_format($row["FBAPICPACF"], 2, ".", "") : "-";
    $FBAWEIHANF = ($row["FBAWEIHANF"] != 0.00000) ? "$" . number_format($row["FBAWEIHANF"], 2, ".", "") : "-";
    $FBAINBSHI = ($row["FBAINBSHI"] != 0.00000) ? "$" . number_format($row["FBAINBSHI"], 2, ".", "") : "-";
    $PACMAT = ($row["PACMAT"] != 0.00000) ? "$" . number_format($row["PACMAT"], 2, ".", "") : "-";
    $FBAREFOSSP = ($row["FBAREFOSSP"] != 0.00000) ? "$" . number_format($row["FBAREFOSSP"], 2, ".", "") : "-";

    $response = [
        "FBAORDHANF" => $FBAORDHANF,
        "FBAPICPACF" => $FBAPICPACF,
        "FBAWEIHANF" => $FBAWEIHANF,
        "FBAINBSHI" => $FBAINBSHI,
        "PACMAT" => $PACMAT,
        "FBAREFOSSP" => $FBAREFOSSP,
    ];

    return json_encode($response);
}

function getUtilidadValues($amazonSKU){
    $query = "
        SELECT 
            sugsalpric,
            subtotfbac,
            fbarefossp
        FROM
            tra_bun_det
        WHERE
            amazonsku = '$amazonSKU';
    ";

    $result = mysqli_query(conexion($_SESSION["pais"]), $query);
    $row = mysqli_fetch_array($result);
    $sugsalpric = ($row["sugsalpric"] != 0.00000) ? "$" . number_format($row["sugsalpric"], 2, ".", "") : "-";
    $subtotfbac = ($row["subtotfbac"] != 0.00000) ? "$" . number_format($row["subtotfbac"], 2, ".", "") : "-";
    $fbarefossp = ($row["fbarefossp"] != 0.00000) ? "$" . number_format($row["fbarefossp"], 2, ".", "") : "-";

    $response = [
        "sugsalpric" => $sugsalpric,
        "subtotfbac" => $subtotfbac,
        "fbarefossp" => $fbarefossp,
    ];

    return json_encode($response);
}