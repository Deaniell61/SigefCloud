<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/fpdf181/fpdf.php");

if (isset($_GET["method"])) {
    $method = $_GET["method"];
    switch ($method) {
        case "getPDF":
            $DOCID = $_GET["DOCID"];
            echo getPDF($DOCID);
            break;
    }
}

function getPDF($balanceId) {

    $_SESSION["currentBalance"] = $balanceId;

    class PDF extends FPDF {

        function Header() {

            session_start();
            $tBalance = $_SESSION["currentBalance"];
            $balancesQuery = "
                SELECT 
                    codbalance, inicia, termina, estatus
                FROM
                    cat_bal_cobro
                WHERE CODBALANCE = $tBalance;
            ";

            $balancesResult = mysqli_query(conexion(""), $balancesQuery);
            $balancesRow = mysqli_fetch_array($balancesResult);
            $tIni = date_format(date_create(explode(" ", $balancesRow["inicia"])[0]), "M d, Y");
            $tFin = date_format(date_create(explode(" ", $balancesRow["termina"])[0]), "M d, Y");
            $tEstatus = ($balancesRow["estatus"] == 1) ? "" : "(Abierto)";
            $balance = "$tIni - $tFin $tEstatus";

            $width = "40";
            $height = "5";
            $font = "Arial";
            $newLine = $height;

            //LOGO
            $this->SetFont($font, "B", 18);
            $this->Cell($width, $height, $_SESSION["nomEmpresa"]);
            $this->Ln($newLine);
            $this->SetFont($font, "", 10);
            $this->Cell($width, $height, "Detalle de Transacciones del Balance de Liquidacion");
            $this->Image("../../images/paises/" . $_SESSION["pais"] . ".png", 210, 12, 75);
            $this->Ln($newLine);
            $this->Cell($width, $height, "Balance: " . $balance);
            $this->Ln($newLine);
            $this->Cell($width, $height, "Empresa: " . $_SESSION["nomProv"]);
            $this->Ln($newLine);
            $this->Cell($width, $height, "Fecha: " . date("M/d/Y"));
            $this->Ln($newLine * 2);
        }

        function Footer() {

            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Page number
            $this->Cell(0, 10, utf8_decode('Página: ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
        }
    }

    $b1Total = "";
    $b2Total = "";

    $frame = "1";
    $width = "40";
    $extraWidth = "20";
    $widthSmall = "25";
    $widthLarge = "110";
    $height = "5";
    $font = "Arial";
    $size = "10";
    $newLine = $height;
    $encMult = 2;

    $cO1 = 20;
    $cO2 = 29;
    $cO3 = 20;
    $cO4 = 14;
    $cO5 = 20;
    $cO6 = 17;
    $cO7 = 33;
    $cO8 = 13;
    $cO9 = 33;
    $cO10 = 39;
    $cO11 = 22;

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage("L");
//    $pdf->Ln("10");
    //LOGO
//    $pdf->SetFont($font, "B", 18);
//    $pdf->Cell($width, $height, $_SESSION["nomEmpresa"]);
//    $pdf->Ln($newLine);
//    $pdf->SetFont($font, "", 10);
//    $pdf->Cell($width, $height, "Detalle de Transacciones del Balance de Liquidacion");
//    $pdf->Image("../../images/paises/" . $_SESSION["pais"] . ".png", 210, 15, 75);
//    $pdf->Ln($newLine * 2);
//    $pdf->Cell($width, $height, "Balance: ");
//    $pdf->Ln($newLine);
//    $pdf->Cell($width, $height, "Empresa: " . $_SESSION["nomProv"]);
//    $pdf->Ln($newLine);
//    $pdf->Cell($width, $height, "Fecha: " . date("M/d/Y"));
//    $pdf->Ln($newLine);

    //ORDENES
    $pdf->Ln($newLine * 2);
    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Ordenes");

    $pdf->Ln($newLine);
    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->SetFont($font, "B", 11);
    $pdf->Cell($cO1, $height, "ID Orden");
    $pdf->Cell($cO2, $height, "Canal de Venta");
    $pdf->Cell($cO3, $height, "Fecha");
    $pdf->Cell($cO4, $height, "Estado");
    $pdf->Cell($cO5, $height, "Unidades");
    $pdf->Cell($cO6, $height, "Subtotal");
    $pdf->Cell($cO7, $height, "Shipping y Otros");
    $pdf->Cell($cO8, $height, "Total");
    $pdf->Cell($cO9, $height, "Cargos de Canal");
    $pdf->Cell($cO10, $height, "Cargos de Shipping");
    $pdf->Cell($cO11, $height, "Neto Orden");
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);

    $codProv = $_SESSION["codprov"];
    $oQuery = "
        SELECT 
            *
        FROM
            tra_ord_enc AS enc 
        INNER JOIN 
            tra_ord_det AS det 
        ON enc.CODORDEN = det.CODORDEN
        WHERE
            CODBALCOM IN (SELECT 
                    CODBALCOM
                FROM
                    tra_balances
                WHERE
                    CODBALANCE = '$balanceId'
                        AND CODPROV = '$codProv')
        GROUP BY ORDERID;
    ";
//    echo $oQuery . "<br>";
    $oResult = mysqli_query(conexion($_SESSION["pais"]), $oQuery);
    $tBody = "";
    $ttUnidades = 0;
    $ttSubtotal = 0;
    $ttShipping = 0;
    $ttTotal = 0;
    $ttCargosCanal = 0;
    $ttCargosShipping = 0;
    $ttNeto = 0;
    while ($oRow = mysqli_fetch_array($oResult)) {

        $tCF = 0;
        $tSH = 0;
        $tCodOrden = $oRow["CODORDEN"];
        $tCargosQuery = "
            SELECT 
                CODCARGO, VALOR
            FROM
                tra_bit_cobro
            WHERE
                CODDOCTO = '$tCodOrden'; 
        ";
        $tCargosResult = mysqli_query(conexion($_SESSION["pais"]), $tCargosQuery);
        while ($tCargosRow = mysqli_fetch_array($tCargosResult)) {
            $tCodCargo = $tCargosRow["CODCARGO"];
            $tCargoQuery = "
                SELECT 
                    UBICACION
                FROM
                    cat_car_proyecto
                WHERE
                    CODCARGO = '$tCodCargo';
            ";
//            echo $tCargoQuery."<br>";
            $tCargoResult = mysqli_query(conexion(""), $tCargoQuery);
            if ($tCargoResult->num_rows > 0) {
                while ($tCargoRow = mysqli_fetch_array($tCargoResult)) {
                    $tCargo = $tCargoRow["UBICACION"];
//                    echo "$tCargo : <br>";
                    switch ($tCargo) {
                        case "CF":
                            $tCF += $tCargosRow["VALOR"];
                            break;

                        case "SH":
                            $tSH += $tCargosRow["VALOR"];
                            break;
                    }
                }
            }
        }

        $tOrdenId = $oRow["ORDERID"];
        $tCanalVenta = $oRow["ORDSOU"];
        $tDate = explode(" ", $oRow["TIMOFORD"])[0];
        $tDate = explode("-", $tDate)[2] . "/" . explode("-", $tDate)[1] . "/" . explode("-", $tDate)[0];
        $tFecha = $tDate;
        $tEstado = $oRow["SHIPSTATE"];
        $tUnidades = $oRow["ORDERUNITS"];
        $ttUnidades += $tUnidades;
        $tSubtotal = number_format($oRow["TLINETOTAL"], 2);
        $ttSubtotal += $tSubtotal;
        $ttSubtotal = number_format($ttSubtotal, 2);
        $tShipping = number_format($oRow["SHITOT"] + $oRow["GIFTWRAP"], 2);
        $ttShipping += $tShipping;
        $ttShipping = number_format($ttShipping, 2);
        $tTotal = number_format($oRow["GRANDTOTAL"], 2);
        $ttTotal += $tTotal;
        $ttTotal = number_format($ttTotal, 2);
        $tCargosCanal = "-" . number_format($tCF, 2);
        $ttCargosCanal += $tCargosCanal;
        $ttCargosCanal = number_format($ttCargosCanal, 2);
        $tCargosShipping = "-" . number_format($tSH, 2);
        $ttCargosShipping += $tCargosShipping;
        $ttCargosShipping = number_format($ttCargosShipping, 2);
        $tNeto = number_format($oRow["GRANDTOTAL"] - $tCF - $tSH, 2);
        $ttNeto += $tNeto;
        $ttNeto = number_format($ttNeto, 2);
        $pdf->Ln($newLine);
        $pdf->SetFont($font, "", 10);
        $pdf->Cell($cO1, $height, $tOrdenId, 0, 0, "R");
        $pdf->Cell($cO2, $height, $tCanalVenta);
        $pdf->Cell($cO3, $height, $tFecha);
        $pdf->Cell($cO4, $height, $tEstado);
        $pdf->Cell($cO5, $height, $tUnidades, 0, 0, "R");
        $pdf->Cell($cO6, $height, "$" . $tSubtotal, 0, 0, "R");
        $pdf->Cell($cO7, $height, "$" . $tShipping, 0, 0, "R");
        $pdf->Cell($cO8, $height, "$" . $tTotal, 0, 0, "R");
        $pdf->Cell($cO9, $height, "$" . $tCargosCanal, 0, 0, "R");
        $pdf->Cell($cO10, $height, "$" . $tCargosShipping, 0, 0, "R");
        $pdf->Cell($cO11, $height, "$" . number_format($tNeto, 2), 0, 0, "R");
    }

    $pdf->Ln($newLine);
    $pdf->SetFont($font, "B", 11);
    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);
    $pdf->Cell($cO1, $height, "", 0, 0, "R");
    $pdf->Cell($cO2, $height, "");
    $pdf->Cell($cO3, $height, "");
    $pdf->Cell($cO4, $height, "");
    $pdf->Cell($cO5, $height, $ttUnidades, 0, 0, "R");
    $pdf->Cell($cO6, $height, "$" . $ttSubtotal, 0, 0, "R");
    $pdf->Cell($cO7, $height, "$" . $ttShipping, 0, 0, "R");
    $pdf->Cell($cO8, $height, "$" . $ttTotal, 0, 0, "R");
    $pdf->Cell($cO9, $height, "$" . $ttCargosCanal, 0, 0, "R");
    $pdf->Cell($cO10, $height, "$" . $ttCargosShipping, 0, 0, "R");
    $pdf->Cell($cO11, $height, "$" . number_format($ttNeto, 2), 0, 0, "R");

    //CARGOS DE CANAL
    $cO1 = 140;
    $cO2 = 20;
    $cO3 = 15;
    $cO4 = 13;

    $pdf->Ln($newLine * 2);
    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Cargos de Canal");

    $pdf->Ln($newLine);
    $pdf->SetFont($font, "B", 11);
    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);
    $pdf->Cell($cO1, $height, "Descripcion del Cargo / Fecha / Detalle");
    $pdf->Cell($cO2, $height, "Cantidad");
    $pdf->Cell($cO3, $height, "Precio");
    $pdf->Cell($cO4, $height, "Total");

    $ocQuery = "
        SELECT 
            CODCARGO, NOMBRE
        FROM
            cat_car_proyecto;
    ";

    $cResult = mysqli_query(conexion(""), $ocQuery);

    $ttCantidad = 0;
    $ttPrecio = 0;
    $ttTotal = 0;
    while ($cRow = mysqli_fetch_array($cResult)) {
        $cargos[$cRow["CODCARGO"]] = utf8_encode($cRow["NOMBRE"]);
    }

    $codProv = $_SESSION["codprov"];
    $ocQuery = "
        SELECT 
            b.ORDERID, a.VALOR, b.TIMOFORD, b.ORDERUNITS, a.PRECIO, a.CODCARGO
        FROM
            tra_bit_cobro AS a
        INNER JOIN
            tra_ord_enc AS b ON a.CODDOCTO = b.CODORDEN
        WHERE
            CODDOCTO IN (SELECT 
                    CODORDEN
                FROM
                    tra_ord_enc
                WHERE
                    CODBALCOM IN (SELECT 
                            CODBALCOM
                        FROM
                            tra_balances
                        WHERE
                            CODBALANCE = '$balanceId'
                                AND CODPROV = '$codProv'));    
    ";
