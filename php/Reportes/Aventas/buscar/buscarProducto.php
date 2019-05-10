<?php 
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../../../fecha.php');
require_once('../../../coneccion.php');
$idioma=idioma();
include('../../../idiomas/'.$idioma.'.php');
verTiempo();
session_start();

$codigo=$_POST['codigo'];
$_SESSION['pais']=$_POST['pais'];
$_SESSION['codpais']=$_POST['codpais'];

switch($_POST['tipo'])
{
	case '1':
	{
		buscarForm($codigo);
		break;
	}
	case '2':
	{
		tablaOrden($codigo,$_SESSION['pais']);
		break;
	}
	case '3':
	{
		tablaCargoOrden($codigo,$_SESSION['pais']);
		break;
	}
}

function buscarForm($codigo)
{
	$squery="select orderid, 
					timoford, 
					grandtotal, 
					orderunits, 
					ordsou, 
					tranum,
					codorden,
					shifee,
					shicar,
					firstname,
					lastname,
					shipcity,
					shipstate from tra_ord_enc where orderid='".$codigo."'";
	/*$squery="select productid,
					linetotal,
					disnam,
					qty,
					codorden from tra_ord_det where productid='".$codigo."' order by codorden;";
	*/	if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					if(file_exists('../../../images/iconosSeller/Channel_'.$row['4'].'.png'))
						{
							$canal='../../../images/iconosSeller/Channel_'.$row['4'].'.png';
						}
						else
						{
							$canal='../../../images/iconosSeller/Channel_Local_Store.png';
						}
						
						if(strtoupper($row['8'])=="USPS")
						{
							$link="https://tools.usps.com/go/TrackConfirmAction.action?tRef=fullpage&tLc=1&text28777=&tLabels=".$row['5']."\' target=\'_blank\'";
						}
						else
						if(strtoupper($row['8'])=="FEDEX")
						{
							$link="https://www.fedex.com/apps/fedextrack/?action=track&cntry_code=us&tracknumber_list=".$row['5']."&language=english\' target=\'_blank\'";
						}
						else
						if(strtoupper($row['8'])=="UPS")
						{
							$link="https://wwwapps.ups.com/WebTracking/processRequest?tracknums_displayed=1&TypeOfInquiryNumber=T&InquiryNumber1=".$row['5']."\' target=\'_blank\'";
						}
						else
						{
							$link="#'";
						}
					echo "<script>
										document.getElementById('codigo').value='".$row['6']."';
										document.getElementById('timoford').value='".$row['1']."';
										document.getElementById('grandtotal').value='".toMoney(round($row['2'],5,2))."';
										document.getElementById('numeroOrden').innerHTML='".$row['0']."';
										document.getElementById('numeroTraking').innerHTML='<a href=\'".$link.">".($row['5'])."</a>';
										document.getElementById('logoLocation').src='".$canal."';
										document.getElementById('shipping').value='".toMoney(round($row['7'],5,2))."';
										document.getElementById('Nombre').innerHTML='".$row['9']." ".$row['10']."';
										document.getElementById('Estado').innerHTML='".$row['11'].", ".$row['12']."';
										
										
										
										
									</script>
							";
				}
			}
		}
}

