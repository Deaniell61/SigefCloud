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
$nombre=$_POST['nombre'];
$abre=$_POST['abre'];
$factor=$_POST['factor'];
if($_POST['opera']=="mas")
{
	$opera="+";
}
else
{
	$opera=$_POST['opera'];
}
if($nombre=="" || $abre=="" || $factor=="")
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	if($codigo=='')
	{
		$sql="insert into cat_uni_peso(codunipeso,nombre,abre,factor,opera) values('".sys2015()."','".$nombre."','".$abre."','".$factor."','".$opera."');";
	}
	else
	{
  		$sql="update cat_uni_peso set nombre='".$nombre."',abre='".$abre."',factor='".$factor."',opera='".$opera."' where codunipeso='".$codigo."'; ";
	}
## ejecución de la sentencia sql

if(mysqli_query(conexion($pais),$sql))
{
		echo "<script>window.opener.location.reload();setTimeout(function(){window.opener.selecFormulario('7');},500);setTimeout(function(){window.opener.document.getElementById('pais').value='".$cod."';window.opener.buscar();window.close();},1200);//setTimeout(function(){location.reload();},200);//setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},500);</script>".$lang[$idioma]['GuardaMedida']."";
		
					
}
else
{
	echo $sql;
}

}
?>
