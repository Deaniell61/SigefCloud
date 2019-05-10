<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$nombre= ucwords(strtolower($_POST['nombre']));
$pass1=limpiar_caracteres_sql($_POST['clave']);
$pass = crypt_blowfish_bydinvaders(limpiar_caracteres_sql($_POST['clave']));
$apellidor= ucwords(strtolower(limpiar_caracteres_sql($_POST['apellido'])));
$email = ucwords(strtolower(limpiar_caracteres_sql($_POST['email'])));
$posicion = (limpiar_caracteres_sql($_POST['posicion']));
$estado = limpiar_caracteres_sql($_POST['estado']);
$codigo = limpiar_caracteres_sql($_POST['codigo']);
$usuario = ucwords(strtolower(limpiar_caracteres_sql($_POST['usuario'])));
$proveedor='';
if($nombre==NULL || $pass==NULL || $apellidor==NULL || $email==NULL)
{
	echo "<span>".$lang[$idioma]['CompletarCampos']."</span>";
}
else
{
## usa la funcion autentica() que se ubica dentro de sesiones.php
if($codigo=='')
{
	$cod=sys2015();
	$sql_auten="insert into sigef_usuarios(codusua,nombre,clave,posicion,email,apellido,estado,usuario,codprov,clave1,eclave1) values('".$cod."','".$nombre."','$pass','$posicion','$email','$apellidor',$estado,'$usuario','','".$pass1."',0);";
}
else
{
	if($_POST['clave']!='')
	{
	
$sql_auten="update sigef_usuarios set clave='$pass',clave1='$pass1',eclave1=0 where codusua='$codigo'";
mysqli_query(conexion(""),$sql_auten);
	}
	
	
	$sql_auten="update sigef_usuarios set nombre='".$nombre."',posicion='$posicion',email='$email',apellido='$apellidor',estado=$estado,usuario='$usuario' where codusua='$codigo'";
	
}
## ejecución de la sentencia sql

if(mysqli_query(conexion(""),$sql_auten))
{
					if(isset($_POST['tipo']))
					{
						$empresa=$_POST['empresa'];
						$codigoprov=$_POST['prov'];
						$proveedor=$_POST['nomprov'];
							$coduser=$cod;
							sleep(1);
							$codemp=sys2015();
							sleep(1);
							$codacceso=sys2015();
							sleep(1);
							$codacceso2=sys2015();
								$sql="insert into acempresas(codacempr,codusua,codempresa,rol) values('".$codemp."','".$coduser."','".$empresa."',1)";
								if($ejecutar=mysqli_query(conexion(""),$sql))
								{
									$sql="insert into acprov(codacprov,codusua,codprov,rol,codempresa) values('".$codemp."','".$coduser."','".$codigoprov."',1,'".$empresa."')";
									if($ejecutar=mysqli_query(conexion(""),$sql))
									{
										$sql="insert into sigef_accesos(codacceso,codusua,codempresa,codmodu,agrega,modifica,elimina) values('".$codacceso."','".$coduser."','".$empresa."','02',1,1,1),('".$codacceso2."','".$coduser."','".$empresa."','02.01',1,1,1)";
										if($ejecutar=mysqli_query(conexion(""),$sql))
										{
											session_start();
											//echo "clave:".$clave."<br>";
											echo "".$lang[$idioma]['UsuarioGuardado'].""."<br><script>enviarCorreoUserProvCopia('".$_SESSION['user']."','".$pass1."','".$_SESSION['nom']."','".$_SESSION['apel']."','".$proveedor."','".$email."');enviarCorreoUserProv('".$email."','".$pass1."','".$nombre."','".$apellidor."','".$proveedor."');</script>";
										}
										else
										{
											echo $sql;
										}
									}
									else
										{
											echo $sql;
										}
									
								}
								
							
					}
						echo "<script>document.getElementById('usuarios').reset();document.getElementById('nombre').focus();</script>".$lang[$idioma]['UsuarioGuardado']."";
}
else
{
	echo "El usuario ya existe<script>setTimeout(function(){\$(\"#cargaLoadVP\").dialog(\"close\");},500);</script>";
}
}

?>
