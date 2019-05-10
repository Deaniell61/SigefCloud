<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codempresa=$_SESSION['codEmpresa'];
$nombre=$_POST['nombre'];
$cuentaconta=$_POST['codcuentaconta'];

if($nombre==NULL)
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	
	{
		
		$sql="insert into cat_cuenconta(nombre, codcuentaconta, codempresa) values('".$nombre."', '".$cuentaconta."','".$codempresa."');";

	}
	
## ejecución de la sentencia sql

if(mysqli_query(conexion($_SESSION['pais']),$sql))
{
					
						echo "Registros Guardados";
						}
else
{
	echo "$sql";
}
}
?>