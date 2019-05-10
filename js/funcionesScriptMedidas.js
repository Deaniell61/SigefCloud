/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
 function abrirMedidas(codprov,pais,codpais)
{
	params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
	pag=window.open("../php/unidadesMedida/paginaMedida.php?codigo="+codprov+"&pais="+pais+"&cod="+codpais,"Notificaciones",params);
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
function envioDeDataMedidas(es)
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
				llenarDatosMedidas(codi,pais,cod);
			}
			
		
	}
function llenarDatosMedidas(codigo,pais,cod)
	{
		$.ajax({
				url:'../unidadesMedida/buscarMedida.php',
				type:'POST',
				data:'codigo='+codigo+'&pais='+pais+'&codpais='+cod,
				success: function(resp)
				{							
					$('#resultado').html(resp);
				}
			});
	}
	
function ingresoMedidas()
{
	
	var codigo=limpiarCaracteresEspeciales(document.getElementById('codigo').value);
	var nombre=limpiarCaracteresEspeciales(document.getElementById('nombre').value);
	var abre=limpiarCaracteresEspeciales(document.getElementById('abre').value);
	var factor=limpiarCaracteresEspeciales(document.getElementById('factor').value);
	var opera=limpiarCaracteresEspeciales(document.getElementById('opera').value);
	/*var combo = (document.getElementById('pais'));
	var pais = combo.options[combo.selectedIndex].text;*/
	//alert(opera);
	
	
		datos='codigo='+codigo+'&nombre='+nombre+'&abre='+abre+'&factor='+factor+'&opera='+opera;
	
	$.ajax({
				url:'../unidadesMedida/ingresoMedida.php',
				type:'POST',
				data:datos,
				success: function(resp)
				{							
					$('#resultado').html(resp);
				}
			});
	
}