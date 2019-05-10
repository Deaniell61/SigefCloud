/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
//here be dragons
prosigue = false;

var cat1 = 0;
var funciona = 0;

function guardarProducto() {
    masterSKU = limpiarCaracteresEspeciales(document.getElementById('masterSKU').value);
    prodName = limpiarCaracteresEspeciales(document.getElementById('prodName').value);
    descSis = limpiarCaracteresEspeciales(document.getElementById('descSistema').value);
    SName = limpiarCaracteresEspeciales(document.getElementById('SName').value);
    EName = limpiarCaracteresEspeciales(document.getElementById('EName').value);
    prodLin = limpiarCaracteresEspeciales(document.getElementById('prodLin').value);
    subCategory2 = limpiarCaracteresEspeciales(document.getElementById('subCategory2').value);

    subCategory1 = limpiarCaracteresEspeciales(document.getElementById('subCategory1').value);

    marca = limpiarCaracteresEspeciales(document.getElementById('marca').value);

    package = limpiarCaracteresEspeciales(document.getElementById('pakage').value);
    UPC = limpiarCaracteresEspeciales(document.getElementById('UPC').value);
    category = limpiarCaracteresEspeciales(document.getElementById('category').value);
    genero = limpiarCaracteresEspeciales(document.getElementById('genero').value);
    flavor = limpiarCaracteresEspeciales(document.getElementById('flavor').value);
    manufacturadores = limpiarCaracteresEspeciales(document.getElementById('manufacturadores').value);
    age = limpiarCaracteresEspeciales(document.getElementById('age').value);
    formula = limpiarCaracteresEspeciales(document.getElementById('formula').value);
    paisOrigen = limpiarCaracteresEspeciales(document.getElementById('paisOrigen').value);
    concerns = limpiarCaracteresEspeciales(document.getElementById('concerns').value);
    cocina = limpiarCaracteresEspeciales(document.getElementById('cocina').value);
    itemCode = limpiarCaracteresEspeciales(document.getElementById('itemCode').value);
    SizeCount = limpiarCaracteresEspeciales(document.getElementById('SizeCount').value);
    FCE = limpiarCaracteresEspeciales(document.getElementById('FCE').value);
    SID = limpiarCaracteresEspeciales(document.getElementById('SID').value);
    existe = false;
    if ((document.getElementById('itemCode').disabled)) {
        existe = true;
    }

    //alert(verCategoria(category,subCategory1,1));
    //&& verCategoria(category,subCategory1,1)

    // console.log("rpodname" + document.getElementById('descSistema').value);
    // console.log("rpodname" + descSis);

    if ((descSis != "" && SName != "" && EName != "" && category != "" && marca != "" && manufacturadores != "" && package != "" && funciona == 1)) {
        if (cat1 == 1) {
            if (subCategory1 != "") {
                guardaro = 1;
                $.ajax({
                    url: 'ingresoProductos.php',
                    type: 'POST',
                    data: {
                        masterSKU: masterSKU,
                        descSis:descSis,
                        prodName:prodName,
                        SName:SName,
                        EName:EName,
                        itemCode:itemCode,
                        prodLin:prodLin,
                        subCategory2:subCategory2,
                        subCategory1:subCategory1,
                        marca:marca,
                        pakage:package,
                        UPC:UPC,
                        category:category,
                        existe:existe,
                        genero:genero,
                        flavor:flavor,
                        manufacturadores:manufacturadores,
                        age:age,
                        formula:formula,
                        paisOrigen:paisOrigen,
                        concerns:concerns,
                        cocina:cocina,
                        FCE:FCE,
                        SizeCount:SizeCount,
                        SID:SID,
                    },
                    success: function (resp) {
                        console.log("rpodname" + descSis);
                        $('#resultado').html(resp);

                    }


                });
            } else {
                $('#advertencia').show();
            }
        } else {
            guardaro = 1;
            $.ajax({
                url: 'ingresoProductos.php',
                type: 'POST',
                data: 'masterSKU=' + masterSKU + '&descSis=' + descSis + '&prodName=' + prodName + '&SName=' + SName + '&EName=' + EName + '&itemCode=' + itemCode + '&prodLin=' + prodLin + '&subCategory2=' + subCategory2 + '&subCategory1=' + subCategory1 + '&marca=' + marca + '&pakage=' + package + '&UPC=' + UPC + '&category=' + category + '&existe=' + existe + '&genero=' + genero + '&flavor=' + flavor + '&manufacturadores=' + manufacturadores + '&age=' + age + '&formula=' + formula + '&paisOrigen=' + paisOrigen + '&concerns=' + concerns + '&cocina=' + cocina + '&FCE=' + FCE + '&SizeCount=' + SizeCount + '&SID=' + SID,
                success: function (resp) {
                    $('#resultado').html(resp);

                }

            });
        }
    } else {

        $('#advertencia').show();
    }
}

