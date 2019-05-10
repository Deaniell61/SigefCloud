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

$dato[0]=$pla=$_POST['pla'];
$dato[1]=$db=$_POST['db'];
$dato[2]=$tipo=$_POST['tipo'];
$dato[3]=$campo=strtoupper($_POST['campo']);
$dato[4]=$tabla=($_POST['tabla']);
$dato[5]=$tam=$_POST['tam'];
$dato[6]=$nullll=$_POST['nullll'];
$dato[7]=$AutoNum=$_POST['AutoNum'];
$dato[8]=$pk=$_POST['pk'];
$dato[9]=$existe=$_POST['existe'];
$dato[11]=$existeC=$_POST['existeC'];
$dato[12]=$existeN=$_POST['existeN'];
$dato[13]=$nuevoCampo=$_POST['nuevoCampo'];
$squery="";

		if($nullll=='true')
		{
			$null="";
		}
		else
		{
			$null="NOT NULL";
		}
		
		if($pk=='true')
		{
			$pk1="PRIMARY KEY";
		}
		else
		{
			$pk1="";
		}
		
		if($AutoNum=='true')
		{
			$autonum1="AUTO_INCREMENT";
		}
		else
		{
			$autonum1="";
		}
		
		if($tam!="")
		{
			$tam="(".$tam.")";
		}

{
	if($db=='1')
	{
		
		if($existe=='true')
		{
			if($existeC=='true')
			{
				if($existeN=='true')
				{
					$squery="ALTER TABLE ".$tabla." CHANGE ".$campo." ".$nuevoCampo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.";";
				}
				else
				{
					$squery="alter table ".$tabla." modify ".$campo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.";";
				}
			}
			else
			{
				$squery="alter table ".$tabla." add ".$campo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.";";
			}
		}
		else
		{
			$squery="create table ".$tabla."(".$campo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.");";
		}
		$datos=obtenerDatos("");
		$con = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($pla).'sigef');
		//echo 'quintoso_'.strtolower($pla).'sigef';
		
			$dato[10]=$squery;
		mysqli_query($con,"BEGIN");
				
			if($ejecuta=mysqli_query($con,$squery))
			{
				
						mysqli_query($con,"COMMIT");
						$ret= "
								Columna ingresada Exitosamente!
								<script>
										
		document.getElementById('existe').checked=true;
											
								";
						if($existeC=='true')
						{
							$ret.="
							
							document.getElementById('existeC').checked=true;
							document.getElementById('campo').value = '".$campo."';
							limpiarAdminDB();
							cargaColumna(document.getElementById('existe'));";
						}
						else{
							$ret.="
							limpiarAdminDB();
							cargaColumna(document.getElementById('existe'));";
						}
						$ret.="
									
										</script>";
						echo $ret;
						agregar($dato);
				mysqli_close($con);
			}
			else
			{
				echo "Error".$squery;
				mysqli_query($con,"ROLLBACK");
				
			}
	}
	else if($db=='2')
	{
		if($existe=='true')
		{
			if($existeC=='true')
			{
				if($existeN=='true')
				{
					$squery="ALTER TABLE ".$tabla." CHANGE ".$campo." ".$nuevoCampo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.";";
				}
				else
				{
					$squery="alter table ".$tabla." modify ".$campo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.";";
				}
			}
			else
			{
				$squery="alter table ".$tabla." add ".$campo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.";";
			}
		}
		else
		{
			$squery="create table ".$tabla."(".$campo." ".$tipo."".$tam." ".$null." ".$autonum1." ".$pk1.");";
		}
	
	$dato[10]=$squery;
		$datos=obtenerDatos("");
		$con = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($pla).'sigef');

	if($ejecutar=mysqli_query($con,"select codigo from cat_empresas"))
		{
		if($ejecutar->num_rows>0)
			{
				
				while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
				{
					if(strlen($row[0])==1)
					{
						$cod="0".$row[0];
						
					}
					else
					{
						$cod=$row[0];
					}
					$con2 = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($pla).'sigef'.$cod);
					mysqli_query($con2,"BEGIN");
							
						if($ejecuta=mysqli_query($con2,$squery))
						{
							
									mysqli_query($con2,"COMMIT");
									
							mysqli_close($con2);
						}
						else
						{
							echo "Error".$squery;
							mysqli_query($con2,"ROLLBACK");
							
						}
				}
					$ret= "
								Columna ingresada Exitosamente!
								<script>
										
		document.getElementById('existe').checked=true;
											
								";
						if($existeC=='true')
						{
							$ret.="
							
							document.getElementById('existeC').checked=true;
							document.getElementById('campo').value = '".$campo."';
							limpiarAdminDB();
							cargaColumna(document.getElementById('existe'));";
						}
						else{
							$ret.="
							limpiarAdminDB();
							cargaColumna(document.getElementById('existe'));";
						}
						$ret.="
									
										</script>";
						echo $ret;
									agregar($dato);
			}
		}
	}
}

function agregar($datos)
{
	$file = 'log.txt';

	$person = "".date('Y-m-d').",".$_SESSION['user'].",".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$datos[4].",".$datos[5].",".$datos[10]."\n";

	file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
}

?>
