<?php
sleep(1);
include('coneccion.php');

if($_REQUEST)
{
	$username 	= $_REQUEST['user'];
	$query = "select * from sigef_usuarios where email = '$username' or email='".strtolower($username)."@gmail.com' or email='".strtolower($username)."@hotmail.com'";
	$results = @mysqli_query(conexion(""),$query) or die('<div id="Error" alt="Ayuda" onmouseover="muestraAyuda(event, \'UsuarioError\')"></div>');
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