<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sesiones.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
if (isset($_GET["method"])) {
    $method = $_GET["method"];
    switch ($method) {
        case "login":
            $user = $_GET["user"];
            $pass = $_GET["pass"];
            $response = loginRSIGEF($user, $pass);
            echo json_encode($response);
            break;

        case "getEmpresas":
            $userCode = $_GET["userCode"];
            echo getEmpresas($userCode);
            break;

        case "getEmbarques":
            $prefix = $_GET["prefix"];
            echo getEmbarques($prefix);
            break;

        case "getProducts":
            $prefix = $_GET["prefix"];
            $code = $_GET["code"];
            echo getProducts($prefix, $code);
            break;

        case "store":
            $prefix = $_GET["prefix"];
            $code = $_GET["code"];
            $codeDetail = $_GET["codeDetail"];
            $product = $_GET["product"];
            $date = $_GET["date"];
            $pallet = $_GET["pallet"];
            $quantity = $_GET["quantity"];
            echo store($prefix, $code, $codeDetail, $product, $date, $pallet, $quantity);
            break;

        case "getProductsByPallet":
            $prefix = $_GET["prefix"];
            $code = $_GET["code"];
            $pallet = $_GET["pallet"];
            echo getProductsByPallet($prefix, $code, $pallet);
            break;

        case "getPalletsByProduct":
            $prefix = $_GET["prefix"];
            $code = $_GET["code"];
            $product = $_GET["product"];
            echo getPalletsByProduct($prefix, $code, $product);
            break;
    }
} else {
    $response = [
        "status" => "error",
        "message" => "no method called",
    ];
    echo json_encode($response);
}

function getEmpresas($userCode) {
    $query = "SELECT emp.CODIGO, emp.NOMBRE FROM acempresas AS ac INNER JOIN cat_empresas AS emp ON ac.CODEMPRESA = emp.CODEMPRESA WHERE ac.CODUSUA = '$userCode';";
    $result = mysqli_query(rconexion(), $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = [
        "status" => "success",
        "data" => $data,
    ];
    return json_encode($response);
}

function getEmbarques($prefix) {
    $query = "SELECT CODPEDIDO, NOMPROY FROM tra_ped_enc WHERE ESTATUS = 'PROCESO' ORDER BY NOMPROY DESC;";
    $result = mysqli_query(rconexionLocal($prefix), $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "CODPEDIDO" => $row["CODPEDIDO"],
            "NOMPROY" => utf8_encode($row["NOMPROY"])
        ];
    }
    $response = [
        "stauts" => "success",
        "data" => $data,
    ];
    echo (error_get_last());
    return json_encode($response);
}

function getProducts($prefix, $code) {
    $query = "SELECT  NOMBRE, PRESENTA, CODPROD, CODPDET FROM tra_ped_det WHERE CODPEDIDO = '$code' AND SURTIDO = '1.00000' ORDER BY NOMBRE;";
    $result = mysqli_query(rconexionLocal($prefix), $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "NOMBRE" => utf8_encode($row["NOMBRE"]) . " - " . $row["PRESENTA"],
            "CODPROD" => $row["CODPROD"],
            "CODPDET" => $row["CODPDET"]
        ];
    }
    $response = [
        "status" => "success",
        "data" => $data,
    ];
    return json_encode($response);
}

