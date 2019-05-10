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
require_once('../php/menu/menu.php');
require_once('funcionesEmpresa.php');
$idioma = idioma();
include('../php/idiomas/' . $idioma . '.php');
verificar_proveedor();
verTiempo();
$_SESSION['notified'] = nitificaciones($_SESSION['codprov']);
if ($_SESSION['notified'] != 0) {
    $_SESSION['notified2'] = "(" . ($_SESSION['notified']) . ") ";
} else {
    $_SESSION['notified2'] = "";
}
?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <link href="../images/<?php echo limpiar_caracteres_especiales($_SESSION['pais']); ?>.ico" type="image/x-icon" rel="shortcut icon"/>
        <title><?php echo $lang[$idioma]['Inicio'] . " " . $_SESSION['nomProv'] . " | " . $_SESSION['pais']; ?></title>

        <link href="../css/normalize.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/jquery-ui.min.css" type="text/css"/>
        <link href="../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
        <link href="../css/estiloForms.css" rel="stylesheet" type="text/css">
        <link href="../css/grid.css" rel="stylesheet" type="text/css">
        <link href="../php/menu/css/encabezado.css" rel="stylesheet" type="text/css">
        <link href="../css/verificar.css" rel="stylesheet" type="text/css">
        <link href="../css/main.css" rel="stylesheet" type="text/css">
        <link href="../css/botones.css" rel="stylesheet" type="text/css">
        <link href="../css/tabla.css" rel="stylesheet" type="text/css">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/datatables.min.css" rel="stylesheet" type="text/css">
        <link href="../css/textos.css" rel="stylesheet" type="text/css">
        <link href="../php/bancos/css/estilo.css" rel="stylesheet" type="text/css">


        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="../js/colResizable-1.5.min.js"></script>
        <script src="../js/jquery.tablesorter.js"></script>
        <script src="../js/Jqueryvalidation.js" type="text/javascript"></script>
        <script src="../js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../js/funcionesScript.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptPermisos.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptPrecios.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptModulos.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptProductos.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptProveedores.js" type="text/javascript"></script>
        <script src="../js/funcionesScriptSoporte.js" type="text/javascript"></script>

        <script src="../js/funcionesScriptUsuarioLogiado.js" type="text/javascript"></script>
        <script src="../js/datatables.min.js" type="text/javascript"></script>
        <script src="../php/bancos/js/funcionesScriptBancos.js" type="text/javascript"></script>

        <script src="../js/notifIt/js/notifIt.js" type="text/javascript"></script>
        <link href="../js/notifIt/css/notifIt.css" type="text/css" rel="stylesheet">

        <script>

            $(document).ready(function (e) {
                if (document.documentMode || /Edge/.test(navigator.userAgent)) {
                    $('#resultado').html("<?php echo $lang[$idioma]['edge']; ?>");
                }
                $('#ui_notifIt').click(
                    function () {
                        __('globoNotificacion').hidden = false;
                    }
                );
            });

        </script>

    </head>

    <body onLoad="inna();">
    <div class="pagina">
        <div id="encabezado">
            <?php ayuda("../images/header.png", "window.location.href='inicioEmpresa.php'", "../images/sigef_logo.png"); ?>
            <ul id="elementoLogin">
            
                <strong><?php echo ucwords(strtolower($_SESSION['nom'])) . " " . ucwords(strtolower($_SESSION['apel'])) . "<br>" . ucwords(strtolower($_SESSION['nomEmpresa'])) . "<br>" . ucwords(strtolower($_SESSION['nomProv'])); ?></strong>
                <a href="../php/logout.php">
                    <li>
                        <?php echo $lang[$idioma]['Cerrar_Sesion']; ?>
                    </li>
                </a>
                
             </ul>
      
        <nav  onClick="__('globoNotificacion').hidden=true;">
        	
        	<?php //menu("user"); ?>
            
        </nav>
    </div>
        </div>


        <div id="formulario" >
<script>
        selecFormulario('8');
    </script>
            <img src="<?php echo $_SESSION['img']; ?>" width="70%" height="65%"/>
            <center>
                <div><input type="button" class='cmd button button-highlight button-pill'
                            value="<?php echo $lang[$idioma]['Salir']; ?>" onClick="window.location.href='inicio.php'"/>
                </div>
            </center>

        </div>


    </div>

    <footer style="margin-left:0px;">
        <?php footer(); ?>
    </footer>

    </div>
    <div id="contra"></div>
    <div id="usuarioprov"></div>

    </body>
    </html>
<?php
if ($_SESSION['estado'] == "21") {
    echo "<script>
				ventana('contra',400,700);
				cambioContraLlenar();
			</script>";
}



?>