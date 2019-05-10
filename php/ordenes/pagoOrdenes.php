<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

function getProvsDrop()
{
    $q = "
        SELECT 
            dir.nompais, emp.nombre
        FROM
            direct AS dir
                INNER JOIN
            cat_empresas AS emp ON emp.pais = dir.codpais
        WHERE
            dir.codigo != '0';
    ";

    $r = mysqli_query(conexion(""), $q);

    $data = "<option disabled selected>select one...</option>";

    while ($row = mysqli_fetch_array($r)) {
//        echo "<br>$name<br>";
        $value = $row["nompais"];
        $name = $row["nombre"];
        $data .= "<option value='$value'>$name</option>";
    }

//    $data .= "<option value='$value'>$name</option>";

    $response = "<select id='emp' class='entradaTexto'  style='width: 100%'>$data</select>";

    return $response;
}

?>
<div id="container">
    <div id="tabs">
        <ul>
            <li><a href="#fragment-1">offline</a></li>
        </ul>
        <div id="fragment-1">
            <div id="controls">
                <div id="emps" class="colCont">
                    <b>Empresas</b><br>
                    <?php echo getProvsDrop(); ?>
                    <b>Separador</b><br>
                    <input id="separator" type="text" value="-" class="entradaTexto" style="width: 100%">
                </div>
                <div class="colCont">
                    <b>Proveedores</b><br>
                    <div id="provs">
                        <select style="width: 100%" class="entradaTexto">
                            <option disabled selected>select one...</option>
                        </select>
                    </div>
                </div>
                <div id="lists" class="colCont">
                    <input id="list" type="button" value="List" class="cmd button button-highlight button-pill">
                    <input id="generate" type="button" value="Generate" class="cmd button button-highlight button-pill">
                </div>
            </div>
            <br>
            <div id="message" style="clear: both"></div>
            <div id="responseContainer" style="clear: both;"></div>
        </div>
    </div>
