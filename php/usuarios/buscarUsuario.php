<?php
sleep(1);
require_once('../coneccion.php');
require_once('arbolEmpresas.php');
require_once('../fecha.php');
require_once('../productos/combosProductos.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
$codigo = ($_POST['codigo']);
function estado1($es, $si) {

    if ($es == $si) {
        return " selected ";
    }
    else {
        return "";
    }
}

$sql = "select nombre,clave,posicion,email,apellido,estado,usuario,codprov from sigef_usuarios where codusua='$codigo'";
## ejecución de la sentencia sql

$ejecutar = mysqli_query(conexion(""), $sql);
if ($ejecutar) {
    $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
    $nombre = ucwords($row['nombre']);
    $clave = $row['clave'];
    if (strtoupper($row['posicion']) == 'A') {
        $posicion = "Administrador";
    }
    else {
        $posicion = "Usuario";
    }
    $email = $row['email'];
    $apellido = $row['apellido'];
    if ($row['estado'] == '1') {
        $estado = "Activo";
    }
    else {
        $estado = "Inactivo";
    }
    if ($row['posicion'] == 'P') {
        echo "<script>document.getElementById('prov').hidden = false;</script>";
    }

    ?>

    <form id="usuarios" name="usuarios" action="return false" onSubmit="return false" method="POST">
        <center>
            <table>
                <tr>
                    <?php echo $lang[$idioma]['EditarUsuarios'] ?>
                </tr>
                <tr>
                    <div id="resultado"></div>
                </tr>
                <tr><input type="text" class='entradaTexto' hidden="hidden" name="codigo" id="codigo"
                           value="<?php echo $codigo; ?>" disabled/></tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Nombre']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="nombre" id="nombre" value="<?php echo $nombre; ?>"
                               autofocus placeholder="<?php echo $lang[$idioma]['Nombre']; ?>"></td>
                </tr>

                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Apellido']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="apellido" id="apellido"
                               value="<?php echo $apellido; ?>" placeholder="<?php echo $lang[$idioma]['Apellido']; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Usuario']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="usuario" id="usuario"
                               value="<?php echo $row['usuario']; ?>"
                               placeholder="<?php echo $lang[$idioma]['Usuario']; ?>"></td>
                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Email']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="email" id="email" value="<?php echo $email; ?>"
                               onKeyUp="comprobarEmailUsuar();" placeholder="<?php echo $lang[$idioma]['Email']; ?>">
                        <div id="comprobar"></div>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Tipo']; ?> </span></td>
                    <td>
                        <select class='entradaTexto' id="rol">
                            <option value="U"<?php echo estado1($row['posicion'], 'U'); ?>><?php echo $lang[$idioma]['Usuario']; ?></option>
                            <option value="A"<?php echo estado1($row['posicion'], 'A'); ?>><?php echo $lang[$idioma]['Administrador']; ?></option>
                            <option value="P"<?php echo estado1($row['posicion'], 'P'); ?>><?php echo $lang[$idioma]['Proveedor']; ?></option>
                        </select>
                    </td>
                </tr>
                <td class="text"><span><?php echo $lang[$idioma]['Contra']; ?></span></td>
                <td><input class='entradaTexto' type="text" name="contra" id="contra" value="" placeholder="*********">
                </td>
                </tr>

                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Estado']; ?></span></td>
                    <td>
                        <select class='entradaTexto' id="estado">
                            <option value="1"<?php echo estado1($row['estado'], '1'); ?>><?php echo $lang[$idioma]['Activo']; ?></option>
                            <option value="0"<?php echo estado1($row['estado'], '0'); ?>><?php echo $lang[$idioma]['Inactivo']; ?></option>
                            <option value="2"<?php echo estado1($row['estado'], '2'); ?>><?php echo $lang[$idioma]['Registro']; ?></option>
                            <option value="21"<?php echo estado1($row['estado'], '2'); ?>><?php echo $lang[$idioma]['Pendiente']; ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['Empresas']; ?></td>
                    <td>
                        <?php echo cajonEmpresa($codigo); ?>
                    </td>
                </tr>


                <tr>

                    <td colspan="2">
                        <center>
                            <input type="button" class='cmd button button-highlight button-pill'
                                   onClick="editarTodoUsuario();envioDeData('user');"
                                   value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
                            <input type="reset" class='cmd button button-highlight button-pill'
                                   onClick="envioDeData('user');" value="<?php echo $lang[$idioma]['Cancelar']; ?>"/>
                        </center>
                    </td>

                </tr>
            </table>
        </center>
    </form>
    <br>

    <script>
        $("#email").keyup(function(){
            this.value = this.value.toLowerCase();
        });
    </script>

    <?php

}
else {
    echo "<script>alert(\"Error de base de datos\");</script>";
}
?>