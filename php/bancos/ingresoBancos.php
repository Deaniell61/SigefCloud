<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codprov=$_SESSION['codprov'];
$codempresa=$_SESSION['codEmpresa'];
$cuenta= (($_POST['numcuen']));
$elemento= (($_POST['elemento1']));
$nombre=$_POST['nombre'];
$codigoBanco=$_POST['codbanc'];
$tipocuenta=$_POST['Codtcuenta'];
$cuentconta=$_POST['codCuenta'];
$nombreconta=$_POST['codbanctc'];
$TipoMon=$_POST['codmone'];
$formatfec=$_POST['forfecha'];
$condidepo=$_POST['condp'];
$conNotaCre=$_POST['connc'];
$conCheque=$_POST['conch'];
$conNotaDev=$_POST['connd'];
$columnanumero=$_POST['COLNUM'];
$lineanumero=$_POST['LINNUM'];
$columnatran=$_POST['COLTRAN'];
$lineatran=$_POST['LINTRAN'];

if($nombre==NULL)
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	
	{
		
		$sql="insert into cat_cuen(codcuen, numcuen,nombre, codbanc, CODTCUEN, codcuenta, codbanctc, codmone, forfecha,condp, connc, conch, connd, codempresa, codprov, PAGOS, COLNUM, LINNUM, COLTRAN, LINTRAN) values('".sys2015()."','".$cuenta."', '".$nombre."', '".$codigoBanco."', '".$tipocuenta."', '".$cuentconta."', '".$nombreconta."', '".$TipoMon."', '".$formatfec."', '".$condidepo."', '".$conNotaCre."', '".$conCheque."', '".$conNotaDev."', '".$codempresa."', '".$codprov."', '".$elemento."','".$columnanumero."','".$lineanumero."','".$columnatran."','".$lineatran."');";

	}
	
## ejecución de la sentencia sql

if(mysqli_query(conexion($_SESSION['pais']),$sql))
{
					
						echo "Registros Guardados";

						}
else
{
	echo "$sql";
}
}
?>
