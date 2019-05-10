<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();

$codprov=$_SESSION['codprov'];
$codempresa=$_SESSION['codEmpresa'];
$nombanco=$_POST['nombanco'];
$elemento=$_POST['elemento'];
$prioridad=$_POST['prioridad'];
$acompra=$_POST['acompra'];
$aventa=$_POST['aventa'];
$Icompra=$_POST['Icompra'];
$Iventa=$_POST['Iventa'];


if($nombanco==NULL || $prioridad==NULL || $acompra==NULL || $aventa==NULL || $Icompra==NULL || $Iventa==NULL )
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	
	{
		
		$sql="insert into cat_banc(NOMBRE,TASACAMBIO, PRIORIDAD, LOGO, ACTUALIZA, ACOMPRA, AVENTA, ICOMPRA,IVENTA, codempresa, codprov) values('".$nombanco."', '".$elemento."', '".$prioridad."', '1', '1', '".$acompra."', '".$aventa."', '".$Icompra."', '".$Iventa."', '".$codempresa."', '".$codprov."');";
		
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
