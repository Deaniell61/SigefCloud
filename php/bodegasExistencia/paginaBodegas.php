<?php 
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
/*Pagina principal de proveedores*/

require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
require_once('../productos/combosProductos.php');
session_start();
$pais=$_GET['pais'];
$prov=$_GET['prov'];
$cod=$_GET['codigo'];

$hoy=date('Y-m-d');

$nuevafecha2 = strtotime ( '-90 day' , strtotime ( $hoy ) ) ;
$diasatras = date ( 'Y-m-d' , $nuevafecha2 );
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lang[ $idioma ]['notificaciones']; ?></title>
<link href="../../images/<?php echo limpiar_caracteres_especiales($_SESSION['pais']); ?>.ico" type="image/x-icon" rel="shortcut icon" />
<link href="../../css/normalize.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css"/>
<link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
<link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
<link href="../../css/grid.css" rel="stylesheet" type="text/css">
<link href="../../php/menu/css/encabezado.css" rel="stylesheet" type="text/css">
<link href="../../css/verificar.css" rel="stylesheet" type="text/css">
<link href="../../css/main.css" rel="stylesheet" type="text/css">
<link href="../../css/botones.css" rel="stylesheet" type="text/css">
<link href="../../css/tabla.css" rel="stylesheet" type="text/css">
<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../css/datatables.min.css" rel="stylesheet" type="text/css">
<link href="../../css/textos.css" rel="stylesheet" type="text/css">
<link href="../../php/bancos/css/estilo.css" rel="stylesheet" type="text/css">
<link href="../../css/lib/font-awesome.min.css" rel="stylesheet" type="text/css">


<script src="../../js/jquery.js"></script>
<script src="../../js/jquery-2.2.3.min.js" type="text/javascript"></script>
<script  src="../../js/jquery-ui.min.js" type="text/javascript"></script>
<script  src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script  src="../../js/funcionesScript.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptProveedores.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script src="../../js/funcionesScriptProductos.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptBodegasExistencia.js" type="text/javascript"></script>
<script src="../../js/datatables.min.js" type="text/javascript"></script>


<script language="JavaScript" type="text/JavaScript">
Full();

</script>

</head>

<body onLoad="javascript:envioDeDataOrdenes('Notificaciones');inna();">
<div class="pagina">
	<div id="cuerpo">
    <header>
    		<?php ayuda("../../images/header.png","","../../images/sigef_logo.png");?>
            <ul id="elementoLogin">
            	<?php if(isset($_SESSION['nom']) and isset($_SESSION['apel']))
				{?>
            	 <strong><?php echo ucwords(strtolower($_SESSION['nom'])) . " " . ucwords(strtolower($_SESSION['apel'])) . "<br>" . ucwords(strtolower($_SESSION['nomEmpresa'])) . "<br>" . ucwords(strtolower($_SESSION['nomProv'])); ?></strong><?php }?>
            	
             </ul>
    	</header>
    	 <div id="Bodegas">
		 <div class="text-left">
                <input type="button" class='cmd button button-highlight button-pill'
                            value="<?php echo $lang[$idioma]['Salir']; ?>" onClick="window.close();"/>
</div>
         <center>
		<div class="combosCentrar">
        	<div class="colIz">
			<?php echo $lang[ $idioma ]['PeriIni']; ?> <br>
                   
                    	
                        <input type="date" class='entradaTexto' value="<?php echo $diasatras; ?>" style="width:100%" id="periIni" onChange="verificaPeriodo(document.getElementById('periFin'));">
             </div>
             <div class="colDer">
             <?php echo $lang[ $idioma ]['PeriFin']; ?> <br>
            
                    <input type="date" class='entradaTexto' value="<?php echo $hoy; ?>" style="width:100%" id="periFin" onChange="verificaPeriodo(this);">
             </div>
             <center style="margin-right: 40px;">
             <div class="col2"><br>
             	<input type="button" class='cmd button button-highlight button-pill' value="<?php echo $lang[$idioma]['Generar'];?>" onClick="__('tabsBodegas').style.display='block';llenarDatosBodegas('<?php echo $cod; ?>','<?php echo $pais; ?>','<?php echo $prov; ?>');">  
          
             </div>
             </center><br>
        </div>
        </center>
			<div id="tabsBodegas" style="display:none;">
  <ul>
  	<?php
		pestanasBodegas($cod,$pais);
	?>
    </ul>
  
  <div id="contPestanas">
  </div>
</div>


		</div>
	</div>
    <footer style="margin-top:16%;">
    <?php footer(); ?>
    </footer>	
</div>
<div id="mensajeProv"></div>
<div id="cargaLoad"></div>
</body>
</html>
<script>



</script>
<?php
function pestanasBodegas($prod,$pais)
{
require_once("../coneccion.php");
	$sqlBodegas="select codbodega from tra_exi_pro where codprod='".$prod."' ";
	$conP=conexion($pais);	
	$conts="";
	$cont=0;
	if($eBodegas=mysqli_query($conP,$sqlBodegas))
	{
		while($bodegas=mysqli_fetch_array($eBodegas,MYSQLI_NUM))
		{
			 $sqlBodega="select codbodega,nombre from cat_bodegas where codbodega='".$bodegas[0]."'; ";
			$con=conexion("");
			
			if($eBodega=mysqli_query($con,$sqlBodega))
			{
				while($bodega=mysqli_fetch_array($eBodega,MYSQLI_NUM))
				{
					$cont++;
					echo "<li><a href=\"#".$bodega[0].$cont."\">".$bodega[1]."</a></li>";
					
				}
			}
			mysqli_close($con);
			
		}
		mysqli_close($conP);
	}
	
	
		
}
?>