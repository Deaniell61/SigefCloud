
function fechaActual()
{		var f=new Date();
		fecha=document.getElementById('fecha').value
		if(fecha==null || fecha=="")
		{
			fecha2=(f.getDate()+"-"+f.getMonth()+"-"+f.getFullYear());
			document.getElementById('fecha').value=fecha2;
		}
		else
		{
			document.getElementById('fecha').value=f;
		}
		
		
		
}

 /*function valdacionfechas()
        {
            var f=new Date();
            fecha2=(f.getFullYear()+"-"+f.getMonth()+"-"+f.getDate());
 			fecha=document.getElementById('fecha').value;

          valuesStart=fecha2.split("-");
            valuesEnd=fecha.split("-");
            var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
            var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
            if(dateStart<=dateEnd)
            {
                alert('la fecha es mayor');
            }
           else
           {
           	alert('la fecha saber');
           }
            
        }
 
       
*/

function buscarCodigoPoliza()
		{
			
			cuentapoliza=document.getElementById('cuentapoliza').value;
						
			$.ajax({
				
					url:'../bancos/formularios/buscarCodigoConta.php',
					type:'POST',
					data:'codCuentaconta='+cuentapoliza,

					success: function(resp)
					{
						document.getElementById('nombrecuentapoliza').value=resp;
					}
				});
		}







function limparmovimientoTraCuen()
{

	document.getElementsByName('group2').value=""; 
  	document.getElementById('nonegociable').checked=false;
	document.getElementById('ordenpago').value="";
	document.getElementById('numero').value="";
	document.getElementById('fecha').value="";
	document.getElementById('tasacambio1').value="";
	document.getElementById('numvalor').value="";
	document.getElementById('beneficia').value="";
	document.getElementById('concepto').value="";
	document.getElementById('embarque').value="";
	//document.getElementById('poliza').value="";
	document.getElementById('codcuen').value="";
}

function limparpolizatrapoldet()
{
	document.getElementById('cuentapoliza').value="";
	document.getElementById('nombrecuentapoliza').value="";
	document.getElementById('debe').value="";
	document.getElementById('haber').value="";
}


function movimientoTraCuen()
		{
		
		totaldebe=parseInt(document.getElementById('totaldebe').value);
		totalhaber=parseInt(document.getElementById('totalhaber').value);

		if(totaldebe==totalhaber)
		{


var validacion;
var tipo;		
	/*	var f=new Date();
		var fecha2=(f.getDate()+f.getMonth()+f.getFullYear());
		
		f1=document.getElementById('fecha').value; 
		var fecha3=(f1.getDate()+f.getMonth()+f.getFullYear());

		*/
		
			elem1=document.getElementsByName('group2'); 
  			 for(i=0;i<elem1.length;i++) 
       		 if (elem1[i].checked) { 
             valor1 = elem1[i].value; 
              }
			

			if(valor1==1)
            {
            	tipo="DP";
            }
        if(valor1==2)
            {
            	tipo="NC";
            }
		if(valor1==3)
            {
            	tipo="CH";
            }
         if(valor1==4)
            {
            	tipo="ND";
            }

			elem=document.getElementById('nonegociable').checked;
			if(elem==true)
			{
			valor='1'; 	
			}
			else
			{
				valor='0'; 	
			}

			codpoliza1=document.getElementById('codpoliza1').value;
			codcuen=document.getElementById('codcuen').value;
			numero=document.getElementById('numero').value;
			fecha=document.getElementById('fecha').value;
			concepto=document.getElementById('concepto').value;
			beneficia=document.getElementById('beneficia').value;
			numvalor=document.getElementById('numvalor').value;
			tasacambio1=document.getElementById('tasacambio1').value;
			ordenpago=document.getElementById('ordenpago').value;
			embarque=document.getElementById('embarque').value;
			poliza=document.getElementById('poliza').value;
			moneda=document.getElementById('moneda').value;
			statcheque=2;	

			

			$.ajax({
					url:'ingresoTraPoliza.php',
					type:'POST',
					data:'tipo='+tipo+'&numero='+numero+'&fecha='+fecha+'&tasacambio1='+tasacambio1+'&poliza='+poliza+'&concepto='+concepto,
					success: function(resp)
					{
						
						if(resp!=null)
						{   
							setTimeout(llenarcodigos(),2000);
							
							
						}
											
					}
				});
		}
		else
		{
			alert('las columnas debe y haber no son iguales ')
		}
	
		}
			
	

function llenarcodigos()
{
	poliza=document.getElementById('poliza').value;

	$.ajax({
				
					url:'../bancos/formularios/BuscarCodigoPolEnc.php',
					type:'POST',
					data:'poliza='+poliza,

					success: function(resp)
					{
						document.getElementById('codpoliza1').value=resp;
						
						if(resp!=null)
						{   
							
							setTimeout(llenarcodcuen(),2000);
							
						}
					}
				});

}

