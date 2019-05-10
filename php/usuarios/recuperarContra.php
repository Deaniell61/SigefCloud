<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$email = $_POST['email'];
$clave = sys2015();
$clave = substr($clave, 1, strlen($clave));
$pass = crypt_blowfish_bydinvaders($clave);
$sql = "select nombre,apellido,email from sigef_usuarios where email='" . $email . "' and (posicion='P' or posicion='U')";
if ($ejecutar = mysqli_query(conexion(""), $sql)) {
    if ($ejecutar->num_rows > 0) {
        if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $sql = "update sigef_usuarios set clave='" . $pass . "',clave1='" . $clave . "',eclave1=0,estado=21 where email='" . $email . "'";
            if ($ejecutar = mysqli_query(conexion(""), $sql)) {
                $nombre = $row['nombre'];
                $apel = $row['apellido'];
                $destino = $row['email'];
                $destino12 = "paulo.armas@coexport.net";
                $destino5 = "romalch@gmail.com";
//							$destino2="eduardoguallito@gmail.com";
//							$destino3="jdanielr61@gmail.com";
                $from = "SigefCloud Team Support  <support@sigefcloud.com>";
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: $from\r\n";
                $headers .= "Reply-To: $from\r\n";
                $headers .= "Return-path: $from\r\n";
                $headers .= "Bcc: $destino2\r\n" . "X-Mailer: PHP/" . phpversion();
                $desde = $headers;
                $asunto = utf8_decode("Cambio de Contraseña");
                $pais = descubrePais($row['email']);
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
									color:blue;width:50%;\">
										Hemos recibido su solicitud de cambio de contraseña,<br>
										a continuacion se le daran sus nuevos datos de ingreso.<br><br>
											Usuario: <strong>$destino</strong><br>
											Contraseña:<strong> $clave </strong><br>
									</div></center>	
										<br><br>
									<div style=\"text-align:rigth;
									color:#D67900;width:100%;margin-left:10%;\" >
										Si no fue usted quien hizo esta solicitud le recomendamos usar estos datos <br>
										para acceder y cambiar su contraseña.<br><br>
									</div>
										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/" . str_replace(" ", "%20", $pais) . ".png\"  width='200' height='100'  alt=\"Guate Direct\"></a>
										<br><br>http://www.sigefcloud.com/ </center>
								</body>	
								</html>");
                $mailPath = $_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/PHPMailerAutoload.php";
                include_once($mailPath);
                $recipient = $destino;
                $subject = $asunto;
                $message = $mensaje;
                $cc = "mauricio.aldana@guatedirect.com";
                $mail = new PHPMailer(true);
                try {
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = "ssl";
                    $mail->Host = "srv70.hosting24.com";
                    $mail->Port = 465;
                    $mail->Username = "support@sigefcloud.com";
                    $mail->Password = "5upp0rt51g3fCl0ud";
                    $mail->setFrom("sigefcloud@sigefcloud.com", "SigefCloud");
                    $mail->addAddress($recipient, $recipient);
                    $mail->addCC("$cc", "$cc");
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    $mail->isHTML(true);
                    $sent = $mail->send();
                } catch (phpmailerException $e) {
//                              echo $e->errorMessage();
                    echo "<script>alert('No se ha podido enviar el correo " . $e->errorMessage() . " ');setTimeout(function(){window.close();},1000);</script>";
                }
                if ($sent) {
                    echo "<script>alert('Se ha enviado un correo con sus nuevos datos');setTimeout(function(){window.close();},1000);</script>";
                }
                /*
                require_once('../mails/mailMailer.php');
                //mail($destino, $asunto, $mensaje, $desde);
                if(enviaEmail($mensaje, $desde, $asunto, $destino)){
                    echo "<script>alert('Se ha enviado un correo con sus nuevos datos');setTimeout(function(){window.close();},1000);</script>";
                }else{
                    echo "<script>alert('No se ha podido enviar el correo - $desde, $asunto, $destino');setTimeout(function(){window.close();},1000);</script>";
                }
                */
                //mail($destino3, $asunto, $mensaje, $desde);
                //mail($destino5, $asunto, $mensaje, $desde);
                //mail($destino12, $asunto, $mensaje, $desde);
            }
        }
    } else {
        echo "Ese correo no esta Registrado con nosotros como Proveedor<script>setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},500);</script>";
    }
}
?>