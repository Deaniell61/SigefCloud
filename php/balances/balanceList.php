<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
function getListTable() {

    $balancesQuery = "
        SELECT 
            codbalance, inicia, termina, estatus
        FROM
            cat_bal_cobro;
    ";

    $balancesResult = mysqli_query(conexion(""), $balancesQuery);
//    var_dump($balancesResult);
//    echo "<br><br>";
    while ($balancesRow = mysqli_fetch_array($balancesResult)) {
        $tIni = date_format(date_create(explode(" ", $balancesRow["inicia"])[0]), "M d, Y");
        $tIni1 = date_format(date_create(explode(" ", $balancesRow["inicia"])[0]), "M j, Y");
        $tFin = date_format(date_create(explode(" ", $balancesRow["termina"])[0]), "M d, Y");
        $tFin1 = date_format(date_create(explode(" ", $balancesRow["termina"])[0]), "M j, Y");
        $balancesNames[$balancesRow["codbalance"]] = "$tIni1 - $tFin1";
        $tEstatus = ($balancesRow["estatus"] == 1) ? "" : "(Abierto)";
        $balances[$balancesRow["codbalance"]] = "$tIni - $tFin $tEstatus";
    }

    $codProv = $_SESSION["codprov"];
//    echo $codProv;
    $listQuery = "
        SELECT 
            *
        FROM
            tra_balances
        WHERE
            CODPROV = '$codProv'
        ORDER BY CODIGOBAL DESC;
    ";

    $listResult = mysqli_query(conexion($_SESSION["pais"]), $listQuery);
    $table = "";

    $tNomProv = $_SESSION["nomProv"];
    $tNomProv = str_replace(" ", "_", $tNomProv);
    $lastChar = substr($tNomProv, -1, 1);
    if($lastChar == "_"){
        $tNomProv = substr($tNomProv, 0, -1);
    }
    $tNomProv = strtolower($tNomProv);
    $pdfBasePath = $_SERVER["DOCUMENT_ROOT"] . "/imagenes/proveedores/balances/$tNomProv/";
    $pdfBasePath = "../../imagenes/proveedores/balances/$tNomProv/";
    $balCont = 1;
    while ($listRow = mysqli_fetch_array($listResult)) {
//        if($balances[$listRow["CODBALANCE"]] != ""){
        $codigo = $listRow["CODBALANCE"];
        $tBalance = str_pad($balCont, 2, "0", STR_PAD_LEFT) . ". " . $balances[$listRow["CODBALANCE"]];
        $tSalddoInicial = $listRow["SALDO_INI"];
        $tVentaProductos = $listRow["TOTALING"];
        $tCargosCanal = $listRow["CANALCAR"];
        $tOtrosCargos = $listRow["OTROSCAR"];
        $tLiquido = $listRow["LIQUIDO"];
        $tSaldoFinal = $listRow["SALDO"];
        $pdfName = $balancesNames[$listRow["CODBALANCE"]] . "_-_" . $_SESSION["nomProv"];
        $pdfName = str_replace(",", "", $pdfName);
        $pdfName = str_replace(" ", "_", $pdfName);
        $lastChar = substr($pdfName, -1, 1);
        if($lastChar == "_"){
            $pdfName = substr($pdfName, 0, -1);
        }
        $pdfName = strtolower($pdfName);
        $pdfName = "balance_-_$pdfName.pdf";
        $pdfName = str_replace("..", ".", $pdfName);
        $pdfPath = $pdfBasePath . $pdfName;
//        echo $pdfPath;
        $pdf = "";
        if (file_exists($pdfPath)){
            $pdf = "
                <a href='$pdfPath' target='_blank'>
                    <img src='../../images/imgpsh_fullsize_3.png'/>
                </a>
                
            ";
        }

            $table .= "
            <tr>
                <td>
                    $tBalance
                </td>
                <td>
                    $tSalddoInicial
                </td>      
                <td>
                    $tVentaProductos
                </td>      
                <td>
                    $tCargosCanal
                </td>      
                <td>
                    $tOtrosCargos
                </td>      
                <td>
                    $tLiquido
                </td>      
                <td>
                    $tSaldoFinal
                </td>      
                <td>
                    <img src='../../images/zoom.png' id='$codigo' class='balanceCodigo'/>
                    $pdf
                </td>            
            </tr>
        ";
            $balCont += 1;
//        }
    }

    return $table;
}

?>
<div id="container">
    <table id="balancesTable" class="cell-border">
        <thead>
        <tr>
            <td>
                Balance
            </td>
            <td>
                Saldo Inicial
            </td>
            <td>
                Venta de Productos
            </td>
            <td>
                Cargos de Canal
            </td>
            <td>
                Otros Cargos
            </td>
            <td>
                Liquido
            </td>
            <td>
                Saldo Final
            </td>
            <td>
                Detalle
            </td>
        </tr>
        </thead>
        <tbody>
        <?php
        echo getListTable();
        ?>
        </tbody>
    </table>
</div>

<script>
    $(".balanceCodigo").click(function (event) {
        var id = event.target.getAttribute("id");
        $("#tabs").tabs({active: 1});
//        console.log("codigo" + id);
        $("#balanceDrop").val(id);
        $("#balanceDrop").change();
    });

    $("#balancesTable").DataTable({
        "paging": true,
        "filter": false,
        "info": false,
        "scrollY": "500px",
        "scrollCollapse": true,
        "order": [[0, "asc"]]
    });
</script>

<style>
    #container {
        width: 100%;
        height: 100%;
    }

    #balancesTable tr td {
    }
</style>