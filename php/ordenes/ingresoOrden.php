<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codigo=$_POST['codigo'];
$cod=$_SESSION['codPais'];
$pais=$_SESSION['pais'];
$condicion=$_POST['condicion'];
$destino=$_POST['destino'];
$fechaini=$_POST['fechaini'];
$fechafin=$_POST['fechafin'];
$notifica=$_POST['notifica'];
$estatus=$_POST['estatus'];
if($notifica=="" || $condicion=="" || $destino=="")
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	if($codigo=='')
	{
		$sql="insert into cat_notificaciones(notifica,fechaini,fechafin,estatus,condicion,destino) values('".$notifica."','".$fechaini."','".$fechafin."','".$estatus."','".$condicion."','".$destino."');";
	}
	else
	{
  		$sql="update cat_notificaciones set notifica='".$notifica."',fechaini='".$fechaini."',fechafin='".$fechafin."',estatus='".$estatus."',condicion='".$condicion."',destino='".$destino."' where codnoti='".$codigo."'; ";
	}
## ejecución de la sentencia sql

if(mysqli_query(conexion($pais),$sql))
{
		echo "<script>window.opener.location.reload();setTimeout(function(){window.opener.selecFormulario('6');},500);setTimeout(function(){window.opener.document.getElementById('pais').value='".$cod."';window.opener.buscar();window.close();},1200);//setTimeout(function(){location.reload();},200);//setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},500);</script>".$lang[$idioma]['GuardaNoti']."";
					
}
else
{
	echo $sql;
}

}
?>
