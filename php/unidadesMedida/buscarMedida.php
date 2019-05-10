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


	$squery="select nombre,abre,factor,opera from cat_uni_peso where codunipeso='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					if($row['3']=="+")
					{
						$opera="mas";
					}
					else
					{
						$opera=$row['3'];
					}
					
					echo "<script>
										document.getElementById('codigo').value='".$codigo."';
										document.getElementById('nombre').value='".$row['0']."';
										document.getElementById('abre').value='".$row['1']."';
										document.getElementById('factor').value='".$row['2']."';
										document.getElementById('opera').value='".$opera."';
										
										
									</script>
							";
				}
			}
		}

?>
        
       