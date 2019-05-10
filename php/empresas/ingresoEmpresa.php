<?php

/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
## usuario y clave pasados por el formulario
$nombre= strtoupper(limpiar_caracteres_sql($_POST['nombre']));
$email = limpiar_caracteres_sql($_POST['email']);
$npatronal = limpiar_caracteres_sql($_POST['npatronal']);
$rsocial = limpiar_caracteres_sql($_POST['rsocial']);
$direccion = limpiar_caracteres_sql($_POST['direccion']);
$nit = limpiar_caracteres_sql($_POST['nit']);
$telefono = limpiar_caracteres_sql($_POST['telefono']);
$fax = limpiar_caracteres_sql($_POST['fax']);
$www = limpiar_caracteres_sql($_POST['www']);
$ctaIva_CR = limpiar_caracteres_sql($_POST['ctaIva_CR']);
$ctaIva_DB = limpiar_caracteres_sql($_POST['ctaIva_DB']);
$ctaInven = limpiar_caracteres_sql($_POST['ctaInven']);
$ctaIvaCRxL = limpiar_caracteres_sql($_POST['ctaIvaCRxL']);
$ctaCCxP = limpiar_caracteres_sql($_POST['ctaCCxP']);
$ctaIDP = limpiar_caracteres_sql($_POST['ctaIDP']);
$ctaCosto = limpiar_caracteres_sql($_POST['ctaCosto']);
$ctaCajaGR = limpiar_caracteres_sql($_POST['ctaCajaGR']);
$cPIGSS = limpiar_caracteres_sql($_POST['cPIGSS']);
$cPIntecap = limpiar_caracteres_sql($_POST['cPIntecap']);
$cPIRTRA = limpiar_caracteres_sql($_POST['cPIRTRA']);
$cLIGSS = limpiar_caracteres_sql($_POST['cLIGSS']);
$baseDatos = limpiar_caracteres_sql($_POST['baseDatos']);
$moneda = limpiar_caracteres_sql($_POST['moneda']);
$inventar = limpiar_caracteres_sql($_POST['inventar']);
$codigo = limpiar_caracteres_sql($_POST['codigo']);

$incre1=$_POST['incre1'];
$incre2=$_POST['incre2'];
$incre3=$_POST['incre3'];
$incre4=$_POST['incre4'];
$marmin=$_POST['marmin'];
$marpro=$_POST['marpro'];
$marmax=$_POST['marmax'];
$marmincon=$_POST['marmincon'];


$pais = limpiar_caracteres_sql($_POST['pais']);

if($nombre==NULL || $rsocial==NULL || $nit==NULL || $email==NULL)
{
	echo "<span>Debe completar todos los campos obligatorios</span>";
}
else
{
	if($codigo=='')
	{
		$sql="insert into cat_empresas(codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email,ctaIva_CR,ctaIva_DB,ctaInven,ctaIvaCRxL,ctaCCxP,ctaIDP,ctaCosto,ctaCajaGR,cPIGSS,cPIntecap,cPIRTRA,cLIGSS,baseDatos,moneda,inventar,pais,incre1,incre2,incre3,incre4,mmin,mpro,mmax,marmincom) values('".sys2015()."','".$npatronal."','".$nombre."','".$rsocial."','".$direccion."','".$nit."','".$telefono."','".$fax."','".$www."','".$email."','".$ctaIva_CR."','".$ctaIva_DB."','".$ctaInven."','".$ctaIvaCRxL."','".$ctaCCxP."','".$ctaIDP."','".$ctaCosto."','".$ctaCajaGR."','".$cPIGSS."','".$cPIntecap."','".$cPIRTRA."','".$cLIGSS."','".$baseDatos."','".$moneda."','".$inventar."','".$pais."','".$incre1."','".$incre2."','".$incre3."','".$incre4."','".$marmin."','".$marpro."','".$marmax."','".$marmincon."');";
	}
	else
	{
	$sql="update cat_empresas set npatronal='".$npatronal."',nombre='".$nombre."',rsocial='".$rsocial."',direccion='".$direccion."',nit='".$nit."',telefono='".$telefono."',fax='".$fax."',www='".$www."',email='".$email."',ctaIva_CR='".$ctaIva_CR."',ctaIva_DB='".$ctaIva_DB."',ctaInven='".$ctaInven."',ctaIvaCRxL='".$ctaIvaCRxL."',ctaCCxP='".$ctaCCxP."',ctaIDP='".$ctaIDP."',ctaCosto='".$ctaCosto."',ctaCajaGR='".$ctaCajaGR."',cPIGSS='".$cPIGSS."',cPIntecap='".$cPIntecap."',cPIRTRA='".$cPIRTRA."',cLIGSS='".$cLIGSS."',baseDatos='".$baseDatos."',moneda='".$moneda."',inventar='".$inventar."',incre1='".$incre1."',incre2='".$incre2."',incre3='".$incre3."',incre4='".$incre4."',mmin='".$marmin."',mpro='".$marpro."',mmax='".$marmax."',marmincom='".$marmincon."' where codempresa='".$codigo."'";
	}
## ejecución de la sentencia sql

if(mysqli_query(conexion(""),$sql))
{
					
						echo "<script>location.reload();</script>".$lang[$idioma]['EmpresaGuardada']."";
						}
else
{
	echo "$sql";
}
}
?>
