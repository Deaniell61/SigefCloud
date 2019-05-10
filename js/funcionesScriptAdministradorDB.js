function agregarColumnaDBDB() {
    plataforma = document.getElementById('pla').value;
    DB = document.getElementById('db').value;
    tipo = document.getElementById('tipo').value;
    campo = document.getElementById('campo').value;
    tabla = document.getElementById('tablaDB').value;
    tam = document.getElementById('tam').value;
    nullll = document.getElementById('nullll').checked;
    AutoNum = document.getElementById('AutoNum').checked;
    pk = document.getElementById('PK').checked;
    existe = document.getElementById('existe').checked;
    existeC = document.getElementById('existeC').checked;
    existeN = document.getElementById('existeN').checked;
    nuevoCampo = document.getElementById('nuevoCampo').value;
    confirmar = "";
    //alert('pla='+plataforma+'&db='+DB+'&tipo='+tipo+'&campo='+campo+'&tabla='+tabla+'&tam='+tam+'&nullll='+nullll+'&AutoNum='+AutoNum+'&pk='+pk);
    if (existeC == true) {
        confirmar = confirm('Esta a punto de actualizar el campo ' + campo + ", seguro desea continuar?");
    }
    var data = 'pla=' + plataforma + '&db=' + DB + '&tipo=' + tipo + '&campo=' + campo + '&tabla=' + tabla + '&tam=' + tam + '&nullll=' + nullll + '&AutoNum=' + AutoNum + '&pk=' + pk + '&existe=' + existe + '&existeC=' + existeC + '&existeN=' + existeN + '&nuevoCampo=' + nuevoCampo;
    if (confirmar && existeC) {
        $.ajax({
            url: '../php/adminDB/ingresoColumna.php',
            type: 'POST',
            data: data,
            success: function(resp) {
                $('#resultado').html(resp);
            }
        });
    } else
    if (!existeC) {
        $.ajax({
            url: '../php/adminDB/ingresoColumna.php',
            type: 'POST',
            data: data,
            success: function(resp) {
                $('#resultado').html(resp);
            }
        });
    }
}

function limpiarAdminDB() {

    //document.getElementById('tipo').value = '';
    document.getElementById('campo').value = '';
    document.getElementById('tam').value = '';
    document.getElementById('nullll').checked = false;
    document.getElementById('AutoNum').checked = false;
    document.getElementById('PK').checked = false;
    document.getElementById('existeN').checked = false;
    if (document.getElementById('nuevoCampo').value != '') {
        document.getElementById('campo').value = document.getElementById('nuevoCampo').value;
    }
    document.getElementById('nuevoCampo').value = '';
    __('nuevoCampoRW').style.display = 'none';

    setTimeout(function() { document.getElementById('resultado').innerHTML = '' }, 1000);
}

function obtenerRSigef(obj) {
    if (obj.value == "R") {
        document.getElementById('db').value = "2";
    }

}