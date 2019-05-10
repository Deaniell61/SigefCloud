<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$nombre= strtoupper($_POST['nombre']);
$rsocial= strtoupper($_POST['rsocial']);
$email = strtoupper($_POST['email']);
$nit = strtoupper($_POST['nit']);
if(strtoupper($_POST['orden'])!=" DESC"){$orden = strtoupper($_POST['orden']);}else{$orden = "";}

if($nombre==NULL && $rsocial==NULL && $email==NULL && $nit==NULL)
{
	$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas ".$orden;
	
	
}
else
{
	if(!$nombre==NULL && $rsocial==NULL && $email==NULL && $nit==NULL)
	{
		$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where nombre like '$nombre%' ".$orden;
	}
	else
	{
		if($nombre==NULL && !$rsocial==NULL && $email==NULL && $nit==NULL)
		{
			$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where rsocial like '$rsocial%' ".$orden;
		}
		else
		{
			if($nombre==NULL && $rsocial==NULL && !$email==NULL && $nit==NULL)
			{
				$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where email like '$email%' ".$orden;
			}
			
		}
	}

}

## ejecución de la sentencia sql

echo encabezado().

		 tabla($squery);
		
		function tabla($squer)
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	$retornar="";
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion(""),$squer);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						$contador++;
						
						$retornar=$retornar."<tr onClick=\"abrirBancos('".strtoupper($row['codempresa'])."');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['codempresa'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['codempresa'])."').value)\"  value=\"".strtoupper($row['codempresa'])."\" /></td>
								<td hidden=\"hidden\">".strtoupper($row['codempresa'])."</td>
								<td>".strtoupper($row['nombre'])."</td>
								<td>".strtoupper($row['npatronal'])."</td>
								<td>".strtoupper($row['rsocial'])."</td>
								<td>".strtoupper($row['direccion'])."</td>
								</tr>";
							
					}
					$retornar=$retornar."</tbody></table></div>
            <input type=\"button\" onClick=\"LimpiarBuscarBancos();buscarBancos(document.getElementById('buscaUser').value,document.getElementById('buscaNIT').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaEmail').value,'');setTimeout(function(){tabllenar();},500);\" value=\"".$lang[$idioma]['Cancelar']."\" />   <input type=\"button\" onClick=\"window.location.href='inicio.php'\" value=\"".$lang[$idioma]['Salir']."\"/>
			</center><br>";
				}
				else
				{	
					$retornar="$squer Error de llenado de tabla";
				}
				
				return $retornar;
}

function encabezado()
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	return "<center>
			<div style=\"overflow: auto;height: 200px;\">
        	<table id=\"tablaDatos\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"tablesorter\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >Numero de Cuenta</th>
					<th>Nombre de la Cuenta</th>
                    <th>Banco</th>
					<th>Logo</th>
                    
                </tr> </thead>
                
			
            ";
}

				
				
?>
