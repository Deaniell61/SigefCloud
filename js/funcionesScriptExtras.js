/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
prosigue = false;

function envioDeDataExtras() {
    var1 = "";
    var2 = "";
    var3 = "";
    var4 = "";
    var5 = "";
    var6 = "";
    var7 = "";
    cadVariables = location.search.substring(1, location.search.length);
    arrVariables = cadVariables.split("&");
    for (i = 0; i < arrVariables.length; i++) {
        arrVariableActual = arrVariables[i].split("=");

        if (isNaN(parseFloat(arrVariableActual[1]))) {
            eval(arrVariableActual[0] + "='" + unescape(arrVariableActual[1]) + "';");
        }
        else {
            eval(arrVariableActual[0] + "=" + arrVariableActual[1] + ";");
        }

        if (i == 0) {
            var1 = arrVariableActual[1];
        }
        else {
            if (i == 1) {
                var2 = arrVariableActual[1];
            }
            else {
                if (i == 2) {
                    var3 = arrVariableActual[1];
                }
                else {
                    if (i == 3) {
                        var4 = arrVariableActual[1];
                    }
                    else {
                        if (i == 4) {
                            var5 = arrVariableActual[1];
                        }
                        else {
                            if (i == 5) {
                                var6 = arrVariableActual[1];
                            }
                            else {
                                if (i == 6) {
                                    var7 = arrVariableActual[1];
                                }
                            }
                        }
                    }
                }
            }

        }

    }

    llenarDatosExtras(var1, var2, var3, var4, var5, var6, var7);


}

