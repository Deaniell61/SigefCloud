/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
 function abrirNotificacion(codprov,pais,codpais)
{
	params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
	pag=window.open("../php/notificaciones/paginaNotificacion.php?codigo="+codprov+"&pais="+pais+"&cod="+codpais,"Notificaciones",params);
			 pag.focus();
		/*$.ajax({
				url:'../php/notificaciones/paginaNotificacion.php',
				type:'POST',
				data:'codigo='+codprov,
				success: function(resp)
				{							
					$('#NotificacionVentana').html(resp);
				}
			});	
	ventana('NotificacionVentana',screen.height,screen.width) ;*/
		
			 
}
function envioDeDataNotificaciones(es)
	{
		var pais="";
		var codi="";
		cadVariables = location.search.substring(1,location.search.length);
		arrVariables = cadVariables.split("&");
			for (i=0; i<arrVariables.length; i++) 
			{
  				arrVariableActual = arrVariables[i].split("=");
  				if (isNaN(parseFloat(arrVariableActual[1])))
    				eval(arrVariableActual[0]+"='"+unescape(arrVariableActual[1])+"';");
  				else
    				eval(arrVariableActual[0]+"="+arrVariableActual[1]+";");
					
					if(i==0)
					{
						codi=arrVariableActual[1];
						}
					if(i==1)
					{
						pais=arrVariableActual[1];
						}
					if(i==2)
					{
						codpais=arrVariableActual[1];
						}
			}
			
			
			{	
				llenarDatosNotificaciones(codi,pais,cod);
			}
			
		
	}
function llenarDatosNotificaciones(codigo,pais,cod)
	{
		$.ajax({
				url:'../notificaciones/buscarNotificacion.php',
				type:'POST',
				data:'codigo='+codigo+'&pais='+pais+'&codpais='+cod,
				success: function(resp)
				{							
					$('#resultado').html(resp);
				}
			});
	}
	
function ingresoNotificacion()
{
	
	var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
	var notifica=limpiarCaracteresEspeciales(document.getElementById('notifica').value);
	var destino=limpiarCaracteresEspeciales(document.getElementById('destino').value);
	var condicion=limpiarCaracteresEspeciales(document.getElementById('condicion').value);
	var estatus=limpiarCaracteresEspeciales(document.getElementById('estado').value);
	var fechaini=limpiarCaracteresEspeciales(document.getElementById('fechaini').value);
	var fechafin=limpiarCaracteresEspeciales(document.getElementById('fechafin').value);
	/*var combo = (document.getElementById('pais'));
	var pais = combo.options[combo.selectedIndex].text;*/
	//alert(2);
	
	
		datos='codigo='+codigo+'&notifica='+notifica+'&destino='+destino+'&condicion='+condicion+'&estatus='+estatus+'&fechaini='+fechaini+'&fechafin='+fechafin;
	
	$.ajax({
				url:'../notificaciones/ingresoNotificacion.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{							
					$('#resultado').html(resp);
				}
			});
	
}