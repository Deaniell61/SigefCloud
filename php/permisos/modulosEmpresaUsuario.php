<?php
sleep(1);
require_once('../coneccion.php');
require_once('modulos.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$empresa=strtoupper($_POST['empresa']);
$usuario=strtoupper($_POST['usuario']);
$codigo=strtoupper($_POST['codigo']);

	$squery="select e.nombre as empresa,u.nombre as nombre,u.apellido as apellido,a.codacempr as codigo from acempresas a
				inner join sigef_usuarios u on a.codusua=u.codusua
				inner join cat_empresas e on a.codempresa=e.codempresa 
				where (e.codempresa='$empresa' and u.codusua='$usuario') or a.codacempr='$codigo'";
				
				$ejecutar=mysqli_query(conexion(""),$squery);
if($ejecutar)				
{
	$row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC);

echo "
	<form id=\"permisos\" name=\"pemisos\" action=\"return false\" onSubmit=\"return false\" method=\"POST\">
                	<center>
        <table>
		<tr><div class=\"header\">".$lang[$idioma]['PermisosModulos']."</div></tr>
		<tr><div id=\"resultado\"></div></tr>
		<tr><select id=\"rol\">
					<option>".$lang[$idioma]['SelecRol']."</option>
					<option".rolEmpresa($usuario,$empresa,$codigo,'1')."onClick=\"agregarRol('1','".$usuario."','".$empresa."','".$codigo."');\">".$lang[$idioma]['AccesosTotal']."</option>
					<option".rolEmpresa($usuario,$empresa,$codigo,'2')."onClick=\"agregarRol('2','".$usuario."','".$empresa."','".$codigo."');\">".$lang[$idioma]['AccesosModificar']."</option>
					<option".rolEmpresa($usuario,$empresa,$codigo,'3')."onClick=\"agregarRol('3','".$usuario."','".$empresa."','".$codigo."');\">".$lang[$idioma]['AccesosReporteria']."</option>
					<option".rolEmpresa($usuario,$empresa,$codigo,'4')."onClick=\"agregarRol('4','".$usuario."','".$empresa."','".$codigo."');\">".$lang[$idioma]['AccesosVisor']."</option>
			 </select></tr>
		<tr>
			<td class=\"titulo\">".$lang[$idioma]['Empresa']." <input type=\"text\" value=\"".$row['empresa']."\" disabled /></td>
			<td class=\"titulo\">".$lang[$idioma]['Usuario']." <input type=\"text\" value=\"".$row['nombre']." ".$row['apellido']."\" disabled /></td>
		</tr>
		
		<tr><td><br></td><td><br></td></tr>
";

echo "
<tr>
<td class=\"modulos\">
<center>".$lang[$idioma]['Modulos']."</center>
<div class=\"acidjs-css3-treeview\">
    
        
";
## ejecución de la sentencia sql

		
echo menu($empresa,$usuario)." 
	
	</div>
	</td>
		<td class=\"modulos\">
		<center>".$lang[$idioma]['Opciones']."</center>
		<div id=\"opcion\">
                		
                	</div></td>
	</tr>
	<tr><td></td><td><br></td></tr>
	<tr><td class='' colspan='2'><input type=\"reset\"  class='btn button button-highlight button-pill' onClick=\"envioDeDataPermiso('user');\" value=\"".$lang[$idioma]['Cancelar']."\"/></td></tr>
	<tr><td></td><td><br></td></tr>
	</table>
	</center>
	</form>
	";			
							
				
		
	}
function rolEmpresa($usuario,$empresa,$codigo,$rol)
	{
		$squery="select codacempr from acempresas where codusua='$usuario' and codempresa='$empresa' and codacempr='$codigo' and rol='$rol'";
		
		$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					return " selected=\"selected\" ";
					}
					else
					{
						return " ";
					}
				}
					
	}
	
?>
