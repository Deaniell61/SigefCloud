/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function seleccionarProveedor(tipo) {
    if (tipo == "P") {
        document.getElementById('prov').hidden = false;
    } else {
        document.getElementById('prov').hidden = true;
    }
}

function llenarProveedores(empresa) {
    $.ajax({
        url: '../proveedores/asignarProveedor.php',
        type: 'POST',
        data: 'hacer=llenarCombo&empresa=' + empresa,
        success: function (resp) {
            $('#proveedor').html(resp);
        }
    });
}

function asignarProveedor(usuario, chek, prov, empresa) {
    if (chek) {
        guardarAsignarProveedor(usuario, prov, empresa);
    } else {
        borrarAsignarProveedor(usuario, prov, empresa);
    }
}

function guardarAsignarProveedor(usuario, empresa, empresa2) {
    $.ajax({
        url: '../permisos/asignarProveedor.php',
        type: 'POST',
        data: 'usuario=' + usuario + '&empresa=' + empresa + '&asig=1' + '&empresa2=' + empresa2,
        success: function (resp) {
            $('#resultado').html(resp);
        }
    });
}

function borrarAsignarProveedor(usuario, empresa, empresa2) {
    $.ajax({
        url: '../permisos/asignarProveedor.php',
        type: 'POST',
        data: 'usuario=' + usuario + '&empresa=' + empresa + '&asig=2' + '&empresa2=' + empresa2,
        success: function (resp) {
            $('#resultado').html(resp);
        }
    });
}

function envioDeDataProveedor(es) {
    var pais = "";
    var codi = "";
    cadVariables = location.search.substring(1, location.search.length);
    arrVariables = cadVariables.split("&");
    for (i = 0; i < arrVariables.length; i++) {
        arrVariableActual = arrVariables[i].split("=");
        if (isNaN(parseFloat(arrVariableActual[1])))
            eval(arrVariableActual[0] + "='" + unescape(arrVariableActual[1]) + "';");
        else
            eval(arrVariableActual[0] + "=" + arrVariableActual[1] + ";");
        if (i == 0) {
            codi = arrVariableActual[1];
        }
        if (i == 1) {
            pais = arrVariableActual[1];
        }
        if (i == 2) {
            codpais = arrVariableActual[1];
        }
    }
    if (arrVariableActual[1] == 'nuevo') {
        llenarDatosProveedorNuevo(arrVariableActual[1]);
    } else {
        llenarDatosProveedor(codi, pais, cod);
    }
}

function llenarDatosProveedor(codigo, pais, cod) {
    $.ajax({
        url: '../proveedores/buscarProveedor.php',
        type: 'POST',
        data: 'codigo=' + codigo + '&pais=' + pais + '&codpais=' + cod,
        success: function (resp) {
            $('#formularioP').html(resp);
        }
    });
}

function llenarDatosProveedorNuevo(codigo) {
    $.ajax({
        url: '../proveedores/nuevoProveedor.php',
        type: 'POST',
        data: 'codigo=' + codigo,
        success: function (resp) {
            $('#formularioP').html(resp);
        }
    });
}

function abrirProveedor(codprov, pais, codpais) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    pag = window.open("../php/proveedores/paginaProveedores.php?codigo=" + codprov + "&pais=" + pais + "&cod=" + codpais, "Proveedores", params);
    pag.focus();
}

function abrirProveedor2(codprov, pais, codpais, pesta) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    pag = window.open("../php/proveedores/paginaProveedores.php?codigo=" + codprov + "&pais=" + pais + "&cod=" + codpais + "&pesta=" + pesta, "Proveedores", params);
    pag.focus();
}

var prosigue1 = 0;

