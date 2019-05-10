<?php 
require_once('../../fecha.php');
require_once('../../coneccion.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
$seleccion=$_POST['parametro'];
$num=$_POST['num'];
$nombre=$_POST['chaname'];
$pminsale=$_POST['pminsale'];
$columna=$_POST['columna'];
$bundle1=$_POST['bundle1'];
$bundle2=$_POST['bundle2'];
$bundle3=$_POST['bundle3'];
$bundle4=$_POST['bundle4'];
$codigo=$_POST['codigo'];
$formula=$_POST['formula'];
$codparpri=$_POST['codparpri'];
$pais=$_POST['pais'];
$bodega=$_POST['bodega'];
$consulta="select * from cat_sal_cha where codchan='".$seleccion."'";
if($nombre!=NULL and $pminsale!=NULL)
{
if($cadauno=mysqli_query(conexion($pais),$consulta))
{
	if(!(mysqli_num_rows($cadauno)>0))
	{	
	
		switch($num)
		{
			case '1':
			{
		
				$squery="insert into cat_sal_cha(codchan,channel,pminsale,columna,incre1,incre2,incre3,incre4,codigo,bodega) 
					values('".sys2015()."','".$nombre."','".$pminsale."','".$columna."','".$bundle1."','".$bundle2."','".$bundle3."','".$bundle4."','".$codigo."','".$bodega."')";
				$mensaje="Canal Guardado";
			}
			case '2':
			{
		
				$squery="update cat_par_pri set formula=\"".$formula."\" where codparpri='".$codparpri."'";
				$mensaje="Canal Guardado";
			}
		}
	}
	else
	{
		switch($num)
		{
			case '1':
			{
		
				$squery="update cat_sal_cha set channel='".$nombre."',pminsale='".$pminsale."',columna='".$columna."',incre1='".$bundle1."',incre2='".$bundle2."',incre3='".$bundle3."',incre4='".$bundle4."',codigo='".$codigo."',bodega='".$bodega."' where codchan='".$seleccion."'";
				$mensaje="Canal Guardado";
			}
			case '2':
			{
		
				$squery="update cat_par_pri set formula=\"$formula\" where codparpri='".$codparpri."'";
				$mensaje="Canal Guardado";
			}
		}
	}
}
$ejecutar=mysqli_query(conexion($pais),$squery);
if($ejecutar)				
{
	echo $mensaje;
}
}
else
{
	echo "Error";
}
?>
