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
	
$file=fopen("Bundles_Canal.txt","a") or die("Problemas");
  $lin="";
 /* fputs($file,"primera linea");
  fputs($file,"\n");
  fputs($file,"segunda linea");
  fputs($file,"\n");
  fputs($file,"tercera linea");

  fclose($file);*/
	


            $lin.=$lang[ $idioma ]['MasterSKU']." - ";
			$lin.=$lang[ $idioma ]['ProdName']." - ";
			$lin.=$lang[ $idioma ]['amazonSKU']." - ";
			$lin.=$lang[ $idioma ]['Asin']." - ";
			$lin.=$lang[ $idioma ]['UnitCase']." - ";
			$lin.=$lang[ $idioma ]['unitBundle']." - ";
			$lin.=$lang[ $idioma ]['cospri']." - ";
			$lin.=$lang[ $idioma ]['pacmat']." - ";
			$lin.=$lang[ $idioma ]['shipping']." - ";
			$lin.=$lang[ $idioma ]['subtotfbac']." - ";
			$lin.=$lang[ $idioma ]['netrevoves']." - ";
			$lin.=$lang[ $idioma ]['basmar']." - ";
			$lin.=$lang[ $idioma ]['basmarin']." - ";
			$lin.=$lang[ $idioma ]['fbareffeeo']." - ";
			$lin.=$lang[ $idioma ]['sugsalpri']." - ";
			$lin.=$lang[ $idioma ]['marovesugp']." - ";
			$lin.=$lang[ $idioma ]['maroveitec']." - ";
			$lin.=$lang[ $idioma ]['salprionsi']." - ";
			$lin.=$lang[ $idioma ]['comsalpri']." - ";
			$lin.=$lang[ $idioma ]['sugsalpric']." - ";
			$lin.=$lang[ $idioma ]['incovesugs']." - ";
			$lin.=$lang[ $idioma ]['fbarefossp']." - ";
			$lin.=$lang[ $idioma ]['netrevossp']." - ";
			$lin.=$lang[ $idioma ]['marovecoss']." - ";
			$lin.=$lang[ $idioma ]['marovessp']." - ";
			$lin.=$lang[ $idioma ]['bununipri']." - ";
			$lin.=$lang[ $idioma ]['minpri']." - ";
			$lin.=$lang[ $idioma ]['marminsalp']." - ";
			$lin.=$lang[ $idioma ]['maxpri']." - ";
			$lin.=$lang[ $idioma ]['marmaxsalp']."\n\n";
			
			
    $i=0;
   while ($registro = mysqli_fetch_array($resultado,MYSQLI_ASSOC)) 
   {
     if($i==0)
	 { 
	   $lin.=$registro['canal']."\n\n";
		$i++;
	 }
      
            $lin.=$registro['mastersku']." - ";
			$lin.=$registro['prodname']." - ";
			$lin.=$registro['amazonsku']." - ";
			$lin.=$registro['asin']." - ";
			$lin.=$registro['unitcase']." - ";
			$lin.=$registro['unitbundle']." - ";
			$lin.=$registro['cospri']." - ";
			$lin.=$registro['pacmat']." - ";
			$lin.=$registro['shipping']." - ";
			$lin.=$registro['subtotfbac']." - ";
			$lin.=$registro['netrevoves']." - ";
			$lin.=$registro['basmar']." - ";
			$lin.=$registro['basmarin']." - ";
			$lin.=$registro['fbareffeeo']." - ";
			$lin.=$registro['sugsalpri']." - ";
			$lin.=$registro['marovesugp']." - ";
			$lin.=$registro['maroveitec']." - ";
			$lin.=$registro['salprionsi']." - ";
			$lin.=$registro['comsalpri']." - ";
			$lin.=$registro['sugsalpric']." - ";
			$lin.=$registro['incovesugs']." - ";
			$lin.=$registro['fbarefossp']." - ";
			$lin.=$registro['netrevossp']." - ";
			$lin.=$registro['marovecoss']." - ";
			$lin.=$registro['marovessp']." - ";
			$lin.=$registro['bununipri']." - ";
			$lin.=$registro['minpri']." - ";
			$lin.=$registro['marminsalp']." - ";
			$lin.=$registro['maxpri']." - ";
			$lin.=$registro['marmaxsalp']."\n";
 
      $i++;
      
   }
   fputs($file,$lin);
}
fclose($file);
$archivo = 'Bundles_Canal.txt';

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
unlink('Bundles_Canal.txt');
header("Location: ../../../../index.php");  


?>