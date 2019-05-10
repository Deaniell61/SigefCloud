<?php
require_once('../../../coneccion.php');
require_once('../../../fecha.php');
$idioma=idioma();
include('../../../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$estado= $_POST['estado'];
$pais= $_POST['pais'];
$inicio= $_POST['inicio'];
$final= $_POST['final'];
$tipo= $_POST['tipo'];
//$fecha=getdate();
session_start();

 $squer="select e.orderid, e.timoford, (e.grandtotal), e.orderunits, e.ordsou, e.tranum,e.shicar from tra_ord_enc e,tra_ord_det d where d.codorden=e.codorden and (e.timoford between '".$inicio."-01 00:00:00' and '".$final."-30 23:59:59') and d.productid='".$estado."' group by e.codorden order by e.timoford desc";

$con=conexion($pais);
$retornar="";
	
	$retornar.= "<center>
			<div>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../../../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['orderid']."</th>
					<th>".$lang[$idioma]['timoford']."</th>
                    <th>".$lang[$idioma]['grandtotal']."</th>
                    <th>".$lang[$idioma]['orderunits']."</th>
					<th>".$lang[$idioma]['ordsou']."</th>
					<th>".$lang[$idioma]['tranum']."</th>
					
                </tr> </thead>
                
			
            ";
	$contador=0;
	$retornar=$retornar."<tbody>";
	$ejecutar=$con->query($squer);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					
					while($row=$ejecutar->fetch_row())
					{
						$contador++;
						if(file_exists('../../../../images/iconosSeller/Channel_'.$row['4'].'.png'))
						{
							$canal='<img src="../../../images/iconosSeller/Channel_'.$row['4'].'.png" style="width:20px; height:20px;"/>';
						}
						else
						{
							$canal=$row['4'];
						}
						$retornar=$retornar."<tr >
								<td><input type=\"checkbox\" id=\"".strtoupper($row['0'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['0'])."').value)\"  value=\"".strtoupper($row['0'])."\" /></td>
								<td hidden=\"hidden\">".($row['0'])."</td>
								<td id=\"numOrd".$contador."\" onMouseOver=\"this.style.cssText='background-color: #afafaf'\" onMouseOut=\"this.style.cssText='background-color: none'\">".($row['0'])."</td>
								<td>".($row['1'])."</td>
								<td>".toMoney(round($row['2'],5,2))."</td>
								<td><center>".number_format($row['3'])."</center></td>
								<td><center>".($canal)."</center></td>
								<td><a>".($row['5'])."</a></td>
								
							  </tr>";
					
					
					}
						}
						($con->close());
					
				}
				else
				{	
					$retornar="Error de llenado de tabla";
				}
					$retornar=$retornar."</tbody></table></div>
			</center>
			
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
	
           </script>";
				
			//	$retornar=$retornar."<div id='ultimoCont' style='display:none;'>".($contador-1)."</div>";
			//	$retornar=$retornar."<div id='ultimoPag' style='display:none;'>".($pag+1)."</div>";	
				echo $retornar;


				
				
?>
