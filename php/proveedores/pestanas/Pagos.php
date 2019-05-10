<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../busquedas/buscarProv.php');
require_once('../../productos/combosProductos.php');
$idioma = idioma();
include('../../idiomas/' . $idioma . '.php');
session_start();
$codigo = strtoupper($_POST['codigo']);
function pais($cod, $pais) {

    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    {
        echo "<select class='entradaTexto textoGrande' disabled  id=\"pais\" style=\"width:calc(100% + 265px);\" onClick=\"llenarCombo('Empresas',this);\">" . paises() . "</select>
			<script>llenarCombo('Empresas',document.getElementById('pais'));</script>";
    }
}


$paypal;

function getPayPalMail(){
    global $paypal;
    $codprov = $_SESSION["codprov"];
    $query = "select paypalmail from cat_prov where codprov = '$codprov'";
    $result = mysqli_query(conexion($_SESSION["pais"]), $query);
    $paypal = mysqli_fetch_array($result)[0];
}

getPayPalMail();

if (isset($_SESSION['codprov2'])) {
    ?>
    <form id="proveedor" name="proveedor" action="return false" onSubmit="return false" method="POST">
        <center>
            <table class="proveedor">
                <tr>
                    <td colspan="4">
                        <center><?php echo $lang[$idioma]['Ingreso_Proveedores']; ?></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div id="resultado"></div>
                        </center>
                    </td>
                </tr>
                <tr><input class='entradaTexto textoGrande' type="text" autocomplete="off" hidden="hidden" name="codigo"
                           id="codigo" value="<?php echo $codigo; ?>" disabled></tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <center>
                            <?php
                            if (isset($_SESSION['pais'])) {
                                pais($codigo, $_SESSION['pais']);
                            }
                            else {
                                pais('', '');
                            } ?></center>
                    </td>
                </tr>
                <tr hidden>
                    <td class="text">
                        <?php echo $lang[$idioma]['Empresa']; ?>
                    </td>
                    <td colspan="2">
                        <select class='entradaTexto textoGrande' disabled style="width:calc(100% + 265px);"
                                id="Empresas"></select>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['nomEmpresa']; ?>
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="nombre" disabled>
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        PayPal email
                    </td>
                    <td>
                        <input style="float:left;" class='entradaTexto' type="text" autocomplete="off" id="paypalMailInput" value="<?php echo $paypal; ?>">
                        <input style="float: left;" type="checkbox" id="paypal1er" checked> PayPal Primera Opcion de Pago
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['fPago']; ?>
                    </td>
                    <td colspan="2">
                        <select class='entradaTexto ' id="fPago" style="width:calc(100% + 265px);"
                                onChange="if(this.value=='1'){document.getElementById('chequeLabel').hidden =false;document.getElementById('cuentaLabel').hidden =true;}else{document.getElementById('chequeLabel').hidden =true;document.getElementById('cuentaLabel').hidden =false;}">
                            <option value=""></option>
                            <option value="1"><?php echo $lang[$idioma]['cheque']; ?></option>
                            <option value="2"><?php echo $lang[$idioma]['deposito']; ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <span id="chequeLabel" hidden><?php echo $lang[$idioma]['cheque']; ?></span>
                        <span id="cuentaLabel">Nombre de la Cuenta</span>
                    </td>
                    <td colspan="2">
                        <input type="text" class='entradaTexto textoGrande' id="echeque">
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['Banco']; ?>
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="banco">
                    </td>
                </tr>
                <tr>
                <tr>
                    <td class="text">
                        Numero de Cuenta
                    </td>
                    <td colspan="1">
                        <input class='entradaTexto' type="number" autocomplete="off" id="cuenta">
                    </td>
                    <td class="text">
                        No. Router
                    </td>
                    <td colspan="1">
                        <input class='entradaTexto' type="text" autocomplete="off" id="rounum">
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        Swift
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="swiftnum">
                    </td>
                </tr>
                <tr>
                <tr>
                    <td></td>
                    <td colspan="3">
                        <center>    <?php echo $lang[$idioma]['Contacto']; ?></center>
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['Nombre']; ?>
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' type="text" id="contactoNombre">
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['Apellido']; ?>
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' type="text" id="contactoApellido">
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['emailContacto']; ?>
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' onKeyUp="comprobarEmailProv('emailContacto');"
                               type="text" id="emailContacto">
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['Telefono']; ?>
                    </td>
                    <td>
                        <input class='entradaTexto ' type="tel" onKeyUp="comprobarTelefono(event,this);" id="telefono2">
                    </td>
                    <td class="text">
                        <?php echo $lang[$idioma]['Cargo']; ?>
                    </td>
                    <td>
                        <input class='entradaTexto ' type="text" id="cargo">
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><br><br></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <input type="button" class='cmd button button-highlight button-pill'
                                   onClick="actualizarProveedor('pago','<?php echo $codigo; ?>');"
                                   value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
                            <input type="reset" class='cmd button button-highlight button-pill'
                                   onClick="envioDeDataProveedor('Proveedor');"
                                   value="<?php echo $lang[$idioma]['Cancelar']; ?>"/>
                        </center>
                    </td>
                </tr>
            </table>
        </center>
    </form>
    <br><br><br>
    <?php
    buscarPagos($codigo);
}
else {
    echo "<script>alert('No existe el proveedor');llamarProveedor('1');seleccionP(document.getElementById('TabRegistro'));</script>";
}
?>
