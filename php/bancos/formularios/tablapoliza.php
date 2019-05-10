<?php	
require_once('../../fecha.php');
require_once('../../coneccion.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
?>
	<center>
	<link href="../../../css/bootstrap.min.css" rel="stylesheet" type="text/css">	
	<link href="../../../css/datatables.min.css" rel="stylesheet" type="text/css">
			<div>
        	<table id="tablas" width="100%" border="0" cellspacing="0" cellpadding="0" class="hover tablas table">
				<thead>
            	<tr class="titulo" >
                	<th  width='10%' class="check"><img src="../../images/yes.jpg" style="width: 20px;height: 20px;"/></th>
					<th hidden="hidden">codcuen</th>
                    <th  width='20%'>codigo</th>
                    <th  width='40%'>nombre</th>
					
                </tr></thead>
                <tbody>
<?php  

$squer="select codcuenta,codigo,nombre from cat_nomenclatura where nombre like '%".$_POST['nombre']."%' or codigo like '%".$_POST['nombre']."%' order by codigo";				
				if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer))
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
												
						$contador++;
						echo "<tr onDblClick=\"document.getElementById('cuentapoliza').value='".($row['codigo'])."';document.getElementById('nombrecuentapoliza').value='".($row['nombre'])."';bandera=false;cerrarmodal();\" >
								<td  width='10%'><input type=\"checkbox\" id=\"".($row['codcuenta'])."\" onClick=\"agregarAccesos(document.getElementById('".($row['codcuenta'])."').value)\"  value=\"".($row['codcuenta'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".($row['codcuenta'])."\" /></td>
								<td  width='20%'>".($row['codigo'])."</td>
								<td  width='40%'>".($row['nombre'])."</td>
								
							
							  
								</tr>";
							
					}
					 
					}
					else
					{
						echo "<tr><td colspan=\"4\"><center><span style=\"font-size:25px;\">".$lang[$idioma]['NoEncontradoCompe']."</span></center></td></tr>";
					}
					
				}
				else
				{	
					echo "Error";
				}
				
				
?>                
        </tbody>
       </table>
       </div>
              
			  <script   type="text/javascript">

           $(document).ready(function(){
    
   $('#tablas12').DataTable( {
        "scrollY": "400px",
        "scrollX": true,
        "paging":  true,
        "info":     false,
        "oLanguage": {
      "sLengthMenu": " _MENU_ ",
      
  
      
    }
        
         
         
    } );
    
  ejecutarpie();
     
});

           </script>
			</center>