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

$_SESSION['codprov2']=$_POST['codigo'];
$_SESSION['codprov']=$_POST['codigo'];
$_SESSION['nomProv']=descubreProveedor($_SESSION['codprov']);
$codigo=$_POST['codigo'];
$_SESSION['pais']=$_POST['pais'];
$_SESSION['codpais']=$_POST['codpais'];

if(isset($_SESSION['pestaSelec']))
{
	
	if($_SESSION['pestaSelec']!='0')
	{
		
		?>
        <script>setTimeout(function()
		{llamarProveedor('<?php echo $_SESSION['pestaSelec']; ?>','<?php echo $codigo; ?>');seleccionP(document.getElementById('<?php echo $_SESSION['pestaSelec2']; ?>'));
        },500);</script>
        <?php
		$_SESSION['pestaSelec']=0;
		
	}
	
}


?>

   
<aside class="pestanas">
                <ul>
                	
                    <li onClick="llamarProveedor('1','<?php echo $codigo; ?>');seleccionP(this);" id="TabRegistro"><?php echo $lang[ $idioma ]['Registro']; ?></li>
                    <?php if(isset($_SESSION['codprov2']))
					{?>
                    <li onClick="llamarProveedor('2','<?php echo $codigo; ?>');seleccionP(this);"id="TabFacturacion"><?php echo $lang[ $idioma ]['Facturacion']; ?></li>
                    <li onClick="llamarProveedor('3','<?php echo $codigo; ?>');seleccionP(this);"id="TabPagos"><?php echo $lang[ $idioma ]['Pagos']; ?></li>
                    <li onClick="llamarProveedor('4','<?php echo $codigo; ?>');seleccionP(this);"id="TabCobros"><?php echo $lang[ $idioma ]['Cobros']; ?></li>
                     <li onClick="llamarProveedor('6','<?php echo $codigo; ?>');seleccionP(this);"id="TabComer"><?php echo $lang[ $idioma ]['Comercializa']; ?></li>
						 <?php //if($_SESSION['rol']=='P')
                        {?>
                     <li onClick="llamarProveedor('7','<?php echo $codigo; ?>');seleccionP(this);"id="TabArchivos"><?php echo $lang[ $idioma ]['Archivos']; ?></li>
						  <?php 
                        }?>
                    <?php 
					}?>
                </ul>
            </aside>
          
         <center>
   	 		<div id="formularioProveedor">
   	         <script>llamarProveedor('1','<?php echo $codigo; ?>');seleccionP(document.getElementById('TabRegistro'));</script>
			</div>
        </center>
        
        <div id="usuarioProv">
        </div>
        
