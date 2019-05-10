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



  $squery="select tp.codtrapre,tp.de,tp.a,tp.precio,tp.codunidades from tra_pre_dis tp where (tp.de like '%".$nombre."%' or tp.a like '%".$nombre."%' or tp.precio like '%".$nombre."%') and codprod='".$_SESSION['codprod']."' ";

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
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
					
												
						$contador++;
						$retornar=$retornar. "<tr onClick=\"nuevoDistribucion('".$row['0']."','".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".@$_SESSION['codprov']."','".$_SESSION['codprod']."');\">
								<td  width='20%'><input type=\"checkbox\" id=\"".($row['0'])."\" onClick=\"agregarAccesos(document.getElementById('".($row['0'])."').value)\"  value=\"".($row['0'])."\" /></td>
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".($row['0'])."\" /></td>
								<td  width='10%'>".($row['1'])."</td>
								<td  width='20%'>".($row['2'])."</td>
								<td  width='35%'>".toMoney($row['3'])."</td>
								
								
							
							  
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
						$retornar="<tr><td colspan=\"5\"><center><span style=\"font-size:25px;\">".$lang[$idioma]['NoEncontradoDist']."</span></center></td></tr>";
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
                	<th  width='10%' class=\"check\"><img src=\"../../images/yes.jpg\" style=\"width: 15px;height: 15px;\"/></th>
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
                    <th  width='35%'>".$lang[$idioma]['De']."</th>
                    <th  width='25%'>".$lang[$idioma]['A']."</th>
                    <th  width='35%'>".$lang[$idioma]['Precio']."</th>
					
					
                </tr></thead>
                
            ";
}

				
?>