function actualizaProducto(tipo, //1
                           masterSKU, //2
                           prodName, //3
                           itemCode, //4
                           keyWords, //5
                           obserbs, //6
                           metaTitle, //7
                           prodDesc, //8
                           codPres, //9
                           pesoTotLB, //10
                           libras, //11
                           onzas, //12
                           alto, //13
                           ancho, //14
                           largo, //15
                           uniVenta, //16
                           ubundle, //17
                           cospri, //18
                           bunName, //19
                           bundAmSKU) {

    demas = "";
    //console.log('js ' + tipo + ' - ' + prodName);
    //console.log(tipo + ' - ' + codPres);
    //console.log(tipo + ' - ' + limpiarCaracteresEspeciales(codPres));
    if (tipo == "estibar") {

        e2 = document.getElementById('NivelesPallet');
        e1 = document.getElementById('CajasNivel');
        //e3 = document.getElementById('FormaDeEstibarCA');
        e4 = document.getElementById('NivelesPallet');

        //enviar mail si imagen no existe al guardar
        clean1 = e1.value.replace('x', '');
        clean2 = e2.value.replace('x', '');
        //clean3 = e3.value.replace('x', '');
        clean4 = e4.value.replace('x', '');

        //filename = clean1 + "x" + clean2 + "x" + clean3 + "x" + clean4 + ".jpg";
        filename = clean1 + "x" + clean2 + "x" + clean4 + ".jpg";
        url = window.location.origin + "/images/cajas/" + filename;

        $.get(url).fail(function () {
            $.ajax({
                url: 'estibarSimpleMail.php',
                type: 'POST',
                data: 'img=' + filename,
            });
        })
    }

    if (tipo == 'estibarC') {
        tipo = 'estibar';
    }

    if (tipo == "dimensiones") {
        altoCA = document.getElementById('altoCaja').value;
        anchoCA = document.getElementById('anchoCaja').value;
        profCA = document.getElementById('largoCaja').value;
        pesoLBCA = document.getElementById('librasCaja').value;
        pesoOZCA = document.getElementById('onzasCaja').value;
        altoPA = document.getElementById('altoPallet').value;
        anchoPA = document.getElementById('anchoPallet').value;
        profPA = document.getElementById('largoPallet').value;
        pesoLBPA = document.getElementById('librasPallet').value;
        pesoOZPA = document.getElementById('onzasPallet').value;
        demas = '&altoCA=' + limpiarCaracteresEspeciales(altoCA) + '&anchoCA=' + limpiarCaracteresEspeciales(anchoCA) + '&profCA=' + limpiarCaracteresEspeciales(profCA) + '&pesoLBCA=' + limpiarCaracteresEspeciales(pesoLBCA) + '&pesoOZCA=' + limpiarCaracteresEspeciales(pesoOZCA) + '&altoPA=' + limpiarCaracteresEspeciales(altoPA) + '&anchoPA=' + limpiarCaracteresEspeciales(anchoPA) + '&profPA=' + limpiarCaracteresEspeciales(profPA) + '&pesoLBPA=' + limpiarCaracteresEspeciales(pesoLBPA) + '&pesoOZPA=0';
    }

    if (tipo == "metaData") {
        short = limpiarCaracteresEspeciales(document.getElementById('prodDescShort').value);
        short1 = limpiarCaracteresEspeciales(document.getElementById('prodDescShort1').value);
        short2 = limpiarCaracteresEspeciales(document.getElementById('prodDescShort2').value);
        short3 = limpiarCaracteresEspeciales(document.getElementById('prodDescShort3').value);
        short4 = limpiarCaracteresEspeciales(document.getElementById('prodDescShort4').value); //document.getElementById('prodDescShort').value
        demas = '&shortdesc=' + short + '&shortdesc1=' + short1 + '&shortdesc2=' + short2 + '&shortdesc3=' + short3 + '&shortdesc4=' + short4;
    }
    var tData = 'masterSKU=' + masterSKU + '&prodName=' + limpiarCaracteresEspeciales(prodName) + '&itemCode=' + limpiarCaracteresEspeciales(itemCode) + '&tipo=' + tipo + '&keyWords=' + limpiarCaracteresEspeciales(keyWords) + '&obserbs=' + limpiarCaracteresEspeciales(obserbs) + '&metaTitle=' + limpiarCaracteresEspeciales(metaTitle) + '&prodDesc=' + limpiarCaracteresEspeciales(prodDesc) + '&pesoTotLB=' + limpiarCaracteresEspeciales(pesoTotLB) + '&codPres=' + limpiarCaracteresEspeciales(codPres) + '&alto=' + limpiarCaracteresEspeciales(alto) + '&ancho=' + limpiarCaracteresEspeciales(ancho) + '&largo=' + limpiarCaracteresEspeciales(largo) + '&libras=' + limpiarCaracteresEspeciales(libras) + '&onzas=' + limpiarCaracteresEspeciales(onzas) + '&uniVenta=' + limpiarCaracteresEspeciales(uniVenta) + '&ubundle=' + limpiarCaracteresEspeciales(ubundle) + '&cospri=' + limpiarCaracteresEspeciales(cospri) + '&bunName=' + limpiarCaracteresEspeciales(bunName) + '&bunAmSKU=' + limpiarCaracteresEspeciales(bundAmSKU) + demas;

    console.log('TIPO: ' + tipo + ' DATA: ' + tData);
    $.ajax({
        url: 'actualizarProducto.php',
        type: 'POST',
        data: tData,
        success: function (resp) {
            //console.log('EXITO ' + tipo);
            $('#resultado').html(resp);
            guardaro = 1;
        },
        error: function (resp) {
            console.log('ERROR ' + tipo + ' ' + JSON.stringify(resp));
        }
    });
}

function buscarProducto(itemcode, codEmpresa, pais, e) {
    $.ajax({
        url: 'buscarProductos.php',
        type: 'POST',
        data: 'codigo=' + itemcode + '&codEmpresa=' + codEmpresa + '&pais=' + pais,
        success: function (resp) {
            $('#resultado').html(resp);
        }
    });
}

function updatePublishStatus(mSKU, mStatus) {
    // console.log(mSKU + '' + mStatus);
    tStatus = 0;
    if (mStatus) {
        tStatus = 1;
    }
    $.ajax({
        url: 'actualizarProducto.php',
        type: 'POST',
        data: {
            tipo: 'publish',
            sku: mSKU,
            status: tStatus,
            prodName: 'placeholder',
        },
        success: function (resp) {
            console.log(resp);
        }
    });
}

function generateBarcode(upc) {
    prodName = $('#prodName').val();
    if (upc != "") {
        $.ajax({
            url: 'barCode.php',
            type: 'POST',
            data: 'UPC=' + upc,
            success: function (resp) {
                $('#codigo').html(resp);
            }
        });
    }
}

function agregarPesoTotal(lb, oz, to) {
    libras = document.getElementById(lb).value;
    onzas = document.getElementById(oz).value;

    //alert(to);
    var pesoTotLB = libras / 1;
    var pesoTotOnz = (onzas / 16) * 1;
    var pesoTot = pesoTotLB + pesoTotOnz;

    document.getElementById(to).value = "";
    document.getElementById(to).value = pesoTot;
}

function calcularUnidades(univenta, ubundle, masterSKU, itemCode, prodName) {
    var unidades = univenta / ubundle;
    document.getElementById('paquetes').value = Math.round(unidades) - (Math.round(unidades) - Math.floor(unidades));
}

function llamarBundleN(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov) {

    $('#bundle').html('<img src="../../images/loader.gif" alt="" /><span>Creando...</span>');
    $.ajax({
        url: 'Bundle.php',
        type: 'POST',
        data: 'masterSKU=' + masterSKU + '&codprod=' + codprod + '&prodName=' + limpiarCaracteresEspeciales(prodName) + '&unidadesCaja=' + uniVenta + '&uBundle=' + uBundle + '&unidadesPaquete=' + uPaquetes + '&canal=' + canal + '&codprov=' + codprov,
        success: function (resp) {
            // console.log(resp);
            actualizarPreciosBundlesN(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov);
        },
        error: function (resp) {
            console.log('error : ' + JSON.stringify(resp));
        }

    });
}

function llamarBundle(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov) {

    $('#bundle').html('<img src="../../images/loader.gif" alt="" /><span>Loader..</span>');
    actualizarPreciosBundles(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov);


}

function detalleBundle(masterSKU, prodName, codBundle, codempresa, amazonSKU, canal, codprov, lbundle) {
    var si = 0;
    $('#detallesBundle').html('<img src="../../images/loader.gif" alt="" /><span>Loader...</span>');
    $.ajax({
        url: 'detalleBundle.php',
        type: 'POST',
        data: 'masterSKU=' + masterSKU + '&prodName=' + limpiarCaracteresEspeciales(prodName) + '&codBundle=' + codBundle + '&codempresa=' + codempresa + '&amazonSKU=' + amazonSKU + '&canal=' + canal + '&codprov=' + codprov + '&lbundle=' + lbundle,
        complete: function (resp, oa) {
            si = 1;
        },
        success: function (resp) {
            $('#detallesBundle').html(resp);
        }
    });
}

function cargarProgres() {
    conteo = 1;
    i = 0;

    {
        setInterval(function () {
            document.getElementById('barraProgreso').value = ((i / 80) * 100);
            i++;
            if (i == 50) {
                document.getElementById('barraProgreso').hidden = true;
                setTimeout(function () {
                    $("#cargaLoadB").dialog("close");
                }, 500);
                document.getElementById('resActua').hidden = false;
            }
        }, 1000);

    }
}

