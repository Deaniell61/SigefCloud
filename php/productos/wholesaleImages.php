<script>
    setTimeout(function () {
        $("#cargaLoad").dialog("close");
    }, 500);
</script>
<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$idioma = idioma();
include($_SERVER["DOCUMENT_ROOT"] . "/php/idiomas/$idioma.php");

$codigoEmpresa = $_POST['codEmpresa'];
$pais = $_POST['pais'];
$itemCode = limpiar_caracteres_sql($_POST['icode']);

$squery = "SELECT itemcode,mastersku,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,codprod FROM cat_prod WHERE codempresa='" . $codigoEmpresa . "' AND codprod='" . $_SESSION['codprod'] . "'";

if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {

    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {

        $_SESSION['codprod'] = $row['codprod'];

        ?>
        <div id="productos">
            <script>setTimeout(function () {
                    $("#cargaLoad").dialog("close");
                }, 500);</script>
            <script src="../../js/upload.js"></script>
            <script src="../../js/bootstrap.min.js"></script>
            <!--AJAXUPLOAD -->
            <form id="ProductosImagenes" action="return false" onSubmit="return false" method="POST">
                <center>
                    <br>
                    <table>
                        <tr>
                            <div id="resultado"></div>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['MasterSKU']; ?></span></td>
                            <td><input type="text" name="masterSKU" class='entradaTexto' disabled id="masterSKU"
                                       value="<?php echo $row['mastersku']; ?>"></td>
                            <td class="text"><span><?php echo $lang[$idioma]['ItemCode']; ?></span></td>
                            <td><input type="text" name="itemCode" class='entradaTexto' disabled id="itemCode" autofocus
                                       value="<?php echo $row['itemcode']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['ProdName']; ?></span></td>
                            <td colspan="2"><input type="text" class='entradaTexto' name="prodName" disabled
                                                   id="prodName" value="<?php echo $row['prodName']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['ImagenCara']; ?></span></td>
                            <td colspan="3">
                                <select id="tipoImg" class='entradaTexto'
                                        onChange="document.getElementById('archivo').disabled = false;$('#resultado').html('');">
                                    <option value="UN"><?php echo $lang[$idioma]['UN']; ?></option>
                                    <option value="CA"><?php echo $lang[$idioma]['CA']; ?></option>
                                    <option value="PA"><?php echo $lang[$idioma]['PA']; ?></option>
                                </select>
                                <input type="file" style="float:left; margin-left:15px;" class='entradaTexto'
                                       name="archivo" id="archivo" onChange="subirArchivos();"/>
                                <progress id="barra_de_progreso" style="float:left; margin-left:10px; height:20px;"
                                          value="0" max="100"></progress>
                                <!-- <input type="button" class="cmd button button-highlight button-pill"  onclick="location.reload();" value="Guardar Cambio"/>-->
                            </td>
                        </tr>
                        <!--<tr><td></td>

            <td colspan="4" style="text-align:center;"><input type="checkbox" id="terminos" onChange="terminosCons('<?php #echo $_SESSION['codprod'];
                        ?>','<?php #echo $_SESSION['user'];
                        ?>','<?php #echo $_SESSION['codEmpresa'];
                        ?>',this.check,'<?php #echo $_SESSION['pais'];
                        ?>');"> Acepto los <a href="#" onClick="">Terminos y Condiciones del Servicio</a>  </td></tr> -->
                        <tr>
                            <td colspan="2" style="text-align:right;">
                                <ul class="mover" id="mover">
                                </ul>
                            </td>
                            <td colspan="2">
                                <br>
                                <div id="contenidos">
                                    <div id="lupa" hidden=""><img id="im" src="" width="2000px"
                                                                  style="display:inline-block;"/></div>
                                    <img id="im0" onmouseover="document.getElementById('lupa').hidden = false;Lupa();"
                                         onmouseleave="document.getElementById('lupa').hidden = true;" src=""/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </center>
        </div>
        <script>seleccion(document.getElementById('TabImagenesWholesale'));
            function limpiarImagenes() {
                document.getElementById('archivo').value = "";
                document.getElementById('archivo').disabled = true;
                document.getElementById('tipoImg').value = "";
                document.getElementById('barra_de_progreso').hidden = true;
            }
            function subirArchivos() {
                document.getElementById('barra_de_progreso').hidden = false;
                var archivos = document.getElementById('archivo').files;
                var i = 0;
                var size = archivos[i].size;
                var type = archivos[i].type;
                var name = archivos[i].name;
                var ancho = archivos[i].width;
                var alto = archivos[i].height;
                if (size < (2 * (1024 * 1024))) {
                    if (type == "image/jpeg" || type == "image/jpg") {
                        if (1) {
                            $("#archivo").upload('subir_archivo.php',
                                {
                                    nombre_archivo: $("#tipoImg").val()
                                },
                                function (respuesta) {
                                    //Subida finalizada.
                                    $("#barra_de_progreso").val(0);
                                    $('#resultado').html(respuesta);
                                    limpiarImagenes();
                                },
                                function (progreso, valor) {
                                    //Barra de progreso.
                                    $("#barra_de_progreso").val(valor);
                                }
                            );
                        }
                        else {
                            $('#resultado').html("<?php echo $lang[$idioma]['AdverAltoAncho'];?>");
                            limpiarImagenes();
                        }
                    }
                    else {
                        $('#resultado').html("<?php echo $lang[$idioma]['AdverTipo'];?>");
                        limpiarImagenes();
                    }
                }
                else {
                    $('#resultado').html("<?php echo $lang[$idioma]['AdverTamanio'];?>");
                    limpiarImagenes();
                }
            }
            function limpiarColumnas() {
                $('#mover').html("");
            }
            var UN = 'UN';
            var CA = 'CA';
            var PA = 'PA';
            function loadCA() {
                $.ajax({
                    url: 'mostrarImagenes.php',
                    type: 'POST',
                    data: 'cara=' + CA,
                    success: function (resp) {
                        if (resp != 2) {
                            loadPA();
                            $('#mover').append(resp);
                        }
                        else {
                            loadPA();
                        }
                    },
                    async: true,
                    cache: false
                });
            }
            function loadPA() {
                $.ajax({
                    url: 'mostrarImagenes.php',
                    type: 'POST',
                    data: 'cara=' + PA,
                    success: function (resp) {
                        setTimeout(function(){verificaLi();},500);
                        if (resp != 2) {
                            $('#mover').append(resp);
                        }
                        else {
                        }
                    },
                    async: true,
                    cache: false
                });
            }
            function mostrarImagenes() {
                console.log('mostrar imagenes');
                document.getElementById('barra_de_progreso').hidden = true;
                setTimeout(limpiarColumnas, 0000);
                $.ajax({
                    url: 'mostrarImagenes.php',
                    type: 'POST',
                    data: 'cara=' + UN,
                    success: function (resp) {
                        if (resp != 2) {
                            $('#mover').append(resp);
                        }
                        else {
                        }
                    },
                    complete: function () {
                        loadCA();
                    },
                    async: true,
                    cache: false
                });
            }
            function verificaLi() {
                var licant = $("#mover li").size();
                if (licant < 3) {
                    for (inx = 0; inx < (3 - licant); inx++) {
                        $('#mover').append("<li class='bor'></li>");
                    }
                }
            }
            mostrarImagenes();
        </script>
    <?php }
    else {
        echo "<script>alert(\"Debe guardar primero\");producto(1,'" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $_SESSION['codprod'] . "'); </script>";
    }
}
function Desahabilita($dato) {
    if ($dato == NULL) {
        return "";
    }
    else {
        return "disabled";
    }
}