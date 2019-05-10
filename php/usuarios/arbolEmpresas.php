
<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');


function cajonEmpresa($user)
{
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	$contador=0;
$arbol1="
<div class=\"acidjs-css3-treeview\">
    <ul>";	

$squery1="select codpais,nompais from direct";
		$ejecutar1=mysqli_query(conexion(""),$squery1);
				if($ejecutar1)
				{
					$contador1=0;
					while($row1=mysqli_fetch_array($ejecutar1,MYSQLI_ASSOC))
					{

						$contador1++;
        $arbol1=$arbol1. "<li>
            <input type=\"checkbox\" id=\"node0$contador1\" checked=\"checked\" /><label for=\"node0$contador1\">".$row1['nompais']."</label>
            <ul>
";
## ejecución de la sentencia sql
$squery="select codempresa,nombre from cat_empresas where pais='".$row1['codpais']."'";
		$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						$contador++;
						
						$arbol1=$arbol1. "
                <li>
                    <input type=\"checkbox\" id=\"node01-0$contador\" onChange=\"asignarEmpresa(document.getElementById('codigo').value,false,'".$row['codempresa']."');asignarEmpresa(document.getElementById('codigo').value,true,'".$row['codempresa']."');\" /><label><input id=\"ch01-0$contador\"  type=\"checkbox\"".compEmpresa($user,$row['codempresa'])."onChange=\"asignarEmpresa(document.getElementById('codigo').value,document.getElementById('ch01-0$contador').checked,'".$row['codempresa']."');\" value=\"".$row['codempresa']."\"/><span></span></label><label for=\"node01-0$contador\">".$row['nombre']."</label>
                
                
						<ul>
							".DesplegarProveedores($row['codempresa'],$row1['nompais'],$user,'0'.$contador)."
						</ul>
   				</li>
					";
							
					}
				}
					$arbol1=$arbol1. "         </ul>
        </li>
				
";
					}
				
				$arbol1=$arbol1."</ul></div>";
				
				}
				else
				{	
					return "Error";
				}
				
				return $arbol1;
				
	}	
	
	function compEmpresa($usuario,$empresa)
	{
		$squery="select codacempr from acempresas where (codusua='$usuario' and codempresa='$empresa')";
		
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
	function compProv($usuario,$empresa)
	{
		$squery="select codacprov from acprov where (codusua='$usuario' and codprov='$empresa')";
		
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
	
	function DesplegarProveedores($codEmpresa,$pais,$user1,$codi)
	{	
		$arbol1="";
		$squery="select codprov,nombre from cat_prov where codempresa='".$codEmpresa."'";
		
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						$contador++;
						
						$arbol1=$arbol1. "
                <li>
                    <input type=\"checkbox\" id=\"node01-$codi-0$contador\" /><label><input id=\"ch01-$codi-0$contador\" type=\"checkbox\"".compProv($user1,$row['codprov'])."onChange=\"asignarProveedor('".$user1."',document.getElementById('ch01-$codi-0$contador').checked,'".$row['codprov']."','".$codEmpresa."');\" value=\"".$row['codprov']."\"/><span></span></label><label for=\"node01-$codi-0$contador\">".$row['nombre']."</label>
                </li>
					";
							
					}
				}
					$arbol1=$arbol1. "         
        
				
";
			return $arbol1;
	}
?>
