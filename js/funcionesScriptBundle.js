function envioDeDataBundle(es)
{
		var1="";
		var2="";
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
						var1=arrVariableActual[1];
					}
					if(i==1)
					{
						var2=arrVariableActual[1];
					}
			}
			if(es=='Canal')
			{
					
			llenarDatosCanal(var1,var2);
			}
		
	}
	
function abrirCanal(codChan)
{
	pais=document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
	pag=window.open("../php/productos/DatosBundle/paginaNuevoCanal.php?codigo="+codChan+"&pais="+pais,"Canales","width=1095,height=650,top=40%,right=75%,Scrollbars=YES");
			 pag.focus();
}

function llenarDatosCanal(codigo,pais)
{
		
	$.ajax({
			url:'buscarCanales.php',
			type:'POST',
			data:'codigo='+codigo+'&pais='+pais,
			success: function(resp)
			{
				$('#formulario').html(resp);
			}});
			
}
function guardarCanal(selec,num,pais)
{

			
			nombreCanal=document.getElementById('chaName').value;
			pminSale=document.getElementById('pminsale').value;
			codcha=document.getElementById('codchan').value;
			columna=document.getElementById('columna').value;
			bundle1=document.getElementById('bundle1').value;
			bundle2=document.getElementById('bundle2').value;
			bundle3=document.getElementById('bundle3').value;
			bundle4=document.getElementById('bundle4').value;
			bodega=document.getElementById('Warehouse').value;
			formula=document.getElementById('formula').value;
			codParpri=document.getElementById('codparpri').value;
			
			$.ajax({
			url:'ingresoCanal.php',
			type:'POST',
			data:'chaname='+nombreCanal+'&pminsale='+pminSale+'&codigo='+codcha+'&columna='+columna+'&bundle1='+bundle1+'&bundle2='+bundle2+'&bundle3='+bundle3+'&bundle4='+bundle4+'&parametro='+selec+'&num='+num+'&pais='+pais+'&bodega='+bodega+'&formula='+formula+'&codparpri='+codParpri,
			success: function(resp)
			{
				
				$('#resultado').html(resp);
			}});
		
}
function guardarParametros(canal,parametro,pais)
{

			
			nombreCanal=document.getElementById('chaName').value;
			pminSale=document.getElementById('pminsale').value;
			codcha=document.getElementById('codchan').value;
			columna=document.getElementById('columna').value;
			bundle1=document.getElementById('bundle1').value;
			bundle2=document.getElementById('bundle2').value;
			bundle3=document.getElementById('bundle3').value;
			bundle4=document.getElementById('bundle4').value;
			bodega=document.getElementById('Warehouse').value;
			
			$.ajax({
			url:'ingresoCanal.php',
			type:'POST',
			data:'chaname='+nombreCanal+'&pminsale='+pminSale+'&codigo='+codcha+'&columna='+columna+'&bundle1='+bundle1+'&bundle2='+bundle2+'&bundle3='+bundle3+'&bundle4='+bundle4+'&parametro='+selec+'&num='+num+'&pais='+pais+'&bodega='+bodega,
			success: function(resp)
			{
				
				$('#resultado').html(resp);
			}});
		
}

function llenarParametros(chan,pais)
{
	$.ajax({
			url:'parametros.php',
			type:'POST',
			data:'chan='+chan+'&pais='+pais+'&check=0',
			success: function(resp)
			{
				
				$('#chanParam').html(resp);
			}});
}

function agregarParametro(codigo,check,pais)
{
	chan=document.getElementById('codChan').value;
	if(check)
	{
		check1=1;
	}
	else
	{
		check1=2;
	}
	$.ajax({
			url:'parametros.php',
			type:'POST',
			data:'codpar='+codigo+'&pais='+pais+'&check='+check1+'&chan='+chan,
			success: function(resp)
			{
				$('#resultado').html(resp);
			}});
}

function cargarParametros(codigo,chan,pais)
{
	
	$.ajax({
			url:'buscarParametros.php',
			type:'POST',
			data:'codpar='+codigo+'&pais='+pais+'&chan='+chan,
			success: function(resp)
			{
				$('#resultado').html(resp);
			}
			});
			
	
}
function asignarExtras(formul,empresa,pais)
{
	pag=window.open("../paginaExtras.php?formul="+formul+"&empresa="+empresa.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'')+"&ctr="+pais.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\''),"Formulario Extra","width=700,height=350,top=60%,right=50%,Scrollbars=YES");
			
			 pag.focus();
}

function limpiarCamposParametro()
{
									document.getElementById('factor').value='';
									document.getElementById('valueFactor').value='';
									document.getElementById('opera').value='';
									document.getElementById('formula').value='';
									document.getElementById('formulaR').value='';
									document.getElementById('formulaFBG').value='';
									document.getElementById('account').value='';
									document.getElementById('order').value='';
									document.getElementById('valorRegistro').value='';
									document.getElementById('valor').value='';
									document.getElementById('codparpri').value='';
									document.getElementById('columna2').value='';
}

