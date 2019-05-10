/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
function llamarReporte(tipo, dato) {
    dato = dato.value;

    switch (tipo) {

        case 1:
            {
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesCanal.php?param=" + dato + "'", 100);
                break;
            }
        case 2:
            {

                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReporteMarcas.php?param=" + dato + "'", 100);
                break;
            }
        case 3:
            {
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesProdLin.php?param=" + dato + "'", 100);
                break;
            }
        case 4:
            {
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReporteProductos.php?param=" + dato + "'", 100);
                break;
            }
        case 5:
            {
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesCanaltxt.php?param=" + dato + "'", 100);
                break;
            }
        case 6:
            {
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesCanalcsv.php?param=" + dato + "'", 100);
                break;
            }

        case 7:
            {
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesComercializacion.php?param=" + dato + "'", 100);
                break;
            }
        case 8:
            {
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesCanalCat.php?param=" + dato + "'", 100);
                break;
            }
        case 9:
            {
                var datos2 = __('cantBun').value;
                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesCanalProductos.php?param=" + dato + "&num=" + datos2 + "'", 100);
                break;
            }
        case 10:
            {

                var datos2 = "";
                var datos3 = "";
                var datos4 = "";

                if (document.getElementsByName('Export').item(0).checked) {
                    datos2 = document.getElementsByName('Export').item(0).value;
                } else {
                    datos2 = document.getElementsByName('Export').item(1).value;
                }
                if (document.getElementsByName('Tipo').item(0).checked) {
                    datos3 = document.getElementsByName('Tipo').item(0).value;
                } else {
                    datos3 = document.getElementsByName('Tipo').item(1).value;
                }
                if (document.getElementsByName('Codigo').item(0).checked) {
                    datos4 = document.getElementsByName('Codigo').item(0).value;
                } else {
                    datos4 = document.getElementsByName('Codigo').item(1).value;
                }

                setTimeout("location.href='../php/Reportes/precios/tiposReportes/ReportesCanalExportacion.php?canal=" + dato + "&accion=" + datos2 + "&tipo=" + datos3 + "&codigo=" + datos4 + "'", 100);
                break;
            }
        case 11:
            {
                datos2 = document.getElementById('buscaMasterSKU').value;
                setTimeout("location.href='../php/Reportes/productos/ReporteProductos.php?param=" + dato + "&sku=" + datos2 + "'", 100);
                break;
            }
        case 12:
            {
                datos2 = document.getElementById('buscar').value;
                setTimeout("location.href='../php/Reportes/ordenes/ReporteOrdenes.php?filtro=" + dato + "&busca=" + datos2 + "'", 100);
                break;
            }
        case 13:
            {
                datos2 = document.getElementById('FechaFinD').innerHTML;
                dato = document.getElementById('FechaIniD').innerHTML;
                setTimeout("location.href='../php/Reportes/ordenes/ReporteOrdenesD.php?inicio=" + dato + "&fin=" + datos2 + "'", 100);
                break;
            }
        case 14:
            {
                fin = document.getElementById('periFin').options[document.getElementById('periFin').selectedIndex].text;
                dato = document.getElementById('periIni').options[document.getElementById('periIni').selectedIndex].text;
                setTimeout("location.href='../php/Reportes/ventas/tiposReportes/ReporteEstadoCantidad.php?inicio=" + dato + "&fin=" + fin + "'", 100);
                break;
            }
        case 15:
            {
                fin = document.getElementById('periFin').options[document.getElementById('periFin').selectedIndex].text;
                dato = document.getElementById('periIni').options[document.getElementById('periIni').selectedIndex].text;
                setTimeout("location.href='../php/Reportes/ventas/tiposReportes/ReporteEstadoVentas.php?inicio=" + dato + "&fin=" + fin + "'", 100);
                break;
            }
        case 16:
            {
                fin = document.getElementById('periFin').options[document.getElementById('periFin').selectedIndex].text;
                dato = document.getElementById('periIni').options[document.getElementById('periIni').selectedIndex].text;
                setTimeout("location.href='../php/Reportes/ventas/tiposReportes/ReporteProductosCantidad.php?inicio=" + dato + "&fin=" + fin + "'", 100);
                break;
            }
        case 17:
            {
                fin = document.getElementById('periFin').options[document.getElementById('periFin').selectedIndex].text;
                dato = document.getElementById('periIni').options[document.getElementById('periIni').selectedIndex].text;
                setTimeout("location.href='../php/Reportes/ventas/tiposReportes/ReporteProductosVentas.php?inicio=" + dato + "&fin=" + fin + "'", 100);
                break;
            }
        case 18:
            {
                setTimeout("location.href='../php/Reportes/ventas/tiposReportes/Appeagle.php?param=_4Q90XMVNL'", 100);
                break;
            }


    }
}

function verRadio() {
    Expor = document.getElementsByName('Export');

    for (i = 0; i < Expor.length; i++) {
        if (Expor[i].checked == true) {

            switch (Expor[i].value) {
                case 'marcas':
                    {
                        llamarReporte(2, document.getElementById('marcas'));
                        break;
                    }
                case 'canal':
                    {
                        llamarReporte(1, document.getElementById('canal'));
                        break;
                    }
                case 'ProdLin':
                    {
                        llamarReporte(3, document.getElementById('ProdLin'));
                        break;
                    }
                case 'producto':
                    {
                        llamarReporte(4, document.getElementById('producto'));
                        break;
                    }
            }
        }
    }

}

