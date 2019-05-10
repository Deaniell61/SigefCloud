<?php

require_once('coneccion.php');

/**

 * Created by JDR

 * For more information www.facebook.com/DEANIELL6195

 * Unique creator

 */



############### funcion para verificar la existencia del usuario ###########################





function autentica($user, $pass)

{



##  sentencia sql para consultar el usuario y contraseña

    $sql_auten = "SELECT email,posicion,nombre,apellido,codusua,estado,usuario,codprov FROM sigef_usuarios WHERE (email='" . strtolower($user) . "' or email='" . strtolower($user) . "@gmail.com' or email='" . strtolower($user) . "@hotmail.com') AND clave='" . $pass . "' and (estado=1 or estado=21)";

## ejecución de la sentencia sql



    $eje_anterior = mysqli_query(conexion(""), $sql_auten);



## si existe inicia una sesion y guarda el nombre del usuario

    $res = $eje_anterior->num_rows;

    if ($res > 0) {

        ## inicio de sesion

        session_start();

        ## configurar un elemento usuario dentro del arreglo global $_SESSION



        $row = mysqli_fetch_array($eje_anterior, MYSQLI_ASSOC);

        $_SESSION['user'] = $row['email'];

        $_SESSION['rol'] = $row['posicion'];

        $_SESSION['nom'] = $row['nombre'];

        $_SESSION['apel'] = $row['apellido'];

        $_SESSION['codigo'] = $row['codusua'];

        $_SESSION['estado'] = $row['estado'];

        $_SESSION['usuario'] = $row['usuario'];

        $_SESSION['proveedor'] = $row['codprov'];

        $_SESSION['codEmpresa'] = "";

        $_SESSION['codprod'] = "";

        $_SESSION['mEmpresa'] = "";

        $_SESSION['parametro'] = "";

        $_SESSION['pais'] = "";

        $_SESSION['nomProv'] = "";

        $_SESSION['nomEmpresa'] = "";

        $_SESSION['notified2'] = "";

        $_SESSION['notified'] = 0;

        ## retornar verdadero

        return true;

    } else {

        ## retornar falso

        return false;

    }

}



####################### función para verificar que dentro del arreglo global $_SESSION existe el nombre del usuario #####



function verificar_usuario()

{

    //continuar una sesion iniciada

    session_start();

    //comprobar la existencia del usuario

    if ($_SESSION['estado'] == "1" or $_SESSION['estado'] == "21") {



        switch ($_SESSION['rol']) {

            case "U": {

                return true;

                break;

            }

            case "A": {

                echo "<script>window.location.assign('../Admin/inicio.php');</script>";

                //header('Location:../Admin/inicio.php');

                break;

            }

            case "P": {

                echo "<script>window.location.assign('../InicioProveedor/inicio.php');</script>";

                //header('Location:../InicioProveedor/inicio.php');

                break;

            }

            default: {

                echo "<script>window.location.assign('../index.php');</script>";

                //header('Location:../index.php');

                break;

            }



        }

    } else {

        echo "<script>alert(\"El usuario esta deshabilidato\");</script>";

        header('Location:../index.php');

    }

}



function verificar_usuario_admin()

{

    //continuar una sesion iniciada

    @session_start();

    //comprobar la existencia del usuario

    if ($_SESSION['estado'] == "1" or $_SESSION['estado'] == "21") {



        switch ($_SESSION['rol']) {

            case "U": {

                header('Location:../Inicio/inicio.php');

                break;

            }

            case "A": {

                return true;

                break;

            }

            case "P": {

                header('Location:../InicioProveedor/inicio.php');

                break;

            }

            default: {

                header('Location:../index.php');

                break;

            }



        }



    } else {

        echo "<script>alert(\"El usuario esta deshabilidato\");</script>";

        header('Location:../index.php');

    }

}



function verificar_proveedor()

{

    //continuar una sesion iniciada

    @session_start();

    //comprobar la existencia del usuario

    if ($_SESSION['estado'] == "1" or $_SESSION['estado'] == "21") {



        switch ($_SESSION['rol']) {

            case "U": {

                header('Location:../Inicio/inicio.php');

                break;

            }

            case "A": {

                header('Location:../Amin/inicio.php');

                break;

            }

            case "P": {

                return true;

                break;

            }

            default: {

                header('Location:../index.php');

                break;

            }



        }



    } else {

        echo "<script>alert(\"El usuario esta deshabilidato\");</script>";

        header('Location:../index.php');

    }

}



function obtenerRol($user, $pass)

{

    $con = conexion("");

    $sql_auten = "SELECT posicion FROM sigef_usuarios WHERE email='" . strtolower($user) . "' and clave='" . $pass . "' and estado=1";

    $des = "";

    $eje_anterior = mysqli_query($con, $sql_auten);

    $row = mysqli_fetch_array($eje_anterior, MYSQLI_ASSOC);



    $des = $row['posicion'];





    return $des;

}





?>