function store($prefix, $code, $codeDetail, $product, $date, $pallet, $quantity) {

    $status = "success";
    $message = "success";

    $checkExistsQuery = "SELECT codexpira, lote FROM tra_lot_exp WHERE codpedido = '$code' AND coddpedido = '$codeDetail' AND codprod = '$product' AND fechaexp = '$date 00:00:00';";
    $checkExistsResult = mysqli_query(rconexionLocal($prefix), $checkExistsQuery);

    //cantidad disponible
    $getQuantityQuery = "SELECT CANTIDAD FROM tra_ped_det WHERE CODPDET = '$codeDetail';";
    $getQuantityResult = mysqli_query(rconexionLocal($prefix), $getQuantityQuery);
    $totalQuantity = mysqli_fetch_array($getQuantityResult)[0];
    $totalQuantity = explode(".", $totalQuantity)[0];

    if ($checkExistsResult->num_rows > 0) {
        $row = mysqli_fetch_array($checkExistsResult);
        $lote = $row[1];

        $lotesQuery = "SELECT codexpira, lote FROM tra_lot_exp WHERE codpedido = '$code' AND coddpedido = '$codeDetail' AND codprod = '$product';";
        $lotesResult = mysqli_query(rconexionLocal($prefix), $lotesQuery);
        $loteQuantity = 0;
        while($loteRow = mysqli_fetch_array($lotesResult)){
            $lotes = $loteRow[1];
            $loteQuantityString = substr($lotes, 1, -1);
            $loteQuantityData = explode("][", $loteQuantityString);

            foreach ($loteQuantityData as $item) {
                $item = explode(":", $item)[1];
                $loteQuantity += $item;
            }
        }

        $availableQuantity = $totalQuantity - explode(".", $loteQuantity)[0];
//        echo "disponible:" . $availableQuantity . " total:" . $totalQuantity . " solicitada" . $quantity . "<br>";

        $lote = substr($lote, 1, -1);
        $loteData = explode("][", $lote);
        $newLote = "";
        $add = 1;

        if($lote != ''){
            foreach ($loteData as $item) {
                $lotePallet = explode(":", $item)[0];
                $loteQuantity = explode(":", $item)[1];
                if ($lotePallet == $pallet) {
                    if ($quantity != 0) {
                        $tAvailableQuantity = $availableQuantity + $loteQuantity;
                        if ($quantity > $tAvailableQuantity) {
                            $status = "error";
                            $message = "cantidad invalida";
                        } else {
                            $add = 0;
                        }
                        $newLote .= "[$pallet:$quantity]";
                    }
                    else{
                        $add = 0;
                    }
                } else {
                    $newLote .= "[$item]";
                }
            }
        }
        else{
            if ($quantity != 0) {
                $tAvailableQuantity = $availableQuantity + $loteQuantity;
                if ($quantity > $tAvailableQuantity) {
                    $status = "error";
                    $message = "cantidad invalida";
                } else {
                    $add = 0;
                }
                $newLote .= "[$pallet:$quantity]";
            }
        }

        if ($add == 1) {
            if ($quantity > $availableQuantity || $quantity == 0) {
                $status = "error";
                $message = "cantidad invalida";
            } else {
                $newLote .= "[$pallet:$quantity]";
            }
        }
        $codExpira = $row[0];
        $query = "UPDATE tra_lot_exp SET lote = '$newLote' WHERE codexpira = '$codExpira';";
        if ($status != "error" && $codExpira != "") {
            mysqli_query(rconexionLocal($prefix), $query);
        }

    } else {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        $sys = sys2015();
        if ($quantity > $totalQuantity || $quantity == 0) {
            $status = "error";
            $message = "cantidad invalida";
        } else {
            $query = "INSERT INTO tra_lot_exp (codexpira, codpedido, coddpedido, codprod, lote, fechaexp) VALUES ('$sys', '$code', '$codeDetail', '$product', '[$pallet:$quantity]', '$date');";
            mysqli_query(rconexionLocal($prefix), $query);
        }
    }

    if($status == "success"){
        $query = "UPDATE tra_ped_det SET CANTIDAS = '1' WHERE CODPDET = '$codeDetail'";
        mysqli_query(rconexionLocal($prefix), $query);
    }

    $response = [
        "status" => $status,
        "message" => $message,
    ];
    return json_encode($response);
}

function getProductsByPallet($prefix, $code, $pallet) {
    $query = "SELECT det.NOMBRE, det.PRESENTA, lot.fechaexp, lot.lote FROM tra_lot_exp AS lot INNER JOIN tra_ped_det AS det ON lot.coddpedido = det.CODPDET WHERE lot.codpedido = '$code' AND lot.lote LIKE '[%';";
    $result = mysqli_query(rconexionLocal($prefix), $query);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $lotes = $row["lote"];
        $loteString = substr($lotes, 1, -1);
        $loteData = explode("][", $loteString);
        foreach ($loteData as $item) {
            $rowPallet = explode(":", $item)[0];
            $quantity = explode(":", $item)[1];
            if($rowPallet == $pallet){
                $data[] = [
                    "NAME" => utf8_encode($row["NOMBRE"]) . " - " . $row["PRESENTA"],
                    "DATE" => explode(" ", $row["fechaexp"])[0],
                    "QUANTITY" => $quantity
                ];
            }
        }
    }

    $response = [
        "stauts" => "success",
        "data" => $data,
    ];
    return json_encode($response);
}

function getPalletsByProduct($prefix, $code, $product) {
    $query = "SELECT lote, fechaexp FROM tra_lot_exp WHERE codpedido = '$code' AND codprod = '$product' AND lote LIKE '[%';";
    $result = mysqli_query(rconexionLocal($prefix), $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $lotes = $row["lote"];
        $loteString = substr($lotes, 1, -1);
        $loteData = explode("][", $loteString);

        foreach ($loteData as $item) {
            $pallet = explode(":", $item)[0];
            $quantity = explode(":", $item)[1];
            $data[] = [
                "PALLET" => $pallet,
                "DATE" => explode(" ", $row["fechaexp"])[0],
                "QUANTITY" => $quantity
            ];
        }
    }

    $response = [
        "stauts" => "success",
        "data" => $data,
    ];
    return json_encode($response);
}
