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
<script  src="../../js/funcionesScriptSoporte.js" type="text/javascript"></script>
<script  src="../../js/lib/ckeditor/ckeditor.js" type="text/javascript"></script>

<script language="JavaScript" type="text/JavaScript">
Full();

</script>

</head>

<body onLoad="javascript:envioDeDataSoporte('Soporte');inna();">
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
		

   
            <form id="soporte" name="soporte" action="return false" onSubmit="return false" method="POST">
                                <center>
                    <table>
                        <tr>
                        <td colspan="2"> <center><?php echo $lang[$idioma]['Soporte']?></center></td>
                            
                            </tr>
                            <tr> <td colspan="2"><center><div id="resultado"></div> </center></td></tr>
                            <tr><td colspan="2"><input type="text" class='entradaTexto' hidden="hidden" name="codigo" id="codigo" value="" disabled/></td> </tr>
                         <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['TNumero'];?></span></td>
                            <td><input type="text" class='entradaTexto textoGrande' readonly id="numticket" value=""  ></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Asunto'];?></span></td>
                            <td><input type="text" class='entradaTexto' id="asunto" readonly value="" ></td>
                        </tr>
                        <tr>
                        
                            <td class="text"><span><?php echo $lang[$idioma]['Descripcion'];?></span></td>
                            <td>
                            	<div id="descripcionTodos" style="text-align: left; width:calc(100%); height:250px; overflow-y:scroll; " class='entradaTexto'>
                          
                                </div>
                               
                            </td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Email'];?></span></td>
                            <td><input type="text" class='entradaTexto textoGrande' readonly id="email" value=""  ></td>
                        </tr>
                         <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['FechaIni'];?></span></td>
                            <td><input type="date" class='entradaTexto' id="fechaini" readonly value="" ></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['FechaFin'];?></span></td>
                            <td><input type="date" class='entradaTexto' id="fechafin" readonly value="" ></td>
                        </tr>
                          <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Estado'];?></span></td>
                            <td>
                                <select <?php if(isset($_SESSION['CodPaisCod'])){echo "disabled";}?> class='entradaTexto' id="estado" style="width:calc(90% +15px);" onChange="if(this.value!=''){__('enviar12').disabled=false;}else{__('enviar12').disabled=true;}">
                        <option value="Abierto"><?php echo $lang[$idioma]['Abierto'];?></option>
						<option value="Procs"><?php echo $lang[$idioma]['Procs'];?></option>
                        <option value="Procu"><?php echo $lang[$idioma]['Procu'];?></option>
                        <option value="Cerrado"><?php echo $lang[$idioma]['Cerrado'];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        
                            <td class="text"><span><?php echo $lang[$idioma]['Descripcion'];?></span></td>
                            <td>
                            
                               <textarea rows="7" style="text-align: left; width:calc(90%);" onKeyUp="if(this.value!=''){__('enviar12').disabled=false;}else{__('enviar12').disabled=true;}"  autofocus class="entradaTexto" id="descripcion"></textarea>
                            </td>
                        </tr>                                    
                                    
                        <tr>
            
                        <td colspan="2">
                        <?php if(!isset($_SESSION['CodPaisCod'])){ $tipo='user2';}else{ $tipo='user';}?>
                        <center>
                        <input type="button" id="enviar12"  class='cmd button button-highlight button-pill' disabled onClick="seleccionGuardar('<?php echo $_SESSION['codigo'];?>','<?php echo $tipo;?>');" value="<?php echo $lang[$idioma]['Enviar'];?>"/>
                       <!--- <?php if(!isset($_SESSION['CodPaisCod'])){?>
                        <input type="button" id="enviar12"  class='cmd button button-highlight button-pill' onClick="ingresoSoporte('<?php echo $_SESSION['codigo'];?>');" value="<?php echo $lang[$idioma]['Guardar'];?>"/> <?php }?> -->
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
<script>
setTimeout(function(){
if(__('estado').value=="Cerrado")
{
	__('descripcion').disabled=true;
}
},700);

</script> 
</body>
</html>
<?php
?>
