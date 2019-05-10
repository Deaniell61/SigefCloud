<?php
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
require_once('../../fecha.php');
require_once('../../coneccion.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
$cara=$_POST['cara'];
$codprod=$_SESSION['codprod'];



if(isset($_SESSION['imagenSubida']))
{
	$_SESSION['imagenSubida']=0;
	
}

$pref2="../logos";
//$pref2="http://www.guatedirect.com/media/catalog/bancos";
$pref="../../imagenes/media/".limpiar_caracteres_especiales($_SESSION['nomEmpresa'])."/";

	switch($cara)
	{
		case "FRO":
		{
				$sql_auten="select logo as file from cat_banc  where codprod='$codprod'";
					if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql_auten))
					{
						if(mysqli_num_rows($ejecutar)>0)
						{
							if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
							{
								if($row['file']!="")
								{
									echo $pref.$row['file'] . '<br>';
									if(file_exists($pref.$row['file']))
									{
									echo '<script>abrirImagenGrande(document.getElementById("FRONT"));</script>
										<li class="bor">
            								<div>
											'.$lang[$idioma]['FRO'].'
                								<img id="FRONT" class="col3" src="'.$pref.$row['file'].'" onClick="abrirImagenGrande(this);">
            								</div>
        								</li>';		
									}
									else
									{
									
									echo '<script>abrirImagenGrande(document.getElementById("FRONT"));</script>
										<li class="bor">
            								<div>
												'.$lang[$idioma]['FRO'].'
                								<img id="FRONT" class="col3" src="'.$pref2.$row['file'].'" onClick="abrirImagenGrande(this);">
            								</div>
        								</li>';	
										
									}
								}
								else
								{
									echo '2';
								}
							}
						}
						else
						{
							echo "2";
						}
					}
					else
					{
						echo "2";
					}
			break;
		}
		default:
		{
				$sql_auten="select file from cat_prod_img  where codprod='$codprod' and cara='$cara'";
					if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql_auten))
					{
						if(mysqli_num_rows($ejecutar)>0)
						{
							if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
							{
								if(file_exists($pref.$row['file']))
								{
								echo '
										<li class="bor">
            								<div>
												'.$lang[$idioma][$cara].'
                								<img class="col3" src="'.$pref.$row['file'].'" onClick="abrirImagenGrande(this);">
            								</div>
        								</li>';	
								}
								else
								{
								
								echo '
										<li class="bor">
            								<div>
												'.$lang[$idioma][$cara].'
                								<img class="col3" src="'.$pref2.$row['file'].'" onClick="abrirImagenGrande(this);">
            								</div>
        								</li>';	
									
								}
								
							}
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
