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

function getPayPalCode(){
    global $paypal;
    $codprov = $_SESSION["codprov"];
    $query = "select paypalid from cat_prov where codprov = '$codprov'";
    $result = mysqli_query(conexion($_SESSION["pais"]), $query);
    $paypal = mysqli_fetch_array($result)[0];
}

getPayPalCode();

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
                <!--paypal-->
                <tr>
                    <td class="text">
                        <?php
                            if($paypal != ""){
                                echo $lang[$idioma]['paypalID'];
                            }
                            else{
                                echo $lang[$idioma]['paypal'];
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                        if($paypal != ""){
                            ?>
                            <a id="paypalIDButton" href="#" style="float: left;" onclick="toggleHide()"><?php echo $lang[$idioma]['mostrar']; ?></a>
                            <div hidden id="paypalIDLabel" style="float: left;">&nbsp;&nbsp;&nbsp;<?php echo $paypal ?></div>
                            <?
                        }
                        else{
                            ?>
                            <a href="../paypal/obj/expresscheckout.php" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif"></a>
                            <?
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['TipoTarjeta']; ?>
                    </td>

                    <td colspan="2">
                        <select class='entradaTexto ' id="tipoTar" style="width:calc(100% + 265px);">
                            <option value=""></option>
                            <option value="1">Visa</option>
                            <option value="2">MasterCard</option>
                            <option value="3">Discover</option>
                            <option value="4">American Express</option>
                        </select>
                    </td>

                </tr>
                <tr>
                    <td class="text">
                        <span><?php echo $lang[$idioma]['NoTarjeta']; ?></span>

                    </td>

                    <td colspan="2">
                        <input type="text" maxlength="16" min="0" class='entradaTexto textoGrande' id="nTar">
                    </td>

                </tr>

                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['TitularTarjeta']; ?>
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="TitTar">
                    </td>


                </tr>

                <tr>
                    <td></td>
                    <td colspan="3">
                        <center>    <?php echo $lang[$idioma]['Vencimiento']; ?></center>
                    </td>


                </tr>
                <tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['Mes']; ?>
                    </td>
                    <td>
                        <input class='entradaTexto ' type="number" autocomplete="off" id="MesV">
                    </td>
                    <td class="text">
                        <?php echo $lang[$idioma]['Anio']; ?>
                    </td>
                    <td>
                        <input class='entradaTexto ' type="number" autocomplete="off" id="AnioV">
                    </td>


                </tr>
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
                                   onClick="actualizarProveedor('cobro','<?php echo $codigo; ?>');"
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

    buscarCobros($codigo);
}
else {
    echo "<script>alert('No existe el proveedor');llamarProveedor('1');seleccionP(document.getElementById('TabRegistro'));</script>";
}
?>

<script>
    function toggleHide() {
        if($("#paypalIDLabel").is(':visible')){
            $("#paypalIDButton").html("Mostrar");
            $("#paypalIDLabel").hide(250);
        }
        else{
            $("#paypalIDButton").html("Esconder");
            $("#paypalIDLabel").show(250);
        }

    }
</script>