//    echo $ocQuery;
    $ocResult = mysqli_query(conexion($_SESSION["pais"]), $ocQuery);
    $tBody = "";
    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tu = mysqli_fetch_array($tuResult)[0];

        switch ($tu) {
            case "CF":
                $tId = $ocRow["ORDERID"];
                $tDate = date_create($ocRow["TIMOFORD"]);
                $tDate = date_format($tDate, "M/d/Y");
                $tDesc = $tId . " - " . utf8_decode($cargos[$ocRow["CODCARGO"]]) . " - " . $tDate;
                $tQuantity = $ocRow["ORDERUNITS"];
                $ttCantidad += $tQuantity;
                $tPrice = sprintf("%.2f", $ocRow["PRECIO"]);
                $ttPrecio += $tPrice;
                $tTotal = $ocRow["VALOR"];
                $ttTotal += $tTotal;
                $ttTotal = number_format($ttTotal, 2);
                $pdf->Ln($newLine);
                $pdf->SetFont($font, "", 10);
                $pdf->Cell($cO1, $height, $tDesc);
                $pdf->Cell($cO2, $height, $tQuantity, 0, 0, "R");
                $pdf->Cell($cO3, $height, "$" . $tPrice, 0, 0, "R");
                $pdf->Cell($cO4, $height, "$" . $tTotal, 0, 0, "R");
                break;
        }
    }

    $pdf->Ln($newLine);

    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);
    $pdf->SetFont($font, "B", 11);
    $pdf->Cell($cO1, $height, "");
    $pdf->Cell($cO2, $height, "", 0, 0, "R");
    $pdf->Cell($cO3, $height, "", 0, 0, "R");
    $pdf->Cell($cO4, $height, "$" . $ttTotal, 0, 0, "R");

    //SHIPPING
    $pdf->Ln($newLine * 2);
    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Shipping");

    $pdf->Ln($newLine);
    $pdf->SetFont($font, "B", 11);

    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);
    $pdf->Cell($cO1, $height, "Descripcion del Cargo / Fecha / Detalle");
    $pdf->Cell($cO2, $height, "Cantidad");
    $pdf->Cell($cO3, $height, "Precio");
    $pdf->Cell($cO4, $height, "Total");

    $ocQuery = "
        SELECT 
            CODCARGO, NOMBRE
        FROM
            cat_car_proyecto;
    ";

    $cResult = mysqli_query(conexion(""), $ocQuery);

    while ($cRow = mysqli_fetch_array($cResult)) {
        $cargos[$cRow["CODCARGO"]] = utf8_encode($cRow["NOMBRE"]);
    }

    $codProv = $_SESSION["codprov"];
    $ocQuery = "
        SELECT 
            b.ORDERID, a.VALOR, b.TIMOFORD, b.ORDERUNITS, a.PRECIO, a.CODCARGO
        FROM
            tra_bit_cobro AS a
        INNER JOIN
            tra_ord_enc AS b ON a.CODDOCTO = b.CODORDEN
        WHERE
            CODDOCTO IN (SELECT 
                    CODORDEN
                FROM
                    tra_ord_enc
                WHERE
                    CODBALCOM IN (SELECT 
                            CODBALCOM
                        FROM
                            tra_balances
                        WHERE
                            CODBALANCE = '$balanceId'
                                AND CODPROV = '$codProv'));    
    ";
