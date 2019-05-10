<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosBancos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();

$cuentapoliza=$_POST['cuentapoliza'];
$debe=$_POST['debe'];
$haber=$_POST['haber'];


if($cuentapoliza==NULL)
{
  echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
  
  {
    
    $sql="insert into tra_pol_det(CODDPOL, CODPOLIZA, CUENTA, DEBE, HABER) values('".sys2015()."', '1', '".$cuentapoliza."', '".$debe."', '".$haber."');";

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