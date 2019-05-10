<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$codEmpresa = $_POST["codEmpresa"];
$icode = $_POST["icode"];
$pais = $_POST["pais"];

function tablaIngredientes() {

    $icode = $_POST["icode"];
    $pais = $_POST["pais"];
    $getProd = "
        SELECT 
            CODPROD
        FROM
            cat_prod
        WHERE
            MASTERSKU = '$icode';";
    $CODPROD = getSingleValue($getProd, $pais);

    $bQ = "
            SELECT 
                *
            FROM
                tra_prod_ingredientes
            WHERE
                CODPROD = '$CODPROD';
        ";
    $bResult = mysqli_query(conexion($pais), $bQ);
    while ($bRow = mysqli_fetch_array($bResult)) {
        $tIngrediente = $bRow["DESCRIP"];
        $tCantidad = $bRow["CANTIDAD"];
        $tCodingre = $bRow["CODINGRE"];
        $body .= "
                <tr><td>$tIngrediente</td><td>$tCantidad</td><td><a href='#'><image class='ingedit' ingid='$tCodingre' ingdesc='$tIngrediente' ingcant='$tCantidad' src='../../images/document_edit.png'></a>&nbsp;&nbsp;&nbsp;<a href='#'><image class='ingdelete' ingid='$tCodingre' src='../../images/document_delete.png'></a></td></tr>
            ";
    }
    $response = $body;
    return $response;
}

?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script>
    seleccion(document.getElementById('Tabingredientes'));
    setTimeout(function () {
        $("#cargaLoad").dialog("close");
    }, 500);
</script>

<br>
<br>
<div id="formIngredientes">
    <input hidden type="text" id="codEmpresa" value=<?php echo $codEmpresa ?>>
    <input hidden type="text" id="pais" value="<?php echo $pais ?>">
    <input hidden type="text" id="icode" value=<?php echo $icode ?>>
    <div id="col1">
        Descripcion: <input id="descripcionInput" type="text" class="entradaTexto">
    </div>
    <div id="col2">
        Cantidad: <input id="cantidadInput" type="text" class="entradaTexto">
    </div>
    <div id="col3">
        <input disabled id="agregarIngredienteButton" type="button" class="cmd button button-highlight button-pill"
               value="Agregar">
    </div>
</div>
<div id="responseD">&nbsp;</div>
<br>
<br>

<div id="contentIngredientes">
    <table id='tableIngredientes' class='cell-border table tabla hoover'>
        <thead>
        <tr>
            <td>Ingrediente</td>
            <td>Cantidad</td>
            <td>Controles</td>
        </tr>
        </thead>
        <tbody>
        <?php
        echo tablaIngredientes();
        ?>
        </tbody>
    </table>
</div>
<br>
<br>

<div hidden id="deleteModal" title="Eliminar ingrediente">
    <p>Eliminar ingrediente?</p>
    <input id="deleteIngredienteButtonOK" type="button" class="cmd button button-highlight button-pill stackHorizontally"
           value="Eliminar">
    <input id="deleteIngredienteButtonCANCEL" type="button" class="cmd button button-highlight button-pill stackHorizontally"
           value="Cancelar">
    <br>
    <br>
    <p style="text-align: center" id="deleteResponse"></p>
</div>

<div hidden id="editModal" title="Editar ingrediente">
    <div>
        <div class="half stackHorizontally right">Ingrediente:</div>
        <div class="half stackHorizontally"><input id="newDescription" type="text" class="entradaTexto"></div>
    </div>
    <div>
        <div class="half stackHorizontally right">Cantidad:</div>
        <div class="half stackHorizontally"><input id="newQuantity" type="text" class="entradaTexto"></div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <input id="editIngredienteButtonOK" type="button" class="cmd button button-highlight button-pill stackHorizontally"
           value="Editar">
    <input id="editIngredienteButtonCANCEL" type="button" class="cmd button button-highlight button-pill stackHorizontally"
           value="Cancelar">
    <br>
    <br>
    <p style="text-align: center" id="editResponse"></p>
</div>

