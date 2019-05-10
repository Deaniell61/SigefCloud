<?php

include_once ("product.php");
$product = new sigefcloud\product("502TEST", "Guatemala");


?>

<html>
<div id="content">
    <div class="row">
        SKU
    </div>
    <div class="row">
        <input type="text" id="sku">
    </div>
    <div class="row">
        <input type="button" value="load product">
    </div>

    <div class="divider"><!-- nombre --></div>

    <div class="row">
        nombre
    </div>
    <div class="row">
        <div class="colLeft">
            <input disabled type="text" id="nameOld">
        </div>
        <div class="colRight">
            <input type="text" id="nameNew">
        </div>
    </div>
    <div class="row">
        <input type="button" value="sync name">
    </div>

</div>
    sku<input type="button" value="load product">
    <br>
    name<input type="text" id="nameOld"><input type="text" id="nameNew">
</html>

<script>
    function loadProduct(){

    }
</script>

<style>
    #content{
        width: 75%;
        margin-left: 12.5%;
    }

    .row{
        width: 100%;
        text-align: center;
        clear: both;
        font-weight: bold;
    }

    .colLeft{
        width: 50%;
        float: left;
        text-align: right;
        font-weight: bold;
    }

    .colRight{
        width: 50%;
        float: left;
        text-align: left;
    }

    .divider{
        height: 25px;
    }
</style>