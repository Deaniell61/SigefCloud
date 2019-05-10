<?php

header("Expires: TUE, 18 Jul 2015 06:00:00 GMT");

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

header("Cache-Control: no-store, no-cache, must-revalidate");

header("Cache-Control: post-check=0, pre-check=0", false);

header("Pragma: no-cache");

require_once('../coneccion.php');

require_once('../fecha.php');

require_once('combosProductos.php');

$idioma=idioma();

include('../idiomas/'.$idioma.'.php');

$codigoEmpresa=$_POST['codEmpresa'];

$pais=$_POST['pais'];

$itemCode=limpiar_caracteres_sql($_POST['icode']);

session_start();



	$squery="select itemcode,mastersku,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,codprod from cat_prod where codempresa='".$codigoEmpresa."' and codprod='".$_SESSION['codprod']."'";

if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squery))

{

		

					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))

					{

						

						

$_SESSION['codprod']=$row['codprod'];

?>

<div id="productos">

<script>setTimeout(function(){$("#cargaLoad").dialog("close");},500);</script>



<script src="../../js/upload.js"></script>

<script src="../../js/bootstrap.min.js"></script>





<!--AJAXUPLOAD -->

<form id="ProductosImagenes" action="return false" onSubmit="return false" method="POST">



      <center>

      <br>

        <table>

                <tr><div id="resultado"></div></tr>

        	<tr>

            	<td class="text"><span><?php echo $lang[$idioma]['MasterSKU'];?></span></td>

                <td><input type="text" name="masterSKU" class='entradaTexto' disabled id="masterSKU" value="<?php echo $row['mastersku'];?>"></td>

                <td class="text"><span><?php echo $lang[$idioma]['ItemCode'];?></span></td>

                <td><input type="text" name="itemCode" class='entradaTexto' disabled id="itemCode" autofocus value="<?php echo $row['itemcode'];?>"></td>

            </tr>

            <tr>

            	<td class="text"><span><?php echo $lang[$idioma]['ProdName'];?></span></td>

                <td colspan="2"><input type="text" class='entradaTexto' name="prodName" disabled id="prodName" value="<?php echo $row['prodName'];?>"></td>

                

            </tr>

       				<tr>

                    <td class="text"><span><?php echo $lang[$idioma]['ImagenCara'];?></span></td>

                       <td colspan="3" > 

                    	<select id="tipoImg" class='entradaTexto' onChange="document.getElementById('archivo').disabled = false;$('#resultado').html('');">

                        	<option value=""></option>

                            <option value="FRO"><?php echo $lang[$idioma]['FRO'];?></option>

                            <option value="BACK"><?php echo $lang[$idioma]['BACK'];?></option>

                            <option value="CODBAR"><?php echo $lang[$idioma]['CODBAR'];?></option>

                            <option value="PERFILDER"><?php echo $lang[$idioma]['PERFILDER'];?></option>

                            <option value="PERFILIZ"><?php echo $lang[$idioma]['PERFILIZ'];?></option>

                            <option value="NOTFRETCH"><?php echo $lang[$idioma]['NOTFRETCH'];?></option>

                            <option value="INGI"><?php echo $lang[$idioma]['INGI'];?></option>

                            <option value="INSIDE"><?php echo $lang[$idioma]['INSIDE'];?></option>

                            <option value="AD1"><?php echo $lang[$idioma]['AD1'];?></option>

                            <option value="AD2"><?php echo $lang[$idioma]['AD2'];?></option>

                            

                    	</select>

                       <input disabled type="file" style="float:left; margin-left:15px;"  class='entradaTexto'name="archivo" id="archivo" onChange="subirArchivos();" /><progress id="barra_de_progreso" style="float:left; margin-left:10px; height:20px;" value="0" max="100"></progress>

                       <!-- <input type="button" class="cmd button button-highlight button-pill"  onclick="location.reload();" value="Guardar Cambio"/>-->

                       </td></tr>

                    <!--<tr><td></td>

            <td colspan="4" style="text-align:center;"><input type="checkbox" id="terminos" onChange="terminosCons('<?php #echo $_SESSION['codprod'];?>','<?php #echo $_SESSION['user'];?>','<?php #echo $_SESSION['codEmpresa'];?>',this.check,'<?php #echo $_SESSION['pais'];?>');"> Acepto los <a href="#" onClick="">Terminos y Condiciones del Servicio</a>  </td></tr> -->  

                    <tr>

                    <td colspan="2" style="text-align:right;">



    						<ul class="mover" id="mover">



                            

    						</ul>

                    </td>

                    <td colspan="2">

                   <br>

                    	<div id="contenidos" >

        					<div id="lupa" hidden="" ><img  id="im" src="" width="2000px" style="display:inline-block;"   /></div><img id="im0" onmouseover="document.getElementById('lupa').hidden = false;Lupa();" onmouseleave="document.getElementById('lupa').hidden = true;" src=""  />

    					</div>

                     

                     </td>

                     

                    </tr>

                    

             

            

        </table>

        </center>

               

            

</div>

<script>seleccion(document.getElementById('Tabimagen'));

		function limpiarImagenes()

		{

							document.getElementById('archivo').value="";

							document.getElementById('archivo').disabled = true;

							document.getElementById('tipoImg').value="";

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

						$("#archivo").upload('subir_archivo.php',

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

			var FRO='FRO';

				var BACK='BACK';

				var CODBAR='CODBAR';

				var NOTFRETCH='NOTFRETCH';

				var INGI='INGI';

				var PERFILDER='PERFILDER';

				var PERFILIZ='PERFILIZ';

				var AD1='AD1';

				var AD2='AD2';

				var INSIDE='INSIDE';

				

			function liBACK()

			{

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+BACK,

					success: function(resp)

					{

						

						if(resp!=2)

							{

								liCODBAR();

     							$('#mover').append(resp);

							}

							else

							{

								liCODBAR();

							}

						

						

						

					},

						async: true,

						cache:false

      

					

				});

			}

			function liINSIDE()

			{	

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+INSIDE,

					success: function(resp)

					{

						if(resp!=2)

							{

								liAD1();

     							$('#mover').append(resp);

								

							}

							else

							{

								liAD1();

							}

						

					},

						async: true,

						cache:false



        

					

				});

			}

			function liCODBAR()

			{	

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+CODBAR,

					success: function(resp)

					{

						if(resp!=2)

							{

								liPERFILDER();

     							$('#mover').append(resp);

								

							}

							else

							{

								liPERFILDER();

							}

						

					},

						async: true,

						cache:false



        

					

				});

			}

			function liNOTFRETCH()

			{	

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+NOTFRETCH,

					success: function(resp)

					{

						if(resp!=2)

							{

								liINSIDE();

     							$('#mover').append(resp);

								

							}

							else

							{

								liINSIDE();

							}

						

					} ,

						async: true,

						cache:false



        

					

				});

			}

			function liINGI()

			{

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+INGI,

					success: function(resp)

					{

						if(resp!=2)

							{

								liNOTFRETCH();

     							$('#mover').append(resp);

								

							}

							else

							{

								liNOTFRETCH();

							}

						

					} ,

						async: true,

						cache:false



        

					

				});

			}

			function liPERFILDER()

			{

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+PERFILDER,

					success: function(resp)

					{

						

						if(resp!=2)

							{

								liPERFILIZ();

     							$('#mover').append(resp);

								

							}

							else

							{

								liPERFILIZ();

							}

						

					},

						async: true,

						cache:false



        

					

				});

			}

			function liPERFILIZ()

			{

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+PERFILIZ,

					success: function(resp)

					{

						if(resp!=2)

							{

								liINGI();

     							$('#mover').append(resp);

								

							}

							else

							{

								liINGI();

							}

						

					},

						async: true,

						cache:false



        

					

				});

			}

			function liAD1()

			{

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+AD1,

					success: function(resp)

					{

						if(resp!=2)

							{

								liAD2();

     							$('#mover').append(resp);

								

							}

							else

							{

								liAD2();

							}

						

					},

						async: true,

						cache:false



        

					

				});

			}

			function liAD2()

			{	

				$.ajax({

					url:'mostrarImagenes.php',

					type:'POST',

					data:'cara='+AD2,

					success: function(resp)

					{

						if(resp!=2)

							{

								setTimeout(function(){verificaLi();},500);	

     							$('#mover').append(resp);

								

							}

							else

							{

                                    setTimeout(function(){verificaLi();},500);

							}

						

					},

						async: true,

						cache:false



        

					

				});

			}

			function mostrarImagenes()

			{

				console.log('mostrar imagenes');

				document.getElementById('barra_de_progreso').hidden = true;

				

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

							else

							{

								

							}

							

						

							

					},

					complete: function()

					{

						liBACK();

					},

						async: true,

						cache:false

      

					

				});

				

				/*

			

			

			

			

			

			

			

			

				*/

			

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

			mostrarImagenes();

		

  </script>

<?php }

else

{

	echo "<script>alert(\"Debe guardar primero\");producto(1,'".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$_SESSION['codprod']."'); </script>";

}

}





function Desahabilita($dato)

{

	if($dato==NULL)

	{

		return "";

	}

	else

	{

		return "disabled";

	}

}



?>