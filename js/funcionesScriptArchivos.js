// JavaScript Document
function subirArchivosPP() 
		{
			
					document.getElementById('barra_de_progreso').hidden = false;
					var archivos=document.getElementById('archivo').files;
					var i=0;
					var size=archivos[i].size;
		   			var type=archivos[i].type;
		   			var name=archivos[i].name;
			
				
			if(size>0)
			{
				
				$("#archivo").upload('pestanas/subir_archivo.php',
					{
						nombre_archivo: name
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
				
				document.getElementById('resultadoPP').innerHTML= "AdverTamanio";
				
			}
                
			
        }
			