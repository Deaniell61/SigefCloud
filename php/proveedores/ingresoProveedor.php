<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
## usuario y clave pasados por el formulario
$codigo = $_POST['codigo'];
$pais = $_POST['pais'];
$nombre = $_POST['nombre'];
$telefono2 = $_POST['telefono2'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$fax = $_POST['fax'];
$web = $_POST['web'];
$emailContacto = $_POST['emailContacto'];
$contacto = $_POST['contacto'];
$apellido = $_POST['contactoApellido'];
$empresa = $_POST['empresa'];
$codpos = $_POST['codpos'];
$estado = $_POST['estado'];
$paisprov = $_POST['paisprov'];
$check = $_POST['check'];
$ciudadprov = $_POST['ciudadprov'];
$cargo = $_POST['cargo'];
echo "$codigo";
if ($nombre == "" || $empresa == "" || $contacto == "" || $emailContacto == "") {

    echo "<span>Debe completar todos los campos obligatorios</span>";
} else {
    if ($codigo == 'nuevo') {
        $sql = "INSERT INTO cat_prov(codprov,nombre,direccion,telefono,fax,nomcontacto,mailcontac,puestocont,codempresa,website,estado,APELCONTACTO,telcontacto,codeco,ciudad,trademark,codpos,estatus,tipo) VALUES('" . sys2015() . "','" . $nombre . "','" . $direccion . "','" . $telefono . "','" . $fax . "','" . $contacto . "','" . $emailContacto . "','" . $cargo . "','" . $empresa . "','" . $web . "'," . $estado . ",'" . $apellido . "','" . $telefono2 . "','" . $paisprov . "','" . $ciudadprov . "'," . $check . ",'" . $codpos . "','234',1);";
    } else {
        $sql = "UPDATE cat_prov SET nombre='" . $nombre . "',direccion='" . $direccion . "',telefono='" . $telefono . "',fax='" . $fax . "',nomcontacto='" . $contacto . "',mailcontac='" . $emailContacto . "',puestocont='" . $cargo . "',website='" . $web . "',estado=" . $estado . ",APELCONTACTO='" . $apellido . "',telcontacto='" . $telefono2 . "',codeco='" . $paisprov . "',ciudad='" . $ciudadprov . "',trademark=" . $check . ",codpos='" . $codpos . "' WHERE codprov='" . $codigo . "'";
    }
## ejecución de la sentencia sql

    if (mysqli_query(conexion($pais), $sql)) {
        $_SESSION['codprov2'] = "";

        if ($codigo == 'nuevo') {
//            echo "HERE";
//            $destino12 = "solus.huargo@gmail.com";
            $destino12 = "paulo.armas@guatedirect.com";
            $destino5 = "mauricio.aldana@sigefcloud.com";
//            $destino2 = "eduardoguallito@gmail.com";
//            $destino3 = "jdanielr61@gmail.com";
            $from = "SigefCloud Team Support  <support@sigefcloud.com>";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: $from\r\n";
            $headers .= "Reply-To: $from\r\n";
            $headers .= "Return-path: $from\r\n";
            $headers .= "Bcc: $destino3, $destino5, $destino12\r\n" . "X-Mailer: PHP/" . phpversion();
            $desde = $headers;
            $destinoU = $emailContacto;


            $asunto = utf8_decode("Solicitud de Registro Nuevo Proveedor");

            $mensaje = utf8_decode(
                "
							<html>
							<head>
							
							</head>
							<body>
								<br>
									<center>
									<div style=\"text-align:left;
									color:blue;width:70%;\">
										Hemos recibido una solicitud de registro de <strong>$nombre</strong> de <strong>$pais</strong>,<br>
										Es estado del proveedor esta en registro a la espera de ser aprobado.<br><br>
										
										Se ha ingresado el correo:<br>
											Usuario: <strong>$emailContacto</strong><br>
										para registrar como usuario
									</div></center>	
										<br><br>
									<div style=\"text-align:rigth;
									color:#D67900;width:100%;margin-left:10%;\" >
										Por favor atender la solicitud lo antes posible.<br><br>
									</div>
										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/" . str_replace(" ", "%20", $pais) . ".png\" width='200' height='100' alt=\"Guate Direct\"></a>
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
									color:red;width:100%;margin-left:0%;\"><strong>Saludos $contacto $apellido. </strong></span><br><br>
									<center>
									<div style=\"text-align:left;
									color:blue;width:70%;\">
										Hemos recibido su solicitud de registro para la empresa <strong>$nombre</strong> de <strong>$pais</strong>,<br>
										su estado esta a la espera de ser aprobado.<br><br>
										
										
									</div></center>	
										<br>
									<div style=\"text-align:rigth;
									color:#D67900;width:100%;margin-left:10%;\" >
										En breve se le informara su contraseña para que pueda ingresar.<br><br>
									</div>
										<center> <a href=\"http://www.sigefcloud.com/\"><img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/" . str_replace(" ", "%20", $pais) . ".png\" alt=\"Guate Direct\"></a>
										<br><br>http://www.sigefcloud.com/ </center>
								</body>	
								</html>");


            require_once('../mails/mailMailer.php');
            if (enviaEmail($destinoU, $asunto, $mensaje2, $desde)) {
                if (enviaEmailNotificacion($destino3, $asunto, $mensaje, $desde)) {
                    echo "<script>alert('" . $lang[$idioma]['ProveedorGuardadoE'] . "');setTimeout(function(){window.close();},2000);</script>";
                }
            }
            echo "<script>alert('" . $lang[$idioma]['ProveedorGuardadoE'] . "');setTimeout(function(){window.close();},2000);</script>";
        } else {
            if ($estado == "2") {
                sleep(1);
                $coduser = sys2015();

                sleep(1);
                $clave = sys2015();
                $clave = substr($clave, 1, strlen($clave));
                $pass = crypt_blowfish_bydinvaders($clave);

                $sql = "INSERT INTO sigef_usuarios(codusua,nombre,apellido,email,estado,clave,clave1,eclave1,posicion,usuario,codprov) VALUES('" . $coduser . "','" . $contacto . "','" . $apellido . "','" . $emailContacto . "',21,'" . $pass . "','" . $clave . "',0,'P','" . substr($contacto, 0, 3) . "-" . substr($apellido, 0, 3) . "','" . $codigo . "')";
                if ($ejecutar = mysqli_query(conexion(""), $sql)) {
                    sleep(1);
                    $codemp = sys2015();
                    sleep(1);
                    $codacceso = sys2015();
                    sleep(1);
                    $codacceso2 = sys2015();
                    sleep(1);
                    $codacceso3 = sys2015();
                    sleep(1);
                    $codacceso4 = sys2015();
                    $sql = "INSERT INTO acempresas(codacempr,codusua,codempresa,rol) VALUES('" . $codemp . "','" . $coduser . "','" . $empresa . "',1)";
                    if ($ejecutar = mysqli_query(conexion(""), $sql)) {
                        $sql = "INSERT INTO acprov(codacprov,codusua,codprov,rol,codempresa) VALUES('" . $codemp . "','" . $coduser . "','" . $codigo . "',1,'" . $empresa . "')";
                        if ($ejecutar = mysqli_query(conexion(""), $sql)) {
                            $sql = "INSERT INTO sigef_accesos(codacceso,codusua,codempresa,codmodu,agrega,modifica,elimina) VALUES('" . $codacceso . "','" . $coduser . "','" . $empresa . "','02',1,1,1),('" . $codacceso2 . "','" . $coduser . "','" . $empresa . "','02.01',1,1,1),('" . $codacceso3 . "','" . $coduser . "','" . $empresa . "','05',1,1,1),('" . $codacceso4 . "','" . $coduser . "','" . $empresa . "','05.01',1,1,1)";
                            if ($ejecutar = mysqli_query(conexion(""), $sql)) {
                                //echo "clave:".$clave."<br>";
                                echo "" . $lang[$idioma]['UsuarioGuardado'] . "" . "<br><script>enviarCorreo('" . $emailContacto . "','" . $clave . "','" . $contacto . "','" . $apellido . "','" . $nombre . "');</script>";
                            } else {
                                echo $sql;
                            }
                        } else {
                            echo $sql;
                        }

                    } else {
                        echo $sql;
                    }
                } else {
                    echo "El usuario de esta empresa ya existe<br>";
                }
            }

            echo "<script>setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},500);</script>" . $lang[$idioma]['ProveedorGuardado'] . "";
        }
    } else {
        //echo $pais;
        echo "<br>Es posible que el correo ya exista, porfavor intente otro correo electronico<script>setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},500);</script>";
    }
}
?>
