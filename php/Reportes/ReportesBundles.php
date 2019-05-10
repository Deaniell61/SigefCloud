<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../coneccion.php');
$idioma=idiomaC();
include('../idiomas/'.$idioma.'.php');
session_start(); 

   
 #$squery = "SELECT mastersku,amazonsku,prodname,asin,unitcase,unitbundle,cospri,fbaordhanf,fbapicpacf,fbaweihanf,fbainbshi,pacmat,shipping,subtotfbac,netrevoves,basmar,basmarin,fbareffeeo,sugsalpri,marovesugp,maroveitec,salprionsi,comsalpri,sugsalpric,incovesugs,marovessp,bununipri,fbarefossp,marovecoss,netrevossp,marminsalp,marmaxsalp,minpri,maxpri,cant,cantidad,psite FROM tra_bun_det ORDER BY amazonsku ASC";
 $squery="SELECT mastersku,prodname FROM cat_prod ORDER BY mastersku ASC";

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
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bundles.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();


?>