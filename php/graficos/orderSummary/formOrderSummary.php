<?php
require_once('../../../php/fecha.php');
require_once('../../../php/coneccion.php');
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
    	<tr><td colspan="2"><center><?php echo $lang[$idioma]['OrdersSummary'];?></center></td></tr>
    	<tr>
        	<td class="text"><?php echo $lang[$idioma]['RFechaInicio'];?></td>
            <td><input type="date" class="entradaTexto" id="fechaI" value="<?php echo $fechaI;?>"></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['RFechaFin'];?></td>
            <td><input type="date" class="entradaTexto" id="fechaF" value="<?php echo $fecha;?>"></td>
        </tr>
        <tr>
        	<td><input class="cmd button button-highlight button-pill" type="button" onClick="cargarFormularioGrafico('3');" value="<?php echo $lang[$idioma]['gReporte'];?>"></td>
            <td><input class="cmd button button-highlight button-pill" type="button" onClick="formulario('16')" value="<?php echo $lang[$idioma]['Salir'];?>"></td>
        </tr>
    </table>
</div>
</center>