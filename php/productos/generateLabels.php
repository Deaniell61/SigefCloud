<?php
error_reporting(E_ERROR);
ini_set('display_errors', '1');

session_start();
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPExcel/PHPExcel.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/lib/barcode.inc.php";

//configure xls
$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->setTitle('labels');
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(25.57);
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(23.96);
$row = "1";


//get data
if(isset($_POST["formOderIds"])){
    $orderIDs = $_POST["formOderIds"];
}

if(isset($_POST["singlePackageOrderID"])){
    $orderIDs = $_POST["singlePackageOrderID"];
}

if(isset($_POST["singlePackageLimits"])){
    $singlePackageLimits = json_decode($_POST["singlePackageLimits"], true) ;
}

//$orderIDs = "4790733994953, 1794423861820, 3794423860488, 1794382753877";
//$orderIDs = "5550874";
//$singlePackageLimits = json_decode(html_entity_decode('{"502300665":3,"502300666":3}'), true) ;
//var_dump($singlePackageLimits);
//var_dump($singlePackageLimits["502300665"]);
$codOrdersQ = "
    SELECT 
        codorden, orderid
    FROM
        tra_ord_enc
    WHERE
        orderid IN ($orderIDs);
";
$codOrdersR = mysqli_query(conexion($_SESSION["pais"]), $codOrdersQ);
$contLabels = 0;
while ($codOrdersRow = mysqli_fetch_array($codOrdersR)) {
    $orderID = $codOrdersRow["orderid"];
    $codOrder = $codOrdersRow["codorden"];

//    echo "<br><br>ORDERID:$orderID<br>";

    $orderDetailsQ = "
        SELECT
            productid, qty
        FROM
            tra_ord_det
        WHERE 
            codorden = '$codOrder';
    ";

    $orderDetailsR = mysqli_query(conexion($_SESSION["pais"]), $orderDetailsQ);

    while ($orderDetailsRow = mysqli_fetch_array($orderDetailsR)) {
        $productID = $orderDetailsRow["productid"];
        $qty = $orderDetailsRow["qty"];

//        echo "PRODUCT:$productID - QTY:$qty<br>";

        $productQ = "
            SELECT
                UNITBUNDLE, UPC, PRODNAME
            FROM
                tra_bun_det
            WHERE
                (amazonsku = '$productID'
                    || mastersku = '$productID')
            ORDER BY unitbundle ASC
            LIMIT 1;
        ";
//echo"<br>$productQ<br>";
        $productR = mysqli_query(conexion($_SESSION["pais"]), $productQ);

        while ($productRow = mysqli_fetch_array($productR)) {
            $unitbundle = $productRow["UNITBUNDLE"];
            $upc = $productRow["UPC"];
            $prodname = $productRow["PRODNAME"];

//            echo "<br>" . $_SERVER["DOCUMENT_ROOT"] . '/images/tupc.gif' . "<br>";
//            echo "<br>$unitbundle - $upc - $prodname<br>";
            new barCodeGenrator($upc,1,$_SERVER["DOCUMENT_ROOT"] . "/images/tupc-$upc.gif", 125, 40, true);
//echo "Q:" . $qty;
            for ($contQty = 1; $contQty <= $qty; $contQty++) {
//                echo "SET:$contQty<br>";
//                echo "$productID<br>";
                $labelLimit = ($singlePackageLimits[$productID] != "") ? $singlePackageLimits[$productID] : $unitbundle;
//                echo "<br>" . $labelLimit[$productID] . "<br>$labelLimit<br>";
                for ($cont = 1; $cont <= $labelLimit; $cont++) {
                    $tPrintArea .= "A$row:B" . (intval($row) + 2) . ",";
                    $objPHPExcel->getActiveSheet()->mergeCells("A$row:B$row");
                    $objPHPExcel->getActiveSheet()->getStyle("A$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle("A$row")->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->setCellValue("A" . $row, $prodname);
                    $row++;
                    $objPHPExcel->getActiveSheet()->mergeCells("A$row:B$row");
//                        $objPHPExcel->getActiveSheet()->setCellValue("A" . $row, "BAR");
                    $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                    $objDrawing->setName('upc');        //set name to image
                    $objDrawing->setDescription('upc'); //set description to image
                    $signature = "../../images/tupc-$upc.gif";    //Path to signature .jpg file
                    $objDrawing->setPath($signature);
                    $objDrawing->setResizeProportional(false);
                    $objDrawing->setWidth(175);
                    $objDrawing->setHeight(35);
                    $objDrawing->setCoordinates("A$row");        //set image to cell
                    $objDrawing->setOffsetX(100);                       //setOffsetX works properly
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save
                    $row++;
//                        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(13.46);
                    $objPHPExcel->getActiveSheet()->getStyle("A$row:B$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                    $objPHPExcel->getActiveSheet()->getStyle("A$row")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $objPHPExcel->getActiveSheet()->setCellValue("A" . $row, $orderID);
                    $objPHPExcel->getActiveSheet()->setCellValue("B" . $row, "$cont/$unitbundle");
                    $row++;

//                        echo "UNITBUNDLE:$unitbundle - UPC:$upc - PRODNAME:$prodname - CONT:$cont/$unitbundle<br>";

                    $contLabels ++;

                }
            }
        }
    }
}

$objPHPExcel->getActiveSheet()->getStyle("A1:B$row")->getFont()->setSize(8);
$objPHPExcel->getActiveSheet()->getStyle("A1:B$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getStyle("A1:B$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//$objPHPExcel->getActiveSheet()->getRowDimension("1:$row")->setRowHeight(15);

$objPHPExcel->getActiveSheet()->setShowGridlines(false);
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_TABLOID);
$tPrintArea = substr($tPrintArea, 0, -1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea($tPrintArea);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight($contLabels);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0);

header('Content-Type: application/vnd.ms-excel');
$tFileName = " labels " . date("Y-m-d");
header('Content-Disposition: attachment;filename="' . $tFileName . '.xlsx"');
header('Cache-Control: max-age=0');

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter = new PHPExcel_Writer_Excel2007 ( $objPHPExcel );
$objWriter->save('php://output');