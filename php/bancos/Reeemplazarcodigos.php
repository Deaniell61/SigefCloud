<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosBancos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();

$codcuen=$_POST['codcuen'];
$numero=$_POST['numero'];



if($codcuen==NULL || $numero==NULL || $valor1==NULL || $numvalor==NULL || $valor==NULL || $valor==NULL)
{
  echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
  
  {
    
    $sql="insert into tra_cuen(CODTCUEN, CODCUEN, NUMERO, FECHA, TIPDOC, CONCEPTO, BENEFICIA, VALOR, NEGOCIABLE, TASA, ORDEN, CODPOLIZA, CODVOUCHER, CODPROY, IMPRESO, MONEDA, STAT) values('".sys2015()."', '".$codcuen."', '".$numero."', '".$fecha."', '".$valor1."', '".$concepto."', '".$beneficia."', '".$numvalor."', '".$valor."', '".$tasacambio1."', '".$ordenpago."', '".$codpoliza1."', '".$codvoucher."', '".$codproy."', '0', '".$moneda."', '".$statcheque."' );";

  }
  
## ejecución de la sentencia sql

if(mysqli_query(conexion($_SESSION['pais']),$sql))
{
         echo 1;
}
else
{
  echo "$sql";
}
}
?>