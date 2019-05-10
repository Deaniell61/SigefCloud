<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idiomaC();
include('../../idiomas/'.$idioma.'.php');
session_start(); 
$fechaI= $_GET['inicio'];
$fechaF= $_GET['fin'];
//$fecha=getdate();


	$squery="select orderid, timoford, (grandtotal), orderunits, ordsou, tranum,shicar from tra_ord_enc where (timoford <= '".$fechaF."' and timoford >= '".$fechaI."') and codprov='".$_SESSION['codprov']."' order by timoford desc";



	require_once ('../../lib/PHPExcel/PHPExcel.php');
   require_once('../../coneccion.php');

   $objPHPExcel = new PHPExcel();
   
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.SigefCloud.com")
        ->setLastModifiedBy("www.SigefCloud.com")
        ->setTitle("Productos")
        ->setSubject("Reporte_Productos")
        ->setDescription("Reporte de Productos")
        ->setKeywords("Productos")
        ->setCategory("ciudades");    
$objPHPExcel->getSheetCount();//cuenta las pestañas
	$estiloTituloColumnas = array(
    'font' => array(
        		'name'  => 'Arial',
        		'bold'  => true,
        		'color' => array(
            					'rgb' => 'FFFFFF'
        						)
    				),
    'fill' => array(
        			'type'=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
  					'rotation'=> 90,
        			'startcolor' => array(
            								'rgb' => '000000'
        								),
        			'endcolor' => array(
            							'argb' => 'FF431a5d'
        								)
    				),
    'borders' => array(
        				'top' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
        				'bottom' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            											)
        									),
						'left' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
						'right' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
    					),
    'alignment' =>  array(
        					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        					'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        					'wrap'      => FALSE
    						)
	);
	$estiloTituloCanales = array(
    'font' => array(
        		'name'  => 'Arial',
        		'bold'  => true,
        		'color' => array(
            					'rgb' => '000000'
        						)
    				),
    'borders' => array(
        				'top' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
        				'bottom' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            											)
        									),
						'left' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
						'right' => array(
            							'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            							'color' => array(
                										'rgb' => '143860'
            												)
        								),
    					),
    'alignment' =>  array(
        					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        					'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        					'wrap'      => TRUE
    						)
	);

	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    	'font' => array(
        	'name'  => 'Arial',
        	'color' => array(
            				'rgb' => '000000'
        					)
    				),
    	'fill' => array(
  					'type'  => PHPExcel_Style_Fill::FILL_SOLID
  						),
    	'alignment' =>  array(
        					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        					'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    						),
    	'borders' => array(
        			'left' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							),
					'right' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							),
					'top' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							),
					'bottom' => array(
            					'style' => PHPExcel_Style_Border::BORDER_THIN 
        							)

    					),
					
				));
	$positionInExcel=0;//esto es para que ponga la nueva pestaña al principio

	//creamos la pestaña
	
	$o=0;
	
	$i = 3;

	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $lang[ $idioma ]['orderid'])
			->setCellValue('B'.$i, $lang[ $idioma ]['timoford'])
			->setCellValue('C'.$i, $lang[ $idioma ]['grandtotal'])
			->setCellValue('D'.$i, $lang[ $idioma ]['orderunits'])
			->setCellValue('E'.$i, $lang[ $idioma ]['ordsou'])
			->setCellValue('F'.$i, $lang[ $idioma ]['tranum']); 
   $i++;  
   $total=0; 
if($resultado = mysqli_query ( conexion($_SESSION['pais']),$squery))
{
 $registros = mysqli_num_rows ($resultado);
 
 if ($registros > 0) 
 {
   
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_NUM)) 
   {
   
			   $total=$total+$registro['2'];
      
	 $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $registro['0'])
			->setCellValue('B'.$i, $registro['1'])
			->setCellValue('C'.$i, toMoney($registro['2']))
			->setCellValue('D'.$i, number_format($registro['3']))
			//->setCellValue('E'.$i, $registro['0'])
			->setCellValue('F'.$i, "'".$registro['5']);
			
			if(file_exists('../../../images/iconosSeller/Channel_'.$registro['4'].'.png'))
						{
							//$canal='<img src="../images/iconosSeller/Channel_'.$row['4'].'.png" style="width:20px; height:20px;"/>';
							$objDrawing = new PHPExcel_Worksheet_Drawing();
							$objDrawing->setName('image.jpg');
							$objDrawing->setDescription('Excel logo');
							$objDrawing->setPath('../../../images/iconosSeller/Channel_'.$registro['4'].'.png');  
							$objDrawing->setHeight(20);                
							   
							$objDrawing->setCoordinates('E'.$i);  
							$objDrawing->setOffsetX(10);               
							$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						}
						
      $i++;
     $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:F".($i-1));
   	 $objPHPExcel->getActiveSheet()->getStyle('F1:F'.($i-1))->getNumberFormat()->setFormatCode('##########################################################'); 
    
   }
   
 }
}

   //$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
   //$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloCanales);
   $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloColumnas);
   $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
   
   /*$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('C'.$i+1, toMoney($total));*/
			
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:F".($i-1));
	
   /*$objPHPExcel->getActiveSheet() ->getStyle('G4:K'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('N4:O'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('V4:W'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('Z4:AA'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('AC4:AC'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' );   */
   #$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'My Data');
   #$objPHPExcel->addSheet($myWorkSheet, 0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Dashboard_De_Ordenes.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();


?>