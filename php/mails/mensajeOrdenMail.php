<?php

function enviaEmailOrden($mensaje,$codigo,$asunto)
{
    $destino ="support@sigefcloud.com";
    $destino12 ="paulo.armas@coexport.net";
	$destino5 ="romalch@gmail.com";
	$destino3="jdanielr61@gmail.com";
	$from="SigefCloud Team Support <support@sigefcloud.com>";
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	$headers .= "From: $from\r\n"; 
	$headers .= "Reply-To: $from\r\n"; 
	$headers .= "Return-path: $from\r\n"; 
	$headers .= "Bcc: $destino3, $destino5\r\n"."X-Mailer: PHP/".phpversion(); 

	$desde=$headers;
	$pais="Guatemala";

    mail($destino, $asunto, $mensaje, $desde);

}

function enviaEmailOrdenAProveedor($mensaje,$codigo,$asunto,$destino)
{
    $destino12 ="paulo.armas@coexport.net";
	//$destino5 ="romalch@gmail.com";
	$destino5 ="jdrodriguezr61@gmail.com";
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
	//return mail($destino, $asunto, $mensaje);
	if (!mail($destino, $asunto, $mensaje,$desde)) {
        throw new Exception('Mensaje no enviado.');
    }
    return true; 

}

function enviaEmailOrdenAProveedor2($mensaje,$codigo,$asunto,$destino)
{
	require_once("../php/lib/PHPMailer-master/class.phpmailer.php"); 
	require_once("../php/lib/PHPMailer-master/class.smtp.php"); 
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
	$mail->Username = "support@sigefcloud.com"; 
	$mail->Password = "5upp0rt51g3fCl0ud";
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