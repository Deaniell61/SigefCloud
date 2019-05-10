<?php

require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

session_start();
verTiempo3();
?>
    <script>
        function ordenesAux(form) 
		{
			
           switch(form)
		   {
			   case '1':
			   {	
			   		
					$.ajax({
							url: '../php/adminOrdenes/forms/formularioOrdSta.php',
							type: 'POST',
							success: function(resp) {
								$('#datos').html("");
								$('#datos').html(resp);
			
							}
						});
				   
				   break;
			   }
			   case '2':
			   {	
			   		
					$.ajax({
							url: '../php/adminOrdenes/forms/formularioPaySta.php',
							type: 'POST',
							success: function(resp) {
								$('#datos').html("");
								$('#datos').html(resp);
			
							}
						});
				   
				   break;
			   }
			   case '3':
			   {	
			   		
					$.ajax({
							url: '../php/adminOrdenes/forms/formularioShiMdo.php',
							type: 'POST',
							success: function(resp) {
								$('#datos').html("");
								$('#datos').html(resp);
			
							}
						});
				   
				   break;
			   }
			   case '4':
			   {	
			   		
					$.ajax({
							url: '../php/adminOrdenes/forms/formularioShiSta.php',
							type: 'POST',
							success: function(resp) {
								$('#datos').html("");
								$('#datos').html(resp);
			
							}
						});
				   
				   break;
			   }
			   case '5':
			   {	
			   		
					$.ajax({
							url: '../php/adminOrdenes/forms/formularioPayMdo.php',
							type: 'POST',
							success: function(resp) {
								$('#datos').html("");
								$('#datos').html(resp);
			
							}
						});
				   
				   break;
			   }
			   case '6':
			   {	
			   		
					$.ajax({
							url: '../php/adminOrdenes/forms/formularioShiCarrier.php',
							type: 'POST',
							success: function(resp) {
								$('#datos').html("");
								$('#datos').html(resp);
			
							}
						});
				   
				   break;
			   }
			   case '7':
			   {	
			   		
					$.ajax({
							url: '../php/adminOrdenes/forms/formularioTOrden.php',
							type: 'POST',
							success: function(resp) {
								$('#datos').html("");
								$('#datos').html(resp);
			
							}
						});
				   
				   break;
			   }
		   }
		
            
        }
    </script>
    <center>
        <?php echo $lang[$idioma]['cataux'];?>
    </center>
    <aside>
        <div id="resultado"></div>
		<div style="position:absolute; width:97%; top:150px; text-align:left; z-index:0;" >
				<div class="guardar">
				<input type="button"   class='cmd button button-highlight button-pill'  onClick="document.getElementById('filtro').value='1';document.getElementById('buscar').value='';buscar();" value="<?php echo $lang[$idioma]['Cancelar'];?>" />   
              <input type="button"  class='cmd button button-highlight button-pill'  onClick="window.location.href='inicio.php'" value="<?php echo $lang[$idioma]['Salir'];?>"/>
			  </div>
		</div>

        
                    <ul class="nav nav-stacked" id="accordion1">
            <li class="panel"> <a data-toggle="collapse" data-parent="#accordion1" href="#firstLink"><?php echo $lang[ $idioma ]['Editar']; ?></a>

                <ul id="firstLink" class="collapse">
                    <center>
                    <table id="formulariosPrincipales">
                    	<tr>
                        	<td><button onClick="ordenesAux('1');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['ordsta']; ?></button></td>
                            <td><button onClick="ordenesAux('2');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['paysta']; ?></button></td>
                            <td><button onClick="ordenesAux('3');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['shimdo']; ?></button></td>
                         </tr>
                         <tr>
                           <td><button onClick="ordenesAux('4');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['shista']; ?></button></td>
                           <td><button onClick="ordenesAux('5');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['paymdo']; ?></button></td>
                           <td><button onClick="ordenesAux('7');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['torden']; ?></button></td>
                        </tr>
                        <tr>
                        <td></td>
                        <td><button onClick="ordenesAux('6');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['shicarrier']; ?></button></td>
                        <td></td>
                        </tr>
                        
                    </table>
                    </center>
                    
                    
                </ul>
              
            </li>
            
        </ul>
          
    </aside>
	
    <div id="datos">
        <script>
		
           

        </script>
    </div>

    </div>
