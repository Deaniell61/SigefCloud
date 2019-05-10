<?php

require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

session_start();
verTiempo3();
?>
    <script>
       

		
        function buscar() {
			
            nombre = document.getElementById('buscar').value;
           
		
            $.ajax({
               url: '../php/adminOrdenes/tablas/llenarShiSta.php',
                type: 'POST',
                data: 'nombre=' + nombre,

                success: function(resp) {
                    $('#datosF').html("");
                    $('#datosF').html(resp);

                }
            });
        }

        function buscare(e) {
			
            nombre = document.getElementById('buscar').value;
           
            if (validateEnter(e)) {
                $.ajax({
                    url: '../php/adminOrdenes/tablas/llenarShiSta.php',
                    type: 'POST',
                    data: 'nombre=' + nombre,

                    success: function(resp) {
                        $('#datosF').html("");
                        $('#datosF').html(resp);

                    }
                });
            }
        }

	
    </script>
    <center>
        <?php echo $lang[$idioma]['shista'];?>
    </center>
    <aside>
        <div id="resultadoF"></div>

        <table>
            <tr>
                <td>
                    <input type="text" class='entradaTexto' id="buscar" name="buscar" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscare(event);" />
                </td>

                <td>
                    <div class="">
                        <input type="button" class='cmd button button-highlight button-pill' onClick="buscar();" value="<?php echo $lang[$idioma]['Buscar']?>" />
                    </div>
                </td>
               <td>
                    <div class="">
                        <input class='cmd button button-highlight button-pill' type="button" onClick="abrirAdminOrder('ShiSta','');" value="<?php echo $lang[$idioma]['Nuevo']?>" />
                    </div>
                </td>
            </tr>

        </table>
    </aside>
	
    <div id="datosF">
        <script>
		
            buscar();

        </script>
    </div>

    </div>
