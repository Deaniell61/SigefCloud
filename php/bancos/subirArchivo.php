<?php
require_once('../fecha.php');
require_once('../coneccion.php');
$uploadedfileload="true";
$msg="";
session_start();
$codigo=$_SESSION['CodEmp'];
$nombre=$_SESSION['NomEmp'];


#############################################################################################################333
if(@$_FILES['imagen']['size']>0)
{
	$uploadedfile_size=$_FILES['imagen']['size'];
	if ($_FILES['imagen']['size']>2000000)
{
	
	
	$msg=$msg."Los archivo son mayores que 2MB, debes reduzcirlo antes de subirlo<BR>";
	$uploadedfileload="false";
	}

if (!($_FILES['imagen']['type'] =="image/jpeg" OR $_FILES['imagen']['type'] =="image/gif" OR $_FILES['imagen']['type'] =="image/png"))

{$msg=$msg." Tus archivod tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
$uploadedfileload="false";
}

$file_name=sys2015()."_".date('y').date('m').date('d')."_".$_FILES['imagen']['name'];
$dir="../../imagenes/empresas/".$codigo."/";
if(!is_dir($dir)) 
	{
         mkdir($dir, 0777);
	}
		 
$add=$dir.$file_name;
if($uploadedfileload=="true"){

if(move_uploaded_file ($_FILES['imagen']['tmp_name'], $add))
{
	guardarImagen1($add,$codigo,$nombre);
echo " Ha sido subido satisfactoriamente";
}else
{
		echo "Error al subir el archivo";
	}

}else{echo $msg;}

}
	

###################################################################################################################3
if(@$_FILES['imagen1']['size']>0)
{$uploadedfile_size2=$_FILES['imagen1']['size'];
	if ($_FILES['imagen1']['size']>2000000)
{
	
	
	$msg=$msg."Los archivo son mayores que 2MB, debes reduzcirlo antes de subirlo<BR>";
	$uploadedfileload="false";
	}

if (!($_FILES['imagen1']['type'] =="image/jpeg" OR $_FILES['imagen1']['type'] =="image/gif" OR $_FILES['imagen1']['type'] =="image/png"))

{$msg=$msg." Tus archivod tiene que ser JPG o GIF. Otros archivos no son permitidos<BR>";
$uploadedfileload="false";
}

$file_name2=sys2015()."_".date('y').date('m').date('d')."_".$_FILES['imagen1']['name'];
$dir2="../../imagenes/empresas/".$codigo."/";
if(!is_dir($dir2)) 
	{
         mkdir($dir2, 0777);
	}
$add2=$dir2.$file_name2;

if($uploadedfileload=="true"){

if(move_uploaded_file ($_FILES['imagen1']['tmp_name'], $add2))
{
	guardarImagen2($codigo,$nombre,$add2);
echo " Ha sido subido satisfactoriamente";
}else
{
		echo "Error al subir el archivo";
	}

}else{echo $msg;}

}

#######################################################################################################################
#Guarda imagen numero 2
function guardarImagen2($cod,$nom,$direc2)
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
		$sql_auten="update cat_empresas set imagen1='".$direc2."' where codempresa='$cod' and nombre='$nom'";
## ejecución de la sentencia sql

if(mysqli_query(conexion(""),$sql_auten))
{
					
						echo "<span>".$lang[ $idioma ]['ImagenGuardada']."</span>";
						}
else
{
	echo "<script>alert(\"Error\");</script>";
}
}
#############################################################################################################################
#Guarda la imagen numero 1
function guardarImagen1($direc,$cod,$nom)
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
		$sql_auten="update cat_empresas set imagen='".$direc."' where codempresa='$cod' and nombre='$nom'";
## ejecución de la sentencia sql

if(mysqli_query(conexion(""),$sql_auten))
{
					
						echo "<span>".$lang[ $idioma ]['ImagenGuardada']."</span>";
						}
else
{
	echo "<script>alert(\"Error\");</script>";
}
}
?>
