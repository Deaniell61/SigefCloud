<?php
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../fecha.php');
require_once('redimencion.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
session_start();
$_SESSION['prodName'] = limpiar_caracteres_especiales($_SESSION['prodName']);
if (isset($_FILES['archivo'])) {
    $tipoImg = strtolower($_POST['nombre_archivo']);
    $archivo = $_FILES['archivo'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    //echo $tipoImg . ' - ' . $archivo;
    //$clean_ascii_output = iconv('UTF-8', 'ASCII//TRANSLIT', $utf8_input);
    $tProdName = limpiar_caracteres_especiales($_SESSION['prodName']);
//    echo "$tProdName<br><br>";
    setlocale(LC_CTYPE, 'es_ES');
    $tProdName = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $tProdName);
//    echo "$tProdName<br><br>";
    $tipo = $archivo['type'];
    $ruta_provisional = limpiar_caracteres_especiales($archivo['tmp_name']);
    $size = $archivo['size'];
    $dimensiones = getimagesize($ruta_provisional);
    $alto = $dimensiones[1];
    $ancho = $dimensiones[0];
    $subir = false;
    $mensaje = '';
    if ($tipo == "image/jpg" or $tipo == "image/jpeg") {
        if ($size < (2 * (1024 * 1024))) {
            if ($alto >= 501 or $ancho >= 501) {
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
//    echo "subir:$subir";
    if ($subir == true) {
        $dir = strtolower("../../imagenes/media/" . (limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . "/");
        $dir2 = "";
        $dirc = strtolower("../../imagenes/media/cache/" . (limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . "/");
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        if (!is_dir($dirc)) {
            mkdir($dirc, 0777);
        }
        $dir = strtolower($dir . strtolower(limpiar_caracteres_especiales(substr($tProdName, 0, 1))) . "/");
        $dirc = strtolower($dirc . strtolower(limpiar_caracteres_especiales(substr($tProdName, 0, 1))) . "/");
        $dir2 = strtolower("/" . strtolower(limpiar_caracteres_especiales(substr($tProdName, 0, 1))) . "/");
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        if (!is_dir($dirc)) {
            mkdir($dirc, 0777);
        }
        $dir = strtolower($dir . strtolower(limpiar_caracteres_especiales(substr($tProdName, 1, 1))) . "/");
        $dirc = strtolower($dirc . strtolower(limpiar_caracteres_especiales(substr($tProdName, 1, 1))) . "/");
        $dir2 = strtolower($dir2 . strtolower(limpiar_caracteres_especiales(substr($tProdName, 1, 1))) . "/");
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        if (!is_dir($dirc)) {
            mkdir($dirc, 0777);
        }
        $file_name = strtolower(limpiar_caracteres_especiales($tProdName) . "_" . $tipoImg . "." . $extension);
        $file_name = str_replace('/', '', $file_name);
        setlocale(LC_CTYPE, 'es_ES');
        $file_name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $file_name);
        $add = "";
        $file = "";
//        echo "$dir<br>$dir2<br>$file_name<br>" . $_SESSION['prodName'];
        if (file_exists($dir . $file_name)) {
            unlink($dir . $file_name);
            unlink($dirc . $file_name);
            $file_name = strtolower(limpiar_caracteres_especiales($tProdName) . "_" . $tipoImg . "2." . $extension);
            $file_name = str_replace('/', '', $file_name);
            $file_name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $file_name);
            $add = $dir . $file_name;
            $dir2 = $dir2 . $file_name;
            $file = $file_name;
        } else {
            $file_name = strtolower(limpiar_caracteres_especiales($tProdName) . "_" . $tipoImg . "2." . $extension);
            $file_name = str_replace('/', '', $file_name);
            $file_name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $file_name);
            if (file_exists($dir . $file_name)) {
                unlink($dir . $file_name);
                unlink($dirc . $file_name);
            }
            $file_name2 = strtolower(limpiar_caracteres_especiales($tProdName) . "_" . $tipoImg . "." . $extension);
            $file_name2 = str_replace('/', '', $file_name2);
            $file_name2 = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $file_name2);
            $add = $dir . $file_name2;
            $dir2 = $dir2 . $file_name2;
            $file = $file_name2;
        }
//        echo "tipoImg:$tipoImg";
        if ($tipoImg != "") {
//            echo $add . "!<br><br>";
            if (move_uploaded_file($ruta_provisional, $add)) {
                if (redimencionImagen($dir, $dirc, $file)) {
                    $ruta = "cache" . $file;
                } else {
                    $ruta = $pref . $file;
                }
                guardarImagen($dir2, $_SESSION['codprod'], $tipoImg);
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Error al subir el archivo..";
        }
    } else {
        echo "<script>alert('" . $mensaje . "!!');</script>";
    }
}
#Guarda la imagen Front
function guardarImagen($direc, $cod, $nom)
{
    $direc = str_replace("'", "\\'", $direc);
    $direc = str_replace('"', '\\"', $direc);
//    $direc = "test";
    require_once('../fecha.php');
    require_once('../coneccion.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    switch ($nom) {
        case "fro":
        case 'FRO':
            {
                $sql_auten = "update cat_prod set imaurlbase='$direc' where codprod='$cod'";
                break;
            }
        default:
            {
                $cat = "0";
                if ($nom == "un" || $nom == "ca" || $nom == "pa") {
                    $cat = "1";
                }
                if (!comprobarIMG($cod, $nom)) {
                    $sql_auten = "insert into cat_prod_img(codprod,file,cara,cat) values('$cod','$direc','$nom', '$cat')";
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
        echo "<script>alert(\"Error!\");</script>";
    }
}
#Fin Guardar Imagen Frontal
function comprobarIMG($cod, $nom)
{
    require_once('../fecha.php');
    require_once('../coneccion.php');
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