<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../../coneccion.php');
$idioma='es';
include('../../../idiomas/'.$idioma.'_consulta.php');
session_start(); 
$canal=$_GET['param'];
  
  $squery="select p.mastersku as mastersku,tb.amazonsku as amazonsku,tb.unitbundle as unitbundle,p.keywords as keywords,tb.prodname as prodname,p.metatitles as metatitles,p.descprod as description,tb.asin as asin,p.prodname as prodnameprod ,(select channel from cat_sal_cha ch where ch.codchan=tb.codcanal) as canal,(select cct.catname from cat_cat_cha cct inner join tra_cat_hom tcc on tcc.cattarget=cct.codcatcha where (tcc.catsource=p.categori or tcc.catsource=p.subcate2 or tcc.catsource=p.subcate1) and cct.codchan='_4KS0JMQAH' limit 1) as cate from tra_bun_det tb inner join cat_prod p on p.mastersku=tb.mastersku where tb.codcanal='_4EX0ME76Q' limit 3000"; 
 //$squery = "SELECT tr.mastersku as mastersku,tr.amazonsku as amazonsku,tr.prodname as prodname,tr.asin as asin,tr.unitcase as unitcase,tr.unitbundle as unitbundle,tr.cospri,tr.fbaordhanf as fbaordhanf,tr.fbapicpacf as fbapicpacf,tr.fbaweihanf as fbaweihanf,tr.fbainbshi as fbainbshi,tr.pacmat as pacmat,tr.shipping as shipping,tr.subtotfbac as subtotfbac,tr.netrevoves as netrevoves,tr.basmar as basmar,tr.basmarin as basmarin,tr.fbareffeeo as fbareffeeo,tr.sugsalpri as sugsalpri,tr.marovesugp as marovesugp,tr.maroveitec as maroveitec,tr.salprionsi as salprionsi,tr.comsalpri as comsalpri,tr.sugsalpric as sugsalpric,tr.incovesugs as incovesugs,tr.marovessp as marovessp,tr.bununipri as bununipri,tr.fbarefossp as fbarefossp,tr.marovecoss as marovecoss,tr.netrevossp as netrevossp,tr.marminsalp as marminsalp,tr.marmaxsalp as marmaxsalp,tr.minpri as minpri,tr.maxpri as maxpri,tr.cant,tr.cantidad,tr.psite,(SELECT channel from cat_sal_cha where codchan=tr.codcanal) as canal FROM tra_bun_det tr inner join cat_prod cp on cp.mastersku=tr.mastersku where tr.codcanal='".$canal."' ORDER BY tr.mastersku,tr.amazonsku ASC";ORDER BY tb.mastersku,tb.amazonsku ASC
 // where tb.codcanal='_4EX0ME76Q'
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
 
 if ($registros > 0) 
{
   require_once ('../../../lib/PHPExcel/PHPExcel.php');
   require_once('../../../coneccion.php');

   $objPHPExcel = new PHPExcel();
   
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.SigefCloud.com")
        ->setLastModifiedBy("www.SigefCloud.com")
        ->setTitle("Bundles_Canal_Categorias")
        ->setSubject("Reporte_Bundles")
        ->setDescription("Reporte de Bundles")
        ->setKeywords("Bundles")
        ->setCategory("ciudades");    
	$o = 0;
	$i = 1;

	$objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $lang[ $idioma ]['ProductID'])
			->setCellValue('B'.$i, $lang[ $idioma ]['BDC_MerchantSKU'])
			->setCellValue('C'.$i, $lang[ $idioma ]['BDC_ProductCondition'])
			->setCellValue('D'.$i, $lang[ $idioma ]['BDC_ShippingStandard'])
			->setCellValue('E'.$i, $lang[ $idioma ]['BDC_ShippingStandardlsFree'])
			->setCellValue('F'.$i, $lang[ $idioma ]['BDC_SKU'])
			->setCellValue('G'.$i, $lang[ $idioma ]['BuyDotComCategoryID'])
			->setCellValue('H'.$i, $lang[ $idioma ]['BuyDotComEnabled'])
			->setCellValue('I'.$i, $lang[ $idioma ]['BuyDotComPriceUseDefault'])
			->setCellValue('J'.$i, $lang[ $idioma ]['Size'])
			->setCellValue('K'.$i, $lang[ $idioma ]['Flavor'])
			->setCellValue('L'.$i, $lang[ $idioma ]['Gender'])
			->setCellValue('M'.$i, $lang[ $idioma ]['AgeSegment'])
			->setCellValue('N'.$i, $lang[ $idioma ]['PriceFallAgeGrou'])
			->setCellValue('O'.$i, $lang[ $idioma ]['PriceFallCategory'])
			->setCellValue('P'.$i, $lang[ $idioma ]['PriceFallEnabled'])
			->setCellValue('Q'.$i, $lang[ $idioma ]['PriceFallGender'])
			->setCellValue('R'.$i, $lang[ $idioma ]['PriceFallKeywords'])
			->setCellValue('S'.$i, $lang[ $idioma ]['PriceFallPriceUseDefault'])
			->setCellValue('T'.$i, $lang[ $idioma ]['PriceFallShippingType'])
			->setCellValue('U'.$i, $lang[ $idioma ]['PriceFallSize'])
			->setCellValue('V'.$i, $lang[ $idioma ]['PriceFallTitle'])
			->setCellValue('W'.$i, $lang[ $idioma ]['WebEnabled'])
			->setCellValue('X'.$i, $lang[ $idioma ]['MetaTitle'])
			->setCellValue('Y'.$i, $lang[ $idioma ]['MetaDescription'])
			->setCellValue('Z'.$i, $lang[ $idioma ]['MetaKeywords'])
			->setCellValue('AA'.$i, $lang[ $idioma ]['TopTitle'])
			->setCellValue('AB'.$i, $lang[ $idioma ]['PriceFallTitle'])
			->setCellValue('AC'.$i, $lang[ $idioma ]['OverstockTitle'])
			->setCellValue('AD'.$i, $lang[ $idioma ]['AmazonTitle'])
			->setCellValue('AE'.$i, $lang[ $idioma ]['ProductName'])
			->setCellValue('AF'.$i, $lang[ $idioma ]['Title'])
			->setCellValue('AG'.$i, $lang[ $idioma ]['CustomTitle'])
			->setCellValue('AH'.$i, $lang[ $idioma ]['JETCatalogType'])
			->setCellValue('AI'.$i, $lang[ $idioma ]['JETCategoryID'])
			->setCellValue('AJ'.$i, $lang[ $idioma ]['JETEnabled'])
			->setCellValue('AK'.$i, $lang[ $idioma ]['JETMerchantSKU'])
			->setCellValue('AL'.$i, $lang[ $idioma ]['JETPriceUseDefault'])
			->setCellValue('AM'.$i, $lang[ $idioma ]['JETTitle']);
			
	$si2="TRUE";
	$si="TRUE";
	$no="FALSE";
	$cero="1";
	$uno="0";	
   $i = 2;    
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_ASSOC)) 
   {
    	 
	 if($registro['unitbundle']=="1")
	 {		
	 $codigo=$registro['mastersku'];
	 $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $codigo)
			->setCellValue('B'.$i, $codigo)
			->setCellValue('C'.$i, $uno)
			->setCellValue('D'.$i, $cero)
			->setCellValue('E'.$i, $si2)
			->setCellValue('F'.$i, "")
			->setCellValue('G'.$i, $cero)
			->setCellValue('H'.$i, $si)
			->setCellValue('I'.$i, $si2)
			->setCellValue('J'.$i, "Pack of ".$registro['unitbundle'])
			->setCellValue('K'.$i, "")
			->setCellValue('L'.$i, "")
			->setCellValue('M'.$i, "")
			->setCellValue('N'.$i, "")
			->setCellValue('O'.$i, $registro['cate'])
			->setCellValue('P'.$i, $si)
			->setCellValue('Q'.$i, "")
			->setCellValue('R'.$i, $registro['keywords'])
			->setCellValue('S'.$i, $si2)
			->setCellValue('T'.$i, "Free")
			->setCellValue('U'.$i, "Pack of ".$registro['unitbundle'])
			->setCellValue('V'.$i, $registro['prodname'])
			->setCellValue('W'.$i, $si)
			->setCellValue('X'.$i, $registro['metatitles'])
			->setCellValue('Y'.$i, substr($registro['description'],0,255))
			->setCellValue('Z'.$i, $registro['keywords'])
			->setCellValue('AA'.$i, $registro['prodname'])
			->setCellValue('AB'.$i, $registro['prodname'])
			->setCellValue('AC'.$i, $registro['prodname'])
			->setCellValue('AD'.$i, $registro['prodname'])
			->setCellValue('AE'.$i, $registro['prodname'])
			->setCellValue('AF'.$i, $registro['prodname'])
			->setCellValue('AG'.$i, $registro['prodname'])
			->setCellValue('AH'.$i, $registro['asin'])
			->setCellValue('AI'.$i, "")
			->setCellValue('AJ'.$i, $si)
			->setCellValue('AK'.$i, $registro['amazonsku'])
			->setCellValue('AL'.$i, $si2)
			->setCellValue('AM'.$i, $registro['prodname']);
 
      $i++;
	 	
		 }
		$codigo=$registro['amazonsku']; 
      $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $codigo)
			->setCellValue('B'.$i, $codigo)
			->setCellValue('C'.$i, $uno)
			->setCellValue('D'.$i, $cero)
			->setCellValue('E'.$i, $si2)
			->setCellValue('F'.$i, "")
			->setCellValue('G'.$i, $cero)
			->setCellValue('H'.$i, $si)
			->setCellValue('I'.$i, $si2)
			->setCellValue('J'.$i, "Pack of ".$registro['unitbundle'])
			->setCellValue('K'.$i, "")
			->setCellValue('L'.$i, "")
			->setCellValue('M'.$i, "")
			->setCellValue('N'.$i, "")
			->setCellValue('O'.$i, "")
			->setCellValue('P'.$i, $si)
			->setCellValue('Q'.$i, "")
			->setCellValue('R'.$i, $registro['keywords'])
			->setCellValue('S'.$i, $si2)
			->setCellValue('T'.$i, "Free")
			->setCellValue('U'.$i, "Pack of ".$registro['unitbundle'])
			->setCellValue('V'.$i, substr($registro['prodname'],0,255))
			->setCellValue('W'.$i, $si)
			->setCellValue('X'.$i, $registro['metatitles'])
			->setCellValue('Y'.$i, substr($registro['description'],0,255))
			->setCellValue('Z'.$i, $registro['keywords'])
			->setCellValue('AA'.$i, $registro['prodname'])
			->setCellValue('AB'.$i, $registro['prodname'])
			->setCellValue('AC'.$i, $registro['prodname'])
			->setCellValue('AD'.$i, $registro['prodname'])
			->setCellValue('AE'.$i, $registro['prodname'])
			->setCellValue('AF'.$i, $registro['prodname'])
			->setCellValue('AG'.$i, $registro['prodname'])
			->setCellValue('AH'.$i, $registro['asin'])
			->setCellValue('AI'.$i, "")
			->setCellValue('AJ'.$i, $si)
			->setCellValue('AK'.$i, $registro['amazonsku'])
			->setCellValue('AL'.$i, $si2)
			->setCellValue('AM'.$i, $registro['prodname']);
 
      $i++;
      
   }
   /*
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
   
   $objPHPExcel->getActiveSheet()->getStyle('A2:AM2')->applyFromArray($estiloTituloColumnas);
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
   $objPHPExcel->getActiveSheet()->getColumnDimension("AE")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AF")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AG")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AH")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AI")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AJ")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AK")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AL")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension("AM")->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:AM".($i-1));
   /*
   $objPHPExcel->getActiveSheet() ->getStyle('G4:K'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('N4:O'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('V4:W'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('Z4:AA'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('AC4:AC'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); 
   $objPHPExcel->getActiveSheet() ->getStyle('R4:T'.$i) ->getNumberFormat() ->setFormatCode( '_-$* #,##0.00_-;-Q* #,##0.00_-;_-Q* "-"??_-;_-@_-' ); */
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bundles_Canal_Categorias.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();


?>