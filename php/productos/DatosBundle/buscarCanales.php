<?php
sleep(1);
require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../combosProductos.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
$codigo= strtoupper($_POST['codigo']);
$pais= ($_POST['pais']);

				session_start();
$sql="select codchan,channel,pminsale,columna,incre1,incre2,incre3,incre4,codigo,bodega from cat_sal_cha where codchan='$codigo'";
## ejecución de la sentencia sql

$ejecutar=mysqli_query(conexion($pais),$sql);
if($ejecutar)				
{
	$row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC);


						
						
?>

<input type="text" class='entradaTexto' disabled hidden="" id="codChan" value="<?php echo $row['codchan'];?>">
<form id="canales" name="canales" action="return false" onSubmit="return false" method="POST">
<div id="resultado"></div>
                	<center>
        <table style="width:100%;">
        	<tr>
            	<td style="width:30%; vertical-align:text-top;">
                
                	<table class="principalBundle">
                    	<tr>
                        	<td class="text"><?php echo $lang[$idioma]['Nombre']?></td>
                            <td colspan="5"><input type="text" class='entradaTexto' id="chaName"  value="<?php echo $row['channel'];?>" placeholder="<?php echo $lang[$idioma]['Nombre']?>"></td>
                        </tr>
                        <tr>
                        	<td class="text"><?php echo $lang[$idioma]['marminsalp']?></td>
                            <td><input type="text" id="pminsale" class='entradaTexto' value="<?php echo $row['pminsale'];?>" placeholder="<?php echo $lang[$idioma]['marminsalp']?>"></td>
                            <td class="text"><?php echo $lang[$idioma]['Codigo']?></td>
                            <td><input type="text" id="codchan" class='entradaTexto' value="<?php echo $row['codigo'];?>" placeholder="<?php echo $lang[$idioma]['Codigo']?>"></td>
                            <td class="text"><?php echo $lang[$idioma]['Columna']?></td>
                            <td><input type="text" id="columna" class='entradaTexto' value="<?php echo $row['columna'];?>" placeholder="<?php echo $lang[$idioma]['Columna']?>"></td>
                            
                        </tr>
                        <tr>
                        	<td class="text"><?php echo $lang[$idioma]['RevenueAccount']?></td>
                            <td colspan="2"><input type="text" class='entradaTexto' disabled style="width:90%;" placeholder="<?php echo $lang[$idioma]['RevenueAccount']?>"></td>
                            <td colspan="3"><input type="text" class='entradaTexto' disabled placeholder="<?php echo $lang[$idioma]['RevenueAccount']?>"></td>
                        </tr>
                        <tr>
                        	<td class="text"><?php echo $lang[$idioma]['ReciavableAccount']?></td>
                            <td colspan="2"><input type="text" class='entradaTexto' disabled style="width:90%;" placeholder="<?php echo $lang[$idioma]['ReciavableAccount']?>"></td>
                            <td colspan="3"><input type="text" class='entradaTexto' disabled placeholder="<?php echo $lang[$idioma]['ReciavableAccount']?>"></td>
                        </tr>
                        <tr>
                        	<td class="text"><?php echo $lang[$idioma]['InventoryAccount']?></td>
                            <td colspan="2"><input type="text" class='entradaTexto' disabled style="width:90%;" placeholder="<?php echo $lang[$idioma]['InventoryAccount']?>"></td>
                            <td colspan="3"><input type="text" class='entradaTexto' disabled placeholder="<?php echo $lang[$idioma]['InventoryAccount']?>"></td>
                        </tr>
                        <tr>
                        	<td class="text"><?php echo $lang[$idioma]['OrderCode']?></td>
                            <td colspan="5"><input type="text" class='entradaTexto' disabled id="OrderCode" placeholder="<?php echo $lang[$idioma]['OrderCode']?>"></td>
                        </tr>
                        <tr>
                        	<td class="text"><?php echo $lang[$idioma]['Warehouse']?></td>
                            <td colspan="5"><select  class='entradaTexto' id="Warehouse"><?php echo comboWarehouse('',$pais);?></select></td>
                        </tr>
                    </table>
                    <div id="chanParam">
                    <script>
						llenarParametros('<?php echo $row['codchan'];?>','<?php echo $pais;?>');
                    </script>
                    </div>
                </td>
                <td style="width:40%; vertical-align:text-top;">
                	<table class="derechaBundle">
                    	<tr><td colspan="4" style="text-align:center;"><?php echo $lang[$idioma]['IncreFinalSalePri']?></td></tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['1stBundle']?>
                        	</td>
                        	<td>
                            	<input class='entradaTexto' type="number" max="999" min="0" id="bundle1" value="<?php echo $row['incre1'];?>" placeholder="<?php echo $lang[$idioma]['1stBundle']?>">
                        	</td>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['2ndBundle']?>
                        	</td>
                        	<td>
                            	<input class='entradaTexto' type="number" max="999" min="0" id="bundle2" value="<?php echo $row['incre2'];?>" placeholder="<?php echo $lang[$idioma]['2ndBundle']?>">
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['3rdBundle']?>
                        	</td>
                        	<td>
                            	<input class='entradaTexto' type="number" max="999" min="0" id="bundle3" value="<?php echo $row['incre3'];?>" placeholder="<?php echo $lang[$idioma]['3rdBundle']?>">
                        	</td>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['4thBundle']?>
                        	</td>
                        	<td>
                            	<input class='entradaTexto' type="number" max="999" min="0" id="bundle4" value="<?php echo $row['incre4'];?>" placeholder="<?php echo $lang[$idioma]['4thBundle']?>">
                        	</td>
                        </tr>
                    </table>
                    <input type="text" class='entradaTexto' id="codparpri" disabled hidden="">
                    <table class="derechaBundle">
                    	<tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Factor']?>
                        	</td>
                        	<td>
                            	<select  class='entradaTexto' id="factor">
                                	<option selected value="">
                                    </option>
                                    <option value="P">
                                    	<?php echo $lang[$idioma]['Percent']?>
                                    </option>
                                    <option value="V">
                                    	<?php echo $lang[$idioma]['Value']?>
                                    </option>
                                </select>
                        	</td>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['ValueFactor']?>
                        	</td>
                        	<td>
                            	<input class='entradaTexto' type="number" id="valueFactor" max="999" min="0" value="0" disabled >
                        	</td>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Opera']?>
                        	</td>
                        	<td>
                            	<select class='entradaTexto' id="opera">
                                	<option selected value="">
                                    </option>
                                    <option value="C">
                                    	<?php echo $lang[$idioma]['Cost']?>
                                    </option>
                                    <option value="S">
                                    	<?php echo $lang[$idioma]['Sale']?>
                                    </option>
                                </select>
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text"><?php echo $lang[$idioma]['Columna']?></td>
                            <td colspan="5">
                            	<input class='entradaTexto' type="text" id="columna2" value="" placeholder="<?php echo $lang[$idioma]['Columna']?>">
                            </td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Formula']?>
                        	</td>
                        	<td colspan="5">
                            	<textarea class='entradaTexto' id="formula"></textarea>
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['FormulaR']?>
                        	</td>
                        	<td colspan="5">
                            	<textarea class='entradaTexto' id="formulaR" disabled></textarea>
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['FormulaFBG']?>
                        	</td>
                        	<td colspan="5">
                            	<textarea class='entradaTexto' id="formulaFBG" disabled></textarea>
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Account']?>
                        	</td>
                        	<td colspan="4">
                            	<select class='entradaTexto' id="account">
                                	<option><?php echo comboAccount('',$pais);?></option>
                                </select>
                        	</td>
                            <td style="text-align:right">
                            	<input type="checkbox" id="costoCH" disabled><?php echo $lang[$idioma]['Costo']?>
                            </td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Order']?>
                        	</td>
                        	<td>
                            	<input  class='entradaTexto' type="text" id="order" disabled placeholder="<?php echo $lang[$idioma]['Order']?>">
                        	</td>
                            <td colspan="4" style="text-align:right">
                            	<input type="checkbox" id="FBGCH" disabled><?php echo $lang[$idioma]['FBG']?>
                            </td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Registro']?>
                        	</td>
                        	<td colspan="2">
                            	<input type="text"  class='entradaTexto' id="registro" disabled placeholder="<?php echo $lang[$idioma]['Registro']?>">
                        	</td>
                            <td class="text">
                            	<?php echo $lang[$idioma]['ValorRegistro']?>
                        	</td>
                        	<td colspan="2">
                            	<input type="text"  class='entradaTexto' id="valorRegistro" disabled placeholder="<?php echo $lang[$idioma]['ValorRegistro']?>">
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Formula Registro']?>
                        	</td>
                        	<td colspan="5">
                            	<textarea id="formulaRegistro"   class='entradaTexto' disabled></textarea>
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Valor']?>
                        	</td>
                        	<td colspan="5">
                            	<input type="text" id="valor"  class='entradaTexto' disabled placeholder="<?php echo $lang[$idioma]['Valor']?>">
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['ValorR']?>
                        	</td>
                        	<td colspan="5">
                            	<input type="text" id="valorR"  class='entradaTexto' disabled placeholder="<?php echo $lang[$idioma]['ValorR']?>">
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['ValorFBG']?>
                        	</td>
                        	<td colspan="5">
                            	<input type="text" id="valorFBG"  class='entradaTexto' disabled placeholder="<?php echo $lang[$idioma]['ValorFBG']?>">
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text" colspan="2">
                            	<?php echo $lang[$idioma]['AgregarCanal']?>
                        	</td>
                        	<td colspan="4">
                            	<img src="../../../images/document_add.png" style="cursor:pointer;" onClick="asignarExtras('parametrosCanal','','<?php echo $pais;?>');">
                        	</td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
        </center>
        					<div class="">	<input  class='cmd button button-highlight button-pill' type="button" onClick="guardarCanal('<?php echo $row['codchan'];?>','1','<?php echo $pais;?>');guardarCanal('<?php echo $row['codchan'];?>','2','<?php echo $pais;?>');" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            					<input type="reset" style="width:186px;"  class='cmd button button-highlight button-pill' onClick="envioDeDataBundle('Canal');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            					</div>
                </form>
                <br>
<script>document.getElementById('Warehouse').value='<?php echo $row['bodega'];?>'</script>
<?php

}
else
{
	echo "<script>alert(\"Error de base de datos\");</script>";
}
?>