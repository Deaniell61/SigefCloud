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
session_start();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lang[ $idioma ]['cataux']; ?></title>
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
<link href="../../css/textos.css" rel="stylesheet" type="text/css">
<link href="../../php/bancos/css/estilo.css" rel="stylesheet" type="text/css">


<script src="../../js/jquery.js"></script>
<script src="../../js/jquery-2.2.3.min.js" type="text/javascript"></script>
<script  src="../../js/jquery-ui.min.js" type="text/javascript"></script>
<script  src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script  src="../../js/funcionesScript.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptUsuarioLogiado.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptProveedores.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script src="../../js/funcionesScriptProductos.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptAuxOrdenes.js" type="text/javascript"></script>


<script language="JavaScript" type="text/JavaScript">
Full();
function configuraTabla()
{
		
                    $('#tablas').DataTable( {
                        "scrollY": "300px",
                        "scrollX": true,
                        "paging":  true,
                        "info":     false,
                        "oLanguage": {
                        "sLengthMenu": " _MENU_ ",
                        }
                    });
                    ejecutarpie();
                
}
</script>

</head>

<body onLoad="javascript:envioDeDataAuxOrdenes('');inna();">
<div class="pagina">
	<div id="cuerpo">
    <header>
    		<?php ayuda("../../images/header.png","","../../images/sigef_logo.png");?>
            <ul id="elementoLogin">
            	<?php if(isset($_SESSION['nom']) and isset($_SESSION['apel']))
				{?>
            	 <strong><?php echo ucwords(strtolower($_SESSION['nom'])) . " " . ucwords(strtolower($_SESSION['apel'])) . "<br>" . ucwords(strtolower($_SESSION['nomEmpresa'])) . "<br>" . ucwords(strtolower($_SESSION['nomProv'])); ?></strong><?php }?>
            	<a onClick="window.close();">
                <li>
                <?php echo $lang[ $idioma ]['Salir']; ?>
                </li>
                </a>
             </ul>
    	</header>
    	 <div id="ordenesAux">
		

   
            
         



		</div>
	</div>
    <footer>
    <?php footer(); ?>
    </footer>	
</div>

<div id="cargaLoad"></div>
</body>
</html>