function actualizarPreciosBundles(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov) {

    $.ajax({
        url: 'PreciosBundles.php',
        type: 'POST',
        data: 'masterSKU=' + masterSKU,
        success: function (resp) {
            console.log(resp);
            //$('#bundle').html(resp);
            //$('#bundle').html('si hay');
            $('#bundle').html('refrescando...   ');
        },
        error: function (resp) {
            console.log('error ' + JSON.stringify(resp));
            location.reload();
        },
        complete: function () {
            var tData = 'masterSKU=' + masterSKU + '&codprod=' + codprod + '&prodName=' + prodName + '&unidadesCaja=' + uniVenta + '&uBundle=' + uBundle + '&unidadesPaquete=' + uPaquetes + '&canal=' + canal + '&codprov=' + codprov;
            $.ajax({
                url: 'Bundle.php',
                type: 'POST',
                data: tData,
                success: function (resp) {
                    // console.log(resp);
                    console.log("HERE");
                    $('#bundle').html(resp);
                    setTimeout(function () {
                        $.ajax({
                            url: 'bundleAux.php',
                            type: 'POST',
                            success: function (resp) {
                                console.log(">>>" + resp);
                                setTimeout(function () {
                                    var v1 = resp.split(" ")[0];
                                    var v2 = resp.split(" ")[1];
                                    $("#tCargosCanal").val(v1);
                                    $("#tUtilidad").val(v2);
                                }, 500);

                            }
                        });
                    }, 500);

                }
            });
        }
    });
}

function actualizarPreciosBundlesC(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov) {

    //console.log(masterSKU+'-'+codprod+'-'+prodName);
    $.ajax({
        url: 'PreciosBundlesC.php',
        type: 'POST',
        data: 'masterSKU=' + masterSKU + '&amazonSKU=' + codprod + '&newBundlePrice=' + prodName,
        success: function (resp) {

            console.log('Resp' + resp);
            setTimeout(function () {
                $("#cargaLoadGeneral").dialog("close");
            }, 500);

            resp = JSON.parse(resp);

            var tCospri = resp['COSPRI'];
            tCospri = parseFloat(tCospri).toFixed(2);

            var tChannelFee = resp['CHANNELFEE'];
            tChannelFee = parseFloat(tChannelFee).toFixed(2);

            var tNetrevossp = resp['NETREVOSSP'];
            tNetrevossp = parseFloat(tNetrevossp).toFixed(2);

            var tShipping = resp['SHIPPING'];
            tShipping = parseFloat(tShipping).toFixed(2);

            var tSugsalpric = resp['SUGSALPRIC'];
            tSugsalpric = parseFloat(tSugsalpric).toFixed(2);

            var tBununipri = resp['BUNUNIPRI'];
            tBununipri = parseFloat(tBununipri).toFixed(2);

            var tMarovessp = resp['MAROVEITEC'];
            tMarovessp = parseFloat(tMarovessp).toFixed(2);

            $("#cospri").val('$ ' + tCospri);
            $("#channelFee").val('$ ' + tChannelFee);
            $("#netrevossp").val('$ ' + tNetrevossp);
            $("#shipping").val('$ ' + tShipping);
            $("#sugsalpric").val('$ ' + tSugsalpric);
            $("#BUNUNIPRI").val('$ ' + tBununipri);
            $("#marovessp").val('% ' + tMarovessp);

            //$('#bundle').html(resp);
            /*
            $.ajax({
                url: 'Bundle.php',
                type: 'POST',
                data: 'masterSKU=' + masterSKU + '&codprod=' + codprod + '&prodName=' + prodName + '&unidadesCaja=' + uniVenta + '&uBundle=' + uBundle + '&unidadesPaquete=' + uPaquetes + '&canal=' + canal + '&codprov=' + codprov,
                success: function (resp) {
                    $('#bundle').html(resp);
                }
            });
            */
        },
        error: function (resp) {
            console.log('error ' + JSON.stringify(resp));
            location.reload();
        }
    });
}

function actualizarPreciosBundlesCMin(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov) {

    //console.log(masterSKU+'-'+codprod+'-'+prodName);
    $.ajax({
        url: 'PreciosBundlesC.php',
        type: 'POST',
        data: 'masterSKU=' + masterSKU + '&amazonSKU=' + codprod + '&newBundlePrice=' + prodName,
        success: function (resp) {

            // console.log('Rmin:' + resp);
            setTimeout(function () {
                $("#cargaLoadGeneral").dialog("close");
            }, 500);

            resp = JSON.parse(resp);

            var tCospri = resp['COSPRI'];
            tCospri = parseFloat(tCospri).toFixed(2);

            var tChannelFee = resp['CHANNELFEE'];
            tChannelFee = parseFloat(tChannelFee).toFixed(2);

            var tNetrevossp = resp['NETREVOSSP'];
            tNetrevossp = parseFloat(tNetrevossp).toFixed(2);

            var tShipping = resp['SHIPPING'];
            tShipping = parseFloat(tShipping).toFixed(2);

            var tSugsalpric = resp['SUGSALPRIC'];
            tSugsalpric = parseFloat(tSugsalpric).toFixed(2);

            var tBununipri = resp['BUNUNIPRI'];
            tBununipri = parseFloat(tBununipri).toFixed(2);

            var tMarovessp = resp['MAROVEITEC'];
            tMarovessp = parseFloat(tMarovessp).toFixed(2);

            $("#cospriMin").val('$ ' + tCospri);
            $("#channelFeeMin").val('$ ' + tChannelFee);
            $("#netrevosspMin").val('$ ' + tNetrevossp);
            $("#shippingMin").val('$ ' + tShipping);
            $("#sugsalpricMin").val('$ ' + tSugsalpric);
            $("#BUNUNIPRIMin").val('$ ' + tBununipri);
            $("#marovesspMin").val('% ' + tMarovessp);
        },
        error: function (resp) {
            console.log('error ' + JSON.stringify(resp));
            location.reload();
        }
    });
}

function actualizarPreciosBundlesCMax(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov) {

    //console.log(masterSKU+'-'+codprod+'-'+prodName);
    $.ajax({
        url: 'PreciosBundlesC.php',
        type: 'POST',
        data: 'masterSKU=' + masterSKU + '&amazonSKU=' + codprod + '&newBundlePrice=' + prodName,
        success: function (resp) {

            // console.log('RMax:' + resp);
            setTimeout(function () {
                $("#cargaLoadGeneral").dialog("close");
            }, 500);

            resp = JSON.parse(resp);

            var tCospri = resp['COSPRI'];
            tCospri = parseFloat(tCospri).toFixed(2);

            var tChannelFee = resp['CHANNELFEE'];
            tChannelFee = parseFloat(tChannelFee).toFixed(2);

            var tNetrevossp = resp['NETREVOSSP'];
            tNetrevossp = parseFloat(tNetrevossp).toFixed(2);

            var tShipping = resp['SHIPPING'];
            tShipping = parseFloat(tShipping).toFixed(2);

            var tSugsalpric = resp['SUGSALPRIC'];
            tSugsalpric = parseFloat(tSugsalpric).toFixed(2);

            var tBununipri = resp['BUNUNIPRI'];
            tBununipri = parseFloat(tBununipri).toFixed(2);

            var tMarovessp = resp['MAROVEITEC'];
            tMarovessp = parseFloat(tMarovessp).toFixed(2);

            $("#cospriMax").val('$ ' + tCospri);
            $("#channelFeeMax").val('$ ' + tChannelFee);
            $("#netrevosspMax").val('$ ' + tNetrevossp);
            $("#shippingMax").val('$ ' + tShipping);
            $("#sugsalpricMax").val('$ ' + tSugsalpric);
            $("#BUNUNIPRIMax").val('$ ' + tBununipri);
            $("#marovesspMax").val('% ' + tMarovessp);
        },
        error: function (resp) {
            console.log('error ' + JSON.stringify(resp));
            location.reload();
        }
    });
}

