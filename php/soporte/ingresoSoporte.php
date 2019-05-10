<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$tipo=$_POST['tipo'];
$pais=$_SESSION['pais'];
$ticket=1;
$email="";
	switch($tipo)
	{
		case "contacto":
		{
			$asunto=$_POST['asunto'];
			$descripcion=$_POST['descripcion'];
			$email=$_POST['email'];
			
			
			$ticketQuery="select numticket from tra_ticket_enc order by numticket desc limit 1";
			if($ejecutaticket=mysqli_query(conexion($_SESSION['pais']),$ticketQuery))
			{
				if(mysqli_num_rows($ejecutaticket)>0)
				{
					if($row=mysqli_fetch_array($ejecutaticket,MYSQLI_ASSOC))
						{
							$ticket=$row['numticket'];
							$ticket=intval($ticket)+1;
						}
				}
				
			}
			
			$cod1=sys2015();
			sleep(1);
			$cod2=sys2015();
			
			
				$sql="insert into tra_ticket_enc(codticket,numticket,estatus,asunto,codprov,codusua,emailusua) values('".$cod1."',$ticket,'Abierto','".$asunto."','".$_SESSION['codprov']."','".$_SESSION['codigo']."','".$email."');";
				$sql2="insert into tra_ticket_det(coddticket,codticket,descripcion,usuario) values('".$cod2."','".$cod1."','".$descripcion."','".$_SESSION['codigo']."')";
			break;
		}
		case "soporte":
		{
			$estado=$_POST['estado'];
			$email=$_POST['email'];
			$codigo=$_POST['codigo'];
			$ticket=$_POST['ticket'];
			$cerrador=$_POST['cerrador'];
			
				if($estado=="Cerrado")
				{
					$sql="update tra_ticket_enc set usuarioCerro='".$cerrador."',estatus='".$estado."' where codticket='".$codigo."'";
					$sql2="";
				}
				else
				{
					$sql="update tra_ticket_enc set fecha_fin='',usuarioCerro='',estatus='".$estado."' where codticket='".$codigo."'";
					$sql2="1";
				}
				
			break;
		}
		case "user":
		{
			$estado=$_POST['estado'];
			$email=$_POST['email'];
			$codigo=$_POST['codigo'];
			$ticket=$_POST['ticket'];
			$desc=$_POST['desc'];
			$cerrador=$_POST['cerrador'];
			
								
					$sql="insert into tra_ticket_det (coddticket,codticket,descripcion,usuario) values('".sys2015()."','".$codigo."','".$desc."','".$cerrador."')";
				
				$sql2="2";
			break;
		}
		case "user2":
		{
			$estado=$_POST['estado'];
			$email=$_POST['email'];
			$codigo=$_POST['codigo'];
			$ticket=$_POST['ticket'];
			$desc=$_POST['desc'];
			$cerrador=$_POST['cerrador'];
			
								
					$sql="insert into tra_ticket_det (coddticket,codticket,descripcion,usuario) values('".sys2015()."','".$codigo."','".$desc."','".$cerrador."')";
				
				$sql2="";
			break;
		}
	}
				

	

if(mysqli_query(conexion($pais),$sql))
{
	if(isset($sql2))
	{
		switch($sql2)
		{
			case "":
			{
				if($tipo!="user2")
				{
				$desc="Su caso ha sido cerrado esperamos haberlo ayudado";}
				
				echo "<script>envioCorreoContactoRespuesta('".$_SESSION['nom']."','".$_SESSION['apel']."','".$ticket."','".$email."','".$desc."');</script>".$lang[$idioma]['ContactoGuardado2']."";
				break;
			}
			case "1":
			{
				echo '<script>setTimeout(function(){$("#cargaLoad").dialog("close");},700);location.reload();</script>'.$lang[$idioma]['ContactoGuardado2']."";
				break;
			}
			case "2":
			{
				echo "<script>envioCorreoContacto('".$_SESSION['nom']."','".$_SESSION['apel']."','".$ticket."','".$email."','".$desc."');</script>".$lang[$idioma]['ContactoGuardado']."";
				break;
			}
			default :
			{
				if(mysqli_query(conexion($pais),$sql2))
				{
				echo "<script>envioCorreoContacto('".$_SESSION['nom']."','".$_SESSION['apel']."','".$ticket."','".$email."','".$descripcion."');__('contacto').reset();alert('".$lang[$idioma]['NumTicket']." : ".$ticket."')</script>".$lang[$idioma]['ContactoGuardado']."";
				}
				break;
			}
		}
	}
	
	mysqli_close(conexion($pais));

		
					
}
else
{
	echo $sql;
}


?>
