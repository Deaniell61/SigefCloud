<?php
require_once('../coneccion.php');

$query="
    SELECT 
        bun.amazonsku, (inv.physicalin / bun.unitbundle) AS quantity
    FROM
        tra_bun_det AS bun
            INNER JOIN
        sageinventario AS inv ON bun.mastersku = inv.productid LIMIT 10;
";

$result = mysqli_query (conexion("Guatemala"), $query);

while ($row = mysqli_fetch_array($result)){
    echo "$row<br>";
}




/*
if ($registros > 0) {
    require_once ('../lib/PHPExcel/PHPExcel.php');
    require_once('../coneccion.php');

    $objPHPExcel = new PHPExcel();

    //Informacion del excel
    $objPHPExcel->
    getProperties()
        ->setCreator("www.SigefCloud.com")
        ->setLastModifiedBy("www.SigefCloud.com")
        ->setTitle("Bundles")
        ->setSubject("Reporte_Bundles")
        ->setDescription("Reporte de Bundles")
        ->setKeywords("Bundles")
        ->setCategory("ciudades");


    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'MasterSKU');


    $i = 3;
    while ($registro = mysqli_fetch_array($resultado,MYSQLI_ASSOC)) {

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $registro['mastersku'])
            ->setCellValue('B'.$i, $registro['prodname']);

        $i++;

    }
}
*/
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="Bundles.xlsx"');
//header('Cache-Control: max-age=0');
//
//$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
//$objWriter->save('php://output');