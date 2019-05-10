<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

function estado1($es,$si)
				{
					$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
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
$nombre= strtoupper($_POST['nombre']);
$codigo= strtoupper($_POST['codigo']);
$tipo = strtoupper($_POST['tipo']);
if(strtoupper($_POST['orden'])!=" DESC"){$orden = strtoupper($_POST['orden']);}else{$orden = "";}


if($nombre==NULL && $codigo==NULL && $tipo==NULL)
{
	$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos";

}
else
{
	if($nombre!=NULL && $codigo==NULL && $tipo==NULL)
	{
		$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos where nombre like '".$nombre."%'";
	}
	else
	{
		if($nombre==NULL && $codigo!=NULL && $tipo==NULL)
		{
			$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos where codigo like '".$codigo."%'";
		}
		else
		{
			if($nombre==NULL && $codigo==NULL && $tipo!=NULL)
			{
				$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos where tipo like '".$tipo."%'";
			}
			else
			{
				if($nombre!=NULL && $codigo!=NULL && $tipo==NULL)
				{
					$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos where nombre like '".$nombre."%' and codigo like '".$codigo."%'";
				}
				else
				{
					if($nombre!=NULL && $codigo==NULL && $tipo!=NULL)
					{
						$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos where nombre like '".$nombre."%' and tipo like '".$tipo."%'";
					}
					else
					{
						if($nombre==NULL && $codigo!=NULL && $tipo!=NULL)
						{
							$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos where codigo like '".$codigo."%' and tipo like '".$tipo."%'";
						}
						else
						{
							$squery="select codigo,nombre,tipo,aplicacion from sigef_modulos where nombre like '".$nombre."%' and  codigo like '".$codigo."%' and tipo like '".$tipo."%'";
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
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	$retornar="";
	$retornar=$retornar."<tbody>";
					$ejecutar=mysqli_query(conexion(""),$squer);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						
						$contador++;
						$retornar=$retornar. "<tr onClick=\"abrirModulo('".$row['codigo']."');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['codigo'])."\" onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['codigo'])."').value)\"  value=\"".strtoupper($row['codigo'])."\" /></td>
								<td>".strtoupper($row['codigo'])."</td>
								<td>".strtoupper($row['nombre'])."</td>
								<td>".strtoupper($row['aplicacion'])."</td>
								<td>".strtoupper($row['tipo'])."</td>
								
							
							  
								</tr>";
							
					}
					$retornar=$retornar. "</tbody></table></div><div class=\"\">
              <input type=\"button\"  class='cmd button button-highlight button-pill' onClick=\"LimpiarBuscarModulos();buscarModulos(document.getElementById('buscaNombre').value,document.getElementById('buscaCodigo').value,document.getElementById('buscaTipo').value,'');setTimeout(function(){tabllenar();},500);\" value=\"".$lang[$idioma]['Cancelar']."\" />   <input type=\"button\"  class='cmd button button-highlight button-pill' onClick=\"window.location.href='inicio.php'\" value=\"".$lang[$idioma]['Salir']."\"/>
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
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	return "<center>
	<div>
        	<table id=\"tablas\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
				<thead>
            	<tr class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th>".$lang[$idioma]['Codigo']."</th>
                    <th>".$lang[$idioma]['Nombre']."</th>
                    <th>".$lang[$idioma]['Aplicacion']."</th>
                    <th>".$lang[$idioma]['Tipo']."</th>
                </tr></thead>
                
            ";
}
				
?>
