<?php 

require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
$_SESSION['codprod']=$_SESSION['codprod'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lang[ $idioma ]['Terminos']; ?></title>
<link href="../../images/GuateIco.ico" type="image/x-icon" rel="shortcut icon" />
<link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
<link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
<link href="../../css/grid.css" rel="stylesheet" type="text/css">
<link href="../menu/css/encabezado.css" rel="stylesheet" type="text/css">
<link href="../../Inicio/css/productos.css" rel="stylesheet" type="text/css">
<link href="../../css/verificar.css" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
<script type="text/javascript" src="../../js/jquery-1.3.2.js"></script>
<script  src="../../js/funcionesScript.js" type="text/javascript"></script>
<script  src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptProductos.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptUsuarioLogiado.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
window.resizeTo(screen.availWidth,screen.availHeight);
</script>

</head>

<body onLoad="javascript:inna();">

<div class="pagina">
	<div id="cuerpo">
    <header>
    		<img src="../../images/header.png" width="100%" height="100%"/>
    	</header>
                 <center><?php echo $lang[ $idioma ]['Terminos']; ?></center>
   	 <div id="formulario">
   	        
		</div>
	</div>
      <footer>
    <?php footer(); ?>
    </footer>	
</div>

</body>
</html>
