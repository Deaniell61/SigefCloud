<?php
require_once('../fecha.php');
require_once('../coneccion.php');
require_once('combosBancos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();

?>

<div id="bancos">
<center>Ingreso de Cuentas Bancarias</center>
<form id="bancosIngreso" name="bancos" action="return false" onSubmit="return false" method="POST">
    
    <table >
         <tr><div id="resultado"></div></tr>
		<tr>
        <td class="text"><span>Cuenta Bancaria</span></td>
        <td ><input type="text7" class='entradaTexto' name="EName" id="CuentaBancaria" placeholder="Cuenta Bancaria" onBlur=""></td>
		<td ></td>	
		<td></td>	
		</tr>

		<tr>
    	<td class="text"><span>Nombre de la Cuenta</span></td>
        <td><input type="text7" class='entradaTexto' name="prodName" id="NombreCuenta" placeholder="Nombre de la Cuenta"></td>
		<td></td>	
		<td></td>	
		</tr>

		<tr>
    	<td class="text"><span>Banco</span></td>
        <td ><select  class='entradaTexto' id="TipoBanco" autofocus><?php echo comboBancos($_SESSION['pais']);?></select><img src="../images/document_add.png" id="subForm" onClick="abrirFormTipoCuen('Banco','<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>');"></td>
    	<td ></td>
        <td ></td>
		</tr>

		<tr>
    	<td class="text"><span>Tipo de Cuenta</span></td>
        <td ><select  class='entradaTexto' id="tipoCuenta" autofocus><?php echo combotipoCuenta($_SESSION['pais']);?></select><img src="../images/document_add.png" id="subForm" onClick="abrirFormTipoCuen('tipocuenta','<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>');"></td>
    	<td></td>
        <td ></td>
		</tr>

		<tr>
    	<td class="text"><span>Cuenta Contable</span></td>
         <td ><input  type="text1"  class='entradaTexto'   id="codCuentaconta" onkeyup="buscarCodigoCuenta();" placeholder="Codigo de la Cuenta"></td>
        <td colspan="3"><input  class='entradaTexto ajuste1' disabled id="CuentaContable"><img src="../images/document_add.png" id="subForm1" onClick="abrirFormTipoCuen('tipocuentacont','<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>');"></td>
		<td></td>	
		<td></td>	
		</tr>

		<tr>
    	<td class="text"><span>Tipo de Moneda</span></td>
        <td ><select  class='entradaTexto' id="tipmoneda"><?php echo combotipoMone($_SESSION['pais']);?></select><img src="../images/document_add.png" id="subForm" onClick="abrirFormTipoCuen1('tipomone','<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>');"></td>
    	<td></td>
        <td></td>
		</tr>
		
		<tr>
    	<td><span class="ajuste7">Banco Tasa de Cambio</span></td>
        <td><select class='entradaTexto' id="tipoTasaCambio"><?php echo comboTasaCambio($_SESSION['pais']);?></select></td>
    	<td></td>
        <td ></td>
		</tr>
		
		<tr>
		<td class="text"><span>Formato Fecha</span></td>
	    <td><select class='entradaTexto' onclick="formatofecha();" id="formatoFecha">
							<option value=""></option>
                        
                            
                            
	    </select></td>
	    
		<td></td>	
		<td></td>	
		
		<tr>
		<td></td>	
        <td><input type="checkbox" class='entradaTexto' name="concheq1" value="1" id="ConCheq" ><span class="text">Emision de Cheques</span> </td>
		<td></td>	
		<td></td>	
		</tr>
		
		<tr>
		<td></td>	
     	<td class='espacioTexto'><span><br></span></td>
		<td></td>	
		<td></td>	
		</tr>
	</table>
	<table>	
		<tr>
		<td class="text "><span>Columna del documento</span></td>	
		<td><input type="text4" class='entradaTexto' name="coldoc" id="coldoc" placeholder="Col"><span id="ajuste3">Fila del Documento</span><span id="ajuste4">Columna Transaccion</span><span id="ajuste5">Fila Transaccion</span></td>
		<td class="text " ></td>	
		<td><input type="text3" class='entradaTexto' name="fildoc" id="fildoc" placeholder="Fil"></td>
		<td class="text "></td>	
		<td><input type="text5" class='entradaTexto' name="coltran" id="coltran" placeholder="Col"></td>
		<td class="text "></td>	
		<td><input type="text6" class='entradaTexto' name="coltran" id="filtran" placeholder="Fil"></td>
		</tr>
	</table>		
	<table>	
		<tr>
    	<td class="text"><span>Concepto Nota de Credito</span></td>
        <td colspan="3"><input type="text" class='entradaTexto' name="prodName" id="conNotaCre" placeholder="Concepto Nota de Credito"></td>
		<td></td>	
		<td></td>	
		</tr>

		<tr>
    	<td class="text"><span>Concepto Deposito</span></td>
        <td colspan="3"><input type="text" class='entradaTexto' name="prodName" id="conDepositos" placeholder="Conceptos de Depositos"></td>
		<td></td>	
		<td></td>	
		</tr>

		<tr>
    	<td class="text"><span>Concepto de Cheque</span></td>
        <td colspan="3"><input type="text" class='entradaTexto' name="prodName" id="ConcepCheq" placeholder="Concepto de Cheque"></td>
		<td></td>	
		<td></td>	
		</tr>         

        <tr>
    	<td class="text"><span>Concepto Nota de Debito</span></td>
        <td colspan="3"><input type="text" class='entradaTexto' name="prodName" id="ConNotaDeb" placeholder="Concepto Nota de Debito"></td>
        <td></td>	
		<td></td>	
        </tr>

        <tr>
        <center>
      	<td class="" colspan="4">
        <input aling="center" type="button"   class='cmd button button-highlight button-pill' onClick="editarBancos();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
        </td>
		</tr>
    </table>
    </center>
    </form>         
    </div>      


           

        	
         
         
           
            
            
