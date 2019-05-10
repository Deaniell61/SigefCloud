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
<script  src="../../js/funcionesScriptOrdenes.js" type="text/javascript"></script>
<script src="../../js/datatables.min.js" type="text/javascript"></script>


<script language="JavaScript" type="text/JavaScript">
Full();
function configuraTabla()
{
		
                    $('#tablas').DataTable( {
                        "scrollY": "200px",
                        "scrollX": true,
                        "paging":  true,
                        "info":     false,
                        "oLanguage": {
                        "sLengthMenu": " _MENU_ ",
                        }
                    });
                    ejecutarpie();
                
}
function configuraTabla2()
{
		
                    $('#tablas2').DataTable( {
                        "scrollY": "100px",
                        "scrollX": true,
                        "paging":  true,
                        "info":     false,
                        "oLanguage": {
                        "sLengthMenu": " _MENU_ ",
                        }
                    });
                    ejecutarpie2();
                
}
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
            	<a onClick="window.close();">
                <li>
                <?php echo $lang[ $idioma ]['Salir']; ?>
                </li>
                </a>
             </ul>
    	</header>
    	 <div id="ordenes">
		

   
            <form id="notificacion" name="notificacion" action="return false" onSubmit="return false" method="POST">
                                <center>
                    <table>
                        <tr>
                        <td colspan="4"><strong> <center><?php echo $lang[$idioma]['Order']?></center></strong></td>
                            
                            </tr>
                        <tr hidden>
                        <td colspan="4"> <center><img src="../../images/iconosSeller/Channel_Local_Store.png" id="logoLocation" style="width:20px; height:20px;"/></center></td>
                            
                            </tr>
                            <tr>
                        <td class="text"> 
                        	<?php echo $lang[$idioma]['Nombre']?>
                        </td>
                        <td colspan="1"> 
                        <strong>
                        	<div class='entradaTexto textoGrande' id="Nombre" style="text-align:left; padding-left:10px;"></div>
                        </strong>
                        </td>
                        <td class="text"> 
                        	<?php echo $lang[$idioma]['Estado']?>
                        </td>
                        <td colspan="1"> 
                        <strong>
                        	<div class='entradaTexto textoGrande' id="Estado" style="text-align:left; padding-left:10px;"></div>
                        </strong>
                        </td>
                            
                            </tr>
                            <tr>
                        <td class="text"> 
                        	<?php echo $lang[$idioma]['Order']?>
                        </td>
                        <td colspan="1"> 
                        <strong>
                        	<div class='entradaTexto textoGrande' id="numeroOrden" style="text-align:left; padding-left:10px;"></div>
                        </strong>
                        </td>
                        <td class="text"> 
                        	<?php echo $lang[$idioma]['tranum']?>
                        </td>
                        <td colspan="1"> 
                        <strong>
                        	<div class='entradaTexto textoGrande' id="numeroTraking" style="text-align:left; padding-left:10px;"></div>
                        </strong>
                        </td>
                            
                            </tr>
                            <tr> <td colspan="4"><center><div id="resultado"></div> </center></td></tr>
                            <tr><td colspan="4"><input type="text" class='entradaTexto' hidden="hidden" name="codigo" id="codigo" value="" disabled/></td> </tr>
                        <tr hidden>
                            <td class="text"><span></span></td>
                            <td></td>
                       		<td class="text"><span><?php echo $lang[$idioma]['shifee'];?></span></td>
                            <td><input type="text" class='entradaTexto textoGrande' id="shipping" disabled ></td>
                       			
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['timoford'];?></span></td>
                            <td style="padding-bottom:5px;"><input type="text" class='entradaTexto textoGrande' id="timoford" disabled></td>
                       		<td class="text"></td>
                            <td></td>
                       			
                        </tr>
                       <tr>
                       		<td class="text"><span><?php echo $lang[$idioma]['grandtotal'];?></span></td>
                            <td><input type="text" class='entradaTexto textoGrande' id="grandtotal" disabled ></td>
                            <td class="text"><span></span></td>
                            <td></td>
                       </tr>
                        
                            
                        <tr>
            
                        <td colspan="4">
                        <center>
                        		<div id="ordenesCont">
                                <script>llenarTablaOrdenes('<?php echo $_GET['codigo'];?>','<?php echo $_GET['pais'];?>','<?php echo $_GET['cod'];?>');</script>
                                </div>
                      
                            </center>
                        </td>
                        
                         </tr>
                         <tr>
                         <td colspan="4">
                         	
                         </td>
                         </tr>
                         
                         
                        <!-- <td colspan="4">
                        <center>
                        <input type="button"  class='cmd button button-highlight button-pill' onClick="ingresoNotificacion();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
                            <input type="reset"   class='cmd button button-highlight button-pill' onClick="envioDeData('user');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
                            </center>
                        </td>
                        
                         </tr>-->
                    </table>
                    <center>
                    <div>
                    <div id="totalCatgos"></div>
                            	<div id="cargosOrden" style="width: 40%; float: left; margin-left: 10%;position: relative;">
								<script>llenarTablaCargosOrdenes('<?php echo $_GET['codigo'];?>','<?php echo $_GET['pais'];?>','<?php echo $_GET['cod'];?>');</script>
                                	 
                                </div>
                               </div>
                            </center>
                    </center>
                            </form>
                            <br>
         



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