function guardarProveedor(cod) {
    ventana('cargaLoad', 300, 400);
    var nombre = limpiarCaracteresEspeciales(document.getElementById('nombre').value);
    var direccion = limpiarCaracteresEspeciales(document.getElementById('direccion').value);
    var telefono = limpiarCaracteresEspecialesTelefono(document.getElementById('telefono').value);
    var telefono2 = limpiarCaracteresEspecialesTelefono(document.getElementById('telefono2').value);
    var fax = limpiarCaracteresEspecialesTelefono(document.getElementById('fax').value);
    var web = limpiarCaracteresEspeciales(document.getElementById('web').value);
    var emailContacto = limpiarCaracteresEspeciales(document.getElementById('emailContacto').value);
    var contactoNombre = limpiarCaracteresEspeciales(document.getElementById('contactoNombre').value);
    var contactoApellido = limpiarCaracteresEspeciales(document.getElementById('contactoApellido').value);
    var cargo = limpiarCaracteresEspeciales(document.getElementById('cargo').value);
    var combo = (document.getElementById('pais'));
    var pais = combo.options[combo.selectedIndex].text;
    var Empresas = (document.getElementById('Empresas').value);
    var estado = document.getElementById('estado').value;
    var ckeck = document.getElementById('terminos').checked;
    var paisprov = limpiarCaracteresEspeciales(document.getElementById('paisprov').value);
    var ciudadprov = limpiarCaracteresEspeciales(document.getElementById('ciudadprov').value);
    var codpos = limpiarCaracteresEspeciales(document.getElementById('codpostal').value);
    $('#resultado').html('<img src="../../images/loader.gif" alt="" /><span>Loader... </span>');
    if (ckeck) {
        ckeck = 1;
        if (prosigue1 == 1) {
            $.ajax({
                url: '../proveedores/ingresoProveedor.php',
                type: 'POST',
                data: 'nombre=' + nombre + '&direccion=' + direccion + '&telefono=' + telefono + '&telefono2=' + telefono2 + '&fax=' + fax + '&web=' + web + '&emailContacto=' + emailContacto + '&contacto=' + contactoNombre + '&cargo=' + cargo + '&pais=' + pais + '&codigo=' + cod + '&empresa=' + Empresas + '&contactoApellido=' + contactoApellido + '&estado=' + estado + '&ciudadprov=' + ciudadprov + '&paisprov=' + paisprov + '&check=' + ckeck + '&codpos=' + codpos,
                success: function (resp) {
                    console.log(resp);
                    $('#resultado').html(resp);
                    // $('#resultado').html("");
                },
                error: function (response) {
                    console.log(JSON.stringify(response));
                    console.log("error al guardar el proveedor con esta data: " + 'nombre=' + nombre + '&direccion=' + direccion + '&telefono=' + telefono + '&telefono2=' + telefono2 + '&fax=' + fax + '&web=' + web + '&emailContacto=' + emailContacto + '&contacto=' + contactoNombre + '&cargo=' + cargo + '&pais=' + pais + '&codigo=' + cod + '&empresa=' + Empresas + '&contactoApellido=' + contactoApellido + '&estado=' + estado + '&ciudadprov=' + ciudadprov + '&paisprov=' + paisprov + '&check=' + ckeck + '&codpos=' + codpos);
                    $('#resultado').html("");
                }
            });
        } else {
            $('#resultado').html('Verifique el Email');
            document.getElementById('emailContacto').focus();
            setTimeout(function () {
                $("#cargaLoad").dialog("close");
            }, 500);
        }
    } else {
        $('#resultado').html('Debe aceptar los terminos y condiciones');
        document.getElementById('terminos').focus();
        setTimeout(function () {
            $("#cargaLoad").dialog("close");
        }, 500);
    }
}

