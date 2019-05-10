<?php
require_once('../coneccion.php');


function compEmpresa($usuario,$empresa,$codigo)
	{
		$squery="select codacceso from sigef_accesos where codusua='$usuario' and codempresa='$empresa' and codmodu='$codigo'";
		
		$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					return " checked=\"checked\" ";
					}
					else
					{
						return " ";
					}
				}
					
	}



function menu($empresa,$usuario)
{
		echo "<ul>";
            
				for($i=0;$i<numeroMenus();$i++)
				{
					
               		agregarMenus(numero($i+1),$empresa,$usuario);
                   
				}
            echo "</ul>";
}
	


function agregarMenus($codigo,$empresa,$usuario)
{
	
$sql="SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=".strlen("00")." and codigo='".$codigo."' order by codigo";
$ejecutar=conexion("")->query($sql);

$row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);

$res=$ejecutar->num_rows;
for($i=0;$i<$res;$i++)
{
		 echo " <li>";
         echo "<input type=\"checkbox\" onClick=\"mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" id=\"node".$row['codigo']."\" />
		 		<label>
					<input id=\"ch".$row['codigo']."\"".compEmpresa($usuario,$empresa,$row['codigo'])."onChange=\"asignarOpciones('$usuario',document.getElementById('ch".$row['codigo']."').checked,'".$empresa."','".$row['codigo']."','".$row['tipo']."');mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" type=\"checkbox\" value=\"".$row['codigo']."\"/>
						<span></span>
				</label>
				<label for=\"node".$row['codigo']."\">
					".$row['nombre']."
				</label>";
		 

		 	
		 	echo "<ul>";
				
		 			agregarSubMenus($row['codigo'],$empresa,$usuario);
				
				
			echo "</ul>";
		echo " </li>";
		 

		 

}
	
	
}

function agregarSubMenus($codigo,$empresa,$usuario)
{
	$sql="SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=".strlen("00.00")." and codigo like '".$codigo.".%' order by codigo";
$ejecutar=conexion("")->query($sql);

	$res=$ejecutar->num_rows;
	for($o=0;$o<$res;$o++)
{
$row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
		 echo " <li>";
       echo "<input type=\"checkbox\" onClick=\"mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" id=\"node".$row['codigo']."\" />
		 		<label>
					<input id=\"ch".$row['codigo']."\"".compEmpresa($usuario,$empresa,$row['codigo'])."onChange=\"asignarOpciones('$usuario',document.getElementById('ch".$row['codigo']."').checked,'".$empresa."','".$row['codigo']."','".$row['tipo']."');mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" type=\"checkbox\" value=\"".$row['codigo']."\"/>
						<span></span>
				</label>
				<label for=\"node".$row['codigo']."\">
					".$row['nombre']."
				</label>";
		 

		 	
		 	echo "<ul>";
				
		 			agregarSubMenus2($row['codigo'],$empresa,$usuario);
				
				
			echo "</ul>";
		 echo " </li>";
		 
}
}

