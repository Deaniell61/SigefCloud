<?php
header("Expires: TUE, 18 Jul 2015 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
$cara = strtolower($_POST['cara']);
$codprod = strtolower($_SESSION['codprod']);
if (isset($_SESSION['imagenSubida'])) {
    $_SESSION['imagenSubida'] = 0;
}
$pref2 = "http://www.guatedirect.com/media/catalog/product";
$pref = strtolower("../../imagenes/media/" . limpiar_caracteres_especiales($_SESSION['nomEmpresa']) . "/");
$prefc = strtolower("../../imagenes/media/cache/" . limpiar_caracteres_especiales($_SESSION['nomEmpresa']) . "/");
//sleep(2);
switch ($cara) {
    case strtolower("FRO"): {
        $sql_auten = "select imaurlbase as file from cat_prod  where codprod='$codprod'";
        if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $sql_auten)) {
            if (mysqli_num_rows($ejecutar) > 0) {
                if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                    if ($row['file'] != "") {
                        $tFileName = strtolower($row['file']);
                        $tFileName = str_replace('/', '', $tFileName);
                        $tFileName = substr_replace($tFileName, '/', 2, 0);
                        $tFileName = substr_replace($tFileName, '/', 1, 0);
//									echo $prefc.$tFileName . '<br><br>';
//									echo $pref.$tFileName . '<br><br>';
//									echo $pref2.$tFileName . '<br><br>';
                        if (file_exists($prefc . $tFileName)) {
                            $ruta = $prefc . $tFileName;
                        }
                        else
                            if (file_exists($pref . $tFileName)) {
                                $ruta = $pref . $tFileName;
                            }
                            else {
                                $ruta = $pref2 . $tFileName;
                            }
                        echo '<script>setTimeout(function(){abrirImagenGrande(document.getElementById("' . $cara . '"),\'1\',\'1\');},500);</script>
										<li class="bor">
            								<div>
											' . $lang[$idioma]['FRO'] . '
                								<img id="' . $cara . '" class="col3" src="' . strtolower($ruta) . '?' . rand() . '" onClick="abrirImagenGrande(this,\'1\',\'1\');">';
                        echo giro($cara, $row['file'], $codprod) . '          
                                         	</li>';
                    }
                    else {
                        echo '2';
                    }
                }
            }
            else {
                echo "2";
            }
        }
        else {
            echo "2";
        }
        break;
    }
    default: {
        $sql_auten = "select codimage,file from cat_prod_img  where codprod='$codprod' and cara='$cara'";
        if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $sql_auten)) {
            if (mysqli_num_rows($ejecutar) > 0) {
                if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                    if (file_exists(strtolower($pref . $row['file']))) {
                        if (file_exists(strtolower($prefc . $row['file']))) {
                            $ruta = $prefc . $row['file'];
                        }
                        else {
                            $ruta = $pref . $row['file'];
                        }
                    }
                    else {
                        $ruta = $pref2 . $row['file'];
                    }
                    echo '
                        <li class="bor">
                            <div>
                                ' . $lang[$idioma][strtoupper($cara)] . '
                                <img id="' . strtolower($cara) . '" class="col3" src="' . strtolower($ruta) . '?' . rand() . '" onClick="abrirImagenGrande(this,\'1\',\'1\');">';
                    echo giro(strtolower($cara), $row['file'], $row['codimage']) . '          
                                         	</li>';
                }
                else {
                    echo '2';
                }
            }
            else {
                echo '2';
            }
        }
        else {
            echo "2";
        }
        break;
    }
}
function giro($id, $src, $idprod) {

    return ' 
        <script  src="../../js/jqueryRotate.js"></script>
        <img class="imagenderecha" onClick="afectarImagen(\'rotar\',\'' . $id . '\',90,\'' . $src . '\');abrirImagenGrande(document.getElementById(\'' . $id . '\'),\'1\',\'1\');giro1(\'' . $id . '\',\'der\',\'' . $id . '\');window.opener.location.reload();setTimeout(function(){window.opener.formulario(\'1\');},1000);" src="../../images/boton-girar-a-la-derecha.png"/>                                           
        <img class="imagenizquierda" onClick="afectarImagen(\'rotar\',\'' . $id . '\',-90,\'' . $src . '\');abrirImagenGrande(document.getElementById(\'' . $id . '\'),\'1\',\'1\');giro1(\'' . $id . '\',\'iz\',\'' . $id . '\');window.opener.location.reload();setTimeout(function(){window.opener.formulario(\'1\');},1000);" src="../../images/boton-girar-a-la-izquierda.png"/>
        </div>
        <img class="borrarimagen" src="../../images/cerrar.png" onClick="afectarImagen(\'eliminar\',\'' . $id . '\',\'' . $idprod . '\',\'' . $src . '\')"/>
    ';
}

?>