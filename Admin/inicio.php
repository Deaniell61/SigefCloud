<?php 
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('../php/menu/menu.php');
include('../php/sesiones.php');
include('../php/fecha.php');
$idioma=idioma();
include('../php/idiomas/'.$idioma.'.php');

verificar_usuario_admin();
verTiempo();
 ?>

<!doctype html>
<html>
<head>
<link href="../images/GuateIco.ico" type="image/x-icon" rel="shortcut icon" />
<meta charset="utf-8">
<title><?php echo $lang[ $idioma ]['Titulo_Administracion']; ?></title>

<link href="../css/normalize.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/jquery-ui.min.css" type="text/css" />
<link href="../css/main.css" rel="stylesheet" type="text/css">
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/datatables.min.css" rel="stylesheet" type="text/css">
<link href="../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
<link href="../css/estiloForms.css" rel="stylesheet" type="text/css">
<link href="../css/grid.css" rel="stylesheet" type="text/css">
<link href="../php/menu/css/encabezado.css" rel="stylesheet" type="text/css">
<link href="../css/verificar.css" rel="stylesheet" type="text/css">
<link href="../css/botones.css" rel="stylesheet" type="text/css">
<link href="../css/tabla.css" rel="stylesheet" type="text/css">
<link href="../css/textos.css" rel="stylesheet" type="text/css">

<script src="../js/jquery.js"></script>
<script src="../js/jquery-2.2.3.min.js" type="text/javascript"></script>
<script src="../js/jquery.tablesorter.js"></script>
<script src="../js/Jqueryvalidation.js" type="text/javascript"></script>
<script src="../js/jquery-ui.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/funcionesScript.js" type="text/javascript"></script>
<script src="../js/funcionesScriptPermisos.js" type="text/javascript"></script>
<script src="../js/funcionesScriptProveedores.js" type="text/javascript"></script>
<script src="../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script src="../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script src="../js/funcionesScriptAuxOrdenes.js" type="text/javascript"></script>
<script src="../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script src="../js/funcionesScriptBundle.js" type="text/javascript"></script>
<script src="../js/funcionesScriptNotificaciones.js" type="text/javascript"></script>
<script src="../js/funcionesScriptMedidas.js" type="text/javascript"></script>
<script src="../js/funcionesScriptSoporte.js" type="text/javascript"></script>
<script src="../js/funcionesScriptWiki.js" type="text/javascript"></script>
<script src="../js/funcionesScriptAdministradorDB.js" type="text/javascript"></script>
<script src="../js/funcionesScriptOrdenesMod.js" type="text/javascript"></script>
<script  src="../js/datatables.min.js" type="text/javascript"></script>

</head>

<body onLoad="inna();">
<div class="pagina">
	<div id="encabezado">
    
        	<?php ayuda("../images/header.png","window.location.href='inicio.php'","../images/sigef_logo.png");?>
            <ul id="elementoLogin">
            	<strong class="callProfile"><?php echo ucwords(strtolower($_SESSION['nom']))." ".ucwords(strtolower($_SESSION['apel']))."<br>".ucwords(strtolower($_SESSION['nomEmpresa']));?></strong>
            	<a href="../php/logout.php">
                <li>
                <?php echo $lang[ $idioma ]['Cerrar_Sesion']; ?>
                </li>
                </a>
                
             </ul>
    
        <nav>
        	
        	<?php
			menu('admin');
			?>
            
        </nav>
    </div>
    <div id="cuerpo">
    <div id="formulario">
    <br>
    		<nav>
               <!--  <select class='entradaTexto' id="edit" onChange="selecFormulario(document.getElementById('edit').value);">
                	<option value=""><?php echo $lang[ $idioma ]['Editar']; ?></option>
                	<option value="1"><?php echo $lang[ $idioma ]['Usuarios']; ?></option>
                    <option value="2"><?php echo $lang[ $idioma ]['Empresas']; ?></option>
                    <option value="3"><?php echo $lang[ $idioma ]['Modulos']; ?></option>
                    <option value="4"><?php echo $lang[ $idioma ]['Canales']; ?></option>
                    <option value="5"><?php echo $lang[ $idioma ]['Proveedores']; ?></option>
                    <option value="6"><?php echo $lang[ $idioma ]['notificaciones']; ?></option>
                    <option value="7"><?php echo $lang[ $idioma ]['Medidas']; ?></option>
                    <option value="8"><?php echo $lang[ $idioma ]['Tickets']; ?></option>
                    <option value="9"><?php echo $lang[ $idioma ]['ordenes']; ?></option>
                    <option value="10"><?php echo $lang[ $idioma ]['wiki']; ?></option>
                    <option value="11"><?php echo $lang[ $idioma ]['DBManager']; ?></option>
                </select>-->
            </nav>
            
     
        <ul class="nav nav-stacked" id="accordion1">
            <li class="panel panel-default"> <a data-toggle="collapse" data-parent="#accordion1" href="#firstLink"><?php echo $lang[ $idioma ]['Editar']; ?></a>

                <ul id="firstLink" class="collapse in">
                    <center>
                    <table id="formulariosPrincipales">
                    	<tr>
                        	<td><button onClick="selecFormulario('1');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['Usuarios']; ?></button></td>
                            <td><button onClick="selecFormulario('2');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['Empresas']; ?></button></td>
                           <td><button onClick="selecFormulario('3');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['Modulos']; ?></button></td>
                        </tr>
                        <tr>
                        	<td><button onClick="selecFormulario('4');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['Canales']; ?></button></td>
                            <td><button onClick="selecFormulario('5');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['Proveedores']; ?></button></td>
                           <td><button onClick="selecFormulario('6');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['notificaciones']; ?></button></td>
                        </tr>
                         <tr>
                        	<td><button onClick="selecFormulario('7');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['Medidas']; ?></button></td>
                            <td><button onClick="selecFormulario('8');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['Tickets']; ?></button></td>
                            <td><button onClick="selecFormulario('9');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['ordenes']; ?></button></td>
                        </tr>
                        <tr>
                        	<td><button onClick="selecFormulario('10');" class="cmdP button button-highlight button-pill"><?php echo $lang[ $idioma ]['wiki']; ?></button></td>
                            <td><button onClick="selecFormulario('11');" class="button button-highlight button-pill"><?php echo $lang[ $idioma ]['DBManager']; ?></button></td>
                            <td><button onClick="selecFormulario('12');" class=" button button-highlight button-pill"><?php echo $lang[ $idioma ]['ordenesMod']; ?></button></td>
                        </tr>
                    </table>
                    </center>
                    
                    
                </ul>
              
            </li>
            
        </ul>
    
       <br><br>
       <img src="../images/logo.png" width="600" height="250"/>
       <br><br><br>
       

        </div>
        
        
        
        
        </div>
        


  
    
    <footer>
    <?php footer(); ?>
    
    </footer>
</div>
</body>
</html>
<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/profile.php");
?>