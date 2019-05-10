<?php

require_once('../coneccion.php');

require_once('../fecha.php');

$idioma=idioma();

include('../idiomas/'.$idioma.'.php');

session_start();

$pass=$_POST['contra1'];

$pass1 = crypt_blowfish_bydinvaders($pass);



	$sql="update sigef_usuarios set clave='".$pass1."',clave1='".$pass."',eclave1=0,estado=1 where codusua='".$_SESSION['codigo']."'";

	

	if(mysqli_query(conexion(""),$sql))

	{

		$_SESSION['estado']=1;

							$nombre=$_SESSION['nom'];

							$apel=$_SESSION['apel'];

							$destino =$_SESSION['user'];

							$destino12 ="paulo.armas@coexport.net";

							$destino5 ="romalch@gmail.com";

							$destino2="eduardoguallito@gmail.com";

							$destino3="jdanielr61@gmail.com";

							$from="SigefCloud Team Support  <support@sigefcloud.com>";

							$headers = "MIME-Version: 1.0\r\n"; 

							$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

							$headers .= "From: $from\r\n"; 

							$headers .= "Reply-To: $from\r\n"; 

							$headers .= "Return-path: $from\r\n"; 

							$headers .= "Bcc: $destino3, $destino2\r\n"."X-Mailer: PHP/".phpversion(); 

							$desde=$headers;

							$asunto = utf8_decode("Contraseña Cambiada");

							

							$mensaje = utf8_decode(

							"

							<html>

							<head>

							

							</head>

							<body>

								<span style=\"text-align:center;

									color:red;width:100%;margin-left:0%;\"><strong>Saludos ".$_SESSION['nom']." ".$_SESSION['apel'].". </strong></span><br><br>

									<center>

									<div style=\"text-align:center;

									color:blue;width:50%;\">

										Su contraseña ha sido cambiada exitosamente

									</div></center>	

										<br><br>

									<div style=\"text-align:rigth;

									color:#D67900;width:100%;margin-left:10%;\" >

										Si no fue usted quien hizo este cambio porfavor contactar con el administrador.<br><br>

									</div>

										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/".str_replace(" ","%20",$_SESSION['pais']).".png\" width='200' height='100' alt=\"Guate Direct\"></a>

										<br><br>http://www.sigefcloud.com/ </center>

								</body>	

								</html>");

						   

						

							/*if(mail($destino, $asunto, $mensaje, $desde)){

								echo "<script>alert('".$lang[$idioma]['ContraCam']."');

			setTimeout(function(){\$(\"#contra\").dialog(\"close\");},1000);</script>";
							}
							else{
								echo "<script>alert('Hay Error con la pagina en este momento');</script>";
							}*/
							require_once('../mails/mailMailer.php');
							if(enviaEmail($mensaje, $desde, $asunto, $destino)){

								echo "<script>alert('".$lang[$idioma]['ContraCam']."');

			setTimeout(function(){\$(\"#contra\").dialog(\"close\");},1000);</script>";
							}
							else{
								echo "<script>alert('Hay Error con la pagina en este momento');</script>";
							}

			

	}

	else

	{

		echo $sql;

	}



?>