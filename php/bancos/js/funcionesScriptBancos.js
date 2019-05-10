/**
 * Created by Paul Alexander Calderon
 * Unique creator
 */
function LimpiarCuentas()
	{
			
			document.getElementById('CuentaBancaria').value="";
			document.getElementById('NombreCuenta').value="";
			document.getElementById('TipoBanco').value="";
			document.getElementById('tipoCuenta').value="";
			document.getElementById('CuentaContable').value="";
			document.getElementById('codCuentaconta').value="";
			document.getElementById('tipmoneda').value="";
			document.getElementById('tipoTasaCambio').value="";
			document.getElementById('formatoFecha').value="";
			document.getElementById('conDepositos').value="";
			document.getElementById('conNotaCre').value="";
			document.getElementById('ConcepCheq').value="";
			document.getElementById('ConNotaDeb').value="";
			document.getElementById('coldoc').value="";
			document.getElementById('fildoc').value="";
			document.getElementById('coltran').value="";
			document.getElementById('filtran').value="";	
	}

function Limpiartipobancos()
	{
			document.getElementById('nombanco').value="";
			document.getElementById('nombanco').value="";
			document.getElementById('prioridad').value="";
			document.getElementById('acompra').value="";
			document.getElementById('aventa').value="";
			document.getElementById('Icompra').value="";
			document.getElementById('Iventa').value="";
			document.getElementById('prioridad').value="";
			document.getElementById('acompra').value="";
			document.getElementById('aventa').value="";
			document.getElementById('Icompra').value="";
			document.getElementById('Iventa').value="";

	}	



	function envioDeDataBancos(es)
	{
		cadVariables = location.search.substring(1,location.search.length);
		arrVariables = cadVariables.split("&");
			for (i=0; i<arrVariables.length; i++) 
			{
  				arrVariableActual = arrVariables[i].split("=");
  				if (isNaN(parseFloat(arrVariableActual[1])))
    				eval(arrVariableActual[0]+"='"+unescape(arrVariableActual[1])+"';");
  				else
    				eval(arrVariableActual[0]+"="+arrVariableActual[1]+";");
			}
			if(es=='empresa')
			{
			llenarDatosBancos(arrVariableActual[1]);
			}
			else
			{
				if(es=='user')
				{
				llenarDatosUsuario(arrVariableActual[1]);
				}
				
			}
		
	}

function actualizarTodosDatos()
{
	
	setTimeout(function(){document.getElementById('resultado').innerHTML='<img src="../../images/loader.gif" alt="" />';},1000);
	CuentaBancaria=window.opener.document.getElementById('CuentaBancaria').value;
	NombreCuenta=window.opener.document.getElementById('NombreCuenta').value;
	TipoBanco=window.opener.document.getElementById('TipoBanco').value;
	tipoCuenta=window.opener.document.getElementById('tipoCuenta').value;
	codCuentaconta=window.opener.document.getElementById('codCuentaconta').value;
	CuentaContable=window.opener.document.getElementById('CuentaContable').value;
	tipmoneda=window.opener.document.getElementById('tipmoneda').value;
	tipoTasaCambio=window.opener.document.getElementById('tipoTasaCambio').value;
	formatoFecha=window.opener.document.getElementById('formatoFecha').value;

	ConCheq=window.opener.document.getElementById('ConCheq').value;
	coldoc=window.opener.document.getElementById('coldoc').value;
	fildoc=window.opener.document.getElementById('fildoc').value;
	coltran=window.opener.document.getElementById('coltran').value;
	filtran=window.opener.document.getElementById('filtran').value;
	conNotaCre=window.opener.document.getElementById('conNotaCre').value;
	conDepositos=window.opener.document.getElementById('conDepositos').value;
	ConcepCheq=window.opener.document.getElementById('ConcepCheq').value;
	ConNotaDeb=window.opener.document.getElementById('ConNotaDeb').value;

	
	window.opener.document.location.reload();
	
	setTimeout(function(){window.opener.formulario('5');},900);
	setTimeout(function(){window.opener.document.getElementById('CuentaBancaria').value=CuentaBancaria;},1000);
	setTimeout(function(){window.opener.document.getElementById('NombreCuenta').value=NombreCuenta;},1000);
	setTimeout(function(){window.opener.document.getElementById('TipoBanco').value=TipoBanco;},1000);
	setTimeout(function(){window.opener.document.getElementById('tipoCuenta').value=tipoCuenta;},1000);
	setTimeout(function(){window.opener.document.getElementById('codCuentaconta').value=codCuentaconta;},1000);
	setTimeout(function(){window.opener.document.getElementById('CuentaContable').value=CuentaContable;},1000);
	setTimeout(function(){window.opener.document.getElementById('tipmoneda').value=tipmoneda;},1000);
	setTimeout(function(){window.opener.document.getElementById('tipoTasaCambio').value=tipoTasaCambio;},1000);
	setTimeout(function(){window.opener.document.getElementById('formatoFecha').value=formatoFecha;},1000);
	setTimeout(function(){window.opener.document.getElementById('ConCheq').value=ConCheq;},1000);
	setTimeout(function(){window.opener.document.getElementById('coldoc').value=coldoc;},1000);
	setTimeout(function(){window.opener.document.getElementById('fildoc').value=fildoc;},1000);
	setTimeout(function(){window.opener.document.getElementById('coltran').value=coltran;},1000);
	setTimeout(function(){window.opener.document.getElementById('filtran').value=filtran;},1000);
	setTimeout(function(){window.opener.document.getElementById('conNotaCre').value=conNotaCre;},1000);
	setTimeout(function(){window.opener.document.getElementById('conDepositos').value=conDepositos;},1000);
	setTimeout(function(){window.opener.document.getElementById('ConcepCheq').value=ConcepCheq;},1000);
	setTimeout(function(){window.opener.document.getElementById('ConNotaDeb').value=ConNotaDeb;},1000);
	setTimeout(salir1,1500);
		
	
}


