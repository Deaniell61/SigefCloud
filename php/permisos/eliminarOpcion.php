<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$usuario=strtoupper($_POST['usuario']);
$empresa=strtoupper($_POST['empresa']);
$modulo=strtoupper($_POST['modulo']);
$actua=$_POST['actua'];
$squery="update sigef_accesos set $actua=0 where codempresa='$empresa' and codusua='$usuario' and codModu='$modulo'";

$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					echo "<span>".$lang[$idioma]['OpcionEliminada']."</span>";
				}
				else
				{
					echo "<span>Error</span>";
				}
?>