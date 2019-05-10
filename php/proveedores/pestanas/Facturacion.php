<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../busquedas/buscarProv.php');
require_once('../../productos/combosProductos.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
	function pais($cod,$pais)
	{
		$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
		
		{
			echo "<select class='entradaTexto textoGrande' disabled  id=\"pais\" style=\"width:calc(100% + 265px);\" onClick=\"llenarCombo('Empresas',this);\">".paises()."</select>
			<script>llenarCombo('Empresas',document.getElementById('pais'));</script>";
			}
           
	}
$codigo= strtoupper($_POST['codigo']);
if(isset($_SESSION['codprov2']))
{
?>

<form id="proveedor" name="proveedor" action="return false" onSubmit="return false" method="POST">
                  <center>
        <table class="proveedor">
          <tr>
             <td colspan="4"><center><?php echo $lang[$idioma]['Ingreso_Proveedores'];?></center></td>
                </tr>
                <tr><td colspan="4"><center><div id="resultado"></div></center></td></tr>
				<tr><input  class='entradaTexto textoGrande' type="text" autocomplete="off" hidden="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" disabled></tr>
            
       <tr> <td></td>
            <td colspan="2">
            	<center>
             <?php 
			 if(isset($_SESSION['pais']))
			 {
			 	pais($codigo,$_SESSION['pais']);
			 }
			 else
			 {
				 pais('','');
			 }?></center>
           </td>
          </tr>
           <tr hidden>
            	<td class="text">
                	<?php echo $lang[$idioma]['Empresa'];?>
                </td>
                
                <td colspan="2">
                	<select  class='entradaTexto textoGrande' disabled style="width:calc(100% + 265px);" id="Empresas"></select>
                </td>
               
                </tr>
            <tr>
            	<td class="text">
                	<?php echo $lang[$idioma]['nomEmpresa'];?>
                </td>
                
                <td colspan="2">
                	<input  class='entradaTexto textoGrande' disabled type="text" autocomplete="off" id="nombre" value="" >
                </td>
               
                </tr>
            <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['Nit'];?>
                </td>
                
                <td colspan="2">
                	<input  class='entradaTexto textoGrande' type="text" autocomplete="off" id="nit" value="" >
                </td>
                
            </tr>
            <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['nComercial'];?>
                </td>
                
                <td colspan="2">
                	<input  class='entradaTexto textoGrande' type="text" autocomplete="off" id="ncomercial" value="" >
                </td>
                
            </tr>
                <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['Direccion'];?>
                </td>
                
                <td colspan="2">
                	<input  class='entradaTexto textoGrande' type="text" autocomplete="off" id="direccion" value="" >
                </td>
                
            </tr>
            <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['Pais'];?>
                </td>
                
                <td colspan="2">
                	<select  class='entradaTexto '  style="width:calc(100% + 265px );" id="paisprov">
                    	<script>llenarPaisProv();</script>
                    </select>
                </td>
                 
            </tr>
            
             <tr>
            	<td class="text">
                	<?php echo $lang[$idioma]['Ciudad'];?>
                </td>
                <td>
                	<input  class='entradaTexto' type="text"  autocomplete="off" id="ciudadprov" >
                </td>
            	<td class="text">
                	<?php echo $lang[$idioma]['CodPos'];?>
                </td>
                
                <td>
                	<input  class='entradaTexto ' type="text" autocomplete="off" id="codpostal" >
                </td>
                
                </tr>
                
            
                 <tr>
                 <td></td>
                <td colspan="3">
                <center>	<?php echo $lang[$idioma]['Contacto'];?></center>
                </td>
                </tr>
               <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['Nombre'];?>
                </td>
                
                <td colspan="2">
                	<input  class='entradaTexto textoGrande' type="text" id="contactoNombre" >
                </td>
                
            </tr>
             <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['Apellido'];?>
                </td>
                
                <td colspan="2">
                	<input  class='entradaTexto textoGrande' type="text" id="contactoApellido" >
                </td>
                
            </tr>
            <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['emailContacto'];?>
                </td>
                
                <td colspan="2">
                	<input  class='entradaTexto textoGrande' onKeyUp="comprobarEmailProv('emailContacto');" type="text" id="emailContacto" >
                </td>
                
            </tr>
           
           
            <tr>
                <td class="text">
                	<?php echo $lang[$idioma]['Telefono'];?>
                </td>
                
                <td>
                	<input  class='entradaTexto ' type="tel" onKeyUp="comprobarTelefono(event,this);" id="telefono2" >
                </td>
                <td class="text">
                	<?php echo $lang[$idioma]['Cargo'];?>
                </td>
                
                <td>
                	<input  class='entradaTexto ' type="text" id="cargo" >
                </td>
                
            </tr>
            
              
          
			<tr><td colspan="4"><br><br></td></tr>
            <tr>
          
			<td colspan="4">
            <center>
            <input  type="button" class='cmd button button-highlight button-pill' onClick="actualizarProveedor('fact','<?php echo $codigo;?>');" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
           <input  type="reset" class='cmd button button-highlight button-pill' onClick="envioDeDataProveedor('Proveedor');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
          </center>
            </td>
            
             </tr>
           
        </table>
        </center>
                </form>
                <br><br><br> 


<?php
buscarFacturacion($codigo);
}
else
{
	echo "<script>alert('No existe el proveedor');llamarProveedor('1');seleccionP(document.getElementById('TabRegistro'));</script>";
}
?>