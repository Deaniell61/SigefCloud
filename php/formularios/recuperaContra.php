<?php 
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
require_once('../idiomas/'.$idioma.'.php');
 ?>
<!doctype html>
<html>
<head>
<link href="../../images/GuateIco.ico" type="image/x-icon" rel="shortcut icon" />
<meta charset="utf-8">
<title>SIGEF</title>
<link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
<link href="../../css/verificar.css" rel="stylesheet" type="text/css">
<link href="../../php/menu/css/encabezado.css" rel="stylesheet" type="text/css">
<link href="../../css/botones.css" rel="stylesheet" type="text/css">
<link href="../../css/textos.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css" />

<script type="text/javascript" src="../../js/jquery-2.2.3.min.js"></script>
<script  src="../../js/jquery-ui.min.js" type="text/javascript"></script>
<script  src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/funcionesScript.js"></script>
<script type="text/javascript" src="../../js/funcionesScriptProveedores.js"></script>

<script>
function validateEnter(e) 
{
	var key=e.keyCode || e.which;
	if (key==13)
	{ 
		if(document.getElementById('contra').value!="")
		{
			Validar(document.getElementById('user').value,document.getElementById('contra').value); 
		}
		else
		{
			document.getElementById('contra').focus();
		}
	}
	
}
$(document).ready(function(e) {
    if (document.documentMode || /Edge/.test(navigator.userAgent))
 {
	 $('#resultado').html("<?php echo $lang[ $idioma ]['edge']; ?>");
 }
});
 
</script>
</head>

<body onLoad="inna();">
<div class="pagina">
	<div id="encabezado">
    	<?php ayuda("../../images/header.png","window.location.href='index.php'","../../images/sigef_logo.png");?> 
    </div>

    <center>
   <div id="cuerpo">
    	<br><br>
     <div class="log">   
    	<form id="login" method="POST" action="return false" onSubmit="return false" >
    	<center>
        <table>
                <tr><div id="resultado"></div></tr>
            <tr>
            <td>
            	<strong><?php echo $lang[ $idioma ]['Email']; ?></strong>
            </td>
            </tr>
        	<tr>
                <td><input type="text" class='entradaTexto' name="user" id="user" autofocus placeholder="<?php echo $lang[ $idioma ]['Email']; ?>" onKeyPress="comprobarEmailProv('user');document.getElementById('resultado').innerHTML='';"></td>
            </tr>
            
            
            <tr>
         
            
            <td><br>	<input type="button" class='btn button button-highlight button-pill' onClick="comprobarEmailProv('user');cambiarContraUser();" value="<?php echo $lang[ $idioma ]['Entrar']; ?>"/>
            </td>
             </tr>
             
        </table>
        </center>
        </form>
        
      </div><!--Cierra el login-->
      <br>
    </div><!--Cierra el cuerpo del programa-->
    </center>
    <footer style="margin-left:0px;">
    <?php footer(); ?>
    </footer>
</div>
<div id="cargaLoad"></div>
</body>
</html>