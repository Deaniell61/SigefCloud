<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$usuario=strtoupper($_POST['usuario']);
$empresa=strtoupper($_POST['empresa']);
$modulo=strtoupper($_POST['modulo']);
$cod=sys2015();
$squery="delete from sigef_accesos where codempresa='$empresa' and codusua='$usuario' and codmodu='$modulo'";

$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					echo "<span>".$lang[$idioma]['ModuloEliminado']."</span>";
				}
				else
				{
					echo "<span>Error</span>";
				}
?>