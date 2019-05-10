<?php
require_once('../../coneccion.php');
session_start();

$poliza=$_POST['poliza'];

$sql="select CODPOLIZA from tra_pol_enc where numero='".$poliza."'";	
	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						
						echo $row['CODPOLIZA'];
							
						
					}

			}

?>