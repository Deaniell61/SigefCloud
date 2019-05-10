<?php
    if(isset($_POST["method"])){
        $method = $_POST["method"];

        switch($method){
            case "balanceCurrent":

                break;

            case "balanceLast":

                break;
        }
    }
?>

<div id="container" style="width: 100%;">
    <div id="tabs">
        <ul>
            <li><a href="#tab1">Balances</a></li>
            <li><a href="#tab2">Balance</a></li>
            <li><a href="#tab3">Detalle</a></li>
        </ul>
        <div id="tab1" style="width: 100%;">
            <script>
                $(function () {
                    $("#tab1").load("../../php/balances/balanceList.php");
                });
            </script>
        </div>
        <div id="tab2">
            <script>
                $(function () {
                    $("#tab2").load("../../php/balances/balanceEnc.php");
                });
            </script>
        </div>
        <div id="tab3">
            <script>
                $(function () {
                    $("#tab3").load("../../php/balances/balanceDetail.php");
                });
            </script>
        </div>
    </div>
</div>

<script>
    $( function() {
        $( "#tabs" ).tabs({
            activate: function(event, ui) {
            if(ui.newTab.index() == 2){
                $("#balanceDropD").val($("#balanceDrop").val());
                $("#balanceDropD").change();
            }
        } });
    } );
</script>