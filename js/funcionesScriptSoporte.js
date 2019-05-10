/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
 function abrirSoporte(codprov,pais,codpais)
{
	params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
	pag=window.open("../php/soporte/paginaSoporte.php?codigo="+codprov+"&pais="+pais+"&cod="+codpais,"Notificaciones",params);
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
function envioDeDataSoporte(es)
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
				llenarDatosSoporte(codi,pais,cod);
			}
			
		
	}
function llenarDatosSoporte(codigo,pais,cod)
	{
		
		$.ajax({
				url:'../soporte/buscarSoporte.php',
				type:'POST',
				data:'codigo='+codigo+'&pais='+pais+'&codpais='+cod,
				success: function(resp)
				{							
					$('#resultado').html(resp);
				}
			});
	}
	
function ingresoSoporte(cerrador)
{
	
	var estado=limpiarCaracteresEspeciales(document.getElementById('estado').value);
	var email=limpiarCaracteresEspeciales(document.getElementById('email').value);
	var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
	var ticket=limpiarCaracteresEspeciales(document.getElementById('numticket').value);
	var tipo="soporte";
	/*var combo = (document.getElementById('pais'));
	var pais = combo.options[combo.selectedIndex].text;*/
	//alert(2);
	
	setTimeout(function(){ventana('cargaLoad',300,400);},500);
		datos='email='+email+'&estado='+estado+'&tipo='+tipo+'&codigo='+codigo+'&ticket='+ticket+'&cerrador='+cerrador;
	
	
	$.ajax({
				url:'../soporte/ingresoSoporte.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{						
					$('#resultado').html(resp);
					if(tipo!="Cerrado")
					{
						setTimeout(function(){$("#cargaLoadCon").dialog("close");},1500);
					}
				}
			});
	
	
}
function ingresoSoporteUser(cerrador,tipo)
{
	
	var estado=limpiarCaracteresEspeciales(document.getElementById('estado').value);
	var email=limpiarCaracteresEspeciales(document.getElementById('email').value);
	var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
	var descripcion=limpiarCaracteresEspeciales(document.getElementById('descripcion').value);
	var ticket=limpiarCaracteresEspeciales(document.getElementById('numticket').value);
	
	/*var combo = (document.getElementById('pais'));
	var pais = combo.options[combo.selectedIndex].text;*/
	//alert(2);
	
	setTimeout(function(){ventana('cargaLoad',300,400);},500);
		datos='email='+email+'&estado='+estado+'&tipo='+tipo+'&codigo='+codigo+'&ticket='+ticket+'&cerrador='+cerrador+'&desc='+descripcion;
	
	
	$.ajax({
				url:'../soporte/ingresoSoporte.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{						
					$('#resultado').html(resp);
				}
			});
	
	
}
function seleccionGuardar(cod,tipo)
{
	if(__('descripcion').value!="")
	{
		ingresoSoporteUser(cod,tipo);
	}
	else
	{
		ingresoSoporte(cod);
	}
}
function ingresoContacto()
{
	
	var usuario=limpiarCaracteresEspeciales(document.getElementById('usuario').value);
	var asunto=limpiarCaracteresEspeciales(document.getElementById('asunto').value);
	var descripcion=limpiarCaracteresEspeciales(document.getElementById('descript').value);
	var email=limpiarCaracteresEspeciales(document.getElementById('email').value);
	var tipo="contacto";
	/*var combo = (document.getElementById('pais'));
	var pais = combo.options[combo.selectedIndex].text;*/
	//alert(2);
	
	setTimeout(function(){ventana('cargaLoadCon',300,400);},500);
		datos='usuario='+usuario+'&asunto='+asunto+'&descripcion='+descripcion+'&email='+email+'&tipo='+tipo;
	
	
	$.ajax({
				url:'../php/soporte/ingresoSoporte.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{						
					$('#resultado').html(resp);
				}
			});
	

	}

function envioCorreoContacto(nombre,apellido,ticket,email,descripcion)
{
	
	
		datos='nombre='+nombre+'&apellido='+apellido+'&ticket='+ticket+'&email='+email+'&descripcion='+descripcion;
	
	
	$.ajax({
				url:'../soporte/enviar.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{						
					$('#resultado').html(resp);
					//location.reload();
				}
			});
	
}
function envioCorreoContactoRespuesta(nombre,apellido,ticket,email,descripcion)
{
	

		datos='nombre='+nombre+'&apellido='+apellido+'&ticket='+ticket+'&email='+email+'&descripcion='+descripcion;
	
	
	$.ajax({
				url:'../soporte/enviar2.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{						
					$('#resultado').html(resp);
					//location.reload();
				}
			});
	
}