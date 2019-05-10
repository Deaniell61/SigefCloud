<?php
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

	$squery="select masterSKU,codprod,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,codpres,peso,peso_lb,peso_oz,alto,ancho,profun,univenta,ubundle,pcosto,itemcode,codprod from cat_prod where codempresa='".$codigoEmpresa."' and codprod='".$_SESSION['codprod']."'";
if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squery))
{
		
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
if($row['masterSKU']!='')
{
 


$_SESSION['codprod']=$row['codprod'];?>	
<script>formularioDistribucion('<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>','<?php echo $_SESSION['codprod'];?>');
setTimeout(function(){$("#cargaLoad").dialog("close");},500);
</script>

<div id="productos">

<script>seleccion(document.getElementById('TabDistribucion'));</script>
<form id="ProductosGeneral" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table>
                <tr><div id="resultado"></div><input type="text" class='entradaTexto' hidden="" id="paquetes" readonly style="width:100%;" value="<?php echo intval($row['univenta']/$row['ubundle']);?>"/></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['MasterSKU'];?></span></td>
                <td><input type="text" class='entradaTexto' name="masterSKU" disabled id="masterSKU" value="<?php echo $row['masterSKU'];?>"></td>
                <td class="text"><span><?php echo $lang[$idioma]['ItemCode'];?></span></td>
                <td><input type="text" name="itemCode" class='entradaTexto' disabled id="itemCode" autofocus value="<?php echo $row['itemcode'];?>"><br></td>
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['ProdName'];?></span></td>
                <td colspan="2"><input type="text" style="margin-top:10px;" class='entradaTexto' name="prodName" disabled id="prodName" value="<?php echo $row['prodName'];?>"><br></td>
                
            </tr>
            </table>
            <table>
            <tr>
            	
                <td colspan="3" id="cuerpoDistri">
                	
                   
                    
                </td>
            </tr>
            
            <tr>
           
            <td colspan='4'>
            <input type="button" class='cmd button button-highlight button-pill' onClick="setTimeout(function(){ventana('cargaLoad',300,400);producto(12,'<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>','<?php echo $_SESSION['codprod'];?>');},1000);" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="button" class='cmd button button-highlight button-pill' onClick="document.getElementById('buscaSeller').value = '';buscarSellers();" value="<?php echo $lang[$idioma]['Limpiar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
<?php 
					}
					else
					{
						echo "<script>alert(\"".$lang[$idioma]['NoAprobado']."\");producto(1,'".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$itemCode."'); </script>";
						}
}
else
{
	echo "<script>alert(\"Debe guardar primero\");producto(1,'".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$itemCode."'); </script>";
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