function actualizarProveedor(tipo, cod) {
    var datosSend = "";
    ventana('cargaLoad', 300, 400);
    switch (tipo) {
        case "fact": {
            var direccion = limpiarCaracteresEspeciales(document.getElementById('direccion').value);
            var paisprov = limpiarCaracteresEspeciales(document.getElementById('paisprov').value);
            var ciudad = limpiarCaracteresEspeciales(document.getElementById('ciudadprov').value);
            var codpos = limpiarCaracteresEspeciales(document.getElementById('codpostal').value);
            var nombreContacto = limpiarCaracteresEspeciales(document.getElementById('contactoNombre').value);
            var apellidoContacto = limpiarCaracteresEspeciales(document.getElementById('contactoApellido').value);
            var emailContacto = limpiarCaracteresEspeciales(document.getElementById('emailContacto').value);
            var telefonoContacto = limpiarCaracteresEspecialesTelefono(document.getElementById('telefono2').value);
            var cargoContacto = limpiarCaracteresEspeciales(document.getElementById('cargo').value);
            var nit = limpiarCaracteresEspeciales(document.getElementById('nit').value);
            var ncomercial = limpiarCaracteresEspeciales(document.getElementById('ncomercial').value);
            var combo = (document.getElementById('pais'));
            var pais = combo.options[combo.selectedIndex].text;
            datosSend = 'codigo=' + cod + '&pais=' + pais + '&tipo=' + tipo + '&direccion=' + direccion + '&paisprov=' + paisprov + '&ciudad=' + ciudad + '&codpos=' + codpos + '&nombreContacto=' + nombreContacto + '&apellidoContacto=' + apellidoContacto + '&emailContacto=' + emailContacto + '&telefonoContacto=' + telefonoContacto + '&cargoContacto=' + cargoContacto + '&ncomercial=' + ncomercial + '&nit=' + nit;
            break;
        }
        case "pago": {
            var formapago = limpiarCaracteresEspeciales(document.getElementById('fPago').value);
            var echeque = limpiarCaracteresEspeciales(document.getElementById('echeque').value);
            var banco = limpiarCaracteresEspeciales(document.getElementById('banco').value);
            var cuenta = limpiarCaracteresEspeciales(document.getElementById('cuenta').value);
            // var routnum = limpiarCaracteresEspeciales(document.getElementById('routnum').value);
            var nombreContacto = limpiarCaracteresEspeciales(document.getElementById('contactoNombre').value);
            var apellidoContacto = limpiarCaracteresEspeciales(document.getElementById('contactoApellido').value);
            var emailContacto = limpiarCaracteresEspeciales(document.getElementById('emailContacto').value);
            var telefonoContacto = limpiarCaracteresEspecialesTelefono(document.getElementById('telefono2').value);
            var cargoContacto = limpiarCaracteresEspeciales(document.getElementById('cargo').value);
            var paypalMail = document.getElementById('paypalMailInput').value;
            var paypal1er = (document.getElementById('paypal1er').checked) ? 1 : 0;
            var swiftnum = document.getElementById('swiftnum').value;
            var rounum = document.getElementById('rounum').value;
            var combo = (document.getElementById('pais'));
            var pais = combo.options[combo.selectedIndex].text;
            datosSend = 'codigo=' + cod + '&pais=' + pais + '&tipo=' + tipo + '&formapago=' + formapago + '&echeque=' + echeque + '&ppmail=' + paypalMail + '&banco=' + banco + '&cuenta=' + cuenta + '&nombreContacto=' + nombreContacto + '&apellidoContacto=' + apellidoContacto + '&emailContacto=' + emailContacto + '&telefonoContacto=' + telefonoContacto + '&cargoContacto=' + cargoContacto + '&rounum=' + rounum + '&paypal1er=' + paypal1er + '&swiftnum=' + swiftnum;
            break;
        }
        case "cobro": {
            var tipoTarjeta = limpiarCaracteresEspeciales(document.getElementById('tipoTar').value);
            var ntarjeta = limpiarCaracteresEspeciales(document.getElementById('nTar').value);
            var titularTarjeta = limpiarCaracteresEspeciales(document.getElementById('TitTar').value);
            var anioV = limpiarCaracteresEspeciales(document.getElementById('AnioV').value);
            var mesV = limpiarCaracteresEspeciales(document.getElementById('MesV').value);
            var nombreContacto = limpiarCaracteresEspeciales(document.getElementById('contactoNombre').value);
            var apellidoContacto = limpiarCaracteresEspeciales(document.getElementById('contactoApellido').value);
            var emailContacto = limpiarCaracteresEspeciales(document.getElementById('emailContacto').value);
            var telefonoContacto = limpiarCaracteresEspecialesTelefono(document.getElementById('telefono2').value);
            var cargoContacto = limpiarCaracteresEspeciales(document.getElementById('cargo').value);
            var combo = (document.getElementById('pais'));
            var pais = combo.options[combo.selectedIndex].text;
            datosSend = 'codigo=' + cod + '&pais=' + pais + '&tipo=' + tipo + '&tipoTarjeta=' + tipoTarjeta + '&ntarjeta=' + ntarjeta + '&titularTarjeta=' + titularTarjeta + '&anioV=' + anioV + '&mesV=' + mesV + '&nombreContacto=' + nombreContacto + '&apellidoContacto=' + apellidoContacto + '&emailContacto=' + emailContacto + '&telefonoContacto=' + telefonoContacto + '&cargoContacto=' + cargoContacto;
            break;
        }
        case "Comercializa": {
            var codex = limpiarCaracteresEspeciales(document.getElementById('codExport').value);
            /*	var incre1=limpiarCaracteresEspeciales(document.getElementById('incre1').value);
             var incre2=limpiarCaracteresEspeciales(document.getElementById('incre2').value);
             var incre3=limpiarCaracteresEspeciales(document.getElementById('incre3').value);
             var incre4=limpiarCaracteresEspeciales(document.getElementById('incre4').value);
             var marmin=limpiarCaracteresEspeciales(document.getElementById('marmin').value);
             var marmincon=limpiarCaracteresEspeciales(document.getElementById('marmincon').value);
             var marmax=limpiarCaracteresEspeciales(document.getElementById('marmax').value);
             var marpro=limpiarCaracteresEspeciales(document.getElementById('marpro').value);
             */
            var combo = (document.getElementById('pais'));
            var pais = combo.options[combo.selectedIndex].text;
            datosSend = 'codigo=' + cod + '&pais=' + pais + '&tipo=' + tipo/*+'&marmin='+marmin+'&marpro='+marpro+'&marmax='+marmax+'&marmincon='+marmincon*/ + '&codex=' + codex/*+'&incre1='+incre1+'&incre2='+incre2+'&incre3='+incre3+'&incre4='+incre4*/;
            prosigue1 = 1;
            break;
        }
    }
    ckeck = 1;
    if (ckeck) {
        ckeck = 1;
        console.log("aca");
        if (prosigue1 == 1) {
            $.ajax({
                url: '../proveedores/actualizarProveedor.php',
                type: 'POST',
                data: datosSend,
                success: function (resp) {
                    $('#resultado').html("Guardado");
                    console.log("success" + resp);
                    setTimeout(function () {
                        $("#cargaLoad").dialog("close");
                    }, 500);
                },
                error: function (resp) {
                    console.log("error" + resp);
                }
            });
        } else {
            $('#resultado').html('Verifique el Email');
            document.getElementById('emailContacto').focus();
            setTimeout(function () {
                $("#cargaLoad").dialog("close");
            }, 500);
        }
    } else {
        $('#resultado').html('Debe aceptar los terminos y condiciones');
        document.getElementById('terminos').focus();
        setTimeout(function () {
            $("#cargaLoad").dialog("close");
        }, 500);
    }
}

