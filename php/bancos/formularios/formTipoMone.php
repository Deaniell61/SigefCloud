<?php
require_once('../../../php/fecha.php');
$idioma=idioma();
include('../../../php/idiomas/'.$idioma.'.php');
session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];
$pais=$_SESSION['pais'];
?>



<div id="bancos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table >
                <tr><div id="resultado"></div></tr>
        	<tr>
            	<td class="text"><span>Nombre de Moneda</span></td>
                <td><input type="text" class='entradaTexto' name="tipomone" id="tipomone" placeholder="Tipo de Moneda"></td>
                <td ><span>Moneda</span></td>
                <td><input type="text" class='entradaTexto ajuestetams6' name="moneda" id="moneda" style="width: 20%;" placeholder="Simbolos"></td>
            </tr>

            <tr>
              <td colspan="4"><input type="button"  class='cmd button button-highlight button-pill'  onClick="editarMone();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
              <input type="button"  class='cmd button button-highlight button-pill'  onClick="salir1();" value="Regresar"/></td>
            </tr>
        </table>
        </center>
                </form>
                
</div>
