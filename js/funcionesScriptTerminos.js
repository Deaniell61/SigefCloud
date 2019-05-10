/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function terminosCons(producto,usuario,empresa,check,pais)
{
		if(check)
		{
			hacer="agregar";
		}
		else
		{
			hacer="eliminar";
		}
		
		$.ajax({
					url:'../terminosYcondiciones/agregarTerminos.php',
					type:'POST',
					data:'producto='+producto+'&usuario='+usuario+'&empresa='+empresa+'&hacer='+hacer+'&pais='+pais,
					success: function(resp)
					{
						$('#resultado').html(resp);
					}
					
					
				});
		
}