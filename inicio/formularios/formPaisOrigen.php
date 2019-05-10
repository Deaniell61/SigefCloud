<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../../php/fecha.php');
$idioma=idioma();
include('../../php/idiomas/'.$idioma.'.php');
session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];
$pais=$_SESSION['pais'];?>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Nombre'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="nombre" placeholder="<?php echo $lang[$idioma]['Nombre'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['NombreOnu'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="nombreOnu" placeholder="<?php echo $lang[$idioma]['NombreOnu'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="code" placeholder="<?php echo $lang[$idioma]['Codigo'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo']." 1";?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo1" placeholder="<?php echo $lang[$idioma]['Codigo']." 1";?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo']." 2";?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo2" placeholder="<?php echo $lang[$idioma]['Codigo']." 2";?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo']." 3";?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo3" placeholder="<?php echo $lang[$idioma]['Codigo']." 3";?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo']." 4";?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo4" placeholder="<?php echo $lang[$idioma]['Codigo']." 4";?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo']." 5";?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo5" placeholder="<?php echo $lang[$idioma]['Codigo']." 5";?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo']." 6";?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo6" placeholder="<?php echo $lang[$idioma]['Codigo']." 6";?>"></td>
                
            </tr>
            <tr>

            <td colspan="2">
            <input type="button"   class='cmd button button-highlight button-pill' onClick="guardarPais('paisOrigen',document.getElementById('nombreOnu').value,document.getElementById('nombre').value,document.getElementById('code').value,document.getElementById('codigo1').value,document.getElementById('codigo2').value,'<?php echo $pais;?>',document.getElementById('codigo3').value,document.getElementById('codigo4').value,document.getElementById('codigo5').value,document.getElementById('codigo6').value);actualizarExtras();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
