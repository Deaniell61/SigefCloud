<?php

require_once('../fecha.php');
require_once('../combosVarios.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

session_start();

?>
<script>
	function cargaAuto()
	{
		DB=document.getElementById('db').value;
		plat=document.getElementById('pla').value;
		$.ajax({
					url:'../php/combosVarios.php',
					type:'POST',
					data:'tipo=dbTable&db='+DB+'&plat='+plat,
					success: function(resp)
					{
						
						$('#scripting').html(resp);
						
						
					}
					
				});
	}
    function cargaColumna(obj)
	{
        if(obj.checked==true)
        {
            DB=document.getElementById('db').value;
            plat=document.getElementById('pla').value;
            tabla=document.getElementById('tablaDB').value;
            $.ajax({
                        url:'../php/combosVarios.php',
                        type:'POST',
                        data:'tipo=dbColumna&db='+DB+'&plat='+plat+'&tabla='+tabla,
                        success: function(resp)
                        {
                            
                            $('#scripting2').html(resp);
                            
                            
                        }
                        
                    });
        }
	}
</script>
    
    <center>
        <?php echo $lang[$idioma]['cataux'];?>
    </center>
    <aside>
        <div id="resultado"></div>
		<div style="position:absolute; width:97%; top:150px; text-align:left; z-index:0;" >
				<div class="guardar">
				<input type="button"   class='cmd button button-highlight button-pill'  onClick="document.getElementById('filtro').value='1';document.getElementById('buscar').value='';buscar();" value="<?php echo $lang[$idioma]['Cancelar'];?>" />   
              <input type="button"  class='cmd button button-highlight button-pill'  onClick="window.location.href='inicio.php'" value="<?php echo $lang[$idioma]['Salir'];?>"/>
			  </div>
		</div>

        
          
    </aside>
	
    <div id="datos">
    <center>
       <table id="adminBD">
       	<tr>
        	<td class="text"><?php echo $lang[$idioma]['Plataforma'];?></td>
            <td><center><select id="pla" class="entradaTexto textoGrande" style="width:100%;" onChange="cargaAuto();">
            	<option value=""><?php echo $lang[$idioma]['Sigef'];?></option>
                <option value="R"><?php echo $lang[$idioma]['RSigef'];?></option>
            		</select></center></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['BaseDatos'];?></td>
            <td><center><select id="db" class="entradaTexto textoGrande" style="width:100%;" onChange="cargaAuto();">
            	<option value="1"><?php echo $lang[$idioma]['Sistema'];?></option>
                <option value="2"><?php echo $lang[$idioma]['Empresas'];?></option>
            		</select></center></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['Tabla'];?></td>
            <td><center><div class="ui-widget" style="text-align:left;">
                            <input type="text" class='entradaTexto' id="tablaDB" onKeyDown="document.getElementById('existe').checked=false;">
                            <input type="checkbox" id="existe" style="display:none;">
                                </div></center></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['Campo'];?></td>
            <td><center><div class="ui-widget" style="text-align:left;">
                            <input type="text" class='entradaTexto textoGrande' id="campo" onKeyDown="document.getElementById('existeC').checked=false;" style="width:100%;">
                            <input type="checkbox" id="existeC" style="display:none;">
                                </div></center></td>
            <td id="CambiarNombre" style="display:none;">
                <input type="checkbox" id="cambiaNom" style="cursor:pointer;" onChange="if(this.checked){__('nuevoCampoRW').style.display='table-row';}else{__('nuevoCampoRW').style.display='none';}">
                <label for="cambiaNom" style="cursor:pointer;">&nbsp Cambiar Nombre</label>
            </td>
        </tr>
        <tr id="nuevoCampoRW" style="display:none;">
        	<td class="text"><?php echo $lang[$idioma]['CampoNuevo'];?></td>
            <td><center><input type="text" class='entradaTexto textoGrande' id="nuevoCampo" onKeyDown="if(this.value!=''){__('existeN').checked=true;}else{__('existeN').checked=false;}" style="width:100%;">
                        <input type="checkbox" id="existeN" style="display:none;">
                    </center></td>
            
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['Tipo'];?></td>
            <td><center><select id="tipo" class="entradaTexto textoGrande" style="width:100%;">
            	<option value="VARCHAR">VARCHAR</option>
                <option value="INT">INT</option>
                <option value="DATETIME">DATETIME</option>
                <option value="TINYINT">TINYINT</option>
                <option value="DECIMAL">DECIMAL</option>
                <option value="TEXT">TEXT</option>
            		</select></center></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['Tamano'];?></td>
            <td><center><input type="text" class='entradaTexto textoGrande' id="tam" style="width:100%;"></center></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['Null'];?></td>
            <td><center><input type="checkbox" id="nullll"></center></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['AutoNum'];?></td>
            <td><center><input type="checkbox" id="AutoNum"></center></td>
        </tr>
        <tr>
        	<td class="text"><?php echo $lang[$idioma]['PK'];?></td>
            <td><center><input type="checkbox" id="PK"></center></td>
        </tr>
        <tr>
        <td></td>
        	<td colspan="1">
            		<div class="guardar">
				<input type="button"   class='cmd button button-highlight button-pill'  onClick="agregarColumnaDBDB();" value="<?php echo $lang[$idioma]['Guardar'];?>" />   
             
			  </div>
            </td>
        </tr>
        
       </table>
       </center>	
    </div>

    </div>
    <div id="scripting">
<script>
	cargaAuto();
</script>
    </div>
    <div id="scripting2">
<script>
	
</script>
    </div>
    <script>
		
    var availableTags = [ ""
      
    ];
    var availableTagsC = [ ""
      
    ];
    $( "#tablaDB" ).autocomplete({
		
      source: availableTags,
	  position: { my : "right top", at: "right bottom" },
	  select: function(){document.getElementById('existe').checked=true;cargaColumna(document.getElementById('existe'));},
	  open: function(){document.getElementById('existe').checked=false;}
	  
    });
    $( "#campo" ).autocomplete({
		
      source: availableTagsC,
	  position: { my : "right top", at: "right bottom" },
	  select: function(){document.getElementById('existeC').checked=true;document.getElementById('CambiarNombre').style.display="table-cell";},
	  open: function(){document.getElementById('existeC').checked=false;document.getElementById('CambiarNombre').style.display="table-column";}
	  
    });
	
	</script>