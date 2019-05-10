<?php
require_once('../../fecha.php');
require_once('../../coneccion.php');
require_once('../combosBancos.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
$pais=$_POST['pais'];
session_start();
$_SESSION['pais']=$_POST['pais'];


?>
<div id="bancos1">

<br>


<form id="bancosIngreso" name="bancos" action="return false" onSubmit="return false" method="POST">
    
      <center>
    <table Class="tablabordes">
            <tr><div id="resultado"></div></tr>
      		<br>
      		<tr>
                <td></td>
                <td colspan="3" class="text"><span><center>Ingreso de Bancos</center></span><br></td>
               
            </tr>
            <tr>
                <td></td>
                <td class="text"><span><center>Nombre de Banco</center></span></td>
                <td ><input type="text2" name="nombanco"  class='entradaTexto' id="nombanco" placeholder="Nombre del Banco"><br><br><br></td>
                <td></td>
            </tr>


            <tr>
                <td class="text"><span>Insertar Logo del Banco</span></td>
                <td colspan="1"><input type="text" id="tipoImg" hidden value="FRO"/><input type="file" style="float:left; margin-left:15px;"  class='entradaTexto'name="archivo" id="archivo" onChange="subirArchivos(); " /></td>
                <td class="text"><span>Prioridad</span></td>
                <td><input type="number" class='entradaTexto' min="0" max="1000" id="prioridad" style="width:145%;" value="Numero Prioridad"/></td>
                
            </tr>

            
            <tr>
                <td class="text"><span>Compra Agencia</span></td>
                <td><input type="text" class='entradaTexto' name="acompra" id="acompra" placeholder="Compra Agencia"></td>
                <td class="text"><span>venta Agencia</span></td>
                <td><input type="text" class='entradaTexto' name="aventa" id="aventa" style="width:145%;" placeholder="Venta Agencia"></td>
            </tr>
            <tr>
                <td class="text"><span>Compra Internet</span></td>
                <td><input type="text" class='entradaTexto' name="Icompra" id="Icompra"  placeholder="Compra Internet"></td>
                <td class="text"><span>Venta Internet</span></td>
                <td><input type="text" class='entradaTexto' name="Iventa" id="Iventa" style="width:145%;" placeholder="Ventana Internet"></td>
            </tr>
            
            <tr>
                <td> </td>
               <td ><input type="checkbox" style="margin-left: -55%;"  class='entradaTexto' name="tasacambio1" id="tasaCambio1" ><span class="text">Tasa de Cambio</span> </td>
            <tr>
            </tr>    
            </tr>
            
            <tr>
                 <td colspan="2" style="text-align:right;">
                 <ul class="mover" id="mover">
                 </ul>
                </td>
            </tr>
            <tr>
            <td><br><br></td>
            <td class="" colspan="4">
            <input type="button" class='cmd button button-highlight button-pill' onClick="CatBancos();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            <input type="reset" class='cmd button button-highlight button-pill' onClick="Limpiartipobancos();  salir1();" value="Regresar"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