function tablaOrden($codigo,$pais)
{
	require_once('../../../fecha.php');
	$idioma=idioma();
	include('../../../idiomas/'.$idioma.'.php');
	
		echo"<table id=\"tablas\" style=\"text-aling:left;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th width=\"2%\" class=\"check\"><img src=\"../../images/yes.jpg\"/></th>
					<th width=\"0%\" hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th width=\"10%\" >".$lang[$idioma]['productid']."</th>
					<th width=\"2%\"></th>
					<th width=\"50%\">".$lang[$idioma]['disnam']."</th>
                    <th width=\"8%\">".$lang[$idioma]['qty']."</th>
                    <th width=\"5%\">".$lang[$idioma]['oriunipri']."</th>
					<th width=\"5%\">".$lang[$idioma]['linetotal']."</th>
					
					
                </tr> </thead>";
	$squer="select d.productid, 
				   d.disnam, 
				   d.qty, 
				   d.oriunipri, 
				   d.linetotal,
				   (select e.ordsou from tra_ord_enc e where e.codorden=d.codorden) from tra_ord_det d where d.codorden=(select codorden from tra_ord_enc where productid='".$codigo."' limit 1)";			
	$retornar="";
	
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion($pais),$squer);
			if($ejecutar)
			{
				if($ejecutar->num_rows>0)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						
						if(file_exists('../../../images/iconosSeller/Channel_'.$row['5'].'.png'))
						{
							$canal='../../../images/iconosSeller/Channel_'.$row['5'].'.png';
						}
						else
						{
							$canal='../../../images/iconosSeller/Channel_Local_Store.png';
						}
						$contador++;
						
						$retornar=$retornar."<tr >
								<td width=\"2%\"><input type=\"checkbox\" id=\"".strtoupper($row['0'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['0'])."').value)\"  value=\"".strtoupper($row['0'])."\" /></td>
								<td width=\"0%\" hidden=\"hidden\">".($row['0'])."</td>
								<td width=\"10%\">".($row['0'])."</td>
								<td width=\"2%\"><center><img src=\"".$canal."\" id=\"logoLocation\" style=\"width:20px; height:20px;\"/></center></td>
								<td width=\"50%\">".($row['1'])."</td>
								<td width=\"8%\"><center>".number_format($row['2'])."</center></td>
								<td width=\"5%\"><center>".toMoney(round($row['3'],5,2))."</center></td>
								<td width=\"5%\"><center>".toMoney(round($row['4'],5,2))."</center></td>
								
								
							  </tr>";
					
					}
				}
				else
				{
					
				}
						mysqli_close(conexion($pais));
					
			}
				else
				{	
					$retornar="Error de llenado de tabla";
				}
					$retornar=$retornar."</tbody></table>		
			
		   
		   <script>setTimeout(configuraTabla,100);</script>";
				
				echo $retornar;
	
}

function tablaCargoOrden($codigo,$pais)
{
	require_once('../fecha.php');
	$idioma=idioma();
	include('../idiomas/'.$idioma.'.php');
	
		echo"<table id=\"tablas2\" style=\"text-aling:left;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th width=\"2%\" style=\"height:5px; padding:5px;\" class=\"check\"><img height=\"20px\" src=\"../../images/yes.jpg\"/></th>
					<th width=\"0%\" style=\"height:5px; padding:5px;\" hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th width=\"25%\" style=\"height:5px; padding:5px;\" >".$lang[$idioma]['Cargo']."</th>
					
					<th width=\"25%\" style=\"height:5px; padding:5px;\"><center>".$lang[$idioma]['linetotal']."</center></th>
					
					
					
					
					
                </tr> </thead>";
	$squerG="select codcargo,nombre,precio from cat_car_proyecto where estatus=1";			
	$retornar="";
	
	$retornar=$retornar."<tbody>";
	$ejecutarG=mysqli_query(conexion(''),$squerG);
			if($ejecutarG)
			{
				if($ejecutarG->num_rows>0)
				{
					$total=0;
					
					while($rowG=mysqli_fetch_array($ejecutarG,MYSQLI_NUM))
					{
						
						$squer="select coddocto,valor from tra_bit_cobro where codcargo='".$rowG['0']."' and coddocto=(select codorden from tra_ord_enc where orderid='".$codigo."' limit 1)";			
							
							
							
							$ejecutar=mysqli_query(conexion($pais),$squer);
									if($ejecutar)
									{
										if($ejecutar->num_rows>0)
										{
											$contador=0;
											while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
											{
						
						
						$contador++;
						
						$retornar=$retornar."<tr >
								<td width=\"2%\"><input type=\"checkbox\" id=\"".strtoupper($row['0'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['0'])."').value)\"  value=\"".strtoupper($row['0'])."\" /></td>
								<td width=\"0%\" hidden=\"hidden\">".($row['0'])."</td>
								<td width=\"25%\">".utf8_encode($rowG['1'])."</td>
								
								<td width=\"20%\"><center>".toMoney(round($row['1'],5,2))."</center></td>
								
								
								
								
							  </tr>";
							  $total=$total+$row['1'];
											}
										}
									}
					
					}
				}
				else
				{
					
				}
						mysqli_close(conexion($pais));
					
			}
				else
				{	
					$retornar="Error de llenado de tabla";
				}
					$retornar=$retornar."</tbody></table>		
			
		   
		   <script>setTimeout(configuraTabla2,100);
		   document.getElementById('totalCatgos').innerHTML='".$lang[$idioma]['TotalDiaCargo']." ".toMoney($total)."';
							
		   </script>";
				
				echo $retornar;
	
}
?>
        
       