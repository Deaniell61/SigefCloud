<?php

require_once('../fecha.php');
require_once('../combosVarios.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

session_start();
verTiempo3();
?>
    <script>
        paisGlobal = "";
        codPaisGlobal = "";

		
        function buscar() {
			ventana('cargaLoadVP',300,500);
			<?php if($_SESSION['rol']=='P' or $_SESSION['rol']=='U'){
					?>
                
				  	document.getElementById('pais').value='<?php echo $_SESSION['CodPaisCod'];?>';
			
		
                   
					<?php
				}?>
            nombre = document.getElementById('buscar').value;
            paisGlobal=pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
			//filtro = document.getElementById('filtro').value;
            codPaisGlobal=codpais = document.getElementById('pais').value;
			
			{
				$.ajax({
					url: '../php/ordenesMod/llenarOrdenes.php',
					type: 'POST',
					data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais,
	
					success: function(resp) {
						$('#datos').html("");
						$('#datos').html(resp);
						//buscarZip();
	
					},
			error: function( jqXHR, textStatus, errorThrown ) {

            if (jqXHR.status === 0) {

                alert('Not connect: Verify Network.');

            } else if (jqXHR.status == 404) {

                alert('Requested page not found [404]');

            } else if (jqXHR.status == 500) {

                alert('Internal Server Error [500].');

            } else if (textStatus === 'parsererror') {

                alert('Requested JSON parse failed.');

            } else if (textStatus === 'timeout') {

                alert('Time out error.');

            } else if (textStatus === 'abort') {

                alert('Ajax request aborted.');

            } else {

                alert('Uncaught Error: ' + jqXHR.responseText);

           }

        }

				});
			}
        }

        function buscare(e) {
			
			<?php if($_SESSION['rol']=='P' or $_SESSION['rol']=='U'){
					?>
                  
				  	document.getElementById('pais').value='<?php echo $_SESSION['CodPaisCod'];?>';
				  
                   
					<?php
				}?>
            nombre = document.getElementById('buscar').value;
            pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
			//filtro = document.getElementById('filtro').value;
            codpais = document.getElementById('pais').value;
			
			{
				if (validateEnter(e)) 
				{
					ventana('cargaLoadVP',300,500);
					$.ajax({
						url: '../php/ordenesMod/llenarOrdenes.php',
						type: 'POST',
						data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais,
	
						success: function(resp) {
							$('#datos').html("");
							$('#datos').html(resp);
	
						}
					});
				}
            }
        }
		function buscarZip(zip,res) 
		{
			
           
			$.ajax({
				url: 'https://maps.googleapis.com/maps/api/geocode/json',
				type: 'GET',
				dataType: "json",
				data:"address="+zip+"&key=AIzaSyCdJAwErIy3KmcE_EfHACIvL0Nl1RjhcUo",
				success: function(resp) 
				{
					
					document.getElementById(res).innerHTML(resp.results[0].address_components[3].short_name);
				}
			});
            
        }

	
    </script>
    <center>
        <?php echo $lang[$idioma]['ordenes'];?>
    </center>
    <aside>
        <div id="resultado"></div>
         <div id="resultado1"></div>
<div style="position:absolute; width:97%; top:150px; text-align:left; z-index:0;" >
<div class="guardar">
				<input type="button"   class='cmd button button-highlight button-pill'  onClick="buscar();" value="<?php echo $lang[$idioma]['Cancelar'];?>" />   
              <input type="button"  class='cmd button button-highlight button-pill'  onClick="window.location.href='inicio.php'" value="<?php echo $lang[$idioma]['Salir'];?>"/>
			  </div>
			  </div>
<!--<div style="position:absolute; width:97%; top:240px; z-index: 0;">
               
               <img src="../images/excel.png" id="exportExcel" onClick="llamarReporte(12,document.getElementById('buscar'))" style="width:20px; height:20px; float:right; margin-left:5px;margin-top:5px; cursor:pointer;">

               
                	
                    
               </div>-->
        <table>
        
            <tr <?php if($_SESSION['rol']=='P' or $_SESSION['rol']=='U'){echo "hidden";}?>>
                <td colspan="4">
                    <select class='entradaTexto' id="pais" style="width:100%">
                        <?php echo paises();?>
                    </select>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" class='entradaTexto' id="buscar" name="buscar" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscare(event);" />
                </td>

                <td>
                    <div class="">
                        <input type="button" class='cmd button button-highlight button-pill' onClick="buscar();" value="<?php echo $lang[$idioma]['Buscar']?>" />
                    </div>
                </td>
               <!-- <td>
                    <div class="">
                        <input class='cmd button button-highlight button-pill' type="button" onClick="abrirNotificacion('',paisGlobal,codPaisGlobal);" value="<?php echo $lang[$idioma]['Nuevo']?>" />
                    </div>
                </td>-->
            </tr>
            <tr>
                <td>
                
                    <br>
                </td>
            </tr>
            <tr >
                <td>
                    <select class='entradaTexto' onChange="" id="comEstado" style="width:100%">
                        <?php echo comboEstados("","","");?>
                    </select>
                </td>
                <td>
                    <div class="">
                        <input type="button" class='cmd button button-highlight button-pill' onClick="recorreOrdenes();" value="<?php echo $lang[$idioma]['Actualizar']?>" />
                    </div>
                </td>
                <td>
                    <div class="">
                        <input type="button" class='cmd button button-highlight button-pill' onClick="cambiarOrdenesCorrectas();" value="<?php echo $lang[$idioma]['EstadoCorrect']?>" />
                    </div>
                    
                </td>
            </tr>
            <tr>
                    <td><br></td>
            </tr>
            

        </table>
    </aside>
	<div style="position:absolute;width: 7%;top: 280px;z-index: 0;text-align: left;float: left;left: 50px;color: black;font-size: 16px;">
    <span><?php echo $lang[$idioma]['grandtotal'];?></span>
    <span id="totalGrid"></span>
    </div>
    <div id="datos">
        <script>
		
            buscar();

        </script>
    </div>
    
    <div id="cargaLoadVP"></div>

    </div>