function actualizarPreciosBundlesN(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov) {
    console.log(' sku:' + masterSKU + ' codprod:' + codprod + ' prodname:' + prodName + ' univenta:' + uniVenta + ' unitbundle:' + uBundle + ' upaquetes:' + uPaquetes + ' ucanal:' + canal + ' codprov:' + codprov);
    var t0 = performance.now();
    console.log('4');
    $.ajax({
        url: 'PreciosBundles.php',
        type: 'POST',
        data: 'masterSKU=' + masterSKU,
        success: function (resp) {
            llamarBundle(masterSKU, codprod, prodName, uniVenta, uBundle, uPaquetes, canal, codprov);
        }
    });
}

function prodname(ingles, espanol) {
    document.getElementById('prodName').value = ingles + " - " + espanol;
}

function com() {
    bueno1(document.getElementById('EName'));
    bueno1(document.getElementById('SName'));
    bueno1(document.getElementById('descSistema'));
    bueno1(document.getElementById('marca'));
    bueno1(document.getElementById('manufacturadores'));
    bueno1(document.getElementById('category'));
    if (cat1 == 1) {
        bueno1(document.getElementById('subCategory1'));
    }
    bueno1(document.getElementById('pakage'));
}


function subCategorias(codempresa, pais, categoria, tipo) {
    cat1 = 0;
    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&categoria=' + categoria,
        success: function (resp) {
            $('#subCategory1').html(resp);

        }

    });
    setTimeout(com, 500);
    parametrosEspecificos(codempresa, pais, categoria);
}

function subCategorias2(codempresa, pais, categoria, tipo) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&categoria=' + categoria,
        success: function (resp) {

            $('#subCategory2').html(resp);
        }

    });
    parametrosEspecificos(codempresa, pais, categoria);
}

function parametrosEspecificos(codempresa, pais, category) {


    $.ajax({
        url: 'parametrosEspecificos.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&category=' + category,
        success: function (resp) {
            $('#paramEspecific').html(resp);

        }
    });
}

function seleccion(li) {
    document.getElementById('Tabgeneral').style.background = '#ffffff';
    document.getElementById('Tabimagen').style.background = '#ffffff';
    document.getElementById('TabmetaData').style.background = '#ffffff';
    document.getElementById('TabprecioCosto').style.background = '#ffffff';
    document.getElementById('TabpesoDimencion').style.background = '#ffffff';
    document.getElementById('TabSellers').style.background = '#ffffff';
    document.getElementById('TabExportacion').style.background = '#ffffff';
    document.getElementById('TabEstibar').style.background = '#ffffff';
    document.getElementById('TabSellersOff').style.background = '#ffffff';
    document.getElementById('TabDistribucion').style.background = '#ffffff';
    document.getElementById('TabImagenesWholesale').style.background = '#ffffff';
    document.getElementById('Tabingredientes').style.background = '#ffffff';
    if (document.getElementById('Tabinventario')) {
        document.getElementById('Tabinventario').style.background = '#ffffff';
    }

    document.getElementById('TabDistribucion').style.color = '#999999';
    document.getElementById('TabSellersOff').style.color = '#999999';
    document.getElementById('Tabgeneral').style.color = '#999999';
    document.getElementById('Tabimagen').style.color = '#999999';
    document.getElementById('TabmetaData').style.color = '#999999';
    document.getElementById('TabprecioCosto').style.color = '#999999';
    document.getElementById('TabpesoDimencion').style.color = '#999999';
    document.getElementById('TabSellers').style.color = '#999999';
    document.getElementById('TabExportacion').style.color = '#999999';
    document.getElementById('TabEstibar').style.color = '#999999';
    document.getElementById('TabImagenesWholesale').style.color = '#999999';
    document.getElementById('Tabingredientes').style.color = '#999999';
    if (document.getElementById('Tabinventario')) {
        document.getElementById('Tabinventario').style.color = '#999999';
    }


    li.style.background = '#999999';
    li.style.color = '#ffffff';
}

function abrirImagenGrande(img, w, h) {
    document.getElementById('im0').src = '';
    document.getElementById('im').src = '';

    document.getElementById('im0').src = img.src;
    document.getElementById('im').src = img.src;
    //alert($('#im0').width()+"-"+$('#im0').height());
    if ($('#im0').width() > $('#im0').height()) {
        document.getElementById('im0').style.width = "100%";
        document.getElementById('im0').style.height = "100%";

    } else {
        document.getElementById('im0').style.width = "100%";
        document.getElementById('im0').style.height = "100%";
    }
    // $('#im').rotate(0);
    // $('#im0').rotate(0);
}

function formularioSellers(codempresa, pais, code) {
    $.ajax({
        url: 'sellers/formSellers.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&icode=' + code,
        success: function (resp) {
            $('#cuerpoSellers').html(resp);

        }
    });
}

function formularioSellersOff(codempresa, pais, code) {
    $.ajax({
        url: 'sellersOff/formSellersOff.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&icode=' + code,
        success: function (resp) {
            $('#cuerpoSellers').html(resp);

        }
    });
}

function formularioDistribucion(codempresa, pais, code) {
    $.ajax({
        url: 'distribucion/formDistribucion.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&icode=' + code,
        success: function (resp) {
            $('#cuerpoDistri').html(resp);

        }
    });
}

function nuevoSeller(codseller, codempresa, pais, codprov, codprod) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';

    pag = window.open("../productos/sellers/paginaSellers.php?empresa=" + codempresa + "&pais=" + pais + "&prov=" + codprov + "&sell=" + codseller + "&prod=" + codprod, "Nuevo Seller", params);

    pag.focus();

}

function nuevoSellerOff(codseller, codempresa, pais, codprov, codprod) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';

    pag = window.open("../productos/sellersOff/paginaSellersOff.php?empresa=" + codempresa + "&pais=" + pais + "&prov=" + codprov + "&sell=" + codseller + "&prod=" + codprod, "Nuevo Seller Offline", params);

    pag.focus();

}

function nuevoDistribucion(codseller, codempresa, pais, codprov, codprod) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';

    pag = window.open("../productos/distribucion/paginaDistribucion.php?empresa=" + codempresa + "&pais=" + pais + "&prov=" + codprov + "&dis=" + codseller + "&prod=" + codprod, "Nuevo Seller Offline", params);

    pag.focus();

}

function envioDeDataDistribucion(es) {
    var1 = "";
    var2 = "";
    var3 = "";
    var4 = "";
    var5 = "";
    cadVariables = location.search.substring(1, location.search.length);
    arrVariables = cadVariables.split("&");
    for (i = 0; i < arrVariables.length; i++) {
        arrVariableActual = arrVariables[i].split("=");
        if (isNaN(parseFloat(arrVariableActual[1])))
            eval(arrVariableActual[0] + "='" + unescape(arrVariableActual[1]) + "';");
        else
            eval(arrVariableActual[0] + "=" + arrVariableActual[1] + ";");

        switch (i) {
            case 0: {
                var1 = arrVariableActual[1];
                break;
            }
            case 1: {
                var2 = arrVariableActual[1];
                break;
            }
            case 2: {
                var3 = arrVariableActual[1];
                break;
            }
            case 3: {
                var4 = arrVariableActual[1];
                break;
            }
            case 4: {
                var5 = arrVariableActual[1];
                break;
            }
        }
    }

    if (es == 'seller') {
        Distribucion(1, var1, var2, var3, var4, var5);
    }

}

