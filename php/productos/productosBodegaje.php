<?php
session_start();

if(!isset($_SESSION["updateTraExi"])){
    $_SESSION["updateTraExi"] = 0;
}

if($_SESSION["updateTraExi"] == 0){
    $updateButtonStatus = "disabled";
}
else if($_SESSION["updateTraExi"] == 1){
    $updateButtonStatus = "";
    $_SESSION["updateTraExi"] = 0;
}

//echo $_SESSION["updateTraExi"];

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/products.php');
$tProducts = new products();

$codEmpresa = $_POST["codEmpresa"];
$icode = $_POST["icode"];
$pais = $_POST["pais"];

$productQuery = "
    SELECT 
        *, SUM(t.EXISTENCIA) AS sumexistencia, p.ESTATUS as ES
    FROM
        cat_prod AS p
            INNER JOIN
        sageinventario AS s ON p.MASTERSKU = s.productid
            INNER JOIN
        tra_exi_pro AS t ON p.codprod = t.codprod
    WHERE
        p.MASTERSKU = '$icode';
";

$productResult = mysqli_query(conexion($_SESSION["pais"]), $productQuery);
$productRow = mysqli_fetch_array($productResult);
//var_dump($productRow);
$productItemCode = $productRow["ITEMCODE"];
$productName = $productRow["PRODNAME"];
$productUnitPerCase = $productRow["UNIVENTA"];
$productOH = $productRow["QTYONHAND"];
$productPO = $productRow["QTYPURCHAS"];
$productSO = $productRow["QTYSALESOR"];
$productBO = $productRow["QTYBACKOR"];
$productStatus = ($productRow["ES"] == "A") ? "checked" : "";
if($productRow["ES"] == "A"){
    $productStatusMessage = "ALTA";
    $productStatusMessageStyle = "mALTA";
}
else{
    $productStatusMessage = "BAJA";
    $productStatusMessageStyle = "mBAJA";
}
$productTotalQuantity = intval($productRow["QTYONHAND"]) + intval($productRow["QTYPURCHAS"]) - intval($productRow["QTYSALESOR"]) - intval($productRow["QTYBACKOR"]);
$productTotalUnityQuantity = (intval($productRow["QTYONHAND"])  - intval($productRow["QTYSALESOR"])) * intval($productRow["UNIVENTA"]);
$productStoreInventory = $productRow["sumexistencia"];
//$productTotalStoreInventory = ($productRow["QTYONHAND"] > 0) ? $productStoreInventory : "0";
$productTotalStoreInventory = intval($productTotalUnityQuantity) + intval($productStoreInventory);
$productInventoryToSC = ($productRow["PHYSICALIN"] != $productTotalStoreInventory) ? $productTotalStoreInventory : $productRow["PHYSICALIN"];

function exiTable() {
    global $icode;
    $query = "
        SELECT 
            *, b.NOMBRE as bodname
        FROM
            tra_exi_pro AS e
                INNER JOIN
            cat_bodegas AS b ON e.codbodega = b.codbodega
                INNER JOIN
            cat_prod AS p ON p.codprod = e.codprod
        WHERE
            p.MASTERSKU = '$icode'; 
    ";

    $result = mysqli_query(conexion($_SESSION["pais"]), $query);
    while ($row = mysqli_fetch_array($result)) {
        $tBodega = $row["bodname"];
        $tExistencia = $row["EXISTENCIA"];
        $tCod = $row["CODEPROD"];
        $tBody .= "
            <tr>
                <td>$tBodega</td>
                <td><input id='traexiinput$tCod' type='text' value='$tExistencia'><a href='#'><image class='exiedit' editid='$tCod' src='../../images/yes.jpg'></image></a></td>
                <td><a href='#'><image class='exidel' delid='$tCod' src='../../images/document_delete.png'></image></a></td>
            </tr>
        ";
    }

    return $tBody;
}

?>

<script src="/php/objects/products.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script>
    seleccion(document.getElementById('Tabinventario'));
    setTimeout(function () {
        $("#cargaLoad").dialog("close");
    }, 500);
</script>

