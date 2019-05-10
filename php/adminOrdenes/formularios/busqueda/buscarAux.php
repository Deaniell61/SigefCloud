<?php 
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../../../fecha.php');
require_once('../../../coneccion.php');
$idioma=idioma();
include('../../../idiomas/'.$idioma.'.php');
verTiempo();
session_start();

$codigo=$_POST['codigo'];


switch($_POST['tipo'])
{
	case 'ShiSta':
	{
		buscarShiSta($codigo);
		break;
	}
	case 'OrdSta':
	{
		buscarOrdSta($codigo);
		break;
	}
	case 'PaySta':
	{
		buscarPaySta($codigo);
		break;
	}
	case 'ShiMdo':
	{
		buscarShiMdo($codigo);
		break;
	}
	case 'PayMdo':
	{
		buscarPayMdo($codigo);
		break;
	}
	case 'ShiCarrier':
	{
		buscarShiCarrier($codigo);
		break;
	}
	case 'TOrden':
	{
		buscarTOrden($codigo);
		break;
	}
	
}
function buscarOrdSta($codigo)
{
	$squery="select codstatus, nombre from cat_ord_sta where codstatus='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					
					echo "<script>
										document.getElementById('codigo').value='".$row['0']."';
										document.getElementById('nombre').value='".$row['1']."';
										
										
										
										
									</script>
							";
				}
				
			}
			
			mysqli_close(conexion(""));
		}
}
function buscarPaySta($codigo)
{
	$squery="select codpaysta, nombre from cat_pay_sta where codpaysta='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					
					echo "<script>
										document.getElementById('codigo').value='".$row['0']."';
										document.getElementById('nombre').value='".$row['1']."';
										
										
										
										
									</script>
							";
				}
				
			}
			
			mysqli_close(conexion(""));
		}
}
function buscarShiMdo($codigo)
{
	$squery="select codshimdo, nombre from cat_shi_mdo where codshimdo='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					
					echo "<script>
										document.getElementById('codigo').value='".$row['0']."';
										document.getElementById('nombre').value='".$row['1']."';
										
										
										
										
									</script>
							";
				}
				
			}
			
			mysqli_close(conexion(""));
		}
}
function buscarPayMdo($codigo)
{
	$squery="select codpaymdo, nombre,descripcio,cuentacob from cat_pay_mdo where codpaymdo='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					
					echo "<script>
										document.getElementById('codigo').value='".$row['0']."';
										document.getElementById('nombre').value='".$row['1']."';
										document.getElementById('descripcion').value='".$row['2']."';
										document.getElementById('cuentacob').value='".$row['3']."';
										tags('".$row['3']."');
										
										
										
									</script>
							";
				}
				
			}
			
			mysqli_close(conexion(""));
		}
}
function buscarShiCarrier($codigo)
{
	$squery="select codcarrier, nombre,username,apikey,apiurl,urldeliver from cat_shi_carrier where codcarrier='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					
					echo "<script>
										document.getElementById('codigo').value='".$row['0']."';
										document.getElementById('nombre').value='".$row['1']."';
										document.getElementById('username').value='".$row['2']."';
										document.getElementById('apikey').value='".$row['3']."';
										document.getElementById('apiurl').value='".$row['4']."';
										document.getElementById('urldeliver').value='".$row['5']."';
										
										
										
										
									</script>
							";
				}
				
			}
			
			mysqli_close(conexion(""));
		}
}
function buscarTOrden($codigo)
{
	$squery="select codtorden, nombre from cat_torden where codtorden='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					
					echo "<script>
										document.getElementById('codigo').value='".$row['0']."';
										document.getElementById('nombre').value='".$row['1']."';
										
										
										
										
									</script>
							";
				}
				
			}
			
			mysqli_close(conexion(""));
		}
}
function buscarShiSta($codigo)
{
	$squery="select codshista, nombre from cat_shi_sta where codshista='".$codigo."'";
		
		if($ejecuta=mysqli_query(conexion(""),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
					
					echo "<script>
										document.getElementById('codigo').value='".$row['0']."';
										document.getElementById('nombre').value='".$row['1']."';
										
										
										
										
									</script>
							";
				}
				
			}
			
			mysqli_close(conexion(""));
		}
}

?>
        
       