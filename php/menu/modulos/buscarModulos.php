<?php
require_once('../../fecha.php');
require_once('../../coneccion.php');
$idioma=idioma();
require_once('../../idiomas/'.$idioma.'.php');
formulario();
$codigo=$_POST['codigo'];
$squery="select codigo,nombre,tipo,aplicacion,link from sigef_modulos where codigo='".$codigo."'";
// echo $squery;

## ejecución de la sentencia sql

				$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					$contador=0;

					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						echo "<script>
						$(document).ready(function () {
							llenarDatosModulos();
		
						});
						llenarDatosModulos()
						{
							
								document.getElementById('codigo').value = \"".$row['codigo']."\";
								document.getElementById('trCodigo').hidden = false;
								document.getElementById('codigo').disabled = true;
								document.getElementById('nombre').value = \"".$row['nombre']."\";
								document.getElementById('tipo').value = \"".$row['tipo']."\";
								document.getElementById('link').value = \"".$row['link']."\";
								document.getElementById('aplicacion').value = \"".$row['aplicacion']."\";
								".mostrarAplicacion($row['tipo'])."
								document.getElementById('nivel').value = '".nivel($row['codigo']."")."';
								llenarPadres(document.getElementById('nivel').value);
								
								setTimeout(function(){document.getElementById('padre').value = \"".substr($row['codigo'],0,strlen($row['codigo'])-3)."\"},500);
								
						}
								</script>";
					}
					
				}
function mostrarAplicacion($tipo)
{
	if(strtoupper($tipo)=="F")
	{
		return "document.getElementById('trAplicacion').hidden=false";
	}
}
function formulario()
{
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');				

?>
<div id="productos">
<form id="modulos" action="return false" onSubmit="return false" method="POST">
                	<center>
        <table>
        	<tr>
            	<?php echo $lang[$idioma]['IngresoModulos'];?>
                </tr>
                <tr><div id="resultado"></div></tr>
                <tr id="trCodigo" hidden>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="codigo" id="codigo" autofocus placeholder="<?php echo $lang[$idioma]['Codigo'];?>" ></td>
            </tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Nombre'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="nombre" id="nombre" autofocus placeholder="<?php echo $lang[$idioma]['Nombre'];?>" ></td>
            </tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Link'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="link" id="link" autofocus placeholder="<?php echo $lang[$idioma]['Link'];?>" ></td>
            </tr>
            
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Tipo'];?></span></td>
                <td class="colo1"><select class='entradaTexto' id="tipo" onChange="habilitarAplicacion();">
                		<option value="M">Menu</option>
                        <option value="F">Formulario</option>
                	</select></td>
            </tr>
            <tr hidden id="trAplicacion">
            	<td class="text"><span><?php echo $lang[$idioma]['Aplicacion'];?> </span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="aplicacion" id="aplicacion" value="" placeholder="<?php echo $lang[$idioma]['Aplicacion'];?>" ></td>
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Nivel'];?></span></td>
                <td class="colo1"><input class='entradaTexto' type="number" min="0" max="7" name="nivel" id="nivel" onChange="llenarPadres(document.getElementById('nivel').value);" value="0" ><div id="comprobar" ></div></td>
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Padre'];?> </span></td>
                <td><div id="padres">
                		
                	</div></td>
            </tr>
			
            <tr>
				<td></td><td></td>
            </tr>
			
			<tr>
           
			<td colspan="2"> 
            <input type="button"   class='cmd button button-highlight button-pill' onClick="ingresarModulo();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
           	<input type="reset"  class='cmd button button-highlight button-pill' onClick="document.getElementById('modulos').reset();document.getElementById('nombre').className= 'normal';document.getElementById('nombre').focus();" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            </td>
             </tr>
        </table>
        </center>
                </form>
                </div>
                <br>
<?php }

function nivel($nivel)
{
	$nive=strlen($nivel);
	switch($nive)
	{
		case strlen("00"):{return 0; break;}
		case strlen("00.00"):{return 1; break;}
		case strlen("00.00.00"):{return 2; break;}
		case strlen("00.00.00.00"):{return 3; break;}
		case strlen("00.00.00.00.00"):{return 4; break;}
		case strlen("00.00.00.00.00.00"):{return 5; break;}
	}
}
?>
        

