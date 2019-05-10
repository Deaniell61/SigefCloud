<?php

require_once('../../coneccion.php');

session_start();

$codigo=$_POST['combo'];
$grupoconta=$_POST['grupoconta'];
intval($grupoconta);
	$sql="select codigo from cat_nomenclatura where QUE_ES='".$codigo."' and substring(codigo,1,1)='".$grupoconta."'  order by codigo desc limit 1";	
	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						echo intval($row['codigo']);
					}

			}
/*}	


if($codigo==3)
{
	
	$sql="select codigo from cat_nomenclatura where QUE_ES='".$codigo."' and substring(codigo,1,2)='".$subgrupoconta."'  order by codigo desc limit 1";	
	
	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						echo intval($row['codigo']);
					}

			}

}	

if($codigo==4)
{
	
	$sql="select codigo from cat_nomenclatura where QUE_ES='".$codigo."' and substring(codigo,1,2)='11102'  order by codigo desc limit 1";	
	
	
		$ejecutar=mysqli_query(conexion($_SESSION['pais']),$sql);

			if($ejecutar->num_rows>0)
			{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						echo intval($row['codigo']);
					}

			}
			
}		
	*/	
?>