function envioDeDataSellersOff(es) {
    var1 = "";
    var2 = "";
    var3 = "";
    var4 = "";
    var5 = "";
    cadVariables = location.search.substring(1, location.search.length);
    arrVariables = cadVariables.split("&");
    for (i = 0; i < arrVariables.length; i++) {
        arrVariableActual = arrVariables[i].split("=");
        if (isNaN(parseFloat(arrVariableActual[1])))
            eval(arrVariableActual[0] + "='" + unescape(arrVariableActual[1]) + "';");
        else
            eval(arrVariableActual[0] + "=" + arrVariableActual[1] + ";");

        switch (i) {
            case 0: {
                var1 = arrVariableActual[1];
                break;
            }
            case 1: {
                var2 = arrVariableActual[1];
                break;
            }
            case 2: {
                var3 = arrVariableActual[1];
                break;
            }
            case 3: {
                var4 = arrVariableActual[1];
                break;
            }
            case 4: {
                var5 = arrVariableActual[1];
                break;
            }
        }
    }

    if (es == 'seller') {
        sellersOff(1, var1, var2, var3, var4, var5);
    }

}

function Distribucion(fun, codempresa, pais, codprov, codseller, codprod) {
    $.ajax({
        url: 'buscarDistribucion.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&codpredis=' + codseller + '&codprov=' + codprov + '&codprod=' + codprod,
        success: function (resp) {
            $('#formulario').html(resp);

        }
    });
}

function sellersOff(fun, codempresa, pais, codprov, codseller, codprod) {
    $.ajax({
        url: 'buscarSellersOff.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&codseller=' + codseller + '&codprov=' + codprov + '&codprod=' + codprod,
        success: function (resp) {
            $('#formulario').html(resp);

        }
    });
}

function mayor(i, b) {
    i2 = parseFloat(document.getElementById(i).value);
    b2 = parseFloat(document.getElementById(b).value);
    if (i2 > b2) {
        return true;
    } else {
        document.getElementById(i).value = parseFloat(document.getElementById(b).value) + 1;
    }
}

function guardarDistribucion(codempresa, pais, codprov, codprod, codpredis) {
    de = document.getElementById('de').value.replace("$", "").replace(",", "");
    a = document.getElementById('a').value.replace("$", "").replace(",", "");
    precio = document.getElementById('precio').value.replace("$", "").replace(",", "");
    pDescuento = document.getElementById('pDescuento').value.replace("$", "").replace(",", "");
    unidades = document.getElementById('unidades').value;

    $.ajax({
        url: 'ingresoDistribucion.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&codprov=' + codprov + '&codprod=' + codprod + '&distri=' + codpredis + '&de=' + de + '&a=' + a + '&precio=' + precio + '&pDescuento=' + pDescuento + '&unidades=' + unidades,
        success: function (resp) {
            $('#resultado').html(resp);

        },
        error: function (resp) {
            console.log('R: ' + resp);
        }
    });
}

function guardarSellerOff(codempresa, pais, codprov, codprod, codprecom) {
    seller = document.getElementById('competencia').value;
    canal = document.getElementById('canal').value;
    unidades = document.getElementById('unidades').value;
    precio = document.getElementById('precio').value.replace("$", "").replace(",", "");
    shipping = document.getElementById('shipping1').value.replace("$", "").replace(",", "");
    amname = document.getElementById('amname').value;
    asinNumber = document.getElementById('asin').value;
    amsku = document.getElementById('amsku').value;
    upc = document.getElementById('upc').value;

    aplica = 0;

    $.ajax({
        url: 'ingresoSellersOff.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&codprov=' + codprov + '&codprod=' + codprod + '&seller=' + seller + '&canal=' + canal + '&unidades=' + unidades + '&precio=' + precio + '&shipping=' + shipping + '&amname=' + amname + '&asiNumber=' + asinNumber + '&amsku=' + amsku + '&aplica=' + aplica + '&codprecom=' + codprecom + '&upc=' + upc,
        success: function (resp) {
            $('#resultado').html(resp);

        },
        error: function (resp) {
            console.log('R: ' + resp);
        }
    });
}

function envioDeDataSellers(es) {
    var1 = "";
    var2 = "";
    var3 = "";
    var4 = "";
    var5 = "";
    cadVariables = location.search.substring(1, location.search.length);
    arrVariables = cadVariables.split("&");
    for (i = 0; i < arrVariables.length; i++) {
        arrVariableActual = arrVariables[i].split("=");
        if (isNaN(parseFloat(arrVariableActual[1])))
            eval(arrVariableActual[0] + "='" + unescape(arrVariableActual[1]) + "';");
        else
            eval(arrVariableActual[0] + "=" + arrVariableActual[1] + ";");

        switch (i) {
            case 0: {
                var1 = arrVariableActual[1];
                break;
            }
            case 1: {
                var2 = arrVariableActual[1];
                break;
            }
            case 2: {
                var3 = arrVariableActual[1];
                break;
            }
            case 3: {
                var4 = arrVariableActual[1];
                break;
            }
            case 4: {
                var5 = arrVariableActual[1];
                break;
            }
        }
    }

    if (es == 'seller') {
        sellers(1, var1, var2, var3, var4, var5);
    }

}

function sellers(fun, codempresa, pais, codprov, codseller, codprod) {
    $.ajax({
        url: 'buscarSellers.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&codseller=' + codseller + '&codprov=' + codprov + '&codprod=' + codprod,
        success: function (resp) {
            $('#formulario').html(resp);

        }
    });
}

function guardarSeller(codempresa, pais, codprov, codprod, codprecom) {
    seller = document.getElementById('competencia').value;
    canal = document.getElementById('canal').value;
    unidades = document.getElementById('unidades').value;
    precio = document.getElementById('precio').value.replace("$", "").replace(",", "");
    shipping = document.getElementById('shipping1').value.replace("$", "").replace(",", "");
    amname = document.getElementById('amname').value;
    asinNumber = document.getElementById('asin').value;
    amsku = document.getElementById('amsku').value;
    upc = document.getElementById('upc').value;
    if (document.getElementById('aplica').checked) {

        aplica = 1;
    } else {
        aplica = 0;
    }
    $.ajax({
        url: 'ingresoSellers.php',
        type: 'POST',
        data: 'codempresa=' + codempresa + '&pais=' + pais + '&codprov=' + codprov + '&codprod=' + codprod + '&seller=' + seller + '&canal=' + canal + '&unidades=' + unidades + '&precio=' + precio + '&shipping=' + shipping + '&amname=' + amname + '&asiNumber=' + asinNumber + '&amsku=' + amsku + '&aplica=' + aplica + '&codprecom=' + codprecom + '&upc=' + upc,
        success: function (resp) {
            $('#resultado').html(resp);

        },
        error: function (resp) {
            console.log('R: ' + resp);
        }
    });
}


function agregarValorAge(obc) {
    if (obc.checked) {
        document.getElementById('age').value += obc.value;
    } else {
        document.getElementById('age').value = document.getElementById('age').value.replace(obc.value, '');
    }
}

function agregarValorTransp(obc) {
    if (obc.checked) {
        document.getElementById('Transporte').value += obc.value;
    } else {
        document.getElementById('Transporte').value = document.getElementById('Transporte').value.replace(obc.value, '');
    }
}

function agregarValorFormExport(obc) {
    if (obc.checked) {
        document.getElementById('formasExportacion').value += obc.value;
    } else {
        document.getElementById('formasExportacion').value = document.getElementById('formasExportacion').value.replace(obc.value, '');
    }
}

