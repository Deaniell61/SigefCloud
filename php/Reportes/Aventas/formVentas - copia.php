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
<center><?php echo $lang[$idioma]['EditarEmpresas'];?></center>
<center>
<form action="false" onSubmit="false" method="post">
<aside><div id="resultado"></div>
        	
        </aside>
        
        <div id="datos">
        <center>
        <table id="">
            <tbody>
            	<tr>
                	<th>
                    	Reporte Por Canal<br><input type="radio" name="Export" value="canal">
                        
                    </th>
                    <th>
                    	Reporte Por Linea de Producto<br><input type="radio" name="Export" value="ProdLin">
                        
                    	
                    </th>
                    <th>
                    	Reporte Por Marcas<br><input type="radio" name="Export" value="marcas">
                        
                    </th>
                </tr>
                <tr>
                	<th>
                    	Reporte Por Canal<br><input type="radio" name="Export" value="canal">
                        
                    </th>
                    <th>
                    	Reporte Por Linea de Producto<br><input type="radio" name="Export" value="ProdLin">
                        
                    	
                    </th>
                </tr>
           
            	<tr>
                	<td style="background-color:#ffffff;"><br><br></td>
                </tr>
                    	
                   
               </tbody>
         </table></center>
         <input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generar'];?>" onClick="verRadio();">  
          <input type="button" class='cmd button button-highlight button-pill' onClick="window.location.href='inicioEmpresa.php'" value="<?php echo $lang[$idioma]['Salir'];?>"/>
        
      
</form>
   </center>     
       
       		

