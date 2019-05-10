<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
/*Aqui se cargan todos los formularios extras*/
require_once('../fecha.php');
require_once('BusquedaExtra.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
session_start();
verTiempo4();
$_SESSION['codExtra'] = '0';
if (isset($_GET['act'])) {
    $codigo = $_GET['act'];
    $_SESSION['codExtra'] = $codigo;
    buscarExtra($codigo, $_GET['formul']);
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo 'General';  //$lang[ $idioma ]['Ingresar']?></title>
    <link href="../../images/<?php echo limpiar_caracteres_especiales($_SESSION['pais']); ?>.ico" type="image/x-icon"
          rel="shortcut icon"/>
    <link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
    <link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
    <link href="../../css/grid.css" rel="stylesheet" type="text/css">
    <link href="../menu/css/encabezado.css" rel="stylesheet" type="text/css">
    <link href="../../Inicio/css/productos.css" rel="stylesheet" type="text/css">
    <link href="../../css/verificar.css" rel="stylesheet" type="text/css">
    <link href="../../css/botones.css" rel="stylesheet" type="text/css">
    <link href="../../css/textos.css" rel="stylesheet" type="text/css">
    <link href="../../css/tabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css"/>
    <script type="text/javascript" src="../../js/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="../../js/jquery-2.0.2.js"></script>
    <script type="text/javascript" src="../../js/jquery-2.2.3.min.js"></script>
    <script src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
    <script src="../../js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../../js/funcionesScript.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptExtras.js" type="text/javascript"></script>
    <script src="../../js/funcionesScriptUsuarioLogiado.js" type="text/javascript"></script>
    <script src="../../js/datatables.min.js" type="text/javascript"></script>
    <script language='javascript'>
        window.onbeforeunload = exitcheck;
    </script>
</head>
<body onLoad="javascript:envioDeDataExtras();inna();">
<div class="pagina">
    <div id="cuerpo">
        <header>
            <?php ayuda("../../images/header.png", "", "../../images/sigef_logo.png"); ?>
            <ul id="elementoLogin">
                <strong><?php echo ucwords(strtolower($_SESSION['nom'])) . " " . ucwords(strtolower($_SESSION['apel'])) . "<br>" . ucwords(strtolower($_SESSION['nomEmpresa'])) . "<br>" . ucwords(strtolower($_SESSION['nomProv'])); ?></strong>
                <a onClick="window.close();">
                    <li>
                        <?php echo $lang[$idioma]['Salir']; ?>
                    </li>
                </a>
            </ul>
        </header>
        <center>
            <div id="formulario">
            </div>
        </center>
    </div>
    <footer>
        <?php footer(); ?>
    </footer>
</div>
</body>
</html>
<?php
?>