function llenarcodcuen()
{
	var validacion;
	var tipo;		

	
		
			elem1=document.getElementsByName('group2'); 
  			 for(i=0;i<elem1.length;i++) 
       		 if (elem1[i].checked) { 
             valor1 = elem1[i].value; 
              }
			

			if(valor1==1)
            {
            	tipo="DP";
            }
        if(valor1==2)
            {
            	tipo="NC";
            }
		if(valor1==3)
            {
            	tipo="CH";
            }
         if(valor1==4)
            {
            	tipo="ND";
            }

			elem=document.getElementById('nonegociable').checked;
			if(elem==true)
			{
			valor='1'; 	
			}
			else
			{
				valor='0'; 	
			}

			codpoliza1=document.getElementById('codpoliza1').value;
			codvoucher=document.getElementById('codvoucher').value;
			codproy=document.getElementById('codproy').value;
			codcuen=document.getElementById('codcuen').value;
			numero=document.getElementById('numero').value;
			fecha=document.getElementById('fecha').value;
			concepto=document.getElementById('concepto').value;
			beneficia=document.getElementById('beneficia').value;
			numvalor=document.getElementById('numvalor').value;
			tasacambio1=document.getElementById('tasacambio1').value;
			ordenpago=document.getElementById('ordenpago').value;
			embarque=document.getElementById('embarque').value;
			poliza=document.getElementById('poliza').value;
			moneda=document.getElementById('moneda').value;
			
			var f=new Date();
            fecha2=(f.getFullYear()+"-"+f.getMonth()+"-"+f.getDate());
 			fecha=document.getElementById('fecha').value;

          valuesStart=fecha2.split("-");
            valuesEnd=fecha.split("-");
            var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
            var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
            if(dateStart<=dateEnd)
            {
                statcheque=3;
            }
           else
           {
           		statcheque=2;
           }

				
	
			$.ajax({
					url:'ingresoMovimientoCuentas.php',
					type:'POST',
					data:'codcuen='+codcuen+'&numero='+numero+'&fecha='+fecha+'&valor1='+valor1+'&concepto='+concepto+'&beneficia='+beneficia+'&numvalor='+numvalor+'&valor='+valor+'&tasacambio1='+tasacambio1+'&ordenpago='+ordenpago+'&codpoliza1='+codpoliza1+'&moneda='+moneda+'&statcheque='+statcheque+'&codvoucher='+codvoucher+'&codproy='+codproy+'&embarque='+embarque+'&poliza='+poliza,
					success: function(resp)
					{
						
						if(resp==1)
						{   
							
							setTimeout(buscarcodcuen(),2000);
							
							//resp='Registros Guardas';
							//limparmovimientoTraCuen();
						}
						//$('#resultado').html(resp);
					
					}
				});
		
}

function buscarcodcuen()
{
	codpoliza1=document.getElementById('codpoliza1').value;
	$.ajax({
				
					url:'../bancos/formularios/buscarCodigoCodcuen.php',
					type:'POST',
					data:'codpoliza1='+codpoliza1,

					success: function(resp)
					{
						
						
						document.getElementById('CODTCUEN').value=resp;
						setTimeout(reemplazaCodigos(),2000);
					}
				});
}

function reemplazaCodigos()
{
	CODTCUEN=document.getElementById('CODTCUEN').value;
	codpoliza1=document.getElementById('codpoliza1').value;

	contar=1;
	
	$.ajax({
					url:'Reemplazarcodigos.php',
					type:'POST',
					data:'CODTCUEN='+CODTCUEN+'&contar='+contar+'&codpoliza1='+codpoliza1,
					success: function(resp)
					{
					
						if(resp==1)
						{
							
							setTimeout(reemplazaCodigos1(),2000);
						}
						
					
					}
				});

}

function reemplazaCodigos1()
{
	codpoliza1=document.getElementById('codpoliza1').value;
	CODTCUEN=document.getElementById('CODTCUEN').value;
	contar=2;
	
	$.ajax({
					url:'Reemplazarcodigos.php',
					type:'POST',
					data:'CODTCUEN='+CODTCUEN+'&contar='+contar+'&codpoliza1='+codpoliza1,
					success: function(resp)
					{
						
						
						if(resp==1)
						{
							resp='Registros Guardados';
							limparmovimientoTraCuen();
							$('#resultado').html(resp);
							salir2();

						}
					
					}
				});

}




 
function guardarpoliza(e,id){ 
  tecla=(document.all) ? e.keyCode : e.which; 
  if(tecla == 13) 
  {
			cuentapoliza=document.getElementById('cuentapoliza').value;
			debe=document.getElementById('debe').value;
			haber=document.getElementById('haber').value;
							
			$.ajax({
					url:'ingresopoliza.php',
					type:'POST',
					data:'cuentapoliza='+cuentapoliza+'&debe='+debe+'&haber='+haber,
					success: function(resp)
					{
						
						if(resp==1)
						{   
							resp='Registros Guardados';
							limparpolizatrapoldet();
							actualizarpoliza(id);
						}
						$('#resultado1').html(resp);
					
					}
				});
  }	

} 