function llamarProveedor(tab, codigosprov) {
    switch (tab) {
        case '1': {
            $.ajax({
                url: 'pestanas/Registro.php',
                type: 'POST',
                data: 'codigo=' + codigosprov,
                success: function (resp) {
                    $('#formularioProveedor').html(resp);
                }
            });
            break;
        }
        case '2': {
            $.ajax({
                url: 'pestanas/Facturacion.php',
                type: 'POST',
                data: 'codigo=' + codigosprov,
                success: function (resp) {
                    $('#formularioProveedor').html(resp);
                }
            });
            break;
        }
        case '3': {
            $.ajax({
                url: 'pestanas/Pagos.php',
                type: 'POST',
                data: 'codigo=' + codigosprov,
                success: function (resp) {
                    $('#formularioProveedor').html(resp);
                }
            });
            break;
        }
        case '4': {
            $.ajax({
                url: 'pestanas/Cobros.php',
                type: 'POST',
                data: 'codigo=' + codigosprov,
                success: function (resp) {
                    $('#formularioProveedor').html(resp);
                }
            });
            break;
        }
        case '5': {
            tab = "";
            $.ajax({
                url: 'pestanas/crearUsuario.php',
                type: 'POST',
                data: 'codigo=' + codigosprov,
                success: function (resp) {
                    $('#usuarioProv').html(resp);
                }
            });
            break;
        }
        case '6': {
            tab = "";
            $.ajax({
                url: 'pestanas/Comercializacion.php',
                type: 'POST',
                data: 'codigo=' + codigosprov,
                success: function (resp) {
                    $('#formularioProveedor').html(resp);
                }
            });
            break;
        }
        case '7': {
            tab = "";
            $.ajax({
                url: 'pestanas/Archivos.php',
                type: 'POST',
                data: 'codigo=' + codigosprov,
                success: function (resp) {
                    $('#formularioProveedor').html(resp);
                }
            });
            break;
        }
    }
}

