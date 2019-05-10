<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$codempresa=limpiar_caracteres_sql($_POST['codempresa']); 
$pais=limpiar_caracteres_sql($_POST['pais']);
$category=limpiar_caracteres_sql($_POST['category']);


session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];

?>
<center>
<div id="datos">
        	<?php
				
			echo encabezado().
				tabla($pais,$codempresa,$category);
            ?>  
</div>              
</center>
<?php

function identifica($val)
{
	$id="";
	switch($val)
	{
		case "marca":
		{
			$id="marcaEsp";
			break;
		}
		case "ciudad":
		{
			$id="ciudadEsp";
			break;
		}
	}
	
	return $id;
}
function tabla($pais,$codempresa,$category)
{
	
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$squer="select esp.codespatr,esp.nombre,teap.valor as valor,esp.valor as po,esp.ident from cat_esp_atr esp inner join tra_esp_atr catesp on catesp.codespatr=esp.codespatr inner join tra_esp_atr_pro teap on teap.codespatr=esp.codespatr where catesp.codcate='".$category."' and teap.codprod='".$_SESSION['codprod']."'";
	$retornar="";

	$retornar=$retornar."<tbody>";
					$ejecutar=mysqli_query(conexion($pais),$squer);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						
						
						$contador++;
						$retornar=$retornar. "<tr>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".strtoupper($row['codespatr'])."\" /></td>
								<td>".strtoupper($row['nombre'])."</td>
								<td id='".identifica($row['ident'])."'>".$row['valor']."</td>
								<td id='".identifica($row['ident'])."1' hidden>".$row['codespatr']."</td>
							  
								</tr>
								";
								/*<script>
								combo=document.getElementById('marca');
								document.getElementById('col".$contador."').innerHTML=combo.options[combo.selectedIndex].text;</script>
							*/
					}
					$retornar=$retornar. "</tbody></table>
              </center><br>";
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
	
        	<table id=\"tablaDatos\" width=\"100%\" cellspacing=\"1\" cellpadding=\"0\" class=\"tablesorter\">
				<thead>
            	<tr class=\"titulo\">
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
                    <th>".$lang[$idioma]['Nombre']."</th>
                    <th class=\"check\"><img src=\"../../images/yes.jpg\" /></th>
                    
                </tr></thead>
                
            ";
}



?>

    