function editarBancos()
		{
			elem=document.getElementById('ConCheq').checked;
			if(elem==true)
			{
			valor='1'; 	
			}
			else
			{
				valor='0'; 	
			}
			
  			
              
			cuenta=document.getElementById('CuentaBancaria').value;
			nombre=document.getElementById('NombreCuenta').value;
			banco=document.getElementById('TipoBanco').value;
			tipoCuen=document.getElementById('tipoCuenta').value;
			CuentaCont=document.getElementById('CuentaContable').value;
			
			TipoMoneda=document.getElementById('tipmoneda').value;
			TasaCambio=document.getElementById('tipoTasaCambio').value;

			fomratFecha=document.getElementById('formatoFecha').value;
			ConcepDep=document.getElementById('conDepositos').value;
			ConcepNotaCre=document.getElementById('conNotaCre').value;
			ConcepCheque=document.getElementById('ConcepCheq').value;
			ConcepNotaDeb=document.getElementById('ConNotaDeb').value;
			columnadoc=document.getElementById('coldoc').value;
			filadoc=document.getElementById('fildoc').value;
			columnatran=document.getElementById('coltran').value;
			filatran=document.getElementById('filtran').value;	
			$.ajax({
					url:'../php/bancos/ingresoBancos.php',
					type:'POST',
					data:'numcuen='+cuenta+ '&elemento1='+valor+'&nombre='+nombre+'&codbanc='+banco+'&Codtcuenta='+tipoCuen+'&codCuenta='+CuentaCont+'&codbanctc='+TasaCambio+'&codmone='+TipoMoneda+'&forfecha='+fomratFecha+'&condp='+ConcepDep+'&connc='+ConcepNotaCre+'&conch='+ConcepCheque+'&connd='+ConcepNotaDeb+'&COLNUM='+columnadoc+'&LINNUM='+filadoc+'&COLTRAN='+columnatran+'&LINTRAN='+filatran,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						
						LimpiarCuentas();
						llenarDatosBancos(codigo);
						
						
					
					}
				});
			
		}

function CatBancos()
		{
			
			elem=document.getElementById('tasaCambio1').checked;
			if(elem==true)
			{
			valor='1'; 	
			}
			else
			{
				valor='0'; 	
			}
			nombanco=document.getElementById('nombanco').value;
			prioridad=document.getElementById('prioridad').value;
			acompra=document.getElementById('acompra').value;
			aventa=document.getElementById('aventa').value;
			Icompra=document.getElementById('Icompra').value;
			Iventa=document.getElementById('Iventa').value;
			
			$.ajax({
					url:'ingresoCatBancos.php',
					type:'POST',
					data:'nombanco='+nombanco+'&elemento='+valor+'&prioridad='+prioridad+'&acompra='+acompra+'&aventa='+aventa+'&Icompra='+Icompra+'&Iventa='+Iventa,
					success: function(resp)
					{
						
						if(resp=='Registros Guardados')
						{   
							Limpiartipobancos();
							actualizarTodosDatos();
						}
						$('#resultado').html(resp);
						
						
						
						llenarDatosBancos(codigo);

						
					
					}
				});
			
		}

