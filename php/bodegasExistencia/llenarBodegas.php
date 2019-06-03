<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$prod=$_POST['prod'];
$pais=$_POST['pais'];
$codprov=$_POST['prov'];
$periIni=$_POST['periIni'];
$periFin=$_POST['periFin'];

$retornar="";
	$sqlBodegas="select codbodega from tra_exi_pro where codprod='".$prod."' ;";
	$conP=conexion($pais);	
	$conts="";
	$cont=0;
	if($eBodegas=mysqli_query($conP,$sqlBodegas))
	{
		while($bodegas=mysqli_fetch_array($eBodegas,MYSQLI_NUM))
		{
			$cont++;
			$retornar.="
							<div id=\"".$bodegas[0].$cont."\">";
							$retornar.="<center>
								<div>
								<table id=\"tablas".$cont."\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
								
									
									<thead>
									<tr  class=\"titulo\">
										<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
										<th >".$lang[$idioma]['Codigo']."</th>
										<th>".$lang[$idioma]['ProdName']."</th>
										<th><center>".$lang[$idioma]['ingresos']."</center></th>
										<th><center>".$lang[$idioma]['egresos']."</center></th>
										<th><center>".$lang[$idioma]['Existencia']."</center></th>
										
										
									</tr> </thead>
									
								
								";
			$retornar=$retornar."<tbody>";
			
			$existencia=existenciaInicial($periIni,$prod,$bodegas[0],$pais);
			$retornar=$retornar.buscaProducto($prod,$pais);
				$sqlTabla="select e.codmovbod,e.tipomov,e.numero,e.fecha,e.obser,d.cantidad from tra_mob_enc e,tra_mob_det d where d.codmovbod=e.codmovbod and d.codprod='".$prod."' and e.codbod='".$bodegas[0]."' and (e.fecha between '".$periIni."' and '".$periFin."') order by e.tipomov,e.fecha asc,e.tipomov asc ;";
				$contar=0;
			if($ejecutaTabla=mysqli_query($conP,$sqlTabla))
			{
				if($ejecutaTabla->num_rows>0)
				{
					while($Tabla=mysqli_fetch_array($ejecutaTabla,MYSQLI_NUM))
					{
						$contar++;
							
						$ingreso="";
						$egreso="";
						if($Tabla[1]=="IB")
						{
							$ingreso=round($Tabla[5]);
							$existencia+=round($Tabla[5]);
						}
						else
						if($Tabla[1]=="SB")
						{
							$egreso=round($Tabla[5]);
							$existencia-=round($Tabla[5]);
						}
					$retornar.="<tr>
									<td hidden=\"hidden\">".$Tabla[0]."</td>
									<td>".$Tabla[1]."-".$Tabla[2]."</td>
									<td>".$Tabla[3]." - ".$Tabla[4]."</td>
									<td><center>".($ingreso)."</center></td>
									<td><center>".($egreso)."</center></td>
									<td><center>".$existencia."</center></td>
									
									
								</tr>";
							
					}
				}
				else
				{
					$retornar.="<tr><td colspan=\"8\">No hay Datos</td></tr>";
				}
			}
			else
			{
				$retornar.="<tr><td colspan=\"8\">Error en la consutla</td></tr>";
			}
				
			$retornar=$retornar."</tbody>
								</table>
								</div>
										</center><br>
									
				<script   type=\"text/javascript\">
					
				  
							   $('#tablas".$cont."').DataTable( {
									\"scrollY\": \"300px\",
									\"scrollX\": true,
									\"paging\":  true,
									\"info\":     false,
									\"order\": [[ 2, \"desc\" ]],
									\"oLanguage\":{
														\"sLengthMenu\": \" _MENU_ \",
														} 
									} );
					setInterval(function()
					{
						$('#tablas".$cont."_previous').html('Anterior');
						$('#tablas".$cont."_next').html('Siguiente');
						__('tablas".$cont."_filter').style.display='none';
					}, 500 );
					
					
					
					
				</script>
			</div>";
		}
		mysqli_close($conP);
		echo $retornar."<script>setTimeout(function(){
$( \"#tabsBodegas\" ).tabs();$('footer').css('margin-top','1%');
},200);</script>";
	}
		
function existenciaInicial($fechaFin,$prod,$bodega,$pais)
{
	$retornar=0;
	$sqlExis="select e.codmovbod,e.tipomov,e.numero,e.fecha,e.obser,d.cantidad from tra_mob_enc e,tra_mob_det d where d.codmovbod=e.codmovbod and d.codprod='".$prod."' and e.codbod='".$bodega."' and (e.fecha < '".$fechaFin."') order by e.fecha asc;";
	$conP=conexion($pais);	
	$conts="";
	$cont=0;
	if($eExis=mysqli_query($conP,$sqlExis))
	{
		while($Exis=mysqli_fetch_array($eExis,MYSQLI_NUM))
		{
			if($Exis[1]=="IB")
			{
				$retornar+=round($Exis[5]);
			}
			else
			if($Exis[1]=="SB")
			{
				$retornar-=round($Exis[5]);
			}
			
		}
		
	}
	
	mysqli_close($conP);
	return $retornar;
}

function buscaProducto($prod,$pais)
{
	$retornar="";
	$sqlProd="select mastersku,prodname,descsis from cat_prod where codprod='".$prod."' ;";
	$conP=conexion($pais);	
	$conts="";
	$cont=0;
	if($eProd=mysqli_query($conP,$sqlProd))
	{
		if($Prod=mysqli_fetch_array($eProd,MYSQLI_NUM))
		{
			$retornar= "<tr>
					<td hidden=\"hidden\">".$prod."</td>
					<td><strong>".$Prod[0]."</strong></td>
					<td><strong>".$Prod[1]."</strong></td>
					<td></td>
					<td></td>
					<td></td>
					
				  </tr>";
		}
		else
		{
			$retornar="<tr>
					<td hidden=\"hidden\">".$prod."</td>
					<td>000</td>
					<td>No se encuentra</td>
					<td></td>
					<td></td>
					<td></td>
					
				  </tr>";
		}
	}
	
	mysqli_close($conP);
	return $retornar;
}

				
				
?>
