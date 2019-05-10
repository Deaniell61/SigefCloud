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
<link href="../../images/<?php echo limpiar_caracteres_especiales($_SESSION['pais']); ?>.ico" type="image/x-icon" rel="shortcut icon" />
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
<script  src="../../js/funcionesScriptNotificaciones.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
Full();

</script>

</head>

<body onLoad="javascript:envioDeDataNotificaciones('Notificaciones');inna();">
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
		

   
            <form id="notificacion" name="notificacion" action="return false" onSubmit="return false" method="POST">
                                <center>
                    <table>
                        <tr>
                        <td colspan="2"> <center><?php echo $lang[$idioma]['notificaciones']?></center></td>
                            
                            </tr>
                            <tr> <td colspan="2"><center><div id="resultado"></div> </center></td></tr>
                            <tr><td colspan="2"><input type="text" class='entradaTexto' hidden="hidden" name="codigo" id="codigo" value="" disabled/></td> </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Notifica'];?></span></td>
                            <td><input type="text" class='entradaTexto textoGrande' id="notifica" value="" autofocus ></td>
                        </tr>
                        
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['FechaIni'];?></span></td>
                            <td><input type="date" class='entradaTexto' id="fechaini" value="" ></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['FechaFin'];?></span></td>
                            <td><input type="date" class='entradaTexto' id="fechafin" value="" ></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Condicion'];?></span></td>
                            <td><input type="number" min="0" max="100" class='entradaTexto' id="condicion" value="" ></td>
                        </tr>
                        <tr>
                        
                            <td class="text"><span><?php echo $lang[$idioma]['Destino'];?></span></td>
                            <td><input class='entradaTexto' type="number" min="0" max="100" id="destino" value=""  ></td>
                        </tr>
                         
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Estado'];?></span></td>
                            <td>
                                <select class='entradaTexto' id="estado" style="width:calc(90% +15px);">
                        <option value="1"><?php echo $lang[$idioma]['Activo'];?></option>
						<option value="0"><?php echo $lang[$idioma]['Inactivo'];?></option>
                        <option value="2"><?php echo $lang[$idioma]['Registro'];?></option>
                        <option value="21"><?php echo $lang[$idioma]['Pendiente'];?></option>
                                </select>
                            </td>
                        </tr>
                                                            
                                    
                        <tr>
            
                        <td colspan="2">
                        <center>
                        <input type="button"  class='cmd button button-highlight button-pill' onClick="ingresoNotificacion();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
                            <input type="reset"   class='cmd button button-highlight button-pill' onClick="envioDeData('user');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
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
