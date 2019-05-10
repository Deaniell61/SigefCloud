<?php
require_once('../fecha.php');

if(isset($_POST['email']) &&!empty ($_POST['email']))
{
	$nombre=$_POST['nombre'];
	$apel=$_POST['apellido'];
    $destino =$_POST['email'];
	$ticket =$_POST['ticket'];
	$descript =$_POST['descripcion'];
    $destino12 ="paulo.armas@coexport.net";
	$destino5 ="romalch@gmail.com";
	$destino3="jdanielr61@gmail.com";
	$from="SigefCloud Team Support  <support@sigefcloud.com>";
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	$headers .= "From: $from\r\n"; 
	$headers .= "Reply-To: $from\r\n"; 
	$headers .= "Return-path: $from\r\n"; 
	$headers .= "Bcc: $destino3,$destino5,$destino12\r\n"."X-Mailer: PHP/".phpversion(); 
	$desde=$headers;
	$pais=descubrePais($_POST['email']);
    $asunto = "Soporte SigefCloud";
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
										Su mensaje: <br><br>
										\"<strong>$descript</strong>\"<br><br><br> Ha sido recibido, agradecemos sus comentarios<br>
											atenderemos su solicitud lo mas pronto posible<br><br>
											Su numero de solicitud es : $ticket
										
									</div></center>	
										<br><br>
									
										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/".str_replace(" ","%20",$pais).".png\"  width='200' height='100' alt=\"Guate Direct\"></a>
										<br><br>http://www.sigefcloud.com/ </center>
								</body>	
								</html>");
	$mensaje2 = utf8_decode(
							"
							<html>
							<head>
							
							</head>
							<body>
								<span style=\"text-align:center;
									color:red;width:100%;margin-left:0%;\"></span><br><br>
									<center>
									<div style=\"text-align:left;
									color:blue;width:70%;\">
									<strong>El usuario $nombre $apel.</strong>
										Ha ingresado un ticket de soporte nuevo:<br><br>
										\"<strong>$descript</strong>\"<br><br>
											Favor atenderlo lo mas rapido posible<br><br>
											el numero de ticket es $ticket
										
									</div></center>	
										<br><br>
									
										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/".str_replace(" ","%20",$pais).".png\"  width='200' height='100' alt=\"Guate Direct\"></a>
										<br><br>http://www.sigefcloud.com/ </center>
								</body>	
								</html>");
	
    mail($destino, $asunto, $mensaje, $desde);
	mail($destino5, $asunto, $mensaje2, $desde);
	
    
    echo' <script>setTimeout(function(){$("#cargaLoad").dialog("close");},500);window.close();</script>';
    
}else{
    
    echo"Problemas al enviar";
}



?>


