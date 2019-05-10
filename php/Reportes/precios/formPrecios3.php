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
?>
<script>

</script>
<center></center>
<center>
<form action="false" onSubmit="false" method="post">
<aside><div id="resultado"></div>
        	
        </aside>
        
        <div id="datos">
        <center>
        <table>
            <tbody>
            	<tr>
                	<td width="50%">
                    	<center>Reporte Por Tamaño de Bundle</center><br><!--<input type="radio" name="Export" value="canal">-->
                        <input type="number" max="1000" min="0" autofocus value="0" id="cantBun" class='entradaTexto' style="color:#000;" >
                    </td>
                
                	<td width="50%">
                    	<center>Reporte Por Canal</center><br><!--<input type="radio" name="Export" value="canal">-->
                        <select id="canal" class='entradaTexto textoGrande' style="color:#000;">
						<?php echo comboCanal2($_SESSION['codEmpresa'],$_SESSION['pais'],'../');?>
                        </select>
                    </td>
                    
               
                </tr>
              
           
            	
                   
               </tbody>
         </table></center>
         <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generarxsl'];?>" onClick="llamarReporte(9,document.getElementById('canal'));">  
         
        
      
</form>
   </center>     
       
       		

