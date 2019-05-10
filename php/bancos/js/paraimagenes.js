function limpiarImagenes()
{
			document.getElementById('archivo').value="";
			document.getElementById('barra_de_progreso').hidden = true;
}

function subirArchivos() 
{
	
			document.getElementById('barra_de_progreso').hidden = false;
			var archivos=document.getElementById('archivo').files;
			var i=0;
			var size=archivos[i].size;
   			var type=archivos[i].type;
   			var name=archivos[i].name;
   			var ancho=archivos[i].width;
   			var alto=archivos[i].height;
			
		
	if(size<(2*(1024*1024)))
	{
		if(type=="image/jpeg" || type=="image/jpg")
		{
			
			if(1)
			{
				$("#archivo").upload('formularios/subir_archivo.php',
        		{
            		nombre_archivo: $("#tipoImg").val()
        		},
        		function(respuesta) 
				{
            		//Subida finalizada.
            		$("#barra_de_progreso").val(0);
            		$('#resultado').html(respuesta);
            		
					limpiarImagenes();
					
        		}, 
				
				function(progreso, valor) 
				{
            		//Barra de progreso.
            		$("#barra_de_progreso").val(valor);
        		}
									);
			}
			else
			{
				$('#resultado').html("<?php echo $lang[$idioma]['AdverAltoAncho'];?>");
				limpiarImagenes();
			}
			
		}
		else
		{
			$('#resultado').html("<?php echo $lang[$idioma]['AdverTipo'];?>");
			limpiarImagenes();
			
		}
	}
	else
	{
		$('#resultado').html("<?php echo $lang[$idioma]['AdverTamanio'];?>");
		limpiarImagenes();
	}
        
	
}
			
            
function limpiarColumnas()
{
	$('#mover').html("");
}

function mostrarImagenes()
{
		alert('asdfsa');		
		document.getElementById('barra_de_progreso').hidden = true;
		var FRO='FRO';
		setTimeout(limpiarColumnas,0000);
				
		$.ajax({
			url:'mostrarImagenes.php',
			type:'POST',
			data:'cara='+FRO,
			success: function(resp)
			{
				if(resp!=2)
					{
						$('#mover').append(resp);
					}
			}

			
		});
		
		setTimeout(function(){verificaLi();},1000);	
}


function verificaLi()
{
	var licant=$("#mover li").size();
	if(licant<9)
	{
		for(inx=0;inx<(9-licant);inx++)
		{
		$('#mover').append("<li class='bor'></li>");
		}
	}
}
			
			
