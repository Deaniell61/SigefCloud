<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('../formulas.php');
require_once('combosProductos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$masterSKU=limpiar_caracteres_sql($_POST['masterSKU']);
$prodName=limpiar_caracteres_sql($_POST['prodName']);
$codBundle=limpiar_caracteres_sql($_POST['codBundle']);
$codempresa=limpiar_caracteres_sql($_POST['codempresa']); 
$amazonSKU=limpiar_caracteres_sql($_POST['amazonSKU']); 



session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];

?>
<div id="datos">
        	<?php
			echo tabla($prodName,$masterSKU,$codBundle,$amazonSKU);
            ?>                
</div>
<?php

function llamar()
{
	return 1;
}
function tabla($prodName,$masterSKU,$codBundle,$amazonSKU)
{
	
$lbundle=limpiar_caracteres_sql($_POST['lbundle']);
	$CanalDes=limpiar_caracteres_sql($_POST['canal']); 
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$altosql="(select pd.alto+(select te.alto from cat_tip_emp te where te.codpack=pd.codpack) as alto from cat_prod pd where pd.mastersku='".$masterSKU."' and pd.codprod='".$_SESSION['codprod']."')";
$anchosql="(select pd.ancho+(select te.ancho from cat_tip_emp te where te.codpack=pd.codpack) as ancho from cat_prod pd where pd.mastersku='".$masterSKU."' and pd.codprod='".$_SESSION['codprod']."')";
$largosql="(select pd.profun+(select te.largo from cat_tip_emp te where te.codpack=pd.codpack) as prof from cat_prod pd where pd.mastersku='".$masterSKU."' and pd.codprod='".$_SESSION['codprod']."')";
	$retornar="";
	$squery="select (select peso_lb*16+peso_oz from cat_prod where codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codprod='".$_SESSION['codprod']."' limit 1) as pesoOz,(select peso from cat_prod where codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codprod='".$_SESSION['codprod']."' limit 1) as peso,(select peso_lb from cat_prod where codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codprod='".$_SESSION['codprod']."' limit 1) as pesoLB,$altosql as alto,$anchosql as ancho,$largosql as largo,masterSKU,codempresa,prodName,amazondesc,unitcase,codbundle,amazonsku,asin,unitbundle,cospri,pacmat,shipping,shirate,(subtotfbac) as subtotfbac,fbaordhanf,fbapicpacf,fbaweihanf,fbainbshi,basmar,basmarin,comsalpri,bununipri,fbareffeeo,sugsalpri,marovesugp,maroveitec,salprionsi,incovesugs,fbarefossp,marovecoss,marminsalp,marmaxsalp,minpri,maxpri,cant,cantidad,psite,pcompe,psuger,tipo,upc,(select channel from cat_sal_cha where codchan=codcanal) as canal,netrevoves,sugsalpric,netrevossp,marovessp from tra_bun_det where";
	if($codBundle>0)
	{
		$squery=$squery." codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and codbundle='".$codBundle."' and amazonsku='".$amazonSKU."' and codcanal='".$CanalDes."'";
	}
	else
	{
	$squery=$squery."  codempresa='".$_SESSION['codEmpresa']."' and mastersku='".$masterSKU."' and amazonsku='".$amazonSKU."' and codcanal='".$CanalDes."'";
	}
if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squery))
{
		if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
			{
				
		#style=\"overflow: auto;height: 250px;\"					#agregarParametrosBundle($row['amazonsku'],$row['unitbundle'],$row['masterSKU'],substr($row['prodName'],0,strlen($row['prodName'])-12),$row['pesoOz'],$row['pesoLB'],$row['peso'],$amazonSKU,round(intval($row['alto']),2),round(intval($row['largo']),2),round(intval($row['ancho']),2),$lbundle);	
	$lcCantidad=intval($row['unitbundle']);
	$retornar=$retornar."
	
	<center>
			<div >
        	<table id=\"tablaDatos\" width=\"100%\" cellspacing=\"2px\" cellpadding=\"0\" class=\"tablesorter\" >
				<tbody style=\"height: 250px;\">";
				
				
					$retornar=$retornar."
						<tr>
							<td class=\"titulo\">".$lang[$idioma]['amazonSKU']."</td>
							<td><input type=\"text\" style=\"width:98%;background-color: inherit; border:none; text-align:inherit;color:inherit\" value=\"".$row['amazonsku']."\" disabled id=\"bundAmSKU\" /></td>
 					    </tr>
						<tr>
							<td class=\"titulo\">".$lang[$idioma]['DescBundle']."</td>
							<td><input type=\"text\" style=\"width:98%;background-color: inherit; border:none; text-align:inherit;color:inherit\" value=\"".$row['prodName']."\" disabled id=\"bundName\" /></td>
 					    </tr>
						<tr>
							<td class=\"titulo\">".$lang[$idioma]['AmDesc']."</td>
							<td>".$row['amazondesc']."</td>
 					    </tr>
						<tr>
							<td class=\"titulo\">".$lang[$idioma]['Canales']."</td>
							<td>".$row['canal']."</td>
 					    </tr>
						<tr".existencia('unitcase',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['UnitCase']."</td>
							<td>".$row['unitcase']."</td>
 					    </tr>
						<tr".existencia('unitbundle',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['unitBundle']."</td>
							<td>".$row['unitbundle']."</td>
 					    </tr>
						<tr".existencia('cospri',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['cospri']."</td>
							<td>".$row['cospri']."</td>
 					    </tr>
						<tr".existencia('fbaordhanf',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['fbaordhanf']."</td>
							<td>".$row['fbaordhanf']."</td>
 					    </tr>
						<tr".existencia('fbapicpacf',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['fbapicpacf']."</td>
							<td>".$row['fbapicpacf']."</td>
 					    </tr>
						<tr".existencia('fbaweihanf',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['fbaweihanf']."</td>
							<td>".$row['fbaweihanf']."</td>
 					    </tr>
						<tr".existencia('fbainbshi',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['fbainbshi']."</td>
							<td>".$row['fbainbshi']."</td>
 					    </tr>
						<tr".existencia('pacmat',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['pacmat']."</td>
							<td>".$row['pacmat']."</td>
 					    </tr>
						<tr".existencia('shipping',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['shipping']."</td>
							<td>".$row['shipping']."</td>
 					    </tr>
						<tr".existencia('shirate',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['shirate']."</td>
							<td>".$row['shirate']."</td>
 					    </tr>
						<tr".existencia('subtotfbac',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['subtotfbac']."</td>
							<td>".$row['subtotfbac']."</td>
 					    </tr>
						<tr".existencia('netrevoves',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['netrevoves']."</td>
							<td>".$row['netrevoves']."</td>
 					    </tr>
						<tr".existencia('basmar',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['basmar']."</td>
							<td>".$row['basmar']."</td>
 					    </tr>
						<tr".existencia('basmarin',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['basmarin']."</td>
							<td>".$row['basmarin']."</td>
 					    </tr>
						<tr".existencia('marminsalp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['marminsalp']."</td>
							<td>".$row['marminsalp']."</td>
 					    </tr>
						<tr".existencia('marmaxsalp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['marmaxsalp']."</td>
							<td>".$row['marmaxsalp']."</td>
 					    </tr>
						<tr".existencia('fbareffeeo',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['fbareffeeo']."</td>
							<td>".$row['fbareffeeo']."</td>
 					    </tr>
						<tr".existencia('sugsalpri',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['sugsalpri']."</td>
							<td>".$row['sugsalpri']."</td>
 					    </tr>
						<tr".existencia('marovesugp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['marovesugp']."</td>
							<td>".$row['marovesugp']."</td>
 					    </tr>
						<tr".existencia('maroveitec',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['maroveitec']."</td>
							<td>".$row['maroveitec']."</td>
 					    </tr>
						<tr".existencia('salprionsi',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['salprionsi']."</td>
							<td>".$row['salprionsi']."</td>
 					    </tr>
						<tr".existencia('comsalpri',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['comsalpri']."</td>
							<td>".$row['comsalpri']."</td>
 					    </tr>
						<tr".existencia('sugsalpric',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['sugsalpric']."</td>
							<td>".$row['sugsalpric']."</td>
 					    </tr>
						<tr".existencia('incovesugs',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['incovesugs']."</td>
							<td>".$row['incovesugs']."</td>
 					    </tr>
						<tr".existencia('fbarefossp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['fbarefossp']."</td>
							<td>".$row['fbarefossp']."</td>
 					    </tr>
						<tr".existencia('netrevossp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['netrevossp']."</td>
							<td>".$row['netrevossp']."</td>
 					    </tr>
						<tr".existencia('marovessp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['marovessp']."</td>
							<td>".$row['marovessp']."</td>
 					    </tr>
						<tr".existencia('marovecoss',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['marovecoss']."</td>
							<td>".$row['marovecoss']."</td>
 					    </tr>
						<tr".existencia('bununipri',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['bununipri']."</td>
							<td>".$row['bununipri']."</td>
 					    </tr>
						<tr".existencia('minpri',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['minpri']."</td>
							<td>".$row['minpri']."</td>
 					    </tr>
						<tr".existencia('marminsalp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['marminsalp']."</td>
							<td>".$row['marminsalp']."</td>
 					    </tr>
						<tr".existencia('maxpri',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['maxpri']."</td>
							<td>".$row['maxpri']."</td>
 					    </tr>
						<tr".existencia('marmaxsalp',$CanalDes,$row['codbundle']).">
							<td class=\"titulo\">".$lang[$idioma]['marmaxsalp']."</td>
							<td>".$row['marmaxsalp']."</td>
 					    </tr>
						<tr>
							<td class=\"titulo\">".$lang[$idioma]['UPC']."</td>
							<td>".$row['upc']."</td>
 					    </tr>
						<tr>
							<td></td>
							<td><center><div id=\"codigo\"></div></center></td>
 					    </tr>
						<script>generateBarcode('".$row['upc']."');</script>
						";
					$retornar=$retornar."
				</tbody>
			</table> </div>";
			
				
			}
}				
				return $retornar;
}

function existencia($columna,$canal,$codbundle)
{
	$retorn=" hidden";
	$parametro="select tpc.codparam as codparpri,cpp.columna as columna,cpp.formula as formula,cpp.fac_val as fac_val from cat_par_pri cpp inner join tra_par_cha tpc on tpc.codparam=cpp.codparpri where cpp.columna!='' and tpc.codcanal='".$canal."' and columna='".strtoupper($columna)."' order by cpp.orden ";
			if($ejecutarParametro=mysqli_query(conexion($_SESSION['pais']),$parametro))				
				{	
					if(mysqli_num_rows($ejecutarParametro)>0)
					{
						if($rowParametro=mysqli_fetch_array($ejecutarParametro,MYSQLI_ASSOC))
						{
							$retorn="";
						}
					}
					
					
				}
	return $retorn;
}

?>

    

