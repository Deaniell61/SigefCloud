<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$nombre= ucwords(strtolower($_POST['nombre']));
$pais= $_POST['pais'];
$codpais= $_POST['codpais'];
if($nombre==NULL)
{
	$squery="select notifica,codnoti,fechaini,fechafin,condicion,destino,estatus from cat_notificaciones";
}
else
{
	$squery="select notifica,codnoti,fechaini,fechafin,condicion,destino,estatus from cat_notificaciones where notifica like '%$nombre%' or condicion like '%$nombre%' or fechafin like '%$nombre%' or fechaini like '%$nombre%'";
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
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						switch($row['6'])
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
						
						$retornar=$retornar."<tr onClick=\"abrirNotificacion('".strtoupper($row['1'])."','".$pais."','".$codpais."');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['1'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['1'])."').value)\"  value=\"".strtoupper($row['1'])."\" /></td>
								<td hidden=\"hidden\">".($row['1'])."</td>
								<td>".($row['0'])."</td>
								<td>".($row['2'])."</td>
								<td>".($row['3'])."</td>
								<td>".($row['4'])."</td>
								<td>".($row['5'])."</td>
								<td>".($estado)."</td>
								
							  </tr>";
					
					}
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
				
				$retornar=$retornar."<div id='NotificacionVentana'></div>";	
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
					<th >".$lang[$idioma]['Notifica']."</th>
					<th>".$lang[$idioma]['FechaIni']."</th>
                    <th>".$lang[$idioma]['FechaFin']."</th>
                    <th>".$lang[$idioma]['Condicion']."</th>
					<th>".$lang[$idioma]['Destino']."</th>
					<th>".$lang[$idioma]['Estado']."</th>
					
                </tr> </thead>
                
			
            ";
}

				
				
?>
