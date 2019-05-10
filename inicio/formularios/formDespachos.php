<?php
/**
 * Created by chq
 * Date: 7/13/2016
 */
require_once('../../php/fecha.php');
require_once('../../php/coneccion.php');
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
session_start();
$currentCodProy = 'curCodProy';
$currentCodPedido = 'curCodPed';
$currentCodDespa = $_POST['coddespa'];
?>
<script>

    function loadDespacho(mDespacho) {
        //ventana('cargaLoad', 300, 400);
        $.ajax({
            type: 'POST',
            url: '/php/despachos/despachos.php',
            data: {
                method: 'loadDespacho',
                coddespa: mDespacho,
            },
            success: function (response) {

                setTimeout(function () {
                    $("#cargaLoad").dialog("close");
                }, 1000);

                $.ajax({
                    type: 'POST',
                    url: '/php/despachos/despachos.php',
                    data: {
                        method: 'loadEnc',
                        coddespa: mDespacho,
                    },
                    success: function (r) {
                        console.log(":" + r);
                        r = JSON.parse(r);
                        //console.log(r);
                        $('#despDis').val(r['numdespa']);
                        $('#nombreDis').val(r['embarque']);
                        $('#fechaDis').val(r['fechadesp']);
                    }
                });

                response = JSON.parse(response);

                $("#dataTable tr").remove();

                var val1 = 0;
                var val2 = 0;
                var val3 = 0;
                var val4 = 0;
                var val5 = 0;

                $.each(response, function (index, value) {
                    var table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
                    var row = table.insertRow(0);
                    var cel1 = row.insertCell(0);
                    var cel2 = row.insertCell(1);
                    var cel3 = row.insertCell(2);
                    var cel4 = row.insertCell(3);
                    var cel5 = row.insertCell(4);
                    var cel6 = row.insertCell(5);
                    var cel7 = row.insertCell(6);
                    var cel8 = row.insertCell(7);
                    var cel9 = row.insertCell(8);
                    var cel10 = row.insertCell(9);
                    var cel11 = row.insertCell(10);

                    cel1.innerHTML = value.mastersku;
                    cel2.innerHTML = value.nomprod;
                    cel3.innerHTML = value.presprod;
                    cel4.innerHTML = getUniDespa(value.unidespa);
                    cel5.innerHTML = Number(value.CANPA).toLocaleString('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                    cel6.innerHTML = Number(value.CANCA).toLocaleString('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                    cel7.innerHTML = Number(value.CANUN).toLocaleString('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                    cel8.innerHTML = Number(value.PRECUNDES).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    cel9.innerHTML = Number(value.TOTALDES).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    cel10.innerHTML = Number(value.PESO).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    cel11.innerHTML = value.codprod;

                    cel1.className = 'regularCell disText';
                    cel2.className = 'bigCell disText';
                    cel3.className = 'mediumCell disText';
                    cel4.className = 'regularCell disText';
                    cel5.className = 'regularCell disNum';
                    cel6.className = 'regularCell disNum';
                    cel7.className = 'regularCell disNum';
                    cel8.className = 'regularCell disNum';
                    cel9.className = 'regularCell disNum';
                    cel10.className = 'regularCell disNum';
                    cel11.className = 'regularCellH';

                    val1 = parseInt(val1) + parseInt(value.CANPA);
                    val2 = parseInt(val2) + parseInt(value.CANCA);
                    val3 = parseInt(val3) + parseInt(value.CANUN);
                    val4 = parseInt(val4) + parseInt(value.TOTALDES);
                    val5 = parseInt(val5) + parseInt(value.PESO);
                });

                var tble = $('#dataTable').DataTable();
                $(tble.column(4).footer()).html(Number(val1).toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
                $(tble.column(5).footer()).html(Number(val2).toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
                $(tble.column(6).footer()).html(Number(val3).toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
                $(tble.column(8).footer()).html(Number(val4).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $(tble.column(9).footer()).html(Number(val5).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }
        });
    }

    currentCodDespa = '<?php echo $currentCodDespa;?>';
    if (currentCodDespa != '') {
        setTimeout(function () {
            loadDespacho(currentCodDespa);
        }, 500);
    }

    $(function () {
        $("#tabs").tabs();
    });
</script>
<script src="../../js/jquery.tabletojson.min.js"></script>
<div>
    <?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/despachos/cargosProyecto.php");
    ?>
    <input type="button" value="cargos proyectos" onclick="openCargosProyecto()">

    <?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/despachos/tiposProyecto.php");
    ?>
    <input type="button" value="tipos proyectos" onclick="openTiposProyecto()">
</div>
<div id="tabs">
    <ul>
        <li><a href="#tab1">Despacho</a></li>
        <li><a href="#tab2">Proyectos</a></li>
    </ul>
    <div style="height: 75%; width:  100%" id="tab1">
        <div style="height: 50%; width: 100%; display: inline-block">
            <div style="display: inline-block; height: 100%; width: 50%; float: left; border: outset; border-width: 1px; border-radius: 10px;">

                <div style="width: 100%; height: 50%;">
                    <div style="float: left; width: 50%; height: 100%; padding: 5px;">
                        <div style="width: 100%; height: 50%; font-size: 14px;">
                            <b><?= $lang[$idioma]['NumDespacho'] ?></b>
                        </div>
                        <div style="width: 100%; height: 50%;">
                            <input disabled class="entradaTexto"
                                   style="display: inline-block; width: 100%; height: 25px;"
                                   id="despDis" type="text" name=""
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                    <div style="float: right; width: 50%; height: 100%; padding: 5px">
                        <div style="width: 100%; height: 50%; font-size: 14px;">
                            <b><?= $lang[$idioma]['Fecha'] ?></b>
                        </div>
                        <div style="width: 100%; height: 50%;">
                            <input disabled class="entradaTexto"
                                   style="display: inline-block; width: 100%; height: 25px;"
                                   id="fechaDis" type="text" name=""
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>


                <div style="width: 100%; height: 50%; padding: 5px;">
                    <div style="width: 100%; height: 50%; font-size: 14px;">
                        <b><?= $lang[$idioma]['Embarque'] ?></b>
                    </div>
                    <div style="width: 100%; height: 50%">
                        <input disabled class="entradaTexto" style="width: 100%; height: 25px;" id="nombreDis"
                               type="text"
                               name=""
                               onkeypress="return isNumber(event)">
                    </div>
                </div>

            </div>
            <div style="height: 100%; width: 50%; float: right;">

                <div style="display: inline-block; float: left; width: 100%; height: 100%; overflow-y: auto; border: outset;
                            border-width: 1px;
                            border-radius: 10px;">
                    <span style="font-size: 12px" id="bitacoraHolder"></span>
                </div>

            </div>
        </div>
        <div style="height: 40%; width: 100%; display: inline-block;">
            <div style="text-align: left; height: 90%; width: 100%; float: left; border: outset; border-width: 1px; border-radius: 10px;">
                <div style="display: inline-block; width: 3%; text-align: left;">
                    <img style="margin: auto;" src="../../images/zoom.png" onclick="openSearchProductForm()">
                </div>
                <div style="display: inline-block; width: 10%; text-align: left;">
                    <b><?= $lang[$idioma]['codigoItem'] ?></b><br>
                    <div style="display: inline-block">
                        <input class="entradaTexto" style="width: 100px; height: 25px;" id="codItem" type="text"
                               name="fname"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>
                <div style="display: inline-block; width: 27%; text-align: left; vertical-align: top ">
                    <b><?= $lang[$idioma]['descripcionProducto'] ?>:</b><br>
                    <label style="display:inline-block;
    width:100%;
    white-space: nowrap;
    overflow:hidden !important;
    text-overflow: ellipsis;" id="prodName"></label><br>
                </div>
                <div style="display: inline-block; width: 15%; text-align: left; vertical-align: top">
                    <b><?= $lang[$idioma]['unidadDespacho'] ?>:</b><br>
                    <select style="width: 100px; height: 25px;" id="despachoSelect">
                        <option>PALLETS</option>
                        <option>CAJAS</option>
                        <option>UNIDADES</option>
                    </select>
                </div>
                <div style="display: inline-block; width: 10%; text-align: left; vertical-align: top">
                    <b><?= $lang[$idioma]['cantidadDespacho'] ?></b><br>
                    <div style="display: inline-block">
                        <input class="entradaTexto" style="width: 100px; height: 25px;" id="cantidadInput" type="text"
                               name="fname"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>
                <div style="display: inline-block; width: 14%; text-align: left; vertical-align: top">
                    <b><?= $lang[$idioma]['presentacion'] ?>:</b><br>
                    <label style="display:inline-block;
    width:100%;
    white-space: nowrap;
    overflow:hidden !important;
    text-overflow: ellipsis;" id="prodPresentation"></label><br>
                </div>
                <div style="display: inline-block; width: 9%; text-align: left; vertical-align: top; margin-top: 10px">
                    <input class="cmd button button-highlight button-pill" type="submit" onclick="addRow()"
                           value="<?= $lang[$idioma]['Agregar'] ?>">
                </div>
            </div>
        </div>
    </div>
    <div id="tab2" style="width: 100%; height: 100%">
        <div id="catalogoProyectosEnc"
             style="width: 100%; height: 40%; border: outset; border-width: 1px; border-radius: 10px;">
            <script>
                $(function () {
                    $("#catalogoProyectosEnc").load("../../php/despachos/catalogoProyectosEnc.php");
                });
            </script>
        </div>
        <div id="catalogoProyectosDet"
             style="width: 100%; height: 50%; border: outset; border-width: 1px; border-radius: 10px;">
            <script>
                $(function () {
                    $("#catalogoProyectosDet").load("../../php/despachos/catalogoProyectosDet.php");
                });
            </script>
        </div>
    </div>
</div>
<div>
    <input class="cmd button button-highlight button-pill" type="button" onclick="saveData()"
           value="<?= $lang[$idioma]['Guardar'] ?>">
</div>
<br>
<div id="dataTableContainer">
    <div id="dataTableHolder">
        <table id="dataTable">
            <thead>
            <tr>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Codigo Item</th>
                <th style="width: 340px; padding: 5px 5px 5px 5px; text-align: center !important;">Descripcion del
                    Producto
                </th>
                <th style="width: 150px; padding: 5px 5px 5px 5px; text-align: center !important;">Presentacion</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Unidad Despacho</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Cantidad Pallets</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Cantidad Cajas</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Cantidad Unidades</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Precio Unidad</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Valor Total</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;">Total Peso</th>
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;"></th>
                <th style="width: 340px; padding: 5px 5px 5px 5px; text-align: center !important;"></th>
                <th style="width: 150px; padding: 5px 5px 5px 5px; text-align: center !important;"></th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;"></th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;" id="totPallets">0</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;" id="totCajas">0</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;" id="totUnidades">0
                </th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;"></th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;" id="totValor">0</th>
                <th style="width: 90px; padding: 5px 5px 5px 5px; text-align: center !important;" id="totPeso">0</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<div>
    <input class="cmd button button-highlight button-pill" type="button" onclick="back()"
           value="<?= $lang[$idioma]['Salir'] ?>">
</div>

<div id="cargaLoad"></div>
<div id="codProyHolder"></div>
<div id="codPedHolder"></div>

<div hidden id="searchProductForm" title="<?= $lang[$idioma]['Buscar'] ?>" style="text-align: center">
    <br><br><br>
    <b><?= $lang[$idioma]['Codigo'] ?> / <?= $lang[$idioma]['Nombre'] ?></b>
    <br><br>
    <input id="searchProductInput" class="entradaTexto" style="width: 75%; height: 25px;" type="text">
    <br><br>
    <input class="cmd button button-highlight button-pill" type="button" onclick="useProduct()"
           value="<?= $lang[$idioma]['Agregar'] ?>">
</div>

<script>
    var masterData = [];
    var data;
    function getProduct() {
        masterData = [];
        if (document.getElementById('codItem').value != '') {
            $.ajax({
                type: 'POST',
                url: '/php/despachos/despachos.php',
                data: {
                    method: 'getProduct',
                    codItem: document.getElementById('codItem').value,
                },
                success: function (response) {
                    data = JSON.parse(response);
                    masterData.push(data);
                    //console.log(data);

                    if (data['status'] == 1) {
                        document.getElementById("codItem").style.borderColor = "green";
                        document.getElementById('prodName').innerHTML = data['prodName'];
                        document.getElementById('prodPresentation').innerHTML = data['prodPresentation'];
                        //$('#prodDescriptions').show(100);
                    }
                    else if (data['status'] == 0) {
                        document.getElementById("codItem").style.borderColor = "red";
                        //$('#prodDescriptions').hide(100);
                        document.getElementById('prodName').innerHTML = '';
                        document.getElementById('prodPresentation').innerHTML = '';
                    }
                    $('#despachosList').hide(100);
                },
            });
        }
    }

    function addRow() {
        if (data != null) {
            if (document.getElementById('cantidadInput').value != '') {
                despSelect = document.getElementById('despachoSelect').value;
                quantity = document.getElementById('cantidadInput').value;
                data['unidadDespacho'] = despSelect;
                if (despSelect == 'PALLETS') {
                    data['palletQ'] = Math.ceil(quantity);
                    data['cajaQ'] = Math.ceil((quantity * data['cajasPallet']));
                    data['unidadQ'] = (quantity * data['cajasPallet'] * data['unidadesCaja']);
                }
                else if (despSelect == 'CAJAS') {
                    //console.log(data['cajasPallet']);
                    data['palletQ'] = isFinite(Math.ceil((quantity / data['cajasPallet']))) ? Math.ceil((quantity / data['cajasPallet'])) : 1;
                    data['cajaQ'] = Math.ceil(quantity);
                    data['unidadQ'] = (quantity * data['unidadesCaja']);
                }
                else if (despSelect == 'UNIDADES') {
                    data['palletQ'] = isFinite(Math.ceil((quantity / data['unidadesCaja'] / data['cajasPallet']))) ? Math.ceil((quantity / data['unidadesCaja'] / data['cajasPallet'])) : 1;
                    data['cajaQ'] = Math.ceil((quantity / data['unidadesCaja']));
                    data['unidadQ'] = quantity;
                }
                data['valorTotal'] = Number(data['unidadQ'] * data['prodCosto']).toFixed(2);
                data['pesoTotal'] = Number(data['unidadQ'] * data['peso']).toFixed(2);
                var table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
                var row = table.insertRow(0);

                var cel1 = row.insertCell(0);
                var cel2 = row.insertCell(1);
                var cel3 = row.insertCell(2);
                var cel4 = row.insertCell(3);
                var cel5 = row.insertCell(4);
                var cel6 = row.insertCell(5);
                var cel7 = row.insertCell(6);
                var cel8 = row.insertCell(7);
                var cel9 = row.insertCell(8);
                var cel10 = row.insertCell(9);
                var cel11 = row.insertCell(10);

                cel1.innerHTML = data['codItem'];
                cel2.innerHTML = data['prodName'];
                cel3.innerHTML = data['prodPresentation'];
                cel4.innerHTML = data['unidadDespacho'];
                cel5.innerHTML = data['palletQ'];
                cel6.innerHTML = Number(data['cajaQ']).toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                cel7.innerHTML = Number(data['unidadQ']).toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                cel8.innerHTML = Number(data['prodCosto']).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                cel9.innerHTML = Number(data['valorTotal']).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                cel10.innerHTML = Number(data['pesoTotal']).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                cel11.innerHTML = masterData[0]['codProd'];

                cel1.className = 'regularCell disText';
                cel2.className = 'bigCell disText';
                cel3.className = 'mediumCell disText';
                cel4.className = 'regularCell disText';
                cel5.className = 'regularCell disNum';
                cel6.className = 'regularCell disNum';
                cel7.className = 'regularCell disNum';
                cel8.className = 'regularCell disNum';
                cel9.className = 'regularCell disNum';
                cel10.className = 'regularCell disNum';
                cel11.className = 'regularCellH';

                calcTotal(4, 'palletQ', 0);
                calcTotal(5, 'cajaQ', 0);
                calcTotal(6, 'unidadQ', 0);
                calcTotal(8, 'valorTotal', 2);
                calcTotal(9, 'pesoTotal', 2);
                data = null;
                document.getElementById('prodName').innerHTML = '';
                document.getElementById('prodPresentation').innerHTML = '';
                document.getElementById('codItem').value = '';
                document.getElementById('cantidadInput').value = '';
                $('#prodDescriptions').hide(100);
                document.getElementById("codItem").style.removeProperty('border-color');
                document.getElementById("cantidadInput").style.removeProperty('border-color');
                document.getElementById("despachoSelect").options[0].selected = true;
            }
            else {
                document.getElementById("cantidadInput").style.borderColor = "red";
            }
            document.getElementById('codItem').focus();
        }
    }

    function saveData() {
        var table = $('#dataTable').tableToJSON({
            headings: ['mastersku', 'nomprod', 'presprod', 'unidespa', 'canpa', 'canca', 'canun', 'precundes', 'totaldes', 'peso', 'codprod']
        });
        //console.log(JSON.stringify(table));
        var tcoddespa;
        if (table.length > 0) {
            ventana('cargaLoad', 300, 400);
            $.ajax({
                type: 'POST',
                url: '/php/despachos/despachos.php',
                data: {
                    method: 'saveData',
                    coddespa: currentCodDespa,
                    json: JSON.stringify(table),
                },
                success: function (response) {
                    console.log(response);
                    currentCodDespa = response;
//                    console.log('SD1' + response + '! ');
                    tcoddespa = response;
                    setTimeout(function () {
                        $("#cargaLoad").dialog("close");
                    }, 1000);

                    $.ajax({
                        type: 'POST',
                        url: '/php/despachos/despachos.php',
                        data: {
                            method: 'loadEnc',
                            coddespa: response,
                        },
                        success: function (r) {
//                            console.log('SD2' + r + '! ');
                            r = JSON.parse(r);
                            $('#despDis').val(r['numdespa']);
                            $('#nombreDis').val(r['embarque']);
                            $('#fechaDis').val(r['fechadesp']);

                            var tble = $('#dataTable').DataTable();
                            var tValor = $(tble.column(8).footer()).html();
                            var tPeso = $(tble.column(9).footer()).html();
                            var tUnidad = $(tble.column(5).footer()).html();

                            //console.log(tValor + ' - ' + tPeso + ' - ' + tUnidad + ' - ' + response + ' - ' + r['embarque']);


//                            console.log('aca se inserta pedido ' + r['codproy']);
                            $.ajax({
                                type: 'POST',
                                url: '/php/despachos/despachos.php',
                                data: {
                                    method: 'insertarEncPedidos',
                                    valor: tValor,
                                    peso: tPeso,
                                    unidad: tUnidad,
                                    codProy: r['codproy'],
                                    codDespa: tcoddespa,
                                    embarque: r['embarque'],
                                },
                                success: function (respEnc) {
                                    //console.log('SD3' + respEnc);
                                    $.ajax({
                                        type: 'POST',
                                        url: '/php/despachos/despachos.php',
                                        data: {
                                            method: 'insertarPedidos',
                                            coddespa: tcoddespa,
                                            codpedido: respEnc,
                                            json: JSON.stringify(table),
                                        },
                                        success: function (r1) {
                                            console.log('insertDetalle:' + r1);
                                        },
                                        error: function (r1) {
                                            console.log('er:' + JSON.stringify(r1));
                                        }
                                    });
                                },
                                error: function (r) {
                                    console.log('er:' + JSON.stringify(r));
                                }
                            });
                        }
                    });

                },
                error: function (response) {
                    console.log('error:' + response);
                }
            });
        }
    }

    function calcTotal(colIndex, dataKey, decimals) {
        table = $('#dataTable').DataTable();
        v1 = parseFloat($(table.column(colIndex).footer()).html());
        v2 = parseFloat(data[dataKey]);
        tResp = (v1 + v2).toFixed(decimals);
        if (colIndex == 4 || colIndex == 5 || colIndex == 6) {
            $(table.column(colIndex).footer()).html(Number(tResp).toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }));
        }
        else {
            $(table.column(colIndex).footer()).html(Number(tResp).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }

    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $('#despachosListToggle').click(function () {
        $('#despachosList').toggle(100);
    });

    //nuevo
    $('#newDespacho').click(function () {
        $('#despachosList').hide(100);
        $("#dataTable tr").remove();
        $('#codPedHolder').text('');
        $('#codProyHolder').text('');
    });

    $('#dataTable').DataTable({

        "scrollY": "375px",
        "scrollX": false,
        "paging": false,
        "info": false,
        'bFilter': false,
        'bSort': false,
    });

    $('#despachosListTable').DataTable({
        "paging": false,
        "filter": false,
        "info": false,
        "scrollY": "100px",
        "scrollCollapse": true
    });

    $("#codItem").focusout(function () {
        getProduct();
    });

    function getUniDespa(name) {
        switch (name) {
            case 'PA':
                return 'PALLETS';
            case 'CA':
                return 'CAJAS';
            case 'UN':
                return 'UNIDADES';
        }
    }

    function back() {
        formulario('10');
    }

    function openSearchProductForm() {
        if ($("#searchProductForm").hasClass("ui-dialog-content") &&
            $("#searchProductForm").dialog("isOpen")) {
            $("#searchProductForm").dialog("open");
        } else {
            $("#searchProductForm").dialog({
                width: 650,
                height: 300,
                modal: true,
            });
        }

        $("#searchProductInput").val("");
    }

    $(function () {
        $("#searchProductInput").autocomplete({
            source: '../../php/despachos/getProduct.php',
            delay: 500,
            minLength: 4,
            position: {my: "center top", at: "center bottom"}
        });
    });

    function useProduct() {
        $("#searchProductForm").dialog('close');
        var codItem = $("#searchProductInput").val().toString().split(" - ")[0];
        $("#codItem").val(codItem);
        $("#codItem").focus();
        $("#despachoSelect").focus();
    }
</script>

<link rel="stylesheet" type="text/css" href="/css/despachos.css">
<script src="/js/funcionesScriptDespachos.js"></script>
<style>
    #dataTableContainer {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    #dataTableHolder {
        width: 1250px;
        height: 500px;
    }

    .dataTables_empty {
        display: none;
    }

    table.dataTables {

    tfoot {

    th {
        font-size: 8px !important;
    }

    }
    }

    #despachosList {
        height: 150px;
        width: 600px;
        margin: 0 auto;
    }

    .regularCell {
        width: 90px;
        padding: 5px 5px 5px 5px !important;
    }

    .regularCellH {
        display: none;
        width: 90px;
    }

    .mediumCell {
        width: 150px;
        padding: 5px 5px 5px 5px !important;
    }

    .bigCell {
        width: 340px;
        padding: 5px 5px 5px 5px !important;
    }

    .disNum {
        text-align: right !important;
    }

    .disText {
        text-align: left !important;
    }

    #tabs {
        width: 100%;
        height: 550px;
        margin: auto;
    }

    .ui-autocomplete {
        z-index: 5000;
    }
</style>