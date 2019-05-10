<?php
require_once('../../../coneccion.php');
require_once('../../../fecha.php');
$idioma=idioma();
include('../../../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$Vventa= $_POST['Vventa'];
$Vtipo= $_POST['Vtipo'];
$periFin= $_POST['periFin'];
$periIni= $_POST['periIni'];
//$fecha=getdate();
session_start();
$fecha = date('Y-m-d');
$pais=$_SESSION['pais'];

$oculta="";

	if(!($_SESSION['codEmpresa']=="_4jt03skyy"))
	{
		$oculta=" style=\"display:none;\"";
	}

	$squery="select codestvta,codestado,codperi,sum(subtotal),sum(shipping),sum(discount),sum(total),sum(unidades),sum(ordenes),GIFTWRAP,nomestado from tra_ventas_estado where (codperi between '".$periIni."' and '".$periFin."') group by codestado order by codestado";


	$retornar="
	
	 <img src=\"../images/excel.png\" id=\"exportExcel\" onClick=\"llamarReporte(15,document.getElementById('periIni'))\" style=\"width:20px;height:20px;float:right;margin-left:5px;margin-top:5px;margin-right: 20px;cursor:pointer;\">
	<center>
			<div><br>
			<center><strong>".$periIni." - ".$periFin."</strong></center>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['Codigo']."</th>
					<th>".$lang[$idioma]['Estado']."</th>
                    <th><center>".$lang[$idioma]['ordenes']."</center></th>
                    <th$oculta><center>".$lang[$idioma]['subTotal']."</center></th>
					<th$oculta><center>".$lang[$idioma]['shipping']."</center></th>
					<th$oculta><center>".$lang[$idioma]['Descuento']."</center></th>
					<th><center>".$lang[$idioma]['grandtotal']."</center></th>
					".
					meses($periIni,$periFin)
					."
                </tr> </thead>
                
			
            ";;
	$total=0;
	
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						
						$contador++;
						setlocale(LC_MONETARY, 'en_US');
						$retornar=$retornar."<tr onClick=\"abrirOrdenesPorEstado('".$row['1']."','".$_SESSION['pais']."','".$periIni."','".$periFin."','1','');\">
								<td><input type=\"checkbox\" id=\"".strtoupper($row['0'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['0'])."').value)\"  value=\"".strtoupper($row['0'])."\" /></td>
								<td hidden=\"hidden\">".($row['0'])."</td>
								<td>".($row['1'])."</td>
								<td>".($row['10'])."</td>
								<td><center>".($row['8'])."</center></td>
								<td$oculta><center>".toMoney(round($row['3'],5,2))."</center></td>
								<td$oculta><center>".toMoney(round($row['4'],5,2))."</center></td>
								<td$oculta><center>".toMoney(round($row['5'],5,2))."</center></td>
								<td><center>".toMoney((round($row['3'],5,2)+round($row['4'],5,2)-round($row['5'],5,2)))."</center></td>
							
								".mesesPlanteados($periIni,$periFin,$pais,$row['1'])
								."
								
								
							  </tr>";
					$total=$total+round($row['2'],5,2);
					}
						}
						mysqli_close(conexion($pais));
					
				}
				else
				{	
					$retornar="Error de llenado de tabla";
				}
					$retornar=$retornar."</tbody></table></div>
			</center><br>
			
			<script   type=\"text/javascript\">

           $(document).ready(function(){
    
   $('#tablas').DataTable( {
        \"scrollY\": \"300px\",
        \"scrollX\": true,
        \"paging\":  true,
        \"info\":     false,
        \"oLanguage\": {
      \"sLengthMenu\": \" _MENU_ \",
      
  
      
    }
        
         
         
    } );
    
  ejecutarpie();
     
});
	setTimeout(function () {
            $(\"#cargaLoadVP\").dialog(\"close\");
        }, 300);
           </script>";
				
				$retornar=$retornar."<div id='NotificacionVentana'></div>";	
				echo $retornar;


function meses($periIni,$periFin)
{
	$periodo=$periIni;




	$ret="";
	
	while($periodo<=$periFin)
	{
		$ret.="<th><center>".substr($periodo,0,strlen($periodo)-3)."".nombreMes(substr($periodo,strlen($periodo)-3,strlen($periodo)))."</center></th>";
		$nuevafecha = strtotime ( '+1 month' , strtotime ( $periodo ) ) ;
		$periodo = date ( 'Y-m' , $nuevafecha );
		
	}
	return $ret;
}
function mesesPlanteados($periIni,$periFin,$pais,$estado)
{
	$periodo=$periIni;




	$ret="";
	
	while($periodo<=$periFin)
	{
		$squery="select sum(ordenes),sum(subtotal),sum(shipping),sum(discount),sum(total),sum(unidades),GIFTWRAP,nomestado from tra_ventas_estado where codperi='".$periodo."' and codestado='".$estado."' group by codperi";
		$ejecutar=mysqli_query(conexion($pais),$squery);
		if($ejecutar)
		{
			if($ejecutar->num_rows>0)
			{
			$contador=0;
				while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
				{
					$ret.="<td><center>".toMoney((round($row['1'],5,2)+round($row['2'],5,2)-round($row['3'],5,2)))."</center></td>";
				}
			}
			else
			{
				$ret.="<td><center>".toMoney(0)."</center></td>";
			}
		}
		
		
		$nuevafecha = strtotime ( '+1 month' , strtotime ( $periodo ) ) ;
		$periodo = date ( 'Y-m' , $nuevafecha );
		
	}
	return $ret;
}

function nombreMes($mes)
{
	switch($mes)
	{
		case "-01":
		{
			return "-ENE";
			break;
		}
		case "-02":
		{
			return "-FEB";
			break;
		}
		case "-03":
		{
			return "-MAR";
			break;
		}
		case "-04":
		{
			return "-ABR";
			break;
		}
		case "-05":
		{
			return "-MAY";
			break;
		}
		case "-06":
		{
			return "-JUN";
			break;
		}
		case "-07":
		{
			return "-JUL";
			break;
		}
		case "-08":
		{
			return "-AGO";
			break;
		}
		case "-09":
		{
			return "-SEP";
			break;
		}
		case "-10":
		{
			return "-OCT";
			break;
		}
		case "-11":
		{
			return "-NOV";
			break;
		}
		case "-12":
		{
			return "-DIC";
			break;
		}
		
	}
}
				
?>
