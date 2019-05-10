<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../../coneccion.php');
require_once('../../../fecha.php');
$idioma=idiomaC();
include('../../../idiomas/'.$idioma.'.php');
session_start(); 

$codigoEmpresa = $_SESSION['codEmpresa'];
$prov = "";
$extra = "";

$inicio= $_GET['inicio'];
$fin= $_GET['fin'];

$pais=$_SESSION['pais'];

	$squery="select codprovta,codprod,codperi,sum(subtotal),sum(shipping),sum(discount),sum(total),sum(unidades),sum(ordenes),giftwrap,prodname from tra_ventas_producto where (codperi between '".$inicio."' and '".$fin."') group by codprod order by prodname";


	require_once ('../../../lib/PHPExcel/PHPExcel.php');
   require_once('../../../coneccion.php');

   $objPHPExcel = new PHPExcel();
   
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.SigefCloud.com")
        ->setLastModifiedBy("www.SigefCloud.com")
        ->setTitle("ProductosPorVenta")
        ->setSubject("ProductosPorVenta")
        ->setDescription("Productos Por Venta")
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
	$estiloInformacion2= new PHPExcel_Style();
	$estiloInformacion2->applyFromArray( array(
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
	if($_SESSION['codEmpresa']=="_4jt03skyy")
	{
	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $lang[ $idioma ]['Codigo'])
			->setCellValue('B'.$i, $lang[ $idioma ]['Estado'])
			->setCellValue('C'.$i, $lang[ $idioma ]['ordenes'])
			->setCellValue('D'.$i, $lang[ $idioma ]['subTotal'])
			->setCellValue('E'.$i, $lang[ $idioma ]['shipping'])
			->setCellValue('F'.$i, $lang[ $idioma ]['Descuento'])
			->setCellValue('G'.$i, $lang[ $idioma ]['grandtotal']); 
	}
	else
	{
	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $lang[ $idioma ]['Codigo'])
			->setCellValue('B'.$i, $lang[ $idioma ]['Estado'])
			->setCellValue('C'.$i, $lang[ $idioma ]['ordenes'])
			->setCellValue('G'.$i, $lang[ $idioma ]['grandtotal']); 
	}
	$periodo=$inicio;
	$letra="G";
	while($periodo<=$fin)
	{
		$letra++;
		$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue($letra.$i, substr($periodo,0,strlen($periodo)-3)."".nombreMes(substr($periodo,strlen($periodo)-3,strlen($periodo))));
			
		$nuevafecha = strtotime ( '+1 month' , strtotime ( $periodo ) ) ;
		$periodo = date ( 'Y-m' , $nuevafecha );
		
	}
	
   $i++;  
   $total=0; 
   
if($resultado = mysqli_query ( conexion($_SESSION['pais']),$squery))
{
 $registros = mysqli_num_rows ($resultado);
 
 if ($registros > 0) 
 {
   
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_NUM)) 
   {
   
			   
    if($_SESSION['codEmpresa']=="_4jt03skyy")
	{
	 $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $registro['1'])
			->setCellValue('B'.$i, $registro['10'])
			->setCellValue('C'.$i, ($registro['8']))
			->setCellValue('D'.$i, (round($registro['3'],5,2)))
			->setCellValue('E'.$i, (round($registro['4'],5,2)))
			->setCellValue('F'.$i, (round($registro['5'],5,2)))
			->setCellValue('G'.$i, ((round($registro['3'],5,2)+round($registro['4'],5,2)-round($registro['5'],5,2))));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "C4:".$letra.($i-1));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:A".($i-1));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion2, "B4:B".($i-1));
	}
	else
	{
	 $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $registro['1'])
			->setCellValue('B'.$i, $registro['10'])
			->setCellValue('C'.$i, ($registro['8']))
			->setCellValue('G'.$i, ((round($registro['3'],5,2)+round($registro['4'],5,2)-round($registro['5'],5,2))));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "G4:".$letra.($i));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "C4:C".($i));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:A".($i-1));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion2, "B4:B".($i-1));
	}
	$periodo2=$inicio;
	$letra2="G";
	while($periodo2<=$fin)
	{
		
		$letra2++;
		
		$squery2="select sum(ordenes),sum(subtotal),sum(shipping),sum(discount),sum(total),sum(unidades),giftwrap,prodname from tra_ventas_producto where codperi='".$periodo2."' and codprod='".$registro['1']."' group by codperi";
		$ejecutar2=mysqli_query(conexion($pais),$squery2);
		if($ejecutar2)
		{
			if($ejecutar2->num_rows>0)
			{
			$contador=0;
				while($row2=mysqli_fetch_array($ejecutar2,MYSQLI_NUM))
				{
		$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue($letra2.$i, ((round($row2['1'],5,2)+round($row2['2'],5,2)-round($row2['3'],5,2))));
				}
			}
			else
			{
		$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue($letra2.$i, ("0"));
			}
		}
			
		$nuevafecha = strtotime ( '+1 month' , strtotime ( $periodo2 ) ) ;
		$periodo2 = date ( 'Y-m' , $nuevafecha );
		
	}	
			
			
						
      $i++;
      
   	 //$objPHPExcel->getActiveSheet()->getStyle('G1:'.$letra.($i-1))->getNumberFormat()->setFormatCode('##########################################################'); 
    
   }
   
 }
}

   //$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
   //$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloCanales);
   $objPHPExcel->getActiveSheet()->getStyle('A3:'.$letra.'3')->applyFromArray($estiloTituloColumnas);
   $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(14);
   $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(14);
   $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(15);
   $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(15);
   $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(15);
   if(!($_SESSION['codEmpresa']=="_4jt03skyy"))
	{
		$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(0);
   		$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(0);
   		$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(0);
	}
   $Letra1="G";
   while($Letra1<$letra)
   {
	$Letra1++;
	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue($Letra1.$i, '=SUM('.$Letra1.'4:'.$Letra1.($i-1).')');
    $objPHPExcel->getActiveSheet()->getColumnDimension($Letra1)->setWidth(15);
    //$objPHPExcel->getActiveSheet()->getColumnDimension($Letra1)->setAutoSize(true);
   }
   $Letra2=$Letra1;
   $Letra2++;
   $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue($Letra2.$i, '=SUM(G'.($i).':'.($Letra1).($i).')');
   /*$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('C'.$i+1, toMoney($total));*/
			
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "C4:".$letra.($i-1));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:A".($i-1));
	 $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion2, "B4:B".($i-1));
	 $objPHPExcel->getActiveSheet() ->getStyle('D4:'.$Letra2.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
	  $objPHPExcel->getActiveSheet()->getColumnDimension($Letra2)->setWidth(15);
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
header('Content-Disposition: attachment;filename="Productos_$.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();

function nombreMes($mes)
{
	switch($mes)
	{
		case "-01":
		{
			return "-ENE";
			break;
		}
		case "-02":
		{
			return "-FEB";
			break;
		}
		case "-03":
		{
			return "-MAR";
			break;
		}
		case "-04":
		{
			return "-ABR";
			break;
		}
		case "-05":
		{
			return "-MAY";
			break;
		}
		case "-06":
		{
			return "-JUN";
			break;
		}
		case "-07":
		{
			return "-JUL";
			break;
		}
		case "-08":
		{
			return "-AGO";
			break;
		}
		case "-09":
		{
			return "-SEP";
			break;
		}
		case "-10":
		{
			return "-OCT";
			break;
		}
		case "-11":
		{
			return "-NOV";
			break;
		}
		case "-12":
		{
			return "-DIC";
			break;
		}
		
	}
}
?>