function llenarDatosExtras(fomul, empresa, pais, sku, prodname, bundle, univenta) {
    switch (formul) {
        case "marca":
        {

            $.ajax({
                url: '../../Inicio/formularios/formMarca.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {

                    $('#formulario').html(resp);
                }


            });

            break;
        }
        case "prodLin":
        {

            $.ajax({
                url: '../../Inicio/formularios/formLinea.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {

                    $('#formulario').html(resp);
                }


            });

            break;
        }
        case "category":
        {

            $.ajax({
                url: '../../Inicio/formularios/formCategoria.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {

                    $('#formulario').html(resp);
                }


            });

            break;
        }
        case "subCategory":
        {

            $.ajax({
                url: '../../Inicio/formularios/formSubCategoria.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {

                    $('#formulario').html(resp);
                }


            });

            break;
        }
        case "pakage":
        {

            $.ajax({
                url: '../../Inicio/formularios/formPakage.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {

                    $('#formulario').html(resp);
                }


            });

            break;
        }
        case "size":
        {
            $.ajax({
                url: '../../Inicio/formularios/formSize.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "flavor":
        {
            $.ajax({
                url: '../../Inicio/formularios/formFlavor.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "bundle":
        {
            $.ajax({
                url: '../../Inicio/formularios/formBundle.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais + '&sku=' + sku + '&prodname=' + prodname + '&bundle=' + bundle + '&tota=' + univenta,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "formulas":
        {
            $.ajax({
                url: '../../Inicio/formularios/formFormula.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "ageSegment":
        {
            $.ajax({
                url: '../../Inicio/formularios/formAgeSegment.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "cocina":
        {
            $.ajax({
                url: '../../Inicio/formularios/formCocina.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "concerns":
        {
            $.ajax({
                url: '../../Inicio/formularios/formConcern.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "manufacturadores":
        {
            $.ajax({
                url: '../../Inicio/formularios/formManufacturadores.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "paisOrigen":
        {
            $.ajax({
                url: '../../Inicio/formularios/formPaisOrigen.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "parametrosCanal":
        {

            $.ajax({
                url: '../productos/DatosBundle/formParametroNuevo.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "seller":
        {

            $.ajax({
                url: '../../Inicio/formularios/formSeller.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais + '&codprov=' + sku,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "Exportacion":
        {

            $.ajax({
                url: '../../Inicio/formularios/formExporta.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais + '&codprov=' + sku,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "Transporte":
        {

            $.ajax({
                url: '../../Inicio/formularios/formTransporte.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais + '&codprov=' + sku,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "Comercializa":
        {

            $.ajax({
                url: '../../Inicio/formularios/formCanalesComercializa.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais + '&codprov=' + sku,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }
        case "Arancel":
        {

            $.ajax({
                url: '../../Inicio/formularios/formArancel.php',
                type: 'POST',
                data: 'empresa=' + empresa + '&pais=' + pais + '&codprov=' + sku,
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

    }
}

function guardarExtra(formul, empresa, nombre, alto, ancho, largo, pais, pesouni) {

    var pesuni = "";

    if (formul == "manufact" || formul == "MANUFACT") {
        ciudad = document.getElementById('Ciudad').value;
        estado = document.getElementById('Estado').value;
        codpos = document.getElementById('CodPos').value;
        pais2 = document.getElementById('pais').value;
        pesuni = '' + '&ciudad=' + ciudad + '&estado=' + estado + '&codpos=' + codpos + '&pais2=' + pais2;
    }

    $.ajax({

        url: '../../php/productos/ingresoExtras.php',
        type: 'POST',
        data: 'empresa=' + limpiarCaracteresEspeciales(empresa) + '&formul=' + limpiarCaracteresEspeciales(formul) + '&nombre=' + limpiarCaracteresEspeciales(nombre) + '&alto=' + limpiarCaracteresEspeciales(alto) + '&ancho=' + limpiarCaracteresEspeciales(ancho) + '&largo=' + limpiarCaracteresEspeciales(largo) + '&pais=' + limpiarCaracteresEspeciales(pais) + '&pesoUni=' + limpiarCaracteresEspeciales(pesouni) + '&pesni=' + (pesuni),
        success: function (resp) {
            console.log("S" + resp)
        },
        error: function (resp) {
            console.log("E" + resp)
        }
    });
}

function actualizarExtra(formul, empresa, nombre, alto, ancho, largo, pais, pesouni) {
    var pesuni = "";

    if (formul == "manufact" || formul == "MANUFACT") {
        ciudad = document.getElementById('Ciudad').value;
        estado = document.getElementById('Estado').value;
        codpos = document.getElementById('CodPos').value;
        pais2 = document.getElementById('pais').value;
        pesuni = '' + '&ciudad=' + ciudad + '&estado=' + estado + '&codpos=' + codpos + '&pais2=' + pais2;
    }

    $.ajax({
        url: '../../php/productos/actualizarExtras.php',
        type: 'POST',
        data: 'empresa=' + limpiarCaracteresEspeciales(empresa) + '&formul=' + limpiarCaracteresEspeciales(formul) + '&nombre=' + limpiarCaracteresEspeciales(nombre) + '&alto=' + limpiarCaracteresEspeciales(alto) + '&ancho=' + limpiarCaracteresEspeciales(ancho) + '&largo=' + limpiarCaracteresEspeciales(largo) + '&pais=' + limpiarCaracteresEspeciales(pais) + '&pesoUni=' + limpiarCaracteresEspeciales(pesouni) + '&pesni=' + (pesuni),
        success: function (resp) {
            $('#resultado').html(resp);

        }


    });

}
function guardarPais(formul, empresa, nombre, alto, ancho, largo, pais, pesouni, cod1, cod2, cod3) {
    $('#resultado').html('<img src="../../images/loader.gif" alt="" /><span>Loader...</span>');
    $.ajax({
        url: '../../php/productos/ingresoExtras.php',
        type: 'POST',
        data: 'empresa=' + limpiarCaracteresEspeciales(empresa) + '&formul=' + limpiarCaracteresEspeciales(formul) + '&nombre=' + limpiarCaracteresEspeciales(nombre) + '&alto=' + limpiarCaracteresEspeciales(alto) + '&ancho=' + limpiarCaracteresEspeciales(ancho) + '&largo=' + limpiarCaracteresEspeciales(largo) + '&pais=' + limpiarCaracteresEspeciales(pais) + '&pesoUni=' + limpiarCaracteresEspeciales(pesouni) + '&cod1=' + limpiarCaracteresEspeciales(cod1) + '&cod2=' + limpiarCaracteresEspeciales(cod2) + '&cod3=' + limpiarCaracteresEspeciales(cod3),
        success: function (resp) {
            document.getElementById('formExtra').reset();
            $('#resultado').html(resp);
        }
    });

}

function generaDescripcion(uni, pes, medida, descripcion) {
    uni = document.getElementById(uni).value;
    pes = document.getElementById(pes).value;
    medida = document.getElementById(medida).value;
    document.getElementById(descripcion).value = uni + ' x ' + pes + ' ' + medida;
}
