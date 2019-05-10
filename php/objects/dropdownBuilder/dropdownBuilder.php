<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    $idioma = idioma();
    include_once($_SERVER["DOCUMENT_ROOT"] . '/php/idiomas/' . $idioma . '.php');;
    //cat_pre_dis
    class dropdownBuilder {
        public function build($dropdownId, $optionValue, $optionName, $selected, $table, $connectionType, $filter) {
            session_start();
            include_once($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
            $query = "SELECT $optionValue, $optionName FROM $table $filter";
            switch ($connectionType) {
                case '1':
                    $result = mysqli_query(conexion($_SESSION['pais']), $query);
                    break;
                case '2':
                    $result = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
                    break;
                default:
                    $result = mysqli_query(conexion(""), $query);
                    break;
            }
            $response = '
                <select disabled class="entradaTextoDrop fullInput" id="' . $dropdownId . '">
                    <option value="na">No Data</option>
                </select>
            ';
            if ($result) {
                $response = '<select class="entradaTextoDrop fullInputx" id="' . $dropdownId . '">';
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $tSelected = '';
                        if (utf8_encode(strtolower($row[1])) == strtolower($selected)) {
                            $tSelected = 'selected="selected"';
                        }
                        $response = $response . '<option value="' . $row[0] . '" ' . $tSelected . '>' . limpiar_caracteres_sql(($row[1])) . '</option>';
                    }
                }
                $response = $response . '</select>';
            }
            echo $response;
        }
    }

?>

<html>
<div hidden
     id="addRecordForm">
    <div id="menuBar">
        <input id="guardar"
               type="button"
               recordType=""
               class="cmd button button-highlight button-pill"
               value="<?= $lang[$idioma]['Guardar'] ?>"
               onclick="dropdownBuilder.saveForm(this.getAttribute('recordType'), this.getAttribute('dropId'), this.getAttribute('dropValue'), this.getAttribute('newRecord'))"/>
    </div>
    <div id="addRecordFormContent"></div>
</div>
</html>

<script>
    var dropdownBuilder = {
        openAddRecordForm: function (recordType, dropId, dropValue, newRecord) {

            var tTitle = "Nuevo";
            if(!newRecord){
                tTitle = "Editar";
            }
//            console.log($("#addRecordForm").data("ui-dialog"));
            $("#addRecordForm").dialog({
                modal: true,
                width: 700,
                height: 500,
                title: tTitle,
            }).dialog("open");
            //$("#addRecordForm").dialog("open");
            $("#guardar").attr("recordType", recordType);
            $("#guardar").attr("dropId", dropId);
            $("#guardar").attr("dropValue", dropValue);
            $("#guardar").attr("newRecord", newRecord);
            $("#addRecordFormContent").html("");
            dropdownBuilder.getForm(recordType, dropValue, newRecord);
        },

        getForm: function (recordType, dropValue, newRecord) {
            var tUrl = "/php/objects/dropdownBuilder/forms/" + recordType + ".php";
            $.ajax({
                url: tUrl,
                type: "post",
                data: {},
                success: function (response) {
                    $("#addRecordFormContent").html(response);
                    if (dropValue !== undefined) {
                        if(!newRecord){
                            dropdownBuilder.fillForm(recordType, dropValue);
                        }
                    }
                },
                error: function (response) {
                    $("#addRecordFormContent").html("<div>error:" + JSON.stringify(response) + "</div>");
                }
            });
        },

        fillForm: function (recordType, dropValue) {
            var tQuery = "";
            var tConnectionType = "";
            switch (recordType) {
                case "paymentStatusForm":
                    tQuery = "SELECT codpaysta, nombre FROM cat_pay_sta WHERE codpaysta = '" + dropValue + "';";
                    tConnectionType = 0;
                    break;
            }

            $.ajax({
                url: "/php/objects/dropdownBuilder/dropdownBuilderRequests.php",
                type: "post",
                data: {
                    method: "load",
                    connectionType: tConnectionType,
                    query: tQuery,
                },
                success: function (response) {
                    response = JSON.parse(response);
                    switch (recordType) {
                        case "paymentStatusForm":
                            $("#codigo").val(response["codpaysta"]);
                            $("#nombre").val(response["nombre"]);
                            break;
                    }
                }
            });
        },

        saveForm: function (recordType, dropId, selected, newRecord) {
            var tQuery = "";
            var tConnectionType = "";
            switch (recordType) {
                case "paymentStatusForm":
                    tQuery = "INSERT INTO cat_pay_sta (codpaysta, nombre) VALUES ('" + $("#codigo").val() + "', '" + $("#nombre").val() + "') ON DUPLICATE KEY UPDATE nombre='" + $("#nombre").val() + "';";
                    tConnectionType = 0;
                    break;
            }

            if(dropdownBuilder.validateForm(recordType)){
                $.ajax({
                    url: "/php/objects/dropdownBuilder/dropdownBuilderRequests.php",
                    type: "post",
                    data: {
                        method: "save",
                        connectionType: tConnectionType,
                        query: tQuery,
                    },
                    success: function (response) {

                        console.log(selected + "-" + newRecord);
                        if(newRecord == "true"){
                            console.log("!");
                            selected = response;
                        }
                        console.log(selected);
                        dropdownBuilder.closeForm();
                        dropdownBuilder.refreshDropdown(recordType, dropId, selected);
                    },
                    error: function (response) {
                        dropdownBuilder.closeForm();
                    }
                });
            }
        },

        refreshDropdown: function (recordType, dropId, selected) {
            $.ajax({
                url: "/php/objects/dropdownBuilder/dropdownBuilderRequests.php",
                type: "post",
                data: {
                    method: "refresh",
                    recordType: recordType,
                    dropId: dropId,
                    selected: selected,
                },
                success: function (response) {
                    console.log(response);
                    var tParent = $("#"+dropId).parent();
                    $("#"+dropId).remove();
                    tParent.prepend(response);
                },
            });
        },

        validateForm: function(recordType){
            var response = true;
            switch (recordType){
                case "paymentStatusForm":
                    if($("#nombre").val() == ""){
                       response = false;
                    }
                    break;
            }
            return response;
        },

        closeForm: function(){
            $("#addRecordForm").dialog("close");
            $("#addRecordForm").remove();
        }
    }
</script>

<style>
    #menuBar {
        width: 100%;
        height: 50px;
        display: flex;
        justify-content: center;
    }

    #addRecordFormContent {
        width: 100%;
        height: 350px;
        display: flex;
        justify-content: center;
    }
</style>