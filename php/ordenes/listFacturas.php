<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$prov = $_POST["prov"];
$emp = $_POST["emp"];
$separator = $_POST["separator"];

echo getFacturas($prov, $emp, $separator);

function getFacturas($prov, $emp, $separator){
    $data .= "
        <thead>
            <td>&nbsp;</td>
            <td>Factura</td>
            <td>Fecha</td>
            <td>Fecha Pago</td>
            <td>Abonos</td>
            <td>Total</td>
            <td>Saldo</td>
            <td>Detail</td>
            <td>Send</td>
            <td hidden>WD</td>
        </thead>
    ";
    //wd
    $data .= getTableData($prov, true, $separator);
    //02
    $data .= getTableData($prov, false, $separator, $emp);

    if(count($data) > 0){
        $table = "
            <table id='facTable'>
            <colgroup>
               <col span=\"1\" style=\"width: 5%;\">
               <col span=\"1\" style=\"width: 20%;\">
               <col span=\"1\" style=\"width: 12%;\">
               <col span=\"1\" style=\"width: 12%;\">
               <col span=\"1\" style=\"width: 10.75%;\">
               <col span=\"1\" style=\"width: 10.75%;\">
               <col span=\"1\" style=\"width: 10.75%;\">
               <col span=\"1\" style=\"width: 8%;\">
               <col span=\"1\" style=\"width: 10%;\">
            </colgroup>
                $data
            </table>
        ";
        $response = $table;
    }
    else{
        $message = "no data...";
        $response = $message;
    }

    return $response;
}

function getTableData($prov, $wd, $separator, $emp = null){

    $query = "
        SELECT 
            codfact, serie, numero, fecha, fechpago, abonos, total
        FROM
            tra_fact_enc
        WHERE
            codclie = '$prov' AND (total - abonos) > 0 ORDER BY fecha ASC;
    ";

    if($wd){
        $result = mysqli_query(rconexion04(), $query);
    }

    else{
        $result = mysqli_query(conexion($emp), $query);
    }

    if($result->num_rows > 0){
        $tEmp = ($wd) ? "wd" : $emp;
        while ($row = mysqli_fetch_array($result)){
            $id = $row["codfact"];
            $tSerie = $row["serie"];
            $tNumero = $row["numero"];
            $tFecha = explode(" ", $row["fecha"])[0];
            $tFechaPago = explode(" ", $row["fechpago"])[0];
            $tAbonos = "$" . number_format((float)$row["abonos"], 2, '.', '');
            $tTotal = "$" . number_format((float)$row["total"], 2, '.', '');

            //
            $q = "select * from tra_pp_det where fac_id = '$id' ORDER BY tries desc limit 1";
            if($wd == "wd"){
                $r = mysqli_query(rconexion04(), $q);
            }

            else{
                $r = mysqli_query(conexion($tEmp), $q);
            }

            $tStatus = "&nbsp;";
            $tAction = "<td align='left'><img onclick='sendInvoice(\"$id\", \"$tEmp\", \"$separator\");' src='/images/email.png'/></td>";
            $tCheckbox = "<td><input type='checkbox' name='generate' value='$id'></td>";
            $tDetail = "<td>&nbsp;</td>";
            if($r->num_rows == 1){
                $rr = mysqli_fetch_array($r);
                $tStatusType = $rr["status"];
                $tTries = $rr["tries"];
                $tTransaction = $rr["transaction"];

                $tStatus = "$tStatusType - $tTries";
                $tAction = "<td align='left'><img onclick='remindInvoice(\"$tTransaction\", \"$tEmp\");' src='/images/email.png'/> x $tTries</td>";
                $tCheckbox = "<td><input type='checkbox' name='remind' value='$tTransaction'></td>";

                //details
                $tDetail = "<td><img onclick='detailInvoice(\"$tTransaction\", \"$tEmp\");' src='/images/document.png'/></td>";
            }
            $tSaldo =  "$" . number_format(floatval($row["total"]) - floatval($row["abonos"]), 2, '.', '');
            $data .= "
                <tr>
                    $tCheckbox
                    <td>$tSerie$separator$tNumero</td>
                    <td>$tFecha</td>
                    <td>$tFechaPago</td>
                    <td>$tAbonos</td>
                    <td>$tTotal</td>
                    <td>$tSaldo</td>
                    $tDetail
                    $tAction
                    <td hidden>$wd</td>
                </tr>
            ";
        }

        return $data;
    }
}