<script>
    var currentId;
    var currentDesc;
    var currentQty;
    $("#agregarIngredienteButton").click(function () {
        var descripcion = $("#descripcionInput").val();
        var cantidad = $("#cantidadInput").val();
        var codEmpresa = $("#codEmpresa").val();
        var pais = $("#pais").val();
        var icode = $("#icode").val();
        console.log(pais);
        $.ajax({
            url: "../../php/ingredientes/ingredientesOperations.php",
            type: "POST",
            data: {
                method: "agregarIngrediente",
                descripcion: descripcion,
                cantidad: cantidad,
                producto: icode,
                pais: pais,
                codEmpresa: codEmpresa,
            },
            success: function (response) {
                if (response == "S") {
                    $("#cantidadInput").val("");
                    $("#descripcionInput").val("");
                    $("#responseD").html("guardado con exito");
                }
                else {
                    $("#responseD").html("error al guardar");
                }
                setTimeout(function () {
                    $("#responseD").html("&nbsp;");
                    $("#Tabingredientes").click();
                }, 1500);
            },
            error: function (response) {
                console.log("E:" + JSON.stringify(response));
            }
        });
    });
    $('#tableIngredientes').DataTable({
        'paging': true,
        'filter': false,
        'info': false,
        'scrollY': '500px',
        'scrollCollapse': true,
    });

    $(".ingedit").click(function (event) {
        currentId = event.target.getAttribute("ingid");
//        console.log("edit " + JSON.stringify(id));
        $("#newDescription").val(event.target.getAttribute("ingdesc"));
        $("#newQuantity").val(event.target.getAttribute("ingcant"));
        $("#editResponse").html("");
        $(function () {
            $("#editModal").dialog({
                width: 400,
                height: 200,
                modal: true
            });
        });
    });

    $(".ingdelete").click(function (event) {
        currentId = event.target.getAttribute("ingid");
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

    $("#descripcionInput").keyup(function () {
        if($("#descripcionInput").val() != "" && $("#cantidadInput").val() != ""){
            $("#agregarIngredienteButton").prop("disabled", false);
        }else{
            $("#agregarIngredienteButton").prop("disabled", true);
        }
    });
    $("#cantidadInput").keyup(function () {
        if($("#descripcionInput").val() != "" && $("#cantidadInput").val() != ""){
            $("#agregarIngredienteButton").prop("disabled", false);
        }else{
            $("#agregarIngredienteButton").prop("disabled", true);
        }
    });
    
    $("#editIngredienteButtonCANCEL").click(function () {
        $("#editModal").dialog("close");
    });
    $("#deleteIngredienteButtonCANCEL").click(function () {
        $("#deleteModal").dialog("close");
    });

    $("#editIngredienteButtonOK").click(function () {
        $.ajax({
            url: "../../php/ingredientes/ingredientesOperations.php",
            type: "POST",
            data: {
                method: "editarIngrediente",
                id: currentId,
                cantidad: $("#newQuantity").val(),
                descripcion: $("#newDescription").val(),
            },
            success: function (response) {
                console.log(response);
                $("#editResponse").html("Editado con exito");
                setTimeout(function () {
                    $("#editModal").dialog("close");
                    $("#Tabingredientes").click();
                }, 1500);
            },
            error: function (response) {
                $("#deleteResponse").html("Error al editar");
                setTimeout(function () {
                    $("#deleteModal").dialog("close");
                }, 1500);
                console.log(response);console.log("E:" + JSON.stringify(response));
            }
        });
    });

    $("#deleteIngredienteButtonOK").click(function () {
        var pais = $("#pais").val();
        $.ajax({
            url: "../../php/ingredientes/ingredientesOperations.php",
            type: "POST",
            data: {
                method: "eliminarIngrediente",
                id: currentId,
                pais: pais,
            },
            success: function (response) {
                $("#deleteResponse").html("Eliminado con exito");
                setTimeout(function () {
                    $("#deleteModal").dialog("close");
                    $("#Tabingredientes").click();
                }, 1500);
                console.log(response);
            },
            error: function (response) {
                $("#deleteResponse").html("Error al eliminar");
                setTimeout(function () {
                    $("#deleteModal").dialog("close");
                }, 1500);
                console.log(response);
            }
        });
    });
</script>

<style>

    #contentIngredientes {
        margin: auto;
        width: 60%;
        height: 500px;
    }

    #formIngredientes {
        margin: auto;
        width: 60%;
        height: 50px;
    }

    #col1 {
        width: 33%;
        float: left;
    }

    #col2 {
        width: 33%;
        float: left;
    }

    #col3 {
        width: 33%;
        float: left;
    }

    .stackHorizontally {
        float: left;
    }

    .half{
        width: 50%;
    }

    .right{
        text-align: right;
    }
</style>