//    echo $ocQuery;
    $ocResult = mysqli_query(conexion($_SESSION["pais"]), $ocQuery);
    $tBody = "";
    $ttCantidad = 0;
    $ttPrecio = 0;
    $ttTotal = 0;
    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tu = mysqli_fetch_array($tuResult)[0];

        switch ($tu) {
            case "SH":
                $tId = $ocRow["ORDERID"];
                $tDate = date_create($ocRow["TIMOFORD"]);
                $tDate = date_format($tDate, "M/d/Y");
                $tDesc = $tId . " - " . $cargos[$ocRow["CODCARGO"]] . " - " . $tDate;
                $tQuantity = $ocRow["ORDERUNITS"];
                $ttCantidad += $tQuantity;
                $tPrice = sprintf("%.2f", $ocRow["PRECIO"]);
                $ttPrecio += $tPrice;
                $tTotal = $ocRow["VALOR"];
                $ttTotal += $tTotal;
                $ttTotal = number_format($ttTotal, 2);
                $pdf->Ln($newLine);
                $pdf->SetFont($font, "", 10);
                $pdf->Cell($cO1, $height, $tDesc);
                $pdf->Cell($cO2, $height, $tQuantity, 0, 0, "R");
                $pdf->Cell($cO3, $height, "$" . $tPrice, 0, 0, "R");
                $pdf->Cell($cO4, $height, "$" . $tTotal, 0, 0, "R");
                break;
        }
    }

    $pdf->Ln($newLine);
    $pdf->SetFont($font, "B", 11);
    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);
    $pdf->Cell($cO1, $height, "");
    $pdf->Cell($cO2, $height, "", 0, 0, "R");
    $pdf->Cell($cO3, $height, "", 0, 0, "R");
    $pdf->Cell($cO4, $height, "$" . $ttTotal, 0, 0, "R");

    //OTROS CARGOS
    $pdf->Ln($newLine * 2);
    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Otros Cargos");
    $cO1 = 90;
    $cO2 = 20;
    $cO3 = 15;
    $cO4 = 13;
    $cO5 = 80;

    $pdf->Ln($newLine);
    $pdf->SetFont($font, "B", 11);
    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);
    $pdf->Cell($cO1, $height, "Descripcion del Cargo / Fecha / Detalle");
    $pdf->Cell($cO2, $height, "Cantidad");
    $pdf->Cell($cO3, $height, "Precio");
    $pdf->Cell($cO4, $height, "Total");
    $pdf->Cell($cO5, $height, "Observaciones");

    $ocQuery = "
        SELECT 
            CODCARGO, NOMBRE
        FROM
            cat_car_proyecto;
    ";

    $cResult = mysqli_query(conexion(""), $ocQuery);

    while ($cRow = mysqli_fetch_array($cResult)) {
        $cargos[$cRow["CODCARGO"]] = utf8_encode($cRow["NOMBRE"]);
    }

    $codProv = $_SESSION["codprov"];
