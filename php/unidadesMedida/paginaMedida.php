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
$_SESSION['pais']=$_GET['pais'];
$_SESSION['codPais']=$_GET['cod'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lang[ $idioma ]['notificaciones']; ?></title>
<link href="../../images/GuateIco.ico" type="image/x-icon" rel="shortcut icon" />
<link href="../../css/estiloProveedor.css" rel="stylesheet" type="text/css">
<link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
<link href="../../css/grid.css" rel="stylesheet" type="text/css">
<link href="../menu/css/encabezado.css" rel="stylesheet" type="text/css">
<link href="../../Inicio/css/productos.css" rel="stylesheet" type="text/css">
<link href="../../css/verificar.css" rel="stylesheet" type="text/css">
<link href="../../css/botones.css" rel="stylesheet" type="text/css">
<link href="../../css/textos.css" rel="stylesheet" type="text/css">
<link href="../../css/tabla.css" rel="stylesheet" type="text/css">
<link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css" />

<script type="text/javascript" src="../../js/jquery-2.2.3.min.js"></script>
<script  src="../../js/jquery-ui.min.js" type="text/javascript"></script>
<script  src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script  src="../../js/funcionesScript.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptProveedores.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script  src="../../js/funcionesScriptMedidas.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
Full();

</script>

</head>

<body onLoad="javascript:envioDeDataMedidas('Medidas');inna();">
<div class="pagina">
	<div id="cuerpo">
    <header>
    		<?php ayuda("../../images/header.png","","../../images/sigef_logo.png");?>
            <ul id="elementoLogin">
            	<?php if(isset($_SESSION['nom']) and isset($_SESSION['apel']))
				{?>
            	<strong><?php echo ucwords(strtolower($_SESSION['nom']))." ".ucwords(strtolower($_SESSION['apel']));?></strong><?php }?>
            	<a onClick="window.close();">
                <li>
                <?php echo $lang[ $idioma ]['Salir']; ?>
                </li>
                </a>
             </ul>
    	</header>
    	 <div id="formulario">
		

   
            <form id="Medidas" name="Medidas" action="return false" onSubmit="return false" method="POST">
                                <center>
                    <table>
                        <tr>
                        <td colspan="2"> <center><?php echo $lang[$idioma]['Medidas']?></center></td>
                            
                            </tr>
                            <tr> <td colspan="2"><center><div id="resultado"></div> </center></td></tr>
                            <tr><td colspan="2"><input type="text" class='entradaTexto' hidden="hidden" name="codigo" id="codigo" value="" disabled/></td> </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Nombre'];?></span></td>
                            <td><input type="text" class='entradaTexto textoGrande' id="nombre" value="" autofocus ></td>
                        </tr>
                        
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Abre'];?></span></td>
                            <td><input type="text" class='entradaTexto' id="abre" value="" ></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Factor'];?></span></td>
                            <td><input type="number" class='entradaTexto' id="factor" value="" ></td>
                        </tr>
                        
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Opera'];?></span></td>
                            <td>
                                <select class='entradaTexto' id="opera" style="width:calc(90% +15px);">
                        <option value="*"><?php echo $lang[$idioma]['*'];?></option>
						<option value="mas"><?php echo $lang[$idioma]['+'];?></option>
                        <option value="/"><?php echo $lang[$idioma]['/'];?></option>
                        <option value="-"><?php echo $lang[$idioma]['-'];?></option>
                                </select>
                            </td>
                        </tr>
                                                            
                                    
                        <tr>
            
                        <td colspan="2">
                        <center>
                        <input type="button"  class='cmd button button-highlight button-pill' onClick="ingresoMedidas();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
                            <input type="reset"   class='cmd button button-highlight button-pill' onClick="location.reload();" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
                            </center>
                        </td>
                        
                         </tr>
                    </table>
                    </center>
                            </form>
                            <br>
         



		</div>
	</div>
    <footer>
    <?php footer(); ?>
    </footer>	
</div>
<div id="mensajeProv"></div>
<div id="cargaLoad"></div>
</body>
</html>
