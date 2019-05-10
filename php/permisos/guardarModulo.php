<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$usuario=strtoupper($_POST['usuario']);
$empresa=strtoupper($_POST['empresa']);
$modulo=strtoupper($_POST['modulo']);
$cod=sys2015();
$squery="insert into sigef_accesos values('".$cod."','$empresa','$usuario','$modulo','','','','','','')";

$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					echo "<span>".$lang[$idioma]['ModuloGuardado']."</span>";
				}
				else
				{
					echo "<span>Error</span>";
				}
?>