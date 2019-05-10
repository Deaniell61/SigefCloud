<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$nombre= ucwords(strtolower($_POST['nombre']));
$email = ($_POST['email']);
$nit = ($_POST['nit']);
$pais= $_POST['pais'];
$codpais= $_POST['codpais'];
if($nombre==NULL && $email==NULL && $nit==NULL)
{
	$squery="select pv.codprov,pv.nombre,pv.direccion,pv.nit,pv.telefono,pv.fax,pv.mailcontac,pv.estado from cat_prov pv where pv.tipo=1";
}


## ejecución de la sentencia sql

echo encabezado().
		 tabla($squery,$pais,$codpais);
		
function tabla($squer,$pais,$codpais)
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	$retornar="";
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion($pais),$squer);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						switch($row['estado'])
						{
							case "0":
							{
								$estado="Inactivo";
								break;
							}
							case "1":
							{
								$estado="Activo";
								break;
							}
							case "2":
							{
								$estado="Pendiente";
								break;
							}
							default:
							{
								$estado="Inactivo";
								break;
							}
						}
					
						$contador++;
						
						$retornar=$retornar."<tr onClick=\"abrirProveedor('".strtoupper($row['codprov'])."','".$pais."','".$codpais."');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['codprov'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['codprov'])."').value)\"  value=\"".strtoupper($row['codprov'])."\" /></td>
								<td hidden=\"hidden\">".($row['codprov'])."</td>
								<td>".($row['nombre'])."</td>
								<td>".($row['direccion'])."</td>
								<td>".($row['nit'])."</td>
								<td>".($row['telefono'])."</td>
								<td>".($row['mailcontac'])."</td>
								<td>".($estado)."</td>
								
							  </tr>";
							
					}
					}
				else
				{	
					$retornar="Error de llenado de tabla";
				}
					$retornar=$retornar."</tbody></table></div><div class=\"guardar\">
            <input type=\"button\"   class='cmd button button-highlight button-pill'  onClick=\"LimpiarBuscarEmpresa();buscarEmpresasOrdenadas(document.getElementById('buscaUser').value,document.getElementById('buscaNIT').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaEmail').value,'');setTimeout(function(){tabllenar();},500);\" value=\"".$lang[$idioma]['Cancelar']."\" />   
			
			<input type=\"button\"  class='cmd button button-highlight button-pill'  onClick=\"window.location.href='inicio.php'\" value=\"".$lang[$idioma]['Salir']."\"/></div>
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
				
				
				return $retornar;
}

function encabezado()
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	return "<center>
			<div>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['Nombre']."</th>
					<th>".$lang[$idioma]['Direccion']."</th>
                    <th>".$lang[$idioma]['Nit']."</th>
                    <th>".$lang[$idioma]['Telefono']."</th>
					<th>".$lang[$idioma]['Email']."</th>
					<th>".$lang[$idioma]['Estado']."</th>
					
                </tr> </thead>
                
			
            ";
}

				
				
?>
