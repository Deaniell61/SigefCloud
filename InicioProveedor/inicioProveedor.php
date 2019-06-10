<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../php/fecha.php');
require_once('../php/sesiones.php');
require_once('funcionesEmpresa.php');
$idioma = idioma();
include('../php/idiomas/' . $idioma . '.php');
verificar_proveedor();
verTiempo();
?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <link href="../images/<?php echo limpiar_caracteres_especiales($_SESSION['pais']); ?>.ico" type="image/x-icon"
              rel="shortcut icon"/>
        <title><?php echo "" . $lang[$idioma]['Inicio'] . " " . $_SESSION['nomEmpresa'] . " | " . $_SESSION['pais']; ?></title>
        <link href="../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
        <link href="../css/estiloForms.css" rel="stylesheet" type="text/css">
        <link href="../css/grid.css" rel="stylesheet" type="text/css">
        <link href="../php/menu/css/encabezado.css" rel="stylesheet" type="text/css">
        <link href="../css/botones.css" rel="stylesheet" type="text/css">
        <link href="../css/verificar.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="../js/funcionesScript.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
        <script src="../js/Jqueryvalidation.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptPermisos.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptModulos.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../css/jquery-ui.min.css" type="text/css"/>
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="../js/jquery-ui.min.js" type="text/javascript"></script>
    </head>
    <body onLoad="inna();">
    <div class="pagina">
        <div id="encabezado">
            <?php ayuda("../images/header.png", "window.location.href='inicioProveedor.php'", "../images/sigef_logo.png"); ?>
            <ul id="elementoLogin">
                <strong class="callProfile"><?php echo ucwords(strtolower($_SESSION['nom'])) . " " . ucwords(strtolower($_SESSION['apel'])) . "<br>" . ucwords(strtolower($_SESSION['nomEmpresa'])); ?></strong>
                <a href="../php/logout.php">
                    <li>
                        <?php echo $lang[$idioma]['Cerrar_Sesion']; ?>
                    </li>
                </a>
            </ul>
            <nav>
            </nav>
        </div>
        <div id="cuerpo">
            <div id="resultado"></div>
            <div id="formulario">
            <div style="position: absolute;"><input type="button" class='cmd button button-highlight button-pill'
                                         value="<?php echo $lang[$idioma]['Salir']; ?>"
                                         onClick="window.location.href='inicio.php'"/></div>
                <div id="datos">
                    <?php
                    getProveedor($_SESSION['codigo']);
                    ?>
                </div>
                <center>
                   
                </center>
            </div>
        </div>
        <footer style="margin-left:0px;">
            <?php footer(); ?>
        </footer>
    </div>
    </body>
    </html>
<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/profile.php");
?>