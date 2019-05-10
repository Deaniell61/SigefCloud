/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
prosigue=false;

function ingresarUsuarios(nombre,apellido,email,contra,rol)
		{
			if(prosigue)
			{
			$.ajax({
					url:'../php/usuarios/ingresoUsuarios.php',
					type:'POST',
					data:'nombre='+nombre.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'')+'&pass='+contra.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'')+'&apellido='+
					apellido.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'')+'&email='+email.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'')+'&rol='+rol,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						document.getElementById('usuarios').reset();
						document.getElementById('nombre').className= "normal";
						document.getElementById('nombre').focus();
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
function actualizarUsuario(nombre,email,codigo,apellido)
{
	
	$.ajax({
				
					url:'../php/usuarios/editarUsuarios.php',
					type:'POST',
					data:'nombre='+nombre+'&email='+email+'&apellido='+
					apellido+'&codigo='+codigo,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
					}
					
				});
}

function editarUsuarios(contador)
		{
			
			for(i=1;i<=contador;i++)
			{
				
				nombre=document.getElementById('nombre'+i+'').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
				apellido=document.getElementById('apellido'+i+'').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
				email=document.getElementById('email'+i+'').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
				codigo=document.getElementById('codigo'+i+'').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
				actualizarUsuario(nombre,email,codigo,apellido);
			
			
				
			}
			
			LimpiarBuscarUsua();
			buscarUsuario(document.getElementById('buscaUser').value,document.getElementById('buscaApel').value,document.getElementById('buscaEmail').value);
			alert("Usuarios Guardados");
			
			
		}
		

function LimpiarBuscarUsua()
	{
		document.getElementById('buscaUser').value="";
		document.getElementById('buscaEmail').value="";
		document.getElementById('buscaApel').value="";
	}

function comprobarEmailUsuar()
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

function comprobarEmailUsua(email,comp)
{

    // Expresion regular para validar el correo
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    // Se utiliza la funcion test() nativa de JavaScript
    if (regex.test($('#'+email+'').val().trim())) {
		prosigue=true;
        $('#'+comp+'').html("<div id=\"Success\" ></div>");
		document.getElementById(email).className= "entradaTexto textoGrande";
    } else {
		prosigue=false;
        $('#'+comp+'').html("<div id=\"Error\" alt=\"Ayuda\" onmouseover=\"muestraAyuda(event, \'UsuarioError\')\"></div>");
   		document.getElementById(email).className= "obligado entradaTexto textoGrande";
    }

}

function abrirUsuario(cod)
		{
			params  = 'width='+screen.width;
			 params += ', height='+screen.height;
			 params += ', top=0, left=0'
			 params += ', fullscreen=yes';
			 params += ', location=yes';
			 params += ', Scrollbars=YES';
			pag=window.open("../php/usuarios/paginaUsuarios.php?codigo="+cod,"EditarUsuario",params);
			pag.focus();
		}
		
		function llenarDatosUsuario(codigo)
		{
			
			$.ajax({
					url:'../usuarios/buscarUsuario.php',
					type:'POST',
					data:'codigo='+codigo,
					success: function(resp)
					{
					
						
						$('#formulario').html(resp);
						
								
					
					}
					
					
				});
		}
		
		function editarTodoUsuario()
		{
			
			nombre=document.getElementById('nombre').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
			clave=document.getElementById('contra').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
			email=document.getElementById('email').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
			estado=document.getElementById('estado').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
			posicion=document.getElementById('rol').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
			apellido=document.getElementById('apellido').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
			codigo=document.getElementById('codigo').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
			usuario=document.getElementById('usuario').value.replace(/&/gi,'y').replace(/'/gi,'\\\'').replace(/"/gi,'\\\'');
				
			$.ajax({
					url:'../usuarios/ingresoUsuario.php',
					type:'POST',
					data:'nombre='+nombre+'&clave='+clave+'&email='+email+'&posicion='+posicion+'&apellido='+apellido+'&estado='+estado+'&codigo='+codigo+'&usuario='+usuario,
					success: function(resp)
					{
						
						$('#resultado').html(resp);
						
						LimpiarBuscarEmpresa();
			llenarDatosUsuario(codigo);
			
						
					
					}
				});
			
		}
		
function llenarDatoUsuario(obc1,obc2,llanado)
{
	llanado.value=obc1.value.substr(0,3)+"."+obc2.value.substr(0,3);
	
}

