<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../../coneccion.php');
$idioma='es';
include('../../../idiomas/'.$idioma.'_ConProductos.php');
session_start(); 
$canal=$_GET['param'];
$cantbun=$_GET['num'];
$extra="";
  	
	if($cantbun!='0')
	{
		$extra="and tb.unitbundle<=".$cantbun." ";
		
	}
	
  $squery="select p.mastersku as mastersku,tb.amazonsku as amazonsku,tb.unitbundle as unitbundle,p.keywords as keywords,tb.prodname as prodname,p.metatitles as metatitles,p.descprod as description,tb.asin as asin,p.prodname as prodnameprod ,(select channel from cat_sal_cha ch where ch.codchan=tb.codcanal) as canal,(select nombre from cat_manufacturadores m where m.codmanufac=p.codmanufac) manuf,tb.asin as asin,p.descprod as descripcion,imaurlbase as imagen1,(select file from cat_prod_img cpp where cpp.codprod=p.codprod limit 1 ) as imagen2 from tra_bun_det tb inner join cat_prod p on p.mastersku=tb.mastersku where tb.codcanal='$canal' ".$extra." limit 3000"; 
 

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
            ->setCellValue('A'.$i, 'seller-id')
			->setCellValue('B'.$i, 'gtin')
			->setCellValue('C'.$i, 'isbn')
			->setCellValue('D'.$i, 'mfg-name')
			->setCellValue('E'.$i, 'mfg-part-number')
			->setCellValue('F'.$i, 'asin')
			->setCellValue('G'.$i, 'seller-sku')
			->setCellValue('H'.$i, 'title')
			->setCellValue('I'.$i, 'description')
			->setCellValue('J'.$i, 'main-image')
			->setCellValue('K'.$i, 'additional-images')
			->setCellValue('L'.$i, 'weight')
			->setCellValue('M'.$i, 'features')
			->setCellValue('N'.$i, 'listing-price')
			->setCellValue('O'.$i, 'msrp')
			->setCellValue('P'.$i, 'category-id	')
			->setCellValue('Q'.$i, 'keywords')
			->setCellValue('R'.$i, 'product-set-id')
			->setCellValue('S'.$i, 'Age Segment')
			->setCellValue('T'.$i, 'Ailment')
			->setCellValue('U'.$i, 'Amino Acid Type')
			->setCellValue('V'.$i, 'Antioxidant Type')
			->setCellValue('W'.$i, 'Application')
			->setCellValue('X'.$i, 'Bristle/Brush Type')
			->setCellValue('Y'.$i, 'Celebrity')
			->setCellValue('Z'.$i, 'Color')
			->setCellValue('AA'.$i, 'Color Class')
			->setCellValue('AB'.$i, 'Color Retention')
			->setCellValue('AC'.$i, 'Cosmetic Color')
			->setCellValue('AD'.$i, 'Cosmetic Color Class')
			->setCellValue('AE'.$i, 'Electric Power Supply')
			->setCellValue('AF'.$i, 'Environmental')
			->setCellValue('AG'.$i, 'Enzyme Type')
			->setCellValue('AH'.$i, 'Equipment Property')
			->setCellValue('AI'.$i, 'Essential Fatty Acids Type')
			->setCellValue('AJ'.$i, 'Flavor')
			->setCellValue('AK'.$i, 'Food Attribute')
			->setCellValue('AL'.$i, 'Form')
			->setCellValue('AM'.$i, 'Fragrance Classification')
			->setCellValue('AN'.$i, 'Fragrance Concentration')
			->setCellValue('AO'.$i, 'Fragrance Occasion')
			->setCellValue('AP'.$i, 'Fragrance Size Type')
			->setCellValue('AQ'.$i, 'Gender')
			->setCellValue('AR'.$i, 'Hair Color')
			->setCellValue('AS'.$i, 'Hair Color Class')
			->setCellValue('AT'.$i, 'Hair Treatment')
			->setCellValue('AU'.$i, 'Hair Type')
			->setCellValue('AV'.$i, 'Herbal Supplement')
			->setCellValue('AW'.$i, 'Lens Correction Power')
			->setCellValue('AX'.$i, 'Lipstick Color')
			->setCellValue('AY'.$i, 'Lipstick Color Class')
			->setCellValue('AZ'.$i, 'Lotion Type')
			->setCellValue('BA'.$i, 'Mineral Type')
			->setCellValue('BB'.$i, 'Nail Polish Color')
			->setCellValue('BC'.$i, 'Nail Polish Color Class')
			->setCellValue('BD'.$i, 'Olfactive Family')
			->setCellValue('BE'.$i, 'Packaging Note')
			->setCellValue('BF'.$i, 'Protein Type')
			->setCellValue('BG'.$i, 'Quantity in Package')
			->setCellValue('BH'.$i, 'Scent')
			->setCellValue('BI'.$i, 'Scent Class')
			->setCellValue('BJ'.$i, 'Scented')
			->setCellValue('BK'.$i, 'Sexual Product Type')
			->setCellValue('BL'.$i, 'Size')
			->setCellValue('BM'.$i, 'Size (oz)')
			->setCellValue('BN'.$i, 'Skin Care')
			->setCellValue('BO'.$i, 'Skin Concern')
			->setCellValue('BP'.$i, 'Skin Tone')
			->setCellValue('BQ'.$i, 'Skin Type')
			->setCellValue('BR'.$i, 'SPF')
			->setCellValue('BS'.$i, 'Strength (Mg)')
			->setCellValue('BT'.$i, 'Styling Tool Features')
			->setCellValue('BU'.$i, 'Styling Tool Size (in.)')
			->setCellValue('BV'.$i, 'Styling Tool Type')
			->setCellValue('BW'.$i, 'Supplement Properties')
			->setCellValue('BX'.$i, 'Supplement Purpose')
			->setCellValue('BY'.$i, 'Vitamin');
			
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
			->setCellValue('C'.$i, '')
			->setCellValue('D'.$i, $registro['manuf'])
			->setCellValue('E'.$i, $codigo)
			->setCellValue('F'.$i, $registro['asin'])
			->setCellValue('G'.$i, $codigo)
			->setCellValue('H'.$i, $registro['prodname'])
			->setCellValue('I'.$i, $registro['descripcion'])
			->setCellValue('J'.$i, $registro['imagen1'])
			->setCellValue('K'.$i, $registro['imagen2'])
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
			->setCellValue('AM'.$i, $registro['prodname'])
			->setCellValue('AN'.$i, '')
			->setCellValue('AO'.$i, '')
			->setCellValue('AP'.$i, '')
			->setCellValue('AQ'.$i, '')
			->setCellValue('AR'.$i, '')
			->setCellValue('AS'.$i, '')
			->setCellValue('AT'.$i, '')
			->setCellValue('AU'.$i, '')
			->setCellValue('AV'.$i, '')
			->setCellValue('AW'.$i, '')
			->setCellValue('AX'.$i, '')
			->setCellValue('AY'.$i, '')
			->setCellValue('AZ'.$i, '')
			->setCellValue('BA'.$i, '')
			->setCellValue('BB'.$i, '')
			->setCellValue('BC'.$i, '')
			->setCellValue('BD'.$i, '')
			->setCellValue('BE'.$i, '')
			->setCellValue('BF'.$i, '')
			->setCellValue('BG'.$i, '')
			->setCellValue('BH'.$i, '')
			->setCellValue('BI'.$i, '')
			->setCellValue('BJ'.$i, '')
			->setCellValue('BK'.$i, '')
			->setCellValue('BL'.$i, '')
			->setCellValue('BM'.$i, '')
			->setCellValue('BN'.$i, '')
			->setCellValue('BO'.$i, '')
			->setCellValue('BP'.$i, '')
			->setCellValue('BQ'.$i, '')
			->setCellValue('BR'.$i, '')
			->setCellValue('BS'.$i, '')
			->setCellValue('BT'.$i, '')
			->setCellValue('BU'.$i, '')
			->setCellValue('BV'.$i, '')
			->setCellValue('BW'.$i, '')
			->setCellValue('BX'.$i, '')
			->setCellValue('BY'.$i, '');
 
      $i++;
	 	
		 }
		$codigo=$registro['amazonsku']; 
      $objPHPExcel->setActiveSheetIndex($o)
            ->setCellValue('A'.$i, $codigo)
			->setCellValue('B'.$i, $codigo)
			->setCellValue('C'.$i, '')
			->setCellValue('D'.$i, $registro['manuf'])
			->setCellValue('E'.$i, $codigo)
			->setCellValue('F'.$i, $registro['asin'])
			->setCellValue('G'.$i, $codigo)
			->setCellValue('H'.$i, $registro['prodname'])
			->setCellValue('I'.$i, $registro['descripcion'])
			->setCellValue('J'.$i, $registro['imagen1'])
			->setCellValue('K'.$i, $registro['imagen2'])
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
			->setCellValue('AM'.$i, $registro['prodname'])
			->setCellValue('AN'.$i, '')
			->setCellValue('AO'.$i, '')
			->setCellValue('AP'.$i, '')
			->setCellValue('AQ'.$i, '')
			->setCellValue('AR'.$i, '')
			->setCellValue('AS'.$i, '')
			->setCellValue('AT'.$i, '')
			->setCellValue('AU'.$i, '')
			->setCellValue('AV'.$i, '')
			->setCellValue('AW'.$i, '')
			->setCellValue('AX'.$i, '')
			->setCellValue('AY'.$i, '')
			->setCellValue('AZ'.$i, '')
			->setCellValue('BA'.$i, '')
			->setCellValue('BB'.$i, '')
			->setCellValue('BC'.$i, '')
			->setCellValue('BD'.$i, '')
			->setCellValue('BE'.$i, '')
			->setCellValue('BF'.$i, '')
			->setCellValue('BG'.$i, '')
			->setCellValue('BH'.$i, '')
			->setCellValue('BI'.$i, '')
			->setCellValue('BJ'.$i, '')
			->setCellValue('BK'.$i, '')
			->setCellValue('BL'.$i, '')
			->setCellValue('BM'.$i, '')
			->setCellValue('BN'.$i, '')
			->setCellValue('BO'.$i, '')
			->setCellValue('BP'.$i, '')
			->setCellValue('BQ'.$i, '')
			->setCellValue('BR'.$i, '')
			->setCellValue('BS'.$i, '')
			->setCellValue('BT'.$i, '')
			->setCellValue('BU'.$i, '')
			->setCellValue('BV'.$i, '')
			->setCellValue('BW'.$i, '')
			->setCellValue('BX'.$i, '')
			->setCellValue('BY'.$i, '');
 
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