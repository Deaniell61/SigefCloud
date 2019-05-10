<?php
require_once('../../coneccion.php');
include('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codempresa=$_POST['codempresa'];
$pais=$_SESSION['pais'];
$codprov=$_SESSION['codprov'];
$codprod=$_SESSION['codprod'];
$distri=$_POST['distri'];
$de=$_POST['de'];
$a=$_POST['a'];
$precio=$_POST['precio'];
$unidades=$_POST['unidades'];
$pDescuento=$_POST['pDescuento'];



{
## usa la funcion autentica() que se ubica dentro de sesiones.php
if($distri=='')
{
	$sql_auten="insert into tra_pre_dis(codtrapre,de,a,precio,codunidades,codprod,pdescuento) values('".sys2015()."','".$de."','".$a."','".$precio."','".$unidades."','".$codprod."','".$pDescuento."')";
}
else
{
	$sql_auten="update tra_pre_dis set de='".$de."',a='".$a."',precio='".$precio."',codunidades='".$unidades."',pdescuento='".$pDescuento."' where codtrapre='".$distri."' and codprod='".$codprod."'";
	
}
## ejecución de la sentencia sql

if(mysqli_query(conexion($pais),$sql_auten))
{
					
						echo $lang[$idioma]['DistGuardado'];
						}
else
{
	echo "<script>alert(\"Error\");</script>";
}
}

?>
