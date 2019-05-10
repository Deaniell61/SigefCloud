<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosProductos.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$codigoEmpresa=$_POST['codEmpresa'];
$pais=$_POST['pais'];
$itemCode=limpiar_caracteres_sql($_POST['icode']);
session_start();
verTiempo2();

	$squery="select masterSKU,codempresa,descsis,prodName,nombre,itemcode,codprod,codaran,prodprocess,transport,formexport,tipcontenedor,temp,comercanal,prodcapaci from cat_prod where codempresa='".$codigoEmpresa."' and mastersku='".$_SESSION['mastersku']."'";
	
if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squery))
{
		
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$_SESSION['codprod']=$row['codprod'];

?>
<div id="productos" onMouseOver="document.getElementById('busqueda').innerHTML='';">
<script>					seleccion(document.getElementById('TabExportacion'));

setTimeout(function(){$("#cargaLoad").dialog("close");},500);
</script>
<form id="ProductosExportacion" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table class="exporta">
                <tr><div id="resultado"></div></tr>
                <tr><div id="advertencia" style="color:red;" hidden><?php echo $lang[$idioma]['Adevertencia_Rojo'];?></div></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['MasterSKU'];?></span></td>
                <td><input type="text" class='entradaTexto' name="masterSKU" disabled id="masterSKU" value="<?php echo $row['masterSKU'];?>"></td>
                <td class="text"><span><?php echo $lang[$idioma]['ItemCode'];?></span></td>
                <td><input type="text" class='entradaTexto' name="itemCode" disabled id="itemCode" autofocus value="<?php echo $row['itemcode'];?>"></td>
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['ProdName'];?></span></td>
                <td colspan="2"><input type="text" class='entradaTexto textoGrande' name="prodName" disabled id="prodName" value="<?php echo $row['prodName'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['descPreProd'];?><span class="validaraster">*</span></span></td>
                <td colspan="2"><textarea rows="5" class='entradaTexto textoGrande' id="descPreProd"  onKeyPress="verificaImportantes('Exportar','guardar26');"  onChange="verificaImportantes('Exportar','guardar26');"><?php echo $row['prodprocess'];?></textarea></td>
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['capProdMen'];?><span class="validaraster">*</span></span></td>
                <td><input class='entradaTexto' type="text" id="capProdMen"  onClick="verificaImportantes('Exportar','guardar26');" onChange="verificaImportantes('Exportar','guardar26');" value="<?php echo $row['prodcapaci'];?>"></td>
                 <td class="text"><span><?php echo $lang[$idioma]['Arancel'];?><span class="validaraster">*</span></span></td>
                <td><select class='entradaTexto' onClick="verificaImportantes('Exportar','guardar26');"  id="partidaArancelaria"><?php echo comboArancel($codigoEmpresa,$pais);?></select><img src="../../css/lupa.png" onClick="ventana('busqueda',550,850);llenarBusqueda('Arancel','busqueda');" style="float:left;" width="21px" height="21px"><img src="../../images/document_add.png" id="subForm" onClick="asignarExtras('Arancel','<?php echo $codigoEmpresa;?>','<?php echo $pais;?>'); verificaImportantes('Exportar','guardar26');"></td>
            </tr>            
           
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['TipContenedor'];?><span class="validaraster">*</span></span></td>
                <td><select class='entradaTexto' id="TipContenedor" onClick="verificaImportantes('Exportar','guardar26');"  onChange="temperatura(this,'Temperatura'); verificaImportantes('Exportar','guardar26');">
                		<option value=""></option>
                        <option value="SE"><?php echo $lang[$idioma]['SE'];?></option>
                        <option value="RE"><?php echo $lang[$idioma]['RE'];?></option>
                	</select></td>
                <td class="text"><span><?php echo $lang[$idioma]['Transporte'];?><span class="validaraster">*</span></span></td>
                <td style="text-align:left;"><input type="text" value="<?php echo $row['transport'];?>"  id="Transporte" onChange="verificaImportantes('Exportar','guardar26');" hidden><?php echo comboTransporte($codigoEmpresa,$_SESSION['pais']);?><!--<img src="../../images/document_add.png" style="float:right;" id="subForm" onClick="asignarExtras('Transporte','<?php echo $codigoEmpresa;?>','<?php echo $pais;?>');">--></td>
               
            </tr>
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Temperatura'];?></span></td>
                <td style="text-align:left"><input class='entradaTexto' type="number" id="Temperatura" disabled value="<?php echo $row['temp'];?>"></td>
            	 
                
            </tr>
            <tr>
            <td class="text"></td>
                <td style="text-align:left;"><input type="text" id="canalesComercializa" onClick="verificaImportantes('Exportar','guardar26');" value="<?php echo $row['comercanal'];?>"   onChange="verificaImportantes('Exportar','guardar26');" hidden><span><span class="validaraster">*</span><?php echo $lang[$idioma]['CanalComercializa'];?></span><br><?php echo comboCanalComercializa($codigoEmpresa,$pais);?><!--<img src="../../images/document_add.png" id="subForm" style="float:right;" onClick="asignarExtras('Comercializa','<?php echo $codigoEmpresa;?>','<?php echo $pais;?>');">--></td>
            <td class="text"></td>
                <td style="text-align:left;"><input type="text" id="formasExportacion" onClick="verificaImportantes('Exportar','guardar26');" value="<?php echo $row['formexport'];?>"  onChange="verificaImportantes('Exportar','guardar26');" hidden><span><span class="validaraster">*</span><?php echo $lang[$idioma]['FormaExporta'];?></span><br><?php echo comboExportacion($codigoEmpresa,$pais);?><!--<img src="../../images/document_add.png" style="float:right;" id="subForm" onClick="asignarExtras('Exportacion','<?php echo $codigoEmpresa;?>','<?php echo $pais;?>');">--></td>
            	
               
            </tr>
            <tr>
            
            <td colspan="4">
            <center>
            <input id="guardar26" type="button" class='cmd button button-highlight button-pill' onClick="actualizaProducto('Exporta',document.getElementById('masterSKU').value,document.getElementById('prodName').value,document.getElementById('itemCode').value,document.getElementById('canalesComercializa').value,document.getElementById('Temperatura').value,document.getElementById('formasExportacion').value,document.getElementById('TipContenedor').value,document.getElementById('Transporte').value,document.getElementById('descPreProd').value,document.getElementById('partidaArancelaria').value,document.getElementById('capProdMen').value,'','','','','','','','');setTimeout(function(){ventana('cargaLoad',300,400);producto(5,'<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>','<?php echo $_SESSION['codprod'];?>');},1000);" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset" class='cmd button button-highlight button-pill' onClick="producto(8,'<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>','<?php echo $_SESSION['codprod'];?>');" value="<?php echo $lang[$idioma]['Limpiar'];?>"/>
            </center>	
            </td>
			
             </tr>
        </table>
        </center>
                </form><div id="busqueda">
</div>
                
</div>
<script>

document.getElementById('partidaArancelaria').value = "<?php echo $row['codaran'];?>";
document.getElementById('Transporte').value = "<?php echo $row['transport'];?>";
document.getElementById('formasExportacion').value = "<?php echo $row['formexport'];?>";
document.getElementById('canalesComercializa').value = "<?php echo $row['comercanal'];?>";
document.getElementById('TipContenedor').value = "<?php echo $row['tipcontenedor'];?>";
</script>
<?php }
else
{
	echo "<script>alert(\"$squery\");producto(1,'".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$itemCode."'); </script>";
}
}


function Desahabilita($dato)
{
	if($dato==NULL)
	{
		return "";
	}
	else
	{
		return "disabled";
	}
}?>