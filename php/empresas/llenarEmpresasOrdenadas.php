<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
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
			else
			{
				if($nombre==NULL && $rsocial==NULL && $email==NULL && !$nit==NULL)
				{
					$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where nit like '$nit%' ".$orden;
				}
				else
				{
					if(!$nombre==NULL && !$rsocial==NULL && $email==NULL && $nit==NULL)
					{
						$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where nombre like '$nombre%' and rsocial like '$rsocial%' ".$orden;
					}
					else
					{
						if(!$nombre==NULL && $rsocial==NULL && !$email==NULL && $nit==NULL)
						{
							$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where email like '$email%' and nombre like '$nombre%' ".$orden;
						}
						else
						{
							if(!$nombre==NULL && $rsocial==NULL && $email==NULL && !$nit==NULL)
							{
								$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where nit like '$nit%' and nombre like '$nombre%' ".$orden;
							}
							else
							{
								if($nombre==NULL && !$rsocial==NULL && !$email==NULL && $nit==NULL)
								{
									$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where email like '$email%' and rsocial like '$rsocial%' ".$orden;
								}
								else
								{
									if(!$nombre==NULL && !$rsocial==NULL && $email==NULL && !$nit==NULL)
									{
										$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where rsocial like '$rsocial%' and nombre like '$nombre%' and nit like '$nit%' ".$orden;
									}
									else
									{
										if($nombre==NULL && !$rsocial==NULL && !$email==NULL && !$nit==NULL)
										{
											$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where rsocial like '$rsocial%' and email like '$email%' and nit like '$nit%' ".$orden;
										}
										else
										{
											$squery="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email from cat_empresas where rsocial like '$rsocial%' and email like '$email%' and nit like '$nit%' and nombre like '$nombre%'".$orden;
										}
									}
								}
							}
							
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
					
						$contador++;
						
						$retornar=$retornar."<tr onClick=\"abrirEmpresa('".strtoupper($row['codempresa'])."');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['codempresa'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['codempresa'])."').value)\"  value=\"".strtoupper($row['codempresa'])."\" /></td>
								<td hidden=\"hidden\">".strtoupper($row['codempresa'])."</td>
								<td>".strtoupper($row['nombre'])."</td>
								<td>".strtoupper($row['npatronal'])."</td>
								<td>".strtoupper($row['rsocial'])."</td>
								<td>".strtoupper($row['direccion'])."</td>
								<td>".strtoupper($row['nit'])."</td>
								<td>".strtoupper($row['telefono'])."</td>
								<td>".strtoupper($row['email'])."</td>
							  </tr>";
							
					}
					$retornar=$retornar."</tbody></table></div><div class=\"\">
            <input type=\"button\"  class='cmd button button-highlight button-pill' onClick=\"LimpiarBuscarEmpresa();buscarEmpresasOrdenadas(document.getElementById('buscaUser').value,document.getElementById('buscaNIT').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaEmail').value,'');setTimeout(function(){tabllenar();},500);\" value=\"".$lang[$idioma]['Cancelar']."\" />   <input type=\"button\"  class='cmd button button-highlight button-pill' onClick=\"window.location.href='inicio.php'\" value=\"".$lang[$idioma]['Salir']."\"/></div>
			</center><br>
			
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
			<div>
        	<table id=\"tablas\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['Nombre']."</th>
					<th>".$lang[$idioma]['Npatronal']."</th>
                    <th>".$lang[$idioma]['Rsocial']."</th>
					<th>".$lang[$idioma]['Direccion']."</th>
                    <th>".$lang[$idioma]['Nit']."</th>
                    <th>".$lang[$idioma]['Telefono']."</th>
					<th>".$lang[$idioma]['Email']."</th>
                </tr> </thead>
                
			
            ";
}

				
				
?>
