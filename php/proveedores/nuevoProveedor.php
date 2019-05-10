<?php 
header("Expires: TUE, 18 Jul 2017 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
verTiempo();
session_start();
$codigo=$_POST['codigo'];
$_SESSION['pais']="";

?>
<!--
   
<aside class="pestanas">
                <ul>
                	
                    <li onClick="llamarProveedor('1','<?php echo $codigo; ?>');seleccionP(this);" id="TabRegistro"><?php echo $lang[ $idioma ]['Registro']; ?></li>
                    <?php if(isset($_SESSION['codprov']))
					{?>
                    <li onClick="llamarProveedor('2','<?php echo $codigo; ?>');seleccionP(this);"id="TabFacturacion"><?php echo $lang[ $idioma ]['Facturacion']; ?></li>
                    <li onClick="llamarProveedor('3','<?php echo $codigo; ?>');seleccionP(this);"id="TabPagos"><?php echo $lang[ $idioma ]['Pagos']; ?></li>
                    <li onClick="llamarProveedor('4','<?php echo $codigo; ?>');seleccionP(this);"id="TabCobros"><?php echo $lang[ $idioma ]['Cobros']; ?></li>
                    <?php 
					}?>
                </ul>
            </aside>
   -->       
         <center>
   	 		<div id="formularioProveedor">
   	         <script>llamarProveedor('1','<?php echo $codigo; ?>');seleccionP(document.getElementById('TabRegistro'));</script>
			</div>
        </center>
        
        <div id="usuarioProv">
        </div>
        