<div class="contentOutter">
    <div class="contentInner">
        <div id="contentHeader"
             class="group">
            <!--master sku-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    Master SKU
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeMasterSKU"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $icode ?>>
                </div>
            </div>

            <!--item code-->
            <div class="row50 stackHorizontally">
                <div class="leftSide stackHorizontally alignRight">
                    Item Code
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeItemCode"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productItemCode ?>>
                </div>
            </div>

            <!--product name-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    Product Name
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeProductName"
                           type="text"
                           class="entradaTexto fullWidthInput"
                           value= <? echo $productName ?>>
                </div>
            </div>

            <!--unit per case-->
            <div class="row50 stackHorizontally">
                <div class="leftSide stackHorizontally alignRight">
                    Unit per Case
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeUnitPerCase"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productUnitPerCase ?>>
                </div>
            </div>

            <!--product name-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    Estatus
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input id="productStatus"
                           type="checkbox"
                           class="entradaTexto"
                           style="float: left;"
                           <?php echo $productStatus ?>>
                    <span class="<?php echo $productStatusMessageStyle ?>" id="statusMessage"><?php echo $productStatusMessage ?></span>
                </div>
            </div>
        </div>

        <div id="exiTable"
             class="group topSpace15">
            <div id="exiproResponse"></div>
            <table id="exiProTable">
                <thead>
                <tr>
                    <td>Bodega</td>
                    <td>Existencia</td>
                    <td>Borrar</td>
                </tr>
                </thead>
                <tbody>
                <?php
                echo exiTable();
                ?>
                </tbody>
            </table>

        </div>


        <div id="contentBody"
             class="topSpace15 group">
            <!--title-->
            <div class="row bold">
                Warehouse Inventory
            </div>
            <!--update button-->
            <div class="row">
                <input <?php echo $updateButtonStatus?> id="updateInventoryButton"
                       type="button"
                       class="cmd button button-highlight button-pill"
                       value="Update">
            </div>

            <div class="topSpace15"></div>
            
            <div class="row">
                
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    Iventario Mayaland
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    Iventario Guatedirect
                </div>
                
            </div>
            
            <!--OH Quantity-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    OH Quantity [+]
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeOHQuantity"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productOH ?>>
                </div>
            </div>

            <!--total unity quantity-->
            <div class="row50 stackHorizontally">
                <div class="leftSide stackHorizontally alignRight">
                    Total Unity Quantity (OH * UC)
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeTotalQuantity"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productTotalUnityQuantity ?>>
                </div>
            </div>

            <!--PO Quantity-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    PO Quantity [+]
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajePOQuantity"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productPO ?>>
                </div>
            </div>

            <!--store inventory-->
            <div class="row50 stackHorizontally">
                <div class="leftSide stackHorizontally alignRight">
                    Store Inventory
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeStoreInventory"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productStoreInventory ?>>
                </div>
            </div>

            <!--SO Quantity-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    SO Quantity [-]
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeSOQuantity"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productSO ?>>
                </div>
            </div>

            <!--total store inventory-->
            <div class="row50 stackHorizontally">
                <div class="leftSide stackHorizontally alignRight">
                    Total Store Inventory
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeTotalStoreInventory"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productTotalStoreInventory ?>>
                </div>
            </div>

            <!--BO Quantity-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    BO Quantity [-]
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeBOQuantity"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productBO ?>>
                </div>
            </div>

            <!--inventory to sc-->
            <div class="row50 stackHorizontally">
                <div class="leftSide stackHorizontally alignRight">
                    Inventory to SC
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input id="bodegajeInventoryToSC"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productInventoryToSC ?>>
                </div>
            </div>

            <!--total quantity-->
            <div class="row50">
                <div class="leftSide stackHorizontally alignRight">
                    Total Quantity
                </div>
                <div class="rightSide stackHorizontally alignLeft">
                    <input disabled id="bodegajeTotalQuantity"
                           type="text"
                           class="entradaTexto"
                           value= <? echo $productTotalQuantity ?>>
                </div>
            </div>

            <div id="deleteResponse" class="row">

            </div>

        </div>
    </div>
</div>

<div hidden id="deleteModal" title="Eliminar">
    <p>Eliminar?</p>
    <input id="deleteButtonOK" type="button" class="cmd button button-highlight button-pill stackHorizontally"
           value="Eliminar">
    <input id="deleteButtonCANCEL" type="button" class="cmd button button-highlight button-pill stackHorizontally"
           value="Cancelar">
    <br>
    <br>
    <p style="text-align: center" id="deleteModalResponse"></p>
</div>

