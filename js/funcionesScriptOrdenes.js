/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function abrirOrdenes(codprov, pais, codpais, contador) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';
    ultimo = __('ultimoCont').innerHTML;
    pag = __('ultimoPag').innerHTML;
    if (pag > 1) {
        ultimo = 99;
    }
    pag = window.open("../php/ordenes/paginaOrdenes.php?codigo=" + codprov + "&pais=" + pais + "&cod=" + codpais + "&con=" + contador + "&ul=" + ultimo, "Ordenes", params);
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

function mostrarDetalleOrden(orderid, pais, codpais, codorden) {

    let params = {
        codorden:codorden,
        orderId:orderid,
        pais:pais,
        codpais:codpais,
        controller:"orden/detalle"
    }
    $.ajax({
            url:'../php/general/controladorGeneral.php',
            type:'GET',
            datatype:'json',
            data:params,
            success: function(response)
            {		
                var tr = $("#"+orderid+"Detail").closest('tr');
                if(tr.hasClass('row1Detalle')){
                    tr.removeClass('row1Detalle');
                }else{
                    tr.addClass('row1Detalle');
                    // tr.html(tr.html()+"<div id='divid'>este div es dinamico</div>");
                }
                response = JSON.parse(response);
                var trtd =$("#"+orderid+"Detail")
                var detalle = ''
                detalle += '<div class="row pl-5">'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">'+
                            'Nombre'+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            'Cantidad'+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            'Precio'+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            'Total'+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            'UPC'+
                        '</div>'+
                    '</div>';
                if(Array.isArray( response )){
                    response.forEach(element => {
                        detalle += '<div class="row pl-5">'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">'+
                            element.DISNAM+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            element.QTY+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            element.ORIUNIPRI+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            element.LINETOTAL+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            element.UPC+
                        '</div>'+
                    '</div>';
                    });
                }
                else{
                    detalle += '<div class="row pl-5">'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">'+
                            response.DISNAM+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            response.QTY+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            response.PRECIO+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            response.TOTAL+
                        '</div>'+
                        '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'+
                            response.UPC+
                        '</div>'+
                    '</div>';
                }
                if(trtd.hasClass('DivInternoOculto')){
                    trtd.removeClass('DivInternoOculto');
                    trtd.addClass('DivInterno');
                    trtd.html('<div class="rowInterno">'+detalle+'</div>')
                }else{
                    trtd.removeClass('DivInterno');
                    trtd.addClass('DivInternoOculto');
                    trtd.html('');
                }
            },
            error: element => {
                console.log(element);
                
            }
        });	
}

function cambiarOrden(tipo, num, pais, codigo, ul) {
    if (tipo == 1) {
        num++;
    }
    if (tipo == 2) {
        num--;
    }
    numOrd = window.opener.$('#numOrd' + num).html();
    window.location = "paginaOrdenes.php?codigo=" + numOrd + "&pais=" + pais + "&cod=" + codigo + "&con=" + num + "&ul=" + ul + "";
}

function envioDeDataOrdenes(es) {
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


    {
        llenarDatosOrdenes(codi, pais, cod);
    }


}

function llenarDatosOrdenes(codigo, pais, cod) {
    $.ajax({
        url: '../ordenes/buscarOrden.php',
        type: 'POST',
        data: 'codigo=' + codigo + '&pais=' + pais + '&codpais=' + cod + '&tipo=1',
        success: function(resp) {
            $('#resultado1').html(resp);
        }
    });
}

function llenarTablaOrdenes(codigo, pais, cod) {

    $.ajax({
        url: '../ordenes/buscarOrden.php',
        type: 'POST',
        data: 'codigo=' + codigo + '&pais=' + pais + '&codpais=' + cod + '&tipo=2',
        success: function(resp) {
            $('#ordenesCont').html(resp);
        }
    });
}

function llenarTablaCargosOrdenes(codigo, pais, cod) {

    $.ajax({
        url: '../ordenes/buscarOrden.php',
        type: 'POST',
        data: 'codigo=' + codigo + '&pais=' + pais + '&codpais=' + cod + '&tipo=3',
        success: function(resp) {
            $('#cargosOrden').html(resp);
        }
    });
}

function ingresoOrdenes() {

    var codigo = limpiarCaracteresEspeciales(document.getElementById('codigo').value);
    var notifica = limpiarCaracteresEspeciales(document.getElementById('notifica').value);
    var destino = limpiarCaracteresEspeciales(document.getElementById('destino').value);
    var condicion = limpiarCaracteresEspeciales(document.getElementById('condicion').value);
    var estatus = limpiarCaracteresEspeciales(document.getElementById('estado').value);
    var fechaini = limpiarCaracteresEspeciales(document.getElementById('fechaini').value);
    var fechafin = limpiarCaracteresEspeciales(document.getElementById('fechafin').value);
    /*var combo = (document.getElementById('pais'));
    var pais = combo.options[combo.selectedIndex].text;*/
    //alert(2);


    datos = 'codigo=' + codigo + '&notifica=' + notifica + '&destino=' + destino + '&condicion=' + condicion + '&estatus=' + estatus + '&fechaini=' + fechaini + '&fechafin=' + fechafin;

    $.ajax({
        url: '../notificaciones/ingresoNotificacion.php',
        type: 'POST',
        data: datos,
        success: function(resp) {
            $('#resultado').html(resp);
        }
    });

}