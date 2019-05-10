<?php 
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
/*Pagina principal de proveedores*/

require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
$pais=$_SESSION['pais']=$_GET['pais'];
$estado=$_GET['estado'];
$inicio=$_GET['inicio'];
$final=$_GET['final'];
$tipo=$_GET['tipo'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lang[ $idioma ]['notificaciones']; ?></title>
<link href="../../../images/<?php echo limpiar_caracteres_especiales($_SESSION['pais']); ?>.ico" type="image/x-icon" rel="shortcut icon" />
<link href="../../../css/normalize.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../../../css/jquery-ui.min.css" type="text/css"/>
<link href="../../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
<link href="../../../css/estiloForms.css" rel="stylesheet" type="text/css">
<link href="../../../css/grid.css" rel="stylesheet" type="text/css">
<link href="../../../php/menu/css/encabezado.css" rel="stylesheet" type="text/css">
<link href="../../../css/verificar.css" rel="stylesheet" type="text/css">
<link href="../../../css/main.css" rel="stylesheet" type="text/css">
<link href="../../../css/botones.css" rel="stylesheet" type="text/css">
<link href="../../../css/tabla.css" rel="stylesheet" type="text/css">
<link href="../../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../../css/datatables.min.css" rel="stylesheet" type="text/css">
<link href="../../../css/textos.css" rel="stylesheet" type="text/css">
<link href="../../../php/bancos/css/estilo.css" rel="stylesheet" type="text/css">
<link href="../../../css/lib/font-awesome.min.css" rel="stylesheet" type="text/css">


<script src="../../../js/jquery.js"></script>
<script src="../../../js/jquery-2.2.3.min.js" type="text/javascript"></script>
<script  src="../../../js/jquery-ui.min.js" type="text/javascript"></script>
<script  src="../../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script  src="../../../js/funcionesScript.js" type="text/javascript"></script>
<script  src="../../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script  src="../../../js/funcionesScriptProveedores.js" type="text/javascript"></script>
<script  src="../../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script  src="../../../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script src="../../../js/funcionesScriptProductos.js" type="text/javascript"></script>
<script  src="../../../js/funcionesScriptPrecios.js" type="text/javascript"></script>
<script src="../../../js/datatables.min.js" type="text/javascript"></script>


<script language="JavaScript" type="text/JavaScript">
Full();
</script>

</head>

<body onLoad="inna();">
<div class="pagina">
	<div id="cuerpo">
    <header>
    		<?php ayuda("../../../images/header.png","","../../../images/sigef_logo.png");?>
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
    	 <div id="ventasEstado">
		
            <form id="ventasEstado" name="ventasEstado" action="return false" onSubmit="return false" method="POST">
                                <center>
                    <table>
                        <tr>
                        <td colspan="4"><strong> <center><?php echo $lang[$idioma]['Order']?></center></strong></td>
                            
                            </tr>
                       
                            <tr>
                        <td class="text"> 
                        	<?php echo $lang[$idioma]['FechaIni']?>
                        </td>
                        <td> 
                        <strong>
                        	<div class='entradaTexto textoGrande' id="Nombre" style="text-align:left; padding-left:10px;"><?php echo $inicio; ?></div>
                        </strong>
                        </td>
                        <td class="text"> 
                        	<?php echo $lang[$idioma]['FechaFin']?>
                        </td>
                        <td colspan="1"> 
                        <strong>
                        	<div class='entradaTexto textoGrande' id="Estado" style="text-align:left; padding-left:10px;"><?php echo $final; ?></div>
                        </strong>
                        </td>
                            
                            </tr>
                            <tr>
                        <td class="text"> 
                        	<?php 
                            if($tipo=='1'){
                                echo $lang[$idioma]['Estado'];
                            }else
                            if($tipo=='2'){
                                echo $lang[$idioma]['ItemCode'];
                            }?>
                        </td>
                        <td colspan="1"> 
                        <strong>
                        	<div class='entradaTexto textoGrande' id="numeroOrden" style="text-align:left; padding-left:10px;"><?php echo $estado; ?></div>
                        </strong>
                        </td>
                        	<?php 
                            if($tipo=='1'){
                                echo "";
                            }else
                            if($tipo=='2'){
                                echo "</tr><tr>";
                            }?>
                        <td class="text"> 
                        	<?php echo $lang[$idioma]['Nombre']?>
                        </td>
                        <td colspan="<?php 
                            if($tipo=='1'){
                                echo "1";
                            }else
                            if($tipo=='2'){
                                echo "3";
                            }?>"> 
                        <strong>
                            <div class='entradaTexto textoGrande' id="numeroTraking" style="text-align:left; padding-left:10px;"><?php 
                                                                                                                                    if($tipo=='1'){
                                                                                                                                        echo buscaNomEstado($estado,"../../");
                                                                                                                                    }else
                                                                                                                                    if($tipo=='2'){
                                                                                                                                         echo $_GET['prod'];
                                                                                                                                    }
                                                                                                                                    ?></div>
                        </strong>
                        </td>
                            
                            </tr>
                            <tr> <td colspan="4"><center><div id="resultado"></div> </center></td></tr>
                            <tr><td colspan="4"><input type="text" class='entradaTexto' hidden="hidden" id="codigo" value="" disabled/></td> </tr>
                        
                        
                            
                        <tr>
            
                        <td colspan="4">
                        <center>
                        		<div id="ventasEstadoCont">
                                <script>llenarOrdenesVentaEstado('<?php echo $estado;?>','<?php echo $pais;?>','<?php echo $inicio;?>','<?php echo $final;?>','<?php echo $tipo;?>');</script>
                                </div>
                      
                            </center>
                        </td>
                        
                         </tr>
                         <tr>
                         <td colspan="4">
                         	
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
