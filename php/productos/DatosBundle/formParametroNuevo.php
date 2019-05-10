<?php
require_once('../../../php/fecha.php');
require_once('../../../php/productos/combosProductos.php');
$idioma=idioma();
include('../../../php/idiomas/'.$idioma.'.php');
session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];
$pais=$_SESSION['pais'];?>

<script language="JavaScript" type="text/JavaScript">
Full();
</script>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
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
                            	<input  class='entradaTexto' type="number" id="valueFactor" max="999" min="0" value="0" >
                        	</td>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Opera']?>
                        	</td>
                        	<td>
                            	<select  class='entradaTexto' id="opera">
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
                            	<input type="text"  class='entradaTexto' id="columna" value="" placeholder="<?php echo $lang[$idioma]['Columna']?>">
                            </td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Formula']?>
                        	</td>
                        	<td colspan="4">
                            	<textarea  class='entradaTexto' id="formula"></textarea>
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['FormulaR']?>
                        	</td>
                        	<td colspan="4">
                            	<textarea  class='entradaTexto' id="formulaR" ></textarea>
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['FormulaFBG']?>
                        	</td>
                        	<td colspan="4">
                            	<textarea  class='entradaTexto' id="formulaFBG" ></textarea>
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Account']?>
                        	</td>
                        	<td colspan="3">
                            	<select  class='entradaTexto' id="account">
                                	<option><?php echo comboAccount('',$pais);?></option>
                                </select>
                        	</td>
                            <td style="text-align:left;">
                            	<input type="checkbox" id="costoCH" ><?php echo $lang[$idioma]['Costo']?>
                            </td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Order']?>
                        	</td>
                        	<td colspan="3">
                            	<input  class='entradaTexto' type="text" id="order"  placeholder="<?php echo $lang[$idioma]['Order']?>">
                        	</td>
                            <td style="text-align:left;">
                            	<input type="checkbox" id="FBGCH" ><?php echo $lang[$idioma]['FBG']?>
                            </td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Registro']?>
                        	</td>
                        	<td colspan="2">
                            	<input  class='entradaTexto' type="text" id="registro"  placeholder="<?php echo $lang[$idioma]['Registro']?>">
                        	</td>
                            <td class="text">
                            	<?php echo $lang[$idioma]['ValorRegistro']?>
                        	</td>
                        	<td colspan="2">
                            	<input type="text"  class='entradaTexto' id="valorRegistro"  placeholder="<?php echo $lang[$idioma]['ValorRegistro']?>">
                        	</td>
                        </tr>
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Formula Registro']?>
                        	</td>
                        	<td colspan="4">
                            	<textarea  class='entradaTexto' id="formulaRegistro" ></textarea>
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['Valor']?>
                        	</td>
                        	<td colspan="4">
                            	<input type="text"  class='entradaTexto' id="valor"  placeholder="<?php echo $lang[$idioma]['Valor']?>">
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['ValorR']?>
                        	</td>
                        	<td colspan="4">
                            	<input type="text"  class='entradaTexto' id="valorR"  placeholder="<?php echo $lang[$idioma]['ValorR']?>">
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td class="text">
                            	<?php echo $lang[$idioma]['ValorFBG']?>
                        	</td>
                        	<td colspan="4">
                            	<input type="text"  class='entradaTexto' id="valorFBG"  placeholder="<?php echo $lang[$idioma]['ValorFBG']?>">
                        	</td>
                        </tr>
                        <tr>
            <tr>
            
            <td colspan="6">
            <input type="button"  class='cmd button button-highlight button-pill' onClick="guardarExtra('pakage','<?php echo $codigoEmpresa;?>',document.getElementById('package').value,document.getElementById('alto').value,document.getElementById('ancho').value,document.getElementById('largo').value,'<?php echo $pais;?>','');actualizarExtras();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset" class='cmd button button-highlight button-pill'  onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
