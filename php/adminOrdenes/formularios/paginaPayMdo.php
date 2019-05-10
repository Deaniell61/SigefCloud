<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
require_once('../../combosVarios.php');
session_start();
$codigo=$_POST['codigo'];
$tipo=$_POST['tipo'];

if($codigo!="")
{
		echo "
		<script>
		buscarDatosAuxOrdenes('".$tipo."','".$codigo."');
		</script>
		";
}

?>
<script language="JavaScript" type="text/JavaScript">
Full();
	function tags(codig)
	{
		$.ajax({
					url:'../combosVarios.php',
					type:'POST',
					data:'tipo=tags&codigo='+codig,
					success: function(resp)
					{
						
						document.getElementById('lbCuentacob').innerHTML=(resp);
						
						
					}
					
				});
				
	}
  $( function() {
    var availableTags = [
      <?php
	  	 echo tags('');
	  ?>
    ];
    $( "#cuentacob" ).autocomplete({
		
      source: availableTags,
	  close: function(){separar(document.getElementById('cuentacob'),'lbCuentacob');}
    });
  } );
  
</script>
<div id="auxOrde">
<form id="formAux" action="return false" onSubmit="return false" method="POST">
      <center>
      <div class="tituloCatalogo">
    	 <br>
    	 <strong>
    	  &nbsp;&nbsp;<?php echo $lang[ $idioma ]['catpaymdo']; ?>
    	 </strong>
			</div>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
                <tr hidden>
            	<td class="text"><span><?php echo $lang[$idioma]['paymdo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo" ></td>
                
            </tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['paymdo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="nombre"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Descripcion'];?></span></td>
                <td class="colo1"><textarea class='entradaTexto' id="descripcion" rows="5" style="width: 64%;"></textarea></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Descripcion'];?></span></td>
                <td class="colo1"  style="text-align:left;">
                		<div class="ui-widget" style="text-align:left;">
                            <input type="text" class='entradaTexto' id="cuentacob" onKeyUp="tags(this.value);">
                            <div id="lbCuentacob" style="display: inline;"></div>
                                </div></td>
                
            </tr>
            <tr>

            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="ingresoAux('payMdo');" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="envioDeDataAuxOrdenes('');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>

