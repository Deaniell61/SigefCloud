<?php
require_once('../../php/fecha.php');
require_once('../../php/sesiones.php');
$idioma=idioma();
include('../../php/idiomas/'.$idioma.'.php');
session_start();
verTiempo3();
?>
<link href="../css/lib/c3.css" rel="stylesheet" type="text/css">
<script src="../js/bootstrap.min.js" type="text/javascript"></script>

<div style=" width:97%; top:150px; text-align:left; z-index:0;" >
<div class="guardar">
				<!--<input type="button"   class='cmd button button-highlight button-pill'  onClick="document.getElementById('filtro').value='1';cargarGrafico('1',document.getElementById('filtro').value,'<?php echo $_SESSION['codprov'];?>');cargarGrafico('2',document.getElementById('filtro').value,'<?php echo $_SESSION['codprov'];?>');" value="<?php echo $lang[$idioma]['Cancelar'];?>" />   -->
              <input type="button"  class='cmd button button-highlight button-pill'  onClick="window.location.href='inicioEmpresa.php'" value="<?php echo $lang[$idioma]['Salir'];?>"/>
			  </div>
			  </div>

	<div class="menuGrafico">
    
    	<ul class="nav nav-stacked" id="accordion1">
            <li class="panel"> <a data-toggle="collapse" data-parent="#accordion1" href="#firstLink"><?php echo $lang[$idioma]['SalesSummary'];?></a>

                <ul id="firstLink" class="collapse">
                    <center>
                    	<li onClick="cargarFormularioGrafico('1');" class="menuCollapseLi"><?php echo $lang[$idioma]['Dashboard'];?></li>
                        
                    </center>
                    
                    
                </ul>
              
            </li>
            
        </ul>
        <ul class="nav nav-stacked" id="accordion2">
            <li class="panel"> <a data-toggle="collapse" data-parent="#accordion2" href="#firstLink2"><?php echo $lang[$idioma]['OrdersSummary'];?></a>

                <ul id="firstLink2" class="collapse">
                    <center>
                    	<li onClick="cargarFormularioGrafico('2');" class="menuCollapseLi"><?php echo $lang[$idioma]['OrdersSummary'];?></li>
                    </center>
                    
                    
                </ul>
              
            </li>
            
        </ul>
        <ul class="nav nav-stacked" id="accordion3">
            <li class="panel"> <a data-toggle="collapse" data-parent="#accordion3" href="#firstLink3"><?php echo $lang[$idioma]['InventorySummary'];?></a>

                <ul id="firstLink3" class="collapse">
                    <center>
                    	<li onClick="cargarFormularioGrafico('4');" class="menuCollapseLi"><?php echo $lang[$idioma]['InventorySummary'];?></li>
                    </center>
                    
                    
                </ul>
              
            </li>
            
        </ul>
        
   		 
    </div>
   
    <div class="contenidoGrafico" id="contenidoGraf">
    <script>cargarFormularioGrafico('1');</script>
    </div>

<div id="cargaLoadG">

</div>




