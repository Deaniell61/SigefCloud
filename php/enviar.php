<?php

require_once('fecha.php');



if(isset($_POST['email']) &&!empty ($_POST['email']))

{

	$nombre=$_POST['nombre'];

	$apel=$_POST['apel'];

	$pass=$_POST['pass'];

	$empresa=$_POST['emp'];

    $destino =$_POST['email'];

    $destino12 ="paulo.armas@coexport.net";

	$destino5 ="romalch@gmail.com";

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

										Hemos recibido su solicitud de proveedor para la empresa <strong>$empresa</strong><br>

											Se le ha creado un usuario:<br><br>

											

												Usuario: <strong>$destino</strong><br>

												Contraseña: <strong>$pass</strong><br>

									</div></center>	

										<br><br>

									<div style=\"text-align:rigth;

									color:#D67900;width:100%;margin-left:10%;\" >

										Esperamos su ingreso para cambiar su contraseña.<br><br>

									</div>

										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/".str_replace(" ","%20",$pais).".png\"  width='200' height='100' alt=\"Guate Direct\"></a>

										<br><br>http://www.sigefcloud.com/ </center>

								</body>	

								</html>");

	

    //mail($destino, $asunto, $mensaje, $desde);
	 enviaEmail($mensaje, $desde, $asunto, $destino);
	

    

    echo'Notificacion por correo electronico Enviada <script>setTimeout(function(){$("#cargaLoadVP").dialog("close");},500);setTimeout(function(){$("#usuarioprov").dialog("close");},500);</script>';

    

}else{

    

    echo"Problemas al enviar";

}


function enviaEmail($mensaje,$desde,$asunto,$destino)
{
	require_once("lib/PHPMailer-master/class.phpmailer.php"); 
	require_once("lib/PHPMailer-master/class.smtp.php"); 
    $destino12 ="paulo.armas@coexport.net";
	$destino5 ="romalch@gmail.com";
	//$destino5 ="jdrodriguezr61@gmail.com";
	$destino3 ="jdanielr61@gmail.com";
	$from="SigefCloud Team Support <support@sigefcloud.com>";
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	$headers .= "From: $from\r\n"; 
	$headers .= "Reply-To: $from\r\n"; 
	$headers .= "Return-path: $from\r\n"; 
	$headers .= "Bcc: $destino3, $destino5\r\n"."X-Mailer: PHP/".phpversion(); 

	$desde=$headers;
	$pais="Guatemala";
	
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = "ssl"; 
	//$mail->Host = "smtp.gmail.com"; 
	$mail->Host = "srv70.hosting24.com"; 
	$mail->Port = 465; 
	$mail->Username = "jdrodriguez@sigefcloud.com"; 
	$mail->Password = "Pistolas32761";
	//$mail->Username = "support@crdirect.com"; 
	//$mail->Password = "supCRDirect2016";
	//$mail->Password = "CRDirectSup2016";
	$mail->From = "support@sigefcloud.com"; 
	$mail->FromName = $from; 
	$mail->Subject = $asunto; 
	$mail->AltBody = $asunto; 
	$mail->addBCC = $destino3;
	$mail->addBCC = $destino5; 
	$mail->MsgHTML($mensaje); 
	/*$mail->AddAttachment("files/files.zip"); 
	$mail->AddAttachment("files/img03.jpg"); 
	*/$mail->AddAddress($destino, $destino); 
	$mail->IsHTML(true); 
	return $mail->Send();

}




?>