function actualizarpoliza(id)
		{

			$.ajax({
				
					url:'combosBancos.php',
					type:'POST',
					data:'id='+id+'&tipoMovPOL='+"poliza",
					success: function(resp)
					{
						
						$('#recargaMovimientoCuent').html(resp);
					}
				});
		}

/*
function actualizarpoliza()
{
	setTimeout(function(){document.getElementById('resultado').innerHTML='<img src="../../images/loader.gif" alt="" />';},1000);
	//elem1=document.getElementsByName('group2').value; 
			
	//		elem=document.getElementById('nonegociable').value;
			codcuen=document.getElementById('codcuen').value;
			numero=document.getElementById('numero').value;
			fecha=document.getElementById('fecha').value;
			concepto=document.getElementById('concepto').value;
			beneficia=document.getElementById('beneficia').value;
			numvalor=document.getElementById('numvalor').value;
			tasacambio1=document.getElementById('tasacambio1').value;
			ordenpago=document.getElementById('ordenpago').value;
	//		embarque=document.getElementById('embarque').value;
			poliza=document.getElementById('poliza').value;
			cuentapoliza=document.getElementById('cuentapoliza').value;
			debe=document.getElementById('debe').value;
			haber=document.getElementById('haber').value;
			nombrecuentapoliza=document.getElementById('nombrecuentapoliza').value;

	
	window.opener.document.location.reload();
	
	setTimeout(function(){abrirMoviemientoscuen1('movimientoscuen', codcuen);},300);
	//setTimeout(function(){window.opener.document.getElementById('codcuen').value=codcuen;},1300);
	//setTimeout(function(){window.opener.document.getElementById('nonegociable').checked=elem;},1300);
	setTimeout(function(){window.opener.document.getElementById('codcuen').value=codcuen;},2000);
	setTimeout(function(){window.opener.document.getElementById('numero').value=numero;},2000);
	setTimeout(function(){window.opener.document.getElementById('fecha').value=fecha;},2000);
	setTimeout(function(){window.opener.document.getElementById('concepto').value=concepto;},2000);
	setTimeout(function(){window.opener.document.getElementById('beneficia').value=beneficia;},2000);
	//setTimeout(function(){window.opener.document.getElementById('numvalor').value=numvalor;},1300);
	setTimeout(function(){window.opener.document.getElementById('tasacambio1').value=tasacambio1;},2000);
	setTimeout(function(){window.opener.document.getElementById('ordenpago').value=ordenpago;},2000);
	setTimeout(function(){window.opener.document.getElementById('embarque').value=embarque;},2000);
	setTimeout(function(){window.opener.document.getElementById('poliza').value=poliza;},2000);	
	setTimeout(function(){window.opener.document.getElementById('cuentapoliza').value=cuentapoliza;},2000);
	setTimeout(function(){window.opener.document.getElementById('debe').value=debe;},2000);
	setTimeout(function(){window.opener.document.getElementById('haber').value=haber;},2000);
	setTimeout(function(){window.opener.document.getElementById('nombrecuentapoliza').value=nombrecuentapoliza;},1000);
	setTimeout(salir2, 2000);

}
*/
function salir2()
{
	window.close();

}

function correlativonumero()
{
			
			elem1=document.getElementsByName('group2'); 
  			 for(i=0;i<elem1.length;i++) 
       		 if (elem1[i].checked) { 
             valor1 = elem1[i].value; 
              }
			
			codcuen=document.getElementById('codcuen').value;
			ordenpago=document.getElementById('ordenpago').value;
			
		$.ajax({
					url:'formularios/NumeroOrden.php',
					type:'POST',
					data:'combo='+valor1+'&codcuen='+codcuen,
					success: function(resp)
					{
						if(resp=="")
						{

							resp=0;
							
						}
						suma1=parseInt(resp);
						suma1=suma1+1;

						
						document.getElementById('numero').value=suma1;
						
					}
					
					
				});


		

}

function codigodePoliza()
{
			
			elem1=document.getElementsByName('group2'); 
  			 for(i=0;i<elem1.length;i++) 
       		 if (elem1[i].checked) { 
             valor1 = elem1[i].value; 
              }
			
			codcuen=document.getElementById('codcuen').value;
			ordenpago=document.getElementById('ordenpago').value;
		
		$.ajax({
					url:'formularios/CodigoPoliza.php',
					type:'POST',
					data:'combo='+valor1+'&codcuen='+codcuen,
					success: function(resp)
					{
						if(resp=="")
						{
							resp=0;
						}
						suma2=parseInt(resp);
						suma2=suma2+1;

						
						document.getElementById('ordenpago').value=suma2;
						
					}
					
					
				});         

 }

 function numerocorPoliza()
{
			
			
			
			codcuen=document.getElementById('codcuen').value;
			poliza=document.getElementById('poliza').value;
			
		$.ajax({
					url:'formularios/numerocoPoliza.php',
					type:'POST',
					data:'poliza='+poliza+'&codcuen='+codcuen,
					success: function(resp)
					{
						if(resp=="")
						{
							resp=0;
						}
						suma2=parseInt(resp);
						suma2=suma2+1;

						
						document.getElementById('poliza').value=suma2;
						
					}
					
					
				});         

 }

