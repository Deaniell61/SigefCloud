/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
prosigue=false;
function asignarEmpresa(usuario,chek,empresa)
{
       if(chek)
	   {  
		guardarAsignarEmpresa(usuario,empresa);
	   }
	   else
	   {
		  borrarAsignarEmpresa(usuario,empresa);
	   }
      llenarProveedores(empresa);  
       
}

function guardarAsignarEmpresa(usuario,empresa)
{
	
	$.ajax({
					url:'../permisos/asignarEmpresa.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
								
					
					}
				});
}
function borrarAsignarEmpresa(usuario,empresa)
{
	
	$.ajax({
					url:'../permisos/desasignarEmpresa.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
								
					
					}
				});
}

function abrirAsignacionModulos(codigo,usuario,empresa)
{
	pag=window.open("../permisos/paginaAsignarModulos.php?codigo="+codigo+"&usuario="+usuario+"&empresa="+empresa,"Modulos","width=1000,height=550,top=40%,rigth=75%,Scrollbars=YES");
	pag.focus();
}

function envioDeDataPermiso(es)
	{
		var1="";
		var2="";
		var3="";
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
						{var3=arrVariableActual[1];}
					}
			}
			
			llenarDatosModulos(var1,var2,var3);
			
		
	}
	
	function llenarDatosModulos(codigo,usuario,empresa)
	{
		
		$.ajax({
					url:'../permisos/modulosEmpresaUsuario.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa+'&codigo='+codigo,
					success: function(resp)
					{
						
						$('#formulario').html(resp);
								
					
					}
				});
		
	}
	
	function asignarOpciones(usuario,chek,empresa,modulo,tipo)
	{
		
		if(chek)
		{
			
			guardarModulo(usuario,empresa,modulo);
			
			
		}
		else
		{
			eliminarModulo(usuario,empresa,modulo);
			$('#opcion').html("");
		}
	}
	function mostrarOpciones(usuario,empresa,modulo,tipo)
	{
		if(tipo=='F')
		{
		$.ajax({
					url:'../permisos/opciones.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa+'&codigo='+modulo,
					success: function(resp)
					{
						
						
						$('#opcion').html(resp);
							
					
					}
					
				});
		}
		else
		{
			$('#opcion').html("");
		}
				
	}
	
	function guardarModulo(usuario,empresa,modulo)
{
		
	$.ajax({
					url:'../permisos/guardarModulo.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa+'&modulo='+modulo,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						mostrarOpciones(usuario,empresa,modulo);		
					
					}
				});
}
function eliminarModulo(usuario,empresa,modulo)
{
		
	$.ajax({
					url:'../permisos/eliminarModulo.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa+'&modulo='+modulo,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
								
					
					}
				});
}

function guardarOpciones(usuario,chek,empresa,modulo,actualiza)
{
	if(chek)
	{
	$.ajax({
					url:'../permisos/guardarOpcion.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa+'&modulo='+modulo+'&actua='+actualiza,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
								
					
					}
				});
	}
	else
	{
		$.ajax({
					url:'../permisos/eliminarOpcion.php',
					type:'POST',
					data:'usuario='+usuario+'&empresa='+empresa+'&modulo='+modulo+'&actua='+actualiza,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
								
					
					}
				});
	}
}

function agregarRol(rol,usuario,empresa,acempresa)
{
	
	$.ajax({
					url:'../permisos/agregarRol.php',
					type:'POST',
					data:'rol='+rol+'&usuario='+usuario+'&empresa='+empresa+'&acempresa='+acempresa,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
								
					
					},
					error: function(resp)
					{
						
						$('#resultado').html(resp);
								
					
					}
					
				});
}


		

