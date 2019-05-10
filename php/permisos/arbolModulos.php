
<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

function cajonEmpresa($user)
{
	$squery="select codempresa,nombre from cat_empresas";


$arbol1="
<div class=\"acidjs-css3-treeview\">
    
        
";
## ejecución de la sentencia sql

		$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						$contador++;
						
						$arbol2=$arbol1. "
                
                    <input type=\"checkbox\" id=\"node01-0$contador\" /><label><input id=\"ch01-0$contador\" type=\"checkbox\"".compEmpresa($user,$row['codempresa'])."onChange=\"asignarEmpresa(document.getElementById('codigo').value,document.getElementById('ch01-0$contador').checked,'".$row['codempresa']."');\" value=\"".$row['codempresa']."\"/><span></span></label><label for=\"node01-0$contador\">".$row['nombre']."</label>
                </li>
                
   
					";
							
					}
					$arbolcompleto=$arbol2. "        
        
    </ul>
</div>";
				
				}
				else
				{	
					return "Error de llenado de arbol";
				}
				
				return $arbolcompleto;
				
	}	
	
	function compEmpresa($usuario,$empresa)
	{
		$squery="select codacempr from acempresas where codusua='$usuario' and codempresa='$empresa'";
		
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
?>
