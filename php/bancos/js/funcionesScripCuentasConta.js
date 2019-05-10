function desabilitargrupo()
{
	$(document).ready(function(){
    $('#tipocuentaconta > option[value="T"]').attr('selected', 'selected');});
	document.getElementById("tipocuentaconta").disabled=true;
	document.getElementById("grupoconta").disabled=true;
	document.getElementById("subgrupoconta").disabled=true;
	document.getElementById("cuentaconta1").disabled=true;
	document.getElementById("cuentacontanivel1").disabled=true;
	document.getElementById("cuentacontanivel2").disabled=true;
	document.getElementById("grupoconta").value="";
	document.getElementById("subgrupoconta").value="";
	document.getElementById("cuentaconta1").value="";
	document.getElementById("cuentacontanivel1").value="";
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('grupoconta1').value="";
	document.getElementById('subgrupoconta1').value="";
	document.getElementById('cuentaconta11').value="";
	document.getElementById('codCuentaconta').value="";
	document.getElementById('cuentacontanivel11').value="";
	document.getElementById('cuentacontanivel21').value="";
	llenarCodigoConta23();

}

function desabilitarsubgrupo()
{
	$(document).ready(function(){
    $('#tipocuentaconta > option[value="T"]').attr('selected', 'selected');});
	document.getElementById("tipocuentaconta").disabled=true;
	document.getElementById("grupoconta").disabled=false;
	document.getElementById("subgrupoconta").disabled=true;
	document.getElementById("cuentaconta1").disabled=true;
	document.getElementById("cuentacontanivel1").disabled=true;
	document.getElementById("cuentacontanivel2").disabled=true;
	document.getElementById("subgrupoconta").value="";
	document.getElementById("cuentaconta1").value="";
	document.getElementById("cuentacontanivel1").value="";
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('subgrupoconta1').value="";
	document.getElementById('cuentaconta11').value="";
	document.getElementById('cuentacontanivel11').value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";
	llenarCodigoConta23();
}

function limpiezaParaGrupo()
{
	document.getElementById("subgrupoconta").value="";
	document.getElementById("cuentaconta1").value="";
	document.getElementById("cuentacontanivel1").value="";
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('subgrupoconta1').value="";
	document.getElementById('cuentaconta11').value="";
	document.getElementById('cuentacontanivel11').value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";

}


function desabilitarcuenta()
{
	$(document).ready(function(){
    $('#tipocuentaconta > option[value="T"]').attr('selected', 'selected');});
	document.getElementById("tipocuentaconta").disabled=true;
	document.getElementById("grupoconta").disabled=false;
	document.getElementById("subgrupoconta").disabled=false;
	document.getElementById("cuentaconta1").disabled=true;
	document.getElementById("cuentacontanivel1").disabled=true;
	document.getElementById("cuentacontanivel2").disabled=true;
	document.getElementById("cuentaconta1").value="";
	document.getElementById("cuentacontanivel1").value="";
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('cuentaconta11').value="";
	document.getElementById('cuentacontanivel11').value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";
	llenarCodigoConta23();
}

function limpiezaParaSubGrupo()
{
	document.getElementById("cuentaconta1").value="";
	document.getElementById("cuentacontanivel1").value="";
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('cuentaconta11').value="";
	document.getElementById('cuentacontanivel11').value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";

}

function desabilitarcuentanivel1()
{
	document.getElementById("tipocuentaconta").disabled=false;
	 $(document).ready(function(){
    $('#tipocuentaconta > option[value=""]').attr('selected', 'selected');});
	
	document.getElementById("grupoconta").disabled=false;
	document.getElementById("subgrupoconta").disabled=false;
	document.getElementById("cuentaconta1").disabled=false;
	document.getElementById("cuentacontanivel1").disabled=true;
	document.getElementById("cuentacontanivel2").disabled=true;
	document.getElementById("cuentacontanivel1").value="";
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('cuentacontanivel11').value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";
	llenarCodigoConta23();
}

function limpiezaParacuentanivel1()
{
	document.getElementById("cuentacontanivel1").value="";
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('cuentacontanivel11').value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";

}

function desabilitarcuentanivel2()
{
	$(document).ready(function(){
    $('#tipocuentaconta > option[value=""]').attr('selected', 'selected');});
	document.getElementById("tipocuentaconta").disabled=false;
	document.getElementById("grupoconta").disabled=false;
	document.getElementById("subgrupoconta").disabled=false;
	document.getElementById("cuentaconta1").disabled=false;
	document.getElementById("cuentacontanivel1").disabled=false;
	document.getElementById("cuentacontanivel2").disabled=true;
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";
	llenarCodigoConta23();
}

