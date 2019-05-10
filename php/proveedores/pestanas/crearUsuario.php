<?php
require_once('../../fecha.php');
$idioma=idioma();
require_once('../../idiomas/'.$idioma.'.php');
$codigo= strtoupper($_POST['codigo']);
		session_start();			
?>
<form id="usuarios" name="usuarios" action="return false" onSubmit="return false" method="POST">
                	<center>
        <table>
        	<tr>
            	<?php echo $lang[$idioma]['EditarUsuarios'];?>
                </tr>
                <tr><div id="resultadouserporv"></div></tr>
				<tr><input type="text" class='entradaTexto' hidden="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" disabled/> </tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Nombre'];?></span></td>
                <td><input type="text" class='entradaTexto' autocomplete="off" name="nombre" id="nombre" onKeyUp="llenarDatoUsuario(document.getElementById('nombre'),document.getElementById('apellido'),document.getElementById('usuario'));"></td>
            </tr>
            
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Apellido'];?></span></td>
                <td><input type="text" class='entradaTexto' autocomplete="off" name="apellido" id="apellido" onKeyUp="llenarDatoUsuario(document.getElementById('nombre'),document.getElementById('apellido'),document.getElementById('usuario'));" ></td>
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Usuario'];?></span></td>
                <td><input type="text" class='entradaTexto' disabled autocomplete="off" name="usuario" id="usuario" ></td>
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Email'];?></span></td>
                <td><input type="text" class='entradaTexto' onKeyUp="comprobarEmailProv('email');" autocomplete="off" name="email" id="email"></td>
            </tr>
            <tr>
			<tr hidden>
            	<td class="text"><span><?php echo $lang[$idioma]['Tipo'];?> </span></td>
                <td>
					<select class='entradaTexto' id="rol">
                        <option value="P" selected><?php echo $lang[$idioma]['Proveedor'];?></option>
					</select>
				</td>
            </tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Contra'];?></span></td>
                <td><input class='entradaTexto' type="password" autocomplete="off" name="contra" id="contrase" value="" placeholder="*********" ></td>
            </tr>
             
			<tr hidden>
            	<td class="text"><span><?php echo $lang[$idioma]['Estado'];?></span></td>
                <td>
					<select class='entradaTexto' id="estado">
						<option value="21" selected ><?php echo $lang[$idioma]['Activo'];?></option>
						
					</select>
				</td>
            </tr>
		
                        
                        
            <tr>

            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill' onClick="GuardarUsuarioProveedor('<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['codprov'];?>','<?php echo $_SESSION['nomProv'];?>');" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"   class='cmd button button-highlight button-pill' onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                <br>
<div id="cargaLoadVP"></div>
<?php


?>