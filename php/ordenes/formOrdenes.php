<?php
header('Content-type: text/html; charset=UTF-8');
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');

session_start();
verTiempo3();

include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/products.php');
$tProducts = new products();
include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/dropdownBuilder/dropdownBuilder.php');
$tDropdownBuilder = new dropdownBuilder();

include_once ("upsCsv.php");
?>
<script src="../../js/jquery.tabletojson.min.js"></script>

<script>
    paisGlobal = "";
    codPaisGlobal = "";


    function buscar() {
        <?php if($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U'){
        ?>

        document.getElementById('pais').value = '<?php echo $_SESSION['CodPaisCod'];?>';

        <?php
        }?>
        nombre = document.getElementById('buscar').value;
        paisGlobal = pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        filtro = document.getElementById('filtro').value;
        codPaisGlobal = codpais = document.getElementById('pais').value;

        $.ajax({
            url: '../php/ordenes/llenarOrdenes.php',
            type: 'POST',
            data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais + '&filtro=' + filtro,

            success: function (resp) {
                $('#datos').html("");
                $('#datos').html(resp);

                //console.log(resp);
            },
            error: function (response) {
                console.log(response);
            }
        });
    }

    function buscare(e) {
        <?php if($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U'){
        ?>

        document.getElementById('pais').value = '<?php echo $_SESSION['CodPaisCod'];?>';


        <?php
        }?>
        nombre = document.getElementById('buscar').value;
        pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        filtro = document.getElementById('filtro').value;
        codpais = document.getElementById('pais').value;
        if (validateEnter(e)) {
            $.ajax({
                url: '../php/ordenes/llenarOrdenes.php',
                type: 'POST',
                data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais + '&filtro=' + filtro,

                success: function (resp) {
                    $('#datos').html("");
                    $('#datos').html(resp);
                }
            });
        }
    }

    /**/

    function openNewOrderForm() {
        if ($("#newOrderForm").hasClass("ui-dialog-content") &&
            $("#newOrderForm").dialog("isOpen")) {
            $("#newOrderForm").dialog("open");
        } else {
            $("#newOrderForm").dialog({
                width: 1200,
                height: 700,
                modal: true,
            });
        }



        $("#newOrderForm").tabs("option", "active", 0,null);

        $("#saveOrderButton").prop('disabled', false);

        $("#currentOrderId").val("");
        $("#orderid").val("");
        $("#date").val(new Date().toISOString().substr(0, 10));
//        $("#username").val("<?//= $_SESSION['user'] ?>//");
//        $("#firstname").val("<?//= $_SESSION['nom'] ?>//");
//        $("#lastname").val("<?//= $_SESSION['apel'] ?>//");\
        $("#username").val("");
        $("#Bfirstname").val("");
        $("#firstname").val("");
        $("#Blastname").val("");
        $("#lastname").val("");

//        $("#orderChannel").val("");
        //$("#paysta").val("");
//        $("#paymet").val("");
        $("#payrefnum").val("");

//        $("#site").val("");
        $("#paydat").val(new Date().toISOString().substr(0, 10));
        $("#channel").val("");

//        $("#shimetsel").val("");
//        $("#shista").val("");
        $("#shipdate").val(new Date().toISOString().substr(0, 10));
        $("#shifee").val("");

        //$("#shicou").val("");
        //$("#shipstate").val("");
        $("#shipcity").val("");
        $("#Bshipcity").val("");
        $("#shizipcod").val("");
        $("#BextraZipcode").val("");
        $("#shiadd1").val("");
        $("#BextraAddress1").val("");
        $("#shiadd2").val("");
        $("#BextraAddress2").val("");

        $("#status").val("");
        $("#tracking").val("");
        $("#shiamocar").val("");

        $("#subtotal").val("0");
        $("#shitot").val("0");
        $("#orddistot").val("0");
        $("#grandtotal").val("0");
        $("#totalQuantity").val("0");

        $("#Bshicou").val($("#Bshicou option:first").val());
        $("#Bshipstate").val($("#Bshipstate option:first").val());

        if(false){
            $("#username").val("t@t.t");
            $("#Bfirstname").val("t");
            $("#firstname").val("t");
            $("#Blastname").val("t");
            $("#lastname").val("t");

            $("#shipcity").val("t");
            $("#Bshipcity").val("t");
            $("#shizipcod").val("t");
            $("#BextraZipcode").val("t");
            $("#shiadd1").val("t");
            $("#BextraAddress1").val("t");
            $("#shiadd2").val("t");
            $("#BextraAddress2").val("t");
        }
    }

    function openWalmartOrders() {
        if ($("#walmartOrders").hasClass("ui-dialog-content") &&
            $("#walmartOrders").dialog("isOpen")) {
            $("#walmartOrders").dialog("open");
        } else {
            $("#walmartOrders").dialog({
                width: 1000,
                height: 500,
                modal: true,
            });
        }
    }

    function generateUSPSCSV() {
        window.open("http://desarrollo.sigefcloud.com/php/shipping/uspsCsvGenerator.php", "_blank");
    }

    function closeNewOrderForm() {
        $("#currentOrderId").val("");
        $("#orderid").val("");
        $("#date").val(new Date().toISOString().substr(0, 10));
//        $("#username").val("<?//= $_SESSION['user'] ?>//");
//        $("#firstname").val("<?//= $_SESSION['nom'] ?>//");
//        $("#lastname").val("<?//= $_SESSION['apel'] ?>//");
        $("#username").val("");
        $("#firstname").val("");
        $("#lastname").val("");

//        $("#orderChannel").val("");
//        $("#paysta").val("");
//        $("#paymet").val("");
        $("#payrefnum").val("");

//        $("#site").val("");
        $("#paydat").val("");
        $("#channel").val("");

//        $("#shimetsel").val("");
//        $("#shista").val("");
        $("#shipdate").val("");
        $("#shifee").val("");

        //$("#shicou").val("");
        //$("#shipstate").val("");
        $("#shipcity").val("");
        $("#shizipcod").val("");
        $("#shiadd1").val("");
        $("#shiadd2").val("");

        $("#status").val("");
        $("#tracking").val("");
        $("#shiamocar").val("");

        $("#subtotal").val("0");
        $("#shitot").val("0");
        $("#orddistot").val("0");
        $("#grandtotal").val("0");

        $('#newOrderData').DataTable().clear().draw();

        $("#newOrderForm").dialog('close');
    }

    $('#newOrderData').DataTable({
        "paging": false,
        "filter": false,
        "info": false,
        "scrollCollapse": true
    });

    $(function () {
        $("#newOrderForm").tabs({selected: 0});
    });

    function getProduct(callback) {

        var tSKU = $("#autocompleteProductInput").val();
//        console.log(tSKU);
        var tQuant = $("#quant").val();
        //console.log('<?//= $_SESSION['codprov']?>//');
        //console.log(tSKU);
        document.getElementById('prodInfo').innerHTML = "";
        if (tSKU != "") {
            products.getProduct(callback, tSKU, 1);
        }
    }

    function saveNewOrderForm() {
        $("#saveOrderButton").prop('disabled', true);
        var userid = checkUser($("#username").val());

        var orderid = $("#orderid").val();
        var date = $("#date").val();
        var username = $("#username").val();
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();

        var orderchannel = $("#orderChannel").val();
        var paysta = $("#paysta").val();
        var paymet = $("#paymet").val();
        var payrefnum = $("#payrefnum").val();

        var site = $("#site").val();
        var paydat = $("#paydat").val();
        var channel = $("#channel").val();

        var shimetsel = $("#shimetsel").val();
        var shista = $("#shista").val();
        var shipdate = $("#shipdate").val();
        var shifee = $("#shifee").val();

        var shicou = $("#shicou").val()
        var shipstate = $("#shipstate").val();
        var shipcity = $("#shipcity").val();
        var shizipcod = $("#shizipcod").val();
        var shiadd1 = $("#shiadd1").val();
        var shiadd2 = $("#shiadd2").val();

        var status = $("#status").val();
        var tracking = $("#tracking").val();
        var shiamocar = $("#shiamocar").val();

        var subtotal = $("#subtotal").val();
        var shitot = $("#shitot").val();
        var orddistot = $("#orddistot").val();
        var grandtotal = $("#grandtotal").val();
        var isrusord = $('#chkbox').is(':checked') ? "1" : "0";
        var codbod = $('#CODBOD').val();
        var torden = $("#TORDEN").val();

        // console.log('orderid:' + orderid);
        // console.log('date:' + date);
        // console.log('username:' + username);
        // console.log('firstname:' + firstname);
        // console.log('lastname:' + lastname);
        //
        // console.log('orderchannel:' + orderchannel);
        // console.log('paysta:' + paysta);
        // console.log('paymet:' + paymet);
        // console.log('payrefnum:' + payrefnum);
        //
        // console.log('site:' + site);
        // console.log('paydat:' + paydat);
        // console.log('channel:' + channel);
        //
        // console.log('shimetsel:' + shimetsel);
        // console.log('shista:' + shista);
        console.log('shipdate:' + shipdate);
        // console.log('shipfee:' + shifee);
        //
        // console.log('shicou:' + shicou);
        // console.log('shipcity:' + shipcity);
        // console.log('shipstate:' + shipstate);
        // console.log('shizipcod:' + shizipcod);
        //
        // console.log('status:' + status);
        // console.log('tracking:' + tracking);
        // console.log('shiamXocar:' + shiamocar);
        //
        // console.log('subtotal:' + subtotal);
        // console.log('shitot:' + shitot);
        // console.log('orddistot:' + orddistot);
        // console.log('grandtotal:' + grandtotal);


        var table = $('#newOrderData').tableToJSON();


        $.ajax({
            url: '../php/ordenes/newOrder.php',
            type: 'POST',
            data: {
                method: 'newOrder',

                orderid: orderid,
                date: date,
                username: username,
                firstname: firstname,
                lastname: lastname,

                orderchannel: orderchannel,
                paysta: paysta,
                paymet: paymet,
                payrefnum: payrefnum,

                site: site,
                paydat: paydat,
                channel: channel,

                shimetsel: shimetsel,
                shista: shista,
//                shista: "Unshipped",
                shipdate: shipdate,
                shifee: shifee,

                shicou: shicou,
                shipstate: shipstate,
                shipcity: shipcity,
                shizipcod: shizipcod,
                shiadd1: shiadd1,
                shiadd2: shiadd2,

                tracking: tracking,
                status: status,
                shiamocar: shiamocar,

                subtotal: subtotal,
                shitot: shitot,
                orddistot: orddistot,
                grandtotal: grandtotal,
                isrusord: isrusord,
                codbod: codbod,
                torden: torden,

                json: JSON.stringify(table),
            },
            success: function (resp) {
                var OldOrderId = resp.split("]")[1];
                // console.log("R:" + resp);
                $("#orderid").val(OldOrderId);

                setTimeout(function () {
                    $.ajax({
                        url: "../php/ordenes/orderOperations.php",
                        type: "post",
                        data: {
                            method: "orderToSellercloud",
                        },
                        success: function (response) {
                            console.log("Su " + response);
//                            console.log("!1");
                            var tResp = JSON.parse(response);

                            if(tResp.error){
                                alert("SELLERCLOUD ERROR: " + tResp.error);
                                closeNewOrderForm();
                            }else{
                                var NewOrderId = tResp.CreateNewOrderResult;
                                $.ajax({
                                    url: "../php/ordenes/orderOperations.php",
                                    type: "post",
                                    data: {
                                        method: "updateOrderId",
                                        newOI: NewOrderId,
                                        oldOI: OldOrderId,
                                    },
                                    success: function (response) {
                                        console.log("UPDATE ORDER ID" + response);
                                    }
                                });
                                openConfirmationDialog("ID : " + tResp.CreateNewOrderResult);
                                $("#orderid").val(response);
                                closeNewOrderForm();
                                openConfirmationDialog("guardando orden...");
                            }
                        },
                        error: function (response) {
//                            console.log("E " + JSON.stringify(response));
                            closeNewOrderForm();
                            openConfirmationDialog("ID : " + tResp.CreateNewOrderResult);
                        }
                    });
                }, 500);

            }
            ,
            error: function (resp) {
                console.log("error:" + resp);
            }
        });

    }

    function checkUser(username) {
        if (username != "") {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
//            console.log(firstname +  " " + lastname);
            $.ajax({
                url: "../php/ordenes/orderOperations.php",
                type: "post",
                data: {
                    method: "getUser",
                    username: username,
                },
                success: function (response) {
                    if (response == "0") {
                        $.ajax({
                            url: "../php/ordenes/orderOperations.php",
                            type: "post",
                            data: {
                                method: "saveUser",
                                username: username,
                                firstname: firstname,
                                lastname: lastname,
                            },
                            success: function (resp) {
//                                console.log(resp);
                            },
                            error: function (resp) {
//                                console.log(resp);
                            }
                        })
                        ;
                    }
                }
            });

            $.ajax({
                url: "../php/sellercloud/sellercloudOperations.php",
                type: "post",
                data: {
                    method: "getUser",
                    username: username,
                },
                success: function (response) {
//                    console.log(response);
//                    response = JSON.parse(response);
                    if (!response.hasOwnProperty("Customer_GetResult")) {
                        $.ajax({
                            url: "../php/sellercloud/sellercloudOperations.php",
                            type: "post",
                            data: {
                                method: "saveUser",
                                username: username,
                                firstname: firstname,
                                lastname: lastname,
                            },
                            success: function (response) {
//                                console.log("S" + response);
//                                console.log("S");
                            },
                            error: function (response) {
//                                console.log("E" + JSON.stringify(response));
                                console.log("E");
                            }
                        });
                    }
                },
            });
        }
    }
