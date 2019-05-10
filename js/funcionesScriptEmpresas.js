/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
prosigue=false;

function ingresarEmpresa(nombre,npatronal,rsocial,direccion,nit,telefono,fax,www,email,ctaIva_CR,ctaIva_DB,ctaInven,ctaIvaCRxL,ctaCCxP,ctaIDP,ctaCosto,ctaCajaGR,cPIGSS,cPIntecap,cPIRTRA,cLIGSS,baseDatos,moneda,inventar,pais)
		{
			
			if(prosigue)
			{
				
			$.ajax({
					url:'../php/empresas/ingresoEmpresas.php',
					type:'POST',
					data:'nombre='+limpiarCaracteresEspeciales(nombre)+'&npatronal='+npatronal+'&rsocial='+limpiarCaracteresEspeciales(rsocial)+'&direccion='+limpiarCaracteresEspeciales(direccion)+'&nit='+nit+'&telefono='+telefono+'&fax='+fax+'&www='+limpiarCaracteresEspeciales(www)+'&email='+limpiarCaracteresEspeciales(email)+'&ctaIva_CR='+ctaIva_CR+'&ctaIva_DB='+ctaIva_DB+'&ctaInven='+ctaInven+'&ctaIvaCRxL='+ctaIvaCRxL+'&ctaCCxP='+ctaCCxP+'&ctaIDP='+ctaIDP+'&ctaCosto='+ctaCosto+'&ctaCajaGR='+ctaCajaGR+'&cPIGSS='+cPIGSS+'&cPIntecap='+cPIntecap+'&cPIRTRA='+cPIRTRA+'&cLIGSS='+cLIGSS+'&baseDatos='+baseDatos+'&moneda='+moneda+'&inventar='+limpiarCaracteresEspeciales(inventar)+'&pais='+pais,
					success: function(resp)
					{
						alert(pais);
						$('#resultado').html(resp);
						resetFormEmpresas();
						
					
					}
				});
			}
			else
			{
				
				reso="Debe ingresar todos los campos correctamente";
				$('#resultado').html(reso);
				document.getElementById('email').focus();
			}
		}

function comprobarEmailEmpresa()
{

    // Expresion regular para validar el correo
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    // Se utiliza la funcion test() nativa de JavaScript
    if (regex.test($('#email').val().trim())) {
		prosigue=true;
        $('#comprobar').html("<div id=\"Success\" ></div>");
		document.getElementById('email').className= "entradaTexto textoGrande";
    } else {
		prosigue=false;
        $('#comprobar').html("<div id=\"Error\" alt=\"Ayuda\" onmouseover=\"muestraAyuda(event, \'UsuarioError\')\"></div>");
   		document.getElementById('email').className= "obligado entradaTexto textoGrande";
    }

}

