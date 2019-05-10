<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$usuario=strtoupper($_POST['usuario']);
$empresa=strtoupper($_POST['empresa']);

$squery="delete from acempresas where codusua='$usuario' and codempresa='$empresa'";

$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					echo "<span>".$lang[ $idioma ]['EmpresaDesAsignada']."</span>";
				}
				else
				{
					echo "<script>alert(\"Error de asignacion\");</script>";
				}
?>