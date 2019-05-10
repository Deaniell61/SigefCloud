<?php
sleep(1);
include('coneccion.php');

if($_REQUEST)
{
	$username 	= $_REQUEST['user'];
	$query = "select * from sigef.cat_usua where email = '$username'";
	$results = @mysqli_query( conexion(""),$query) or die('ok');
	$res=$results->num_rows;
	if($res > 0) // not available
	{
		echo '<div id="Success" ></div>';
		
	}
	else
	{
		echo '<div id="Error" alt="Ayuda" onmouseover="muestraAyuda(event, \'UsuarioError\')"></div>';
	}
	
}?>