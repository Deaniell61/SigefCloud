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
$seller=$_POST['seller'];
$canal=$_POST['canal'];
$unidades=$_POST['unidades'];
$precio=$_POST['precio'];
$shipping=$_POST['shipping'];
$amname=ucwords(strtolower($_POST['amname']));
$asinNumber=$_POST['asiNumber'];
$amsku=$_POST['amsku'];
$aplica=$_POST['aplica'];
$codprecom=$_POST['codprecom'];



{
## usa la funcion autentica() que se ubica dentro de sesiones.php
if($codprecom=='')
{
	$sql_auten="insert into tra_pre_com(codprecom,codprod,codcompe,codcanal,fecha,unidades,preciomin,preciomax,shipping,azname,asin,azsku,aplica,codempresa,codprov) values('".sys2015()."','".$codprod."','".$seller."','".$canal."','".getFecha()."','".$unidades."','".$precio."','".$precio."','".$shipping."','".$amname."','".$asinNumber."','".$amsku."','".$aplica."','".$codempresa."','".$codprov."')";
}
else
{
	$sql_auten="update tra_pre_com set codprod='".$codprod."',codcompe='".$seller."',codcanal='".$canal."',unidades='".$unidades."',preciomin='".$precio."',preciomax='".$precio."',shipping='".$shipping."',azname='".$amname."',asin='".$asinNumber."',azsku='".$amsku."',aplica='".$aplica."' where codempresa='".$codempresa."' and codprov='".$codprov."' and codprecom='".$codprecom."'";
	
}
## ejecución de la sentencia sql

if(mysqli_query(conexion($pais),$sql_auten))
{
					
						echo $lang[$idioma]['SellerGuardado'];
						}
else
{
	echo "<script>alert(\"Error\");</script>";
}
}

?>
