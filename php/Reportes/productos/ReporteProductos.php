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
$prod=$_GET['param'];
   
$sku = strtoupper($_GET['sku']);

$codigoEmpresa = $_SESSION['codEmpresa'];
$prov = "";
$extra = "";
if ($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U') {
    $prov = " and cp.codprov='" . $_SESSION['codprov'] . "'";
}

if(isset($_GET['param']))
{
	switch($prod)
	{
		case '1':
		{
			$extra = " and cp.imaurlbase='' ";
			break;
			
		}
		case '2':
		{
			$extra = " and cp.estatus='A' ";
			break;
			
		}
		case '3':
		{
			$extra = " and cp.estatus='B' ";
			break;
			
		}
		case '4':
		{
			$extra = " and cp.estatus='' ";
			break;
			
		}
		default:
		{
			$extra = "";
			break;
			
		}
	}
	
}

if ($sku == NULL) {
    $squery = "select cp.masterSKU,cp.codprod,cp.imaurlbase as imagen,cp.itemCode,cp.prodName,cp.nombre,cp.nombri,(select cm.nombre from cat_marcas cm where cm.codmarca=cp.marca and cm.codempresa='" . $_SESSION['codEmpresa'] . "') as marca,(select clp.prodline from cat_pro_lin clp where clp.codprolin=cp.codProLin and clp.codempresa='" . $_SESSION['codEmpresa'] . "') as prolin,(select ccp.nombre from cat_cat_pro ccp where ccp.codcate=cp.categori and ccp.codempresa='" . $_SESSION['codEmpresa'] . "') as category, (select tep.existencia from tra_exi_pro tep where tep.codprod=cp.codprod order by tep.existencia desc limit 1) as inventario from cat_prod cp where cp.codempresa='" . $_SESSION['codEmpresa'] . "'" . $prov . "" . $extra . " order by mastersku";
	
} else {
    if (!$sku == NULL) {
        $squery = "select cp.masterSKU,cp.codprod,cp.imaurlbase as imagen,cp.itemCode,cp.prodName,cp.nombre,cp.nombri,(select cm.nombre from cat_marcas cm where cm.codmarca=cp.marca and cm.codempresa='" . $_SESSION['codEmpresa'] . "') as marca,(select clp.prodline from cat_pro_lin clp where clp.codprolin=cp.codProLin and clp.codempresa='" . $_SESSION['codEmpresa'] . "') as prolin,(select ccp.nombre from cat_cat_pro ccp where ccp.codcate=cp.categori and ccp.codempresa='" . $_SESSION['codEmpresa'] . "') as category, (select tep.existencia from tra_exi_pro tep where tep.codprod=cp.codprod order by tep.existencia desc limit 1) as inventario from cat_prod cp where cp.codempresa='" . $_SESSION['codEmpresa'] . "'" . $prov . "" . $extra . " and (cp.masterSKU like '" . $sku . "%' or (select cm.nombre from cat_marcas cm where cm.codmarca=cp.marca" . $prov . " and cm.codempresa='" . $_SESSION['codEmpresa'] . "') like '" . $sku . "%' or cp.descSis like '" . $sku . "%' or cp.prodName like '%" . $sku . "%') order by mastersku";
    }
}

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
            ->setCellValue('A'.$i, $lang[ $idioma ]['MasterSKU'])
			->setCellValue('B'.$i, $lang[ $idioma ]['ItemCode'])
			->setCellValue('C'.$i, $lang[ $idioma ]['Imagen'])
			->setCellValue('D'.$i, $lang[ $idioma ]['ProdName'])
			->setCellValue('E'.$i, $lang[ $idioma ]['Marca'])
			->setCellValue('F'.$i, $lang[ $idioma ]['Category'])
			->setCellValue('G'.$i, $lang[ $idioma ]['Inventario']); 
   $i++;   
if($resultado = mysqli_query ( conexion($_SESSION['pais']),$squery))
{
 $registros = mysqli_num_rows ($resultado);
 
 if ($registros > 0) 
 {
   
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_NUM)) 
   {
       if($registro['10']=="")
	   {
		   $existe=0;
		   }
		   else
		   {
			   $existe=$registro['10'];
			   }
			   
      
	 $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $registro['0'])
			->setCellValue('B'.$i, $registro['3'])
			
			->setCellValue('D'.$i, $registro['4'])
			->setCellValue('E'.$i, $registro['7'])
			->setCellValue('F'.$i, $registro['9'])
			->setCellValue('G'.$i, $existe);
			
			if($registro['2']!="")
			   {
				   if(file_exists("../../../imagenes/media/cache/".limpiar_caracteres_especiales($_SESSION['nomEmpresa']).$registro['2']))
				   {
	   $objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('image.jpg');
			$objDrawing->setDescription('Excel logo');
			$objDrawing->setPath("../../../imagenes/media/cache/".limpiar_caracteres_especiales($_SESSION['nomEmpresa']).$registro['2']);  
			$objDrawing->setHeight(20);                
			   
			$objDrawing->setCoordinates('C'.$i);  
			$objDrawing->setOffsetX(10);               
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				   }
			   }
      $i++;
     $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:G".($i-1));
   $objPHPExcel->getActiveSheet() ->getStyle('G4:G'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
    
   }
   
 }
}

   //$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
   //$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloCanales);
   $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($estiloTituloColumnas);
   $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
   
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:G".($i-1));
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
header('Content-Disposition: attachment;filename="Catalogo_De_Productos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();


?>