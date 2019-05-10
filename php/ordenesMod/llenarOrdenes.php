<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$nombre= ucwords(strtolower($_POST['nombre']));
$pais= $_POST['pais'];
$codpais= $_POST['codpais'];
//$filtro= $_POST['filtro'];
//$fecha=getdate();
session_start();
/*$fecha = date('Y-m-d');


if($filtro=='2')
{
	$nuevafecha = strtotime ( '-24 hour' , strtotime ( $fecha ) ) ;
}
else
if($filtro=='13')
{
	$nuevafecha = strtotime ( '-10000 year' , strtotime ( $fecha ) ) ;
}
else
{
	$nuevafecha = strtotime ( '-'.$filtro.' day' , strtotime ( $fecha ) ) ;
}

$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
$nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
$fecha = date ( 'Y-m-d' , $nuevafecha2 );*/
if($nombre=="" or $nombre==NULL)
{
	$squery="select te.orderid, te.timoford, (te.grandtotal), te.orderunits, te.ordsou, te.tranum,te.shicar, te.codorden, te.SHISTA, te.SHIPDATE, te.SHIFEE, te.SHIFIRNAM, te.SHILASNAM, te.SHIADD1, te.SHIADD2, te.SHIPCITY, te.SHIPSTATE, te.SHIZIPCOD, te.SHICOU, te.SHIPHONUM from tra_ord_enc te where (SHIPSTATE='$nombre' and paysta!='NoPayment') order by timoford desc";
}
else
{
	$squery="select te.orderid, te.timoford, (te.grandtotal), te.orderunits, te.ordsou, te.tranum,te.shicar, te.codorden, te.SHISTA, te.SHIPDATE, te.SHIFEE, te.SHIFIRNAM, te.SHILASNAM, te.SHIADD1, te.SHIADD2, te.SHIPCITY, te.SHIPSTATE, te.SHIZIPCOD, te.SHICOU, te.SHIPHONUM from tra_ord_enc te where (SHIPSTATE like '%$nombre%' and paysta!='NoPayment') order by timoford desc";
}

## ejecución de la sentencia sql

echo encabezado().
		 tabla($squery,$pais,$codpais);
		
function tabla($squer,$pais,$codpais)
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	$retornar="";
	$total=0;
	$contador=0;
	$contador2=0;
	$retornar=$retornar."<tbody>";
	$GoogleDirect='https://maps.googleapis.com/maps/api/geocode/json?address=';
	$apyKey='&key=AIzaSyDApgjC6tUNZlYqPFHxSBBtX7TStL-DcAw';
//AIzaSyDgW7obBgI8oI-rMNwYEevtvn-Wy5pjyJU
//AIzaSyCdJAwErIy3KmcE_EfHACIvL0Nl1RjhcUo
	$ejecutar=mysqli_query(conexion($pais),$squer);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
						include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
						$sellercloud = new sellercloud();
						
					
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						if($contador==100)
						{
							$contador=0;
						}
						$contador++;
						$contador2++;
						setlocale(LC_MONETARY, 'en_US');
						
						//var_dump(ZipCodeSearch(urlencode($row['17'])));
						$zip=explode("-",$row['17']);
						$zipCodeData = $sellercloud->getZipCode($zip[0]);
						$codCity="";
						if(isset($zipCodeData->ZipCodeSearchResult->State))
						{
							$zipCodeData=$zipCodeData->ZipCodeSearchResult->State;
							$codCity=$zipCodeData;
						}
						else
						{
							if(file_exists($GoogleDirect.urlencode($row['17']).$apyKey))
							{
								$googleFile=file_get_contents($GoogleDirect.urlencode($row['17']).$apyKey);
								$json=json_decode($googleFile,true);
									//var_dump($json['results']);
								if(!empty($json['results']))
								{
									for($i=0;$i<count($json['results'][0]['address_components']);$i++)
									{
										if($json['results'][0]['address_components'][$i]['types'][0]=="administrative_area_level_1")
										{
											$codCity=$json['results'][0]['address_components'][$i]['short_name'];
										}
										
										
									}
								}
							}
							
							//echo $GoogleDirect.urlencode($row['17']).$apyKey."-".$json['results'][0]['address_components'][$i]['types'][0]."-".$json['results'][0]['address_components'][$i]['short_name']."<br>";
						}

						
						
						//echo $zipCodeData;
						$retornar=$retornar."<tr  id=\"OrdenNum".$contador."\">
								<td><input type=\"checkbox\" id=\"CheckOrdenNum".$contador."\" value=\"".strtoupper($row['7'])."\" /></td>
								<td hidden=\"hidden\">".($row['0'])."</td>
								<td><center>".($row['0'])."</center></td>
								<td id=\"ActualState".$contador."\"><center>".($row['16'])."</center></td>
								<td>".buscaNomEstado($row['16'],"../")."</td>
								<td>".($row['15'])."</td>
								<td id=\"CorrectState".$contador."\"><center>". ($codCity)."</center></td>
								
								<td><center>".($row['17'])."</center></td>
								<td>".($row['13'])."</td>
								<td>".($row['14'])."</td>
								
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
		\"pageLength\": 100,
        \"info\":     false,
        \"oLanguage\": {
      \"sLengthMenu\": \" _MENU_ \",
      
  
      
    }
        
         
         
    } );
    
  ejecutarpie();
     
});
	document.getElementById('totalGrid').innerHTML=': ".($contador2)."';
	
	document.getElementById('tablas_length').style.display='none';
	setTimeout(function () {
            $(\"#cargaLoadVP\").dialog(\"close\");
        }, 300);
           </script>";
				
				$retornar=$retornar."<div id='NotificacionVentana'></div>";	
				return $retornar;
}

function encabezado()
{
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	return "<center>
			<div>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/ onClick=\"marcarTodosChech();\" title=\"Select All\"></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['orderid']."</th>
					<th>".$lang[$idioma]['Estado']."</th>
                    <th>".$lang[$idioma]['Nombre']."</th>
                    <th>".$lang[$idioma]['Ciudad']."</th>
					<th>".$lang[$idioma]['EstadoCorrect']."</th>
					<th>".$lang[$idioma]['ZipCode']."</th>
					<th>".$lang[$idioma]['Direccion']." 1</th>
					<th>".$lang[$idioma]['Direccion']." 2</th>
					
                </tr> </thead>
                
			
            ";
}


function ZipCodeSearch($zip)
{
	include_once($_SERVER["DOCUMENT_ROOT"] . "SIGEF/php/sellercloud/sellercloud.php");
	$sellercloud = new sellercloud();
	$zipCodeData = $sellercloud->getZipCode($zip);
	if(isset($zipCodeData->ZipCodeSearchResult->State))
	{
		$zipCodeData=$zipCodeData->ZipCodeSearchResult->State;
	}
	else
	{
		$zipCodeData=$zipCodeData->ZipCodeSearchResult->ZipCode;
	}
	//$zipCodeData=$zipCodeData['ZipCodeSearchResult']['ZipCode'];
	return $zipCodeData;
	
}
				
?>
