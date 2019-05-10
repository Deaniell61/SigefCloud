<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosBancos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
$tipo=$_POST['tipo'];
$numero=$_POST['numero'];
$fecha=$_POST['fecha'];
$tasacambio1=$_POST['tasacambio1'];
$poliza=$_POST['poliza'];
$concepto=$_POST['concepto'];

if($tipo==NULL || $numero==NULL || $fecha==NULL)
{
  echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
  
  {
     // $sql="insert into cat_dato(coddato, datos) values('".sys2015()."', '1');";	
    $sql="insert into tra_pol_enc(CODPOLIZA, TIPO, NUMERO, FECHA, TASACAMBIO, CODDOCTO, NUMDOCTO, NUDOCTO, DESCRIPCIO) values('".sys2015()."', '".$tipo."', '".$poliza."', '".$fecha."', '".$tasacambio1."', '1', '".$numero."', '".$numero."', '".$concepto."');";


  }
  
## ejecución de la sentencia sql

if(mysqli_query(conexion($_SESSION['pais']),$sql))
{
   // $sql1="select codpoliza from tra_pol_enc where numero='".$poliza."'";
   			
   	   		echo 1;
                 
        }
else
{
  echo "$sql";
}
}
?>