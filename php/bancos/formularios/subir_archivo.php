<?php
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
if (isset($_FILES['archivo'])) {
    session_start();
    $tipoImg = $_POST['nombre_archivo'];
    $archivo = $_FILES['archivo'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $tipo = $archivo['type'];
    $ruta_provisional = $archivo['tmp_name'];
    $size = $archivo['size'];
    $dimensiones = getimagesize($ruta_provisional);
    $alto = $dimensiones[1];
    $ancho = $dimensiones[0];
    $subir = false;
    $mensaje = '';

    if ($tipo == "image/jpg" or $tipo == "image/jpeg") {
        if ($size < (2 * (1024 * 1024))) {
            if ($alto > 1001 or $ancho > 1001) {
                $subir = true;
            } else {
                $mensaje = $lang[$idioma]['AdverAltoAncho'];
            }

        } else {
            $mensaje = $lang[$idioma]['AdverTamanio'];

        }
    } else {
        $mensaje = $lang[$idioma]['AdverTipo'];;

    }

    if ($subir == true) {
        $dir = "../../imagenes/media/" . limpiar_caracteres_especiales($_SESSION['nomEmpresa']) . "/";
        $dir2 = "";

        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }

        $dir = $dir . (substr($_SESSION['prodName'], 0, 1)) . "/";
        $dir2 = "/" . (substr($_SESSION['prodName'], 0, 1)) . "/";
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $dir = $dir . (substr($_SESSION['prodName'], 1, 1)) . "/";
        $dir2 = $dir2 . (substr($_SESSION['prodName'], 1, 1)) . "/";
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }

        $file_name = limpiar_caracteres_especiales($_SESSION['prodName']) . "_" . $tipoImg . "." . $extension;
        echo "$dir<br>$dir2<br>$file_name<br>" . $_SESSION['prodName'];

        $add = "";

        if (file_exists($dir . $file_name)) {
            unlink($dir . $file_name);
            $file_name = limpiar_caracteres_especiales($_SESSION['prodName']) . "_" . $tipoImg . "2." . $extension;
            $add = $dir . $file_name;
            $dir2 = $dir2 . $file_name;

        } else {
            $file_name = limpiar_caracteres_especiales($_SESSION['prodName']) . "_" . $tipoImg . "2." . $extension;
            if (file_exists($dir . $file_name)) {
                unlink($dir . $file_name);

            }
            $file_name2 = limpiar_caracteres_especiales($_SESSION['prodName']) . "_" . $tipoImg . "." . $extension;
            $add = $dir . $file_name2;
            $dir2 = $dir2 . $file_name2;
        }
        if ($tipoImg != "") {

            if (move_uploaded_file($ruta_provisional, $add)) {

                guardarImagen($dir2, $_SESSION['codprod'], $tipoImg);

            } else {
                echo "Error al subir el archivo";
            }

        } else {
            echo "Error al subir el archivo";
        }

    } else {
        echo "<script>alert('" . $mensaje . "');</script>";
    }

}
#Guarda la imagen Front
function guardarImagen($direc, $cod, $nom)
{
    require_once('../../fecha.php');
    require_once('../../coneccion.php');
    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    switch ($nom) {
        case "FRO":
            {

                $sql_auten = "update cat_banc set logo='$direc' where codprod='$cod'";
                break;
            }
        default:
            {
                if (!comprobarIMG($cod, $nom)) {
                    $sql_auten = "insert into cat_prod_img(codprod,file,cara) values('$cod','$direc','$nom')";
                } else {
                    $sql_auten = "update cat_prod_img set file='$direc' where codprod='$cod' and cara='$nom'";
                }
                break;
            }
    }

## ejecución de la sentencia sql

    if (mysqli_query(conexion($_SESSION['pais']), $sql_auten)) {
        $_SESSION['imagenSubida'] = 1;

        echo "<span>" . $lang[$idioma]['ImagenGuardada'] . "</span> <script> /*window.location.reload(true);setTimeout(function(){producto(5,'" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $_SESSION['codprod'] . "');},500);*/setTimeout(function(){mostrarImagenes();},1000);</script>";
    } else {
        echo "<script>alert(\"Error\");</script>";
    }
}

#Fin Guardar Imagen Frontal

function comprobarIMG($cod, $nom)
{
    require_once('../../fecha.php');
    require_once('../../coneccion.php');
    $sql_auten = "select file from cat_prod_img  where codprod='$cod' and cara='$nom'";
    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $sql_auten)) {
        if (mysqli_num_rows($ejecutar) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

?>
