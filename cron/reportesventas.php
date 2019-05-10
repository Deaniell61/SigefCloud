<?php
//function llenarGraficas1()
{
require_once('../php/coneccion.php');
require_once('../php/fecha.php');
$idioma=idioma();
include('../php/idiomas/'.$idioma.'.php');

$sqlEmpresas="select nompais from direct where codproloc!='' and nompais!='DEMO' ; ";
$con=conexion("");
	mysqli_query($con,"BEGIN");

//Abrir las empresas
if($eEmpresas=mysqli_query($con,$sqlEmpresas))
{
	while($empresas=mysqli_fetch_array($eEmpresas,MYSQLI_NUM))
	{
		$conP=conexion($empresas['0']);
		mysqli_query($conP,"BEGIN");
		//Abrir los periodos
		$sqlPeriodos="select nombre from cat_peri";
		if($ePeriodos=mysqli_query($con,$sqlPeriodos))
		{
			while($periodo=mysqli_fetch_array($ePeriodos,MYSQLI_NUM))
			{
				//Abrir las ordenes
				$sqlOrdenes="select shipstate,
									subtotal,
									shifee,
									orddistot,
									giftwrap,
									grandtotal,
									orderunits,
									codorden from tra_ord_enc where shipdate like '".$periodo[0]."%' and reportes=0";
				
				if($eOrdenes=mysqli_query($conP,$sqlOrdenes))
				{
					while($ordenes=mysqli_fetch_array($eOrdenes,MYSQLI_ASSOC))
					{
						
						//Buscar estado y perido
						$sqlVentaEstado="select codestvta,
												codperi,
												codestado from tra_ventas_estado where codperi='".$periodo['0']."' and codestado='".$ordenes['shipstate']."'";
						
						if($eVentaEstado=mysqli_query($conP,$sqlVentaEstado))
						{
							if($eVentaEstado->num_rows>0)
							{	//Reemplazar si ya existe
								while($ventaEstado=mysqli_fetch_array($eVentaEstado,MYSQLI_ASSOC))
								{
									$sqlVentaEstadoUP="update tra_ventas_estado set
																subtotal=subtotal+".$ordenes['subtotal'].",
																shipping=shipping+".$ordenes['shifee'].",
																discount=discount+".$ordenes['orddistot'].",
																total=total+".$ordenes['grandtotal'].",
																unidades=unidades+".$ordenes['orderunits'].",
																ordenes=ordenes+1,
																giftwrap=giftwrap+".$ordenes['giftwrap']." where codperi='".$periodo['0']."' and codestado='".$ordenes['shipstate']."'";
									if($eVentaEstadoUP=mysqli_query($conP,$sqlVentaEstadoUP))
									{
										$sqlOrdenesUP="update tra_ord_enc set reportes=1 where codorden='".$ordenes['codorden']."' and reportes=0";
				
										if($eOrdenesUP=mysqli_query($conP,$sqlOrdenesUP))
										{
											echo "Actualizado: ".$ordenes['shipstate'].",".$periodo['0'];
										}
										else
										{
											mysqli_query($conP,"ROLLBACK");
										}
										
									}
									else
									{
										mysqli_query($conP,"ROLLBACK");
									}
								}
							}
							//Agregar si no existe
							else
							{
								$sqlVentaEstadoIN="insert into tra_ventas_estado
														(CODESTVTA, CODESTADO, CODPERI, SUBTOTAL, SHIPPING, DISCOUNT, TOTAL, UNIDADES, ORDENES, GIFTWRAP, NOMESTADO) values('".sys2015()."', '".$ordenes['shipstate']."', '".$periodo['0']."', '".$ordenes['subtotal']."', '".$ordenes['shifee']."', '".$ordenes['orddistot']."', '".$ordenes['grandtotal']."', '".$ordenes['orderunits']."', 1, '".$ordenes['giftwrap']."', '".buscarrEstado($ordenes['shipstate'])."') ";
														//echo "$sqlVentaEstadoIN ".$empresas['0']."<br>";
								if($eVentaEstadoIN=mysqli_query($conP,$sqlVentaEstadoIN))
								{
									$sqlOrdenesUP="update tra_ord_enc set reportes=1 where codorden='".$ordenes['codorden']."' and reportes=0";
				
									if($eOrdenesUP=mysqli_query($conP,$sqlOrdenesUP))
									{
										echo "Ingresado: ".$ordenes['shipstate'].",".$periodo['0'];
									}
									else
									{
										mysqli_query($conP,"ROLLBACK");
									}
									
								}
							}
								
						}
						
						//Verificar los detalles de cada orden
						$sqlDetOrden="select productid,
												linetotal,
												disnam,
												qty,
												CODDETORD from tra_ord_det where codorden='".$ordenes['codorden']."' and reportes=0;";
						if($eDetOrden=mysqli_query($conP,$sqlDetOrden))
						{
								
							while($detOrden=mysqli_fetch_array($eDetOrden,MYSQLI_ASSOC))
							{
								//Buscar producto y perido
								$sqlVentaProd="select codprovta,
												codperi,
												codprod from tra_ventas_producto where codperi='".$periodo['0']."' and codprod='".$detOrden['productid']."';";
								if($eVentaProd=mysqli_query($conP,$sqlVentaProd))
								{
									if($eVentaProd->num_rows>0)
									{	
										//Reemplazar si ya existe
										while($ventaProd=mysqli_fetch_array($eVentaProd,MYSQLI_ASSOC))
										{
											$sqlVentaProdUP="update tra_ventas_producto set
																SUBTOTAL=SUBTOTAL+".$detOrden['linetotal'].",
																SHIPPING=SHIPPING+".$ordenes['shifee'].",
																DISCOUNT=DISCOUNT+".$ordenes['orddistot'].",
																TOTAL=TOTAL+".$detOrden['linetotal'].",
																UNIDADES=UNIDADES+".$ordenes['orderunits'].",
																ORDENES=ORDENES+1,
																GIFTWRAP=GIFTWRAP+".$ordenes['giftwrap']." where CODPERI='".$periodo['0']."' and CODPROD='".$detOrden['productid']."'";
											if($eVentaProdUP=mysqli_query($conP,$sqlVentaProdUP))
											{
												$sqlDetOrdenUP="update tra_ord_det set reportes=1 where CODDETORD='".$detOrden['CODDETORD']."' and reportes=0;";
				
												if($eDetOrdenUP=mysqli_query($conP,$sqlDetOrdenUP))
												{
													echo "Actualizado: ".$detOrden['productid'].",".$periodo['0'];
												}
												else
												{
													mysqli_query($conP,"ROLLBACK");
												}
												
											}
											else
											{
												mysqli_query($conP,"ROLLBACK");
											}
										}
									}
									//Agregar si no existe
									else
									{
										$sqlVentaProdIN="insert into tra_ventas_producto
														(CODPROVTA, CODPROD, CODPERI, SUBTOTAL, SHIPPING, DISCOUNT, TOTAL, UNIDADES, ORDENES, GIFTWRAP, PRODNAME)
														values
														('".sys2015()."', '".$detOrden['productid']."', '".$periodo['0']."', '".$detOrden['linetotal']."', '".$ordenes['shifee']."', '".$ordenes['orddistot']."', '".$detOrden['linetotal']."', '".$ordenes['orderunits']."', 1, '".$ordenes['giftwrap']."', '".$detOrden['disnam']."') ";
										if($eVentaProdIN=mysqli_query($conP,$sqlVentaProdIN))
										{
												$sqlDetOrdenUP="update tra_ord_det set reportes=1 where CODDETORD='".$detOrden['CODDETORD']."';";
				
												if($eDetOrdenUP=mysqli_query($conP,$sqlDetOrdenUP))
												{
													echo "Ingresado: ".$detOrden['productid'].",".$periodo['0'];
												}
												else
												{
													mysqli_query($conP,"ROLLBACK");
												}
											
										}
										else{
											mysqli_query($conP,"ROLLBACK");
										}
									}
									
								}
								
							}
							
						}
						echo "<br>";
					}
					
					
				}
			}
				
		}
		mysqli_query($conP,"COMMIT");
		mysqli_close($conP);
	}
		
			mysqli_query($con,"COMMIT");
			mysqli_close($con);
					
}
else
{
	mysqli_query($con,"ROLLBACK");
}

}//Cierro funcion

function buscarrEstado($estado)
{
	require_once('../php/coneccion.php');
$pais="";
	$squery="select nombre from cat_estados where codigo='".$estado."'";
	$retornar="";
	$total=0;
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
						if($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
						{
							return $row['0'];
						}
					}
				}
				mysqli_close(conexion($pais));
}

?>