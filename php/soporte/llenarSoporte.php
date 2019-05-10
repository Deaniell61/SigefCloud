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
$extra="";
$extra2="";

if(isset($_POST['coduser']))
{
	$coduser= $_POST['coduser'];
	$extra=" where tr.codusua='".$coduser."'";
	$extra2=" and tr.codusua='".$coduser."'";

}


	
if($nombre==NULL)
{
	$squery="select tr.numticket,tr.codticket,tr.fecha_ini,tr.fecha_fin,tr.estatus,tr.asunto,(select p.nombre from cat_prov p where p.codprov=tr.codprov) as prov,emailusua from tra_ticket_enc tr $extra";
}
else
{
	$squery="select tr.numticket,tr.codticket,tr.fecha_ini,tr.fecha_fin,tr.estatus,tr.asunto,(select p.nombre from cat_prov p where p.codprov=tr.codprov) as prov,emailusua from tra_ticket_enc tr where tr.numticket like '%$nombre%' or tr.fecha_ini like '%$nombre%' or tr.fecha_fin like '%$nombre%' or tr.asunto like '%$nombre%' $extra";
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
						
					
					
						$contador++;
						
						$retornar=$retornar."<tr onClick=\"abrirSoporte('".strtoupper($row['1'])."','".$pais."','".$codpais."');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['1'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['1'])."').value)\"  value=\"".strtoupper($row['1'])."\" /></td>
								<td hidden=\"hidden\">".($row['1'])."</td>
								<td>".($row['0'])."</td>
								<td>".($row['5'])."</td>
								<td>".($row['2'])."</td>
								<td>".($row['3'])."</td>
								<td>".($row['6'])."</td>
								<td>".($row['7'])."</td>
								<td>".($row['4'])."</td>
								
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
				mysqli_close(conexion($pais));
	
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
					<th >".$lang[$idioma]['TNumero']."</th>
					<th>".$lang[$idioma]['Asunto']."</th>
                    <th>".$lang[$idioma]['FechaIni']."</th>
                    <th>".$lang[$idioma]['FechaFin']."</th>
					<th>".$lang[$idioma]['Proveedor']."</th>
					<th>".$lang[$idioma]['Usuario']."</th>
					<th>".$lang[$idioma]['Estado']."</th>
					
                </tr> </thead>
                
			
            ";
}

				
				
?>
