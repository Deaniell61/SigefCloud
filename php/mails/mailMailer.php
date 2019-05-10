<?php
function enviaEmail($mensaje,$desde,$asunto,$destino)
{
	require_once("../lib/PHPMailer-master/class.phpmailer.php"); 
	require_once("../lib/PHPMailer-master/class.smtp.php"); 
    $destino12 ="paulo.armas@coexport.net";
	$destino5 ="romalch@gmail.com";
	//$destino5 ="jdrodriguezr61@gmail.com";
	$destino3 ="jdanielr61@gmail.com";
	$from="SigefCloud Team Support";
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
	
	$mail->MsgHTML($mensaje); 
	/*$mail->AddAttachment("files/files.zip"); 
	$mail->AddAttachment("files/img03.jpg"); 
	*/
	$direcciones[0]=$destino;
	$direcciones[1]=$destino3;
	$direcciones[2]=$destino5;
	$mail->IsHTML(true);
	$is=false;
	foreach($direcciones as $destino1){
		$mail->AddAddress($destino1, $destino1);  
		$is= $mail->Send();
		$mail->ClearAddresses();
	}

	return $is;
}
function enviaEmailNotificacion($destino,$asunto,$mensaje,$desde)
{
		
	require_once("../lib/PHPMailer-master/class.phpmailer.php"); 
	require_once("../lib/PHPMailer-master/class.smtp.php"); 
    $destino12 ="paulo.armas@coexport.net";
	$destino5 ="romalch@gmail.com";
	$destino120 ="paulo.armas@guatedirect.com";
	$destino50 ="mauricio.aldana@sigefcloud.com";
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
	$mail->MsgHTML($mensaje); 
	/*$mail->AddAttachment("files/files.zip"); 
	$mail->AddAttachment("files/img03.jpg"); 
	*/
	$mail->IsHTML(true); 
	$direcciones[0]=$destino;
	$direcciones[1]=$destino3;
	$direcciones[2]=$destino5;
	$direcciones[3]=$destino12;
	$direcciones[4]=$destino50; 
	$direcciones[5]=$destino120; 

	
	$mail->IsHTML(true);
	$is=false;
	foreach($direcciones as $destino1){
		$mail->AddAddress($destino1, $destino1);  
		$is= $mail->Send();
		$mail->ClearAddresses();
	}

	return $is;

}
?>