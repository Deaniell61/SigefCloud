var managerController = {
    changeModuleFields: function (webservice) {
        $.ajax({
            url: "managerController.php",
            type: "post",
            data: {
                method: "changeModuleFields",
                webservice: webservice,
            },
            success: function (response) {
                $("#modules").html("");
                $("#modules").html(response);
                $("#modules").change();
                managerController.getModuleFields($("#modules").val(), webservice);
            },
        });
    },

    getModuleFields: function (module, webservice) {
        $.ajax({
            url: "managerController.php",
            type: "post",
            data: {
                method: "getModuleFields",
                module: module,
                webservice: webservice,
            },
            success: function (response) {
                // console.log(response);
                response = JSON.parse(response);
                $("#moduleFields").html("");
                var table = "<table>";
                table += "<thead>";
                table += "<tr>";
                table += "<th>CODCAMPO</th>";
                table += "<th>ORDEN</th>";
                table += "<th>NOMBRE</th>";
                table += "<th>DESCRIP</th>";
                // table += "<th>MODULO</th>";
                table += "<th>VALOR</th>";
                table += "<th>ACCIONES</th>";
                table += "</tr>";
                table += "</thead>";
                $.each(response, function (idx, field) {
                    table += "<tr>";
                    table += "<td>" + field.CODCAMPO + "</td>";
                    table += "<td>" + field.ORDEN + "</td>";
                    table += "<td>" + field.NOMBRE + "</td>";
                    table += "<td>" + field.DESCRIP + "</td>";
                    // table += "<td>" + field.MODULO + "</td>";
                    table += "<td>" + field.VALOR + "</td>";
                    table += "<td>" +
                        "<input type='button' value='editar' onclick='managerController.editField(\"" + field.CODCAMPO + "\");'>" +
                        "<input type='button' value='borrar' onclick='managerController.deleteField(\"" + field.CODCAMPO + "\")'>";
                    table += "</td>";
                    table += "</tr>";
                });
                table += "</table>";
                $("#moduleFields").html(table);
            },
            error: function (response) {
            }
        });
    },

    deleteField: function (id) {
        $.ajax({
            url: "managerController.php",
            type: "post",
            data: {
                method: "deleteField",
                id: id,
            },
            success: function (response) {
                console.log($("#modules").val()+" - "+$("#webservices").val());
                managerController.getModuleFields($("#modules").val(), $("#webservices").val());
            },
            error: function (response) {
            }
        });
    },

    editField: function (id) {
        this.showFieldForm();
        $.ajax({
            url: "managerController.php",
            type: "post",
            data: {
                method: "getField",
                id: id,
            },
            success: function (response) {
                response = JSON.parse(response);
                $.each(response, function (idx, field) {
                    $("#codcampo").val(field.CODCAMPO);
                    $("#orden").val(field.ORDEN);
                    $("#nombre").val(field.NOMBRE);
                    $("#descripcion").val(field.DESCRIP);
                    $("#modulo").val(field.MODULO);
                    $("#webservice").val(field.WEBSERVICE);
                    $("#valor").val(field.VALOR);

                    var valor = field.VALOR.split("|");

                    $("#valueType").val(valor).change();
                    $("#input1").val(valor[1]);
                    $("#input2").val(valor[2]);
                    $("#input3").val(valor[3]);
                    $("#input4").val(valor[4]);
                    $("#input5").val(valor[5]);
                    $("#input6").val(valor[6]);
                    managerController.updateFormValue();
                });
            },
            error: function (response) {

            }
        });
    },

    addField: function (module, webservice) {
        managerController.showFieldForm();
        $("#codcampo").val("");
        $("#orden").val("");
        $("#nombre").val("");
        $("#descripcion").val("");
        $("#valor").val("");
        $("#modulo").val(module);
        $("#webservice").val(webservice);
        $("#input1").val("");
        $("#input2").val("");
        $("#input3").val("");
        $("#input4").val("");
        $("#input5").val("");
        $("#input6").val("");
    },

    saveField: function (id, orden, nombre, descripcion, modulo, valor, webservice) {
        $.ajax({
            url: "managerController.php",
            type: "post",
            data: {
                method: "saveField",
                id: id,
                orden: orden,
                nombre: nombre,
                descripcion: descripcion,
                modulo: modulo,
                valor: valor,
                webservice: webservice,
            },
            success: function (response) {
                console.log(response);
                managerController.closeFieldForm();
                managerController.getModuleFields($("#modules").val(), $("#webservice").val());
            },
            error: function (response) {

            }
        });
    },

    changeFormType: function (type) {

        $("#valor").val("");

        var input1 = $("#input1");
        var input2 = $("#input2");
        var input3 = $("#input3");
        var input4 = $("#input4");
        var input5 = $("#input5");
        var input6 = $("#input6");

        input1.val("");
        input2.val("");
        input3.val("");
        input4.val("");
        input5.val("");
        input6.val("");

        input1.hide();
        input2.hide();
        input3.hide();
        input4.hide();
        input5.hide();
        input6.hide();

        switch (type) {
            case "var":
                input1.attr("placeholder", "valor").show();
                break;
            case "table":
                input1.attr("placeholder", "tabla").show();
                input2.attr("placeholder", "campo").show();
                input3.attr("placeholder", "filtro").show();
                input4.attr("placeholder", "valor del filtro").show();
                input5.attr("placeholder", "tipo de conexion").show();
                break;
            case "array":
                input1.attr("placeholder", "tabla").show();
                input2.attr("placeholder", "campo").show();
                input3.attr("placeholder", "filtro").show();
                input4.attr("placeholder", "valor del filtro").show();
                input5.attr("placeholder", "tipo de conexion").show();
                input6.attr("placeholder", "modulo del array").show();
                break;
            case "function":
                input1.attr("placeholder", "funcion").show();
                break;
        }
    },

    showFieldForm: function () {
        $("#fieldForm").dialog({
            modal: true,
            width: 750,
            height: 550,
            position: {
                my: "center",
                at: "top",
            },
        }).dialog("open");
    },

    closeFieldForm: function () {
        $("#fieldForm").dialog("close");
    },

    updateFormValue: function () {
        var input1 = $("#input1");
        var input2 = $("#input2");
        var input3 = $("#input3");
        var input4 = $("#input4");
        var input5 = $("#input5");
        var input6 = $("#input6");
        switch ($("#valueType").val()) {
            case "var":
                $("#valor").val("var|" + input1.val());
                break;
            case "table":
                $("#valor").val("table|" + input1.val() + "|" + input2.val() + "|" + input3.val() + "|" + input4.val() + "|" + input5.val());
                break;
            case "array":
                $("#valor").val("array|" + input1.val() + "|" + input2.val() + "|" + input3.val() + "|" + input4.val() + "|" + input5.val() + "|" + input6.val());
                break;
            case "function":
                $("#valor").val("function|" + input1.val());
                break;
        }
    }
};