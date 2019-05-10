<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
verTiempo();
## usuario y clave pasados por el formulario
$pais= $_SESSION['pais'];
$codpais= $_SESSION['CodPaisCod'];
$fechaI= $_POST['fechaI'];
$fechaF= $_POST['fechaF'];
//$fecha=getdate();


	$tcodprov = $_SESSION["codprov"];
	$squery="select orderid, timoford, (grandtotal), orderunits, ordsou, tranum,shicar from tra_ord_enc where CODPROV = '$tcodprov' AND timoford <= '".$fechaF."' and timoford >= '".$fechaI."' order by timoford desc";

//	echo $squery;

## ejecución de la sentencia sql

echo "<div style=\"display:none;\" id=\"FechaIniD\">".$fechaI."</div><div style=\"display:none;\" id=\"FechaFinD\">".$fechaF."</div>".encabezado().
		 tabla($squery,$pais,$codpais);
		
function tabla($squer,$pais,$codpais)
{
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	$retornar="";
	$total=0;
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion($pais),$squer);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						
						if(file_exists('../../../images/iconosSeller/Channel_'.$row['4'].'.png'))
						{
							$canal='<img src="../images/iconosSeller/Channel_'.$row['4'].'.png" style="width:20px; height:20px;"/>';
						}
						else
						{
							$canal=$row['4'];
						}
						if(strtoupper($row['6'])=="USPS")
						{
							$link="https://tools.usps.com/go/TrackConfirmAction.action?tRef=fullpage&tLc=1&text28777=&tLabels=".$row['5']."' target='_blank'";
						}
						else
						if(strtoupper($row['6'])=="FEDEX")
						{
							$link="https://www.fedex.com/apps/fedextrack/?action=track&cntry_code=us&tracknumber_list=".$row['5']."&language=english' target='_blank'";
						}
						else
						if(strtoupper($row['6'])=="UPS")
						{
							$link="https://wwwapps.ups.com/WebTracking/processRequest?tracknums_displayed=1&TypeOfInquiryNumber=T&InquiryNumber1=".$row['5']."' target='_blank'";
						}
						else
						{
							$link="#'";
						}
					
					if(strtoupper($row['5'])!="")
						{
							$click="onClick=\"abrirOrdenes('".strtoupper($row['0'])."','".$pais."','".$codpais."');\"";
						}
						else
						{
							$click="";
						}
						$contador++;
						setlocale(LC_MONETARY, 'en_US');
						$retornar=$retornar."<tr >
								<td><input type=\"checkbox\" id=\"".strtoupper($row['0'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['0'])."').value)\"  value=\"".strtoupper($row['0'])."\" /></td>
								<td hidden=\"hidden\">".($row['0'])."</td>
								<td onMouseOver=\"this.style.cssText='background-color: #afafaf'\" onMouseOut=\"this.style.cssText='background-color: none'\" ".$click.">".($row['0'])."</td>
								<td>".($row['1'])."</td>
								<td>".toMoney(round($row['2'],5,2))."</td>
								<td><center>".number_format($row['3'])."</center></td>
								<td><center>".($canal)."</center></td>
								<td><a href='".$link.">".($row['5'])."</a></td>
								
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
	setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
           </script>";
				
				$retornar=$retornar."<div id='NotificacionVentana'></div>";	
				return $retornar;
}

function encabezado()
{
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	return "<center>
			<div>
			<div style=\"position:absolute; width:77%; top:200px;\">
               <img src=\"../images/excel.png\" id=\"exportExcel\" onClick=\"llamarReporte(13,document.getElementById('FechaIniD').innerHTML)\" style=\"width:20px; height:20px; float:right; margin-left:5px;margin-top:5px; cursor:pointer;\">

               </div>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['orderid']."</th>
					<th>".$lang[$idioma]['timoford']."</th>
                    <th>".$lang[$idioma]['grandtotal']."</th>
                    <th>".$lang[$idioma]['orderunits']."</th>
					<th>".$lang[$idioma]['ordsou']."</th>
					<th>".$lang[$idioma]['tranum']."</th>
					
                </tr> </thead>
                
			
            ";
}

				
				
?>