function busqueda1(e,id){ 
  tecla=(document.all) ? e.keyCode : e.which; 
  if(tecla == 13) 
  {
		ventana1(id);
  		//llenarBusqueda1('poliza','busqueda');
  }	

} 

function ventana1(id) 
{

      $( "#"+id ).dialog({
  
          maxWidth:900,
          maxHeight: 900,
          width: 800,
          height: 600,
          modal: true,
  
      });

      llenarBusqueda1('cuentasconta',id);

};

function llenarBusqueda1(tipo,id)
{
	switch(tipo)
	{
		case "cuentasconta":
		{
			$.ajax({
						url:'formularios/buscarcuentas.php',
						type:'POST',
						data:'tipo='+tipo,
						success: function(resp)
						{
							$('#'+id).html(resp);
						}
					});
				break;
		}
	}
	
}


function editarTipoCuenta()
		{
			
			nombre=document.getElementById('tipoCuenta1').value;
			 
			$.ajax({
				
					url:'ingresoTipoCuenta.php',
					type:'POST',
					data:'nombre='+nombre,
					success: function(resp)
					{
						
						if(resp==1)
						{   

							document.getElementById('tipoCuenta1').value="";
							actualizarTodosDatos();
							resp='Registros Cuardados';
						}

						$('#resultado').html(resp);

						llenarDatosBancos(codigo);
					}


					
			
				});
			
		}

function editarCuentaContable()
		{
			
			cuentaconta=document.getElementById('cuentacont').value;
			nomnombreconta=document.getElementById('nomcuentacont').value;
			$.ajax({
				
					url:'ingresoCuentaContable.php',
					type:'POST',
					data:'nombre='+nomnombreconta+'&codcuentaconta='+cuentaconta,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						
						document.getElementById('cuentacont').value="";
						document.getElementById('nomcuentacont').value="";
						 
						llenarDatosBancos(codigo);
					 	
					}

			
				});
			
		}


function cerrarmodal()
{
	setTimeout(function(){$("#busqueda").dialog("close");},1000);
}


function editarMone()
		{
			
			nombre=document.getElementById('tipomone').value;
			moneda=document.getElementById('moneda').value;
			$.ajax({
				
					url:'ingresoTipoMone.php',
					type:'POST',
					data:'nombre='+nombre+'&moneda='+moneda,
					success: function(resp)
					{
						
						if(resp==1)
						{
							actualizarTodosDatos();
							document.getElementById('tipomone').value="";
							resp='Registros Guardados';	
						}	
						$('#resultado').html(resp);
						
						
						
						llenarDatosBancos(codigo);
					 	
					}

			
				});
			
		}
		
function salir1()
{
	window.close();

}
	




function llenarDatosBancos(codigo)
		{
			
			$.ajax({
					url:'../bancos/buscarBancos.php',
					type:'POST',
					data:'codigo='+codigo,
					success: function(resp)
					{
					
						
						$('#formulario').html(resp);
					}
				});
		}


	

function actualizarcombos()
{
	tipoCuenta1=window.opener.document.getElementById('tipoCuenta1').value;
	
	window.opener.document.location.reload();
		
}

/////////////////////escribir funcion en funcionesScrip.js

//////////////////////////////////////////////////////////

function abrirMovimientoBanco(cod)
		{
			
  			 pag=window.open("../php/banco/paginaEmpresas.php?codigo="+cod,"Empresas","location=yes,Scrollbars=YES");
			 pag.focus();
			 
		}

function abrirFormTipoCuen(formul,empresa,pais)
{
	pag=window.open("../php/bancos/paginaExtras.php?formul="+formul+"&empresa="+empresa.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'')+"&ctr="+pais.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\''),"Formulario Extra","width=1500,height=900,Scrollbars=YES");
	pag.focus();
}

function abrirFormTipoCuen1(formul,empresa,pais)
{
	pag=window.open("../php/bancos/paginasubExtras.php?formul="+formul+"&empresa="+empresa.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'')+"&ctr="+pais.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\''),"Formulario Extra","width=1500,height=900,Scrollbars=YES");
	pag.focus();
}