//cargos de canal
    $ocQuery = "
        SELECT 
            *
        FROM
            tra_det_cobro AS a
                INNER JOIN
            tra_bit_cobro AS b ON a.CODDETCOB = b.CODDETCOB
        WHERE
            CODBALANCE = '$balanceId'
                AND CODPROV = '$codProv'
        ORDER BY FECHACAR;    
    ";
    $ocResult = mysqli_query(rconexionProveedorLocal($_SESSION["pais"]), $ocQuery);
    $tBody = "";
    $ttTotal = 0;
    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION, OBSER
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tuRow = mysqli_fetch_array($tuResult);
        $tu = $tuRow[0];
        $tuObser = $tuRow[1];
        switch ($tu) {
            case "OC":
                $tId = "";
                $tDate = date_create($ocRow["FECHACAR"]);
                $tDate = date_format($tDate, "M/d/Y");
                $tD = explode(" ", $ocRow["OBSER"]);
                $tMiddle1 = substr($tD[4], 0, 4);
                $tMiddle2 = substr($tD[4], 5, strlen($tD[4]) - 1);
                $tD1 = $tD[0] . " " . $tD[1] . " " . $tD[2] . " " . $tD[3] . " " . $tMiddle1;
                $tD2 = $tMiddle2 . " " . $tD[5] . " " . $tD[6] . " " . $tD[7] . " " . $tD[8] . " " . $tD[9];
                $tDesc1 = utf8_decode($cargos[$ocRow["CODCARGO"]]) . " - " . $tDate;
                $tDesc2 = $tD1;
                $tDesc3 = $tD2;
                $tQuantity = number_format($ocRow["CANTIDAD"], 0);
                $tPrice = number_format($ocRow["PRECIO"], 2);
                $tTotal = $ocRow["VALOR"];
                $tObservaciones = $tuObser;
                $ttTotal += $tTotal;
                $ttTotal = number_format($ttTotal, 2);
                $pdf->Ln($newLine);
                $pdf->SetFont($font, "", 10);
                $pdf->Cell($cO1, $height, $tDesc1);
                $pdf->Ln($newLine);
                $pdf->Cell($cO1, $height, "  " . $tDesc2);
                $pdf->Ln($newLine);
                $pdf->Cell($cO1, $height, "  " . $tDesc3);
                $pdf->Cell($cO2, $height, $tQuantity, 0, 0, "R");
                $pdf->Cell($cO3, $height, "$" . $tPrice, 0, 0, "R");
                $pdf->Cell($cO4, $height, "$" . $tTotal, 0, 0, "R");
                $pdf->Cell($cO5, $height, $tObservaciones, 0, 0, "R");
                break;
        }
    }

    $pdf->Ln($newLine);
    $pdf->SetFont($font, "B", 11);
    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);
    $pdf->Cell($cO1, $height, "");
    $pdf->Cell($cO2, $height, "", 0, 0, "R");
    $pdf->Cell($cO3, $height, "", 0, 0, "R");
    $pdf->Cell($cO4, $height, "$" . $ttTotal, 0, 0, "R");
    $pdf->Cell($cO5, $height, "", 0, 0, "R");

    $pdf->Output("I", "$balanceId.pdf");
}