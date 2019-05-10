<?php
require_once('../../coneccion.php');
session_start();

$codCuentaconta=$_POST['codCuentaconta'];

	$sql="select nombre from cat_nomenclatura where codigo='".$codCuentaconta."'";	
	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						
						echo $row['nombre'];
							
						
					}

			}

?>