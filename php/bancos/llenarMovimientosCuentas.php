<?php
require_once('../coneccion.php');
require_once('../fecha.php');

$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## ejecución de la sentencia sql
$squery="select cc.codcuen as codigo,cc.numcuen as cuenta,cc.nombre as nombre,(select cb.nombre from cat_banc cb where cb.codbanc=cc.codbanc) as banco from cat_cuen cc where codprov='".$_SESSION['codprov']."'";
echo encabezado().
tabla($squery);
		
		function tabla($squer)
{
	$retornar="";
	$retornar=$retornar."<tbody>";
	$ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer);

		if($ejecutar)
		{
			while($row=mysqli_fetch_array($ejecutar,MYSQL_ASSOC))
			{
				if($ejecutar->num_rows>0)
				{
					$retornar.="<tr onclick=\"abrirMoviemientoscuen('movimientoscuen', '".$row['codigo']."')\";>
									
									<td></td>
									<td hidden>".$row['codigo']."</td>
									<td>".$row['cuenta']."</td>
									<td>".$row['nombre']."</td>
									<td>".$row['banco']."</td>
									<td></td>
								</tr>
								";
				}
			}

		}
		$retornar.="</tbody></table></div></center>

			<script   type=\"text/javascript\">

           $(document).ready(function(){
    
   $('#tablas').DataTable( {
        \"scrollY\":        \"500px\",
        \"scrollX\": true,
        \"paging\":         true,
        \"info\":     false
        
         
    } );
});
           </script>
           </div>";
		
				return $retornar;
}

function encabezado()
{
	return "
	<div id='datos'>
	<center>
			<div>
        	<table id=\"tablas\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"hover tablas table\">
				<thead>
				<tr  class=\"titulo\">
                	<th class=\"check\"><img src=\"../images/yes.jpg\"/></th>
					<th hidden=\"hidden\">Codigo</th>
					<th>Numero de la Cuenta</th>
					<th>Nombre de la Cuenta</th>
					<th>Banco</th>
                    <th>Logo</th>
					
                </tr> </thead>
            ";
}
?>
