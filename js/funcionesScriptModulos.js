/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function llenarPadres(nivel)
	{
		
		$.ajax({
					url:'../../../php/llenarModulosPadres.php',
					type:'POST',
					data:'nivel='+nivel,
					success: function(resp)
					{
						
						$('#padres').html(resp);
					}
					
					
				});
		
	}
	function ingresarModulo()
{

	tipo=document.getElementById('tipo').value;
	padre=document.getElementById('padre').value;
	nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
	nivel=limpiarCaracteresEspeciales(document.getElementById('nivel').value);
	codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
	aplicacion=limpiarCaracteresEspeciales(document.getElementById('aplicacion').value);

	$.ajax({
					url:'ingresoModulos.php',
					type:'POST',
					data:'nombre='+nombre+'&padre='+padre+'&tipo='+
					tipo+'&nivel='+nivel+'&aplicacion='+aplicacion+'&codigo='+codigo,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						
					},
					error: function(resp)
					{
						alert("1");
						$('#resultado').html(resp);
						
					}
					
				});
	
}

function abrirModulo(cod)
		{
			params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
			
  			 pag=window.open("../php/menu/modulos/paginaModulos.php?codigo="+cod,"Modulos",params);
			 pag.focus();
			 
		}
		
		function envioDeDataModulos(es)
	{
		cadVariables = location.search.substring(1,location.search.length);
		arrVariables = cadVariables.split("&");
			for (i=0; i<arrVariables.length; i++) 
			{
  				arrVariableActual = arrVariables[i].split("=");
  				if (isNaN(parseFloat(arrVariableActual[1])))
    				eval(arrVariableActual[0]+"='"+unescape(arrVariableActual[1])+"';");
  				else
    				eval(arrVariableActual[0]+"='"+arrVariableActual[1]+"';");
			}
			
			if(es=='modulos')
			{
				
				llenarDatosPagModulos(arrVariableActual[1]);					
			}
				
		
	}
		
		function llenarDatosPagModulos(codigo)
		{			
			$.ajax({
					url:'../modulos/buscarModulos.php',
					type:'POST',
					data:'codigo='+codigo,
					success: function(resp)
					{
					
						
						$('#formulario').html(resp);
						
								
					
					}
					
					
				});
		}
function habilitarAplicacion()
{
	tipo=document.getElementById('tipo').value;
	if(tipo=='F')
	{
		document.getElementById('trAplicacion').hidden=false;
	}
	else
	{
		document.getElementById('trAplicacion').hidden=true;
	}
}

