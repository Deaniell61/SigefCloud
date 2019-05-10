<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../busquedas/buscarProv.php');
require_once('../../productos/combosProductos.php');
$idioma = idioma();
include('../../idiomas/' . $idioma . '.php');

$codigo = ($_POST['codigo']);
session_start();

function pais($cod, $pais) {

    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    if ($cod == 'nuevo') {
        echo "<select class='entradaTexto textoGrande' id=\"pais\" style=\"width:calc(100% + 265px);\" onClick=\"llenarCombo('Empresas',this);\">" . paises() . "</select>
			<script>llenarCombo('Empresas',document.getElementById('pais'));</script>";
    }
    else {
        echo "<select class='entradaTexto textoGrande'  id=\"pais\" style=\"width:calc(100% + 265px);\" onClick=\"llenarCombo('Empresas',this);\">" . paises() . "</select>
			<script>llenarCombo('Empresas',document.getElementById('pais'));</script>";
    }

}

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
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['Empresa']; ?>
                </td>

                <td colspan="2">
                    <select class='entradaTexto textoGrande' style="width:calc(100% + 265px);" id="Empresas"></select>
                </td>

            </tr>
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['nomEmpresa']; ?>
                </td>

                <td colspan="2">
                    <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="nombre" value="">
                </td>

            </tr>
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['Direccion']; ?>
                </td>

                <td colspan="2">
                    <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="direccion" value="">
                </td>

            </tr>
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['Ciudad']; ?>
                </td>
                <td>
                    <input class='entradaTexto  capitalize' type="text" autocomplete="off" id="ciudadprov"
                           onkeypress="return isAlfa(event)">
                </td>

                <td class="text">
                    <?php echo $lang[$idioma]['Estado']; ?>
                </td>

                <td colspan="">
                    <input class='entradaTexto  capitalize' type="text" autocomplete="off" id="estadoProv"
                           onkeypress="return isAlfa(event)">
                </td>
            </tr>

            <tr>

                <td class="text">
                    <?php echo $lang[$idioma]['CodPos']; ?>
                </td>

                <td>
                    <input class='entradaTexto ' type="text" autocomplete="off" id="codpostal"
                           onkeypress="return isNumber(event)">
                </td>
                <td class="text">
                    <?php echo $lang[$idioma]['Pais']; ?>
                </td>

                <td colspan="">
                    <select class='entradaTexto ' style="width:calc(95% + 5px );" id="paisprov">
                        <script>llenarPaisProv();</script>
                    </select>
                </td>
            </tr>
            <tr>
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['Telefono']; ?>
                </td>
                <td>
                    <input class='entradaTexto' type="tel" autocomplete="off" id="telefono" value=""
                           onkeypress="return isNumber(event)">
                    <!--onKeyUp="comprobarTelefono(event,this);"-->
                </td>
                <td class="text">
                    <?php echo $lang[$idioma]['Fax']; ?>
                </td>

                <td>
                    <input class='entradaTexto ' type="tel" autocomplete="off" id="fax" value=""
                           onkeypress="return isNumber(event)">
                </td>

            </tr>
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['Pagina Web']; ?>
                </td>
                <td colspan="2">
                    <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="web">
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
                    <input class='entradaTexto textoGrande capitalize' type="text" id="contactoNombre"
                           onkeypress="return isAlfa(event)">
                </td>

            </tr>
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['Apellido']; ?>
                </td>

                <td colspan="2">
                    <input class='entradaTexto textoGrande capitalize' type="text" id="contactoApellido"
                           onkeypress="return isAlfa(event)">
                </td>

            </tr>
            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['emailContacto']; ?>
                </td>

                <td colspan="2">
                    <input class='entradaTexto textoGrande' onKeyUp="comprobarEmailProv('emailContacto');" type="text"
                           id="emailContacto" onkeypress="return noSpace(event)">
                </td>

            </tr>
            <?php
            if (isset($_SESSION['codprov2'])) {
                echo "<script>document.getElementById('rowstado').hidden = false;</script>";
            }
            ?>
            <tr id="rowstado" hidden>
                <td class="text">
                    <?php echo $lang[$idioma]['Estado']; ?>
                </td>

                <td colspan="2">
                    <select id="estado" class='entradaTexto' style="text-align: left;width: calc(100% + 263px);">
                        <option value=""></option>
                        <option value="0"><?php echo $lang[$idioma]['Inactivo']; ?></option>
                        <option value="1"><?php echo $lang[$idioma]['Activo']; ?></option>
                        <option value="2"><?php echo $lang[$idioma]['Aprobado']; ?></option>
                        <option value="3" selected><?php echo $lang[$idioma]['Registro']; ?></option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text">
                    <?php echo $lang[$idioma]['Telefono']; ?>
                </td>

                <td>
                    <input class='entradaTexto ' type="tel" id="telefono2" onkeypress="return isNumber(event)">
                </td>
                <td class="text">
                    <?php echo $lang[$idioma]['Cargo']; ?>
                </td>

                <td>
                    <input class='entradaTexto ' type="text" id="cargo">
                </td>

            </tr>

            <tr>
                <td colspan="4" style="text-align:center;"><input type="checkbox" id="terminos"> Acepto los <a href="#"
                                                                                                               onClick="">Terminos
                        y Condiciones del Servicio</a></td>
            </tr>

            <tr>
                <td colspan="4"><br><br></td>
            </tr>
            <tr>

                <td colspan="4">
                    <center>
                        <input type="button" class='cmd button button-highlight button-pill'
                               onClick="guardarProveedor('<?php echo $codigo; ?>');"
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

<script>
    $("#emailContacto").keyup(function(){
        this.value = this.value.toLowerCase();
    });
</script>

<?php

buscarRegistro($codigo);
?>
<script>
    setTimeout(function () {
        comprobarEmailProv('emailContacto');
    }, 1000);
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isAlfa(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode > 32 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
            return false;
        }
        return true;
    }

    function noSpace(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode == 32) {
            return false;
        }
        return true;
    }

    $("#telefono").keyup(function () {
        $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "($1) $2 - $3"));
    });

    $("#telefono2").keyup(function () {
        $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "($1) $2 - $3"));
    });

    $("#fax").keyup(function () {
        $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "($1) $2 - $3"));
    });
</script>

<style>
    .capitalize {
        text-transform: capitalize;
    }
</style>