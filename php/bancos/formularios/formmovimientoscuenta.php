<?php
require_once('../../fecha.php');
require_once('../../coneccion.php');
require_once('../combosBancos.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
$codigo=$_POST['codigo'];

$squery="select cc.coddpol as codigo,cc.debe as debe,cc.haber as haber, cc.cuenta as cuenta, (select cb.nombre from cat_nomenclatura cb where cb.codigo=cc.cuenta limit 1) as nombreconta from tra_pol_det cc;";
$_SESSION['queryPolizaPasar']=$squery;
$squery1="select cc.codcuen as codigo,cc.numcuen as cuenta, cc.CODMONE as moneda,cc.nombre as nombre,(select cb.nombre from cat_banc cb where cb.codbanc=cc.codbanc) as banco from cat_cuen cc where cc.codcuen='".$codigo."'";
$ejecutar=mysqli_query(conexion($_SESSION['pais']),$squery1);
        if($ejecutar)
        {
            $row=mysqli_fetch_array($ejecutar,MYSQL_ASSOC)
?>
<script  src="../js/jquery-2.2.3.min.js" type="text/javascript"></script>
<script  src="../js/jquery-ui.min.js" type="text/javascript"></script>
<SCRIPT> 
var eventoControlado = false;
window.onload=fechaActual();codigodePoliza();correlativonumero();numerocorPoliza();
</SCRIPT>

<div id="movimientoscuenta">

<br>

<form id="movimientos" name="cuentas" action="return false" onSubmit="return false" method="POST">
    <div id="busqueda">
</div>

      <center>
       <table>
            <tr><div id="resultado"></div></tr>
        </table>
        <table width="838" height="329" border="0">
          <tr>
            <td colspan="6"><div align="center">Movimientos de Cuentas Bancarias</div></td>
          </tr>
          <tr>
            <td width="117"><div align="right"><span class="text ">Nombre de la Cuenta</span></div></td>
            <td colspan="5"><input type="text" disabled name="nombrecuenta" style="width: 99%;" class='entradaTexto' value="<?php echo $row['cuenta'].'     |     '.$row['nombre'].'     |     '.$row['banco']?>" id="nombrecuenta" >
            <input type="text" name="codcuen" hidden value="<?php echo $row['codigo']?>" id="codcuen" ><input type="text" name="moneda" hidden value="<?php echo $row['moneda']?>" id="moneda" ><input type="text" hidden name="codpoliza1" id="codpoliza1" ><input type="text" hidden name="CODTCUEN" id="CODTCUEN" ><input type="text" hidden name="codvoucher" id="codvoucher" ><input type="text" hidden name="codproy" id="codproy" ><input type="text" hidden name="codigobusqueda" id="codigobusqueda" ><br><br></td>
          </tr>
          <tr>
            <td><div align="right"><span class="text">Tipo de Documento</span></div></td>
            <td colspan="5"><fieldset Class="ajustefiel23">
              <div align="center">
                <input type="radio" name="group2" checked="checked" value="1" onclick="correlativonumero(); codigodePoliza()">
              Depositos
              <input type="radio" name="group2" value="2" onclick="correlativonumero(); codigodePoliza();">
              Notas de Crédito
              <input type="radio" name="group2" value="3" onclick="correlativonumero(); codigodePoliza();">
              Cheques
              <input type="radio" name="group2" value="4" onclick="correlativonumero(); codigodePoliza();">
              Notas de Débito
              </div>
            </fieldset></td>
          </tr>
          <tr>
            <td><div align="right"><span class="text"><span style="text-align: right;">Orden de Pago</span></span></div></td>
            <td ><input type="number"  name="ordenpago"  class='entradaTexto' id="ordenpago" ></td>
            <td ><div align="right"><span class="text">Numero</span></div></td>
            <td ><input type="number"  name="numero"  class='entradaTexto' id="numero" ></td>
            <td ><div align="right"><span class="text">Fecha</span></div></td>
            <td ><input type="date" name="fecha" style="width: 100%;"   value="" class='entradaTexto' id="fecha" ><?php selectFecha("");?></td>
          </tr>
          <tr>
            <td><div align="right"><span class="text">Tasa de Cambio</span></div></td>
            <td><input type="number" name="tasacambio1" class='entradaTexto' id="tasacambio1" ></td>
            <td><div align="right"><span class="text"><span class="entradaTexto">Valor</span></span></div></td>
            <td><input type="number" name="numvalor" class='entradaTexto' id="numvalor" ></td>
            <td colspan="2"><div align="center">
              <input type="checkbox" class='entradaTexto' name="nonegociable" value="1" id="nonegociable" >
            <span class="text">No Negociable</span></div></td>
          </tr>
          <tr>
            <td><div align="right"><span class="text">Beneficia</span></div></td>
            <td colspan="5"><input name="beneficia" type="text" class='entradaTexto' id="beneficia"  placeholder="Nombre quien beneficia" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><div align="right"><span class="text">Concepto</span></div></td>
            <td colspan="5"><textarea name="concepto" rows="2" class='entradaTexto' id="concepto" style="width: 100%;"></textarea></td>
          </tr>
          <tr>
            <td><div align="right"><span class="text">Embarque</span></div></td>
            <td colspan="5"><select name="embarque" class='entradaTexto' id="embarque"  style="width: 102%;">
              <?php echo comboembarque($_SESSION['pais']);?>
            </select></td>
          </tr>
          <tr>
            <td><div align="right">
              <input type="button" class='cmd button button-highlight button-pill' onClick="" value="Pagar Facturas"/>
            </div></td>
            <td><div align="center" class='ajustetam'>Poliza</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right"></div></td>
            <td><input type="text" name="cuentapoliza" class='entradaTexto  ajusteposicion' id="cuentapoliza" style="width: 57%;"  onkeypress="busqueda1(event, 'busqueda')" onKeyup="buscarCodigoPoliza();" placeholder="Enter para buscar" ></td>
            <td colspan="2"><input type="text" name="nombrecuentapoliza" disabled style="width: 90%;"  class='entradaTexto ajusteposicion1' id="nombrecuentapoliza" ></td>
            <td><input type="text" name="debe"  class='entradaTexto ajusteposicion2' style="width: 271%;" onkeypress="guardarpoliza(event, 'busqueda')" placeholder="Enter para guardar" id="debe" ></td>
            <td><input type="text" name="haber"  class='entradaTexto ajusteposicion3' style="width: 69%;" onkeypress="guardarpoliza(event, 'busqueda')"  placeholder="Enter para guardar" id="haber" ></td>
          </tr>
          <tr>
            <td><div align="right"></div></td>
            <td colspan="5" id="recargaMovimientoCuent" >
			<?php   
                echo encabezado().tabla($squery,"../../");
            ?>
            </td>
          </tr>
          <tr>
            <td><div align="right">
              <input type="button" class='cmd button button-highlight button-pill' onClick="" value="Facturas Pagadas"/>
            </div></td>
            <td><div align="center"><span class="text ajustetam">Poliza No.</span></div></td>
            <td colspan="2"><input type="text" disabled name="poliza" class='entradaTexto ajusteposicion1' style="width: 90%;"  id="poliza" ></td>
            <td><input type="text" name="totaldebe"  value=" <?php echo $_SESSION['debe'];?>" disabled style="width: 271%;" class='entradaTexto ajusteposicion2' id="totaldebe" ></td>
            <td><input type="text" name="totalhaber" value="<?php echo $_SESSION['haber'];?>"disabled style="width: 69%;" class='entradaTexto ajusteposicion3' id="totalhaber" ></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><div align="center">
            <input type="button" class='cmd button button-highlight button-pill' onClick="movimientoTraCuen();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
              <input type="reset" class='cmd button button-highlight button-pill' onClick="Limpiartipobancos();  salir1();" value="Regresar"/>
            </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
                </form>
                
</div>
<script>

//document.getElementById('cuentapoliza').value = "<?php echo $row['codaran'];?>";

</script>
<?php

}

function selectFecha($fecha)
{
 $retorno="";
 if($fecha==NULL or $fecha=="")
 {
  $retorno=date('Y')."-".date('m')."-".date('d');
  
 }
 else
 {
  $retorno=$fecha;
 }
 echo "<script>document.getElementById('fecha').value='".$retorno."'</script>";
}  



?>
