<?php
require_once('coneccion.php');
require_once('fecha.php');

## usuario y clave pasados por el formulario
$nivel= $_POST['nivel'];

$squery="select codigo,codmodu,nombre from sigef_modulos where LENGTH(codigo)=LENGTH('".nivel($nivel)."')";


## ejecución de la sentencia sql

				$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					$contador=0;
					echo "<select class='entradaTexto' id=\"padre\">";
					echo "<option value=\"00\"></option>";
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						{
							echo "<option value=\"".$row['codigo']."\">".$row['nombre']."</option>";
						}
						
					}
				
					echo "</select>";
				}
				else
				{	
					echo "Error al cargar los padres";
				}
				
function nivel($nive)
{
	switch($nive)
	{
		case 1:{return "00"; break;}
		case 2:{return "00.00"; break;}
		case 3:{return "00.00.00"; break;}
		case 4:{return "00.00.00.00"; break;}
		case 5:{return "00.00.00.00.00"; break;}
		case 6:{return "00.00.00.00.00.00"; break;}
	}
}

function padre($nombre,$codigo)
{
	$codigo=substr($codigo,strlen($codigo)-2,strlen($codigo));
	$squery="select codigo,codmodu,nombre from sigef_modulos where codigo like '".$codigo."%'";
		$ejecutar=mysqli_query(conexion(""),$squery);
			if($ejecutar)
			{
				while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						echo "<option value=\"".$row['codigo']."\">".$row['nombre']."</option>";
						
					}
			}
}

?>
