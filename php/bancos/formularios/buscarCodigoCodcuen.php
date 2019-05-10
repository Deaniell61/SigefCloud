<?php
require_once('../../coneccion.php');
session_start();

$codpoliza1=$_POST['codpoliza1'];

$sql="select CODTCUEN from tra_cuen where CODPOLIZA='".$codpoliza1."'";	
	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						
						echo $row['CODTCUEN'];
							
						
					}

			}

?>