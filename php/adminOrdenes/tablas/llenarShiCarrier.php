<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$nombre= ucwords(strtolower($_POST['nombre']));
if($nombre==NULL)
{
	$squery="select codcarrier,nombre,username,apikey,apiurl,urldeliver from cat_shi_carrier ";
}
else
{
	$squery="select codcarrier,nombre,username,apikey,apiurl,urldeliver from cat_shi_carrier where nombre like '%".$nombre."%' or username like '%".$nombre."%' or apiurl like '%".$nombre."%' or urldeliver like '%".$nombre."%'";
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
	$total=0;
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion(""),$squer);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						
						
						$retornar=$retornar."<tr  onClick=\"abrirAdminOrder('ShiCarrier','".$row['0']."');\" >
								<td><input type=\"checkbox\" id=\"".strtoupper($row['0'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['0'])."').value)\"  value=\"".strtoupper($row['0'])."\" /></td>
								<td hidden=\"hidden\">".($row['0'])."</td>
								<td>".($row['1'])."</td>
								<td>".($row['2'])."</td>
								<td>".($row['3'])."</td>
								<td>".($row['4'])."</td>
								<td>".($row['5'])."</td>
								
								
							  </tr>";
					
					}
						}
						mysqli_close(conexion(""));
					
				}
				else
				{	
					$retornar="Error de llenado de tabla";
				}
					$retornar=$retornar."</tbody></table></div>
			</center><br>
			
			<script   type=\"text/javascript\">

           $(document).ready(function(){
    
   $('#tablas').DataTable( {
        \"scrollY\": \"300px\",
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
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	return "<center>
			<div>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['Nombre']."</th>
					<th >".$lang[$idioma]['usernameCAR']."</th>
					<th >".$lang[$idioma]['apikeyCAR']."</th>
					<th >".$lang[$idioma]['apiurlCAR']."</th>
					<th >".$lang[$idioma]['urldeliverCAR']."</th>
					
					
                </tr> </thead>
                
			
            ";
}

				
				
?>
