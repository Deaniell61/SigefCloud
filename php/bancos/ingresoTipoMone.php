<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codempresa=$_SESSION['codEmpresa'];
$nombre=$_POST['nombre'];
$moneda=$_POST['moneda'];

if($nombre==NULL)
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	
	{
		
		$sql="insert into cat_tipomone(codmone, nombre, moneda) values('".sys2015()."','".$nombre."', '".$moneda."');";

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