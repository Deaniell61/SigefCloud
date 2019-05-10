<div id="editShipping" title="Edit">
    <br>
    <div class="row1">
        <div class="col2">Local order:</div>
        <div class="col2"><input id="isLocal" type="checkbox" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Order ID:</div>
        <div class="col2"><input id="editOrderId" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Tracking number:</div>
        <div class="col2" style="text-align: left !important;"><input id="editTrackingNumber" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Ship date:</div>
        <div class="col2"><input id="editShipDate" class="entradaTexto" type="date" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Shipping carrier:</div>
        <div class="col2">
            <select id="editShippingCarrier" class="entradaTexto" style="width: 100%">
                <option value="ups">UPS</option>
                <option value="fedex">FEDEX</option>
                <option value="usps">USPS</option>
                <option value="other">OTRO</option>
            </select>
        </div>
    </div>
    <div hidden id="otherCarrierRow" class="row1">
        <div class="col2">Other carrier:</div>
        <div class="col2"><input id="otherCarrierName" class="entradaTexto" type="text" style="width: 100%"></div>
    </div><div class="row1">
        <div class="col2">Shipping method:</div>
        <div class="col2"><input id="editShippingMethod" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Shipping cost:</div>
        <div class="col2"><input id="editShippingCost" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1" id="editMessage">
    </div>
    <div class="row1" style="text-align: center; padding-top: 20px;">
        <input id="editTrackingButton" class="cmd button button-highlight button-pill" type="button" value="Save">
        <input id="new" class="cmd button button-highlight button-pill" type="button" value="New">
    </div>
</div>

<script>

    var other;

    document.getElementById('editShipDate').valueAsDate = new Date();

    $("#editShippingCarrier").change(function () {
        // console.log($(this).val());
        if($(this).val() == "other"){
            $("#otherCarrierRow").prop("hidden", false);
            other = true;
        }
        else{
            $("#otherCarrierRow").prop("hidden", true);
            other = false;
        }
        $("#otherCarrierName").val("");
    });

    $("#editTrackingButton").click(function () {
        $('#editMessage').html("<p style='text-align: center;'>saving...</p>");
        $("#editTrackingButton").prop("disabled", true);
        var tOrderId = $("#editOrderId").val();
        var tTrackingNumber = $("#editTrackingNumber").val();
        var tShipDate = $("#editShipDate").val();
        if(other){
            var tShipCarrier = $("#otherCarrierName").val();
        }
        else{
            var tShipCarrier = $("#editShippingCarrier").val();
        }

        var tShipMethod = $("#editShippingMethod").val();
        var tShipCost = $("#editShippingCost").val();
        var tIsLocal = $("#is").val();

        console.log(tOrderId + " " + tTrackingNumber + " " + tShipDate + " " + tShipCarrier + " " + tShipMethod + " " + tShipCost);

        $.ajax({
            url: "../php/ordenes/updateTrackingOperation.php",
            type: "POST",
            data: {
                tOrderId:tOrderId,
                tTrackingNumber:tTrackingNumber,
                tShipDate:tShipDate,
                tShipCarrier:tShipCarrier,
                tShipMethod:tShipMethod,
                tShipCost:tShipCost,
                tIsLocal:tIsLocal,
            },
            success: function (response) {
                console.log(response);
                $('#editMessage').html("<p style='text-align: center; color: green;'>success...<br></p>");

            },
            error:function (response) {
                console.log(response)
                $('#editMessage').html("<p style='text-align: center; color: red;'>error...</p>");
            }
        });
    });

    $("#new").click(function () {
        $("#editTrackingButton").prop("disabled", false);

        $("#editOrderId").val("");
        $("#editTrackingNumber").val("");
        document.getElementById('editShipDate').valueAsDate = new Date();
        // $("#editShippingCarrier").val("");
        $("#editShippingCarrier").val($("#editShippingCarrier option:first").val());
        $("#editShippingMethod").val("");
        $("#editShippingCost").val("");

        $('#editMessage').html("");

        $("#otherCarrierRow").prop("hidden", true);
        $("#isLocal").prop("checked", false);
        other = false;
        $("#otherCarrierName").val("");
    });
</script>

<style>
    .col2{
        float: left;
        width: 50%;
    }
    #editShipping{
        width: 60%;
        margin-left: 20%;
    }
</style>