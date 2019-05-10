<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

switch($_POST['asig'])
{
	case 1:
	{
		$usuario=strtoupper($_POST['usuario']);
		$empresa=strtoupper($_POST['empresa']);
		$empresa2=strtoupper($_POST['empresa2']);
		$cod=sys2015();
		$squery="insert into acprov(codacprov,codusua,codprov,codempresa) values('".$cod."','$usuario','$empresa','$empresa2')";
		$mensaje=$lang[ $idioma ]['ProveedorAsignada'];
		break;
	}
	case 2:
	{
		$usuario=strtoupper($_POST['usuario']);
		$empresa=strtoupper($_POST['empresa']);
		$empresa2=strtoupper($_POST['empresa2']);
		$squery="delete from acprov where codusua='$usuario' and codprov='$empresa' and codempresa='$empresa2'";
		$mensaje=$lang[ $idioma ]['ProveedorDesAsignada'];
		break;
	}

}
$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					echo "<span>".$mensaje."</span>";
				}
				else
				{
					echo "<script>alert(\"$squery\");</script>";
				}
			
?>