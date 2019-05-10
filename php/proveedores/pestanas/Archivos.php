<?php
header("Expires: TUE, 18 Jul 2015 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
verTiempo2();
$codprov=$_POST['codigo'];
	

?>





<!--AJAXUPLOAD -->
<form id="ProductosImagenes" action="return false" onSubmit="return false" method="POST">

      <center>
      <br>
        <table>
                <tr><div id="resultadoPP"></div></tr>
        	
       				<tr>
                    <td class="text"><span><?php echo $lang[$idioma]['ImagenCara'];?></span></td>
                       <td colspan="3" > 
                    	
                       <input type="file" style="float:left; margin-left:15px;"  class='entradaTexto'name="archivo" id="archivo"  /><progress id="barra_de_progreso" style="float:left; margin-left:10px; height:20px;" value="0" max="100"></progress>
                       <!-- <input type="button" class="cmd button button-highlight button-pill"  onclick="location.reload();" value="Guardar Cambio"/>-->
                       </td></tr>
                
                    <tr>
                    
                    <td class="text"><span><?php echo $lang[$idioma]['Nombre'];?></span></td>
                     <td colspan="3"><input type="text" class="entradaTexto" id="nombreA"></td>
                    </tr>
                    <tr>
                    
                    <td class="text"><span><?php echo $lang[$idioma]['Descripcion'];?></span></td>
                     <td colspan="3"><textarea class="entradaTexto" style="width:90%;" rows="5" id="descripcionA"></textarea></td></tr>
                    <tr>
                    <td></td>
                     <td><input onClick="subirArchivosPP();" type="button" class='cmd button button-highlight button-pill'  value="<?php echo $lang[$idioma]['Guardar'];?>"/></td>
                    </tr>
                    
                    <tr>
                    <td colspan="4" style="text-align:left;">

    						<ul class="mover" id="mover" style="text-align:left; padding-left:100px; height:350px; overflow-y:auto;">
									
                            
    						</ul>
                    </td>
                  
                     
                    </tr>
                    
             
            
        </table>
        </center>
               
            
</form>

<script>
function subirArchivosPP() 
		{
			
					document.getElementById('barra_de_progreso').hidden = false;
					var archivos=document.getElementById('archivo').files;
					var i=0;
					var size=archivos[i].size;
		   			var type=archivos[i].type;
		   			var name=$('#nombreA').val();
					var tipo=$('#descripcionA').val();
			
				
			if(size<(2*(1024*1024)))
			{
				
				$("#archivo").upload('pestanas/subir_archivo.php',
					{
						nombre_archivo: $('#descripcionA').val(),
						nombre_archivo2: $('#nombreA').val()
						
					},
					function(respuesta) 
					{
						//Subida finalizada.
						$('#resultadoPP').html(respuesta);
						
						
						
					}, 
					function(progreso, valor) 
					{
						//Barra de progreso.
						$("#barra_de_progreso").val(valor);
					}
										);
										
					
				
			}
			else
			{
				
				$('#resultadoPP').html('<?php echo $lang[$idioma]['AdverTamanio'];?>');
				
			}
                
			
        }
function limpiarColumnas()
			{
				$('#mover').html("");
			}			
function mostrarArchivos()
			{
				
				document.getElementById('barra_de_progreso').hidden = true;
				
				setTimeout(limpiarColumnas,0000);
				
				$.ajax({
					url:'pestanas/mostrarArchivos.php',
					type:'POST',
					data:'cara=1',
					success: function(resp)
					{
						
						if(resp!=2)
							{
								$('#mover').append(resp);
								
     							
							}
							else
							{
								
							}
							
						
							
					}
      
					
				});
				

			
			}
	function limpiarArchivosProv()
	{
		document.getElementById('nombreA').value="";
		document.getElementById('descripcionA').value="";
		document.getElementById('archivo').value="";
	}
mostrarArchivos();

</script>
<?php 


function Desahabilita($dato)
{
	if($dato==NULL)
	{
		return "";
	}
	else
	{
		return "disabled";
	}
}

?>