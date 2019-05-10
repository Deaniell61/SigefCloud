<?php 
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
verTiempo();
session_start();

$codigo=$_POST['codigo'];
$_SESSION['pais']=$_POST['pais'];
$_SESSION['codpais']=$_POST['codpais'];


	$squery="select te.asunto,CAST(te.fecha_ini AS DATE),CAST(te.fecha_fin AS DATE),te.estatus,te.codticket,te.numticket,te.emailusua from tra_ticket_enc te where te.codticket='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					echo "<script>
										document.getElementById('codigo').value='".$codigo."';
										document.getElementById('asunto').value='".$row['0']."';
										document.getElementById('numticket').value='".$row['5']."';
										document.getElementById('descripcionTodos').innerHTML='".descripciones($codigo)."';
										document.getElementById('fechaini').value='".$row['1']."';
										document.getElementById('fechafin').value='".$row['2']."';
										document.getElementById('estado').value='".$row['3']."';
										document.getElementById('email').value='".$row['6']."';
										
										
										
									</script>
							";
				}
			}
		}
		mysqli_close(conexion($_SESSION['pais']));


function descripciones($codigo)
{
	require_once('../coneccion.php');
	
	$squery="select descripcion,fecha,usuario from tra_ticket_det where codticket='".$codigo."' order by fecha desc";
	$retorna="";
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					$retorna.= '<div style="text-align:left; width:200px;float:left;">'.$row['1'].'</div><div style="text-align:right; width:300px;float:right;margin-right:70px;">From: '.usuario($row['2']).'</div><br><textarea rows="5" style="text-align: left; width:calc(90%);" readonly class="entradaTexto" id="">'.strip_tags(str_replace("\n","",$row['0'])).'</textarea><br>';
				}
			}
		}
		mysqli_close(conexion($_SESSION['pais']));

	 return $retorna;
}
function usuario($codigo)
{
	require_once('../coneccion.php');
	
	$squery="select nombre,apellido from sigef_usuarios where codusua='".$codigo."'";
	$retorna="";
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					$retorna= $row['0']." ".$row['1'];
				}
			}
		}
		mysqli_close(conexion(""));

	 return $retorna;
}
?>
        
       