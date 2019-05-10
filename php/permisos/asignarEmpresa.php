<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

$usuario=strtoupper($_POST['usuario']);
$empresa=strtoupper($_POST['empresa']);
$cod=sys2015();
$squery="insert into acempresas(codacempr,codusua,codempresa,nombre) values('".$cod."','$usuario','$empresa','$usuario-$empresa')";

$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					echo "<span>".$lang[ $idioma ]['EmpresaAsignada']."</span><script>abrirAsignacionModulos('$cod','$usuario','$empresa');</script>";
				}
				else
				{
					echo "<script>alert(\"Error de asignacion\");</script>";
				}
?>