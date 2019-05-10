<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../php/coneccion.php');
function formulario($codigo)
{
    $sql = "SELECT aplicacion FROM sigef_modulos WHERE codigo='$codigo' and tipo='F'";
    $ejecutar = conexion("")->query($sql);

    $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
    $res = $ejecutar->num_rows;
    if ($res > 0) {
        return " onClick=\"formulario('" . $row['aplicacion'] . "')\" ";
    } else {
        return "";
    }
}

function menu($dato)
{
    echo "<ul id=\"elementoMenu\">";

    for ($i = 0; $i < numeroMenus(); $i++) {

        agregarMenus(numero($i + 1), $dato);

    }
    echo "</ul>";
}


function agregarMenus($codigo, $rol)
{
    $sql = "SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=" . strlen("00") . " and codigo='" . $codigo . "' order by codigo";
    $ejecutar = conexion("")->query($sql);

    $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);

    $res = $ejecutar->num_rows;

    for ($i = 0; $i < $res; $i++) {
        if (permitido($row['codigo'], $rol)) {
            echo " <li" . formulario($row['codigo']) . ">";
            echo $row['nombre'];

            echo "<ul class=\"elementoSubMenu\">";

            agregarSubMenus($row['codigo'], $rol);

            echo "</ul>";
            echo " </li>";
        }
    }
}

function agregarSubMenus($codigo, $rol)
{
    $sql = "SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=" . strlen("00.00") . " and codigo like '" . $codigo . ".%' order by codigo";
    $ejecutar = conexion("")->query($sql);

    $res = $ejecutar->num_rows;
    for ($o = 0; $o < $res; $o++) {
        $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
        if (permitido($row['codigo'], $rol)) {
            echo " <li" . formulario($row['codigo']) . ">";
            echo $row['nombre'];
            echo "<ul class=\"elementoSubMenu2\">";

            agregarSubMenus2($row['codigo'], $rol);

            echo "</ul>";
            echo " </li>";
        }
    }
}

function agregarSubMenus2($codigo, $rol)
{
    $sql = "SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=" . strlen("00.00.00") . " and LENGTH(codigo)<=9 and codigo like '" . $codigo . ".%' order by codigo";
    $ejecutar = conexion("")->query($sql);

    $res = $ejecutar->num_rows;
    for ($o = 0; $o < $res; $o++) {
        $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
        if (permitido($row['codigo'], $rol)) {
            echo " <li" . formulario($row['codigo']) . ">";
            echo $row['nombre'];
            echo "<ul class=\"elementoSubMenu3\">";

            agregarSubMenus3($row['codigo'], $rol);

            echo "</ul>";
            echo " </li>";
        }
    }
}

function agregarSubMenus3($codigo, $rol)
{
    $sql = "SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=" . strlen("00.00.00.00") . " and codigo like '" . $codigo . ".%' order by codigo";
    $ejecutar = conexion("")->query($sql);

    $res = $ejecutar->num_rows;
    for ($o = 0; $o < $res; $o++) {
        $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
        if (permitido($row['codigo'], $rol)) {
            echo " <li" . formulario($row['codigo']) . ">";
            echo $row['nombre'];
            echo "<ul class=\"elementoSubMenu4\">";

            agregarSubMenus4($row['codigo'], $rol);

            echo "</ul>";
            echo " </li>";
        }
    }
}

function agregarSubMenus4($codigo, $rol)
{
    $sql = "SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=" . strlen("00.00.00.00.00") . " and codigo like '" . $codigo . ".%' order by codigo";
    $ejecutar = conexion("")->query($sql);

    $res = $ejecutar->num_rows;
    for ($o = 0; $o < $res; $o++) {
        $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
        if (permitido($row['codigo'], $rol)) {
            echo " <li" . formulario($row['codigo']) . ">";
            echo $row['nombre'];
            echo "<ul class=\"elementoSubMenu5\">";

            agregarSubMenus5($row['codigo'], $rol);

            echo "</ul>";
            echo " </li>";
        }
    }
}

function agregarSubMenus5($codigo, $rol)
{
    $sql = "SELECT nombre,codigo,tipo FROM sigef_modulos WHERE LENGTH(codigo)<=" . strlen("00.00.00.00.00.00") . " and codigo like '" . $codigo . ".%' order by codigo";
    $ejecutar = conexion("")->query($sql);

    $res = $ejecutar->num_rows;
    for ($o = 0; $o < $res; $o++) {
        $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
        if (permitido($row['codigo'], $rol)) {
            echo " <li" . formulario($row['codigo']) . ">";
            echo $row['nombre'];
            echo "<ul class=\"elementoSubMenu6\">";
            echo "</ul>";
            echo " </li>";
        }
    }
}

function numero($cod)
{
    switch ($cod) {
        case 1: {
            return "01";
            break;
        }
        case 2: {
            return "02";
            break;
        }
        case 3: {
            return "03";
            break;
        }
        case 4: {
            return "04";
            break;
        }
        case 5: {
            return "05";
            break;
        }
        case 6: {
            return "06";
            break;
        }
        case 7: {
            return "07";
            break;
        }
        case 8: {
            return "08";
            break;
        }
        case 9: {
            return "09";
            break;
        }
    }
}

function numeroMenus()
{
    $sql = "SELECT * FROM sigef_modulos WHERE tipo='M' and LENGTH(codigo)<=2";
    $ejecutar = conexion("")->query($sql);
    return $ejecutar->num_rows;
}

function permitido($modulo, $rol)
{
    $res = false;
    $sql = "SELECT * FROM sigef_accesos WHERE codmodu='$modulo' and codempresa='" . $_SESSION['codEmpresa'] . "' and codusua='" . $_SESSION['codigo'] . "'";
    $ejecutar = conexion("")->query($sql);
    if ($rol == "admin") {
        $res = true;
    } else {
        if ($ejecutar->num_rows > 0) {
            $res = true;
        }
    }
    return $res;
}
?>