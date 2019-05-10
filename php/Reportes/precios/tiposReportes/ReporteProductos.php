<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../../coneccion.php');
$idioma=idiomaC();
include('../../../idiomas/'.$idioma.'.php');
session_start(); 
$prod=$_GET['param'];
   
 $squery = "SELECT tr.mastersku as mastersku,tr.amazonsku as amazonsku,tr.prodname as prodname,tr.asin as asin,tr.unitcase as unitcase,tr.unitbundle as unitbundle,tr.cospri,tr.fbaordhanf as fbaordhanf,tr.fbapicpacf as fbapicpacf,tr.fbaweihanf as fbaweihanf,tr.fbainbshi as fbainbshi,tr.pacmat as pacmat,tr.shipping as shipping,tr.subtotfbac as subtotfbac,tr.netrevoves as netrevoves,tr.basmar as basmar,tr.basmarin as basmarin,tr.fbareffeeo as fbareffeeo,tr.sugsalpri as sugsalpri,tr.marovesugp as marovesugp,tr.maroveitec as maroveitec,tr.salprionsi as salprionsi,tr.comsalpri as comsalpri,tr.sugsalpric as sugsalpric,tr.incovesugs as incovesugs,tr.marovessp as marovessp,tr.bununipri as bununipri,tr.fbarefossp as fbarefossp,tr.marovecoss as marovecoss,tr.netrevossp as netrevossp,tr.marminsalp as marminsalp,tr.marmaxsalp as marmaxsalp,tr.minpri as minpri,tr.maxpri as maxpri,tr.cant,tr.cantidad,tr.psite,(SELECT channel from cat_sal_cha where codchan=tr.codcanal) as canal FROM tra_bun_det tr inner join cat_prod cp on cp.mastersku=tr.mastersku where cp.codprod='".$prod."' ORDER BY tr.codcanal,tr.mastersku,tr.amazonsku ASC ";

#$altosql="(select pd.alto+(select te.alto from cat_tip_emp te where te.codpack=pd.codpack) as alto from cat_prod pd where pd.mastersku='".$masterSKU."' and pd.codprod='".$_SESSION['codprod']."')";
#$anchosql="(select pd.ancho+(select te.ancho from cat_tip_emp te where te.codpack=pd.codpack) as ancho from cat_prod pd where pd.mastersku='".$masterSKU."' and pd.codprod='".$_SESSION['codprod']."')";
#$largosql="(select pd.profun+(select te.largo from cat_tip_emp te where te.codpack=pd.codpack) as prof from cat_prod pd where pd.mastersku='".$masterSKU."' and pd.codprod='".$_SESSION['codprod']."')";

	
#	$squery="select (select peso_lb*16+peso_oz from cat_prod where codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codprod='".$_SESSION['codprod']."' limit 1) as pesoOz,(select peso from cat_prod where codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codprod='".$_SESSION['codprod']."' limit 1) as peso,(select peso_lb from cat_prod where codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codprod='".$_SESSION['codprod']."' limit 1) as pesoLB,$altosql as alto,$anchosql as ancho,$largosql as largo,masterSKU,codempresa,prodName,amazondesc,unitcase,codbundle,amazonsku,asin,unitbundle,cospri,pacmat,shipping,shirate,(subtotfbac) as subtotfbac,fbaordhanf,fbapicpacf,fbaweihanf,fbainbshi,basmar,basmarin,comsalpri,bununipri,fbareffeeo,sugsalpri,marovesugp,maroveitec,salprionsi,incovesugs,fbarefossp,marovecoss,marminsalp,marmaxsalp,minpri,maxpri,cant,cantidad,psite,pcompe,psuger,tipo,upc,(select channel from cat_sal_cha where codchan=codcanal) as canal,netrevoves,sugsalpric,netrevossp,marovessp from tra_bun_det where";
#	if($codBundle>0)
	{
#		$squery=$squery." codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codbundle='".$codBundle."' and amazonsku='".$amazonSKU."' and codcanal='".$CanalDes."'";
	}
#	else
	{
#	$squery=$squery."  codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and amazonsku='".$amazonSKU."' and codcanal='".$CanalDes."'";
	}
	

