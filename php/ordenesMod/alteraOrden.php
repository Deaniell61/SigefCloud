<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codigo=$_POST['codigo'];
$estado=$_POST['estado'];
$pais=$_POST['pais'];

	$con=conexion($pais);
	$ejecuta=$con->query("select timoford,
									shipstate,
									subtotal,
									shifee,
									orddistot,
									giftwrap,
									grandtotal,
									orderunits,
									codorden from tra_ord_enc where codorden='".$codigo."'");
	if($ejecuta->num_rows>0)
	{
		if($ordenes=$ejecuta->fetch_assoc())
		{mysqli_query($con,"BEGIN");
			$sqlVentaEstadoUP="update tra_ventas_estado set
								subtotal=subtotal+".$ordenes['subtotal'].",
								shipping=shipping+".$ordenes['shifee'].",
								discount=discount+".$ordenes['orddistot'].",
								total=total+".$ordenes['grandtotal'].",
								unidades=unidades+".$ordenes['orderunits'].",
								ordenes=ordenes+1,
								giftwrap=giftwrap+".$ordenes['giftwrap']." where codperi='".substr($ordenes['timoford'],0,7)."' and codestado='".substr($estado,0,2)."'";
			if($con->query($sqlVentaEstadoUP))
			{
				$sqlVentaEstadoDEL="update tra_ventas_estado set
								subtotal=subtotal-".$ordenes['subtotal'].",
								shipping=shipping-".$ordenes['shifee'].",
								discount=discount-".$ordenes['orddistot'].",
								total=total-".$ordenes['grandtotal'].",
								unidades=unidades-".$ordenes['orderunits'].",
								ordenes=ordenes-1,
								giftwrap=giftwrap-".$ordenes['giftwrap']." where codperi='".substr($ordenes['timoford'],0,7)."' and codestado='".$ordenes['shipstate']."'";
				if($con->query($sqlVentaEstadoDEL))
				{
					$sql="update tra_ord_enc set oldstate=shipstate,shipstate='".substr($estado,0,2)."' where codorden='".$codigo."'; ";
					
						if(mysqli_query($con,$sql))
						{
							$conP=conexion('');
							$conP->query('BEGIN');
								if($conP->query("update cat_estados set variaciones=CONCAT(variaciones, ',".$ordenes['shipstate']."') where codigo='".substr($estado,0,2)."'"))
								{
									$conP->query('COMMIT');
								}
								else{
									$conP->query('ROLLBACK');
								}
								$conP->close();
											mysqli_query($con,"COMMIT");
											echo "<script>
											$sqlVentaEstadoUP
												buscar();
											
											</script>
											";
							comprobarEstadoWrong(substr($ordenes['timoford'],0,7),substr($estado,0,2));
						}
						else
						{
							mysqli_query($con,"ROLLBACK");
							echo "$sql";
						}

				}
				mysqli_query($con,"COMMIT");
				$con->close();
			}
		}
		
	}

function comprobarEstadoWrong($peri,$estado,$pais)
{
	$con=conexion($pais);
	$ejecuta=$con->query("select codestvta from tra_ventas_estado where codestado='".$estado."' and codperi='".$peri."' and subtotal<1 and total<1");
	if($ejecuta->num_rows>0)
	{
		if($ordenes=$ejecuta->fetch_row())
		{
			$con->query('BEGIN');
			$elim="delete from tra_ventas_estado where codestvta='".$ordenes[0]."'";

			if(!$con->query($elim))
			{
				$con->query('ROLLBACK');
				echo "Error eliminando Estado ".$estado;
			}
			else{
				$con->query('COMMIT');
			}
		}
	}
}
?>