</script>
<center>
    <?php echo $lang[$idioma]['ordenes']; ?>
</center>
<aside>
    <div id="resultado"></div>
    <div class="controls">
        <div class="row">
            <div class="col">
                <input type="button" class='cmd button button-highlight button-pill'
                       onClick="document.getElementById('filtro').value='1';document.getElementById('buscar').value='';buscar();"
                       value="<?php echo $lang[$idioma]['Cancelar']; ?>"/>
                <input type="button" class='cmd button button-highlight button-pill'
                       onClick="window.location.href='inicioEmpresa.php'" value="<?php echo $lang[$idioma]['Salir']; ?>"/>
                <br>
                <select class='entradaTexto' style="" id="filtro" onChange="buscar();">
                    <option value="1" selected>Hoy</option>
                    <option value="8">Ultima semana</option>
                    <option value="2">Ultimas 24 horas</option>
                    <option value="4">Ultimos 3 dias</option>
                    <option value="8">Ultimos 7 dias</option>
                    <option value="15">Ultimos 14 dias</option>
                    <option value="32">Ultimos 31 dias</option>
                    <option value="60">Ultimos 60 dias</option>
                    <option value="90">Ultimos 90 dias</option>
                    <option value="120">Ultimos 120 dias</option>
                    <option value="13">Inicio de los tiempos</option>
                </select>
            </div>
            <div class="col grey">
                <input class='cmd button button-highlight button-pill' type="button"
                       onClick="openNewOrderForm();document.getElementById('orderDetTable').hidden=true;"
                       value="<?php echo $lang[$idioma]['newOrder'] ?>"/>

                <input type="text" class='entradaTexto' id="buscar" name="buscar"
                       placeholder="<?php echo $lang[$idioma]['Buscar'] ?>" value="" onKeyUp="buscare(event);"/>

                <input type="button" class='cmd button button-highlight button-pill' onClick="buscar();"
                       value="<?php echo $lang[$idioma]['Buscar'] ?>"/>

                <input class='cmd button button-highlight button-pill' type="button"
                       onClick="abrirNotificacion('',paisGlobal,codPaisGlobal);"
                       value="<?php echo $lang[$idioma]['Nuevo'] ?>"/>
            </div>
            <div class="col">

            </div>
            <div class="col grey">
                <span><?php echo $lang[$idioma]['grandtotal']; ?></span>
                <span id="totalGrid"></span>
                <br>
                <input class='cmd button button-highlight button-pill' type="button"
                       id="upsCsv_OpenDialog"
                       value="Shipping"/>
            </div>
        </div>
    </div>

    <div style="position:absolute; width:97%; top:160px; text-align:left; z-index:0;">
        <div class="guardar">

        </div>
    </div>
    <div style="position:absolute; width:97%; top:200px;">

    </div>
    <table>
        <tr <?php if ($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U') {
            echo "hidden";
        } ?>>
            <td colspan="4">
                <select class='entradaTexto' onChange="buscar();" id="pais" style="width:100%">
                    <?php echo paises(); ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <div class="">

                </div>
            </td>
            <td>

            </td>
            <td>
                <div class="">

                </div>
            </td>
            <td>
                <div class="">

                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center" colspan="4">

            </td>
        </tr>
    </table>
    <br><br><br>