function limpiezaParacuentanivel2()
{
	document.getElementById("cuentacontanivel2").value="";
	document.getElementById('cuentacontanivel21').value="";
	document.getElementById('codCuentaconta').value="";

}

function desabilitarcuentanivel3()
{
	$(document).ready(function(){
    $('#tipocuentaconta > option[value=""]').attr('selected', 'selected');});
	document.getElementById("tipocuentaconta").disabled=false;
	document.getElementById("grupoconta").disabled=false;
	document.getElementById("subgrupoconta").disabled=false;
	document.getElementById("cuentaconta1").disabled=false;
	document.getElementById("cuentacontanivel1").disabled=false;
	document.getElementById("cuentacontanivel2").disabled=false;
	
}

function CatNomenclatura()
			
		{
			elem=document.getElementsByName('group1'); 
  			 for(i=0;i<elem.length;i++) 
       		 if (elem[i].checked) { 
             valor = elem[i].value; 
              }

            balance=document.getElementById('ubicacionconta').value;
			if(balance=='B')
			{
			balanceDato='1'; 	
			}
			else
			{
			balanceDato='0'; 	
			}

			if(balance=='R')
			{
			ResultadoDato='1'; 	
			}
			else
			{
			ResultadoDato='0'; 	
			}

		    grupoconta=document.getElementById('grupoconta').value;
			subgrupoconta=document.getElementById('subgrupoconta').value;
			cuentaconta1=document.getElementById('cuentaconta1').value;
			cuentacontanivel1=document.getElementById('cuentacontanivel1').value;
			cuentacontanivel2=document.getElementById('cuentacontanivel2').value;
        	codCuentaconta=document.getElementById('codCuentaconta').value;
			nomCuentaconta=document.getElementById('nomCuentaconta').value;
			tipocuentaconta=document.getElementById('tipocuentaconta').value;
			ubicacionconta=document.getElementById('ubicacionconta').value;

			$.ajax({
					url:'ingresoCatNomenclatura.php',
					type:'POST',
					
					data: 'elementos='+valor+ '&balanceDato='+balanceDato+ '&ResultadoDato='+ResultadoDato+'&grupoconta='+grupoconta+ '&subgrupoconta='+subgrupoconta+'&cuentaconta1='+cuentaconta1+ '&cuentacontanivel1='+cuentacontanivel1+'&cuentacontanivel2='+cuentacontanivel2+'&codCuentaconta='+codCuentaconta+'&nomCuentaconta='+nomCuentaconta+'&tipocuentaconta='+tipocuentaconta+'&ubicacionconta='+ubicacionconta,
					success: function(resp)
					{
						if (resp==1)
						{
							actualizarTodosDatos();
							resp='Registros Guardados'

						}

						$('#resultado').html(resp);
						
											
						
					
					}
				});
			
		}


function llenarCodigoConta23()
{
			grupoconta=document.getElementById('grupoconta1').value;
			subgrupoconta=document.getElementById('subgrupoconta1').value;
			cuentaconta1=document.getElementById('cuentaconta11').value;
			cuentacontanivel1=document.getElementById('cuentacontanivel11').value;
			cuentacontanivel2=document.getElementById('cuentacontanivel21').value;
			cuentacontanivel31=document.getElementById('cuentacontanivel31').value;

			subgruop=subgrupoconta.substring(1);
			cuentacuenta=cuentaconta1.substring(2);
			cuentacuenta1=cuentacontanivel1.substring(3);
			cuentacuenta2=cuentacontanivel2.substring(5);
			cuentacuenta3=cuentacontanivel31.substring(8);
			codigo=grupoconta+subgruop+cuentacuenta+cuentacuenta1+cuentacuenta2+cuentacuenta3;
			document.getElementById('codCuentaconta').value=codigo;
		
}



function filtrarcombos(pais,filtro)
		{

			$.ajax({
				
					url:'combosBancos.php',
					type:'POST',
					data:'subgrupoconta1='+filtro.value+'&pais='+pais,
					success: function(resp)
					{
						
						$('#subgrupoconta').html(resp);
					}
				});
		}

function filtrarcombos1(pais,filtro)
		{

			$.ajax({
				
					url:'combosBancos.php',
					type:'POST',
					data:'subgrupoconta2='+filtro.value+'&pais='+pais,

					success: function(resp)
					{
						
						$('#cuentaconta1').html(resp);
					}
				});
		}