function seleccionP(li) {
    document.getElementById('TabRegistro').style.background = '#ffffff';
    document.getElementById('TabFacturacion').style.background = '#ffffff';
    document.getElementById('TabPagos').style.background = '#ffffff';
    document.getElementById('TabCobros').style.background = '#ffffff';
    document.getElementById('TabComer').style.background = '#ffffff';
    document.getElementById('TabArchivos').style.background = '#ffffff';
    document.getElementById('TabArchivos').style.color = '#999999';
    document.getElementById('TabComer').style.color = '#999999';
    document.getElementById('TabRegistro').style.color = '#999999';
    document.getElementById('TabFacturacion').style.color = '#999999';
    document.getElementById('TabPagos').style.color = '#999999';
    document.getElementById('TabCobros').style.color = '#999999';
    li.style.background = '#999999';
    li.style.color = '#ffffff';
}

function llenarCombo(tipo, pais) {
    $.ajax({
        url: '../productos/combosProductos.php',
        type: 'POST',
        data: 'tipo=' + tipo + '&pais=' + pais.value,
        success: function (resp) {
            console.log("T" + resp);
            $('#' + tipo).html(resp);
        },
        error: function (resp) {
            console.log("E" + resp);
        }
    });
}

telefono = 0;

function comprobarTelefono(e, obc) {
    var key = e.keyCode || e.which;
    //  alert(key);
    if (key == 46 || key == 8 || key == 16 || key == 20 || key == 37 || key == 38 || key == 39) {
    } else {
        if (key == 40 || key == 41 || key == 14 || key == 32 || key == 15 || key == 109 || key == 45 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
            obc.value = obc.value;
            //obc.value=obc.value;
        } else {
            obc.value = obc.value.substr(0, (obc.value.length) - 1);
        }
    }
}

function llenarPaisProv() {
    var tipo = "pais";
    var empresa = "";
    var pais = "";
    var puntos = "";
    $.ajax({
        url: '../combosVarios.php',
        type: 'POST',
        data: 'empresa=' + empresa + '&tipo=' + tipo + '&puntos=' + puntos + '&pais=' + pais,
        success: function (resp) {
            $('#paisprov').html(resp);
        }
    });
}

function llenarCiudadProv() {
    var tipo = "ciudad";
    var empresa = "";
    var pais = "";
    var puntos = "";
    $.ajax({
        url: '../combosVarios.php',
        type: 'POST',
        data: 'empresa=' + empresa + '&tipo=' + tipo + '&puntos=' + puntos + '&pais=' + pais,
        success: function (resp) {
            $('#ciudadprov').html(resp);
        }
    });
}

