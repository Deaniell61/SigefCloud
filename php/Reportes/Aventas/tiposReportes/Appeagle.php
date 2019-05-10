<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../../coneccion.php');
require_once('../../../fecha.php');
require_once('../../../funciones.php');
$idioma=idiomaC();
include('../../../idiomas/'.$idioma.'.php');
session_start(); 

$codigoEmpresa = $_SESSION['codEmpresa'];
$prov = "";
$extra = "";

$canal= $_GET['param'];

$pais=$_SESSION['pais'];


	$squery = "SELECT tr.mastersku as mastersku,tr.amazonsku as amazonsku,tr.prodname as prodname,tr.asin as asin,tr.unitcase as unitcase,tr.unitbundle as unitbundle,tr.cospri,tr.fbaordhanf as fbaordhanf,tr.fbapicpacf as fbapicpacf,tr.fbaweihanf as fbaweihanf,tr.fbainbshi as fbainbshi,tr.pacmat as pacmat,tr.shipping as shipping,tr.subtotfbac as subtotfbac,tr.netrevoves as netrevoves,tr.basmar as basmar,tr.basmarin as basmarin,tr.fbareffeeo as fbareffeeo,tr.sugsalpri as sugsalpri,tr.marovesugp as marovesugp,tr.maroveitec as maroveitec,tr.salprionsi as salprionsi,tr.comsalpri as comsalpri,tr.sugsalpric as sugsalpric,tr.incovesugs as incovesugs,tr.marovessp as marovessp,tr.bununipri as bununipri,tr.fbarefossp as fbarefossp,tr.marovecoss as marovecoss,tr.netrevossp as netrevossp,tr.marminsalp as marminsalp,tr.marmaxsalp as marmaxsalp,tr.minpri as minpri,tr.maxpri as maxpri,tr.cant,tr.cantidad,tr.psite,(SELECT channel from cat_sal_cha where codchan=tr.codcanal) as canal FROM tra_bun_det tr inner join cat_prod cp on cp.mastersku=tr.mastersku where tr.codcanal='".$canal."' ORDER BY tr.mastersku,tr.amazonsku ASC";
	$squery = "SELECT tr.mastersku as mastersku,tr.amazonsku as amazonsku,tr.prodname as prodname,tr.asin as asin,tr.unitcase as unitcase,tr.unitbundle as unitbundle,tr.cospri,tr.fbaordhanf as fbaordhanf,tr.fbapicpacf as fbapicpacf,tr.fbaweihanf as fbaweihanf,tr.fbainbshi as fbainbshi,tr.pacmat as pacmat,tr.shipping as shipping,tr.subtotfbac as subtotfbac,tr.netrevoves as netrevoves,tr.basmar as basmar,tr.basmarin as basmarin,tr.fbareffeeo as fbareffeeo,tr.sugsalpri as sugsalpri,tr.marovesugp as marovesugp,tr.maroveitec as maroveitec,tr.salprionsi as salprionsi,tr.comsalpri as comsalpri,tr.sugsalpric as sugsalpric,tr.incovesugs as incovesugs,tr.marovessp as marovessp,tr.bununipri as bununipri,tr.fbarefossp as fbarefossp,tr.marovecoss as marovecoss,tr.netrevossp as netrevossp,tr.marminsalp as marminsalp,tr.marmaxsalp as marmaxsalp,tr.minpri as minpri,tr.maxpri as maxpri,tr.cant,tr.cantidad,tr.psite,(SELECT channel from cat_sal_cha where codchan=tr.codcanal) as canal FROM tra_bun_det tr inner join cat_prod cp on cp.mastersku=tr.mastersku where tr.codcanal='".$canal."' ORDER BY tr.mastersku,tr.amazonsku ASC";
	

 $con = conexion($_SESSION['pais']);
 	$qBundle="select tr.amazonsku,te.existencia,tr.asin,tr.prodname,tr.minpri,tr.maxpri,tr.sugsalpric from tra_bun_det tr inner join cat_prod c on c.mastersku=tr.mastersku inner join tra_exi_pro te on te.codprod=c.codprod where tr.codcanal='".$canal."' group by tr.amazonsku ;";
 	
 
	 

 if (intval(getCountArrayBD($qBundle,$con))>=0) 
{
   require_once ('../../../lib/PHPExcel/PHPExcel.php');
	
   $csv_end = "  
";  
$csv_sep = "\t";  
$csv_file = "Bundles_Canal.csv";  
$csv="";  

            $csv.='SKU'.$csv_sep;
			$csv.='INVENTORY'.$csv_sep;
			$csv.='LIVE_INVENTORY'.$csv_sep;
			$csv.='ITEM_ID'.$csv_sep;
			$csv.='MEMO'.$csv_sep;
			$csv.='TITLE'.$csv_sep;
			$csv.='GROUP_NAME'.$csv_sep;
			$csv.='GROUP_INVENTORY'.$csv_sep;
			$csv.='MARKETPLACE_ID'.$csv_sep;
			$csv.='COST'.$csv_sep;
			$csv.='CURRENCY'.$csv_sep;
			$csv.='MIN_PRICE'.$csv_sep;
			$csv.='MAX_PRICE'.$csv_sep;
			$csv.='CURRENT_PRICE'.$csv_sep;
			$csv.='CURRENT_SHIPPING'.$csv_sep;
			$csv.='MANUAL_PRICE'.$csv_sep;
			$csv.='ORIGINAL_PRICE'.$csv_sep;
			$csv.='MAP_PRICE'.$csv_sep;
			$csv.='HANDLING_DAYS'.$csv_sep;
			$csv.='LISTING_TYPE'.$csv_sep;
			$csv.='STRATEGY_ID'.$csv_end;
			
			
    $i=0;
	$rBundle=getArrayBD($qBundle,$con);
   foreach ($rBundle as $registro) 
   {
           
			$csv.=$registro['amazonsku'].$csv_sep;
			$csv.=$registro['existencia'].$csv_sep;
			$csv.=$registro['existencia'].$csv_sep;
			$csv.=$registro['asin'].$csv_sep;
			$csv.='-'.$csv_sep;
			$csv.=$registro['prodname'].$csv_sep;
			$csv.='-'.$csv_sep;
			$csv.='-'.$csv_sep;
			$csv.='9914'.$csv_sep;
			$csv.='-'.$csv_sep;
			$csv.='-'.$csv_sep;
			$csv.=$registro['minpri'].$csv_sep;
			$csv.=$registro['maxpri'].$csv_sep;
			$csv.=$registro['sugsalpric'].$csv_sep;
			$csv.='0'.$csv_sep;
			$csv.=$registro['sugsalpric'].$csv_sep;
			$csv.=$registro['sugsalpric'].$csv_sep;
			$csv.='-'.$csv_sep;
			$csv.='-'.$csv_sep;
			$csv.='Amazon MFN'.$csv_sep;
			$csv.='31327'.$csv_end;
 
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
unlink('Bundles_SiteOnline.csv');
header("Location: ../../../../index.php");   

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