/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
 function abrirAdminOrder(aux,cod)
{
	params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
	pag=window.open("../php/adminOrdenes/paginaOrdenes.php?formul="+aux+"&codigo="+cod,"Ordenes",params);
			 pag.focus();
		
		
			 
}
function envioDeDataAuxOrdenes(es)
	{
		var cod="";
		var formul="";
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
						formul=arrVariableActual[1];
						}
					if(i==1)
					{
						cod=arrVariableActual[1];
						}
					
			}
			
			
			{	
				llenarDatosAuxOrdenes(formul,cod);
			}
			
		
	}
function llenarDatosAuxOrdenes(formul,cod)
	{
		switch(formul)
		{
			case 'ShiSta':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/paginaShiSta.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#ordenesAux').html(resp);
						}
					});
				
				break;
			}
			case 'ShiMdo':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/paginaShiMdo.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#ordenesAux').html(resp);
						}
					});
				
				break;
			}
			case 'OrdSta':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/paginaOrdSta.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#ordenesAux').html(resp);
						}
					});
				
				break;
			}
			case 'PaySta':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/paginaPaySta.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#ordenesAux').html(resp);
						}
					});
				
				break;
			}
			case 'PayMdo':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/paginaPayMdo.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#ordenesAux').html(resp);
						}
					});
				
				break;
			}
			case 'TOrden':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/paginaTOrden.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#ordenesAux').html(resp);
						}
					});
				
				break;
			}
			case 'ShiCarrier':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/paginaShiCarrier.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#ordenesAux').html(resp);
						}
					});
				
				break;
			}
		}
		
	}
function buscarDatosAuxOrdenes(formul,cod)
	{
		switch(formul)
		{
			case 'ShiSta':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/busqueda/buscarAux.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#resultado').html(resp);
						}
					});
				
				break;
			}
			case 'ShiMdo':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/busqueda/buscarAux.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#resultado').html(resp);
						}
					});
				
				break;
			}
			case 'OrdSta':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/busqueda/buscarAux.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#resultado').html(resp);
						}
					});
				
				break;
			}
			case 'PaySta':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/busqueda/buscarAux.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#resultado').html(resp);
						}
					});
				
				break;
			}
			case 'PayMdo':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/busqueda/buscarAux.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#resultado').html(resp);
						}
					});
				
				break;
			}
			case 'TOrden':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/busqueda/buscarAux.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#resultado').html(resp);
						}
					});
				
				break;
			}
			case 'ShiCarrier':
			{
				$.ajax({
						url:'../adminOrdenes/formularios/busqueda/buscarAux.php',
						type:'POST',
						data:'codigo='+cod+'&tipo='+formul,
						success: function(resp)
						{							
							$('#resultado').html(resp);
						}
					});
				
				break;
			}
		}
		
	}

function ingresoAux(tipo)
{
	
	switch(tipo)
	{
		case 'shiSta':
		{
			var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
			var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
			datos='codigo='+codigo+'&nombre='+nombre+'&tipo='+tipo;
			break;
		}
		case 'shiMdo':
		{
			var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
			var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
			datos='codigo='+codigo+'&nombre='+nombre+'&tipo='+tipo;
			break;
		}
		case 'ordSta':
		{
			var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
			var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
			datos='codigo='+codigo+'&nombre='+nombre+'&tipo='+tipo;
			break;
		}
		case 'paySta':
		{
			var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
			var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
			datos='codigo='+codigo+'&nombre='+nombre+'&tipo='+tipo;
			break;
		}
		case 'payMdo':
		{
			var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
			var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
			var descripcion=limpiarCaracteresEspeciales(document.getElementById('descripcion').value);
			var cuentas=(document.getElementById('cuentacob').value);
			//alert(cuentas);
			datos='codigo='+codigo+'&nombre='+nombre+'&descripcion='+descripcion+'&tipo='+tipo+'&cuentas='+cuentas;
			
			break;
		}
		case 'shiCarrier':
		{
			var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
			var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
			var username=limpiarCaracteresEspeciales(document.getElementById('username').value);
			var apikey=limpiarCaracteresEspeciales(document.getElementById('apikey').value);
			var apiurl=limpiarCaracteresEspeciales(document.getElementById('apiurl').value);
			var urldeliver=limpiarCaracteresEspeciales(document.getElementById('urldeliver').value);
			datos='codigo='+codigo+'&nombre='+nombre+'&username='+username+'&apikey='+apikey+'&apiurl='+apiurl+'&urldeliver='+urldeliver+'&tipo='+tipo;
			break;
		}
		case 'tOrden':
		{
			var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
			var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
			datos='codigo='+codigo+'&nombre='+nombre+'&tipo='+tipo;
			break;
		}
	}
		
	$.ajax({
				url:'../adminOrdenes/ingresoAuxiliares.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{							
					$('#resultado').html(resp);
				}
			});
	
}