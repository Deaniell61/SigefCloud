<?php
require_once('../coneccion.php');
require_once('../fecha.php');
session_start();
if(isset($_POST['tipo']))
{
	switch($_POST['tipo'])
	{
		case "eliminar":
		{

			$src=$_POST['src'];
			$idimage=$_POST['grados'];
			$cara=$_POST['ima'];
			if(strtolower($cara) != 'fro'){
				$sql="delete from cat_prod_img where codimage=".$idimage." and cara='".$cara."'";
			}
			else{
				$sql="UPDATE cat_prod set IMAURLBASE = '' WHERE CODPROD = '$idimage';";
			}


			$pref="../../imagenes/media/".limpiar_caracteres_especiales($_SESSION['nomEmpresa'])."/";
			$pref2="../../imagenes/media/cache/".limpiar_caracteres_especiales($_SESSION['nomEmpresa'])."/";
			
			$p1 = strtolower($pref.$src);
			$p2 = strtolower($pref2.$src);

			if(file_exists($p1))
			{
				if(unlink($p1))
				{
					if(file_exists($p2))
					{
						if(unlink($p2))
						{
							if(mysqli_query(conexion($_SESSION['pais']),$sql))
							{
								echo "Imagen Borrada <script>mostrarImagenes();</script>";

							}
						}
					}
				}
			}
			else
			{
				echo "La imagen ya se encuentra en el servidor, no puede ser cambiada";
			}
			break;
		}
		case "rotar":
		{
			//function RotateJpg($nombre, $angulo, $guardarnombre)
    		$src=$_POST['src'];
			$angulo=$_POST['grados']*-1;
      		$pref="../../imagenes/media/".limpiar_caracteres_especiales($_SESSION['nomEmpresa'])."";
			$pref2="../../imagenes/media/cache/".limpiar_caracteres_especiales($_SESSION['nomEmpresa'])."";
			//$src=substr($src,59,strlen($src));
			//$src=substr($src,60,strlen($src));
			if(file_exists(strtolower($pref.$src)))
			{
				$guardarnombre=strtolower($nombre=$pref.$src);
				$guardarnombre2=$nombre2=strtolower($pref2.$src);


				
				$original   =   imagecreatefromjpeg($nombre);
				$original2   =   imagecreatefromjpeg($nombre2);
		  
				$rotated    =   imagerotate($original, $angulo, 0);
				$rotated2    =   imagerotate($original2, $angulo, 0);
			   
				if($guardarnombre == false) 
				{
						header('Content-Type: image/jpeg');
						imagejpeg($rotated);
				}
				else
				{
					imagejpeg($rotated,$guardarnombre,98);
				}
				if($guardarnombre2 == false) 
				{
						header('Content-Type: image/jpeg');
						imagejpeg($rotated2);
				}
				else
				{
					imagejpeg($rotated2,$guardarnombre2,98);
				}
				
			   
				imagedestroy($rotated);
				imagedestroy($rotated2);
				echo "Imagen Girada";
				$_SESSION['imagenSubida']=1;
    			/*echo "<script>//location.reload();</script>";*/
			}
			else
			{
				echo "Imagen No Girada \n $src";
			}
			
			break;
		}
	}
}

?>