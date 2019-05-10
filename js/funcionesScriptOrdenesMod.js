/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function recorreOrdenes() {
    ventana('cargaLoadVP', 300, 500);
    cont = 0;
    estado = document.getElementById('comEstado').options[document.getElementById('comEstado').selectedIndex].text;
    pais = document.getElementById('pais').options[document.getElementById('pais').selectedIndex].text;
    siHay = 0;
    conf = confirm("Se actualizara el estado de las ordenes seleccionadas.\n¿Desea continuar?");
    if (conf == true) {
        for (i = 1; i <= $('#tablas >tbody >tr').length; i++) {

            if (document.getElementById('CheckOrdenNum' + i)) { //alert('CheckOrdenNum'+i+" "+estado);

                if (document.getElementById('CheckOrdenNum' + i).checked) {
                    cont++;
                    siHay = 1;
                    codigo = document.getElementById('CheckOrdenNum' + i).value;


                    $.ajax({
                        url: '../php/ordenesMod/alteraOrden.php',
                        type: 'POST',
                        data: 'codigo=' + codigo + '&estado=' + estado + '&pais=' + pais,
                        success: function(resp) {
                            $('#resultado').html(resp);
                        }
                    });
                    document.getElementById('CheckOrdenNum' + i).checked = false;
                }
            }
        }
    }
    if ($('#tablas >tbody >tr').length < 1) {
        setTimeout(function() {
            $("#cargaLoadVP").dialog("close");
        }, 300);
    }
    if (siHay == 0) {
        setTimeout(function() {
            $("#cargaLoadVP").dialog("close");
        }, 300);
    }


}

function cambiarOrdenesCorrectas() {

    ventana('cargaLoadVP', 300, 500);
    conf = confirm("Se actualizara el estado de las ordenes incorrectas.\n¿Desea continuar?");
    pais = document.getElementById('pais').options[document.getElementById('pais').selectedIndex].text;
    cambiador = 0;
    if (conf == true) {
        for (i = 1; i <= $('#tablas >tbody >tr').length; i++) {

            if (document.getElementById('ActualState' + i) && document.getElementById('CorrectState' + i)) { //alert('CheckOrdenNum'+i+" "+estado);
                actual = document.getElementById('ActualState' + i).innerHTML.replace("<center>", "").replace('</center>', '');
                corecto = document.getElementById('CorrectState' + i).innerHTML.replace("<center>", "").replace('</center>', '');

                if (actual != corecto) {
                    cambiador = 1;
                    codigo = document.getElementById('CheckOrdenNum' + i).value;

                    $.ajax({
                        url: '../php/ordenesMod/alteraOrden.php',
                        type: 'POST',
                        data: 'codigo=' + codigo + '&estado=' + corecto + '&pais=' + pais,
                        success: function(resp) {
                            $('#resultado').html(resp);
                        }
                    });
                }

            }
        }
    }

    if ($('#tablas >tbody >tr').length < 1) {
        setTimeout(function() {
            $("#cargaLoadVP").dialog("close");
        }, 300);
    }
    if (cambiador == 0) {
        setTimeout(function() {
            $("#cargaLoadVP").dialog("close");
        }, 300);
    }


}

function marcarTodosChech() {

    for (i = 1; i <= $('#tablas >tbody >tr').length; i++) {

        if (document.getElementById('CheckOrdenNum' + i)) { //alert('CheckOrdenNum'+i+" "+estado);

            document.getElementById('CheckOrdenNum' + i).checked = true;


        }
    }
}