function envioDeDataExtras1()
	{
		var1="";
		var2="";
		var3="";
		var4="";
		var5="";
		var6="";
		var7="";
		cadVariables = location.search.substring(1,location.search.length);
		arrVariables = cadVariables.split("&");
			for (i=0; i<arrVariables.length; i++) 
			{
  				arrVariableActual = arrVariables[i].split("=");
				
  				if (isNaN(parseFloat(arrVariableActual[1])))
    				{eval(arrVariableActual[0]+"='"+unescape(arrVariableActual[1])+"';");}
  				else
    				{eval(arrVariableActual[0]+"="+arrVariableActual[1]+";");}
					
					if(i==0)
					{	var1=arrVariableActual[1];
					}
					else
					{
						if(i==1)
						{var2=arrVariableActual[1];}
						else
						{
							if(i==2)
							{var3=arrVariableActual[1];}
							else
							{
								if(i==3)
								{
									var4=arrVariableActual[1];
								}
								else
								{
									if(i==4)
									{
										var5=arrVariableActual[1];
									}
									else
									{
										if(i==5)
										{
											var6=arrVariableActual[1];
										}
										else
										{
											if(i==6)
											{
												var7=arrVariableActual[1];
											}
										}
									}
								}
							}
						}
						
					}
					
			}
			
			llenarDatosExtras1(var1,var2,var3,var4,var5,var6,var7);
			
		
	}


function llenarDatosExtras1(fomul,empresa,pais,sku,prodname,bundle,univenta)
{
	switch(formul)
	{
		
		
		
		case "tipocuenta":
		{
			
			$.ajax({
					url:'formularios/formTipoCuenta.php',
					type:'POST',
					data:'empresa='+empresa+'&pais='+pais,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
					}
					
					
				});
			
			break;
		}

		case "tipocuentacont":
		{
			
			$.ajax({
					url:'formularios/formTipoCuentaCont.php',
					type:'POST',
					data:'empresa='+empresa+'&pais='+pais,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
					}
					
					
				});
			
			break;
		}

		case "tipomone":
		{
			
			$.ajax({
					url:'formularios/formTipoMone.php',
					type:'POST',
					data:'empresa='+empresa+'&pais='+pais,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
					}
					
					
				});
			
			break;
		}

		case "Banco":
		{
			
			$.ajax({
					url:'formularios/formBancos.php',
					type:'POST',
					data:'empresa='+empresa+'&pais='+pais,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
					}
					
					
				});
							
			break;
		}

		case "Conciliaciones":
		{
			
			$.ajax({
					url:'formularios/formconciliaciones.php',
					type:'POST',
					data:'empresa='+empresa,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
					}
					
					
				});
				
			break;
		}

		case "movimientoscuen":
		{
			
			$.ajax({
					url:'formularios/formmovimientoscuenta.php',
					type:'POST',
					data:'codigo='+empresa,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
					}
					
					
				});
				
			break;
		}

		
		
		case "busquedaconta":
		{
			
			$.ajax({
					url:'formularios/formbusquedaconta.php',
					type:'POST',
					data:'codigo='+empresa,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
					}
					
					
				});
				
			break;
		}

	}
}

function buscarCodigoCuenta()
		{
			codCuentaconta=document.getElementById('codCuentaconta').value;
			
			
			$.ajax({
				
					url:'../php/bancos/formularios/buscarCodigoConta.php',
					type:'POST',
					data:'codCuentaconta='+codCuentaconta,

					success: function(resp)
					{
						
						document.getElementById('CuentaContable').value=resp;
					}
				});
		}



function formatofecha()
{
		
		var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		var f=new Date();
		var fecha=("Guatemala, "+f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		var fecha1=(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		var i=0;

		var popular1 = new Option(fecha);
    	var popular2 = new Option(fecha1);
    	formatoFecha[0] = popular1
    	formatoFecha[1] = popular2

		
}


function abrirConciliacion(formul,codigo)
{
	pag=window.open("../php/bancos/paginaExtras.php?formul="+formul+"&empresa="+codigo.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\''),"Formulario Extra","width=1500,height=900,Scrollbars=YES");
	pag.focus();
}

function abrirMoviemientoscuen(formul,codigo)
{
	pag=window.open("../php/bancos/paginasubExtras.php?formul="+formul+"&empresa="+codigo.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\''),"Formulario Extra","width=1500,height=900,Scrollbars=YES");
	pag.focus();
}

function abrirMoviemientoscuen1(formul,codigo)
{
	pag=window.open("../bancos/paginasubExtras.php?formul="+formul+"&empresa="+codigo.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\''),"Formulario Extra","width=1500,height=900,Scrollbars=YES");
	pag.focus();
}