<?php
require_once('../../fecha.php');
require_once('../../coneccion.php');
require_once('../combosBancos.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

session_start();



?>
<div id="bancos1">

<br>


<form id="bancosIngreso" name="bancos" action="return false" onSubmit="return false" method="POST">
    
      <center>
    <table Class="tablabordes">
            <tr><div id="resultado"></div></tr>
            <br>
            <tr>
                <td></td>
                <td colspan="3" class="text"><span><center>Ingreso de Bancos</center></span><br></td>
               
            </tr>
            </tr>
            <tr>
            <td><br><br></td>
            <td class="" colspan="4">
            <input type="button" class='cmd button button-highlight button-pill' onClick="CatBancos();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            <input type="reset" class='cmd button button-highlight button-pill' onClick="Limpiartipobancos();  salir1();" value="Regresar"/>
                
            </td>
            
             </tr>
        </table>
        </center>
                </form>
                
</div>
