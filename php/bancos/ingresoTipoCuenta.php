<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosBancos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codempresa=$_SESSION['codEmpresa'];
$nombre=$_POST['nombre'];

if($nombre==NULL)
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	
	{
		
		$sql="insert into cat_tcuen(nombre, codtcuen) values('".$nombre."', '".sys2015()."');";
		
	}
	
## ejecución de la sentencia sql

if(mysqli_query(conexion($_SESSION['pais']),$sql))
{
					
						echo 1;
						}
else
{
	echo "$sql";
}
}
?>
