<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/php/formulas/formulas.php";
$formulas = new formulas();

if(isset($_POST["method"])){
    $method = $_POST["method"];

    switch ($method){
        case "unitsPerCase":
            $tMasterSKU = $_POST["masterSKU"];
            $tCountry = $_POST["country"];
            echo $formulas->unitsPerCase($tMasterSKU, $tCountry);
            break;
        case "bundleUnits":
            $tMasterSKU = $_POST["masterSKU"];
            $tCountry = $_POST["country"];
            echo json_encode($formulas->bundleUnits($tMasterSKU, $tCountry));
            break;
        case "cospri":
            $tMasterSKU = $_POST["masterSKU"];
            $tBundleUnits = $_POST["bundleUnits"];
            $tCountry = $_POST["country"];
            echo $formulas->cospri($tMasterSKU, $tBundleUnits, $tCountry);
            break;
        case "fbaordhanf":
            $tChannel = $_POST["channel"];
            $tCountry = $_POST["country"];
            echo $formulas->fbaordhanf($tChannel, $tCountry);
            break;
        case "fbapicpacf":
            $tChannel = $_POST["channel"];
            $tCountry = $_POST["country"];
            echo $formulas->fbapicpacf($tChannel, $tCountry);
            break;
        case "fbaweihanf":
            $tMasterSKU = $_POST["masterSKU"];
            $tUnits = $_POST["units"];
            $tChannel = $_POST["channel"];
            $tCountry = $_POST["country"];
            echo $formulas->fbaweihanf($tMasterSKU, $tUnits, $tChannel, $tCountry);
            break;
        case "fbainbshi":
            $tMasterSKU = $_POST["masterSKU"];
            $tUnits = $_POST["units"];
            $tCountry = $_POST["country"];
            echo $formulas->fbainbshi($tMasterSKU, $tUnits, $tCountry);
            break;
        case "pacMat":
            $tChannel = $_POST["channel"];
            $tCountry = $_POST["country"];
            echo $formulas->pacMat($tChannel, $tCountry);
            break;
        case "shipping":
            $tMasterSKU = $_POST["masterSKU"];
            $tCountry = $_POST["country"];
            $tUnits = $_POST["units"];
            echo $formulas->shipping($tMasterSKU, $tCountry, $tUnits);
            break;
        case "minPrice":
            $tMasterSKU = $_POST["masterSKU"];
            $tCountry = $_POST["country"];
            $tUnits = $_POST["units"];
            echo $formulas->minPrice($tMasterSKU, $tCountry, $tUnits);
            break;

        default:
            echo "UNKNOWN METHOD";
            break;
    }
}
else{
    echo "NO METHOD SET";
}