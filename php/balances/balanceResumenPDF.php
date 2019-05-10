<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/fpdf181/fpdf.php");

include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/balances/balanceOperations.php");

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
            $this->Cell($width, $height, "Resumen del Balance de Liquidacion");
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
    $width = "60";
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
    $pdf->Cell($width, $height, "Resumen");

    $t = getBalance($balanceId);
    $r = json_decode($t);
    $pdf->Ln($newLine);
    $pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 25, $pdf->GetY());
    $pdf->SetFont($font, "B", 11);
//    $pdf->Cell($cO1, $height, "$t");

    $saldoInicialValue = number_format($r->SALDO_INI,2);
    $ventaProductosValue = number_format($r->vp,2);
    $extraShippingValue = number_format($r->es,2);
    $cargosCanalValue = number_format($r->cf,2);
    $shippingValue = number_format($r->sh,2);
    $subTotalVentasValue = number_format(($r->TOTALING - $r->CANALCAR),2);
    $otrosCargosValue = number_format($r->OTROSCAR,2);
    $saldoFinalValue = number_format($r->SALDO,2);

    $pdf->Ln($newLine);
    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Balance");
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Saldo Inicial:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$saldoInicialValue");
    $pdf->Ln($newLine);
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Ordenes");
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Venta de Productos:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$ventaProductosValue");
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Extra Shipping y Otros:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$extraShippingValue");
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Cargos de Canal:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$cargosCanalValue");
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Shipping:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$shippingValue");
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Sub Total de Ventas:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$subTotalVentasValue");
    $pdf->Ln($newLine);
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Otros Cargos");
    $pdf->Ln($newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Otros Cargos:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$otrosCargosValue");
    $pdf->Ln($newLine);
    $pdf->Ln($newLine);

    $pdf->Line(10, $pdf->GetY() + $newLine, $pdf->GetPageWidth() - 25, $pdf->GetY() + $newLine);

    $pdf->SetFont($font, "B", 14);
    $pdf->Cell($width, $height, "Saldo Final:");
    $pdf->SetFont($font, "", 14);
    $pdf->Cell($width, $height, "$saldoFinalValue");
    $pdf->Ln($newLine);

    $pdf->Output("I", "$balanceId.pdf");
}