function agregarValorCanalesComercial(obc) {
    if (obc.checked) {
        document.getElementById('canalesComercializa').value += obc.value;
    } else {
        document.getElementById('canalesComercializa').value = document.getElementById('canalesComercializa').value.replace(obc.value, '');
    }
}


function calcular(dato1, dato2, suma) {
    CajasNivel = dato1.value;
    NivelesPallet = dato2.value;

    suma.value = (CajasNivel * NivelesPallet) * 1;
}

function temperatura(obd, id) {
    if (obd.value == 'RE') {
        document.getElementById(id).disabled = false;
    } else {
        document.getElementById(id).disabled = true;
    }
}


FRO21 = 0;
BACK21 = 0;
CODBAR21 = 0;
NOTFRETCH21 = 0;
INGI21 = 0;
PERFILDER21 = 0;
PERFILIZ21 = 0;
AD121 = 0;
AD221 = 0;
INSIDE21 = 0;

function giro1(id, lado, gir) {
    var im = document.getElementById(gir);
    abrirImagenGrande(im, 1, 1);

    var imageurl = im.src;

    $.ajax({

        url: 'rotateImage.php',
        type: 'POST',
        data: 'direction=' + lado + '&imageurl=' + imageurl,
    });

    if (lado == "iz") {
        switch (gir) {
            case "BACK": {
                if (BACK21 == 0) {
                    BACK21 = 360;
                }

                BACK21 = (BACK21 - 90);
                giro = BACK21;
                break;
            }
            case "FRO": {
                if (FRO21 == 0) {
                    FRO21 = 360;
                }

                FRO21 = (FRO21 - 90);
                giro = FRO21;
                break;
            }
            case "CODBAR": {
                if (CODBAR21 == 0) {
                    CODBAR21 = 360;
                }

                CODBAR21 = (CODBAR21 - 90);
                giro = CODBAR21;
                break;
            }
            case "NOTFRETCH": {
                if (NOTFRETCH21 == 0) {
                    NOTFRETCH21 = 360;
                }

                NOTFRETCH21 = (NOTFRETCH21 - 90);
                giro = NOTFRETCH21;
                break;
            }
            case "INGI": {
                if (INGI21 == 0) {
                    INGI21 = 360;
                }

                INGI21 = (INGI21 - 90);
                giro = INGI21;
                break;
            }
            case "PERFILDER": {
                if (PERFILDER21 == 0) {
                    PERFILDER21 = 360;
                }

                PERFILDER21 = (PERFILDER21 - 90);
                giro = PERFILDER21;
                break;
            }
            case "PERFILIZ": {
                if (PERFILIZ21 == 0) {
                    PERFILIZ21 = 360;
                }

                PERFILIZ21 = (PERFILIZ21 - 90);
                giro = PERFILIZ21;
                break;
            }
            case "AD1": {
                if (AD121 == 0) {
                    AD121 = 360;
                }

                AD121 = (AD121 - 90);
                giro = AD121;
                break;
            }
            case "AD2": {
                if (AD221 == 0) {
                    AD221 = 360;
                }

                AD221 = (AD221 - 90);
                giro = AD221;
                break;
            }
            case "INSIDE": {
                if (INSIDE21 == 0) {
                    INSIDE21 = 360;
                }

                INSIDE21 = (INSIDE21 - 90);
                giro = INSIDE21;
                break;
            }
        }
    }

    if (lado == "der") {
        switch (gir) {
            case "BACK": {
                if (BACK21 == 360) {
                    BACK21 = 0;
                }

                BACK21 = (BACK21 + 90);
                giro = BACK21;
                break;
            }
            case "FRO": {
                if (FRO21 == 360) {
                    FRO21 = 0;
                }

                FRO21 = (FRO21 + 90);
                giro = FRO21;
                break;
            }
            case "CODBAR": {
                if (CODBAR21 == 360) {
                    CODBAR21 = 0;
                }

                CODBAR21 = (CODBAR21 + 90);
                giro = CODBAR21;
                break;
            }
            case "NOTFRETCH": {
                if (NOTFRETCH21 == 360) {
                    NOTFRETCH21 = 0;
                }

                NOTFRETCH21 = (NOTFRETCH21 + 90);
                giro = NOTFRETCH21;
                break;
            }
            case "INGI": {
                if (INGI21 == 360) {
                    INGI21 = 0;
                }

                INGI21 = (INGI21 + 90);
                giro = INGI21;
                break;
            }
            case "PERFILDER": {
                if (PERFILDER21 == 360) {
                    PERFILDER21 = 0;
                }

                PERFILDER21 = (PERFILDER21 + 90);
                giro = PERFILDER21;
                break;
            }
            case "PERFILIZ": {
                if (PERFILIZ21 == 360) {
                    PERFILIZ21 = 0;
                }

                PERFILIZ21 = (PERFILIZ21 + 90);
                giro = PERFILIZ21;
                break;
            }
            case "AD1": {
                if (AD121 == 360) {
                    AD121 = 0;
                }

                AD121 = (AD121 + 90);
                giro = AD121;
                break;
            }
            case "AD2": {
                if (AD221 == 360) {
                    AD221 = 0;
                }

                AD221 = (AD221 + 90);
                giro = AD221;
                break;
            }
            case "INSIDE": {
                if (INSIDE21 == 360) {
                    INSIDE21 = 0;
                }

                INSIDE21 = (INSIDE21 + 90);
                giro = INSIDE21;
                break;
            }
        }
    }
    // $('#'+id).rotate(giro);
    // $('#im').rotate(giro);
    // $('#im0').rotate(giro);

    var turl = document.getElementById(gir).src;
    document.getElementById(gir).src = "";
    document.getElementById('im').src = "";
    document.getElementById('im0').src = "";
    document.getElementById(gir).src = turl + '?' + Math.random();
    document.getElementById('im').src = turl + '?' + Math.random();
    document.getElementById('im0').src = turl + '?' + Math.random();


}