function verRadioVentas() {
    ventana('cargaLoadVP', 300, 500);
    $('#firstLink').removeClass('in');
    $('#panelDefault > a').addClass('collapsed');
    Vventa = "";
    Vtipo = "";
    Ventas = document.getElementsByName('Ventas');
    
    
    {
        for (i = 0; i < Ventas.length; i++) {
            if (Ventas[i].checked == true) {

                Vventa = Ventas[i].value;

            }
        }

        Tipo = document.getElementsByName('Tipo');

        for (i = 0; i < Tipo.length; i++) {
            if (Tipo[i].checked == true) {

                Vtipo = Tipo[i].value;

            }
        }
        periFin = document.getElementById('periFin').options[document.getElementById('periFin').selectedIndex].text;
        periIni = document.getElementById('periIni').options[document.getElementById('periIni').selectedIndex].text;
        //alert(Vventa+' '+Vtipo+' '+periFin);


        if (Vventa == "Estado" && Vtipo == "Cantidad") {
            $.ajax({
                url: '../php/Reportes/ventas/Reportes/llenarVentas1.php',
                type: 'POST',
                data: 'Vventa=' + Vventa + '&Vtipo=' + Vtipo + '&periFin=' + periFin + '&periIni=' + periIni + '&tipo=1',
                success: function(resp) {
                    $('#datos').html(resp);
                }
            });
        } else
        if (Vventa == "Estado" && Vtipo == "Dolar") {
            $.ajax({
                url: '../php/Reportes/ventas/Reportes/llenarVentas2.php',
                type: 'POST',
                data: 'Vventa=' + Vventa + '&Vtipo=' + Vtipo + '&periFin=' + periFin + '&periIni=' + periIni + '&tipo=1',
                success: function(resp) {
                    $('#datos').html(resp);
                }
            });
        } else
        if (Vventa == "Producto" && Vtipo == "Cantidad") {
            $.ajax({
                url: '../php/Reportes/ventas/Reportes/llenarVentas3.php',
                type: 'POST',
                data: 'Vventa=' + Vventa + '&Vtipo=' + Vtipo + '&periFin=' + periFin + '&periIni=' + periIni + '&tipo=1',
                success: function(resp) {
                    $('#datos').html(resp);
                }
            });
        } else
        if (Vventa == "Producto" && Vtipo == "Dolar") {
            $.ajax({
                url: '../php/Reportes/ventas/Reportes/llenarVentas4.php',
                type: 'POST',
                data: 'Vventa=' + Vventa + '&Vtipo=' + Vtipo + '&periFin=' + periFin + '&periIni=' + periIni + '&tipo=1',
                success: function(resp) {
                    $('#datos').html(resp);
                }
            });
        }
    }

}
function generarAnalisisVenta(){
         ventana('cargaLoadVP', 300, 500);
        $('#firstLink').removeClass('in');
        $('#panelDefault > a').addClass('collapsed');
        periIni= document.getElementById('periIni').value;
        periFin= document.getElementById('periFin').value;
        $.ajax({
                url: '../php/Reportes/Aventas/Reportes/llenarReporteAnalisisV.php',
                type: 'POST',
                data: 'periFin=' + periFin + '&periIni=' + periIni + '&tipo=1',
                success: function(resp) {
                    $('#datos').html(resp);
                }
            });
}
function abrirOrdenesPorEstado(estado, pais, inicio, final, tipo, prod) {
    params = 'width=' + screen.width;
    params += ', height=' + screen.height;
    params += ', top=0, left=0'
    params += ', fullscreen=yes';
    params += ', location=yes';
    params += ', Scrollbars=YES';

    pag = window.open("../php/Reportes/ventas/paginaVentas.php?estado=" + estado + "&pais=" + pais + "&inicio=" + inicio + "&final=" + final + "&tipo=" + tipo + '&prod=' + prod, "Ordenes Por Estados", params);
    pag.focus();

}

function llenarOrdenesVentaEstado(estado, pais, inicio, final, tipo, prod) {
    if (tipo == '1') {
        $.ajax({
            url: '../../../php/Reportes/ventas/buscar/llenarEstados.php',
            type: 'POST',
            data: 'estado=' + estado + '&pais=' + pais + '&inicio=' + inicio + '&final=' + final + '&tipo=' + tipo + '&prod=' + prod,
            success: function(resp) {
                $('#ventasEstadoCont').html(resp);
            }
        });
    } else
    if (tipo == '2') {
        $.ajax({
            url: '../../../php/Reportes/ventas/buscar/llenarProducto.php',
            type: 'POST',
            data: 'estado=' + estado + '&pais=' + pais + '&inicio=' + inicio + '&final=' + final + '&tipo=' + tipo + '&prod=' + prod,
            success: function(resp) {
                $('#ventasEstadoCont').html(resp);
            }
        });
    }

}