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
$canal=$_GET['param'];
   
 $squery = "SELECT tr.mastersku as mastersku,tr.amazonsku as amazonsku,tr.prodname as prodname,tr.asin as asin,tr.unitcase as unitcase,tr.unitbundle as unitbundle,tr.cospri,tr.fbaordhanf as fbaordhanf,tr.fbapicpacf as fbapicpacf,tr.fbaweihanf as fbaweihanf,tr.fbainbshi as fbainbshi,tr.pacmat as pacmat,tr.shipping as shipping,tr.subtotfbac as subtotfbac,tr.netrevoves as netrevoves,tr.basmar as basmar,tr.basmarin as basmarin,tr.fbareffeeo as fbareffeeo,tr.sugsalpri as sugsalpri,tr.marovesugp as marovesugp,tr.maroveitec as maroveitec,tr.salprionsi as salprionsi,tr.comsalpri as comsalpri,tr.sugsalpric as sugsalpric,tr.incovesugs as incovesugs,tr.marovessp as marovessp,tr.bununipri as bununipri,tr.fbarefossp as fbarefossp,tr.marovecoss as marovecoss,tr.netrevossp as netrevossp,tr.marminsalp as marminsalp,tr.marmaxsalp as marmaxsalp,tr.minpri as minpri,tr.maxpri as maxpri,tr.cant,tr.cantidad,tr.psite,(SELECT channel from cat_sal_cha where codchan=tr.codcanal) as canal FROM tra_bun_det tr inner join cat_prod cp on cp.mastersku=tr.mastersku where tr.codcanal='".$canal."' ORDER BY tr.mastersku,tr.amazonsku ASC";
 
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
	
$csv_end = "  
";  
$csv_sep = "\t";  
$csv_file = "Bundles_Canal.csv";  
$csv="";  

            $csv.=$lang[ $idioma ]['MasterSKU'].$csv_sep;
			$csv.=$lang[ $idioma ]['ProdName'].$csv_sep;
			$csv.=$lang[ $idioma ]['amazonSKU'].$csv_sep;
			$csv.=$lang[ $idioma ]['Asin'].$csv_sep;
			$csv.=$lang[ $idioma ]['UnitCase'].$csv_sep;
			$csv.=$lang[ $idioma ]['unitBundle'].$csv_sep;
			$csv.=$lang[ $idioma ]['cospri'].$csv_sep;
			$csv.=$lang[ $idioma ]['pacmat'].$csv_sep;
			$csv.=$lang[ $idioma ]['shipping'].$csv_sep;
			$csv.=$lang[ $idioma ]['subtotfbac'].$csv_sep;
			$csv.=$lang[ $idioma ]['netrevoves'].$csv_sep;
			$csv.=$lang[ $idioma ]['basmar'].$csv_sep;
			$csv.=$lang[ $idioma ]['basmarin'].$csv_sep;
			$csv.=$lang[ $idioma ]['fbareffeeo'].$csv_sep;
			$csv.=$lang[ $idioma ]['sugsalpri'].$csv_sep;
			$csv.=$lang[ $idioma ]['marovesugp'].$csv_sep;
			$csv.=$lang[ $idioma ]['maroveitec'].$csv_sep;
			$csv.=$lang[ $idioma ]['salprionsi'].$csv_sep;
			$csv.=$lang[ $idioma ]['comsalpri'].$csv_sep;
			$csv.=$lang[ $idioma ]['sugsalpric'].$csv_sep;
			$csv.=$lang[ $idioma ]['incovesugs'].$csv_sep;
			$csv.=$lang[ $idioma ]['fbarefossp'].$csv_sep;
			$csv.=$lang[ $idioma ]['netrevossp'].$csv_sep;
			$csv.=$lang[ $idioma ]['marovecoss'].$csv_sep;
			$csv.=$lang[ $idioma ]['marovessp'].$csv_sep;
			$csv.=$lang[ $idioma ]['bununipri'].$csv_sep;
			$csv.=$lang[ $idioma ]['minpri'].$csv_sep;
			$csv.=$lang[ $idioma ]['marminsalp'].$csv_sep;
			$csv.=$lang[ $idioma ]['maxpri'].$csv_sep;
			$csv.=$lang[ $idioma ]['marmaxsalp'].$csv_end;
			
			
    $i=0;
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_ASSOC)) 
   {
     if($i==0)
	 { 
	   $csv.=$registro['canal'].$csv_end;
		$i++;
	 }
      
            $csv.=$registro['mastersku'].$csv_sep;
			$csv.=$registro['prodname'].$csv_sep;
			$csv.=$registro['amazonsku'].$csv_sep;
			$csv.=$registro['asin'].$csv_sep;
			$csv.=$registro['unitcase'].$csv_sep;
			$csv.=$registro['unitbundle'].$csv_sep;
			$csv.=$registro['cospri'].$csv_sep;
			$csv.=$registro['pacmat'].$csv_sep;
			$csv.=$registro['shipping'].$csv_sep;
			$csv.=$registro['subtotfbac'].$csv_sep;
			$csv.=$registro['netrevoves'].$csv_sep;
			$csv.=$registro['basmar'].$csv_sep;
			$csv.=$registro['basmarin'].$csv_sep;
			$csv.=$registro['fbareffeeo'].$csv_sep;
			$csv.=$registro['sugsalpri'].$csv_sep;
			$csv.=$registro['marovesugp'].$csv_sep;
			$csv.=$registro['maroveitec'].$csv_sep;
			$csv.=$registro['salprionsi'].$csv_sep;
			$csv.=$registro['comsalpri'].$csv_sep;
			$csv.=$registro['sugsalpric'].$csv_sep;
			$csv.=$registro['incovesugs'].$csv_sep;
			$csv.=$registro['fbarefossp'].$csv_sep;
			$csv.=$registro['netrevossp'].$csv_sep;
			$csv.=$registro['marovecoss'].$csv_sep;
			$csv.=$registro['marovessp'].$csv_sep;
			$csv.=$registro['bununipri'].$csv_sep;
			$csv.=$registro['minpri'].$csv_sep;
			$csv.=$registro['marminsalp'].$csv_sep;
			$csv.=$registro['maxpri'].$csv_sep;
			$csv.=$registro['marmaxsalp'].$csv_end;
 
      $i++;
      
   }


 

//Generamos el csv de todos los datos  
if (!$handle = fopen($csv_file, "w")) {  
    echo "Cannot open file";  
    exit;  
}  
if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
    echo "Cannot write to file";  
    exit;  
}  
 


}
fclose($handle); 

$archivo = 'Bundles_Canal.csv';

$TheFile = basename($archivo);
header('Content-Description: File Transfer');

ob_end_flush();

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename=' . $TheFile);

header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($archivo));

flush();
readfile($archivo);
unlink('Bundles_Canal.csv');
header("Location: ../../../../index.php");  


?>