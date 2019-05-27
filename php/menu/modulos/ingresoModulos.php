<?php
require_once('../../coneccion.php');
include('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
## usuario y clave pasados por el formulario
$nombre= strtoupper($_POST['nombre']);
$padre = $_POST['padre'];
$nivel= $_POST['nivel'];
$codigo= $_POST['codigo'];
$link= $_POST['link'];
$aplicacion= $_POST['aplicacion'];
$tipo = strtoupper($_POST['tipo']);

if($nombre==NULL || $tipo==NULL || $nivel==NULL || $padre==NULL)
{
	echo "<span>".$lang[$idioma]['CompletarCampos']."</span>";
}
else
{
## usa la funcion autentica() que se ubica dentro de sesiones.php
if($codigo=='')
{
switch($nivel)
{
	case 1:
	{
		$sql_auten="insert into sigef_modulos(codigo,nombre,tipo,aplicacion,link) values('$padre.0".cod($padre,".")."','".$nombre."','$tipo','$aplicacion','$link')"; 
		break;
	}
	case 2:
	{
		$sql_auten="insert into sigef_modulos(codigo,nombre,tipo,aplicacion,link) values('$padre.0".cod($padre,".")."','".$nombre."','$tipo','$aplicacion','$link')";
		break;
	}
	case 3:
	{
		$sql_auten="insert into sigef_modulos(codigo,nombre,tipo,aplicacion,link) values('$padre.0".cod($padre,".")."','".$nombre."','$tipo','$aplicacion','$link')";
		break;
	}
	case 4:
	{
		$sql_auten="insert into sigef_modulos(codigo,nombre,tipo,aplicacion,link) values('$padre.0".cod($padre,".")."','".$nombre."','$tipo','$aplicacion','$link')";
		break;
	}
	case 5:
	{
		$sql_auten="insert into sigef_modulos(codigo,nombre,tipo,aplicacion,link) values('$padre.0".cod($padre,".")."','".$nombre."','$tipo','$aplicacion','$link')";
		break;
	}
	case 0:
	{
		$sql_auten="insert into sigef_modulos(codigo,nombre,tipo,aplicacion,link) values('0".cod1($padre)."','".$nombre."','$tipo','$aplicacion','$link')";
		break;
	}
}
}
else
{	
switch($nivel)
{
	case 1:
	{
		$sql_auten="update sigef_modulos set codigo='$padre.0".cod($padre,".")."',nombre='".$nombre."',tipo='$tipo',aplicacion='$aplicacion',link='$link' where codigo='".$codigo."'";
		break;
	}
	case 2:
	{
		$sql_auten="update sigef_modulos set codigo='$padre.0".cod($padre,".")."',nombre='".$nombre."',tipo='$tipo',aplicacion='$aplicacion',link='$link' where codigo='".$codigo."'";
		break;
	}
	case 3:
	{
		$sql_auten="update sigef_modulos set codigo='$padre.0".cod($padre,".")."',nombre='".$nombre."',tipo='$tipo',aplicacion='$aplicacion',link='$link' where codigo='".$codigo."'";
		break;
	}
	case 4:
	{
		$sql_auten="update sigef_modulos set codigo='$padre.0".cod($padre,".")."',nombre='".$nombre."',tipo='$tipo',aplicacion='$aplicacion',link='$link' where codigo='".$codigo."'";
		break;
	}
	case 5:
	{
		$sql_auten="update sigef_modulos set codigo='$padre.0".cod($padre,".")."',nombre='".$nombre."',tipo='$tipo',aplicacion='$aplicacion',link='$link' where codigo='".$codigo."'";
		break;
	}
	case 0:
	{
		$sql_auten="update sigef_modulos set codigo='0".cod1($padre)."',nombre='".$nombre."',tipo='$tipo',aplicacion='$aplicacion',link='$link' where codigo='".$codigo."'";
		break;
	}
}
	 
		
		
}
## ejecución de la sentencia sql

if(mysqli_query(conexion(""),$sql_auten))
{
					
						echo "<script>document.getElementById('modulos').reset();document.getElementById('nombre').className= \"normal\";document.getElementById('nombre').focus();</script>Modulo ".$lang[$idioma]['Guardado']."";
						}
else
{
	echo "$sql_auten";
}
}

function cod($pad,$cant)
{
	$sql="(select (count(*)+1) as cod from sigef_modulos where codigo like '$pad".$cant."%' and length(codigo)>2)";
	$ejecuta=mysqli_query(conexion(""),$sql);
	$row=mysqli_fetch_array($ejecuta,MYSQLI_ASSOC);
	return $row['cod'];
}
function cod1($pad)
{
	$sql="(select count(*)+1 as cod from sigef_modulos where length(codigo)<=2)";
	$ejecuta=mysqli_query(conexion(""),$sql);
	$row=mysqli_fetch_array($ejecuta,MYSQLI_ASSOC);
	return $row['cod'];
}
?>
