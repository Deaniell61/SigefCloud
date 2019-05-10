<?php

/**

 * Created by Eduardo de Jesus

 * 

 * Unique creator

 */

 //echo "hola";

require_once('php/coneccion.php');

require_once('php/fecha.php');
//echo strtoupper(sys2015());
$idioma=idioma();

require_once('php/idiomas/'.$idioma.'.php');

   session_start();

	//comprobar la existencia del usuario

	if(isset($_SESSION['nom']))

	{

		switch($_SESSION['rol'])

		{

			case "U":

			{

				header('Location:Inicio/inicio.php');

				break;

			}

			case "A":

			{

				header('Location:Admin/inicio.php');

				break;

			}

			case "P":

			{

				header('Location:InicioProveedor/inicio.php');

				break;

			}

			default:

			{

				return false;

				break;

			}

			

		}

	}

	









 ?>

<!doctype html>

<html>

<head>

<link href="images/GuateIco.ico" type="image/x-icon" rel="shortcut icon" />

<meta charset="utf-8">

<title>SIGEF</title>

<link href="css/estiloPrincipal.css" rel="stylesheet" type="text/css">

<link href="css/verificar.css" rel="stylesheet" type="text/css">

<link href="php/menu/css/encabezado.css" rel="stylesheet" type="text/css">

<link href="css/botones.css" rel="stylesheet" type="text/css">

<link href="css/textos.css" rel="stylesheet" type="text/css">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 

<script type="text/javascript" src="js/jquery-1.3.2.js"></script>

<script  src="js/Jqueryvalidation.js" type="text/javascript"></script>

<script type="text/javascript" src="js/funcionesScript.js"></script>

<script type="text/javascript" src="js/funcionesScriptProveedores.js"></script>



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

    	<?php ayuda("images/header.png","window.location.href='index.php'","images/sigef_logo.png");?> 

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

                <td><input type="text" class='entradaTexto' name="user" id="user" autofocus placeholder="<?php echo $lang[ $idioma ]['Email']; ?>" onKeyPress="validateEnter(event);"><div id="comprobar" ></div></td>

            </tr>

            

            <tr>

                <td><input type="password" class='entradaTexto' id="contra" name="contra" placeholder="********" onKeyPress="validateEnter(event);"></td>

            </tr>

            <tr>

         

            

            <td><br>	<input type="button" class='`' onClick="Validar(document.getElementById('user').value,document.getElementById('contra').value);" value="<?php echo $lang[ $idioma ]['Entrar']; ?>"/>

            </td>

             </tr>

             <tr><td><br><span><a href="php/formularios/recuperaContra.php" target="_blank">Olvide mi contraseña</a> / <a href="php/proveedores/paginaProveedores.php?codigo=nuevo" target="_blank">Registrarme</a></span></td></tr>

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

</body>

</html>