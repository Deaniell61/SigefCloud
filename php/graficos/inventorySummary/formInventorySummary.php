<?php
require_once('../../../php/fecha.php');
require_once('../../../php/coneccion.php');
require_once('../../../php/combosVarios.php');
$idioma=idioma();
include('../../../php/idiomas/'.$idioma.'.php');
session_start();
verTiempo3();
$fecha=date('Y-m-d');
$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
$fechaI = date ( 'Y-m-d' , $nuevafecha );
?>
<center>
<div>
	<table class="pandiadoT">
    	<tr><td colspan="2"><center><?php echo $lang[$idioma]['InventorySummary'];?></center></td></tr>
    	<tr>
        	<td class="text"><?php echo $lang[$idioma]['Bodegas'];?></td>
            <td><select class="entradaTexto" id="bodega">
            		
                    <?php echo comboBodegas($_SESSION['codEmpresa'],$_SESSION['pais'],"");
					?>
            	</select></td>
        </tr>
        
        <tr>
        	<td><input class="cmd button button-highlight button-pill" type="button" onClick="cargarFormularioGrafico('5');"  value="<?php echo $lang[$idioma]['gReporte'];?>"></td>
            <td><input class="cmd button button-highlight button-pill" type="button"  value="<?php echo $lang[$idioma]['Salir'];?>"></td>
        </tr>
    </table>
</div>
</center>