function comprobarEmailProv(email) {
    // Expresion regular para validar el correo
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    // Se utiliza la funcion test() nativa de JavaScript
    if (regex.test($('#' + email + '').val().trim())) {
        prosigue1 = 1;
        document.getElementById(email).style.borderColor = "#0bcc08";
    } else {
        prosigue1 = 0;
        document.getElementById(email).style.borderColor = "red";
    }
}

function enviarCorreo(email, pas, nombre, apel, emp) {
    $.ajax({
        url: '../enviar.php',
        type: 'POST',
        data: 'email=' + email + '&pass=' + pas + '&nombre=' + nombre + '&apel=' + apel + '&emp=' + emp,
        success: function (resp) {
            $('#resultado').html(resp);
        }
    });
}

function enviarCorreoUserProv(email, pas, nombre, apel, emp) {
    $.ajax({
        url: '../php/enviar.php',
        type: 'POST',
        data: 'email=' + email + '&pass=' + pas + '&nombre=' + nombre + '&apel=' + apel + '&emp=' + emp,
        success: function (resp) {
            $('#resultadouserporv').html(resp);
        }
    });
}

function enviarCorreoUserProvCopia(email, pas, nombre, apel, emp, empleado) {
    $.ajax({
        url: '../php/enviarCopia.php',
        type: 'POST',
        data: 'email=' + email + '&pass=' + pas + '&nombre=' + nombre + '&apel=' + apel + '&emp=' + emp + '&empleado=' + empleado,
        success: function (resp) {
            $('#resultadouserporv').html(resp);
        }
    });
}

function cambiarContraUser() {
    ventana('cargaLoad', 300, 400);
    email = document.getElementById('user').value;
    comprobarEmailProv('user');
    if (prosigue1 == 1) {
        $.ajax({
            url: '../usuarios/recuperarContra.php',
            type: 'POST',
            data: 'email=' + email,
            success: function (resp) {
                //alert(2);
                $('#resultado').html(resp);
            }
        });
    } else {
        $('#resultado').html("El correo no es valido");
        setTimeout(function () {
            $("#cargaLoad").dialog("close");
        }, 500);
    }
}

function GuardarUsuarioProveedor(empresa, prov, nomprov) {
    ventana('cargaLoadVP', 300, 400);
    nombre = limpiarCaracteresEspeciales(document.getElementById('nombre').value);
    clave12 = limpiarCaracteresEspeciales(document.getElementById('contrase').value);
    email12 = limpiarCaracteresEspeciales(document.getElementById('email').value);
    estado12 = limpiarCaracteresEspeciales(document.getElementById('estado').value);
    posicion = limpiarCaracteresEspeciales(document.getElementById('rol').value);
    apellido = limpiarCaracteresEspeciales(document.getElementById('apellido').value);
    codigo = limpiarCaracteresEspeciales(document.getElementById('codigo').value);
    usuario = limpiarCaracteresEspeciales(document.getElementById('usuario').value);
    tipo = "prov";
    if (prosigue1 == 1) {
        $.ajax({
            url: '../php/usuarios/ingresoUsuario.php',
            type: 'POST',
            data: 'nombre=' + nombre + '&clave=' + clave12 + '&email=' + email12 + '&posicion=' + posicion + '&apellido=' + apellido + '&estado=' + estado12 + '&codigo=' + codigo + '&usuario=' + usuario + '&tipo=' + tipo + '&empresa=' + empresa + '&prov=' + prov + '&nomprov=' + nomprov,
            success: function (resp) {
                $('#resultadouserporv').html(resp);
            }
        });
    } else {
        $('#resultadouserporv').html("Verifique su correo");
        setTimeout(function () {
            $("#cargaLoadVP").dialog("close");
        }, 500);
        document.getElementById('email').focus();
    }
}

function calculaPromedio(id1, id2, res) {
    id1 = __(id1).value * 1;
    id2 = __(id2).value * 1;
    __(res).value = (id1 + id2) / 2;
}