function editarEmpresas(contador)
		{
			
			for(i=1;i<=contador;i++)
			{
			
				
				nombre=document.getElementById('nombre'+i+'').value;
				npatronal=document.getElementById('npatronal'+i+'').value;
				email=document.getElementById('email'+i+'').value;
				codigo=document.getElementById('codigo'+i+'').value;
				rsocial=document.getElementById('rsocial'+i+'').value;
				direccion=document.getElementById('direccion'+i+'').value;
				telefono=document.getElementById('telefono'+i+'').value;
				nit=document.getElementById('nit'+i+'').value;
				actualizarEmpresa(nombre,npatronal,rsocial,direccion,nit,telefono,email,codigo);
			
			
				
			}
			
			LimpiarBuscarEmpresa();
			buscarEmpresas(document.getElementById('buscaUser').value,document.getElementById('buscaNIT').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaEmail').value);
			
			
		}
		
		function actualizarEmpresa(nombre,npatronal,rsocial,direccion,nit,telefono,email,codigo)
		{
			
			
				
			$.ajax({
					url:'../php/empresas/editarEmpresas.php',
					type:'POST',
					data:'nombre='+limpiarCaracteresEspeciales(nombre)+'&npatronal='+limpiarCaracteresEspeciales(npatronal)+'&rsocial='+limpiarCaracteresEspeciales(rsocial)+'&direccion='+limpiarCaracteresEspeciales(direccion)+'&nit='+limpiarCaracteresEspeciales(nit)+'&telefono='+limpiarCaracteresEspeciales(telefono)+'&email='+limpiarCaracteresEspeciales(email)+'&codigo='+limpiarCaracteresEspeciales(codigo),
					success: function(resp)
					{
						
						$('#resultado').html(resp);

					
					}
				});
			
		}
		
		function abrirEmpresa(cod)
		{
			params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
  			 pag=window.open("../php/empresas/paginaEmpresas.php?codigo="+cod,"Empresas",params);
			 pag.focus();
			 
		}
		
		function llenarDatosEmpresa(codigo)
		{
			
			$.ajax({
					url:'../empresas/buscarEmpresa.php',
					type:'POST',
					data:'codigo='+codigo,
					success: function(resp)
					{
					
						
						$('#formulario').html(resp);
						
								
					
					}
					
					
				});
		}
		
		
		function envioDeData(es)
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
			llenarDatosEmpresa(arrVariableActual[1]);
			}
			else
			{
				if(es=='user')
				{
				llenarDatosUsuario(arrVariableActual[1]);
				}
				
			}
		
	}
	
			
		function editarTodaEmpresa(nombre,npatronal,rsocial,direccion,nit,telefono,fax,www,email,ctaIva_CR,ctaIva_DB,ctaInven,ctaIvaCRxL,ctaCCxP,ctaIDP,ctaCosto,ctaCajaGR,cPIGSS,cPIntecap,cPIRTRA,cLIGSS,baseDatos,moneda,inventar,codigo,pais)
		{
			
			var marpro=limpiarCaracteresEspeciales(document.getElementById('marpro').value);
			var marmin=limpiarCaracteresEspeciales(document.getElementById('marmin').value);
			var marmincon=limpiarCaracteresEspeciales(document.getElementById('marmincon').value);
			var marmax=limpiarCaracteresEspeciales(document.getElementById('marmax').value);
			var incre1=limpiarCaracteresEspeciales(document.getElementById('incre1').value);
			var incre2=limpiarCaracteresEspeciales(document.getElementById('incre2').value);
			var incre3=limpiarCaracteresEspeciales(document.getElementById('incre3').value);
			var incre4=limpiarCaracteresEspeciales(document.getElementById('incre4').value);

				datosSend='&marmin='+marmin+'&marpro='+marpro+'&marmax='+marmax+'&marmincon='+marmincon+'&incre1='+incre1+'&incre2='+incre2+'&incre3='+incre3+'&incre4='+incre4	;
				
			$.ajax({
					url:'../empresas/ingresoEmpresa.php',
					type:'POST',
					data:'nombre='+limpiarCaracteresEspeciales(nombre)+'&npatronal='+limpiarCaracteresEspeciales(npatronal)+'&rsocial='+limpiarCaracteresEspeciales(rsocial)+'&direccion='+limpiarCaracteresEspeciales(direccion)+'&nit='+nit+'&telefono='+limpiarCaracteresEspeciales(telefono)+'&fax='+limpiarCaracteresEspeciales(fax)+'&www='+limpiarCaracteresEspeciales(www)+'&email='+limpiarCaracteresEspeciales(email)+'&ctaIva_CR='+ctaIva_CR+'&ctaIva_DB='+ctaIva_DB+'&ctaInven='+ctaInven+'&ctaIvaCRxL='+ctaIvaCRxL+'&ctaCCxP='+ctaCCxP+'&ctaIDP='+ctaIDP+'&ctaCosto='+ctaCosto+'&ctaCajaGR='+ctaCajaGR+'&cPIGSS='+cPIGSS+'&cPIntecap='+cPIntecap+'&cPIRTRA='+cPIRTRA+'&cLIGSS='+cLIGSS+'&baseDatos='+baseDatos+'&moneda='+moneda+'&inventar='+inventar+'&codigo='+codigo+'&pais='+pais+datosSend,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						
					
			
						
					
					}
				});
			
		}
		
function subirImagen(form, action_url, div_id) {
    // Create the iframe...
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "upload_iframe");
    iframe.setAttribute("name", "upload_iframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0; height: 0; border: none;");
 
    // Add to document...
    form.parentNode.appendChild(iframe);
    window.frames['upload_iframe'].name = "upload_iframe";
 
    iframeId = document.getElementById("upload_iframe");
 
    // Add event...
    var eventHandler = function () {
 
            if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
            else iframeId.removeEventListener("load", eventHandler, false);
 
            // Message from server...
            if (iframeId.contentDocument) {
                content = iframeId.contentDocument.body.innerHTML;
            } else if (iframeId.contentWindow) {
                content = iframeId.contentWindow.document.body.innerHTML;
            } else if (iframeId.document) {
                content = iframeId.document.body.innerHTML;
            }
 
            document.getElementById(div_id).innerHTML = content;
 
            // Del the iframe...
            setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
        }
 
    if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
    if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
 
    // Set properties of form...
    form.setAttribute("target", "upload_iframe");
    form.setAttribute("action", action_url);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("encoding", "multipart/form-data");
 
    // Submit the form...
    form.submit();
 
    document.getElementById(div_id).innerHTML = "Uploading...";
}


function abrirPaginaEmpresa(empresa,rol)
{

	$.ajax({
					url:'EnvioEmpresa.php',
					type:'POST',
					data:'codempresa='+empresa+'&rol='+rol,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						window.location.href='inicioEmpresa.php'
					
					}
				});
	
}
function abrirPaginaProveedor(empresa,rol)
{

	$.ajax({
					url:'EnvioEmpresa.php',
					type:'POST',
					data:'codempresa='+empresa+'&rol='+rol,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						window.location.href='inicioProveedor.php'
					
					}
				});
	
}
function abrirPaginaPrinProveedor(empresa,rol)
{

	$.ajax({
					url:'EnvioProveedor.php',
					type:'POST',
					data:'codprov='+empresa+'&rol='+rol,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						window.location.href='inicioEmpresa.php'
					
					}
				});
	
}

function abrirBancos(cod)
		{
			params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
  			 pag=window.open("../php/bancos/paginaBancos.php?codigo="+cod,"Empresas",params);
			 pag.focus();
			 
		}