$resultado = mysqli_query ( conexion($_SESSION['pais']),$squery);
 $registros = mysqli_num_rows ($resultado);
 
 if ($registros > 0) {
   require_once ('../../../lib/PHPExcel/PHPExcel.php');
   require_once('../../../coneccion.php');

   $objPHPExcel = new PHPExcel();
   
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.SigefCloud.com")
        ->setLastModifiedBy("www.SigefCloud.com")
        ->setTitle("Bundles_Productos")
        ->setSubject("Reporte_Bundles")
        ->setDescription("Reporte de Bundles")
        ->setKeywords("Bundles")
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
        					'wrap'      => TRUE
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
	
	$o=-1;
$chan="";	
	 
      
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_ASSOC)) {
       
      if($chan != $registro['canal'])
	 {
		  
	 $o++;
	$objPHPExcel->createSheet($o)->setTitle($registro['canal']);
	
	$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
   $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloCanales);
   $objPHPExcel->getActiveSheet()->getStyle('A3:AD3')->applyFromArray($estiloTituloColumnas);
   $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("X")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Y")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Z")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AA")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AB")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AC")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AD")->setAutoSize(true);
  
   
	$i = 2;
		
	   $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $registro['canal']);
	$i = 3;

	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $lang[ $idioma ]['MasterSKU'])
			->setCellValue('B'.$i, $lang[ $idioma ]['ProdName'])
			->setCellValue('C'.$i, $lang[ $idioma ]['amazonSKU'])
			->setCellValue('D'.$i, $lang[ $idioma ]['Asin'])
			->setCellValue('E'.$i, $lang[ $idioma ]['UnitCase'])
			->setCellValue('F'.$i, $lang[ $idioma ]['unitBundle'])
			->setCellValue('G'.$i, $lang[ $idioma ]['cospri'])
			->setCellValue('H'.$i, $lang[ $idioma ]['pacmat'])
			->setCellValue('I'.$i, $lang[ $idioma ]['shipping'])
			->setCellValue('J'.$i, $lang[ $idioma ]['subtotfbac'])
			->setCellValue('K'.$i, $lang[ $idioma ]['netrevoves'])
			->setCellValue('L'.$i, $lang[ $idioma ]['basmar'])
			->setCellValue('M'.$i, $lang[ $idioma ]['basmarin'])
			->setCellValue('N'.$i, $lang[ $idioma ]['fbareffeeo'])
			->setCellValue('O'.$i, $lang[ $idioma ]['sugsalpri'])
			->setCellValue('P'.$i, $lang[ $idioma ]['marovesugp'])
			->setCellValue('Q'.$i, $lang[ $idioma ]['maroveitec'])
			->setCellValue('R'.$i, $lang[ $idioma ]['salprionsi'])
			->setCellValue('S'.$i, $lang[ $idioma ]['comsalpri'])
			->setCellValue('T'.$i, $lang[ $idioma ]['sugsalpric'])
			->setCellValue('U'.$i, $lang[ $idioma ]['incovesugs'])
			->setCellValue('V'.$i, $lang[ $idioma ]['fbarefossp'])
			->setCellValue('W'.$i, $lang[ $idioma ]['netrevossp'])
			->setCellValue('X'.$i, $lang[ $idioma ]['marovecoss'])
			->setCellValue('Y'.$i, $lang[ $idioma ]['marovessp'])
			->setCellValue('Z'.$i, $lang[ $idioma ]['bununipri'])
			->setCellValue('AA'.$i, $lang[ $idioma ]['minpri'])
			->setCellValue('AB'.$i, $lang[ $idioma ]['marminsalp'])
			->setCellValue('AC'.$i, $lang[ $idioma ]['maxpri'])
			->setCellValue('AD'.$i, $lang[ $idioma ]['marmaxsalp']);
			
		
			
			
   
	$i++;
	 }
	 $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $registro['mastersku'])
			->setCellValue('B'.$i, $registro['prodname'])
			->setCellValue('C'.$i, $registro['amazonsku'])
			->setCellValue('D'.$i, $registro['asin'])
			->setCellValue('E'.$i, $registro['unitcase'])
			->setCellValue('F'.$i, $registro['unitbundle'])
			->setCellValue('G'.$i, $registro['cospri'])
			->setCellValue('H'.$i, $registro['pacmat'])
			->setCellValue('I'.$i, $registro['shipping'])
			->setCellValue('J'.$i, $registro['subtotfbac'])
			->setCellValue('K'.$i, $registro['netrevoves'])
			->setCellValue('L'.$i, $registro['basmar'])
			->setCellValue('M'.$i, $registro['basmarin'])
			->setCellValue('N'.$i, $registro['fbareffeeo'])
			->setCellValue('O'.$i, $registro['sugsalpri'])
			->setCellValue('P'.$i, $registro['marovesugp'])
			->setCellValue('Q'.$i, $registro['maroveitec'])
			->setCellValue('R'.$i, $registro['salprionsi'])
			->setCellValue('S'.$i, $registro['comsalpri'])
			->setCellValue('T'.$i, $registro['sugsalpric'])
			->setCellValue('U'.$i, $registro['incovesugs'])
			->setCellValue('V'.$i, $registro['fbarefossp'])
			->setCellValue('W'.$i, $registro['netrevossp'])
			->setCellValue('X'.$i, $registro['marovecoss'])
			->setCellValue('Y'.$i, $registro['marovessp'])
			->setCellValue('Z'.$i, $registro['bununipri'])
			->setCellValue('AA'.$i, $registro['minpri'])
			->setCellValue('AB'.$i, $registro['marminsalp'])
			->setCellValue('AC'.$i, $registro['maxpri'])
			->setCellValue('AD'.$i, $registro['marmaxsalp']);
 $chan=$registro['canal'];
      $i++;
     $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:AD".($i-1));
   $objPHPExcel->getActiveSheet() ->getStyle('G4:K'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('N4:O'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('V4:W'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('Z4:AA'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('AC4:AC'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' );   
   }
   $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
   $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloCanales);
   $objPHPExcel->getActiveSheet()->getStyle('A3:AD3')->applyFromArray($estiloTituloColumnas);
   $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("X")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Y")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("Z")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AA")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AB")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AC")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AD")->setAutoSize(true);
   
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:AD".($i-1));
   $objPHPExcel->getActiveSheet() ->getStyle('G4:K'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('N4:O'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('V4:W'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('Z4:AA'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('AC4:AC'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-' );   
   #$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'My Data');
   #$objPHPExcel->addSheet($myWorkSheet, 0);
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bundles_Productos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();


?>