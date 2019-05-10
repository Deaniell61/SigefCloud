<?php
require_once('../../../coneccion.php');
require_once('../../../fecha.php');
require_once('../../../funciones.php');
$idioma=idioma();
include('../../../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$periFin= $_POST['periFin'];
$periIni= $_POST['periIni'];
//$fecha=getdate();
session_start();
$fecha = date('Y-m-d');
$pais=$_SESSION['pais'];
$con=conexion($_SESSION['pais']);
$oculta="";
$qOrdenes="SELECT od.productid,od.disnam,sum(od.qty) as qty,sum(od.linetotal) as total,(select (select ct.nombre from cat_cat_pro ct where ct.codcate=p.categori) from cat_prod p where p.mastersku=od.productid) as categoria FROM tra_ord_det od , tra_ord_enc oe where oe.codorden=od.CODORDEN and (oe.TIMOFORD >= '".$periIni."' and oe.TIMOFORD <= '".$periFin."') group by productid ";
$rOrdenes=getArrayBD($qOrdenes,$con);
$TDetalleOrd = array();
$i=0;
$where="";
?>
<script>
	$(document).ready(function(){
    
   $('#tablas').DataTable( {
        "scrollY": "300px",
        "scrollX": true,
        "paging":  true,
        "info":     false,
        "oLanguage": {
      "sLengthMenu": " _MENU_ ",
      
  
      
    }
        
         
         
    } );
	$('#tablas2').DataTable( {
        "scrollY": "300px",
        "scrollX": true,
        "paging":  true,
        "info":     false,
        "oLanguage": {
      "sLengthMenu": " _MENU_ ",
      
  
      
    }
        
         
         
    } );
    
  ejecutarpie();
   ejecutarpie2();
     
});
</script>
<div id="tabla1" class="s6">
	
<table  id="tablas" border="0" width="100%" cellspacing="0" cellpadding="0" class="hover tablas table">
	<thead>
	  <tr>
		<th>
			No.
		</th>
		<th>
			ProductID
		</th>
		<th>
			DisplayName
		</th>
		<th>
			Unidades
		</th>
		<th>
			Valor
		</th>
		<th>
			Categoria
		</th>
	  </tr>
	</thead>
	<tbody>
<?php
$cont=0;
	foreach($rOrdenes as $Ordenes){
		$cont++;
		echo "<tr>
			<td style=\"text-align: left;\">".$cont."</td>
			<td style=\"text-align: left;\">".$Ordenes['productid']."</td>
			<td style=\"text-align: left;\">".$Ordenes['disnam']."</td>
			<td>".$Ordenes['qty']."</td>
			<td style=\"text-align: left;\">".toMoney($Ordenes['total'])."</td>
			<td style=\"text-align: left;\">".$Ordenes['categoria']."</td>
		</tr>";
	}
?>
	</tbody>
</table>

</div>

<div id="totales" class="s5">
	
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="hover tablas table">
	
	<tbody>
	<?php
	$qTotales="SELECT count(od.qty) as ordenes,sum(od.qty) as cantidad,sum(od.linetotal) as total FROM tra_ord_det od , tra_ord_enc oe where oe.codorden=od.CODORDEN and (oe.TIMOFORD >= '".$periIni."' and oe.TIMOFORD <= '".$periFin."')";
	$rTotales=getArrayBD($qTotales,$con);
		$cont=0;
	foreach($rTotales as $Totales){
		$cont++;
		echo "<tr>
			<td style=\"text-align: left;\">".$Totales['ordenes']."</td>
			<td style=\"text-align: left;\">Ordenes</td>
			<td style=\"text-align: left;\">Totales</td>
			<td>".$Totales['cantidad']."</td>
			<td style=\"text-align: left;\">".toMoney($Totales['total'])."</td>
			
		</tr>";
	}
		?>
	</tbody>
</table>

</div>
<!--
<div id="tabla2" class="s6">
	
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="hover tablas table">
	
	<tbody>
		<tr>
			<td>
				1
			</td>
			<td>
				300147
			</td>
			<td>
				De la cruz
			</td>
			<td>
				9
			</td>
			<td>
				37
			</td>
			<td>
				Medicina
			</td>
			
		</tr>
	</tbody>
</table>

</div>

<div id="tabla3" class="s5 frigth5" >
	
<table id="tabla2" border="0" width="100%" cellspacing="0" cellpadding="0" class="hover tablas table">
	<thead>
	  <tr>
		<th>
			No.
		</th>
		<th>
			ProductID
		</th>
		<th>
			DisplayName
		</th>
		<th>
			Unidades
		</th>
		<th>
			Valor
		</th>
		<th>
			Categoria
		</th>
	  </tr>
	</thead>
	<tbody>
		<tr>
			<td>
				1
			</td>
			<td>
				300147
			</td>
			<td>
				De la cruz
			</td>
			<td>
				9
			</td>
			<td>
				37
			</td>
			<td>
				Medicina
			</td>
			
		</tr>
	</tbody>
</table>

</div>

<div id="tabla4" class="s6">
	
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="hover tablas table">
	
	<tbody>
		<tr>
			<td>
				1
			</td>
			<td>
				300147
			</td>
			<td>
				De la cruz
			</td>
			<td>
				9
			</td>
			<td>
				37
			</td>
			<td>
				Medicina
			</td>
			
		</tr>
	</tbody>
</table>

</div>-->
<script>
	$("#cargaLoadVP").dialog("close");
</script>