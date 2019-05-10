<?php
require_once('fecha.php');

if(isset($_POST['email']) &&!empty ($_POST['email']))
{
	$nombre=$_POST['nombre'];
	$apel=$_POST['apel'];
	$pass=$_POST['pass'];
	$empresa=$_POST['emp'];
    $destino =$_POST['email'];
	$empleado =$_POST['empleado'];
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
	$pais=descubrePais($_POST['email']);
    $asunto = "Ingreso de Usuario";
    $mensaje = utf8_decode(
							"
							<html>
							<head>
							
							</head>
							<body>
								<span style=\"text-align:center;
									color:red;width:100%;margin-left:0%;\"><strong>Saludos $nombre $apel.</strong></span><br><br>
									<center>
									<div style=\"text-align:left;
									color:blue;width:70%;\">
										Hemos recibido su solicitud para crear un usuario proveedor para la empresa <strong>$empresa</strong><br>
											El usuario creado es el siguiente:<br><br>
											
												Usuario: <strong>$empleado</strong><br>
												Contraseña: <strong>$pass</strong><br>
											
									</div></center>	
										<br><br>
									<div style=\"text-align:rigth;
									color:#D67900;width:100%;margin-left:10%;\" >
										Recuerde que estos datos son temporales hasta que el usuario cambie su contraseña.<br><br>
									</div>
										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/".str_replace(" ","%20",$pais).".png\"  width='200' height='100' alt=\"Guate Direct\"></a>
										<br><br>http://www.sigefcloud.com/ </center>
								</body>	
								</html>");
	
    mail($destino, $asunto, $mensaje, $desde);
	
    
    echo'Notificacion por correo electronico Enviada ';
    
}else{
    
    echo"Problemas al enviar $destino  ";
}



?>


