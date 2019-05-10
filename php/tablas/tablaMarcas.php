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
        	<table id="tablasMarcas" width="100%" style="font-size:12px;" border="0" cellspacing="0" cellpadding="0" class="hover tablas table">
				<thead>
            	<tr class="titulo" >
                	<th  width='10%' class="check"><img src="../../images/yes.jpg" style="width: 20px;height: 20px;"/></th>
					<th hidden="hidden"><?php echo $lang[$idioma]['Codigo'];?></th>
                    <th  width='40%'><?php echo $lang[$idioma]['Nombre'];?></th>
                    <th  width='20%'><?php echo $lang[$idioma]['Codigo'];?></th>
                    <th  width='40%'><?php echo $lang[$idioma]['Opciones'];?></th>
					
                </tr></thead>
                <tbody>
<?php  

$squer="select m.codmarca,m.codigo,m.nombre from cat_marcas m inner join tra_cat_prov tc on tc.codcat=m.codmarca where tc.codprov='".$_SESSION['codprov']."' and (m.nombre like '%".$_POST['nombre']."%' or m.codigo like '%".$_POST['nombre']."%') order by nombre,codigo";				
				if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer))
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
												
						$contador++;
						echo "<tr onDblClick=\"document.getElementById('marca').value='".($row['codmarca'])."';setTimeout(function(){\$('#Busqueda').html('');$('#Busqueda').dialog('close');},500);\">
								<td  width='10%'><input type=\"checkbox\" id=\"".($row['codmarca'])."\" onClick=\"agregarAccesos(document.getElementById('".($row['codmarca'])."').value)\"  value=\"".($row['codmarca'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".($row['codmarca'])."\" /></td>
								<td  width='40%'>".(utf8_encode($row['nombre']))."</td>
								<td  width='20%'>".($row['codigo'])."</td>
								<td  width='40%'><img src='../../images/editar.png' title='Editar ".$lang[$idioma]['Marca']."' id='EditaBusqueda' onClick=\"actualizaExtras('marca','".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$row['codmarca']."');document.getElementById('marca').value='".($row['codmarca'])."';\" /> </td>
								
							
							  
								</tr>";
							
					}
					 
					}
					else
					{
						echo "<tr><td colspan=\"4\"><center><span style=\"font-size:25px;\">".$lang[$idioma]['NoEncontrado1']." ".$lang[$idioma]['Marca']."</span></center></td></tr>";
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