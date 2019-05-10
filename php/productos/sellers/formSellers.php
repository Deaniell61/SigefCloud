
<?php
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

session_start();

?>
<script type="text/javascript">

function buscarSellers()
{
	nombre=document.getElementById('buscaSeller').value;
	canal='';
	
		$.ajax({
			url:'sellers/llenarSellers.php',
			type:'POST',
			data:'nombre='+nombre+'&canal='+
					canal,
					
			success: function(resp)
			{
				$('#datos').html(resp);
				setTimeout(function(){tabllenar();},500);
			}
        
		});
	}
	

</script>
<aside><div id="resultado"></div>

        	<table cellspacing="10px">
            	<tr>
                	<td style="width:250px;"><input type="text" class='entradaTextoBuscar' id="buscaSeller" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscarSellers();"/></td>
                
                	
                <?php if($_SESSION['rol']=='P') { ?>
                	<td class="" style="width:20%;"><input type="button" style="padding:0px;"  class='cmd button button-highlight button-pill' onClick="nuevoSeller('','<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>','<?php echo $_SESSION['codprov'];?>','<?php echo $_SESSION['codprod'];?>');" value="<?php echo $lang[$idioma]['NuevoSeller']?>"/></td><?php }?>
                </tr>
                 </table>
        </aside>
        
        <div id="datos">
        <script> buscarSellers(); </script>
        </div>	
            
        </div>
        


