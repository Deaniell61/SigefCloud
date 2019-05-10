<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
@$chan=$_POST['chan'];
$pais=$_POST['pais'];
$check=$_POST['check'];

if($check==1)
{
	
	$codChan=$chan;
	$codPar=$_POST['codpar'];
	$factor="(select factor from cat_par_pri where codparpri='".$codPar."')";
	$fac_val="(select fac_val from cat_par_pri where codparpri='".$codPar."')";
	$fac_type="(select fac_type from cat_par_pri where codparpri='".$codPar."')";
	$opera="(select opera from cat_par_pri where codparpri='".$codPar."')";
	$formula="(select formula from cat_par_pri where codparpri='".$codPar."')";
	$cuentacon="(select cuentacon from cat_par_pri where codparpri='".$codPar."')";
	$acosto="(select acosto from cat_par_pri where codparpri='".$codPar."')";
	$aventa="''";
	$registro="(select registro from cat_par_pri where codparpri='".$codPar."')";
	$valregis="(select valregis from cat_par_pri where codparpri='".$codPar."')";
	$forregis="(select forregis from cat_par_pri where codparpri='".$codPar."')";
	$valor_a="(select valor_a from cat_par_pri where codparpri='".$codPar."')";
	$valor_r="(select valor_r from cat_par_pri where codparpri='".$codPar."')";
	$valor_fbg="(select valor_fbg from cat_par_pri where codparpri='".$codPar."')";
	$orden="(select orden from cat_par_pri where codparpri='".$codPar."')";
	$descrip="(select descrip from cat_par_pri where codparpri='".$codPar."')";

	$queryInsert="insert into tra_par_cha(codparcha,codparam,codcanal,factor,fac_val,fac_type,opera,formula,cuentacon,acosto,aventa,registro,valregis,forregis,valor_a,valor_r,valor_fbg,orden,descrip) values('".sys2015()."','".$codPar."','".$codChan."',$factor,$fac_val,$fac_type,$opera,$formula,$cuentacon,$acosto,$aventa,$registro,$valregis,$forregis,$valor_a,$valor_r,$valor_fbg,$orden,$descrip)";
	mysqli_query(conexion($pais),$queryInsert);
	
}
else
{
	if($check==2)
	{
		$codChan=$chan;
	$codPar=$_POST['codpar'];
	$queryInsert="delete from tra_par_cha where codparam='".$codPar."' and codcanal='".$codChan."' ";
	mysqli_query(conexion($pais),$queryInsert);
	}
	else
	{
		$squery="select descrip,codparpri from cat_par_pri order by orden";
		
		echo encabezado().
				tabla($squery,$pais,$chan);
	}
}

function checked($es,$si,$pais)
				{
					$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
						$squery="select codparam,codcanal from tra_par_cha where codparam='$es' and codcanal='$si'";
						if($ejecutar=mysqli_query(conexion($pais),$squery))
						{
							if(mysqli_num_rows($ejecutar)>0)
								{
									return " checked";
								}
						}
				}
				
				
				
function tabla($squer,$pais,$chan)
{
	
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
	$retornar="";
	$retornar=$retornar."<tbody>";
					$ejecutar=mysqli_query(conexion($pais),$squer);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
					
						
						$contador++;
						$retornar=$retornar. "<tr onClick=\"cargarParametros('".$row['codparpri']."','".$chan."','".$pais."');\">
								<td hidden=\"hidden\" ><input id=\"codigo".$contador."\" type=\"text\" readonly value=\"".strtoupper($row['codparpri'])."\" /></td>
								<td>".strtoupper($row['descrip'])."</td>
								<td><input type=\"checkbox\" id=\"".strtoupper($row['codparpri'])."\" onClick=\"agregarParametro(document.getElementById('".strtoupper($row['codparpri'])."').value,document.getElementById('".strtoupper($row['codparpri'])."').checked,'".$pais."')\"".checked($row['codparpri'],$chan,$pais)." value=\"".strtoupper($row['codparpri'])."\" /></td>
							
							  
								</tr>";
							
					}
					$retornar=$retornar. "</tbody></table></div>
              </center><br>
			  
			  <script   type=\"text/javascript\">

           $(document).ready(function(){
    
   $('#tablas').DataTable( {
        \"scrollY\":        \"250px\",
        \"scrollX\": true,
        \"paging\":         false,
        \"info\":     false
        
         
    } );
});
           </script>";
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
			<div style=\"overflow-y: scroll;overflow-x: hidden; height: 250px;\">
        	<table id=\"tablaParametros\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"\">
				<thead width=\"100%\">
            	<tr class=\"titulo\">
					<th hidden=\"hidden\">".$lang[$idioma]['Codigo']."</th>
                    <th>".$lang[$idioma]['Nombre']."</th>
                    <th class=\"check\"><img src=\"../../../images/yes.jpg\" /></th>
                    
                </tr></thead>
                
            ";
}
?>