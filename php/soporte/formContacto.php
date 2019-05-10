<?php
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
?>
<script>
paisGlobal="";
codPaisGlobal="";

</script>
<center><?php echo $lang[$idioma]['Contacto2'];?></center>

        <div id="datos">
        	<div id="resultado"></div>
            	
                <form id="contacto">
                <center>
                	<table>
                    	<tbody>
                       		<tr hidden>
                            	<td class="text">
                                	<?php echo $lang[$idioma]['Usuario'];?>
                                </td>
                                <td>
                                	<input type="text" id="usuario" disabled class="entradaTexto" value="<?php echo $_SESSION['codigo'];?>">
                                </td>
                            </tr>
                        	<tr>
                            	<td class="text">
                                	<?php echo $lang[$idioma]['Asunto'];?>
                                </td>
                                <td>
                                	<input type="text" id="asunto" class="entradaTexto">
                                </td>
                            </tr>
                            <tr> 
                            	<td class="text">
                                	<?php echo $lang[$idioma]['Email'];?>
                                </td>
                                <td>
                                	<input type="text" id="email" class="entradaTexto" value="<?php echo $_SESSION['user'];?>">
                                </td>
                            </tr>
                            <tr> 
                            	<td class="text">
                                	<?php echo $lang[$idioma]['Descripcion'];?>
                                </td>
                                <td>
                                	<textarea class='entradaTexto textoGrande' id="descript" style="text-align: left; width:calc(90%);" rows="7"></textarea>
                                </td>
                            </tr>
                             <tr>
                        <td class="" colspan="2">
                        <center>
                            <input type="button" class='cmd button button-highlight button-pill' id="envioContacto"
                                   onClick="ingresoContacto();"
                                   value="<?php echo $lang[$idioma]['Enviar']; ?>"/>
                            <!--onClick="verificaEspeciales();guardarProducto();window.opener.formulario('1');"-->
                            <input type="reset" class='cmd button button-highlight button-pill'
                                   onClick="__('contacto').reset();"
                                   value="<?php echo $lang[$idioma]['Limpiar2']; ?>"/>
                                   </center>
                        </td>
                    </tr>
                            
                        </tbody>
                    </table>
                    </center>
                </form>
              <div id="cargaLoadCon"></div>  
        </div>	
            
        </div>
        
       
       		

