<?php 
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lang[ $idioma ]['AsignarModulos']; ?></title>
<link href="../../images/GuateIco.ico" type="image/x-icon" rel="shortcut icon" />
<link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
<link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
<link href="../../css/modulos.css" rel="stylesheet" type="text/css">
<link href="../menu/css/encabezado.css" rel="stylesheet" type="text/css">
<link href="../../css/verificar.css" rel="stylesheet" type="text/css">
<link href="../../css/botones.css" rel="stylesheet" type="text/css">

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
<script type="text/javascript" src="../../js/jquery-1.3.2.js"></script>
<script  src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script  src="../../js/funcionesScript.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptPermisos.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
Full();
</script>


</head>

<body onLoad="javascript:envioDeDataPermiso('user');inna();">
<div class="pagina">
	<div id="cuerpo">
    <header>
    		<?php ayuda("../../images/header.png","","../../images/sigef_logo.png");?>
            <ul id="elementoLogin">
            	<strong><?php echo ucwords(strtolower($_SESSION['nom']))." ".ucwords(strtolower($_SESSION['apel']))."<br>".ucwords(strtolower($_SESSION['nomEmpresa']))."<br>".ucwords(strtolower($_SESSION['nomProv']));?></strong>
            	<a onClick="window.close();">
                <li>
                <?php echo $lang[ $idioma ]['Salir']; ?>
                </li>
                </a>
             </ul>
    	</header>
    	 <div id="formulario">

         



		</div>
	</div>
</div>

</body>
</html>


