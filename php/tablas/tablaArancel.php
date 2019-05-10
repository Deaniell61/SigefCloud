<?php	
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
?>
	<center>
	<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">	
	<link href="../../css/datatables.min.css" rel="stylesheet" type="text/css">
			<div>
        	<table id="tablasArancel" width="100%" style="font-size:12px;" border="0" cellspacing="0" cellpadding="0" class="hover tablas table">
				<thead>
            	<tr class="titulo" >
                	<th  width='10%' class="check"><img src="../../images/yes.jpg" style="width: 20px;height: 20px;"/></th>
					<th hidden="hidden"><?php echo $lang[$idioma]['Codigo'];?></th>
                    <th  width='50%'><?php echo $lang[$idioma]['Nombre'];?></th>
                    <th  width='40%'><?php echo $lang[$idioma]['Codigo'];?></th>
					
                </tr></thead>
                <tbody>
<?php  

$squer="select codarancel,codigo,nombre from cat_par_arancel where nombre like '%".$_POST['nombre']."%' or codigo like '%".$_POST['nombre']."%' order by codigo, nombre";				
				if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer))
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
												
						$contador++;
						echo "<tr onDblClick=\"document.getElementById('partidaArancelaria').value='".($row['codarancel'])."';bandera=false;setTimeout(function(){\$('#busqueda').html('');$('#busqueda').dialog('close');},500);\" >
								<td  width='10%'><input type=\"checkbox\" id=\"".($row['codarancel'])."\" onClick=\"agregarAccesos(document.getElementById('".($row['codarancel'])."').value)\"  value=\"".($row['codarancel'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".($row['codarancel'])."\" /></td>
								<td  width='50%'>".(utf8_encode($row['nombre']))."</td>
								<td  width='40%'>".($row['codigo'])."</td>
								
							
							  
								</tr>";
							
					}
					 
					}
					else
					{
						echo "<tr><td colspan=\"4\"><center><span style=\"font-size:25px;\">".$lang[$idioma]['NoEncontrado1']." ".$lang[$idioma]['Arancel']."</span></center></td></tr>";
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

          
    
   $('#tablasArancel').DataTable( {
        "scrollY": "400px",
        "scrollX": true,
        "paging":  true,
        "info":     false,
        "oLanguage": {
      "sLengthMenu": " _MENU_ ",
      
  
      
    }
        
         
         
    } );
    
  ejecutarpie();
     


           </script>
			</center>