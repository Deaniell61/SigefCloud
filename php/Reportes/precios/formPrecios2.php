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
        <table id="">
            <tbody>
            	<tr>
                
                	<td>
                    	Reporte Por Canal<br><!--<input type="radio" name="Export" value="canal">-->
                        <select id="canal" class='entradaTexto textoGrande' style="color:#000;">
						<?php echo comboCanal2($_SESSION['codEmpresa'],$_SESSION['pais'],'../');?>
                        </select>
                    </td>
               
                </tr>
              
           
            	
                   
               </tbody>
         </table></center>
         <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generarxsl'];?>" onClick="llamarReporte(1,document.getElementById('canal'));">  
         <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generartxt'];?>" onClick="llamarReporte(5,document.getElementById('canal'));">  
          <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generarcsv'];?>" onClick="llamarReporte(6,document.getElementById('canal'));"> 
          <br><input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generarcsv'];?>" onClick="llamarReporte(6,document.getElementById('canal'));"> 
        
      
</form>
   </center>     
       
       		

