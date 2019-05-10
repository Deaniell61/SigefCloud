<?php

include_once("product.php");
$product = new sigefcloud\product("502TEST", "Guatemala");

?>

<html>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<div id="content">
    <div class="leftPanel">

        <div class="row">
            COUNTRY
        </div><div class="row">
            <select id="country" class="editorInput">
                <option selected value="Guatemala">Guatemala</option>
                <option value="Costa Rica">Costa Rica</option>
            </select>
        </div>

        <div class="divider"></div>
        <div class="row">
            SKU
        </div>
        <div class="row">
            <input disabled type="text" id="sku" value="502TEST" class="editorInput">
        </div>
        <div class="row">
            <input type="button" id="loadProduct" value="load product" onclick="loadProduct()">
        </div>
        <div id="message" class="row message">
        </div>
    </div>
    <div class="righPanel">
        <div class="row">
            name
        </div>
        <div class="row">
            <div class="colLeft">
                name
            </div>
            <div class="colCenter">
                <input disabled type="text" id="nameOld" class="editorInput">
            </div>
            <div class="colRight">
                <input type="text" id="nameNew" class="editorInput">
            </div>
        </div>
        <div class="row">
            <input disabled type="button" id="syncName" value="sync name" onclick="syncName()">
        </div>

        <div class="divider"></div>
        <div class="row">
            weight
        </div>
        <div class="row">
            <div class="colLeft">
                lb
            </div>
            <div class="colCenter">
                <input disabled type="number" step="0.01" id="lbOld" class="editorInput">
            </div>
            <div class="colRight">
                <input type="number" step="0.01" id="lbNew" class="editorInput">
            </div>
        </div>
        <div class="row">
            <div class="colLeft">
                oz
            </div>
            <div class="colCenter">
                <input disabled type="number" step="0.01" id="ozOld" class="editorInput">
            </div>
            <div class="colRight">
                <input type="number" step="0.01" id="ozNew" class="editorInput">
            </div>
        </div>
        <div class="row">
            <div class="colLeft">
                peso
            </div>
            <div class="colCenter">
                <input disabled type="text" id="pesoOld" class="editorInput">
            </div>
            <div class="colRight">
                <input disabled type="text" id="pesoNew" class="editorInput">
            </div>
        </div>
        <div class="row">
            <input disabled type="button" id="syncWeight" value="sync weight" onclick="syncWeight()">
        </div>
    </div>
</div>
</html>

<script>
    function loadProduct() {
        var sku = $("#sku").val();
        var country = $("#country").val();
        $.ajax({
            type: "POST",
            url: "productEditorOperations.php",
            data: {
                method: "loadProduct",
                sku: sku,
                country: country,
            },
            success: function (response) {
                $("#message").html("");
                console.log("S" + response);
                response = JSON.parse(response);
                $("#nameOld").val(response.name);
                $("#nameNew").val(response.name);
                $("#lbOld").val(response.lb);
                $("#lbNew").val(response.lb);
                $("#ozOld").val(response.oz);
                $("#ozNew").val(response.oz);
                $("#pesoOld").val(response.peso);
                $("#pesoNew").val(response.peso);

                $("#syncName").prop("disabled", false);
                $("#syncWeight").prop("disabled", false);
            },
            error: function (response) {
                console.log("E" + response);
            }
        })
    }

    function syncName() {
        var sku = $("#sku").val();
        var name = $("#nameNew").val();
        var country = $("#country").val();
        if(name != ''){
            $.ajax({
                type: "POST",
                url: "productEditorOperations.php",
                data: {
                    method: "syncName",
                    sku: sku,
                    name: name,
                    country: country,
                },
                success: function (response) {
                    console.log("SN:" + response);
                    $("#message").html("edited");

                    setTimeout(function () {
                        $("#loadProduct").click();
                    }, 3000);
                },
                error: function (response) {
                    console.log("E" + response);
                }
            })
        }else{
            $("#message").html("name cannot be empty");
        }
    }

    function syncWeight() {
        var sku = $("#sku").val();
        var lb = $("#lbNew").val();
        var oz = $("#ozNew").val();
        var peso = $("#pesoNew").val();
        var country = $("#country").val();
        if(lb != "" && oz != "" && peso != ""){
            $.ajax({
                type: "POST",
                url: "productEditorOperations.php",
                data: {
                    method: "syncWeight",
                    sku: sku,
                    lb: lb,
                    oz: oz,
                    peso: peso,
                    country: country,
                },
                success: function (response) {
                    console.log("S" + response);
                    $("#message").html("edited");

                    setTimeout(function () {
                        $("#loadProduct").click();
                    }, 3000);
                },
                error: function (response) {
                    console.log("E" + response);
                }
            })
        }else{
            $("#message").html("weight error");
        }
    }

    $("#lbNew").on("keypress", function(evt) {
        var keycode = evt.charCode || evt.keyCode;
        if (keycode == 46) {
            return false;
        }
    });

    $("#lbNew").on('input propertychange',function(e) {
        var lb = $(this).val();
        var oz = Math.floor(($("#ozNew").val() * 100) / 16);
        $("#pesoNew").val(lb + "." + oz)

    });

    $("#ozNew").on('input propertychange',function(e) {
        var lb = $("#lbNew").val();
        var oz = $(this).val();
        if(oz >= 16){
            var lb = parseFloat($("#lbNew").val()) +  Math.floor(oz/16);
            var oz = oz%16;
            $("#lbNew").val(lb);
            $("#ozNew").val(oz);
        };

        oz = Math.floor(($("#ozNew").val() * 100) / 16);
        $("#pesoNew").val(lb + "." + oz)
    });
</script>

<style>
    #content {
        width: 100%;
        height: 100%;
    }

    .leftPanel{
        width: 24%;
        float: left;
        height: 100%;
        border: 1px solid black;
    }

    .righPanel{
        width: 74%;
        float: left;
        height: 100%;
        overflow-y:auto;
        border: 1px solid black;
    }

    .row {
        width: 100%;
        text-align: center;
        clear: both;
        font-weight: bold;
    }

    .colLeft {
        width: 20%;
        float: left;
        text-align: right;
        font-weight: bold;
    }

    .colCenter {
        width: 40%;
        float: left;
        text-align: left;
    }

    .colRight {
        width: 40%;
        float: left;
        text-align: left;
    }

    .divider {
        height: 25px;
    }

    .editorInput{
        width: 100%;
        text-align: center;
    }

    .message{
        font-weight: bold;
        color: red;
    }
</style>