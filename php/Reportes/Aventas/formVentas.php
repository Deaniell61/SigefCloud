<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../../productos/combosProductos.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
$hoy=date('Y-m-d');
$nuevafecha = strtotime ( '-1 month' , strtotime ( $hoy ) ) ;
$fechaF = date ( 'Y-m-d' , $nuevafecha );
?>
<script>

function buscarEmpresasOrdenadas(nombre,rsocial,nit,email,orden)
{
		$.ajax({
			url:'../php/empresas/llenarEmpresasOrdenadas.php',
			type:'POST',
			data:'nombre='+nombre+'&rsocial='+
					rsocial+'&nit='+nit+'&email='+email+'&orden='+orden,
					
			success: function(resp)
			{
				$('#datos').html("");
				$('#datos').html(resp);
				
			}
		});
		
}
</script>
<center><?php echo $lang[$idioma]['ReporteSales'];?></center>
<center>

<form action="false" onSubmit="false" method="post">
<aside><div id="resultado"></div>
        	
        </aside>
        
        <div>
        <center>
          <ul class="nav nav-stacked" id="accordion1">
            <center><li class="panel panel-default" id="panelDefault"> <a data-toggle="collapse" data-parent="#accordion1" href="#firstLink"><?php echo $lang[ $idioma ]['ReporteSales']; ?></a></center>

                <ul id="firstLink" class="collapse in">
                    <center>
                    <table class="ventasReporte">
            <tbody>
            	<tr>
                	<td>
                    	<?php echo $lang[ $idioma ]['PeriIni']; ?> <br>
                   <input type="date" value="<?php echo $fechaF;?>" class='entradaTexto' id="periIni">
                    </td>
                    
                    <td>
                    	<?php echo $lang[ $idioma ]['PeriFin']; ?> <br>
                   <input type="date" value="<?php echo $hoy;?>" class='entradaTexto' id="periFin">
                    </td>                   
                   
                </tr>
                
            	<tr>
                	<td style="background-color:#ffffff;"></td>
                </tr>
                    	
                   
               </tbody>
         </table>
          <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generar'];?>" onClick="generarAnalisisVenta();">  
          <input type="button" class='cmd button button-highlight button-pill' onClick="window.location.href='inicioEmpresa.php'" value="<?php echo $lang[$idioma]['Salir'];?>"/>
                    </center>
                    
                    
                </ul>
              
            </li>
            
        </ul>
        
      </center>
      </div>
</form>

		
        <div id="datos">
        </div>
        
   </center>     
       
<div id="cargaLoadVP"></div>
<!-- 



         <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generar'];?>" onClick="verRadioVentas();">  
          <input type="button" class='cmd button button-highlight button-pill' onClick="window.location.href='inicioEmpresa.php'" value="<?php echo $lang[$idioma]['Salir'];?>"/>-->