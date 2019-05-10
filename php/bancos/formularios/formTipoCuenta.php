<?php
require_once('../../../php/fecha.php');
$idioma=idioma();
include('../../../php/idiomas/'.$idioma.'.php');
session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];
$pais=$_SESSION['pais'];
?>



<div id="bancos" >
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table class="ajustesvarios">
                <tr><div id="resultado"></div></tr>
            <tr>
                <td class="text"><span>Tipo de Cuenta</span></td>
                <td><input type="text2" style="margin-left: -28%;"class='entradaTexto ' name="tipoCuenta1" id="tipoCuenta1" placeholder="Tipo de Cuenta"></td>
                
            </tr>
            <tr>
            
            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="editarTipoCuenta();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="salir1();" value="Regresar"/>
            
            </td>
            
             </tr>
        </table>
        </center>
                </form>
                
</div>
