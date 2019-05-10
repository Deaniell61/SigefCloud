<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../busquedas/buscarProv.php');
require_once('../../productos/combosProductos.php');
$idioma = idioma();
include('../../idiomas/' . $idioma . '.php');
session_start();
$codigo = strtoupper($_POST['codigo']);

function pais($cod, $pais)
{
    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    {
        echo "<select class='entradaTexto ' disabled  id=\"pais\" style=\"width:calc(100% + 265px);\" onClick=\"llenarCombo('Empresas',this);\">" . paises() . "</select>
			<script>llenarCombo('Empresas',document.getElementById('pais'));</script>";
    }
}

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
                <tr><input class='entradaTexto ' type="text" autocomplete="off" hidden="hidden" name="codigo"
                           id="codigo" value="<?php echo $codigo; ?>" disabled></tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <center>
                            <?php
                            if (isset($_SESSION['pais'])) {
                                pais($codigo, $_SESSION['pais']);
                            } else {
                                pais('', '');
                            } ?></center>
                    </td>
                </tr>
                <tr hidden>
                    <td class="text">
                        <?php echo $lang[$idioma]['Empresa']; ?>
                    </td>
                    <td colspan="2">
                        <select class='entradaTexto ' disabled style="width:calc(100% + 265px);" id="Empresas"></select>
                    </td>
                </tr>
                <tr>
                    <td class="text">
                        <?php echo $lang[$idioma]['nomEmpresa']; ?>
                    </td>
                    <td colspan="2">
                        <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="nombre" disabled>
                    </td>
                </tr>
                <!--1 row-->
                <tr>
                	<td class="text">
                        <?php echo $lang[$idioma]['codex']; ?>
                    </td>
                    <td colspan="3">
                        <input class='entradaTexto textoGrande' type="text" autocomplete="off" id="codExport">
                    </td>
                    
                    
                 </tr>
                
                
                
                
                <tr>
                    <td colspan="4"><br><br></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <input type="button" class='cmd button button-highlight button-pill'
                                   onClick="actualizarProveedor('Comercializa','<?php echo $codigo; ?>');"
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
    buscarComercializa($codigo);
} else {
    echo "<script>alert('No existe el proveedor');llamarProveedor('1');seleccionP(document.getElementById('TabRegistro'));</script>";
}
?>