<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
/*Pagina principal de proveedores*/
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
session_start();
if (isset($_GET['pesta'])) {
    $_SESSION['pestaSelec'] = $_GET['pesta'];
    switch ($_SESSION['pestaSelec']) {
        case "2": {
            $_SESSION['pestaSelec2'] = "TabFacturacion";
            break;
        }
        case "3": {
            $_SESSION['pestaSelec2'] = "TabPagos";
            break;
        }
        case "4": {
            $_SESSION['pestaSelec2'] = "TabCobros";
            break;
        }
        case "6": {
            $_SESSION['pestaSelec2'] = "TabComer";
            break;
        }
    }
}
else {

}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $lang[$idioma]['EditarProveedores']; ?></title>
    <link href="../../images/GuateIco.ico" type="image/x-icon" rel="shortcut icon"/>
    <link href="../../css/estiloProveedor.css" rel="stylesheet" type="text/css">
    <link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
    <link href="../../css/grid.css" rel="stylesheet" type="text/css">
    <link href="../menu/css/encabezado.css" rel="stylesheet" type="text/css">
    <link href="../../Inicio/css/productos.css" rel="stylesheet" type="text/css">
    <link href="../../css/verificar.css" rel="stylesheet" type="text/css">
    <link href="../../css/botones.css" rel="stylesheet" type="text/css">
    <link href="../../css/textos.css" rel="stylesheet" type="text/css">
    <link href="../../css/tabla.css" rel="stylesheet" type="text/css">
    <link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css"/>

    <script type="text/javascript" src="../../js/jquery-2.2.3.min.js"></script>
    <script src="../../js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
    <script src="../../js/funcionesScript.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptProveedores.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
    
    <script src="../../js/upload.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
    

    <script language="JavaScript" type="text/JavaScript">
        Full();
    </script>
    
</head>

<body onLoad="javascript:envioDeDataProveedor('Proveedor');inna();">
<div class="pagina">
    <div id="cuerpo">
        <header>
            <?php ayuda("../../images/header.png", "", "../../images/sigef_logo.png"); ?>
            <ul id="elementoLogin">
                <?php if (isset($_SESSION['nom']) and isset($_SESSION['apel'])) {
                    ?>
                    <strong><?php echo ucwords(strtolower($_SESSION['nom'])) . " " . ucwords(strtolower($_SESSION['apel'])) . "<br>" . ucwords(strtolower($_SESSION['nomEmpresa'])) . "<br>" . ucwords(strtolower($_SESSION['nomProv'])); ?></strong><?php } ?>
                <a onClick="window.close();">
                    <li>
                        <?php echo $lang[$idioma]['Salir']; ?>
                    </li>
                </a>
            </ul>
        </header>
        <div id="formularioP">
        </div>
    </div>
    <footer>
        <?php footer(); ?>
    </footer>
</div>
<div id="mensajeProv"></div>
<div id="cargaLoad"></div>
</body>
</html>
