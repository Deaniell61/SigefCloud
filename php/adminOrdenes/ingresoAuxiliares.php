<?php 
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
verTiempo();
session_start();


switch($_POST['tipo'])
{
	case 'shiSta':
	{
		$datos[0]=$_POST['codigo'];
		$datos[1]=$_POST['nombre'];
		
		ingresarShiSta($datos);
		break;
	}
	case 'ordSta':
	{
		$datos[0]=$_POST['codigo'];
		$datos[1]=$_POST['nombre'];
		
		ingresarOrdSta($datos);
		break;
	}
	case 'paySta':
	{
		$datos[0]=$_POST['codigo'];
		$datos[1]=$_POST['nombre'];
		
		ingresarPaySta($datos);
		break;
	}
	case 'payMdo':
	{
		$datos[0]=$_POST['codigo'];
		$datos[1]=$_POST['nombre'];
		$datos[2]=$_POST['descripcion'];
		$datos[3]=$_POST['cuentas'];
		ingresarPayMdo($datos);
		break;
	}
	case 'shiMdo':
	{
		$datos[0]=$_POST['codigo'];
		$datos[1]=$_POST['nombre'];
		
		ingresarShiMdo($datos);
		break;
	}
	case 'shiCarrier':
	{
		$datos[0]=$_POST['codigo'];
		$datos[1]=$_POST['nombre'];
		$datos[2]=$_POST['username'];
		$datos[3]=$_POST['apikey'];
		$datos[4]=$_POST['apiurl'];
		$datos[5]=$_POST['urldeliver'];
		   
		
		ingresarShiCarrier($datos);
		break;
	}
	case 'tOrden':
	{
		$datos[0]=$_POST['codigo'];
		$datos[1]=$_POST['nombre'];
		
		ingresarTOrden($datos);
		break;
	}
	
}
function ingresarOrdSta($datos)
{
	mysqli_query(conexion(""),"BEGIN");
	if($datos[0]=="")
	{
		$squery="insert into cat_ord_sta(codstatus, nombre) values('".sys2015()."','".$datos[1]."')";
	}
	else
	{
		$squery="update cat_ord_sta set nombre='".$datos[1]."' where codstatus='".$datos[0]."'";
	}
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			
					mysqli_query(conexion(""),"COMMIT");
					echo "<script>
									
										window.opener.ordenesAux('1');
										ventana('cargaLoad',300,400);
										setTimeout(function(){window.close();},500);
									</script>
							";
			
			mysqli_close(conexion(""));
		}
		else
		{
			mysqli_query(conexion(""),"ROLLBACK");
			
		}
}
function ingresarPaySta($datos)
{
	mysqli_query(conexion(""),"BEGIN");
	if($datos[0]=="")
	{
		$squery="insert into cat_pay_sta(codpaysta, nombre) values('".sys2015()."','".$datos[1]."')";
	}
	else
	{
		$squery="update cat_pay_sta set nombre='".$datos[1]."' where codpaysta='".$datos[0]."'";
	}
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			
					mysqli_query(conexion(""),"COMMIT");
					echo "<script>
										window.opener.ordenesAux('2');
										ventana('cargaLoad',300,400);
										setTimeout(function(){window.close();},500);
									</script>
							";
			
			mysqli_close(conexion(""));
		}
		else
		{
			mysqli_query(conexion(""),"ROLLBACK");
		}
}
function ingresarPayMdo($datos)
{
	mysqli_query(conexion(""),"BEGIN");
	if($datos[0]=="")
	{
		$squery="insert into cat_pay_mdo(codpaymdo, nombre,descripcio,cuentacob) values('".sys2015()."','".$datos[1]."','".$datos[2]."','".$datos[3]."')";
	}
	else
	{
		$squery="update cat_pay_mdo set nombre='".$datos[1]."',descripcio='".$datos[2]."',cuentacob='".$datos[3]."' where codpaymdo='".$datos[0]."'";
	}
	
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			
					mysqli_query(conexion(""),"COMMIT");
					echo "<script>
										window.opener.ordenesAux('5');
										ventana('cargaLoad',300,400);
										setTimeout(function(){window.close();},500);
									</script>
							";
			
			mysqli_close(conexion(""));
		}
		else
		{
			mysqli_query(conexion(""),"ROLLBACK");
			
		}
}
function ingresarShiMdo($datos)
{
	mysqli_query(conexion(""),"BEGIN");
	if($datos[0]=="")
	{
		$squery="insert into cat_shi_mdo(codshimdo, nombre) values('".sys2015()."','".$datos[1]."')";
	}
	else
	{
		$squery="update cat_shi_mdo set nombre='".$datos[1]."' where codshimdo='".$datos[0]."'";
	}
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			
					mysqli_query(conexion(""),"COMMIT");
					echo "<script>
										window.opener.ordenesAux('3');
										ventana('cargaLoad',300,400);
										setTimeout(function(){window.close();},500);
									</script>
							";
			
			mysqli_close(conexion(""));
		}
		else
		{
			mysqli_query(conexion(""),"ROLLBACK");
		}
}
function ingresarShiCarrier($datos)
{
	mysqli_query(conexion(""),"BEGIN");
	if($datos[0]=="")
	{
		$squery="insert into cat_shi_carrier(codcarrier, nombre,username,apikey,apiurl,urldeliver) values('".sys2015()."','".$datos[1]."','".$datos[2]."','".$datos[3]."','".$datos[4]."','".$datos[5]."')";
	}
	else
	{
		$squery="update cat_shi_carrier set nombre='".$datos[1]."',username='".$datos[2]."',apikey='".$datos[3]."',apiurl='".$datos[4]."',urldeliver='".$datos[5]."' where codcarrier='".$datos[0]."'";
	}
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			
					mysqli_query(conexion(""),"COMMIT");
					echo "<script>
										window.opener.ordenesAux('6');
										ventana('cargaLoad',300,400);
										setTimeout(function(){window.close();},500);
									</script>
							";
			
			mysqli_close(conexion(""));
		}
		else
		{
			mysqli_query(conexion(""),"ROLLBACK");
		}
}
function ingresarTOrden($datos)
{
	mysqli_query(conexion(""),"BEGIN");
	if($datos[0]=="")
	{
		$squery="insert into cat_torden(codtorden, nombre) values('".sys2015()."','".$datos[1]."')";
	}
	else
	{
		$squery="update cat_torden set nombre='".$datos[1]."' where codtorden='".$datos[0]."'";
	}
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			
					mysqli_query(conexion(""),"COMMIT");
					echo "<script>
										window.opener.ordenesAux('7');
										ventana('cargaLoad',300,400);
										setTimeout(function(){window.close();},500);
									</script>
							";
			
			mysqli_close(conexion(""));
		}
		else
		{
			mysqli_query(conexion(""),"ROLLBACK");
		}
}
function ingresarShiSta($datos)
{
	mysqli_query(conexion(""),"BEGIN");
	if($datos[0]=="")
	{
		$squery="insert into cat_shi_sta(codshista, nombre) values('".sys2015()."','".$datos[1]."')";
	}
	else
	{
		$squery="update cat_shi_sta set nombre='".$datos[1]."' where codshista='".$datos[0]."'";
	}
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			
					mysqli_query(conexion(""),"COMMIT");
					echo "<script>
										window.opener.ordenesAux('4');
										ventana('cargaLoad',300,400);
										setTimeout(function(){window.close();},500);
									</script>
							";
			
			mysqli_close(conexion(""));
		}
		else
		{
			mysqli_query(conexion(""),"ROLLBACK");
		}
}

?>
