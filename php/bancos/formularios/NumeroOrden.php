<?php

require_once('../../coneccion.php');

session_start();

$combo=$_POST['combo'];
$codcuen=$_POST['codcuen'];

	$sql="select numero from tra_cuen where tipdoc='".$combo."' and codcuen='".$codcuen."' order  by numero desc limit 1";	
	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						
						echo intval($row['numero']);
							
						
					}

			}

	

?>