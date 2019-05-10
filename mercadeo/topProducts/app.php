<?php
//include_once($_SERVER["DOCUMENT_ROOT"] . "/php/general/header.php");
$start = date("Y-m-d\TH:i:s", strtotime("-1 week"));
$end = date("Y-m-d\TH:i:s");
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <title>top products</title>
</head>
<body>
<div class="row mx-1 my-5">
    <div class="col-12">
        <h3>top products</h3>
    </div>
</div>
<div class="row mx-1">
    <div class="col-12 col-sm-6 col-md-3 p-2 border">
        <div class="form-group">
            <label for="date">start date</label>
            <input type="datetime-local"
                   class="form-control"
                   id="startDate"
                   name="startDate"
                   value="<?php echo $start ?>">
        </div>
        <div class="form-group">
            <label for="date">end date</label>
            <input type="datetime-local"
                   class="form-control"
                   id="endDate"
                   name="endDate"
                   value="<?php echo $end ?>">
        </div>
        <div class="form-group">
            <label for="sku">quantity</label>
            <input type="text"
                   class="form-control"
                   id="quantity"
                   name="quantity"
                   value="10">
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 p-2 border">
        <input id="prodAuto" type="checkbox" aria-label="Checkbox for following text input"> Valores Automaticos
        <button disabled id="addProd" class="btn btn-primary btn-block">Agregar Producto</button>
        <div class="form-group">
            <label for="sku">sku</label>
            <input disabled type="text"
                   class="form-control"
                   id="sku"
                   name="sku"
                   hint="sku">
        </div>
        <button disabled id="removeProd" class="btn btn-primary btn-block">Quitar Producto</button>
        <input type="text"
               class="form-control"
               id="skuList"
               name="skuList">
    </div>
    <div class="col-12 col-sm-6 col-md-3 p-2 border">
        <input id="stateAuto" type="checkbox" aria-label="Checkbox for following text input"> Valores Automaticos
        <button disabled id="addState" class="btn btn-primary btn-block">Agregar Estado</button>
        <div class="form-group">
            <label for="sku">estado</label>
            <input disabled
                   id="state"
                   type="text"
                   class="form-control"
                   id="state"
                   name="state"
                   hint="state">
        </div>
        <button disabled id="removeState" class="btn btn-primary btn-block">Quitar Estado</button>
    </div>
    <div class="col-12 col-sm-6 col-md-3 p-2 border">
        <button disabled id="genInfo" type="submit" class="btn btn-primary btn-block">Generar Informacion</button>
        <button id="sendMails" class="btn btn-primary btn-block">Lanzar envio de emails</button>
        <button class="btn btn-primary btn-block">Lanzar contenido FB</button>
        Promo <input type="file" name="promo" id="promo" value=""/>
    </div>
</div>
<div class="row mx-1">
    <div id="result1" class="col-12 border">
        <h3>tables 1</h3>
    </div>
</div>
<div class="row mx-1">
    <div class="col-12">
        <h3>footer</h3>
    </div>
</div>
</body>
</html>
<script>
    $(document).ready(function () {

        setTimeout(function () {
            $("#prodAuto").click();
            $("#stateAuto").click();
        }, 250);

        $("#prodAuto").change(
            function () {
                if ($(this).is(':checked')) {
                    disableProds(true);
                    disableStates(true);
                    $("#genInfo").prop("disabled", false);
                }
                else {
                    disableProds(false);
                    disableStates(true);
                    $('#stateAuto').prop('checked', true);
                    $("#genInfo").prop("disabled", true);
                }
                $("#result1").html("");
                $("#skuList").val("");
            });

        $("#stateAuto").change(
            function () {
                if ($(this).is(':checked')) {
                    disableProds(true);
                    disableStates(true);
                    $("#genInfo").prop("disabled", false);
                }
                else {
                    disableProds(true);
                    disableStates(false);
                    $('#prodAuto').prop('checked', true);
                    $("#genInfo").prop("disabled", true);
                }
                $("#result1").html("");
                $("#skuList").val("1002FBA','501989','501214','500553','501993','501988','500308','502502710','502503918','500914','");
            });

        function disableProds(type){
            $("#addProd").prop("disabled", type);
            $("#sku").prop("disabled", type);
            $("#removeProd").prop("disabled", type);
        }
        function disableStates(type){
            $("#addState").prop("disabled", type);
            $("#state").prop("disabled", type);
            $("#removeState").prop("disabled", type);
        }

        $("#addProd").click(function () {
            var tSku = $("#sku").val();
            if (tSku != "") {
                $("#sku").val("");
                $("#skuList").val($("#skuList").val() + tSku + ",");
            }
        });

        $("#genInfo").click(function (e) {
            $("#result1").html("<br><img src='../../images/loader.gif'/><br>");
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            var quantity = $("#quantity").val();
            $.ajax({
                type: "POST",
                url: "../mercadeo/topProducts/getTopProducts.php",
                data: {
                    method:"auto",
                    startDate: startDate,
                    endDate: endDate,
                    quantity: quantity,
                },
                success: function (response) {
                    $("#result1").html(response);
                    $('#topProducts1').DataTable({
                        searching: false,
                        lengthChange: false,
                        info: false,
                    });
                    $('#topStates1').DataTable({
                        searching: false,
                        lengthChange: false,
                        info: false,
                    });
                    $('#product1').DataTable({
                        searching: false,
                        lengthChange: false,
                        info: false,
                    });

                    var tSkuList = $('#topProducts1').DataTable().columns(1).data().eq(0);

                    for(var i = 0; i < tSkuList.length; i++){
                        $("#skuList").val($("#skuList").val() + tSkuList[i] + "','");
                    }
                },
                error: function (response) {
                    $("#result1").html("Ocurrio un error inesperado...");
                    console.log(response);
                }
            });
        });

        $("#addProd").click(function (e) {
            $("#result1").html("<br><img src='../../images/loader.gif'/><br>");
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            var skuList = $("#skuList").val();
            $.ajax({
                type: "POST",
                url: "../mercadeo/topProducts/getTopProducts.php",
                data: {
                    method:"skuList",
                    startDate: startDate,
                    endDate: endDate,
                    skuList: skuList,
                },
                success: function (response) {
                    $("#result1").html(response);
                    $('#topProducts1').DataTable({
                        searching: false,
                        lengthChange: false,
                        info: false,
                    });
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });
    });

    $("#sendMails").click(function (e) {
        var skuList = $("#skuList").val();
        $.ajax({
            type: "POST",
            url: "../mercadeo/topProducts/sendMails.php",
            data: {
                method:"sendMails",
                skuList: skuList,
            },
            success: function (response) {
                console.log("s: " + response);
            },
            error: function (response) {
                console.log("e: " + response);
            }
        });
    });

    function getProductTable(sku) {
        console.log(sku);
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var quantity = $("#quantity").val();
        $.ajax({
            type: "POST",
            url: "../mercadeo/topProducts/getTopProducts.php",
            data: {
                method:"singleProduct",
                sku: sku,
                quantity: quantity,
                endDate: endDate,
                startDate: startDate,
            },
            success: function (response) {
                $("#productContainer").html(response);
                $('#product1').DataTable({
                    searching: false,
                    lengthChange: false,
                    info: false,
                });
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
</script>