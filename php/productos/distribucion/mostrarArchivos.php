<?php
header("Expires: TUE, 18 Jul 2015 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
require_once('../../fecha.php');
require_once('../../coneccion.php');

$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
$cara=strtolower($_POST['cara']);
$codprov=strtolower($_POST['id']);
$seller=strtolower($_POST['seller']);



if(isset($_SESSION['imagenSubida']))
{
	$_SESSION['imagenSubida']=0;
	
}
$pref2="http://www.guatedirect.com/proveedores/catalog/product";
$pref=strtolower("../../../imagenes/proveedores/".limpiar_caracteres_especiales($_SESSION['nomProv'])."/".limpiar_caracteres_especiales($seller)."/");
$prefc=strtolower("../../../imagenes/proveedores/cache/".limpiar_caracteres_especiales($_SESSION['nomProv'])."/".limpiar_caracteres_especiales($seller)."/");
$ret="";
//sleep(2);
	switch($cara)
	{
		
		default:
		{
				$sql_auten="select archivo as file,descripcion,tipo from documents  where codprov='$codprov'";
					if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql_auten))
					{
						if(mysqli_num_rows($ejecutar)>0)
						{
							while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
							{
								
								if(file_exists(("".$pref.$row['file'])))
									{
											$ruta=$pref.$row['file'].'" target="_blank"';
										
									}
									else
									{
										$ruta='#"';
									}
									
								$ret.= '
										<li><a href="'.strtolower($ruta).'><img src="../../../images/'.strtolower($row['tipo']).'.png" width="50px" >'.strtolower($row['file']).'</a>';
									
									$ret.= '          
                                         	</li><br>';	
                                    	
								
								
							}
							echo $ret;
							
						}
						else
						{
							echo '2';
						}
					}
					else
					{
						echo "2";
					}
			break;
		}
	}
				
				

				
				
				
?>