</aside>
<div style="position:absolute; width:97%; top:310px; text-align:right;">

</div>
<div id="datos">
    <script>
        buscar();
    </script>
</div>
</div>
<div hidden id="newOrderForm" title="<?= $lang[$idioma]['newOrderFormTitle'] ?>">
    <!--top row buttons (save, etc)-->
    <div style="width: 100%; height: 40px; display: flex; justify-content: center;" id="buttons">
        <input id="saveOrderButton" style="float: left" type="button" class='cmd button button-highlight button-pill'
               onClick="saveNewOrderForm();" value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
        <input style="float: left" type="reset" class='cmd button button-highlight button-pill'
               onClick="closeNewOrderForm()" value="<?php echo $lang[$idioma]['Cancelar']; ?>"/>
    </div>
    <!--tab container-->
    <ul>
        <li onclick="document.getElementById('orderDetTable').hidden=true"><a href="#tabs-1"><?= $lang[$idioma]['ordertitle'] ?></a></li>
        <li onclick="document.getElementById('orderDetTable').hidden=true"><a href="#tabs-2"><?= $lang[$idioma]['shippingTitle'] ?></a></li>
        <li onclick="document.getElementById('orderDetTable').hidden=false"><a href="#tabs-3"><?= $lang[$idioma]['orderDetail'] ?></a></li>
    </ul>
    <div style="width: 100%; height: 225px;">
        <!--row1-->
        <!--<div style="width: 100%; text-align: center; font-weight: bold;"><?= $lang[$idioma]['ordertitle'] ?></div>-->
        <div id="tabs-1" style="width: 100%; height: 240px; display: flex;  justify-content: center;">
            
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div  class="frame">
                        <!--<div style="width: 100%; text-align: center; font-weight: bold;"><?= $lang[$idioma]['ordertitle'] ?></div>-->
                        <!--order id-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['orderId'] ?>
                            </div>
                            <div class="rightSide">
                                <input disabled
                                    type="text"
                                    id="orderid"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--date-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['date'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="date"
                                    id="date"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>


                        <!--order channel-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['orderChannel'] ?>
                            </div>
                            <div class="rightSide">
                                <input disabled
                                    type="text"
                                    id="orderChannel"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value="Local Store"/>
                            </div>
                        </div>
                        <!--payment status-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['paymentStatus'] ?>
                            </div>
                            <div class="rightSide">
                                <?php
                                $tDropdownBuilder->build("paysta", "NOMBRE", "NOMBRE", "NoPayment", "cat_pay_sta", 0, "WHERE APLICA = '1'");
                                ?>
                                <img id="test"
                                    src="/images/document_add.png"
                                    onclick="dropdownBuilder.openAddRecordForm('paymentStatusForm', 'paysta', $('#paysta').val(), true);"/>
                                <img id="test"
                                    src="/images/editar.png"
                                    width="21px"
                                    height="21px"
                                    onclick="dropdownBuilder.openAddRecordForm('paymentStatusForm', 'paysta', $('#paysta').val(), false);"/>
                            </div>
                        </div>
                        <!--payment method-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['paymentMethod'] ?>
                            </div>
                            <div class="rightSide">
                                <?php
                                $tDropdownBuilder->build("paymet", "NOMBRE", "NOMBRE", "Cash", "cat_pay_mdo", 0, "WHERE APLICA = '1'");
                                ?>
                            </div>
                        </div>
                        <!--payment ref number-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['paymentRefNumber'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="payrefnum"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div style="width: 350px; height: 35rem;" class="frame">
                        <div style="width: 100%; text-align: center; font-weight: bold;"></div>

                        <!--username-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['username'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="username"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--firstaname-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['firstname'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="Bfirstname"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--lastname-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['lastname'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="Blastname"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>

                        <!--shicou-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shicou'] ?>
                            </div>
                            <div class="rightSide">
                                <?php
                                $tDropdownBuilder->build("Bshicou", "CODECO", "NOMBRE", "Estados Unidos de América", "cat_country", 0,null);
                                ?>
                            </div>
                        </div>
                        <!--shipstate-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shipstate'] ?>
                            </div>
                            <div class="rightSide">
                                <?php
                                $tDropdownBuilder->build("Bshipstate", "CODIGO", "NOMBRE", "Alabama", "cat_estados", 0,null);
                                ?>
                            </div>
                        </div>
                        <!--shipcity-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shipcity'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="Bshipcity"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>

                        <!--zipcode-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['ZipCode'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="BextraZipcode"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>

                        <!--shiadd1-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shiadd1'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="BextraAddress1"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>

                        <!--shiadd2-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shiadd2'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="BextraAddress2"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>


                        <!--phone-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['Telefono'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="BextraPhone"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                   <div  class="frame">
                        <div style="width: 100%; text-align: center; font-weight: bold;"></div>
                        <!--site-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['site'] ?>
                            </div>
                            <div class="rightSide">
                                <input disabled
                                    type="text"
                                    id="site"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value="LS"/>
                            </div>
                        </div>
                        <!--paydate-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['paydate'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="date"
                                    id="paydat"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--channel-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['channel'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="channel"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--warehouse-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['Warehouse'] ?>
                            </div>
                            <div class="rightSide">
                                <?php
                                include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
                                $query = "SELECT CODBODEGA, UBICACION FROM cat_bodegas;";
                                $result = mysqli_query(conexion($_SESSION["pais"]), $query);
                                echo "<select id='CODBOD' class='entradaTextoDrop'>";
                                while ($row = mysqli_fetch_array($result)) {
        //                                $response[$row[0]] = $row[0];
                                    echo "<option value='$row[0]'>$row[1]</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                        </div>
                        <!--torden-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                Tipo de Orden
                            </div>
                            <div class="rightSide">
                                <select id="TORDEN" class="entradaTextoDrop">
                                    <option value="OFL">
                                        ORDER OFFLINE
                                    </option>
                                    <option value="TES">
                                        SAMPLES ORDER
                                    </option>
                                    <option value="SHI">
                                        SHIPPING ORDER
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!--                new fields-->

                        <!--company-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['company'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="extraCompany"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>


                        <!--firstname
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['firstname'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="extraFirstname"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
        -->
                        <!--lastname
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['lastname'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="extraLastname"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
        -->


                        <!--userID-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['id'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="extraUserID"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--TEST
                        <div style="width: 100%;">
                            <div class="leftSide">
                                TEST
                            </div>
                            <div class="rightSide">
                                <?php
                        $tDropdownBuilder->build("paises", "NOMBRE", "NOMBRE", "FreeEconom", "cat_country", 0,null);
                        ?>
                            </div>
                        </div>-->
                    </div> 
                </div>
            </div>
            
            <!--bloque1-->
            
            <!--bloque2-->
            
            <!--bloque3-->
            
        </div>
        <!-- row2 -->
        <!--<div id="tabs-2" style="width: 100%; text-align: center; font-weight: bold;"><?= $lang[$idioma]['shippingTitle'] ?></div>-->
        <div id="tabs-2" style="width: 100%; height: 235px; display: flex; justify-content: center;" id="inputs">
            <!--<div style="width: 250px; height: 225px; border-style: solid; border-width: 2px;">-->
            <style>
            .entradaTextoDrop{
                width: 100%!important;
            }
            .pt-3{
                padding-top:3rem;
            }
            .pt-5{
                padding-top:5rem;
            }
            .mb-3{
                margin-bottom:3rem;
            }
            </style>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                    <div style="width: 350px; height: 210px;" class="frame pt-3">
                        <!--shimetsel-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shimetsel'] ?>
                            </div>
                            <div  class="rightSide">
                                <?php
                                $tDropdownBuilder->build("shimetsel", "nombre", "nombre", "FreeEconom", "cat_shi_mdo", 0,null);
                                ?>
                            </div>
                        </div>
                        <!--shista-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shista'] ?>
                            </div>
                            <div class="rightSide">
                                <?php
                                $tDropdownBuilder->build("shista", "nombre", "nombre", "Unshipped", "cat_shi_sta", 0, "WHERE APLICA = '1'");
                                ?>
                            </div>
                        </div>
                        <!--shipdate-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shipdate'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="date"
                                    id="shipdate"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--shifee-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shifee'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="shifee"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--rusord-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['isrusord'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="checkbox"
                                    id="isrusord"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                    <div style="heigth:100%;" class="frame mb-3">
                        <!--firstaname-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['firstname'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="firstname"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--lastname-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['lastname'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="lastname"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--shicou-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shicou'] ?>
                            </div>
                            <div class="rightSide">
                                <?php
                                $tDropdownBuilder->build("shicou", "CODECO", "NOMBRE", "Estados Unidos de América", "cat_country", 0,null);
                                ?>
                            </div>
                        </div>
                        <!--shipstate-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shipstate'] ?>
                            </div>
                            <div  class="rightSide">
                                <?php
                                $tDropdownBuilder->build("shipstate", "CODIGO", "NOMBRE", "Alabama", "cat_estados", 0,null);
                                ?>
                            </div>
                        </div>
                        <!--shipcity-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shipcity'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="shipcity"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--shizipcod-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shizipcod'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="shizipcod"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--shiadd1-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shiadd1'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="shiadd1"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--shiadd2-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shiadd2'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="shiadd2"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>

                        <!--phone-->
                        <div style="width: 100%;">
                            <div class="leftSide">
                                <?= $lang[$idioma]['Telefono'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="extraPhone"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                    <div style="width: 350px; height: 210px;" class="frame pt-5">
                        <!--<div style="width: 100%; text-align: center; font-weight: bold;"><?= $lang[$idioma]['paytitle'] ?></div>-->
                        <!--tracking-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['tracking'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="tracking"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--status-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['status'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="status"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--shiamocar-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shiamocar'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="shiamocar"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>
                        <!--paysta
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['paysta'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="paysta"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>-->
                        <!--paydat
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['paydat'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="paydat"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>-->
                        <!--payrefnum
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['payrefnum'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="payrefnum"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>-->
                        <!--paymet
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['paymet'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="paymet"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>-->
                    </div>
                </div>
                
            </div>
            
            <!--ship1-->
            
            <!--ship2-->
            
            <!--ext-->
            
        </div>
        <!-- row3 -->
        <div id="tabs-3" class="row" style="width: 100%; height: 225px; justify-content: center;" id="inputs">
            
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div style="width: 350px; height: 210px;" class="frame">

                        <div style="width: 100%; text-align: center">
                            <div style="width: 100%">
                                <div class="leftSide">

                                </div>
                                <div class="rightSide">

                                </div>
                            </div>
                            <br>

                            <div style="width: 100%">
                                <input type="button" value="<?= $lang[$idioma]['Buscar'] ?>"
                                    onclick="getProduct(getProductCallback)"
                                    class="cmd button button-highlight button-pill"/>
                            </div>
                            <div style="width: 100%">
                                <div class="leftSide">

                                </div>
                                <div class="rightSide">

                                </div>
                            </div>
                            <div style="width: 100%">
                                <div class="leftSide">

                                </div>
                                <div class="rightSide" style="padding: 0px 0px 0px 15%">
                                    <div style="width: 166px">

                                    </div>
                                </div>
                            </div>
                            <div hidden id="nPrice" style="width: 100%">
                                <div class="leftSide">

                                </div>
                                <div class="rightSide" style="padding: 0px 0px 0px 15%">
                                    <div style="width: 166px; float:  left">

                                    </div>
                                    <img id="test"
                                        style="float: left"
                                        src="/images/add.png"
                                        onclick="setNPrice()"/>
                                    <p id="newPPResponse"></p>
                                </div>
                            </div>
                            <br>
                            <div style="width: 100%">

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="frame">
                        <!--subtotal-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['subtotal'] ?>
                            </div>
                            <div class="rightSide">
                                <input disabled
                                    type="text"
                                    id="subtotal"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value="0"/>
                            </div>
                        </div>
                        <!--shitot-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['shitot'] ?>
                            </div>
                            <div class="rightSide">
                                <input disabled
                                    type="text"
                                    id="shitot"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value="0"/>
                            </div>
                        </div>
                        <!--orddistot-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['orddistot'] ?>
                            </div>
                            <div class="rightSide">
                                <input
                                        type="text"
                                        id="orddistot"
                                        class='entradaTextoBuscar'
                                        placeholder=""
                                        value="0"/>
                            </div>
                        </div>
                        <!--cantidad-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['cantidad'] ?>
                            </div>
                            <div class="rightSide">
                                <input disabled
                                    type="text"
                                    id="totalQuantity"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value="0"/>
                            </div>
                        </div>
                        <!--grandtotal-->
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['grandtotal'] ?>
                            </div>
                            <div class="rightSide">
                                <input disabled
                                    type="text"
                                    id="grandtotal"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value="0"/>
                            </div>
                        </div>
                        <!--estatus
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['estatus'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="estatus"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>-->
                        <!--isrusord
                        <div style="width: 100%">
                            <div class="leftSide">
                                <?= $lang[$idioma]['isrusord'] ?>
                            </div>
                            <div class="rightSide">
                                <input type="text"
                                    id="isrusord"
                                    class='entradaTextoBuscar'
                                    placeholder=""
                                    value=""/>
                            </div>
                        </div>-->
                    </div>
                </div>
                
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div style="width: 350px; height: 210px;" class="frame">
                        <div>
                            <?= $lang[$idioma]['MasterSKU'] ?>
                            <!--
                            <?= $lang[$idioma]['MasterSKU'] ?>
                            <input type="text"
                                id="codprodinp"
                                class='entradaTextoBuscar'
                                placeholder=""
                                value=""/>
                            <input style="width: 166px" type="button" value="<?= $lang[$idioma]['Buscar'] ?>"
                                onclick="getProduct(getProductCallback)"
                                class="cmd button button-highlight button-pill"/>
                            -->
                            <input type="text"
                                id="autocompleteProductInput"
                                class='entradaTextoBuscar'
                                placeholder=""
                                value=""/>
                        </div>
                        <div style="width: 25%; height: 100%; float: left; padding: 10px">
                            <div id="prodInfo" style="font-size: 12px"></div>
                        </div>
                        <div >
                            <?= $lang[$idioma]['unidadDespacho'] ?>
                            <?php
                            $tDropdownBuilder->build("unidespa", "CODUNIDES", "NOMBRE", "", "cat_uni_des", 0,null);
                            ?>
                        </div>
                        <div >
                            <?= $lang[$idioma]['qty'] ?>
                            <input type="text"
                                id="quant"
                                class='entradaTextoBuscar'
                                placeholder=""
                                value="0"/>
                        </div>
                        <div >
                            Precio
                            <input type="text"
                                id="newPPrice"
                                class='entradaTextoBuscar'
                                placeholder=""
                                value="0"/>
                        </div>
                        <div style="width: 15%; height: 100%; float: left; margin-top: 15px">
                            <input type="button" value="<?= $lang[$idioma]['Agregar'] ?>" onclick="addProductToTable()"
                                class="cmd button button-highlight button-pill"/>
                        </div>
                        <!--                <input type="text" class="entradaTexto">-->
                    </div>
                </div>
                
                
            </div>
            
            
    </div>
    <!--table with order detail-->
    <div ID="orderDetTable" style="margin-top: 20px; width: 100%;">
        <table id="newOrderData" class="dataTable">
            <thead>
            <tr>
                <th width="10%"><?= $lang[$idioma]['productid'] ?></th>
                <th width="50%"><?= $lang[$idioma]['disnam'] ?></th>
                <th width="8%">Unidad</th>
                <th width="8%"><?= $lang[$idioma]['qty'] ?></th>
                <th width="5%"><?= $lang[$idioma]['oriunipri'] ?></th>
                <th width="5%"><?= $lang[$idioma]['linetotal'] ?></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!--hidden aux inputs-->
    <input disabled hidden type="text" id="validProduct" value="0">
</div>
<div hidden id="confirmationDialog">
    <div style="text-align: center; vertical-align: middle; transform: translateY(-50%);" id="confirmationMessage">
    </div>
</div>
<div hidden id="walmartOrders">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</div>
<script src="/php/objects/products.js"></script>
<script>
    curProd = '';


    function openConfirmationDialog(message) {
        if ($("#confirmationDialog").hasClass("ui-dialog-content") &&
            $("#confirmationDialog").dialog("isOpen")) {
            $("#confirmationDialog").dialog("open");
        } else {
            $("#confirmationDialog").dialog({
                width: 350,
                height: 250,
                modal: true,
            });
        }

        $("#confirmationMessage").html(message);

        setTimeout(function () {
            $("#confirmationDialog").dialog('close')
        }, 3000);
    }


    function getProductCallback(response) {
        // console.log("CH:" + JSON.stringify(response));
        if (response != 0) {

            var univenta1 = response['UNIVENTA'];
            var cajanivel1 = response['CAJANIVEL'];
            var nivpalet1 = response['NIVPALET'];

            if (univenta1 == "0") {
                $('#unidespa option[value="CA"]').attr("disabled", true);
            } else {
                $('#unidespa option[value="CA"]').attr("disabled", false);
            }

            if (cajanivel1 == "0" && nivpalet1 == "0") {
                $('#unidespa option[value="PA"]').attr("disabled", true);
            } else {
                $('#unidespa option[value="PA"]').attr("disabled", false);
            }

            curProd = response;
            document.getElementById('prodInfo').innerHTML = response['PRODNAME'];
//            console.log("H:" + response['SUGSALPRI'] + " - " + response['SUGSALPRIC'] + " - " + response['PVENTA']);
            $("#validProduct").val("1");
//            var tResponse = JSON.parse(response);
            var sugsalpric = parseFloat(response['SUGSALPRIC']).toFixed(2);
            var sugsalpri = parseFloat(response['SUGSALPRI']).toFixed(2);
//            console.log(sugsalpric + " - " + sugsalpri);
            if (sugsalpric > sugsalpri) {
                $("#newPPrice").val(sugsalpric);
            }
            else {
                $("#newPPrice").val(sugsalpri);
            }
            if (response.PVENTA = '0.00000') {
                $("#nPrice").prop("hidden", false);
            } else {
                $("#nPrice").prop("hidden", true);
            }
        }

        else {
            console.log('no existe');
            document.getElementById('prodInfo').innerHTML = "Producto no existe";
            $("#validProduct").val("0");
        }
    }

    function addProductToTable() {

        var tQuant = $("#quant").val();
        var tPrice = $("#newPPrice").val();
        var tSKU = $("#codprodinp").val();
//        console.log(tSKU + "-" + tQuant);
        if ($("#validProduct").val() == "1" && curProd != null && tQuant > 0 && tPrice > 0) {
            $.ajax({
                url: '../php/objects/productsRequests.php',
                type: 'post',
                data: {
                    method: 'getPriceByDistribution',
                    masterSKU: tSKU,
                    quantity: tQuant,
                },
                success: function (res) {
                    console.log(res);
                    res = JSON.parse(res);
                    var response = curProd;
                    var table = document.getElementById('orderDetTable').getElementsByTagName('tbody')[0];
                    var row = table.insertRow(0);

                    var cel1 = row.insertCell(0);
                    var cel2 = row.insertCell(1);
                    var cel3 = row.insertCell(2);
                    var cel4 = row.insertCell(3);
                    var cel5 = row.insertCell(4);
                    var cel6 = row.insertCell(5);

                    cel1.innerHTML = $("#autocompleteProductInput").val(); // response['MASTERSKU']
                    cel2.innerHTML = response['PRODNAME'];
                    cel3.innerHTML = tQuant + " - " + $("#unidespa option:selected").text();
                    cel4.innerHTML = tQuant;

                    var pv = response['PVENTA'];
                    if (res != '0') {
                        pv = res;
                    }

                    var tprice = parseFloat($("#newPPrice").val()).toFixed(2);
                    var pt = parseFloat($("#newPPrice").val()) * parseInt(tQuant);
                    pt = parseFloat(pt).toFixed(2);
                    cel5.innerHTML = tprice;
                    cel6.innerHTML = (pt).toString();

                    var tsub = parseFloat(pt) + parseFloat($("#subtotal").val());
                    if ($("#TORDEN").val() == "TES" || $("#TORDEN").val() == "SHI") {
                        console.log("descuento:"+tsub);
                        $("#orddistot").val(tsub.toFixed(2));
                    }
                    else {
                        $("#orddistot").val("0");
                    }

                    $("#totalQuantity").val(parseInt($("#totalQuantity").val()) + parseInt(tQuant));

                    var tgtot = parseFloat(tsub) - parseFloat($("#shitot").val()) - parseFloat($("#orddistot").val());
                    $("#subtotal").val(tsub.toFixed(2));
                    $("#orddistot").val(tgtot.toFixed(2));
                    $("#grandtotal").val(tgtot.toFixed(2));

                    document.getElementById("prodInfo").innerHTML = "";
                    curProd = null;
                    $("#codprodinp").val('');
                    $("#quant").val('0');
                    $("#autocompleteProductInput").focus();
                    $("#validProduct").val("0");
                    $("#newPPrice").val("0");
                    $("#autocompleteProductInput").val("");
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    }

    function setNPrice() {
//        console.log($("#newPPrice").val());
        $.ajax({
            url: '../php/objects/productsRequests.php',
            type: 'post',
            data: {
                method: 'setPVenta',
                masterSKU: $("#codprodinp").val(),
                price: $("#newPPrice").val(),
            },
            success: function (res) {
//                console.log(res);
                $("#newPPResponse").html("precio guardado");
                setTimeout(function () {
                    $("#newPPResponse").html("");
                }, 1500);
            },
            error: function (response) {
                console.log("error")
                $("#newPPResponse").html("error al guardar precio");
                setTimeout(function () {
                    $("#newPPResponse").html("");
                }, 1500);
            }
        });
    }

    //$("#paysta").prop("disabled", true);

    $("#autocompleteProductInput").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "../php/objects/productsRequests.php",
                dataType: "json",
                data: {
                    method: "searchProduct",
                    term: request.term
                },
                success: function (data) {
                    response(data);
                    // console.log(data);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        },
        select: function (event, ui) {
            var d = ui.item.label.split(" - ");
            $("#autocompleteProductInput").val(d[0]);
            getProduct(getProductCallback)
            return false;
        },
        minLength: 3,
        maxShowItems: 10,
    });

    $("#autocompleteProductInput").focusout(function () {
        getProduct(getProductCallback)
    });

    $("#TORDEN").change(function () {
//        console.log(this.value);
        if (this.value == "TES" || this.value == "SHI") {
            $("#paysta").val("Charged").change();
        }
        else {
            $("#paysta").val("NoPayment").change();
        }
    });

    $("#Bfirstname").change(function () {
        $("#firstname").val($("#Bfirstname").val());
    });
    $("#Blastname").change(function () {
        $("#lastname").val($("#Blastname").val());
    });
    $("#Bshipcity").change(function () {
        $("#shipcity").val($("#Bshipcity").val());
    });
    $("#BextraZipcode").change(function () {
        $("#shizipcod").val($("#BextraZipcode").val());
    });
    $("#BextraAddress1").change(function () {
        $("#shiadd1").val($("#BextraAddress1").val());
    });
    $("#BextraAddress2").change(function () {
        $("#shiadd2").val($("#BextraAddress2").val());
    });
    $("#BextraPhone").change(function () {
        $("#extraPhone").val($("#BextraPhone").val());
    });
    $("#Bshicou").change(function () {
        $("#shicou").val($("#Bshicou").val());
    });
    $("#Bshipstate").change(function () {
        $("#shipstate").val($("#Bshipstate").val());
    });
</script>
<style>
    .leftSide {
        text-align: right;
        float: left;
        width: 35%;
        font-size: 12px;
    }

    .rightSide {
        float: left;
        width: 50%;
        font-size: 12px;
    }

    .frame {
        border: outset;
        border-width: 1px;
        border-radius: 10px;
        height: 30rem;
        padding-top: 3rem;
    }

    .dataTables_empty {
        display: none;
    }

    ul.ui-autocomplete {
        z-index: 1100;
        max-width: 500px;
        max-height: 400px;
        overflow-y: scroll;
        overflow-x: hidden;
        font-size: 12px;
    }

    .controls{
        height: 75px;
    }

    .row{
        width: 100%;
        height: 100%;
    }

    .col{
        width: 25%;
        height: 100%;
        float: left;
    }

    .grey{
        background-color: white;
    }
</style>