/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */

var IDLE_TIMEOUT = 1800;
var _idleSecondsCounter = 0;
document.onclick = function () {
    _idleSecondsCounter = 0;
    // console.log("SESSION TIMER RESET");
};
document.onmousemove = function () {
    _idleSecondsCounter = 0;
    // console.log("SESSION TIMER RESET");
};
document.onwheel = function () {
    _idleSecondsCounter = 0;
    // console.log("SESSION TIMER RESET");
};
document.onkeypress = function () {
    _idleSecondsCounter = 0;
    // console.log("SESSION TIMER RESET");
};
window.onfocus = function() {
    _idleSecondsCounter = 0;
    // console.log("SESSION TIMER RESET");
}
window.setInterval(CheckIdleTime, 1000);

function CheckIdleTime() {
    var curLoc = $(location).attr("href");
    if (curLoc != location.origin
        && curLoc != 'https://desarrollo.sigefcloud.com/index.php'
        && curLoc != 'https://www.sigefcloud.com/index.php'
        && curLoc != 'http://sigefcloud.com/wiki/'
    ) {
        _idleSecondsCounter++;
        if(_idleSecondsCounter > 5){
            // console.log("SESSION IDDLE TIME : " + _idleSecondsCounter + " TIME UNTIL END SESSION (IN SECONDS): " + (1800 - parseInt(_idleSecondsCounter)));
        }

        if (_idleSecondsCounter >= IDLE_TIMEOUT) {
            $.ajax({
                url: location.origin + "/php/logout.php",
                success: function (response) {
                    alert("Tu sesion ha expirado por falta de actividad.");
                    location.reload();
                    if(pag !=  null){
                        pag.close();
                    }
                }
            });
        }
    }
}


prosigue = false;
guardaro = 1;

function __(id) {
    return document.getElementById(id);
}

function vaciarDemas(nombre) {
    switch (nombre) {
        case "ing": {
            document.getElementById('edit').selectedIndex = 0;
            break;
        }
        case "edit": {
            document.getElementById('ing').selectedIndex = 0;
            break;
        }
    }
}

function agregarAccessos(nombre) {
}

function inna() {
    //document.oncontextmenu = function(){return false}
}

function formularioDinamico(link,method,data){
    let data1 = {
        link : link,
        data : data,
        method: method
    }

    $.ajax({
        url: '../'+data1.link,
        type: ''+data1.method?data1.method:'POST',
        data: ''+data1.data?data1.data:null,
        success: function (resp) {
            $('#formulario').html(resp);
        }
    });
}

