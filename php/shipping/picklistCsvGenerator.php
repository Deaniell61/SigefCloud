<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPExcel/PHPExcel.php");

generateCSV("Guatemala");

function generateCSV($connectionCountry)
{
    $date = date("Y-m-d h:m:s");
    $fileName = "picklist-$date.csv";

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->
    getProperties()
        ->setTitle("Bundles");

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(65);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

    $q = "
        SELECT 
            det.productid,
            det.disnam,
            SUM(det.qty) AS qty,
            group_concat(enc.orderid SEPARATOR ', ') as orderids
        FROM
            tra_ord_enc AS enc
                INNER JOIN
            tra_ord_det AS det ON enc.codorden = det.codorden
        WHERE
            estatus = 'created' AND tranum = ''
        GROUP BY det.productid
        ORDER BY qty;
    ";

    $r = mysqli_query(conexion($connectionCountry), $q);

    $objPHPExcel->getActiveSheet()
        ->setCellValue('A1', 'GuateDirect LLC')
        ->setCellValue('A2', 'Pick List products to made shipping')
        ->setCellValue('A3', "Date: " . date("m-d-Y"))
        ->setCellValue('A5', 'Product ID')
        ->setCellValue('B5', 'Product Name')
        ->setCellValue('C5', 'Packs')
        ->setCellValue('D5', 'Total Units')
        ->setCellValue('E5', 'Boxes')
        ->setCellValue('F5', 'Units')
        ->setCellValue('G5', 'Orders');

    $i = 6;
    while ($row = mysqli_fetch_array($r)) {

        $productid = $row["productid"];
        $disnam = $row["disnam"];
        $qty = $row["qty"];
        $orderids = $row["orderids"];

        $unitData = getUnitData($productid, $qty);
        $units = $unitData[0];
        $boxes = $unitData[1];
        $unit = $unitData[2];

        $data[] = [
            "$productid",
            "$disnam",
            "$qty",
            "$units",
            "$boxes",
            "$unit",
            "$orderids",
        ];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $productid)
            ->setCellValue('B'.$i, $disnam)
            ->setCellValue('C'.$i, $qty)
            ->setCellValue('D'.$i, $units)
            ->setCellValue('E'.$i, $boxes)
            ->setCellValue('F'.$i, $unit)
            ->setCellValue('G'.$i, $orderids);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$i)
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G'.$i)
            ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $i++;
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit;
}

function getUnitData($productId, $qty){
    $q = "
        SELECT 
            ($qty * unitbundle) as units, floor((($qty * unitbundle) / unitcase)) as boxes, ($qty * unitbundle) - (floor((($qty * unitbundle) / unitcase)) * unitcase) as unit
        FROM
            tra_bun_det
        WHERE
            amazonsku = '$productId';
    ";

    $r = mysqli_query(conexion("Guatemala"), $q);

    return mysqli_fetch_array($r);
}