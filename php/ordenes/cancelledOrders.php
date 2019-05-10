<?php
    session_start();
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    function getOrderTypesSelect(){
        $orderTypesQuery = "
            SELECT 
                estatus
            FROM
                tra_ord_enc
            WHERE
                TRANUM = ''
            GROUP BY estatus; 
        ";

        $orderTypesResult = mysqli_query(conexion($_SESSION["pais"]), $orderTypesQuery);

        $data = "<option value='all'>All</option>";

        while($orderTypesRow = mysqli_fetch_array($orderTypesResult)){
            $tEstatus = $orderTypesRow["estatus"];
            $data .= "
                <option value='$tEstatus'>$tEstatus</option>
            ";
        }

        $response = "
            <select id='orderTypes' class='entradaTexto'>$data</select>
        ";

        return $response;
    }
?>
<div class="row">
    <div class="col">
        <b>Start Date</b>
        <br>
        <input id="startDate" type="date" class="entradaTexto" value="<?php echo date('Y-m-d', strtotime('-7 days')); ?>">
    </div>
    <div class="col">
        <b>End Date</b>
        <br>
        <input id="endDate" type="date" class="entradaTexto" value="<?php echo date('Y-m-d'); ?>"></div>
<!--    <div class="col">-->
<!--        <b>Type</b>-->
<!--        <br>-->
<!--        --><?php //echo getOrderTypesSelect(); ?>
<!--    </div>-->

</div>
<div class="row">
    <div style="text-align: center">
<!--        <a href="#"-->
<!--           class="cmd button button-highlight button-pill"-->
<!--           onclick="window.open('../php/ordenes/cancelledOrdersReport.php?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val() + '&orderType=' + $('#orderTypes').val()) ">-->
<!--           Generate-->
<!--        </a>-->
        <input type="button" class="cmd button button-highlight button-pill" value="Generate" onclick="window.open('../php/ordenes/cancelledOrdersReport.php?startDate=' + $('#startDate').val() + '&endDate=' + $('#endDate').val()) ">
    </div>
</div>
<style>
    .row{
        width: 50%;
        margin-left: 25%;
    }
    .col{
        width: 50%;
        float: left;
        text-align: center;
    }
</style>