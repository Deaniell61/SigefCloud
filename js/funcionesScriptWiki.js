/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function abrirWiki(codprov) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    pag = window.open("../php/wiki/paginaWiki.php?codigo=" + codprov, "Wiki", params);
    pag.focus();
    /*$.ajax({
     url:'../php/notificaciones/paginaNotificacion.php',
     type:'POST',
     data:'codigo='+codprov,
     success: function(resp)
     {
     $('#NotificacionVentana').html(resp);
     }
     });
     ventana('NotificacionVentana',screen.height,screen.width) ;*/


}
function envioDeDataWiki(es) {
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

    }


    {
        llenarDatosWiki(codi);
    }


}
function llenarDatosWiki(codigo) {
    $.ajax({
        url: '../wiki/buscarwiki.php',
        type: 'POST',
        data: 'codigo=' + codigo,
        success: function (resp) {
            $('#resultado').html(resp);
        }
    });
}
function cargarWiki(codigo) {

    $.ajax({
        url: 'Funciones/articulos.php',
        type: 'POST',
        data: 'codigo=' + codigo,
        success: function (resp) {

            $('#contenido').html(resp);
        }
    });
}
function ingresoWiki() {
    ventana('cargaLoad', 300, 400);
    var codigo = limpiarCaracteresEspeciales(document.getElementById('codigo').value);
    var modulo = limpiarCaracteresEspeciales(document.getElementById('padre').value);
    var codi = limpiarCaracteresEspeciales(document.getElementById('cod').value);
    var titulo = limpiarCaracteresEspeciales(document.getElementById('titulo').value);
    var tituloEn = limpiarCaracteresEspeciales(document.getElementById('tituloEn').value);
    var subtitutlo = limpiarCaracteresEspeciales(document.getElementById('subtitulo').value);
    var subtitutloEn = limpiarCaracteresEspeciales(document.getElementById('subtituloEn').value);
    var inciso = limpiarCaracteresEspeciales(document.getElementById('inciso').value);
    var incisoEn = limpiarCaracteresEspeciales(document.getElementById('incisoEn').value);
    var descinciso = limpiarCaracteresEspeciales(document.getElementById('descinciso').value);
    var descincisoEn = limpiarCaracteresEspeciales(document.getElementById('descincisoEn').value);
    var estado = limpiarCaracteresEspeciales(document.getElementById('estado').value);
    var nivel = limpiarCaracteresEspeciales(document.getElementById('nivel').value);
    var entrada = limpiarCaracteresEspeciales(CKEDITOR.instances.wikiDesc.getData());
    var entradaEn = limpiarCaracteresEspeciales(CKEDITOR.instances.wikiDescEn.getData());


    datos = 'codigo=' + codigo + '&modulo=' + modulo + '&codi=' + codi + '&titulo=' + titulo + '&subtitutlo=' + subtitutlo + '&inciso=' + inciso + '&descinciso=' + descinciso + '&estado=' + estado + '&entrada=' + entrada + '&nivel=' + nivel + '&entradaEn=' + entradaEn + '&tituloEn=' + tituloEn + '&subtituloEn=' + subtitutloEn + '&incisoEn=' + incisoEn + '&descincisoEn=' + descincisoEn;

    // alert(datos);

    $.ajax({
        url: '../wiki/ingresoWiki.php',
        type: 'POST',
        data: datos,
        success: function (resp) {
            $('#resultado').html(resp);
        }
    });

}

function modulosLlenar(nivel) {

    $.ajax({
        url: '../../php/llenarModulosPadres.php',
        type: 'POST',
        data: 'nivel=' + nivel,
        success: function (resp) {

            $('#modulos').html(resp);
            setTimeout(function () {

                document.getElementById('padre').addEventListener('change', function () {
                    document.getElementById('cod').value = (this.value);
                    document.getElementById('cod').disabled = true;
                });
            }, 1000);
        }


    });

}
function padresLlenar(nivel) {

    $.ajax({
        url: '../../php/llenarModulosPadres.php',
        type: 'POST',
        data: 'nivel=' + nivel,
        success: function (resp) {

            $('#modulos').html(resp);
        }


    });

}