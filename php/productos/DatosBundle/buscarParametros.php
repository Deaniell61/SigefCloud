<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
$chan=$_POST['chan'];
$pais=$_POST['pais'];
$codpar=$_POST['codpar'];
		echo "<script>
									
									limpiarCamposParametro();
			</script>
			";
$squery="select codparpri,descrip,factor,fac_val,fac_type,opera,formula,formulaR,formulafbg,cuentacon,acosto,cuentacon,orden,valor_a,valor_r,columna from cat_par_pri where codparpri='".$codpar."'";
					
				if($ejecutar=mysqli_query(conexion($pais),$squery))
				{
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						
							echo "<script>					
									document.getElementById('factor').value=\"".$row['factor']."\";
									document.getElementById('valueFactor').value=\"".$row['fac_val']."\";
									document.getElementById('opera').value=\"".$row['opera']."\";
									document.getElementById('formula').value=\"".$row['formula']."\";
									document.getElementById('columna2').value=\"".$row['columna']."\";
									document.getElementById('formulaR').value=\"".$row['formulaR']."\";
									document.getElementById('formulaFBG').value=\"".$row['formulafbg']."\";
									document.getElementById('account').value=\"".$row['cuentacon']."\";
									document.getElementById('order').value=\"".$row['orden']."\";
									document.getElementById('valorRegistro').value=\"".$row['valor_r']."\";
									document.getElementById('codparpri').value=\"".$row['codparpri']."\";
									document.getElementById('valor').value=\"".$row['valor_a']."\";
								
								  </script>";
						$_SESSION['parametro']=$row['codparpri'];
					}
				}
				else
				{	
					$retornar= "Error";
				}
				
				
				
?>
