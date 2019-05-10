<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

function estado1($es,$si)
				{
					$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
						if($es==$si)
						{
							return $lang[$idioma]['Activo'];
						}
						else
						{
							return $lang[$idioma]['Inactivo'];
						}
				}
				
				


## usuario y clave pasados por el formulario
$nombre= ucwords($_POST['nombre']);
$apellidor= ucwords($_POST['apellido']);
$email = ($_POST['email']);
if(strtoupper($_POST['orden'])!=" DESC"){$orden = strtoupper($_POST['orden']);}else{$orden = "";}


if($nombre==NULL && $apellidor==NULL && $email==NULL)
{
	$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios".$orden;
}
else
{
	if($nombre!=NULL && $apellidor==NULL && $email==NULL)
	{
		$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios where nombre like '$nombre%'".$orden;
	}
	else
	{
		if($nombre==NULL && $apellidor!=NULL && $email==NULL)
		{
			$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios where apellido like '$apellidor%'".$orden;
		}
		else
		{
			if($nombre==NULL && $apellidor==NULL && $email!=NULL)
			{
				$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios where email like '$email%'".$orden;
			}
			else
			{
				if($nombre!=NULL && $apellidor!=NULL && $email==NULL)
				{
					$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios where nombre like '$nombre%' and apellido like '$apellidor%'".$orden;
				}
				else
				{
					if($nombre!=NULL && $apellidor==NULL && $email!=NULL)
					{
						$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios where nombre like '$nombre%' and email like '$email%'".$orden;
					}
					else
					{
						if($nombre==NULL && $apellidor!=NULL && $email!=NULL)
						{
							$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios where email like '$email%' and apellido like '$apellidor%'".$orden;
						}
						else
						{
							$squery="select codusua,nombre,apellido,posicion,email,estado from sigef_usuarios where email like '%$email%' and apellido like '%$apellidor%' and nombre like '%$nombre%'".$orden;
						}
					}
				}
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
					
						switch(strtoupper($row['posicion']))
						{
							case "A":
							{
								$tipo="Administrador";
								break;
							}
							case "U":
							{
								$tipo="Usuario";
								break;
							}
							case "P":
							{
								$tipo="Proveedor";
								break;
							}
							
						}
						
						$contador++;
						$retornar=$retornar. "<tr onClick=\"abrirUsuario('".$row['codusua']."');\">
								<td><input type=\"checkbox\" id=\"".($row['codusua'])."\" onClick=\"agregarAccesos(document.getElementById('".($row['codusua'])."').value)\"  value=\"".($row['codusua'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".($row['codusua'])."\" /></td>
								<td>".($row['nombre'])."</td>
								<td>".($row['apellido'])."</td>
								<td>".($tipo)."</td>
								<td>".($row['email'])."
							  <td>
							  	
						".estado1($row['estado'],'1')."
						
					
					</td>
							  
								</tr>";
							
					}
					$retornar=$retornar. "</tbody></table></div>
					<div class=\"\">
              <input type=\"button\"  class='cmd button button-highlight button-pill' onClick=\"LimpiarBuscarUsua();buscarUsuarioOrdenado(document.getElementById('buscaUser').value,document.getElementById('buscaApel').value,document.getElementById('buscaEmail').value,'');setTimeout(function(){tabllenar();},500);\" value=\"".$lang[$idioma]['Cancelar']."\" />   <input type=\"button\"  class='cmd button button-highlight button-pill' onClick=\"window.location.href='inicio.php'\" value=\"".$lang[$idioma]['Salir']."\"/>
			</div></center><br>
			<script   type=\"text/javascript\">

           $(document).ready(function(){
    
   $('#tablas').DataTable( {
        \"scrollY\": \"500px\",
        \"scrollX\": true,
        \"paging\":  true,
        \"info\":     false,
        \"oLanguage\": {
      \"sLengthMenu\": \" _MENU_ \",
      
  
      
    }
        
         
         
    } );
    
  ejecutarpie();
     
});

           </script>";
				}
				else
				{	
					$retornar= "Error";
				}
				
				return $retornar;
}
function encabezado()
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	return "<center>
			<div>
        	<table id=\"tablas\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"hover tablas table\">
				<thead>
            	<tr class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
                    <th>".$lang[$idioma]['Nombre']."</th>
                    <th>".$lang[$idioma]['Apellido']."</th>
                    <th>".$lang[$idioma]['Tipo']."</th>
                    <th>".$lang[$idioma]['Email']."</th>
					<th>".$lang[$idioma]['Estado']."</th>
                </tr></thead>
                
            ";
}
				
?>
