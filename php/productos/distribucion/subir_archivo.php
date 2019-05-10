<?php
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
	require_once('../../fecha.php');
	$idioma=idioma();
	include('../../idiomas/'.$idioma.'.php');
if (isset($_FILES['archivo'])) 
{
	session_start();
	$tipoImg=strtolower($_POST['nombre_archivo']);
    $archivo = $_FILES['archivo'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
	$tipo=$archivo['type'];
	if($_POST['nombre_archivo2']!="")
	{
		$nombre=$_POST['nombre_archivo2'];
	}
	else
	{
		$nombre=str_replace(".".$extension,"",$archivo['name']);
	}
	$codigo=$_POST['nombre_archivo3'];
	$seller=$_POST['nombre_archivo4'];
	$ruta_provisional=$archivo['tmp_name'];
	$size=$archivo['size'];
	$dimensiones=getimagesize($ruta_provisional);
	$alto=$dimensiones[1];
	$ancho=$dimensiones[0];
	$subir=false;
	$mensaje='';
	
	$subir=true;
		if($size < (2*(1024*1024)))
		{
			
				$subir=true;
			
		}
		else
		{
			$mensaje=$lang[$idioma]['AdverTamanio'];
			
		}
	
	
if($subir==true)
{	
	$dir22=strtolower("../../../imagenes/proveedores/");
	if(!is_dir($dir22)) 
		{
         	mkdir($dir22, 0777);
			
		}
		
	$dir=strtolower("../../../imagenes/proveedores/".(limpiar_caracteres_especiales($_SESSION['nomProv']))."/");
	$dir2="";
	$dirc=strtolower("../../../imagenes/proveedores/cache/".(limpiar_caracteres_especiales($_SESSION['nomProv']))."/");
		if(!is_dir($dir)) 
		{
         	mkdir($dir, 0777);
			
		}
		if(!is_dir($dirc)) 
		{
         	mkdir($dirc, 0777);
			
		}
	$dir=strtolower("../../../imagenes/proveedores/".(limpiar_caracteres_especiales($_SESSION['nomProv']))."/".(limpiar_caracteres_especiales($seller))."/");
	$dir2="";
	$dirc=strtolower("../../../imagenes/proveedores/cache/".(limpiar_caracteres_especiales($_SESSION['nomProv']))."/".(limpiar_caracteres_especiales($seller))."/");
		if(!is_dir($dir)) 
		{
         	mkdir($dir, 0777);
			
		}
		if(!is_dir($dirc)) 
		{
         	mkdir($dirc, 0777);
			
		}
		
	
		
		
	
	$file_name=strtolower(limpiar_caracteres_especiales($nombre)."_".$tipoImg.".".$extension);
	
	$add="";
	$file="";
	
		
		
			$file_name=strtolower(limpiar_caracteres_especiales($nombre));
			$nombre11=strtolower(limpiar_caracteres_especiales($nombre));
			$file_name2=strtolower(limpiar_caracteres_especiales($nombre)).".".$extension;
			$add=$dir.$file_name2;
			$dir2=$dir2.$file_name2;
			$file=$file_name2;
		
	if($tipoImg!="")
	{
				
    	if (move_uploaded_file($ruta_provisional, $add)) 
		{
			
			
			guardarArchivo($file_name2,$codigo,$tipoImg,$extension,$nombre11);
        	
    	} 
		else 
		{
        	echo "Error al subir el archivo1";
    	}
		
	}
	else
	{
		echo $lang[ $idioma ]['ReqDesc'];
	}

}
else
{
	echo "<script>alert('".$mensaje."');</script>";
}

}
#Guarda la imagen Front
function guardarArchivo($direc,$codprov,$nom,$tipo,$nombre)
{
	require_once('../../fecha.php');
	require_once('../../coneccion.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	$cod=sys2015();
		switch($nom)
		{
			default:
			{
				if(!comprobarFILE($codprov,$nombre))
				{
					$sql_auten="insert into documents(coddocto,archivo,descripcion,codprov,tipo) values('$cod','$direc','$nom','$codprov','$tipo')";
				}
				else
				{
					$sql_auten="update documents set archivo='$direc',tipo='$tipo' where codprov='$codprov' and archivo like '$nombre%'";
				}
				break;
			}
		}
		
## ejecución de la sentencia sql

if(mysqli_query(conexion($_SESSION['pais']),$sql_auten))
{	
					
						echo "<span>".$lang[ $idioma ]['ArchivoGuardado']."</span><script>limpiarArchivosProv();/*llamarProveedor('7','$codprov');*/mostrarArchivos();</script> ";
					
					mysqli_close(conexion($_SESSION['pais']));					
}
else
{
	echo "<script>alert(\"$sql_auten\");</script>";
}
}
#Fin Guardar Imagen Frontal

function comprobarFILE($cod,$nom)
{require_once('../../fecha.php');
	require_once('../../coneccion.php');
$sql_auten="select archivo from documents where codprov='$cod' and archivo like '$nom%'";
		
		if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql_auten))
			{
				if(mysqli_num_rows($ejecutar)>0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
}
?>
