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
$pais=$_SESSION['pais'];
$sku=$_POST['sku'];
$prodName=$_POST['prodname'];
$uniVenta=$_POST['tota'];
 $bundle=$_POST['bundle'];?>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Bundle'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="bundleCant" placeholder="<?php echo $lang[$idioma]['Bundle'];?>" onkeypress="return isNumber(event);"></td>
                
            </tr>
            <tr>
            
            <td colspan="2">
            <input type="button"
                   class='cmd button button-highlight button-pill'
                   onClick="validateInput1();"
                   value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>

<script>

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function validateInput1() {

        bundleQuantity = document.getElementById('bundleCant').value;
        if(bundleQuantity >1){
            guardarExtra(
                'bundle',
                '<?php echo $codigoEmpresa;?>',
                document.getElementById('bundleCant').value,
                '<?php echo $sku;?>',
                '<?php echo $prodName;?>',
                '<?php echo $bundle;?>',
                '<?php echo $pais;?>',
                '<?php echo $uniVenta;?>');
            <?php
            $_SESSION['refreshBundles'] = 1;
            ?>
            setTimeout(function(){
                window.opener.location.reload();
            },750);
            setTimeout(function(){
                cerrar();
            },1000);
        }
        else{
            alert('El bundle puede ser de 2 en adelante');
        }
    }
</script>