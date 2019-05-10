<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$pais= $_SESSION['pais'];
$codpais= $_SESSION['CodPaisCod'];
$bodega= $_POST['bodega'];
//$fecha=getdate();

if($bodega!="")
{
	
	$squery="select p.prodname,sum(t.existencia),p.prodname from tra_exi_pro t inner join cat_bodegas b on b.codbodega=t.codbodega inner join cat_prod p on t.codprod=p.codprod where p.codprov='".$_SESSION['codprov']."' and b.codbodega='".$bodega."' group by p.mastersku order by p.mastersku;";
}
else
{
	 $squery="select p.prodname,sum(t.existencia),p.prodname from tra_exi_pro t inner join cat_bodegas b on b.codbodega=t.codbodega inner join cat_prod p on t.codprod=p.codprod where p.codprov='".$_SESSION['codprov']."' group by p.mastersku order by p.mastersku;";
}
//echo $squery;
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
						
						
						$contador++;
						setlocale(LC_MONETARY, 'en_US');
						$retornar=$retornar."<tr >
								<td><input type=\"checkbox\" id=\"".strtoupper($row['0'])."\"  onClick=\"agregarAccesos(document.getElementById('".strtoupper($row['0'])."').value)\"  value=\"".strtoupper($row['0'])."\" /></td>
								<td hidden=\"hidden\">".($row['0'])."</td>
								<td>".($row['2'])."</td>
								<td><center>".ceil($row['1'])."</center></td>
								
								
							  </tr>";
					
					}//str_replace("$","",toMoney($row['1']))
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
               <img src=\"../images/excel.png\" id=\"exportExcel\" onClick=\"llamarReporte(14,document.getElementById('FechaIniD').innerHTML)\" style=\"width:20px; height:20px; float:right; margin-left:5px;margin-top:5px; cursor:pointer;\">

               </div>
        	<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
			
            	
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
					<th >".$lang[$idioma]['Bodegas']."</th>
					<th>".$lang[$idioma]['Existencia']."</th>
					
                </tr> </thead>
                
			
            ";
}

				
				
?>
