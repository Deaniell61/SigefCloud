<?php
require_once('coneccion.php');
require_once('sesiones.php');
include('fecha.php');
include('idiomas/' . $idioma . '.php');

$idioma = idioma();

## usuario y clave pasados por el formulario
$user = strtolower($_POST['user']);
$pass = $_POST['pass'];
$estado = "";

if ($user == NULL || $pass == NULL) {
    echo "<span>" . $lang[$idioma]['CompletarCampos'] . "</span>";
} else {

## usa la funcion autentica() que se ubica dentro de sesiones.php
    $sql_auten = "SELECT clave,email,posicion,nombre,apellido,codusua,estado,usuario,codprov FROM sigef_usuarios WHERE (email='" . strtolower($user) . "'  or email='" . strtolower($user) . "@gmail.com' or email='" . strtolower($user) . "@hotmail.com') and (estado=1 or estado=21)";

## ejecución de la sentencia sql
    if ($eje_anterior = mysqli_query(conexion(""), $sql_auten)) {
        if ($row = mysqli_fetch_array($eje_anterior, MYSQLI_ASSOC)) {
            $pass = crypt($pass, $row['clave']);
            $estado = $row['estado'];
        }
    }

    ## si existe inicia una sesion y guarda el nombre del usuario
    if (autentica($user, $pass)) {
        switch (obtenerRol($user, $pass)) {
            case "U":
                {
                    echo '<script>location.href="Inicio/inicio.php";</script>';
                    break;
                }
            case "A":
                {
                    echo '<script>location.href="Admin/inicio.php";</script>';
                    break;
                }
            case "P":
                {
                    echo '<script>location.href="InicioProveedor/inicio.php";</script>';
                    break;
                }
            default:
                {
                    echo '<script>location.href="index.php";</script>';
                    break;
                }
        }
    } else {

        ## si no es valido volvemos al formulario inicial
        if ($estado != "1" && $estado != "21") {
            echo '<span>Su usuario no esta habilitado.</span>';
        } else {
            echo '<span>Usuario o contraseña incorrecta</span>';
        }
    }
}