function verificaImportantes(obc, id) {
    guardaro = 0;
    var tex1 = "1";
    var tex2 = "1";
    var tex3 = "1";
    var tex4 = "1";
    var tex5 = "1";
    var tex6 = "1";
    var tex7 = "1";
    var tex8 = "1";
    var tex9 = "1";
    var tex10 = "1";
    var tex11 = "1";
    var tex12 = "1";
    var tex13 = "1";
    var tex14 = "1";
    var tex15 = "1";
    var tex15 = "1";


    switch (obc) {

        case "General": {
            var tex1 = document.getElementById('marca').value;
            var tex2 = document.getElementById('category').value;
            var tex3 = document.getElementById('manufacturadores').value;
            var tex4 = document.getElementById('pakage').value;
            var tex5 = document.getElementById('itemCode').value;


            var tex6 = document.getElementById('descSistema').value;
            var tex7 = document.getElementById('EName').value;
            var tex8 = document.getElementById('SName').value;
            var tex9 = document.getElementById('paisOrigen').value;

            break;
        }
        case "MetaData": {
            tex1 = document.getElementById('keyWords').value;
            tex2 = document.getElementById('prodDescH').value;
            /*if(document.getElementById('prodDesc'))
            {
                tex2 = document.getElementById('prodDesc').value;
            }
            else*/
            {
                //tex2 = CKEDITOR.instances.prodDesc.getData();
            }

            break;
        }

        case "Estibar": {

            var tex1 = document.getElementById('CajasNivel').value;
            var tex2 = document.getElementById('CajasPorContenedor').value;
            //  var tex3 = document.getElementById('FormaDeEstibarCA').value;
            var tex4 = document.getElementById('NivelesPallet').value;
            var tex5 = document.getElementById('PaletsPorContenedor').value;
            break;
        }


        case "Peso": {


            // var tex1=document.getElementById('libras').value;
            // var tex2=document.getElementById('onzas').value;
            var tex3 = document.getElementById('alto').value;
            var tex4 = document.getElementById('ancho').value;
            var tex5 = document.getElementById('largo').value;


            var tex6 = document.getElementById('librasCaja').value;
            var tex7 = document.getElementById('onzasCaja').value;
            //var tex8=document.getElementById('altoCaja').value;
            //var tex9=document.getElementById('anchoCaja').value;
            //var tex10=document.getElementById('largoCaja').value;

            var tex11 = document.getElementById('librasPallet').value;
            var tex12 = document.getElementById('onzasPallet').value;
            //var tex13=document.getElementById('altoPallet').value;
            //var tex14=document.getElementById('anchoPallet').value;
            //var tex15=document.getElementById('largoPallet').value;
            var tex16 = document.getElementById('uniVenta').value;


            break;

        }

        case "Exportar": {

            var tex1 = document.getElementById('descPreProd').value;
            var tex2 = document.getElementById('capProdMen').value;
            var tex3 = document.getElementById('partidaArancelaria').value;
            var tex4 = document.getElementById('TipContenedor').value;
            var tex5 = document.getElementById('formasExportacion').value;
            var tex6 = document.getElementById('canalesComercializa').value;
            var tex7 = document.getElementById('Transporte').value;
            break;
        }

        case "Precio": {

            var tex1 = document.getElementById('ubundle').value;
            var tex2 = document.getElementById('uniVenta').value;
            var tex3 = document.getElementById('precioBundle').value;


            break;
        }
        case "Distribucion": {

            var tex1 = document.getElementById('de').value;
            var tex2 = document.getElementById('a').value;
            var tex3 = document.getElementById('precio').value;


            break;
        }

        case "competencia":

            var tex1 = document.getElementById('fecha').value;
            var tex2 = document.getElementById('competencia').value;
            var tex3 = document.getElementById('canal').value;
            var tex4 = document.getElementById('unidades').value;
            var tex5 = document.getElementById('precio').value;
            //var tex6 = document.getElementById('shipping').value;

            break;

        case "newPeso":
            var tex1 = document.getElementById('pesoTotLB').value;
            var tex2 = document.getElementById('pesoTotLBCaja').value;
            //var tex3=document.getElementById('librasPallet').value;
            break;


    }

    if (tex1 != "" && tex2 != "" && tex3 != "" && tex4 != "" && tex5 != "" && tex6 != "" && tex7 != "" && tex8 != "" && tex9 != "" && tex10 != "" && tex11 != "" && tex12 != "" && tex13 != "" && tex14 != "" && tex15 != "" && tex16 != "") {
        // if(tex1!=0 && tex2!=0 && tex3!=0 && tex4!=0 && tex5!=0 && tex6!=0 && tex7!=0 && tex8!=0 && tex9!=0 && tex10!=0 && tex11!=0 && tex12!=0 && tex13!=0 && tex14!=0 && tex15!=0 && tex16!=0)

        document.getElementById(id).disabled = false;
        document.getElementById('advertencia').hidden = true;


        if (tex1 != 0 && tex2 != 0 && tex3 != 0 && tex4 != 0 && tex5 != 0 && tex6 != 0 && tex7 != 0 && tex8 != 0 && tex9 != 0 && tex10 != 0 && tex11 != 0 && tex13 != 0 && tex14 != 0 && tex16 != 0) {
            document.getElementById(id).disabled = false;
            if($("#advertenciacero").length > 0){
                document.getElementById('advertenciacero').hidden = true;
            }
            guardaro = 0;
        } else {
            document.getElementById(id).disabled = true;
            document.getElementById('advertenciacero').hidden = false;

            guardaro = 1;
        }

    } else {
        document.getElementById(id).disabled = true;
        document.getElementById('advertencia').hidden = false;

        guardaro = 1;
    }
}

function afectarImagen(tipo, ima, grados, src) {

    // $('#im').rotate(0);
    // $('#im0').rotate(0);
    $.ajax({
        url: 'borrarImagen.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&ima=' + ima + '&grados=' + grados + '&src=' + src,
        success: function (resp) {
            $('#resultado').html(resp);
        },
        async: false,
        cache: false

    });

}


function parametroEspe(id, obj) {
    if (document.getElementById(id)) {
        if (obj.type == "select-one") {
            document.getElementById(id).innerHTML = obj.options[obj.selectedIndex].text;
        } else {
            document.getElementById(id).innerHTML = obj.value;
        }
    }

}

function verificaEspeciales() {
    if (document.getElementById('marcaEsp')) {
        if (document.getElementById('marcaEsp').innerHTML != "") {
            funciona = 1;
        } else {
            funciona = 0;
        }
    } else {
        funciona = 1;
    }
}

function guardarEspecificosProductos(codprod) {
    var consulta = "";
    if (document.getElementById('marcaEsp')) {
        if (document.getElementById('marcaEsp').innerHTML != "") {
            consulta += "('$codigo','" + document.getElementById('marcaEsp1').innerHTML + "','" + codprod + "','" + limpiarCaracteresEspeciales(document.getElementById('marcaEsp').innerHTML) + "'),";
        } else {

        }
    } else {

    }
    if (document.getElementById('ciudadEsp')) {
        if (document.getElementById('ciudadEsp').innerHTML != "") {
            consulta += "('$codigo1','" + document.getElementById('ciudadEsp1').innerHTML + "','" + codprod + "','" + document.getElementById('ciudadEsp').innerHTML + "'),";
        } else {

        }
    } else {

    }

    $.ajax({
        url: 'guardarAtributosEspecificos.php',
        type: 'POST',
        data: 'consulta=' + consulta,
        success: function (resp) {
            $('#resultado').html(resp);
        }
    });


}

function guardarImagen() {

    if (FRO21 > 0 && FRO21 < 360) {
        afectarImagen('rotar', 'FRO', FRO21, document.getElementById('FRO').src);
    }
    if (BACK21 > 0 && BACK21 < 360) {
        afectarImagen('rotar', 'BACK', BACK21, document.getElementById('BACK').src);
    }
    if (CODBAR21 > 0 && CODBAR21 < 360) {
        afectarImagen('rotar', 'CODBAR', CODBAR21, document.getElementById('CODBAR').src);
    }
    if (NOTFRETCH21 > 0 && NOTFRETCH21 < 360) {
        afectarImagen('rotar', 'NOTFRETCH', NOTFRETCH21, document.getElementById('NOTFRETCH').src);
    }
    if (INGI21 > 0 && INGI21 < 360) {
        afectarImagen('rotar', 'INGI', INGI21, document.getElementById('INGI').src);
    }
    if (PERFILDER21 > 0 && PERFILDER21 < 360) {
        afectarImagen('rotar', 'PERFILDER', PERFILDER21, document.getElementById('PERFILDER').src);
    }
    if (PERFILIZ21 > 0 && PERFILIZ21 < 360) {
        afectarImagen('rotar', 'PERFILIZ', PERFILIZ21, document.getElementById('PERFILIZ').src);
    }
    if (AD121 > 0 && AD121 < 360) {
        afectarImagen('rotar', 'AD1', AD121, document.getElementById('AD1').src);
    }
    if (AD221 > 0 && AD221 < 360) {
        afectarImagen('rotar', 'AD2', AD221, document.getElementById('AD2').src);
    }
    if (INSIDE21 > 0 && INSIDE21 < 360) {
        afectarImagen('rotar', 'INSIDE', INSIDE21, document.getElementById('INSIDE').src);
    }
    setTimeout(function () {
        location.reload();
    }, 500);

}