function agregarSubMenus2($codigo,$empresa,$usuario)
{
	$sql="SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=".strlen("00.00.00")." and LENGTH(codigo)<=9 and codigo like '".$codigo.".%' order by codigo";
$ejecutar=conexion("")->query($sql);

	$res=$ejecutar->num_rows;
	for($o=0;$o<$res;$o++)
{
$row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
		 echo " <li>";
         echo "<input type=\"checkbox\" onClick=\"mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" id=\"node".$row['codigo']."\" />
		 		<label>
					<input id=\"ch".$row['codigo']."\"".compEmpresa($usuario,$empresa,$row['codigo'])."onChange=\"asignarOpciones('$usuario',document.getElementById('ch".$row['codigo']."').checked,'".$empresa."','".$row['codigo']."','".$row['tipo']."');mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" type=\"checkbox\" value=\"".$row['codigo']."\"/>
						<span></span>
				</label>
				<label for=\"node".$row['codigo']."\">
					".$row['nombre']."
				</label>";
		 

		 	
		 	echo "<ul>";
				
		 			agregarSubMenus3($row['codigo'],$empresa,$usuario);
				
				
			echo "</ul>";
		 echo " </li>";
		 
}
}
function agregarSubMenus3($codigo,$empresa,$usuario)
{
	$sql="SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=".strlen("00.00.00.00")." and codigo like '".$codigo.".%' order by codigo";
$ejecutar=conexion("")->query($sql);

	$res=$ejecutar->num_rows;
	for($o=0;$o<$res;$o++)
{
$row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
		 echo " <li>";
          echo "<input type=\"checkbox\" onClick=\"mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" id=\"node".$row['codigo']."\" />
		 		<label>
					<input id=\"ch".$row['codigo']."\"".compEmpresa($usuario,$empresa,$row['codigo'])."onChange=\"asignarOpciones('$usuario',document.getElementById('ch".$row['codigo']."').checked,'".$empresa."','".$row['codigo']."','".$row['tipo']."');mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" type=\"checkbox\" value=\"".$row['codigo']."\"/>
						<span></span>
				</label>
				<label for=\"node".$row['codigo']."\">
					".$row['nombre']."
				</label>";
		 

		 	
		 	echo "<ul>";
				
		 			agregarSubMenus4($row['codigo'],$empresa,$usuario);
				
				
			echo "</ul>";
		 echo " </li>";
		 
}
}
function agregarSubMenus4($codigo,$empresa,$usuario)
{
	$sql="SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=".strlen("00.00.00.00.00")." and codigo like '".$codigo.".%' order by codigo";
$ejecutar=conexion("")->query($sql);

	$res=$ejecutar->num_rows;
	for($o=0;$o<$res;$o++)
{
$row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
		 echo " <li>";
          echo "<input type=\"checkbox\" onClick=\"mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" id=\"node".$row['codigo']."\" />
		 		<label>
					<input id=\"ch".$row['codigo']."\"".compEmpresa($usuario,$empresa,$row['codigo'])."onChange=\"asignarOpciones('$usuario',document.getElementById('ch".$row['codigo']."').checked,'".$empresa."','".$row['codigo']."','".$row['tipo']."');mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" type=\"checkbox\" value=\"".$row['codigo']."\"/>
						<span></span>
				</label>
				<label for=\"node".$row['codigo']."\">
					".$row['nombre']."
				</label>";
		 

		 	
		 	echo "<ul>";
				
		 			agregarSubMenus5($row['codigo'],$empresa,$usuario);
				
				
			echo "</ul>";
		 echo " </li>";
		 
}
}
function agregarSubMenus5($codigo,$empresa,$usuario)
{
	$sql="SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=".strlen("00.00.00.00.00.00")." and codigo like '".$codigo.".%' order by codigo";
$ejecutar=conexion("")->query($sql);

	$res=$ejecutar->num_rows;
	for($o=0;$o<$res;$o++)
{
$row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
		 echo " <li>";
          echo "<input type=\"checkbox\" onClick=\"mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" id=\"node".$row['codigo']."\" />
		 		<label>
					<input id=\"ch".$row['codigo']."\"".compEmpresa($usuario,$empresa,$row['codigo'])."onChange=\"asignarOpciones('$usuario',document.getElementById('ch".$row['codigo']."').checked,'".$empresa."','".$row['codigo']."','".$row['tipo']."');mostrarOpciones('$usuario','$empresa','".$row['codigo']."','".$row['tipo']."');\" type=\"checkbox\" value=\"".$row['codigo']."\"/>
						<span></span>
				</label>
				<label for=\"node".$row['codigo']."\">
					".$row['nombre']."
				</label>";
		 

		 	
		 	echo "<ul>";
				
		 			
				
				
			echo "</ul>";
		 echo " </li>";
		 
}
}

function numero($cod)
{

	switch($cod)
	{
		case 1:{ return "01";break;
		}
		case 2:{ return "02";break;
		}
		case 3:{ return "03";break;
		}
		case 4:{ return "04";break;
		}
		case 5:{ return "05";break;
		}
		case 6:{ return "06";break;
		}
		case 7:{ return "07";break;
		}
		case 8:{ return "08";break;
		}
		case 9:{ return "09";break;
		}
		
	}
}

function numeroMenus()
{
	
$sql="SELECT * FROM sigef_modulos WHERE tipo='M' and LENGTH(codigo)<=2";
$ejecutar=conexion("")->query($sql);

	 return $ejecutar->num_rows;
	
	
}


?>
        