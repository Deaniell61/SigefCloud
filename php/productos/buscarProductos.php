<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
## usuario y clave pasados por el formulario
$codigoBusca=$_POST['codigo'];
$codEmpresa=$_POST['codEmpresa'];
$pais=$_POST['pais'];

if($codigoBusca!=NULL)
{
	$squery="select codprod,masterSKU,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,categori,subcate1,subcate2,codPack,upc,flavor as codflavor,gender as genero,itemcode,codmanufac,agesegment,codform,codconcern,codcocina,country,SisCount,SID,FCE from cat_prod where codempresa='".$codEmpresa."' and mastersku='".$codigoBusca."'";

if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squery))
{
		
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{	
						$_SESSION['codprod']=$row['codprod'];
						$_SESSION['mastersku']=$row['masterSKU'];
						$_SESSION['prodName']=$row['prodName'];
						echo "<script>
								document.getElementById('itemCode').value=\"".$row['itemcode']."\";
								document.getElementById('masterSKU').value = \"".$row['masterSKU']."\";
								if(document.getElementById('itemCode').value != ''){
								document.getElementById('itemCode').disabled = true;
								}else{
								document.getElementById('itemCode').disabled = false ;
								}
								
								document.getElementById('descSistema').value = \"".$row['descsis']."\";
								document.getElementById('prodName').value = \"".$row['prodName']."\";
								document.getElementById('SName').value = \"".$row['nombre']."\";
								document.getElementById('EName').value = \"".$row['nombri']."\";
								document.getElementById('UPC').value = \"".$row['upc']."\";
								setTimeout(function(){document.getElementById('marca').value = \"".$row['marca']."\";},500);
								setTimeout(function(){document.getElementById('prodLin').value = \"".$row['codProLin']."\";},500);
								document.getElementById('category').value = \"".$row['categori']."\";
								subCategorias('".$codEmpresa."','".$pais."','".$row['categori']."','subCategory');
								setTimeout(function(){document.getElementById('subCategory1').value = \"".$row['subcate1']."\";},500);
								subCategorias2('".$codEmpresa."','".$pais."','".$row['subcate1']."','subCategory');
								setTimeout(function(){document.getElementById('subCategory2').value = \"".$row['subcate2']."\";},500);						";								
						echo	"
								setTimeout(function(){parametrosEspecificos('".$codEmpresa."','".$pais."','".$row['subcate1']."');},600);
								";
						if($row['subcate2']!="")
						{	
						echo 	"
								setTimeout(function(){parametrosEspecificos('".$codEmpresa."','".$pais."','".$row['subcate2']."');},600);						";
						}
						echo	"
								document.getElementById('pakage').value = \"".$row['codPack']."\";
								setTimeout(function(){document.getElementById('flavor').value = \"".$row['codflavor']."\";},500);
								document.getElementById('genero').value = \"".$row['genero']."\";
								setTimeout(function(){document.getElementById('manufacturadores').value = \"".$row['codmanufac']."\";},500);
								document.getElementById('age').value = \"".$row['agesegment']."\";
								setTimeout(function(){document.getElementById('cocina').value = \"".$row['codcocina']."\";},500);
								setTimeout(function(){document.getElementById('formula').value = \"".$row['codform']."\";},500);
								document.getElementById('paisOrigen').value = \"".$row['country']."\";
								document.getElementById('concerns').value = \"".$row['codconcern']."\";
								document.getElementById('SizeCount').value = \"".$row['SisCount']."\";
								document.getElementById('SID').value = \"".$row['SID']."\";
								document.getElementById('FCE').value = \"".$row['FCE']."\";
								generateBarcode('".$row['upc']."');</script>";
					}
}
else
{
	echo "Su sesion ha expirado";
}

}
?>
