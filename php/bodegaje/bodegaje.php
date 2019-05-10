<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/products.php');
$tProducts = new products();
?>

<script src="/php/objects/products.js"></script>

<div class="contentOutter">
    <div class="contentInner">
        <div id="contentHeader"
             class="group">
            <!--master sku-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Master SKU
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input id="bodegajeMasterSKU"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--item code-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Item Code
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeItemCode"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--product name-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Product Name
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeProductName"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--unit per case-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Unit per Case
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeUnitPerCase"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>
        </div>


        <div id="contentBody"
             class="topSpace15 group">
            <!--title-->
            <div class="row bold">
                Warehouse Inventory
            </div>

            <!--OH Quantity-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    OH Quantity [+]
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeOHQuantity"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--PO Quantity-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    PO Quantity [+]
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajePOQuantity"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--SO Quantity-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    SO Quantity [-]
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeSOQuantity"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--BO Quantity-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    BO Quantity
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeBOQuantity"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--total quantity-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Total Quantity
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeTotalQuantity"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--store inventory-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Store Inventory
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input id="bodegajeStoreInventory"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--total store inventory-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Total Store Inventory
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeTotalStoreInventory"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--inventory to sc-->
            <div class="row">
                <div class="leftSide stackHorizontally alignRight">
                    Inventory to SC
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input id="bodegajeInventoryToSC"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>

            <!--master sku-->
            <div class="row topSpace15">
                <input type="button"
                       class="cmd button button-highlight button-pill"
                       value="Update">
            </div>

            <!--master sku-->
            <div class="row topSpace15">
                <div class="leftSide stackHorizontally alignRight">
                    Master SKU
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input id="bodegajeMasterSKUText"
                           type="text"
                           class="entradaTexto">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var curProd;

    function getProduct(callback) {
        var tSKU = $("#bodegajeMasterSKU").val();
        if (tSKU != "") {
            products.getProduct(callback, tSKU, 1);
        }
    }

    function getProductCallback(response) {
        if (response != 0) {
            curProd = response;
            console.log(curProd);
            $("#bodegajeProductName").val(response.PRODNAME);
            $("#bodegajeItemCode").val(response.ITEMCODE);
            $("#bodegajeUnitPerCase").val(response.UNIVENTA);

            $.ajax({
                url: "../php/objects/productsRequests.php",
                dataType: "json",
                data: {
                    method: "productSage",
                    term: request.term
                },
                success: function (data) {
                    response(data);
//                    console.log(data);
                }
            });
        }
        else {
            console.log('no existe');
        }
    }

    $("#bodegajeMasterSKU").autocomplete({
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
//                    console.log(data);
                }
            });
        },
        select: function (event, ui) {
            var d = ui.item.label.split(" - ");
            $("#bodegajeMasterSKU").val(d[0]);
            getProduct(getProductCallback)
            return false;
        },
        minLength: 3,
        maxShowItems: 10,
    });

    $("#bodegajeMasterSKU").focusout(function () {
        getProduct(getProductCallback)
    });
</script>

<style>
    .contentOutter {
        width: 100%;
    }

    .contentInner {
        max-width: 50%;
        margin: auto;
    }

    .row {
        text-align: center;
    }

    .leftSide {
        width: 50%;
        padding-right: 10px;
    }

    .rightSide {
        width: 50%;
    }

    .alignLeft {
        text-align: left;
    }

    .alignRight {
        text-align: right;
    }

    .bold {
        font-weight: bold;
    }

    .stackHorizontally {
        float: left;
    }

    .topSpace15 {
        margin-top: 15px;
    }

    .group {
        border: outset;
        border-width: 1px;
        border-radius: 10px;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    ul.ui-autocomplete {
        z-index: 1100;
        max-width: 500px;
        max-height: 400px;
        overflow-y: scroll;
        overflow-x: hidden;
        font-size: 12px;
    }
</style>