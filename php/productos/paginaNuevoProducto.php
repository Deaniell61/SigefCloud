<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
/*Pagina de productos aqui se cargan todos los formularios productos en sus pestañas*/
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
verTiempo2();
session_start();
$_SESSION['mastersku'] = $_GET['mt'];
//echo $_SESSION['CodSKUPais']." hola"
?>

    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache">

        <title><?php echo $lang[$idioma]['NuevoProducto']; ?></title>
        <link href="../../images/<?php echo limpiar_caracteres_especiales($_SESSION['pais']); ?>.ico"
              type="image/x-icon" rel="shortcut icon"/>
        <link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
        <link href="../../css/estiloLupa.css" rel="stylesheet" type="text/css">
        <link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
        <link href="../../css/grid.css" rel="stylesheet" type="text/css">
        <link href="../menu/css/encabezado.css" rel="stylesheet" type="text/css">
        <link href="../../Inicio/css/productos.css" rel="stylesheet" type="text/css">
        <link href="../../css/verificar.css" rel="stylesheet" type="text/css">
        <link href="../../css/botones.css" rel="stylesheet" type="text/css">
        <link href="../../css/textos.css" rel="stylesheet" type="text/css">
        <link href="../../css/tabla.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css"/>


        <script type="text/javascript" src="../../js/jquery-2.2.3.min.js"></script>
        <script src="../../js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../../js/colResizable-1.5.min.js"></script>
        <script src="../../js/jqueryRotate.js"></script>
        <script src="../../js/jquery.tablesorter.js"></script>
        <script src="../../js/Lupa.js" type="text/javascript"></script>
        <script src="../../js/jquery-barcode.js" type="text/javascript"></script>
        <script src="../../js/funcionesScript.js" type="text/javascript"></script>
        <script src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
        <script src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
        <script src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
        <script src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
        <script src="../../js/funcionesScriptTerminos.js" type="text/javascript"></script>
        <script>$.ajaxSetup({cache: false});</script>
        <script src="../../js/funcionesScriptUsuarioLogiado.js" type="text/javascript"></script>
        <script src="../../js/datatables.min.js" type="text/javascript"></script>
        <script src="../../js/estibar.js" type="text/javascript"></script>
        <script src="../../js/lib/ckeditor/ckeditor.js" type="text/javascript"></script>

        <script src="../../js/funcionesScriptProductos.js" type="text/javascript"></script>
        <script language="JavaScript" type="text/JavaScript">
            Full();
        </script>

    </head>

    <body onLoad="javascript:envioDeDataProductos('productos');inna();">

    <div class="pagina">
        <div id="cuerpo">
            <header>
                <?php ayuda("../../images/header.png", "", "../../images/sigef_logo.png"); ?>
                <ul id="elementoLogin">
                    <strong><?php echo ucwords(strtolower($_SESSION['nom'])) . " " . ucwords(strtolower($_SESSION['apel'])) . "<br>" . ucwords(strtolower($_SESSION['nomEmpresa'])) . "<br>" . ucwords(strtolower($_SESSION['nomProv'])); ?></strong>
                    
                </ul>
            </header>
            <div class="text-left">
                <input type="button" class='cmd button button-highlight button-pill'
                            value="<?php echo $lang[$idioma]['Salir']; ?>" onClick="window.close();"/>
</div>
            <center>
                
                <aside class="pestanas">
                    <br>
                    <ul>
                        <li onClick="ventana('cargaLoad',300,400);producto(1,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['mastersku']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="Tabgeneral"><?php echo $lang[$idioma]['General']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(14,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['mastersku']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="Tabingredientes">Ingredientes
                        </li>
                        <?php
                        if ($_SESSION["pais"] == "Guatemala") {
                            ?>
                            <li onClick="ventana('cargaLoad',300,400);producto(15,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['mastersku']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                                id="Tabinventario">Inventario
                            </li>
                            <?
                        }
                        ?>
                        <li onClick="ventana('cargaLoad',300,400);producto(2,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabmetaData"><?php echo $lang[$idioma]['MetaData']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(9,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabEstibar"><?php echo $lang[$idioma]['Estibar']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(3,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabpesoDimencion"><?php echo $lang[$idioma]['PesoDimencion']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(8,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabExportacion"><?php echo $lang[$idioma]['Exportacion']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(5,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="Tabimagen"><?php echo $lang[$idioma]['Imagenes']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(7,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabSellers"><?php echo $lang[$idioma]['Competencia']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(11,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabSellersOff"><?php echo $lang[$idioma]['CompetenciaOF']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(4,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabprecioCosto"><?php echo $lang[$idioma]['PrecioCosto']; ?></li>
                        <li onClick="ventana('cargaLoad',300,400);producto(12,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabDistribucion"><?php echo $lang[$idioma]['Distribucion']; ?></li>
                        <!--wholesale images-->
                        <li onClick="ventana('cargaLoad',300,400);producto(13,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>','<?php echo $_SESSION['codprov']; ?>');"
                            id="TabImagenesWholesale"><?php echo $lang[$idioma]['ImagenesWholesale']; ?></li>
                        <!--     <li onClick="ventana('cargaLoad',300,400);producto(10,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>');" id="TabComercializa"><?php echo $lang[$idioma]['Comercializa']; ?></li> -->
                    </ul>
                </aside>
            </center>
            <center>
                <div id="formulario" onMouseOver="document.getElementById('Busqueda').innerHTML='';">
                </div>
            </center>
        </div>
        <div id="cargaLoad"></div>
        <div id="Busqueda"></div>
        <footer>
            <?php footer(); ?>
        </footer>
    </div>
    </body>
    </html>
<?php
if (isset($_SESSION['imagenSubida'])) {
    if ($_SESSION['imagenSubida'] == 1) {
        echo "<script> setTimeout(function(){producto(5,'" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $_SESSION['codprod'] . "');},2000);</script>";
    }
}
if (isset($_SESSION['guardadoprod'])) {
    if ($_SESSION['guardadoprod'] == 1) {
        $_SESSION['guardadoprod'] = 0;
        echo "<script> ventana('cargaLoad',300,400);setTimeout(function(){producto(2,'" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $_SESSION['codprod'] . "');},1000);</script>";
    }
}

if (isset($_SESSION['refreshBundles'])) {
    if ($_SESSION['refreshBundles'] == 1) {
        ?>
        <script>
            setTimeout(function () {
                producto(4, '<?php echo $_SESSION['codEmpresa']; ?>', '<?php echo $_SESSION['pais']; ?>', '<?php echo $_SESSION['codprod']; ?>', '<?php echo $_SESSION['codprov']; ?>');
            }, 750);
        </script><?php
    }
}
?>