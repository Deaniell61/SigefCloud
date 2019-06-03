/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function cargarOrdenBodega(term){
   
    let data =  localStorage.getItem('detalleSigef')
    data = JSON.parse(data);
    
    let data1 = {
        term:term,
        controller: "cargar/upc"
    }
    // console.log(data);
    
    if(data.pendientes>0){
        ventana('esperaD',300,400);
        llenadoDeEspera('cargaLoad', 'esperaD');
        $.ajax({
            url: '../php/bodega/operations.php?controller='+data1.controller,
            type: 'POST',
            data: data1,
            success: function(resp) {
                if(resp){
                    if(data.Productos.Producto){
                        if(data.Productos.Producto.UPC == term ){
                            data.UPC=term;
                            data.agregadas+=1;
                            data.pendientes = + ( data.pendientes - data.agregadas );
                            $("#esperaD").dialog("close");
                            insertShipping(data);
                            // armarTablaOrdenes(data);
                        }
                        
                    }
                }
                
                // console.log('resp:',JSON.parse(resp));
                $('#productoId').val('')
                $('#productoId').focus()
            }
        });
    }else{
        alert('la orden se despacho correctamente')
    }
}

function insertShipping(data){
    
    let data1 = {
        term:data.UPC,
        detalle:data,
        controller: "insert/shipping"
    }
    // console.log(data);
    
    if(data.pendientes>=0){
        $.ajax({
            url: '../php/bodega/operations.php?controller='+data1.controller,
            type: 'POST',
            data: data1,
            success: function(resp) {
                buscarOrdenBodega(data.ORDERID)
                // console.log(JSON.parse(resp));
                
            }
        });
    }else{
        alert('La orden se despacho correctamente 2')
    }
}
function buscarOrdenBodega(term) {
    ventana('esperaD',300,400);
    llenadoDeEspera('cargaLoad', 'esperaD');
    let data = {
        term:term,
        controller: "buscar/orden"
    }
    $.ajax({
        url: '../php/bodega/operations.php?controller='+data.controller,
        type: 'POST',
        data: data,
        success: function(resp) {
            
            // console.log('se guardo:',resp);
            resp = JSON.parse(resp);
            resp.ORDERID = term;
            resp = JSON.stringify(resp)
            localStorage.setItem('detalleSigef',resp)
            resp = JSON.parse(resp);
            $("#esperaD").dialog("close");
            armarTablaOrdenes(resp);
            // console.log('se armo:',resp);
        }
    });
}
function armarTablaOrdenes(resp){
    ventana('esperaD',300,400);
    llenadoDeEspera('cargaLoad', 'esperaD');
    let data = "<center>"+
                "<div class=\"m-t-5\">"+
                "<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">"+
                    "<thead>"+
                    "<tr  class=\"titulo\">"+
                        "<th >Codigo Producto</th>"+
                        "<th>Descripcion Producto</th>"+
                        "<th>Cantidad</th>"+
                        "<th>Agregadas</th>"+
                        "<th>Pendientes</th>"+
                        "<th hidden></th>"+
                        
                        "</tr> </thead><tbody>";
    if(resp.length>1){
        resp.forEach(element => {
            
        });
    }else{
        // console.log('data',resp.pendientes);
        resp.agregadas = resp.agregadas?resp.agregadas:0;
        resp.pendientes = (resp.pendientes>=0)?resp.pendientes:+resp.QTY;
        let secondRow = "";
        
        if(resp.Productos.Producto){
            secondRow+= ""+
                "<div style=\"position:absolute;width: 80%;margin-left: 10%;\">"+
                "<table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">"+
                    "<thead>"+
                    "<tr  class=\"titulo\">"+
                        "<th >Codigo Producto</th>"+
                        "<th>Descripcion Producto</th>"+
                        "<th>UPC</th>"+
                        
                        "</tr> </thead>";
            secondRow+="<tr  id=\"OrdenDetNum"+(1)+"\">"+
            "<td><center>"+(resp.Productos.Producto.MASTERSKU)+"</center></td>"+
            "<td id=\"ActualState"+(1)+"\">"+(resp.Productos['Producto']?resp.Productos['Producto']['DESCSIS']:resp.Productos['DESCSIS'])+"</td>"+
            "<td>"+(resp.Productos.Producto.UPC)+"</td>"+
            "</tr>";
            secondRow+="</tbody></table></div>"+
            "";
        }
        // console.log(resp);
        
        data+="<tr  id=\"OrdenDetNum"+(1)+"\">"+
        "<td><center>"+(resp.PRODUCTID)+"</center></td>"+
        "<td id=\"ActualState"+(1)+"\">"+(resp.Productos['Producto']?resp.Productos['Producto']['DESCSIS']:resp.Productos['DESCSIS'])+"</td>"+
        "<td><center>"+resp.QTY+"</center></td>"+
        "<td>"+resp.agregadas+"</td>"+
        "<td>"+resp.pendientes+"</td>"+
        "<td style=\"position:absolute;width: 100%;left: 0;top: 15%;\">"+secondRow+"</td>"+
        
        "</tr>";
    }
    data+="</tbody></table></div>"+
    "</center>";
    $('#ordenesData').html(data);
    $(document).ready(function(){
        $("#esperaD").dialog("close");

        localStorage.setItem('detalleSigef',JSON.stringify(resp))

        $('#tablas').DataTable( {
                "scrollY": "300px",
                "scrollX": true,
                "paging":  true,
                "pageLength": 100,
                "info":     false,
                "oLanguage": {
            "sLengthMenu": " _MENU_ ",
            }
        } );
        
        ejecutarpie();
        
    });
    document.getElementById('tablas_length').style.display='none';
    $(".productoId").removeClass('hidden');
    setTimeout(function () {
        $('#productoId').focus();
        $("#esperaD").dialog("close");
    }, 300);
        
}
function llenarDatosDetalleOrdenBodega(codprod, pais, codprov) {
    periFin = document.getElementById('periFin').value;
    periIni = document.getElementById('periIni').value;
    let data = {
        prod:codprod,
        pais: pais,
        prov: codprov,
        periFin: periFin,
        periIni: periIni,
        controller: "tabla/detalle"
    }
    $.ajax({
        url: '../bodega/table.php',
        type: 'POST',
        data: data,
        success: function(resp) {
            $('#contPestanas').html(resp);
        }
    });
}


function ingresoProductoBodega() {

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