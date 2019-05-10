<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
function estado1($es,$si)
				{
					$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
						if($es==$si)
						{
							return $lang[$idioma]['Activo'];
						}
						else
						{
							return $lang[$idioma]['Inactivo'];
						}
				}
				
				


## usuario y clave pasados por el formulario
$nombre= ucwords($_POST['nombre']);
$canal= ucwords($_POST['canal']);
$mas="";

if($_SESSION['codprov']!="")
{
	$mas="ts.codprov!='' and ";
}

if($nombre==NULL && $canal==NULL)
{
	$squery="select ts.codprecom as codseller,s.nombre as nombre,c.codchan,c.channel as channel,ts.fecha,ts.unidades,ts.preciomin as pmin,ts.preciomax as pmax,ts.shipping as shipping,ts.aplica,ts.asin,ts.azsku,ts.azname from tra_pre_com ts inner join cat_sellers s on s.codseller=ts.codcompe inner join cat_sal_cha c on ts.codcanal=c.codchan where ".$mas."((ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."') or (ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."' and ts.codprov='".$_SESSION['codprov']."')) ";
	
	 
}
else if($nombre==NULL && $canal!=NULL)
{
	$squery="select ts.codprecom as codseller,s.nombre as nombre,c.codchan,c.channel as channel,ts.fecha,ts.unidades,ts.preciomin as pmin,ts.preciomax as pmax,ts.shipping as shipping,ts.aplica,ts.asin,ts.azsku,ts.azname from tra_pre_com ts inner join cat_sellers s on s.codseller=ts.codcompe inner join cat_sal_cha c on ts.codcanal=c.codchan where ".$mas."((ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."') or (ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."' and ts.codprov='".$_SESSION['codprov']."')) and c.channel='".$canal."'";
}
else if($nombre!=NULL && $canal==NULL)
{
	$squery="select ts.codprecom as codseller,s.nombre as nombre,c.codchan,c.channel as channel,ts.fecha,ts.unidades,ts.preciomin as pmin,ts.preciomax as pmax,ts.shipping as shipping,ts.aplica,ts.asin,ts.azsku,ts.azname from tra_pre_com ts inner join cat_sellers s on s.codseller=ts.codcompe inner join cat_sal_cha c on ts.codcanal=c.codchan where ".$mas."((ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."') or (ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."' and ts.codprov='".$_SESSION['codprov']."')) and s.nombre like '%".$nombre."%'";
}
else if($nombre!=NULL && $canal!=NULL)
{
	$squery="select ts.codprecom as codseller,s.nombre as nombre,c.codchan,c.channel as channel,ts.fecha,ts.unidades,ts.preciomin as pmin,ts.preciomax as pmax,ts.shipping as shipping,ts.aplica,ts.asin,ts.azsku,ts.azname from tra_pre_com ts inner join cat_sellers s on s.codseller=ts.codcompe inner join cat_sal_cha c on ts.codcanal=c.codchan where ".$mas."((ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."') or (ts.codempresa='".$_SESSION['codEmpresa']."' and ts.codprod='".$_SESSION['codprod']."' and ts.codprov='".$_SESSION['codprov']."')) and c.channel='".$canal."' and s.nombre='".$nombre."'";
}

echo encabezado().
		tabla($squery);
				
function tabla($squer)
{
	
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	$retornar="";
	$retornar=$retornar."<tbody>";
					$ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
												
						$contador++;
						$retornar=$retornar. "<tr onClick=\"nuevoSeller('".$row['codseller']."','".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".@$_SESSION['codprov']."','".$_SESSION['codprod']."');\">
								<td  width='20%'><input type=\"checkbox\" id=\"".($row['codseller'])."\" onClick=\"agregarAccesos(document.getElementById('".($row['codseller'])."').value)\"  value=\"".($row['codseller'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".($row['codseller'])."\" /></td>
								<td  width='35%'>".($row['nombre'])."</td>
								<td  width='20%'>".($row['fecha'])."</td>
								<td  width='35%'>".($row['pmin'])."</td>
								<th  width='35%'d>".($row['shipping'])."</td>
								
							
							  
								</tr>";
							
					}
					$retornar=$retornar. "</tbody></table></div>
              
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

           </script>
			</center>";
					}
					else
					{
						$retornar="<tr><td colspan=\"4\"><center><span style=\"font-size:25px;\">".$lang[$idioma]['NoEncontradoCompe']."</span></center></td></tr>";
					}
					
				}
				else
				{	
					$retornar= "Error";
				}
				
				return $retornar;
}
function encabezado()
{
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	return "<center>
	<link href=\"../../css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\">	
	<link href=\"../../css/datatables.min.css\" rel=\"stylesheet\" type=\"text/css\">
			<div>
        	<table id=\"tablas\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
				<thead>
            	<tr class=\"titulo\" >
                	<th  width='20%' class=\"check\"><img src=\"../../images/yes.jpg\" style=\"width: 15px;height: 15px;\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
                    <th  width='35%'>".$lang[$idioma]['Nombre']."</th>
                    <th  width='25%'>".$lang[$idioma]['Fecha']."</th>
                    <th  width='35%'>".$lang[$idioma]['Precio']."</th>
					<th  width='35%'>".$lang[$idioma]['shipping']."</th>
					
                </tr></thead>
                
            ";
}
				
?>
