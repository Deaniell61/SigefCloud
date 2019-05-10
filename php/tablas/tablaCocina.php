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
        	<table id="tablasMarcas" width="100%" style="font-size:12px;"  border="0" cellspacing="0" cellpadding="0" class="hover tablas table">
				<thead>
            	<tr class="titulo" >
                	<th  width='10%' class="check"><img src="../../images/yes.jpg" style="width: 20px;height: 20px;"/></th>
					<th hidden="hidden"><?php echo $lang[$idioma]['Codigo'];?></th>
                    <th  width='60%'><?php echo $lang[$idioma]['Nombre'];?></th>
                    
                    <th  width='40%'><?php echo $lang[$idioma]['Opciones'];?></th>
					
                </tr></thead>
                <tbody>
<?php  

$squer="select m.codcocina as codmarca,m.nombre from cat_cocina m inner join tra_cat_prov tc on tc.codcat=m.codcocina where tc.codprov='".$_SESSION['codprov']."' and (m.nombre like '%".$_POST['nombre']."%') order by nombre";				
				if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer))
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
												
						$contador++;
						echo "<tr onDblClick=\"document.getElementById('cocina').value='".($row['codmarca'])."';setTimeout(function(){\$('#Busqueda').html('');$('#Busqueda').dialog('close');},500);\">
								<td  width='10%'><input type=\"checkbox\" id=\"".($row['codmarca'])."\" onClick=\"agregarAccesos(document.getElementById('".($row['codmarca'])."').value)\"  value=\"".($row['codmarca'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".($row['codmarca'])."\" /></td>
								<td  width='60%'>".(utf8_encode($row['nombre']))."</td>
								
								<td  width='40%'><img src='../../images/editar.png' title='Editar ".$lang[$idioma]['Cocina']."' id='EditaBusqueda' onClick=\"actualizaExtras('cocina','".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$row['codmarca']."');document.getElementById('cocina').value='".($row['codmarca'])."';\" /> </td>
								
							
							  
								</tr>";
							
					}
					 
					}
					else
					{
						echo "<tr><td colspan=\"4\"><center><span style=\"font-size:25px;\">".$lang[$idioma]['NoEncontrado1']." ".$lang[$idioma]['Cocina']."</span></center></td></tr>";
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

          
    
   $('#tablasMarcas').DataTable( {
        "scrollY": "200px",
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