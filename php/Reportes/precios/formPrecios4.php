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
<form id="reporteCanalPrecio" action="false" onSubmit="false" method="post">
<aside><div id="resultado"></div>
        	
        </aside>
        
        <div id="datos">
        <center>
        <table>
            <tbody>
            	<tr>
                	
                
                	<td width="25%">
                    	<center>Reporte Por Canal</center><!--<input type="radio" name="Export" value="canal">-->
                        <select id="canal" class='entradaTexto textoGrande' style="color:#000;">
						<?php echo comboCanal2($_SESSION['codEmpresa'],$_SESSION['pais'],'../');?>
                        </select>
                    </td>
                    <td width="25%" >
                    <center>
                    	<div style="width:50%; text-align:left;">
                    	<input type="radio" name="Export" value="Add">Add<br>
                        <input type="radio" name="Export" value="Update">Update
                        </div>
                    </center>
                        
                    </td>
                    <td width="25%">
                    <center>
                    	<div style="width:50%; text-align:left;">
                    	<input type="radio" name="Tipo" value="G">Grocerys<br>
                        <input type="radio" name="Tipo" value="H">Healt
                        </div>
                    </center>
                        
                    </td>
                     <td width="25%">
                     <center>
                    	<div style="width:50%; text-align:left;">
                    	<input type="radio" name="Codigo" value="1">ASIN<br>
                        <input type="radio" name="Codigo" value="2">UPC
                        </div>
                    </center>
                    </td>
                    
               
                </tr>
              
           
            	
                   
               </tbody>
         </table></center>
         <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generarxsl'];?>" onClick="llamarReporte(10,document.getElementById('canal'));">  
         
        
      
</form>
   </center>     
       
       		