<script>
    var curProd;
    $("#updateInventoryButton").click(function () {
        var masterSKU = $("#bodegajeMasterSKU").val();
        var inventoryToSC = $("#bodegajeInventoryToSC").val();
        var storeInventory = $("#bodegajeStoreInventory").val();
//        console.log(masterSKU + " " + storeInventory + " " + inventoryToSC);
        $.ajax({
            type: "POST",
            url: "../../php/bodegaje/bodegajeOperations.php",
            data: {
                method: "updateInventory",
                mastersku: masterSKU,
                q1: storeInventory,
                q2: inventoryToSC,
            },
            success: function (response) {
               console.log(response);
                $("#updateInventoryResponse").html("exito");
//                $("#bodegajeTotalStoreInventory").val(parseFloat($("#bode0gajeTotalQuantity").val()) + parseFloat($("#bodegajeTotalStoreInventory").val()));
//                $("#bodegajeInventoryToSC").val($("#bodegajeTotalStoreInventory").val());
                setTimeout(function () {
                    $("#updateInventoryResponse").html("");
                    $("#Tabinventario").click();
                }, 500);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    $('#exiProTable').DataTable({
        'paging': true,
        'filter': false,
        'info': false,
        'scrollY': '200px',
        'scrollCollapse': true,
    });

    var currentId;
    $(".exidel").click(function (event) {
        currentId = event.target.getAttribute("delid");
        var pais = $("#deleteResponse").html("");
//        console.log("delete " + id);
        $(function () {
            $("#deleteModal").dialog({
                width: 400,
                height: 175,
                modal: true
            });
        });
    });
    $(".exiedit").click(function (event) {
        currentId = event.target.getAttribute("editid");
        var currentValue = $("#traexiinput"+currentId).val();
        var pais = $("#exiproResponse").html("");
//        console.log("delete " + id);
        $(function () {
            $.ajax({
                url: "../../php/bodegaje/bodegajeOperations.php",
                type: "POST",
                data: {
                    method: "updateTraExi",
                    id: currentId,
                    value:currentValue,
                },
                success: function (response) {
//                    console.log("s"+response);

                    $("#exiproResponse").html("Registro actualizado");
                    setTimeout(function () {
                        $("#Tabinventario").click();
                    }, 1500);
                },
                error: function (response) {
                    console.log("e"+response);
                    $("#exiproResponse").html("Error al actualizar");
                    setTimeout(function () {
                    }, 1500);
                    console.log(response);console.log("E:" + JSON.stringify(response));
                }
            });
        });
    });

    $("#deleteButtonCANCEL").click(function () {
        $("#deleteModal").dialog("close");
    });

    $("#deleteButtonOK").click(function () {
        console.log("delete");
        $.ajax({
            url: "../../php/bodegaje/bodegajeOperations.php",
            type: "POST",
            data: {
                method: "deleteBod",
                id: currentId,
            },
            success: function (response) {
                console.log(response);
                $("#deleteModalResponse").html("Registro borrado");
                setTimeout(function () {
                    $("#deleteModal").dialog("close");
                    $("#Tabinventario").click();
                }, 1500);
            },
            error: function (response) {
                console.log(response);
                $("#deleteModalResponse").html("Error al borrar");
                setTimeout(function () {
                    $("#deleteModal").dialog("close");
                }, 1500);
                console.log(response);console.log("E:" + JSON.stringify(response));
            }
        });
    });

    $( "#bodegajeInventoryToSC" ).keyup(function() {
        $("#updateInventoryButton").prop("disabled", false);
    });

    $("#productStatus").change(function () {
        var sku = $("#bodegajeMasterSKU").val();
        var status = ($(this).is(":checked") == true) ? "A" : "B";
        // console.log();
        $.ajax({
            url:"../../php/productos/changeProductStatus.php",
            type:"POST",
            data:{
                sku:sku,
                status:status
            },
            success:function (response) {
                console.log("S "+status)
                if(status == "A"){
                    $("#statusMessage").attr("class", 'mALTA');
                    $("#statusMessage").text('ALTA');
                }
                else{
                    $("#statusMessage").attr("class", 'mBAJA');
                    $("#statusMessage").text('BAJA');
                }
            },
            error:function (response) {
                console.log("E "+response)
            }
        });
    })
</script>

<style>
    .contentOutter {
        width: 100%;
    }

    .contentInner {
        max-width: 50%;
        margin: auto;
    }

    #contentHeader {
        height: 90px;
    }

    #contentBody {
        height: 220px;
    }

    #exiTable {
        height: 250px;
    }

    .row {
        text-align: center;
        width: 100%;
    }

    .row50 {
        text-align: center;
        width: 50%;
    }

    .leftSide {
        width: 45%;
        padding-right: 10px;
    }

    .rightSide {
        width: 45%;
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

    .fullWidthInput{
        width: 100%;
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

    .mALTA{
        float: left;
        color: green;
        font-weight: bold;
        font-size: 18px;
    }

    .mBAJA{
        float: left;
        color: red;
        font-weight: bold;
        font-size: 18px;
    }
</style>