</div>
<input disabled hidden id="currentDetailId" type="text">
<input disabled hidden id="currentOrderId" type="text">
<input disabled hidden id="currentProvId" type="text">
<div hidden id="details" title="invoice details">
    <div id="detailTabs">
        <ul>
            <li><a id="detailsFirstTab" href="#detailTab1">detail</a></li>
            <li><a href="#detailTab2">payment</a></li>
            <li><a href="#detailTab3">refund</a></li>
            <li><a href="#detailTab4">cancel</a></li>
            <li><a href="#detailTab5">delete</a></li>
        </ul>
        <div id="detailTab1">
            <div id="detailTabMessage" class="messageRow">
            </div>
            <div style="width: 100%; text-align: center; padding-top: 15px;" id="info">
                <div class="row">
                    <div class="col1">transaction id</div>
                    <div class="col2" id="det1"></div>
                </div>
                <div class="row">
                    <div class="col1">status</div>
                    <div class="col2" id="det2"></div>
                </div>
                <div class="row">
                    <div class="col1">tries</div>
                    <div class="col2" id="det3"></div>
                </div>
                <div class="row">
                    <div class="col1">date</div>
                    <div class="col2" id="det4"></div>
                </div>
                <div class="row">
                    <div class="col1">partial</div>
                    <div class="col2" id="det5"></div>
                </div>
                <div class="row">
                    <div class="col1">total</div>
                    <div class="col2" id="det6"></div>
                </div>
            </div>
        </div>
        <div id="detailTab2">
            <div id="paymentTabMessage" class="messageRow">
            </div>
            <div class="row">
                <div class="col1">amount</div>
                <div class="col2" id="det6">
                    <input id="payAmount" class="entradaTexto" type="number" value="0.00" step="0.01">
                </div>
            </div>
            <div class="row">
                <div class="colfull">
                    <input id="list" type="button" value="Pay" onclick="paymentTab()"
                           class="cmd button button-highlight button-pill">
                </div>
            </div>
        </div>
        <div id="detailTab3">
            <div id="refundTabMessage" class="messageRow">
            </div>
            <div class="row">
                <div class="col1">amount</div>
                <div class="col2" id="det6">
                    <input id="refundAmount" class="entradaTexto" type="number" value="0.00" step="0.01">
                </div>
            </div>
            <div class="row">
                <div class="colfull">
                    <input id="list" type="button" value="Refund" onclick="refundTab()"
                           class="cmd button button-highlight button-pill">
                </div>
            </div>
        </div>
        <div id="detailTab4">
            <div id="cancelTabMessage" class="messageRow">
            </div>
                <div class="row">
                    <div class="col1">subject</div>
                    <div class="col2">
                        <input id="cancelSubject" class="entradaTexto">
                    </div>
                </div>
                <div class="row">
                    <div class="col1">note</div>
                    <div class="col2">
                        <input id="cancelNote" class="entradaTexto">
                    </div>
                </div>
                <div class="row">
                    <div class="col1">notify merchant</div>
                    <div class="col2">
                        <input type="checkbox" id="cancelNotifyMerchant" class="entradaTexto">
                    </div>
                </div>
                <div class="row">
                    <div class="col1">notify payer</div>
                    <div class="col2">
                        <input type="checkbox" id="cancelNotifyPayer" class="entradaTexto">
                    </div>
                </div>
                <div class="row">
                    <div class="colfull">
                        <input id="cancel" type="button" value="Cancel" onclick="cancelTab()"
                               class="cmd button button-highlight button-pill">
                    </div>
                </div>
            </div>
            <div id="detailTab5">
                <div id="deleteTabMessage" class="messageRow">
                </div>
                <div class="row">
                    <div class="colfull">
                        <input id="cancel" type="button" value="Delete" onclick="deleteTab()"
                               class="cmd button button-highlight button-pill">
                    </div>
                </div>
            </div>
        </div>

        <!--
        <div style="width: 100%; text-align: center;" id="tools">
            <input id="refundInvoice" type="button" value="Refund" class="cmd button button-highlight button-pill horizontalStack">
            <input id="cancelInvoice" type="button" value="Cancel" class="cmd button button-highlight button-pill horizontalStack">
            <input id="deleteInvoice" type="button" value="Delete" class="cmd button button-highlight button-pill horizontalStack">
        </div>


        -->
    </div>


    <script>
        $(document).ready(function () {
            // $( "#tabs" ).tabs({ active: 0 });
            // $( "#detailTabs" ).tabs({ active: 0 });
        });

        $(function () {
            $("#tabs").tabs({
                heightStyle: "auto",
                activate: function (event, ui) {
                    if (ui.newTab.index() == 0) {
                        $("#emp").change();
                    }
                }
            }).css({
                'min-height': '400px',
                'overflow': 'auto'
            });
        });

        $(function () {
            $("#detailTabs").tabs({
                heightStyle: "auto",
                activate: function (event, ui) {
                    if (ui.newTab.index() == 0) {
                        detailTab($("#currentDetailId").val());
                    }
                    if (ui.newTab.index() == 1) {
                        $("#paymentTabMessage").html("");
                        $("#payAmount").val(0.00);
                    }
                    if (ui.newTab.index() == 2) {
                        $("#refundTabMessage").html("");
                        $("#refundAmount").val(0.00);
                    }
                    if (ui.newTab.index() == 3) {
                        $("#cancelTabMessage").html("");
                        $("#cancelSubject").val("");
                        $("#cancelNote").val("");
                        $("#cancelNotifyMerchant").prop("checked", false);
                        $("#cancelNotifyPayer").prop("checked", false);
                    }
                    if (ui.newTab.index() == 4) {
                        $("#deleteTabMessage").html("");
                    }
                }
            }).css({
                'min-height': '335px',
                'overflow': 'auto'
            });
        });

        $("#emp").change(function () {
            var emp = this.value;
            $.ajax({
                type: "POST",
                url: "../php/ordenes/orderOperations.php",
                data: {
                    method: "getProvsDrop",
                    country: emp,
                },
                success: function (response) {
                    // console.log(response);
                    $("#provs").html(response);
                }
            });
        });

        $("#list").click(function () {
            $("#message").html("");
                var prov = $("#prov").val();
                var emp = $("#emp").val();
                var separator = $("#separator").val();
            $("#responseContainer").html("<p>generating...</p>");
            $.ajax({
                type: "POST",
                url: "../php/ordenes/listFacturas.php",
                data: {
                    prov: prov,
                    emp: emp,
                    separator: separator,
                },
                success: function (response) {
                    // console.log(response);
                    $("#responseContainer").html(response);
                    if (response != 'no data...') {
                        // console.log("1");
                        $('#facTable').DataTable({
                            "paging": true,
                            "lengthMenu": [5, 10, 15],
                            "pageLength": 5,
                            "filter": false,
                            "info": false,
                            "scrollY": "300px",
                            "scrollCollapse": true,
                            "aaSorting": [[2, "desc"]],
                        });
                    }
                },
                error: function (response) {
                    console.log("EEE: " + JSON.stringify(response));
                }
            })
        });

        $("#generate").click(function () {
            var invoicesNew = [];
            var invoicesOld = [];
            $("input:checkbox[name='generate']:checked").each(function () {
                invoicesNew.push($(this).val());
            });
            $("input:checkbox[name='remind']:checked").each(function () {
                invoicesOld.push($(this).val());
            });

            console.log(invoicesNew);
            console.log(invoicesOld);

            remindInvoices(invoicesOld);
            generateInvoices(invoicesNew);
        });

        function sendInvoice(id, wd, separator) {
            $("#message").html("generating invoice...<br>");
            console.log(id);
            $.ajax({
                // url: "../php/paypalClas  sic/invoice-sdk-php-master/samples/generatePaypalInvoice.php",
                url: "../php/paypal/paypalAjax.php",
                type: "post",
                data: {
                    method: "generateInvoice",
                    id: id,
                    wd: wd,
                    separator: separator,
                },
                success: function (response) {
                    console.log("RJQ:" + response)
                    response = JSON.parse(response);
                    if (response.status != "ERROR") {
                        $("#message").append("SUCCESS! Invoice ID: " + response.message + "<br>");

                        // if (refresh) {
                            setTimeout(function () {
                                $("#list").click();
                            }, 5000);
                        // }
                    } else {
                        $("#message").append("ERROR... " + id + " - " + response.message + "<br>");
                    }
                },
                error: function (response) {
                    $("#message").append("ERROR... " + id + "<br>");
                }
            })
        }


        function remindInvoice(id, wd) {
            $("#message").html("generating invoice...<br>");
            $.ajax({
                // url: "../php/paypalClassic/invoice-sdk-php-master/samples/generatePaypalInvoice.php",
                url: "../php/paypal/paypalAjax.php",
                type: "post",
                data: {
                    method: "remindInvoice",
                    id: id,
                    wd: wd,
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.status != "ERROR") {
                        $("#message").append("SUCCESS! Invoice ID: " + response.message + "<br>");

                        // if (refresh) {
                            setTimeout(function () {
                                $("#list").click();
                            }, 5000);
                        // }
                    } else {
                        $("#message").append("ERROR... " + id + " - " + response.message + "<br>");
                    }
                },
                error: function (response) {
                    $("#message").append("ERROR... " + id + "<br>");
                }
            })
        }

        function generateInvoices(invoices) {
            $.each(invoices, function (index, value) {
                sendInvoice(value, false);
            });
        };

        function remindInvoices(invoices) {
            $.each(invoices, function (index, value) {
                remindInvoice(value, false);
            });
        };

        function detailInvoice(id, wd) {
            $("#currentDetailId").val(id);
            $("#details").dialog({
                width: 675,
                height: 400,
                modal: true,
                open: function () {
                    $("#detailTabs").tabs("option", "active", 0);
                    detailTab($("#currentDetailId").val(), wd);
                },
                title:"Invoice Details " + $("#currentDetailId").val(),
            });


            // $("#detailTabs").tabs("option", "active", 0);
            // $('#detailTabs a[href="#detailTab1"]')[0].click();
        }

        function cleanInvoice(id, wd) {
            $.ajax({
                // url: "../php/paypalClas  sic/invoice-sdk-php-master/samples/generatePaypalInvoice.php",
                url: "../php/paypal/paypalAjax.php",
                type: "post",
                data: {
                    method: "cleanInvoice",
                    id: id,
                    wd: wd,
                },
                success: function (response) {
                    console.log("RJQ:" + response)
                    response = JSON.parse(response);
                    if (response.status != "ERROR") {
                        $("#message").append("SUCCESS! Invoice ID: " + response.message + "<br>");

                        // if (refresh) {
                        setTimeout(function () {
                            $("#list").click();
                        }, 5000);
                        // }
                    } else {
                        $("#message").append("ERROR... " + id + " - " + response.message + "<br>");
                    }
                },
                error: function (response) {
                    $("#message").append("ERROR... " + id + "<br>");
                }
            })
        }


        function detailTab(id, wd) {

            $("#detailTabMessage").html("loading...");
            $("#det1").html("");
            $("#det2").html("");
            $("#det3").html("");
            $("#det4").html("");
            $("#det5").html("");
            $("#det6").html("");

            $.ajax({
                url: "../php/paypal/paypalAjax.php",
                type: "post",
                data: {
                    method: "statusInvoice",
                    id: id,
                    wd: wd,
                },
                success: function (response) {
                    console.log(response);
                    $("#detailTabMessage").html("");
                    response = JSON.parse(response);
                    // console.log(response.transaction);
                    // $("#det1").html(response.transaction);
                    $("#det2").html(response.message);
                    // $("#det3").html(response.tries);
                    // $("#det4").html(response.date);
                    // $("#det5").html(response.abonos);
                    // $("#det6").html(response.total);

                },
                error: function (response) {
                    $("#detailTabMessage").append("ERROR... " + id + "<br>");
                }
            });

            $.ajax({
                url: "../php/paypal/paypalAjax.php",
                type: "post",
                data: {
                    method: "detailInvoice",
                    id: id,
                    wd: wd,
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    console.log(response.transaction);
                    $("#det1").html(response.transaction);
                    // $("#det2").html("");
                    $("#det3").html(response.tries);
                    $("#det4").html(response.date);
                    $("#det5").html(response.abonos);
                    $("#det6").html(response.total);

                },
                error: function (response) {
                    $("#detailMessage").html("ERROR... " + id + "<br>");
                }
            });
        }

        function paymentTab() {

            var id = $("#currentDetailId").val();
            var amount = $("#payAmount").val();

            $("#paymentTabMessage").html("processing...");

            $.ajax({
                url: "../php/paypal/paypalAjax.php",
                type: "post",
                data: {
                    method: "payInvoice",
                    id: id,
                    amount: amount,
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.status == "SUCCESS") {
                        $("#paymentTabMessage").html("SUCCESS!");
                    } else {
                        $("#paymentTabMessage").html("ERROR... " + response.message);
                    }
                },
                error: function (response) {
                    $("#paymentTabMessage").append("ERROR... " + id + "<br>");
                }
            });
        }

        function refundTab() {

            var id = $("#currentDetailId").val();
            var amount = $("#refundAmount").val();

            $("#refundTabMessage").html("processing...");

            $.ajax({
                url: "../php/paypal/paypalAjax.php",
                type: "post",
                data: {
                    method: "refundInvoice",
                    id: id,
                    amount: amount,
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.status == "SUCCESS") {
                        $("#refundTabMessage").html("SUCCESS!");
                    } else {
                        $("#refundTabMessage").html("ERROR... " + response.message);
                    }
                },
                error: function (response) {
                    $("#refundTabMessage").append("ERROR... " + id + "<br>");
                }
            });
        }

        function cancelTab() {
            $("#cancelTabMessage").html("cancelling...");
            var id = $("#currentDetailId").val();
            var tSubject = $("#cancelSubject").val();
            var tNote = $("#cancelNote").val();
            var tNotifyMerchant = $("#cancelNotifyMerchant").is(":checked");
            var tNotifyPayer = $("#cancelNotifyPayer").is(":checked");

            $.ajax({
                type:"POST",
                url:"../php/paypal/paypalAjax.php",
                data:{
                    method:"cancelInvoice",
                    id:id,
                    subject:tSubject,
                    note:tNote,
                    notifyMerchant:tNotifyMerchant,
                    notifyPayer:tNotifyPayer,
                },
                success:function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.status == "SUCCESS") {
                        $("#cancelTabMessage").html("SUCCESS!");
                    } else {
                        $("#cancelTabMessage").html("ERROR... " + response.message);
                    }
                },
                error:function (response) {
                    $("#cancelTabMessage").html("error...");
                }
            });
        }

        function deleteTab() {
            $("#deleteTabMessage").html("deleting...");
            var id = $("#currentDetailId").val();

            $.ajax({
                type:"POST",
                url:"../php/paypal/paypalAjax.php",
                data:{
                    method:"deleteInvoice",
                    id:id,
                },
                success:function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.status == "SUCCESS") {
                        $("#deleteTabMessage").html("SUCCESS!");
                    } else {
                        $("#deleteTabMessage").html("ERROR... " + response.message);
                    }
                },
                error:function (response) {
                    $("#deleteTabMessage").html("error...");
                }
            });
        }
    </script>

    <style>
        #container {
            margin-left: 10%;
            width: 90%;
        }

        .colCont {
            width: 32%;
            margin: 0 5px 5px 0;
            float: left;
        }

        .horizontalStack {
            display: inline-block;
        }

        .row {
            width: 100%;
        }

        .messageRow {
            clear: left;
            width: 100%;
            text-align: center;
            font-weight: bold;
        }

        .col1 {
            width: 45%;
            float: left;
            text-align: right;
            font-weight: bold;
        }

        .col2 {
            width: 50%;
            float: left;
            text-align: left;
            margin-left: 5px;
        }

        .col31 {
            width: 32%;
            float: left;
            text-align: right;
            font-weight: bold;
            margin-right: 5px;
        }

        .col32 {
            width: 32%;
            float: left;
            text-align: left;
        }

        .col33 {
            width: 32%;
            float: left;
            text-align: left;
        }

        .colfull {
            width: 100%;
            text-align: center;
            padding-top: 15px;
        }
    </style>