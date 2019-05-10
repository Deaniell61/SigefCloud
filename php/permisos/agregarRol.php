<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
require_once('../idiomas/'.$idioma.'.php');

$usuario=strtoupper($_POST['usuario']);
$empresa=strtoupper($_POST['empresa']);
$acempresa=strtoupper($_POST['acempresa']);
$rol=$_POST['rol'];

$squery="update acempresas set rol='$rol' where codacempr='$acempresa' and codusua='$usuario' and codempresa='$empresa'";

$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					$res="";
					if($rol==1)
					{
					$res="<span>Rol: ".$lang[$idioma]['AccesosTotal']."</span>";
					}
					if($rol==2)
					{
					$res="<span>Rol: ".$lang[$idioma]['AccesosModificar']."</span>";
					}
					if($rol==3)
					{
					$res="<span>Rol: ".$lang[$idioma]['AccesosReporteria']."</span>";
					}
					if($rol==4)
					{
					$res="<span>Rol: ".$lang[$idioma]['AccesosVisor']."</span>";
					}
					echo $res;
				}
				else
				{
					echo "<span>Error</span>";
				}
?>