function selecFormulario(tipo) {
    switch (tipo) {
        case "1": {
            $.ajax({
                url: '../php/usuarios/formUsuarios.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "2": {
            $.ajax({
                url: '../php/empresas/formEmpresas.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "3": {
            $.ajax({
                url: '../php/menu/modulos/formModulos.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "4": {
            $.ajax({
                url: '../php/productos/DatosBundle/formCanales.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "5": {
            $.ajax({
                url: '../php/proveedores/formProveedores.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "6": {
            $.ajax({
                url: '../php/notificaciones/formNotificacion.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "7": {
            $.ajax({
                url: '../php/unidadesMedida/formMedida.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "8": {
            $.ajax({
                url: '../php/soporte/formSoporte.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "9": {
            //alert(2);
            $.ajax({
                url: '../php/adminOrdenes/formOrdenes.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "10": {
            $.ajax({
                url: '../php/wiki/formWiki.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "11": {
            //alert(2);
            $.ajax({
                url: '../php/adminDB/formAdminDB.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        case "12": {
            //alert(2);
            $.ajax({
                url: '../php/ordenesMod/formOrdenes.php',
                type: 'POST',
                success: function (resp) {
                    $('#formulario').html(resp);
                }
            });
            break;
        }

        //balance actual
        case "13":
            $.ajax({
                url: "../php/balances/balances.php",
                type: "POST",
                data: {
                    method: "",
                },
                success: function (response) {
                    $("#formulario").html(response);
                    setTimeout(function () {
                        $("#tabs").tabs({active: 1});
                        $('#balanceDrop option')[0].selected = true;
                        $("#balanceDrop").change();
                    }, 250);
                }
            });
            break;

        //balance pasado
        case "14":
            $.ajax({
                url: "../php/balances/balances.php",
                type: "POST",
                data: {
                    method: "",
                },
                success: function (response) {
                    $("#formulario").html(response);
                    setTimeout(function () {
                        $("#tabs").tabs({active: 1});
                        $('#balanceDrop option')[1].selected = true;
                        $("#balanceDrop").change();
                    }, 250);
                }
            });
            break;

        case "15":
            $.ajax({
                url: "../php/bodegaje/bodegaje.php",
                type: "POST",
                data: {
                    method: "",
                },
                success: function (response) {
                    console.log("S");
                    $("#formulario").html(response);
                },
                error: function (response) {
                    console.log("E");
                }
            });
            break;
    }
    
}

function comprobarEmail() {

    // Expresion regular para validar el correo
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    // Se utiliza la funcion test() nativa de JavaScript
    if (regex.test($('#email').val().trim())) {
        prosigue = true;
        $('#comprobar').html("<div id=\"Success\" ></div>");
        document.getElementById('email').className = "bueno";
    } else {
        prosigue = false;
        $('#comprobar').html("<div id=\"Error\" alt=\"Ayuda\" onmouseover=\"muestraAyuda(event, \'UsuarioError\')\"></div>");
        document.getElementById('email').className = "obligado";
    }

}


$(document).ready(function () {
    $('#user').change(function () {

        $('#comprobar').html('<img src="images/loader.gif" alt="" />');

        var username = $(this).val();
        var dataString = 'user=' + username;

        $.ajax({
            type: "POST",
            url: "../../php/usuario.php",
            data: dataString,
            success: function (data) {
                $('#comprobar').html(data);
                //alert(data);
            }
        });
    });
});

$(document).ready(function () {
    $('#user').keyup(function () {

        $('#comprobar').html('<img src="images/loader.gif" alt="" />');

        var username = $(this).val();
        var dataString = 'user=' + username;

        $.ajax({
            type: "POST",
            url: "../../php/usuario.php",
            data: dataString,
            success: function (data) {
                $('#comprobar').html(data);
                //alert(data);
            }
        });
    });
});

function Validar(user, pass) {
    $.ajax({
        url: 'php/validar.php',
        type: 'POST',
        data: 'user=' + user + '&pass=' + pass,
        success: function (resp) {
            console.log("R" + resp);
            $('#resultado').html(resp);
        }

    });
}

function bueno1(obc, obc2) {
    obc2 = document.getElementById(obc2);
    if (obc.value != "") {
        obc2.hidden = true;

    } else {
        obc2.hidden = false;
    }
}

function buenNombre() {
    document.getElementById('nombre').className = "bueno";
}

function buenNit() {
    document.getElementById('nit').className = "bueno";
}

function buenrsocial() {
    document.getElementById('rsocial').className = "bueno";
}


/*window.onload = function()
 {
 document.getElementById("nombre").addEventListener( 'keydown' , buenNombre );
 document.getElementById("nit").addEventListener( 'keydown' , buenNit );
 document.getElementById("rsocial").addEventListener( 'keydown' , buenrsocial );

 }*/
function resetFormEmpresas() {
    document.getElementById('nombre').className = "obligado";
    document.getElementById('nit').className = "obligado";
    document.getElementById('rsocial').className = "obligado";
    document.getElementById('email').className = "obligado";
}

function LimpiarBuscarUsua() {
    document.getElementById('buscaUser').value = "";
    document.getElementById('buscaEmail').value = "";
    document.getElementById('buscaApel').value = "";
}

function LimpiarBuscarModulos() {
    document.getElementById('buscaNombre').value = "";
    document.getElementById('buscaTipo').value = "";
    document.getElementById('buscaCodigo').value = "";
}

function LimpiarBuscarEmpresa() {

    document.getElementById('buscaUser').value = "";
    document.getElementById('buscaEmail').value = "";
    document.getElementById('buscaRsocial').value = "";
    document.getElementById('buscaNIT').value = "";
}

function LimpiarBuscarProducto() {

    document.getElementById('buscaMasterSKU').value = "";
    document.getElementById('buscaNombre').value = "";
    document.getElementById('buscaMarca').value = "";
    document.getElementById('buscaDescripcion').value = "";
}

function tabllenar() {
    /*var onSampleResized = function(e){
     var columns = $(e.currentTarget).find("th");
     var msg = "columns widths: ";
     columns.each(function(){ msg += $(this).width() + "px; "; })
     }

     $("#tablaDatos").colResizable({
     liveDrag:true,
     gripInnerHtml:"<div class='grip'></div>",
     draggingClass:"dragging",
     onResize:onSampleResized});


     $("table").tablesorter({
     sortList: [[0,0],[2,1]]
     });	*/
}

function ocultar() {
    document.getElementById('trAplicacion').style.display = 'none'
}

function Full() {
    //window.resizeTo(screen.availWidth,screen.availHeight);
    //window.moveTo( 0, 0 );

    //document.fullscreenElement=true;
    //alert(document.fullscreenElement);
}

function validateEnter(e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        return true;
    } else {
        return false;
    }
}

function contarCaracteres(objeto, cantidad, respuesta) {
    //alert(2);
    if (objeto.value.length <= cantidad) {
        objeto.value = objeto.value;
    } else {
        objeto.value = objeto.value.substr(0, cantidad);
    }
    respuesta.innerHTML = (cantidad - objeto.value.length);
}

function piedepagina() {
    $('#tablas_previous').html('Anterior');
    $('#tablas_next').html('Siguiente');
}

function piedepagina2() {
    $('#tablas2_previous').html('Anterior');
    $('#tablas2_next').html('Siguiente');
}

function ejecutarpie() {
    setInterval(piedepagina, 500);
}

function ejecutarpie2() {
    setInterval(piedepagina2, 500);
}

function limpiarCaracteresEspeciales(obj) {
    return obj.replace(/&amp;/gi, '@amp;').replace(/&amp/gi, '@amp;').replace(/&/gi, '@amp;').replace(/'/gi, '\\\'').replace(/"/gi, '\\\'');
}

function limpiarCaracteresEspecialesTelefono(obj) {
    return obj.replace(/&amp;/gi, '@amp;').replace(/&amp/gi, '@amp;').replace(/&/gi, '@amp;').replace(/'/gi, '\\\'').replace(/"/gi, '\\\'').replace('(', '').replace(')', '').replace('-', '').replace(' ', '');
}

function cambioContraLlenar() {
    $.ajax({
        url: '../php/formularios/cambioContra.php',
        type: 'POST',
        success: function (resp) {
            $('#contra').html(resp);
        }
    });
}

function ventana(id, h, w) {
    $("#" + id).dialog({
        maxWidth: w,
        maxHeight: h,
        width: w,
        height: h,
        modal: true,
    });
    llenadoDeEspera(id, id);
}

function llenadoDeEspera(tipo, id) {
    switch (tipo) {
        case "cargaLoad": {
            document.getElementById(id).innerHTML = '<center><img src="../../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere... </span></center>';
            break;
        }
        case "cargaLoadS": {
            document.getElementById(id).innerHTML = '<center><img src="../../../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere... </span></center>';
            break;
        }
        case "cargaLoadB": {
            document.getElementById(id).innerHTML = '<center><img src="../../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere, esto podria tardar unos minutos... </span></center>';
            break;
        }
        case "cargaLoadVP": {
            document.getElementById(id).innerHTML = '<center><img src="../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere... </span></center>';
            break;
        }
        case "cargaLoadCon": {
            document.getElementById(id).innerHTML = '<center><img src="../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere... </span></center>';
            break;
        }
        case "cargaLoadG": {
            document.getElementById(id).innerHTML = '<center><img src="../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere... </span></center>';
            break;
        }
        case "cargaLoadGeneral": {
            document.getElementById(id).innerHTML = '<center><img src="../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere... </span></center>';
            break;
        }
    }
}

function llenarBusqueda(tipo, id) {
    $('#' + id).html("");
    setTimeout(function () {
        switch (tipo) {
            case "Arancel": {
                $.ajax({
                    url: '../formularios/buscaArancel.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
            case "Marca": {
                $.ajax({
                    url: '../formularios/buscaMarca.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
            case "Manufacturador": {
                $.ajax({
                    url: '../formularios/buscaManufacturador.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
            case "ProdLin": {
                $.ajax({
                    url: '../formularios/buscaLinea.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
            case "Flavor": {
                $.ajax({
                    url: '../formularios/buscaFlavor.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
            case "Formula": {
                $.ajax({
                    url: '../formularios/buscaFormula.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
            case "Cocina": {
                $.ajax({
                    url: '../formularios/buscaCocina.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
            case "size": {
                $.ajax({
                    url: '../formularios/buscaSize.php',
                    type: 'POST',
                    data: 'tipo=' + tipo,
                    success: function (resp) {
                        $('#' + id).html(resp);
                    }
                });
                break;
            }
        }
    }, 500);

}

function llenarAviso() {
    $.ajax({
        url: '../php/formularios/cambioContra.php',
        type: 'POST',
        success: function (resp) {
        }
    });
}

function toMoney(input) {
    input.value = (currency(input.value));
}

function toNumber(input) {
    input.value = (number(input.value));
}

function currency(value, decimals, separators) {
    value = value.replace("$", "");
    decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
    separators = separators || [',', ",", '.'];
    var number = (parseFloat(value) || 0).toFixed(decimals);
    if (number.length <= (4 + decimals))
        return "$" + number.replace('.', separators[separators.length - 1]);
    var parts = number.split(/[-.]/);
    value = parts[parts.length > 1 ? parts.length - 2 : 0];
    var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
        separators[separators.length - 1] + parts[parts.length - 1] : '');
    var start = value.length - 6;
    var idx = 0;
    while (start > -3) {
        result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
            + separators[idx] + result;
        idx = (++idx) % 2;
        start -= 3;
    }
    return '$' + (parts.length == 3 ? '-' : '') + result;
}

function number(value, decimals, separators) {
    value = value.replace("$", "");
    decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
    separators = separators || [',', ",", '.'];
    var number = (parseFloat(value) || 0).toFixed(decimals);
    if (number.length <= (4 + decimals))
        return "" + number.replace('.', separators[separators.length - 1]);
    var parts = number.split(/[-.]/);
    value = parts[parts.length > 1 ? parts.length - 2 : 0];
    var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
        separators[separators.length - 1] + parts[parts.length - 1] : '');
    var start = value.length - 6;
    var idx = 0;
    while (start > -3) {
        result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
            + separators[idx] + result;
        idx = (++idx) % 2;
        start -= 3;
    }
    return '' + (parts.length == 3 ? '-' : '') + result;
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if (charCode == 46) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}

function isAlfa(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 32 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
        return false;
    }
    return true;
}

function noSpace(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode == 32) {
        return false;
    }
    return true;
}

function separar(odb, id) {
    txt = odb.value;

    ray = txt.split(" ");
    odb.value = ray[0];
    document.getElementById(id).innerHTML = "";
    for (i = 1; i < ray.length; i++) {
        document.getElementById(id).innerHTML = document.getElementById(id).innerHTML + " " + ray[i];
    }
}

function verificaPeriodo(periFin) {
    periFin = periFin.value;
    periIni = document.getElementById('periIni').value;

    if (periFin <= periIni) {
        setTimeout(function () {
            document.getElementById('periFin').value = periIni;
        }, 200);
    }
}

function balanceCurrent() {
    selecFormulario("13")
}

function balanceLast() {
    selecFormulario("14")
}