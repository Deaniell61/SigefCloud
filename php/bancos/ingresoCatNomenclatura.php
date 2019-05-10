<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosBancos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
//$CODCUENTA=$_POST['sys2015'];
$elementos=$_POST['elementos'];
$balanceDato=$_POST['balanceDato'];
$ResultadoDato=$_POST['ResultadoDato'];
$grupoconta=$_POST['grupoconta'];
$subgrupoconta=$_POST['subgrupoconta'];
$cuentaconta1=$_POST['cuentaconta1'];
$cuentacontanivel1=$_POST['cuentacontanivel1'];
$cuentacontanivel2=$_POST['cuentacontanivel2'];
$codCuentaconta=$_POST['codCuentaconta'];
$nomCuentaconta=$_POST['nomCuentaconta'];
$tipocuentaconta=$_POST['tipocuentaconta'];
$ubicacionconta=$_POST['ubicacionconta'];

if($elementos==1)
{
	if($nomCuentaconta==NULL || $ubicacionconta==NULL )
	{
		echo "<span>Debe completar todos los campos obligatorios</span>";	
	}
	else
	{
		{
			$sql="insert into cat_nomenclatura(CODCUENTA, QUE_ES, RESULTADOS, BALANCE_GE, GRUPO, SGRUPO, CUENTA, SCUENTA, SSCUENTA, CODIGO, NOMBRE,CTATIPO, EVENTO) values('".sys2015()."', '".$elementos."', '".$ResultadoDato."', '".$balanceDato."','".$grupoconta."', '".$subgrupoconta."', '".$cuentaconta1."', '".$cuentacontanivel1."', '".$cuentacontanivel2."', '".$codCuentaconta."', '".$nomCuentaconta."', '".$tipocuentaconta."', '".$ubicacionconta."');";	
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
}

if($elementos==2)
{
	if($grupoconta==NULL || $nomCuentaconta==NULL || $ubicacionconta==NULL )
	{
		echo "<span>Debe completar todos los campos obligatorios</span>";	
	}
	else
	{
		{
			$sql="insert into cat_nomenclatura(CODCUENTA, QUE_ES, RESULTADOS, BALANCE_GE, GRUPO, SGRUPO, CUENTA, SCUENTA, SSCUENTA, CODIGO, NOMBRE,CTATIPO, EVENTO) values('".sys2015()."', '".$elementos."', '".$ResultadoDato."', '".$balanceDato."','".$grupoconta."', '".$subgrupoconta."', '".$cuentaconta1."', '".$cuentacontanivel1."', '".$cuentacontanivel2."', '".$codCuentaconta."', '".$nomCuentaconta."', '".$tipocuentaconta."', '".$ubicacionconta."');";	
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
}

if($elementos==3)
{
	if($grupoconta==NULL || $subgrupoconta==NULL || $nomCuentaconta==NULL || $ubicacionconta==NULL )
	{
		echo "<span>Debe completar todos los campos obligatorios</span>";	
	}
	else
	{
		{
			$sql="insert into cat_nomenclatura(CODCUENTA, QUE_ES, RESULTADOS, BALANCE_GE, GRUPO, SGRUPO, CUENTA, SCUENTA, SSCUENTA, CODIGO, NOMBRE,CTATIPO, EVENTO) values('".sys2015()."', '".$elementos."', '".$ResultadoDato."', '".$balanceDato."','".$grupoconta."', '".$subgrupoconta."', '".$cuentaconta1."', '".$cuentacontanivel1."', '".$cuentacontanivel2."', '".$codCuentaconta."', '".$nomCuentaconta."', '".$tipocuentaconta."', '".$ubicacionconta."');";	
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
}

if($elementos==4)
{
	if($grupoconta==NULL || $subgrupoconta==NULL || $cuentaconta1==NULL || $nomCuentaconta==NULL || $tipocuentaconta==NULL || $ubicacionconta==NULL )
	{
		echo "<span>Debe completar todos los campos obligatorios</span>";	
	}
	else
	{
		{
			$sql="insert into cat_nomenclatura(CODCUENTA, QUE_ES, RESULTADOS, BALANCE_GE, GRUPO, SGRUPO, CUENTA, SCUENTA, SSCUENTA, CODIGO, NOMBRE,CTATIPO, EVENTO) values('".sys2015()."', '".$elementos."', '".$ResultadoDato."', '".$balanceDato."','".$grupoconta."', '".$subgrupoconta."', '".$cuentaconta1."', '".$cuentacontanivel1."', '".$cuentacontanivel2."', '".$codCuentaconta."', '".$nomCuentaconta."', '".$tipocuentaconta."', '".$ubicacionconta."');";	
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
}

if($elementos==5)
{
	if($grupoconta==NULL || $subgrupoconta==NULL || $cuentaconta1==NULL || $cuentacontanivel1==NULL || $nomCuentaconta==NULL || $tipocuentaconta==NULL || $ubicacionconta==NULL )
	{
		echo "<span>Debe completar todos los campos obligatorios</span>";	
	}
	else
	{
		{
			$sql="insert into cat_nomenclatura(CODCUENTA, QUE_ES, RESULTADOS, BALANCE_GE, GRUPO, SGRUPO, CUENTA, SCUENTA, SSCUENTA, CODIGO, NOMBRE,CTATIPO, EVENTO) values('".sys2015()."', '".$elementos."', '".$ResultadoDato."', '".$balanceDato."','".$grupoconta."', '".$subgrupoconta."', '".$cuentaconta1."', '".$cuentacontanivel1."', '".$cuentacontanivel2."', '".$codCuentaconta."', '".$nomCuentaconta."', '".$tipocuentaconta."', '".$ubicacionconta."');";	
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
}

if($elementos==6)
{
	if($grupoconta==NULL || $subgrupoconta==NULL || $cuentaconta1==NULL || $cuentacontanivel1==NULL || $cuentacontanivel2==NULL || $nomCuentaconta==NULL || $tipocuentaconta==NULL || $ubicacionconta==NULL )
	{
		echo "<span>Debe completar todos los campos obligatorios</span>";	
	}
	else
	{
		{
			$sql="insert into cat_nomenclatura(CODCUENTA, QUE_ES, RESULTADOS, BALANCE_GE, GRUPO, SGRUPO, CUENTA, SCUENTA, SSCUENTA, CODIGO, NOMBRE,CTATIPO, EVENTO) values('".sys2015()."', '".$elementos."', '".$ResultadoDato."', '".$balanceDato."','".$grupoconta."', '".$subgrupoconta."', '".$cuentaconta1."', '".$cuentacontanivel1."', '".$cuentacontanivel2."', '".$codCuentaconta."', '".$nomCuentaconta."', '".$tipocuentaconta."', '".$ubicacionconta."');";	
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
}
?>