function MarcasLlenar(codempresa, pais, esmas, tipo, selectedBrand) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas + '&selectedBrand=' + selectedBrand,
        success: function (resp) {
            console.log(resp);
            $('#marca').html(resp);
        },
        error: function (resp) {
            console.log("E:" + resp);
        }
    });

}

function ManufactLlenar(codempresa, pais, esmas, tipo) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas,
        success: function (resp) {
            $('#manufacturadores').html(resp);

        }

    });

}

function prodLinLlenar(codempresa, pais, esmas, tipo) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas,
        success: function (resp) {
            $('#prodLin').html(resp);

        }

    });

}

function CocinaLlenar(codempresa, pais, esmas, tipo) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas,
        success: function (resp) {
            $('#cocina').html(resp);

        }

    });

}

function formulaLlenar(codempresa, pais, esmas, tipo) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas,
        success: function (resp) {
            $('#formula').html(resp);

        }

    });

}

function saborLlenar(codempresa, pais, esmas, tipo) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas,
        success: function (resp) {
            $('#flavor').html(resp);

        }

    });

}

function sellerLlenar(codempresa, pais, esmas, tipo) {

    $.ajax({
        url: '../combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas,
        success: function (resp) {
            $('#competencia').html(resp);

        }

    });

}

function sizeLlenar(codempresa, pais, esmas, tipo, pres) {

    $.ajax({
        url: 'combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&codempresa=' + codempresa + '&pais=' + pais + '&esmas=' + esmas + '&pres=' + pres,
        success: function (resp) {

            $('#size').html(resp);
            /*
            setTimeout(function () {
                agregarUnidad();
            }, 250);
            */
        },
        error: function (resp) {
            console.log('E:' + JSON.stringify(resp));
        }
    });

}

function CompruebaCheck(id, chk) {
    var str = document.getElementById(id).value;
    var rsr = chk.value;
    if (str.match(rsr)) {
        chk.checked = true;
    } else {
        chk.checked = false;
    }
}

function agregarUnidad() {

    combo = document.getElementById("size");
    peso = combo.options[combo.selectedIndex].getAttribute('peso');
    lb = parseInt(peso);
    oz = (peso - lb) * 16;

    __("libras").value = lb;
    __("onzas").value = oz;
    __("uniVenta").value = combo.options[combo.selectedIndex].getAttribute('unidades');

    setTimeout(function () {
        agregarPesoTotal('libras', 'onzas', 'pesoTotLB');
        CalculaCaja();
    }, 500);
}

function imagenesSeller(codseller, vtn) {

    ventana(vtn, 500, 700);
    $.ajax({
        url: 'Archivos.php',
        type: 'POST',
        data: 'codigo=' + codseller,
        success: function (resp) {

            $('#' + vtn).html(resp);
            /*
            setTimeout(function () {
                agregarUnidad();
            }, 250);
            */
        },
        error: function (resp) {
            console.log('E:' + JSON.stringify(resp));
        }
    });

}

function CalculaCaja() {
    var libras, onzas, uniVenta, librasCaja, onzasCaja, uniVenta2, librasPallet;


    //$("#libras, #onzas, #uniVenta, #librasCaja, #onzasCaja, #uniVenta2, #librasPallet ").change(function(){

    var libras = parseInt($("#libras").val());
    var onzas = parseInt($("#onzas").val() * 1);
    var uniVenta = parseInt($("#uniVenta").val());
    var librasCaja = parseInt($("#librasCaja").val());
    var onzasCaja = parseInt($("#onzasCaja").val() * 1);
    var uniVenta2 = parseInt($("#uniVenta2").val());
    var librasPallet = parseInt($("#librasPallet").val());


    //libras2 =Math.ceil(libras);
    //onzas2 =Math.ceil(onzas);
    //uniVentad =Math.ceil(uniVenta);

    //totalcaja=(libras2*16)+onzas2)

    dimCajal = Math.floor(((((libras * 16) + onzas) / 16) * uniVenta));

    dimCajao = parseInt((((((libras * 16) + onzas) / 16) * uniVenta) - dimCajal) * 16);

    dimcajap = Math.floor(((((dimCajal * 16) + dimCajao) / 16) * uniVenta2) + 25);


    $("#librasCaja").val(dimCajal);
    $("#onzasCaja").val(dimCajao);
    $("#librasPallet").val(dimcajap);

    agregarPesoTotal('librasCaja', 'onzasCaja', 'pesoTotLBCaja');


    // totalLibrascaja = parseInt((((libras2*16)+onzas2)/16)*uniVenta2)
    // totalOnzascaja  = parseInt((((((libras2*16)+onzas2)/16)*uniVenta2) - totalLibrasCaja) * 16)
    // totalLibrasPallet = (parseInt((((totalLibrasCaja*16)+totalOnzasCaja))/16)*uniVenta22)+25


    // });
    /*
     libras2=__("libras").value;
     onzas2=__("onzas").value;
     pesoTotLB2=__("pesoTotLB").value;
     librasCaja2=__("librasCaja").value;
     onzasCaja2=__("onzasCaja").value;
     pesoTotLBCaja2=__("pesoTotLBCaja").value;
     uniVenta2=__("uniVenta").value;
     librasPallet2=__("librasPallet").value;
     onzasPallet2=__("onzasPallet").value;
     pesoTotLBPallet2=__("pesoTotLBPallet").value;
     uniVenta22=__("uniVenta2").value;
     var totalonzascaja;

     totalLibrascaja = parseInt((((libras2*16)+onzas2)/16)*uniVenta2);
     totalOnzascaja  = parseInt((((((libras2*16)+onzas2)/16)*uniVenta2) - totalLibrasCaja) * 16);
     totalLibrasPallet = parseInt((((((totalLibrasCaja*16)+totalOnzasCaja))/16)*uniVenta22)+25);
     /*
     totalonzascaja =(onzas2*uniVenta2/16);
     totalLibrascaja=((libras2*uniVenta2)*1)+((totalonzascaja.toFixed())*1);
     totalonzascaja=totalonzascaja-totalonzascaja.toFixed();
     totalonzascaja=totalonzascaja*16;

     totalLibrasC =totalLibrascaja;
     totalOnzasC = totalonzascaja;
     librasCaja2=totalLibrasC;
     onzasCaja2=totalonzascaja;

     __('librasCaja').value=(totalLibrascaja);
     __('onzasCaja').value=(totalOnzascaja);

     agregarPesoTotal('librasCaja','onzasCaja','pesoTotLBCaja');

     totalonzasPallet =(onzasCaja2*uniVenta2/16);
     totalLibrasPallet=((librasCaja2*uniVenta22)*1)+((totalonzasPallet.toFixed())*1);
     totalonzasPallet=totalonzasPallet-totalonzasPallet.toFixed();
     totalonzasPallet=totalonzasPallet*16;

     totalLibrasP =totalLibrasPallet;
     totalOnzasP = totalonzasPallet;
     __('pesoTotLBPallet').value=totalLibrasPallet;
     __('librasPallet').value=totalLibrasPallet;
     __('onzasPallet').value=otalonzasPallet;

     agregarPesoTotal('librasPallet','onzasPallet','pesoTotLBPallet');*/

}