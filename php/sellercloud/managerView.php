<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/managerController.php");
$managerController = new managerController();
?>
<html>
<h1>SellerCloud WS Manager</h1>

<div>
    webservice
    <select id="webservices" onchange="managerController.changeModuleFields(this.value)">
        <?php
        $webservices = $managerController->getWebservices();
        foreach ($webservices as $webservice) {
            echo "<option value='$webservice'>$webservice</option>";
        }
        ?>
    </select>
    module
    <select id="modules" onchange="managerController.getModuleFields(this.value, $('#webservices').val())">
        <!--<?php
        $modules = $managerController->getModules();
        foreach ($modules as $module) {
            echo "<option value='$module'>$module</option>";
        }
        ?>-->
    </select>
    <input type="button" value="agregar registro al modulo" onclick="managerController.addField($('#modules').val(), $('#webservices').val())">
    <input type="button" value="mostrar array del webservice" onclick="window.open('http://desarrollo.sigefcloud.com/php/sellercloud/sellercloudTest.php?ws=' + $('#webservices').val(), '_blank')">
</div>
<br>
<div id="moduleFields">
</div>

<div hidden
     id="fieldForm">
    codcampo<input disabled id="codcampo" class="formInput" type="text"><br>
    orden<input id="orden" class="formInput" type="text"><br>
    nombre<input id="nombre" class="formInput" type="text"><br>
    descripcion<input id="descripcion" class="formInput" type="text"><br>
    modulo<input id="modulo" class="formInput" type="text"><br>
    webservice<input id="webservice" class="formInput" type="text"><br>
    valor<input disabled id="valor" class="formInput" type="text"><br>
    <select id="valueType" onchange="managerController.changeFormType(this.value)">
        <option value="var">var</option>
        <option value="table">table</option>
        <option value="array">array</option>
        <option value="function">function</option>
    </select><br>
    <input id="input1" class="valueInput" type="text" onchange="managerController.updateFormValue()" onkeypress="managerController.updateFormValue()">
    <input hidden id="input2" class="valueInput" type="text" onchange="managerController.updateFormValue()" onkeypress="managerController.updateFormValue()">
    <input hidden id="input3" class="valueInput" type="text" onchange="managerController.updateFormValue()" onkeypress="managerController.updateFormValue()">
    <input hidden id="input4" class="valueInput" type="text" onchange="managerController.updateFormValue()" onkeypress="managerController.updateFormValue()">
    <input hidden id="input5" class="valueInput" type="text" onchange="managerController.updateFormValue()" onkeypress="managerController.updateFormValue()">
    <input hidden id="input6" class="valueInput" type="text" onchange="managerController.updateFormValue()" onkeypress="managerController.updateFormValue()">
    <br>
    <input type="button" value="guardar" onclick="managerController.saveField(
        $('#codcampo').val(),
        $('#orden').val(),
        $('#nombre').val(),
        $('#descripcion').val(),
        $('#modulo').val(),
        $('#valor').val(),
        $('#webservice').val()
        )">
</div>

</html>

<style>
    #moduleFields table, th, td {
        border-collapse: collapse;
        border: 1px solid;
    }

    .formInput{
        width: 100%;
    }
</style>

<script src="managerController.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">