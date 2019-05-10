/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
var bandera = true;
var pag;

function formulario(formul) {
    switch (formul) {
        case '1': {
            $.ajax({
                url: '../Inicio/formularios/formProductos.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '2': {
            $.ajax({
                url: '../Inicio/formularios/formMarca.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '3': {
            $.ajax({
                url: '../Inicio/formularios/formCategoria.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '4': {
            //setTimeout("location.href='../php/Reportes/ReportesBundles.php'", 100);
            $.ajax({
                url: '../php/Reportes/precios/formPrecios.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '5': {
            $.ajax({
                url: '../php/bancos/formBancos.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '6': {
            $.ajax({
                url: '../php/bancos/llenarMovimientosCuentas.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '7': {
            $.ajax({
                url: '../php/bancos/Conciliaciones.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '8': {
            $.ajax({
                url: '../php/soporte/formContacto.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '9': {
            $.ajax({
                url: '../php/proveedores/CargaDeProv.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').append(resp);
                }
            });
            break;
        }
        //despacho
        case '10': {
            $.ajax({
                url: '../Inicio/formularios/formDespachos.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '11': {
            $.ajax({
                url: '../php/productos/comercializacion/formComercializacion.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '12': {
            ventana('usuarioprov', 500, 700);
            esmas = "";
            $.ajax({
                url: '../php/proveedores/pestanas/crearUsuario.php',
                type: 'POST',
                data: 'codigo=' + esmas,
                success: function (resp) {
                    $('#usuarioprov').html(resp);
                }
            });
            break;
        }
        case '13': {
            //setTimeout("location.href='../php/Reportes/ReportesBundles.php'", 100);
            $.ajax({
                url: '../php/Reportes/precios/formPrecios3.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '14': {
            //setTimeout("location.href='../php/Reportes/ReportesBundles.php'", 100);
            $.ajax({
                url: '../php/Reportes/precios/formPrecios4.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '15': {
            esmas = formul;
            $.ajax({
                url: '../php/ordenes/formOrdenes.php',
                type: 'POST',
                data: 'codigo=' + esmas,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '16': {
            esmas = formul;
            $.ajax({
                url: '../php/graficos/mostrarGraficos.php',
                type: 'POST',
                data: 'codigo=' + esmas,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '17': {
            //setTimeout("location.href='../php/Reportes/ReportesBundles.php'", 100);
            $.ajax({
                url: '../php/Reportes/ventas/formVentas.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "18":
            $.ajax({
                url: "../php/comercializacion/cotizadorEmbarque.php",
                type: "POST",
                success: function (resp) {
                    $("#formulario").html(resp);
                }
            });
            break;
        case "19":
            $.ajax({
                url: "../php/wholesales/wholesales.php",
                type: "POST",
                success: function (resp) {
                    $("#formulario").html(resp);
                }
            });
            break;
        case '21': {
            //setTimeout("location.href='../php/Reportes/ReportesBundles.php'", 100);
            $.ajax({
                url: '../php/Reportes/Aventas/formVentas.php',
                type: 'POST',
                data: 'user=' + formul,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '22': {
            $.ajax({
                url: '../mercadeo/topProducts/app.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                    // window.open('../mercadeo/topProducts/app.php');
                }
            });
            break;
        }
        case '24': {
            $.ajax({
                url: '../php/comercializacion/cotizadorShipping.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '25': {
            $.ajax({
                url: '../php/ordenes/cancelledOrders.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '26': {
            $.ajax({
                url: '../php/ordenes/pagoOrdenes.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '27': {
            $.ajax({
                url: '../php/ordenes/updateTracking.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '28': {
            $.ajax({
                url: '../php/productos/analisisProductos.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case '29': {
            $.ajax({
                url: '../php/Reportes/inventario.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
    }
}

function producto(parte, codigo, pais, icode, prov) {
    if (guardaro == 0) {
        confirmar = confirm("Los cambios que no haya guardado se perderan ¿deseas continuar?");
    } else {
        confirmar = true;
    }
    if (confirmar) {
        console.log(parte);
        switch (parte) {
            case 1: {
                $.ajax({
                    url: 'productosGeneral.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 2: {
                $.ajax({
                    url: 'productosMetaData.php',
                    // url: 'simpleDescriptions.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 3: {
                $.ajax({
                    url: 'productosPesoDimencion.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 4: {
                $.ajax({
                    url: 'productosPrecioCosto.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode) + '&codprov=' + limpiarCaracteresEspeciales(prov),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 5: {
                $.ajax({
                    url: '../../php/productos/productosImagenes.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 7: {
                $.ajax({
                    url: 'productosSellers.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 8: {
                $.ajax({
                    url: 'productosExportacion.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 9: {
                $.ajax({
                    url: 'productosEstibar.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 10: {
                $.ajax({
                    url: 'comercializacion/formComercializacion.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 11: {
                $.ajax({
                    url: 'productosSellersOff.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 12: {
                $.ajax({
                    url: 'productosDistribucion.php',
                    type: 'POST',
                    data: 'codEmpresa=' + limpiarCaracteresEspeciales(codigo) + '&pais=' + pais + '&icode=' + limpiarCaracteresEspeciales(icode),
                    success: function (resp) {
                        $('#formulario').html(resp);
                    }
                });
                break;
            }
            case 13:
                $.ajax({
                    url: "wholesaleImages.php",
                    type: "POST",
                    data: {
                        codEmpresa: limpiarCaracteresEspeciales(codigo),
                        pais: pais,
                        icode: limpiarCaracteresEspeciales(icode),
                    },
                    success: function (response) {
                        console.log("s:" + response);
                        $("#formulario").html(response);
                    },
                    error: function (response) {
                        console.log("E:" + response);
                    }
                });
                break;
            case 14:
                $.ajax({
                    url: "productosIngredientes.php",
                    type: "POST",
                    data: {
                        codEmpresa: limpiarCaracteresEspeciales(codigo),
                        pais: pais,
                        icode: limpiarCaracteresEspeciales(icode),
                    },
                    success: function (response) {
                        // console.log("s:" +response);
                        $("#formulario").html(response);
                    },
                    error: function (response) {
                        console.log("E:" + response);
                    }
                });
                break;
            case 15:
                $.ajax({
                    url: "productosBodegaje.php",
                    type: "POST",
                    data: {
                        codEmpresa: limpiarCaracteresEspeciales(codigo),
                        pais: pais,
                        icode: limpiarCaracteresEspeciales(icode),
                    },
                    success: function (response) {
                        // console.log("s:" +response);
                        $("#formulario").html(response);
                    },
                    error: function (response) {
                        console.log("E:" + JSON.stringify(response));
                    }
                });
                break;
        }
        guardaro = 1;
    } else {
        setTimeout(function () {
            $("#cargaLoad").dialog("close");
        }, 500);
        guardaro = 0;
    }
}

function resetFormProductos() {
    document.getElementById('productos').reset();
}

function nuevoProducto(codigo, pais, icode, copy) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    if (typeof copy === 'undefined') {
        copy = '0';
    }
    var tData = 'copyProduct=' + copy + '&origSKU=' + icode;
    $.ajax({
        url: '../php/productos/copyProduct.php',
        type: 'POST',
        data: tData,
        success: function (resp) {
        }
    });
    pag = window.open("../php/productos/paginaNuevoProducto.php?empresa=" + limpiarCaracteresEspeciales(codigo) + "&ctr=" + limpiarCaracteresEspeciales(pais) + "&mt=" + limpiarCaracteresEspeciales(icode), "NuevoProducto", params);
    pag.focus();
}

function envioDeDataProductos(es) {
    var1 = "";
    var2 = "";
    var3 = "";
    cadVariables = location.search.substring(1, location.search.length);
    arrVariables = cadVariables.split("&");
    for (i = 0; i < arrVariables.length; i++) {
        arrVariableActual = arrVariables[i].split("=");
        if (isNaN(parseFloat(arrVariableActual[1])))
            eval(arrVariableActual[0] + "='" + unescape(arrVariableActual[1]) + "';");
        else
            eval(arrVariableActual[0] + "=" + arrVariableActual[1] + ";");
        if (i == 0) {
            var1 = arrVariableActual[1];
        } else {
            if (i == 1) {
                var2 = arrVariableActual[1];
            } else {
                var3 = arrVariableActual[1];
            }
        }
    }
    if (es == 'productos') {
        producto(1, var1, var2, var3);
    }
}

function asignarExtras(formul, empresa, pais) {
    params = 'width=900';
    params += ', height=600';
    params += ', top=100, left=1500'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    console.log("OPEN1")
    pag = window.open("../productos/paginaExtras.php?formul=" + formul + "&empresa=" + limpiarCaracteresEspeciales(empresa) + "&ctr=" + limpiarCaracteresEspeciales(pais), "Formulario Extra", params);
    pag.focus();
}

function actualizaExtras(formul, empresa, pais, codigo) {
    params = 'width=900';
    params += ', height=600';
    params += ', top=100, left=1500'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    pag = window.open("../productos/paginaExtras.php?formul=" + formul + "&empresa=" + limpiarCaracteresEspeciales(empresa) + "&ctr=" + limpiarCaracteresEspeciales(pais) + "&act=" + codigo, "Formulario Extra", params);
    pag.focus();
}

function asignarBundle(formul, empresa, pais, sku, prodname, bundle, cantTot) {
    params = 'width=900';
    params += ', height=600';
    params += ', top=100, left=1500'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    pag = window.open("../productos/paginaExtras.php?formul=" + formul + "&empresa=" + empresa + "&ctr=" + pais + "&sku=" + limpiarCaracteresEspeciales(sku) + "&namepr=" + limpiarCaracteresEspeciales(prodname) + "&bundle=" + limpiarCaracteresEspeciales(bundle) + "&tota=" + limpiarCaracteresEspeciales(cantTot), "Formulario Bundle", params);
    pag.focus();
}

function asignarSellers(formul, empresa, pais) {
    params = 'width=900';
    params += ', height=600';
    params += ', top=100, left=1500'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    pag = window.open("../../productos/paginaExtras.php?formul=" + formul + "&empresa=" + limpiarCaracteresEspeciales(empresa) + "&ctr=" + limpiarCaracteresEspeciales(pais), "Formulario Extra", params);
    pag.focus();
}

function actualizarExtras() {
    setTimeout(function () {
        document.getElementById('resultado').innerHTML = '<img src="../../images/loader.gif" alt="" />';
    }, 500);
    itemCode = window.opener.document.getElementById('itemCode').value;
    masterSKU = window.opener.document.getElementById('masterSKU').value;
    descSis = window.opener.document.getElementById('descSistema').value;
    prodName = window.opener.document.getElementById('prodName').value;
    SName = window.opener.document.getElementById('SName').value;
    EName = window.opener.document.getElementById('EName').value;
    prodLin = window.opener.document.getElementById('prodLin').value;
    category = window.opener.document.getElementById('category').value;
    subCategory1 = window.opener.document.getElementById('subCategory1').value;
    subCategory2 = window.opener.document.getElementById('subCategory2').value;
    marca = window.opener.document.getElementById('marca').value;
    genero = window.opener.document.getElementById('genero').value;
    package = window.opener.document.getElementById('pakage').value;
    UPC = window.opener.document.getElementById('UPC').value;
    paisOrigen = window.opener.document.getElementById('paisOrigen').value;
    cocina = window.opener.document.getElementById('cocina').value;
    flavor = window.opener.document.getElementById('flavor').value;
    concerns = window.opener.document.getElementById('concerns').value;
    manufactur = window.opener.document.getElementById('manufacturadores').value;
    formula = window.opener.document.getElementById('formula').value;
    window.opener.document.location.reload();
    setTimeout(function () {
        window.opener.document.getElementById('itemCode').value = itemCode;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('masterSKU').value = masterSKU;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('descSistema').value = descSis;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('prodName').value = prodName;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('SName').value = SName;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('EName').value = EName;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('prodLin').value = prodLin;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('category').value = category;
    }, 4000);
    setTimeout(function () {
        window.opener.suLlamada1();
    }, 4500);
    setTimeout(function () {
        window.opener.document.getElementById('subCategory1').value = subCategory1;
    }, 5000);
    setTimeout(function () {
        window.opener.suLlamada2();
    }, 5200);
    setTimeout(function () {
        window.opener.document.getElementById('subCategory2').value = subCategory2;
    }, 5500);
    setTimeout(function () {
        window.opener.document.getElementById('marca').value = marca;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('pakage').value = package;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('UPC').value = UPC;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('paisOrigen').value = paisOrigen;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('cocina').value = cocina;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('flavor').value = flavor;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('manufacturadores').value = manufactur;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('concerns').value = concerns;
    }, 5000);
    setTimeout(function () {
        window.opener.document.getElementById('formula').value = formula;
    }, 5000);
    setTimeout(cerrar, 6000);
}

function exitcheck() {
///control de cerrar la ventana///
    if (bandera == true) {
        return "si decide continuar,abandonará la página pudiendo perder los cambios si no ha grabado!!";
    }
}

function cerrar() {
    bandera = false;
    window.close();
}

function actualizarExtrasPesoDimencion(empresa, pais) {
    itemCode = window.opener.document.getElementById('itemCode').value;
    masterSKU = window.opener.document.getElementById('masterSKU').value;
    prodName = window.opener.document.getElementById('prodName').value;
    presentacion = window.opener.document.getElementById('size').value;
    libras = window.opener.document.getElementById('libras').value;
    onzas = window.opener.document.getElementById('onzas').value;
    pesoTotLB = window.opener.document.getElementById('pesoTotLB').value;
    alto = window.opener.document.getElementById('alto').value;
    ancho = window.opener.document.getElementById('ancho').value;
    largo = window.opener.document.getElementById('largo').value;
    window.opener.document.location.reload();
    setTimeout(function () {
        window.opener.producto(3, empresa, pais, masterSKU);
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('itemCode').value = itemCode;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('masterSKU').value = masterSKU;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('prodName').value = prodName;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('size').value = presentacion;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('libras').value = libras;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('onzas').value = onzas;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('pesoTotLB').value = pesoTotLB;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('alto').value = alto;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('ancho').value = ancho;
    }, 4000);
    setTimeout(function () {
        window.opener.document.getElementById('largo').value = largo;
    }, 4000);
    setTimeout(cerrar, 6000);
}

function actualizarExtrasExportacion(empresa, pais) {
    setTimeout(function () {
        document.getElementById('resultado').innerHTML = '<img src="../../images/loader.gif" alt="" />';
    }, 500);
    itemCode = window.opener.document.getElementById('itemCode').value;
    masterSKU = window.opener.document.getElementById('masterSKU').value;
    prodName = window.opener.document.getElementById('prodName').value;
    process = window.opener.document.getElementById('descPreProd').value;
    capProdMen = window.opener.document.getElementById('capProdMen').value;
    TipContenedor = window.opener.document.getElementById('TipContenedor').value;
    Temperatura = window.opener.document.getElementById('Temperatura').value;
    partidaArancelaria = window.opener.document.getElementById('partidaArancelaria').value;
    canalesComercializa = window.opener.document.getElementById('canalesComercializa').value;
    window.opener.document.location.reload();
    setTimeout(function () {
        window.opener.producto(8, empresa, pais, masterSKU);
    }, 2300);
    setTimeout(function () {
        window.opener.document.getElementById('itemCode').value = itemCode;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('masterSKU').value = masterSKU;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('prodName').value = prodName;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('descPreProd').value = process;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('capProdMen').value = capProdMen;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('TipContenedor').value = TipContenedor;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('Temperatura').value = Temperatura;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('partidaArancelaria').value = partidaArancelaria;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('canalesComercializa').value = canalesComercializa;
    }, 3000);
    setTimeout(cerrar, 4000);
}

function actualizarExtrasBundle(empresa, pais) {
    masterSKU = window.opener.document.getElementById('masterSKU').value;
    itemCode = window.opener.document.getElementById('itemCode').value;
    prodName = window.opener.document.getElementById('prodName').value;
    uniVenta = window.opener.document.getElementById('uniVenta').value;
    ubundle = window.opener.document.getElementById('ubundle').value;
    paquetes = window.opener.document.getElementById('paquetes').value;
    window.opener.document.location.reload();
    setTimeout(function () {
        window.opener.producto(5, empresa, pais, itemCode);
    }, 3000);
    setTimeout(function () {
        window.opener.llamarBundle(masterSKU, itemCode, prodName, uniVenta, ubundle, paquetes);
    }, 4000);
}

function actualizarExtrasSeller() {
    fecha = window.opener.document.getElementById('fecha').value;
    competencia = window.opener.document.getElementById('competencia').value;
    canal = window.opener.document.getElementById('canal').value;
    unidades = window.opener.document.getElementById('unidades').value;
    precio = window.opener.document.getElementById('precio').value;
    shipping = window.opener.document.getElementById('shipping').value;
    amname = window.opener.document.getElementById('amname').value;
    asinum = window.opener.document.getElementById('asin').value;
    amsku = window.opener.document.getElementById('amsku').value;
    window.opener.document.location.reload();
    setTimeout(function () {
        window.opener.document.getElementById('fecha').value = fecha;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('competencia').value = competencia;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('canal').value = canal;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('unidades').value = unidades;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('precio').value = precio;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('shipping').value = shipping;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('amname').value = amname;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('asin').value = asinum;
    }, 3000);
    setTimeout(function () {
        window.opener.document.getElementById('amsku').value = amsku;
    }, 3000);
    setTimeout(cerrar, 4000);
}

function regresarEstras() {
    if (window.opener.document.getElementById('itemCode').value != '') {
        window.close();
    }
}

function regresarSeller() {
    window.close();
}

function regresar() {
    window.close();
}

var contra1funca = 0;

function comprobarContra(e, contras, contra2s) {
    contra = document.getElementById(contras);
    contra2 = document.getElementById(contra2s);
    var str = contra.value;
    if (caracteresValidos(str.substr(((str.length) - 1), str.length))) {
        contra.value = contra.value;
    } else {//alert(str);
        contra.value = contra.value.substr(0, (contra.value.length) - 1);
        document.getElementById('advertenciacontra').hidden = false;
        setTimeout(function () {
            document.getElementById('advertenciacontra').hidden = true;
        }, 1000);
    }
    contra = document.getElementById(contras);
    contra2 = document.getElementById(contra2s);
    if (contra.value != contra2.value) {
        contra2.style.borderColor = "red";
        contra.style.borderColor = "red";
        contra1funca = 0;
    } else {
        contra2.style.borderColor = "#0bcc08";
        contra.style.borderColor = "#0bcc08";
        contra1funca = 1;
    }
}

function caracteresValidos(es) {
    str = es;
    ret = false;
    if (str.match("a") || str.match("b") || str.match("c") || str.match("d") || str.match("e") || str.match("f") || str.match("g") || str.match("h") || str.match("i") || str.match("j") || str.match("k") || str.match("l") || str.match("m") || str.match("n") || str.match("o") || str.match("p") || str.match("q") || str.match("r") || str.match("s") || str.match("t") || str.match("u") || str.match("v") || str.match("w") || str.match("x") || str.match("y") || str.match("z")) {
        ret = true;
    } else if (str.match("A") || str.match("B") || str.match("C") || str.match("D") || str.match("E") || str.match("F") || str.match("G") || str.match("H") || str.match("I") || str.match("J") || str.match("K") || str.match("L") || str.match("M") || str.match("N") || str.match("O") || str.match("P") || str.match("Q") || str.match("R") || str.match("S") || str.match("T") || str.match("U") || str.match("V") || str.match("W") || str.match("X") || str.match("Y") || str.match("Z")) {
        ret = true;
    } else if (str.match("0") || str.match("1") || str.match("2") || str.match("3") || str.match("4") || str.match("5") || str.match("6") || str.match("7") || str.match("8") || str.match("9")) {
        ret = true;
    } else if (str.match("-") || str.match("@") || str.match("#") || str.match("=") || str.match("_") || str.match(",") || str.match("!") || str.match("%")) {
        ret = true;
    }
    return ret;
}

function cambioContra() {
    ventana('cargaLoadC', 300, 400);
    contra11 = document.getElementById('contra1').value;
    contra12 = document.getElementById('confirma1').value;
    if (contra1funca == 1) {
        $('#resultado1contra').html('<img src="../../images/loader.gif" alt="" /><span>Loader... </span>');
        $.ajax({
            url: '../php/usuarios/cambioContra.php',
            type: 'POST',
            data: 'contra1=' + contra11 + '&contra2=' + contra12,
            success: function (resp) {
                setTimeout(function () {
                    $("#cargaLoadC").dialog("close");
                }, 100);
                $('#resultado1contra').html(resp);
            }
        });
    }
}

function comprobarTypoContra(id, obj) {
    if (document.getElementById(id).type == "password") {
        document.getElementById(id).type = "text";
        obj.src = "../images/ojo-abierto.png";
    } else {
        document.getElementById(id).type = "password";
        obj.src = "../images/ojo-cerrado.png";
    }
}
