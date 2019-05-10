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
session_start();
$pais = $_POST['pais'];
$_SESSION['pais']=$pais;

if($nombre==NULL)
{
	$squery="select codchan,channel,pminsale,columna from cat_sal_cha order by channel desc";
}
else
{

	$squery="select codchan,channel,pminsale,columna from cat_sal_cha where channel like '%$nombre%'";

}

## ejecución de la sentencia sql
echo $pais;
echo encabezado().
		tabla($squery,$pais);
				
function tabla($squer,$pais)
{
	
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	$retornar="";
	$retornar=$retornar."<tbody>";
					$ejecutar=mysqli_query(conexion($pais),$squer);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						
						$contador++;
						$retornar=$retornar. "<tr onClick=\"abrirCanal('".$row['codchan']."');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['codchan'])."\" onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['codchan'])."').value)\"  value=\"".strtoupper($row['codchan'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".strtoupper($row['codchan'])."\" /></td>
								<td>".strtoupper($row['channel'])."</td>
								<td>".strtoupper($row['pminsale'])."</td>
							
							  
								</tr>";
							
					}
					}
				else
				{	
					$retornar= $squer;
				}
					$retornar=$retornar. "</tbody></table></div><div class=\"\">
              <input type=\"button\" class='cmd button button-highlight button-pill' onClick=\"LimpiarBuscarUsua();buscarUsuarioOrdenado(document.getElementById('buscaUser').value,document.getElementById('buscaApel').value,document.getElementById('buscaEmail').value,'');setTimeout(function(){tabllenar();},500);\" value=\"".$lang[$idioma]['Cancelar']."\" />   <input type=\"button\"  class='cmd button button-highlight button-pill' onClick=\"window.location.href='inicio.php'\" value=\"".$lang[$idioma]['Salir']."\"/>
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
				
				
				return $retornar;
}
function encabezado()
{
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	return "<center>
		<div>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"0\" class=\"hover tablas table\">
				<thead>
            	<tr class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\" /></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
                    <th>".$lang[$idioma]['Nombre']."</th>
                    <th>".$lang[$idioma]['marminsalp']."</th>
                    
                </tr></thead>
                
            ";
}

				
?>
