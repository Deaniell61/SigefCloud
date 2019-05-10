/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */

function cargarGrafico(tipo,fecha,prov,id)
{
	ventana('cargaLoadG',300,400);
	
            $.ajax({
                url: '../php/graficos/cargarGraficos.php',
                type: 'POST',
                data: 'codigo='+prov+'&fecha='+fecha+'&id='+id+'&tipo='+tipo,
                success: function (resp) {
                    $('#comoGraficar').html(resp);
                }
            });
           
    
}
function cargarFormularioGrafico(tipo)
{
	switch(tipo)
	{
		case '1':
		{
			$('.menuGrafico').css('margin-top','-10000000000000px');
			$.ajax({
                url: '../php/graficos/dashboardVentas.php',
                type: 'POST',
                success: function (resp) {
                    $('#contenidoGraf').html(resp);
                }
            });
			break;
		}
		case '2':
		{
			$('.menuGrafico').css('margin-top','0');
			$.ajax({
                url: '../php/graficos/orderSummary/formOrderSummary.php',
                type: 'POST',
                success: function (resp) {
                    $('#contenidoGraf').html(resp);
                }
            });
			break;
		}
		case '3':
		{
			$('.menuGrafico').css('margin-top','-10000000000000px');
			ventana('cargaLoadG',300,400);
			fechaF=document.getElementById('fechaF').value;
			fechaI=document.getElementById('fechaI').value;
			$.ajax({
                url: '../php/graficos/orderSummary/cargarOrderSummary.php',
                type: 'POST',
				data:'fechaI='+fechaI+'&fechaF='+fechaF,
                success: function (resp) {
                    $('#contenidoGraf').html(resp);
                }
            });
			break;
		}
		case '4':
		{
			$('.menuGrafico').css('margin-top','0');
			$.ajax({
                url: '../php/graficos/inventorySummary/formInventorySummary.php',
                type: 'POST',
                success: function (resp) {
                    $('#contenidoGraf').html(resp);
                }
            });
			break;
		}
		case '5':
		{
			$('.menuGrafico').css('margin-top','-10000000000000px');
			ventana('cargaLoadG',300,400);
			bodega=document.getElementById('bodega').value;
			$.ajax({
                url: '../php/graficos/inventorySummary/cargarInventorySummary.php',
                type: 'POST',
				data:'bodega='+bodega,
                success: function (resp) {
                    $('#contenidoGraf').html(resp);
                }
            });
			break;
		}
	}
	
            
           
    
}
