<?php
require_once('../../coneccion.php');
session_start();
$codigo=$_POST['combo'];
$filtro=$_POST['filtro'];
	
		

	$sql="select codigo from cat_nomenclatura where que_es='".$filtro."' and codcuenta='".$codigo."'";

	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						echo $row['codigo'];
					}

			}
		
?>