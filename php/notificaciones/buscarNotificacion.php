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


	$squery="select notifica,condicion,destino,fechaini,fechafin,estatus from cat_notificaciones where codnoti='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					echo "<script>
										document.getElementById('codigo').value='".$codigo."';
										document.getElementById('notifica').value='".$row['0']."';
										document.getElementById('condicion').value='".$row['1']."';
										document.getElementById('destino').value='".$row['2']."';
										document.getElementById('fechaini').value='".$row['3']."';
										document.getElementById('fechafin').value='".$row['4']."';
										document.getElementById('estado').value='".$row['5']."';
										
										
									</script>
							";
				}
			}
		}

?>
        
       