function filtrarcombos2(pais,filtro)
		{

			$.ajax({
				
					url:'combosBancos.php',
					type:'POST',
					data:'cuentaconta12='+filtro.value+'&pais='+pais,
					
					success: function(resp)
					{
						
						$('#cuentacontanivel1').html(resp);
					}
				});
		}

function filtrarcombos3(pais,filtro)
		{
			
			$.ajax({
				
					url:'combosBancos.php',
					type:'POST',
					data:'cuentacontanivel14='+filtro.value+'&pais='+pais,
					
					success: function(resp)
					{
						
						$('#cuentacontanivel2').html(resp);
					}
				});
		}


function codigodegrupo()
{
			elem=document.getElementsByName('group1'); 
			grupoconta=document.getElementById('grupoconta1').value;
			subgrupoconta=document.getElementById('subgrupoconta1').value;
			cuentaconta1=document.getElementById('cuentaconta11').value;
			cuentacontanivel1=document.getElementById('cuentacontanivel11').value;
			cuentacontanivel2=document.getElementById('cuentacontanivel21').value;
  			
  			 for(i=0;i<elem.length;i++) 
       		 if (elem[i].checked) { 
             valor = elem[i].value; 
              }


              if(valor==1)
              {
              	$.ajax({
					url:'formularios/codigogrupoconta.php',
					type:'POST',
					data:'combo='+valor,
					success: function(resp)
					{
						suma=parseInt(resp);
						suma=suma+1;

						
						document.getElementById('grupoconta1').value=suma;
						llenarCodigoConta23();
					}
					
					
				});
              }

             if(valor==2)
              {
              	
              	$.ajax({
              		url:'formularios/codigosubgrupoconta.php',
					type:'POST',
					data:'combo='+valor+'&grupoconta='+grupoconta,
					success: function(resp)
					{
						if(resp=='')
						{
							resp=grupoconta+'0';
						}
						suma=parseInt(resp);
						suma=suma+1;

						
						document.getElementById('subgrupoconta1').value=suma;
						llenarCodigoConta23();
					}
					
					
				});
              }

          if(valor==3)
              {
              	
              	$.ajax({
					url:'formularios/codigocuentagrupoconta.php',
					type:'POST',
					data:'combo='+valor+'&subgrupoconta='+subgrupoconta,
					
					success: function(resp)
					{
						if(resp=='')
						{
							resp=subgrupoconta+'0';
						}
						
						suma=parseInt(resp);
						suma=suma+1;
						
						
						document.getElementById('cuentaconta11').value=suma;
						llenarCodigoConta23();
					}
					
					
				});
              }

          if(valor==4)
             {
              	
              	$.ajax({
					url:'formularios/codigonivel1conta.php',
					type:'POST',
					data:'combo='+valor+'&cuentaconta1='+cuentaconta1,
					
					success: function(resp)
					{
						if(resp=='')
						{
							resp=cuentaconta1+'00';
						}
						suma=parseInt(resp);
						suma=suma+1;
						
						
						document.getElementById('cuentacontanivel11').value=suma;
						llenarCodigoConta23();
					}
					
					
				});
              }

               if(valor==5)
             {
              	
              	$.ajax({
					url:'formularios/codigonivel2conta.php',
					type:'POST',
					data:'combo='+valor+'&cuentacontanivel1='+cuentacontanivel1,
					
					success: function(resp)
					{
						if(resp=='')
						{
							resp=cuentacontanivel1+'000';
						}
						suma=parseInt(resp);
						suma=suma+1;
						
						
						document.getElementById('cuentacontanivel21').value=suma;
						llenarCodigoConta23();
					}
					
					
				});
              }

              if(valor==6)
             {
              	
              	$.ajax({
					url:'formularios/codigonivel3conta.php',
					type:'POST',
					data:'combo='+valor+'&cuentacontanivel2='+cuentacontanivel2,
					
					success: function(resp)
					{
						
						if(resp=='')
						{
							resp=cuentacontanivel2+'000';
						}
						suma=parseInt(resp);
						suma=suma+1;
						
						
						document.getElementById('cuentacontanivel31').value=suma;
						llenarCodigoConta23();
					}
					
					
				});
              }
             
}



function LlenarCodigoOtro(combo,filtro,devuelto)
{

		$.ajax({
					url:'formularios/codigoCuentaContable.php',
					type:'POST',
					data:'combo='+combo.value+'&filtro='+filtro,
					success: function(resp)
					{
						
						document.getElementById(devuelto).value=resp;
						llenarCodigoConta23();
						filtrarcombos();
						codigodegrupo(devuelto);
					}
					
					
				});
}

