<?php
require_once('../../../php/fecha.php');
$idioma=idioma();
include('../../../php/idiomas/'.$idioma.'.php');
require_once('../combosBancos.php');
session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];
$pais=$_SESSION['pais'];
       

?>
<SCRIPT> 
window.onload=codigodegrupo();
</SCRIPT>

<div id="bancos2">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
      <center class="ajueste5a">Catalogo de Nomenclatura Contable</center>
       <table Class="tablabordes">
            <tr><div id="resultado"></div></tr>
            <br>
            <tr>
                <td></td>
                <td colspan="4" class="text"><span></span></td>
               
            </tr>

            
            <tr>
                <td class="text" ><span>Grupo</span></td>
                <td ><select  class='entradaTexto' disabled id="grupoconta" onChange="LlenarCodigoOtro(this,'1','grupoconta1');setTimeout(function(){filtrarcombos('<?php echo $_SESSION['pais']; ?>',document.getElementById('grupoconta1'));},500); limpiezaParaGrupo(); setTimeout(function(){codigodegrupo();},500); "><?php echo combogrupoconta($_SESSION['pais']);?></select><input type="text" hidden id="grupoconta1"/></td>
                 <td  rowspan="5"> <fieldset Class="ajustefiel">
                    <input type="radio" name="group1" value="1" checked="checked"  onclick="desabilitargrupo(); codigodegrupo();">Grupo &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br>
                    <input type="radio" name="group1" value="2" onclick="desabilitarsubgrupo(); codigodegrupo();">Subgrupo &nbsp;&nbsp; &nbsp; &nbsp;<br>
                    <input type="radio" name="group1" value="3" onclick="desabilitarcuenta(); codigodegrupo();">Cuenta &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;<br>
                    <input type="radio" name="group1" value="4" onclick="desabilitarcuentanivel1(); codigodegrupo();">Cuenta Nivel 1<br>
                    <input type="radio" name="group1" value="5" onclick="desabilitarcuentanivel2(); codigodegrupo();">Cuenta Nivel 2<br>
                    <input type="radio" name="group1" value="6" onclick="desabilitarcuentanivel3(); codigodegrupo();">Cuenta Nivel 3<br>
                </fieldset></td>               
               
                
            </tr>
            <tr>
                <td class="text"><span>SubGrupo</span></td>
                <td ><select  class='entradaTexto' disabled id="subgrupoconta" onChange="LlenarCodigoOtro(this,'2','subgrupoconta1');setTimeout(function(){filtrarcombos1('<?php echo $_SESSION['pais']; ?>',document.getElementById('subgrupoconta1'));},500); limpiezaParaSubGrupo(); setTimeout(function(){codigodegrupo();},500);"></select><input type="text" hidden id="subgrupoconta1"/></td>
               
                
            </tr>

            <tr>
                <td class="text"><span>Cuenta</span></td>
                <td ><select  class='entradaTexto' disabled id="cuentaconta1" onChange="LlenarCodigoOtro(this,'3','cuentaconta11'); setTimeout(function(){filtrarcombos2('<?php echo $_SESSION['pais']; ?>',document.getElementById('cuentaconta11'));},500); limpiezaParacuentanivel1(); setTimeout(function(){codigodegrupo();},500);"></select><input type="text"  hidden id="cuentaconta11" /></td>
                
            </tr>
            <tr>
                <td class="text"><span>Cuenta Nivel 1</span></td>
                <td ><select  class='entradaTexto' disabled id="cuentacontanivel1" onChange="LlenarCodigoOtro(this,'4','cuentacontanivel11'); setTimeout(function(){filtrarcombos3('<?php echo $_SESSION['pais']; ?>',document.getElementById('cuentacontanivel11'));},500); limpiezaParacuentanivel2(); setTimeout(function(){codigodegrupo();},500);"></select><input type="text" hidden id="cuentacontanivel11" /></td>
                <td></td>
                <td></td>
                
            </tr>
            <tr>
                <td class="text"><span>Cuenta Nivel 2</span></td>
                <td ><select  class='entradaTexto' disabled id="cuentacontanivel2" onChange="LlenarCodigoOtro(this,'5','cuentacontanivel21'); setTimeout(function(){codigodegrupo();},500); "></select><input type="text" hidden id="cuentacontanivel21" /><input type="text" hidden id="cuentacontanivel31" /><br><br></td>
                <td></td>
                <td></td>
                
            </tr>
             <tr>
                <td class="text"><span>Codigo de Cuenta</span></td>
                <td ><input  type="text1"  class='entradaTexto ' disabled id="codCuentaconta" placeholder="" values=""></td>
                
                

            </tr>
            <tr>
                <td class="text"><span >Nombre de Cuenta</span></td>
                <td colspan="3"><input  type="text4"  class='entradaTexto'  id="nomCuentaconta" placeholder="Nombre de la Cuenta"></td>
            </tr>

             <tr>
            <td class="text"><span>Tipo de Cuenta</span><span class="ajuste3a">Ubicación Contable</span></td>
                <td ><select  class='entradaTexto '  disabled id="tipocuentaconta">
                    
                            <option value=""></option>
                            <option value="T" selected>TITULO</option>
                            <option value="D">DETALLES</option>
                        
                </select></td>
                <td ><select  class='entradaTexto ajuste4a ' id="ubicacionconta"><?php echo ubicaconta($_SESSION['pais']);?></select><br><br></td>
                
            </tr>
             
            <tr>
            <td><br><br></td>
            <td colspan="4">
            <input type="button" style="margin-left: 19%;" class='cmd button button-highlight button-pill' onClick="CatNomenclatura(); " value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            <input type="reset" class='cmd button button-highlight button-pill' onClick=" salir1();" value="Regresar"/>
                
            </td>
            
             </tr>
        </table>
        </center>
                </form>
                
</div>
