/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function formaDeEstibar(obd1, obd2, obd3, obd4) {
    clean1 = "";
    clean2 = "";
    clean3 = "";
    clean4 = "";

    if (obd1 != null) {
        obd1 = obd1.value;
        clean1 = obd1.replace('x', '');
    }

    if (obd2 != null) {
        obd2 = obd2.value;
        clean2 = obd2.replace('x', '');
    }

    if (obd3 != null) {
        obd3 = obd3.value;
        clean3 = obd3.replace('x', '');
    }

    if (obd4 != null) {
        obd4 = obd4.value;
        clean4 = obd4.replace('x', '');
    }

    console.log(clean1 + ' - ' + clean2 + ' - ' + clean3 + ' - ' + clean4);

    obder = (obd1 * obd2) + (obd3 * 1);
    if (obd2 != "") {

        obd2 = "x" + obd2;

    }
    if (obd3 != "") {

        obd3 = "x" + obd3;


    }
    if (obd4 != "") {


        obd4 = "x" + obd4;


    }
    // document.getElementById('CajasNivel').value = obder;
    obd = obd1 + obd2 + obd3 + obd4
    estiba = obd.replace(/ /gi, 'x');
    estiba = estiba.replace("x", "x");
    estiba = estiba.replace("x", "x");
    estiba = estiba.replace("x", "x");
    estiba = estiba.replace("x", "x");
    estiba = estiba.replace("x", "x");
    ultimo = estiba.substr(estiba.length - 1, estiba.length);

    var estibarMessage = 'No tenemos una imagen disponible para su configuracion en este momento, su informacion sera guardada y generaremos una imagen mas adelante.';

    if (ultimo != 's' && ultimo != 'x') {
        if (estiba == "") {
            document.getElementById('formaEstibar').src = "../../images/cajas/0x0x0x0.jpg";
            document.getElementById('estibarMessage').innerText = estibarMessage;
        }
        else {
            $.get(window.location.origin + "/images/cajas/" + estiba + ".jpg").done(function () {
                document.getElementById('formaEstibar').src = "../../images/cajas/" + estiba + ".jpg";
                document.getElementById('estibarMessage').innerText = "";
            }).fail(function () {
                document.getElementById('formaEstibar').src = "../../images/cajas/0x0x0x0.jpg";
                document.getElementById('estibarMessage').innerText = estibarMessage;
            })
        }
    }
}