    <?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "getCountryExpenses":
            $cantidad = $_POST["quantity"];
            $tipo = $_POST["tipo"];
            $empCantidad = $_POST["empQuantity"];
            $isPallet = ($_POST["isPallet"] == "true") ? "1" : "2";
            $isRefri = ($_POST["isRefri"] == "refrigerado") ? "1" : "2";
            $tipoTarifa = $_POST["tipoTarifa"];
            echo getCountryExpenses($cantidad, $tipo, $empCantidad, $isPallet, $tipoTarifa, $isRefri);
            break;

        case "getUSAExpenses":
            $cantidad = $_POST["quantity"];
            $tipo = $_POST["tipo"];
            $empCantidad = $_POST["empQuantity"];
            $isPallet = ($_POST["isPallet"] == "true") ? "1" : "2";
            $isRefri = ($_POST["isRefri"] == "refrigerado") ? "1" : "2";
            $tipoTarifa = $_POST["tipoTarifa"];
            echo getUSAExpenses($cantidad, $tipo, $empCantidad, $isPallet, $tipoTarifa, $isRefri);
            break;

        case "getSummary":
            $cantidad = $_POST["quantity"];
            $empCantidad = $_POST["empQuantity"];
            echo getSummary($cantidad, $empCantidad);
            break;

        case "saveData":
            $NOMBRE = $_POST["NOMBRE"];
            $CLIENTES = $_POST["CLIENTES"];
            $TIPO = $_POST["TIPO"];
            $ESPALLET = ($_POST["ESPALLET"] == "true") ? "1" : "0";
            $ESREFRI = ($_POST["ESREFRI"] == "refrigerado") ? "1" : "0";
            $CANTIDAD = $_POST["CANTIDAD"];
            $TARIFA = $_POST["TARIFA"];
            $FECHA = $_POST["FECHA"];
            $SIGNATURE = $_POST["SIGNATURE"];
            $DESCDIR = $_POST["DESCDIR"];
            $DESCPOR = $_POST["DESCPOR"];
            $bloque1 = $_POST['bloque1'];
            $bloque2 = $_POST['bloque2'];
            echo saveData($NOMBRE, $CLIENTES, $TIPO, $ESPALLET, $CANTIDAD, $TARIFA, $FECHA, $SIGNATURE, $DESCDIR, $DESCPOR, $bloque1, $bloque2, $ESREFRI);
            break;

        case "confirmSearch":
            $DOCID = $_POST["docid"];
            echo confirmSearch($DOCID);
            break;

        case "getContInfo":
            $id = $_POST["id"];
            echo getContInfo($id);
            break;

        case "loadCot":
            $id = $_POST["id"];
            echo loadCot($id);
            break;

        case "loadCotEnc":
            $id = $_POST["id"];
            echo loadCotEnc($id);
            break;
    }
}

if(isset($_GET["method"])) {
    $method = $_GET["method"];
    switch ($method) {
        case "getPDF":
            $DOCID = $_GET["DOCID"];
            echo getPDF($DOCID);
            break;
        case "searchID":
            $term = $_GET["term"];
            echo searchID($term);
            break;
    }
}

function getCountryExpenses($cantidad, $tipo, $empCantidad, $isPallet, $tipoTarifa, $isRefri) {

    $tbody = "";

    $gastosOperativos = "Gastos Operativos";
    $precioTitle = "Precio";
    $cantidadTitle = "Cantidad";
    $totalCostoTitle = "Total Costo";
    $subtotalCostos = "Sub Total Costos Operativos";
    $valoresCotizacion = "Valores de Cotizacion";

    $getCargosQuery = "
        SELECT 
            proy.NOMBRE, proy.APLICA, prod.PVENTA
        FROM
            cat_car_proyecto AS proy
                INNER JOIN
            cat_prod_ven AS prod ON proy.CODIGO = prod.CODIGO
        WHERE
            (proy.APLICA = 'EM' OR proy.APLICA = 'CL')
                AND (UNIDADES = '$tipo' OR UNIDADES = '0')
                AND (ESPALLET = '$isPallet' OR ESPALLET = '0')
                AND (ESREFRI = '$isRefri' OR ESREFRI = '0')
        ORDER BY
            ORDEN;
    ";

    $getCargosResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getCargosQuery);
    $tGrandTotal = "";

    //descuento
    $tDescuento = "1.00";
    if($tipoTarifa == "2"){
        $discountQuery = "
        SELECT 
            discount
        FROM
            cat_emb_desc
        WHERE
            '$cantidad' BETWEEN `from` AND `to`;
        ";

        $tDescuento = getSingleValue($discountQuery);
        $tDescuento = 1 - ($tDescuento / 100);
    }

    while($getCargosRow = mysqli_fetch_array($getCargosResult)){
        $tPrecioValue = $getCargosRow["PVENTA"];
        $tNombre = utf8_encode($getCargosRow["NOMBRE"]);
        $tPrecio = ($getCargosRow["APLICA"] == "EM") ? $tPrecioValue / ($tipo / 2) : $tPrecioValue * $tDescuento;
        $tCantidad = ($getCargosRow["APLICA"] == "CL") ? $empCantidad : $cantidad;
        $tTotal = $tPrecio * $tCantidad;
        $tGrandTotal += $tTotal;

        $tPrecio = number_format($tPrecio, 2);
        $tTotal = number_format($tTotal, 2);

        $tbody .= "
            <tr>
                <td>$tNombre</td>
                <td>$ $tPrecio</td>
                <td>$tCantidad</td>
                <td>$ $tTotal</td>
            </tr>
        ";
    }

    $_SESSION["grandTotalCountry1"] = $tGrandTotal;
    $tGrandTotal = number_format($tGrandTotal, 2);

    $table = "    
        <table id='countryExpensesTable' class='table'> 
            <thead>
                <tr>
                    <td>
                    
                    </td>
                    <td colspan='3'>
                        $valoresCotizacion    
                    </td>
                </tr>
                <tr>
                    <td>
                        $gastosOperativos
                    </td>
                    <td class='td10'>
                        $precioTitle
                    </td>
                    <td class='td10'>
                        $cantidadTitle
                    </td>
                    <td class='td10'>
                        $totalCostoTitle
                    </td>
                </tr>
            </thead>
            <tbody>
                $tbody
            </tbody>
            <tfoot>
                <tr>
                    <td class='bold'>
                        $subtotalCostos                        
                    </td>
                    <td></td>
                    <td></td>
                    <td class='bold'>$ $tGrandTotal</td>
                </tr>
            </tfoot>
        </table>
    ";

    $response = $table;

    return $response;
}

function getUSAExpenses($cantidad, $tipo, $empCantidad, $isPallet, $tipoTarifa, $isRefri) {
    $tbody = "";

    $precioTitle = "Precio";
    $cantidadTitle = "Cantidad";
    $totalCostoTitle = "Total Costo";
    $gastosOperativos = "Gastos Operativos";
    $subtotalCostos = "Sub Total Costos Operativos";

    $getCargosQuery = "
        SELECT 
            proy.NOMBRE, proy.APLICA, prod.PVENTA
        FROM
            cat_car_proyecto AS proy
                INNER JOIN
            cat_prod_ven AS prod ON proy.CODIGO = prod.CODIGO
        WHERE
            (proy.APLICA = 'EM' OR proy.APLICA = 'CL')
                AND (UNIDADES = '$tipo' OR UNIDADES = '0')
                AND (ESPALLET = '$isPallet' OR ESPALLET = '0')
                AND (ESREFRI = '$isRefri' OR ESREFRI = '0')
        ORDER BY
            ORDEN;
    ";

    $getCargosResult = mysqli_query(rconexionProveedorLocal($_SESSION["pais"]), $getCargosQuery);
    $tGrandTotal = "";

    //descuento
    $tDescuento = "1.00";
    if($tipoTarifa == "2"){
        $discountQuery = "
        SELECT 
            discount
        FROM
            cat_emb_desc
        WHERE
            '$cantidad' BETWEEN `from` AND `to`;
        ";

        $tDescuento = getSingleValue($discountQuery);
        $tDescuento = 1 - ($tDescuento / 100);
    }

    while($getCargosRow = mysqli_fetch_array($getCargosResult)){
        $tPrecioValue = $getCargosRow["PVENTA"];
        $tNombre = utf8_encode($getCargosRow["NOMBRE"]);
        $tPrecio = ($getCargosRow["APLICA"] == "EM") ? $tPrecioValue / ($tipo / 2) : $tPrecioValue * $tDescuento;
        $tCantidad = ($getCargosRow["APLICA"] == "CL") ? $empCantidad : $cantidad;
        $tTotal = $tPrecio * $tCantidad;
        $tGrandTotal += $tTotal;

        $tPrecio = number_format($tPrecio, 2);
        $tTotal = number_format($tTotal, 2);

        $tbody .= "
            <tr>
                <td>$tNombre</td>
                <td>$ $tPrecio</td>
                <td>$tCantidad</td>
                <td>$ $tTotal</td>
            </tr>
        ";
    }

    $_SESSION["grandTotalCountry2"] = $tGrandTotal;
    $tGrandTotal = number_format($tGrandTotal, 2);

    $table = "    
        <table id='usaExpensesTable' class='table'>
            <thead>
                    <tr>    
                    <td>
                        $gastosOperativos
                    </td>
                    <td class='td10'>
                        $precioTitle
                    </td>
                    <td class='td10'>
                        $cantidadTitle
                    </td>
                    <td class='td10'>
                        $totalCostoTitle
                    </td>
                </tr>
            </thead>
            $tbody
            <tfoot>
                <tr>
                    <td class='bold'>
                        $subtotalCostos                        
                    </td>
                    <td></td>
                    <td></td>
                    <td class='bold'>$ $tGrandTotal</td>
                </tr>
            </tfoot>
        </table>
    ";

    $response = $table;

    return $response;
}

function getSummary($cantidad, $empCantidad) {
    $tGrandTotal = $_SESSION["grandTotalCountry1"] + $_SESSION["grandTotalCountry2"];

    $totalCostos = "Total Costos";
    $costoEmpresario = "Costo Empresario";
    $costoPallet = "Costo Pallet";

    $totalCostosValor = $tGrandTotal;
    $costoEmpresarioValor = $tGrandTotal / $empCantidad;
    $costoPalletValor = $tGrandTotal / $cantidad;

    $totalCostosValor = number_format($totalCostosValor, 2);
    $costoEmpresarioValor = number_format($costoEmpresarioValor, 2);
    $costoPalletValor = number_format($costoPalletValor, 2);

    $showEmp = "";

    if($_SESSION["rol"] == "U"){
        $showEmp = "
            <tr>
                <td>
                    $costoEmpresario
                </td>
                <td class='td10'></td>
                <td class='td10'></td>
                <td class='td10'>$ $costoEmpresarioValor</td>
            </tr>
        ";
    }

    $table = "    
        <table id='summaryTable' class='table'>
            <thead>
                <tr>
                    <td>
                        $totalCostos
                    </td>
                    <td class='td10'></td>
                    <td class='td10'></td>
                    <td class='td10'>$ $totalCostosValor</td>
                </tr>
                $showEmp
                <tr>
                    <td>
                        $costoPallet
                    </td>
                    <td class='td10'></td>
                    <td class='td10'></td>
                    <td class='td10'>$ $costoPalletValor</td>
                </tr>
            </thead>
        </table>
    ";

    $response = $table;

    return $response;
}

function saveData($NOMBRE, $CLIENTES, $TIPO, $ESPALLET, $CANTIDAD, $TARIFA, $FECHA, $SIGNATURE, $DESCDIR, $DESCPOR, $bloque1, $bloque2, $ESREFRI){
    $getIdQuery = "SELECT (ID + 1) FROM cot_emb_enc ORDER BY ID DESC LIMIT 1;";
    $idResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getIdQuery);
    $id = mysqli_fetch_array($idResult)[0];

    if($id == ""){
        $countryCodeQuery = "SELECT CODIGO FROM direct WHERE nomPais = '".$_SESSION['pais']."';";
        $countryCode = getSingleValue($countryCodeQuery);
        $id = str_pad($countryCode, 8, '0') . '1';
    }

    if($_SESSION["rol"] != "U"){
        $CODPROV = $_SESSION["codprov"];
    }

    $encQuery = "INSERT INTO cot_emb_enc (ID, NOMBRE, CLIENTES, TIPO, ES_PALLET, CANTIDAD, TARIFA, FECHA, SIGNATURE, DESCDIR, DESCPOR, CODPROV, ES_REFRI) VALUES ('$id', '$NOMBRE', '$CLIENTES', '$TIPO', '$ESPALLET', '$CANTIDAD', '$TARIFA', '$FECHA', '$SIGNATURE', '$DESCDIR', '$DESCPOR', '$CODPROV', '$ESREFRI');";
//    echo $encQuery;
    mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $encQuery);

    $dataQuery = "INSERT INTO cot_emb_det (ENC_ID, BLOQUE, CODPROD, PRECIO, CANTIDAD, COSTO) VALUES ";

    //bloque1
    $decodedText1 = html_entity_decode($bloque1);
    $data1 = json_decode($decodedText1, true);

    for ($index = 0; $index < (count($data1)); $index++) {
        if($index > 1 && $index < count($data1) - 1){
            $tEncId = $id;
            $tBloque = "1";
            $tCodprod = addslashes(utf8_decode($data1[$index]["Gastos Operativos"]));
            $tPrecio = str_replace(",","",substr($data1[$index]["Precio"], 2));
            $tCantidad = $data1[$index]["Cantidad"];
            $tCosto = str_replace(",","",substr($data1[$index]["Total Costo"], 2));
            $dataQuery .= "('$tEncId','$tBloque','$tCodprod','$tPrecio','$tCantidad','$tCosto'),";
        }
    }

    //bloque2
    $decodedText2 = html_entity_decode($bloque2);
    $data2 = json_decode($decodedText2, true);

    for ($index = 0; $index < (count($data2)); $index++) {
        if($index < count($data2) - 1){
            $tEncId = $id;
            $tBloque = "2";
            $tCodprod = addslashes(utf8_decode($data2[$index]["Gastos Operativos"]));
            $tPrecio = str_replace(",","",substr($data2[$index]["Precio"],2));
            $tCantidad = $data2[$index]["Cantidad"];
            $tCosto = str_replace(",","",substr($data2[$index]["Total Costo"],2));
            $dataQuery .= "('$tEncId','$tBloque','$tCodprod','$tPrecio','$tCantidad','$tCosto'),";
        }
    }

    $dataQuery = substr($dataQuery, 0, -1);
//    echo $dataQuery;
    mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $dataQuery);
    return $id;
}

function getPDF($DOCID){

    $b1Total = "";
    $b2Total = "";

    $frame = "1";
    $width = "40";
    $extraWidth = "20";
    $widthSmall = "25";
    $widthLarge = "110";
    $height = "5";
    $font = "Arial";
    $size = "10";
    $newLine = $height;
    $encMult = 2;

    $getEncQuery = "
        SELECT 
            *
        FROM
            cot_emb_enc
        WHERE ID = '$DOCID';
    ";

    $getEncResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getEncQuery);
    $getEncRow = mysqli_fetch_array($getEncResult);

    $idTitle = "ID";
    $idValue = $getEncRow["ID"];

    $nombreTitle = "Nombre:";
    $nombreValue = $getEncRow["NOMBRE"];

    $clientesTitle = "Cantidad de Clientes:";
    $clientesValue = $getEncRow["CLIENTES"];

    $tipoTitle = "Tipo de Contenedor:";
    $tipoValue = $getEncRow["TIPO"];

    $esPalletTitle = "Es Paletizado?:";
    $esPalletValue = ($getEncRow["ES_PALLET"] == "1") ? "Si" : "No";

    $esRefriValue = ($getEncRow["ES_REFRI"] == "1") ? "refrigerado" : "seco";

    $cantidadTitle = "Cantidad de Palets:";
    $cantidadValue = $getEncRow["CANTIDAD"];

    /*
    $tarifaTitle = "Tipo de Tarifa:";
    $tarifaValue = ($getEncRow["TARIFA"] == "1") ? "Fijo" : "Descuento";
    */

    $fechaTitle = "Fecha:";
    $fechaValue = explode(" ", $getEncRow["FECHA"])[0];

    $signatureValue = $getEncRow["SIGNATURE"];
    $descDirValue = $getEncRow["DESCDIR"];
    $descPorValue = $getEncRow["DESCPOR"];

    $empInfoQuery = "
        SELECT 
            DIRECCION, DIRECCION2, TELEFONO, WWW, EMAIL
        FROM
            cat_empresas
        WHERE
            CODEMPRESA = '".$_SESSION["codEmpresa"]."';
    ";

    $empInfoResult = mysqli_query(conexion(""), $empInfoQuery);
    $empInfoRow = mysqli_fetch_array($empInfoResult);

    //enc
    $dir = $empInfoRow["DIRECCION"];
    $dir2 = $empInfoRow["DIRECCION2"];
    $tel = $empInfoRow["TELEFONO"];
    $web = $empInfoRow["WWW"];
    $mail = $empInfoRow["EMAIL"];

    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/lib/fpdf181/fpdf.php");

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Ln("10");
    //LOGO
    $pdf->SetFont($font,"B",18);
    $pdf->Cell($width,$height,"Cotizacion de Embarque");
    $pdf->Image("../../images/paises/".$_SESSION["pais"].".png",110,15,75);
    $pdf->Ln(10);
    //ID
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($width,$height,$idTitle,$frame);
    $pdf->SetFont($font,"",$size);
    $pdf->Cell($width + $extraWidth,$height,$idValue,$frame);
    $pdf->Ln($newLine);
    //NOMBRE
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($width,$height,$nombreTitle,$frame);
    $pdf->SetFont($font,"",$size);
    $pdf->Cell($width + $extraWidth,$height,$nombreValue,$frame);
    $pdf->Ln($newLine);
    if(intval($clientesValue) > 1){
        //CLIENTES
        $pdf->SetFont($font,"B",$size);
        $pdf->Cell($width,$height,$clientesTitle,$frame);
        $pdf->SetFont($font,"",$size);
        $pdf->Cell($width + $extraWidth,$height,$clientesValue,$frame);
        $pdf->Ln($newLine);
    }
    //TIPO
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($width,$height,$tipoTitle,$frame);
    $pdf->SetFont($font,"",$size);
    $pdf->Cell($width + $extraWidth,$height,$tipoValue . "' $esRefriValue",$frame);
    //enc dir
    $pdf->SetFont($font,"",8);
    $pdf->Cell($width*$encMult,$height,$dir,0,0,"C");
    $pdf->Ln($newLine);
    //ESPALLET
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($width,$height,$esPalletTitle,$frame);
    $pdf->SetFont($font,"",$size);
    $pdf->Cell($width + $extraWidth,$height,$esPalletValue,$frame);
    //enc dir2
    $pdf->SetFont($font,"",8);
    $pdf->Cell($width*$encMult,$height,$dir2,0,0,"C");
    $pdf->Ln($newLine);
    //CANTIDAD
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($width,$height,$cantidadTitle,$frame);
    $pdf->SetFont($font,"",$size);
    $pdf->Cell($width + $extraWidth,$height,$cantidadValue,$frame);
    //enc tel
    $pdf->SetFont($font,"",8);
    $pdf->Cell($width*$encMult,$height,$tel,0,0,"C");
    $pdf->Ln($newLine);
    /*
    //TARIFA
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($width,$height,$tarifaTitle,$frame);
    $pdf->SetFont($font,"",$size);
    $pdf->Cell($width + $extraWidth,$height,$tarifaValue,$frame);
    */
    //FECHA
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($width,$height,$fechaTitle,$frame);
    $pdf->SetFont($font,"",$size);
    $pdf->Cell($width + $extraWidth,$height,$fechaValue,$frame);
    //enc web
    $pdf->SetFont($font,"",8);
    $pdf->Cell($width*$encMult,$height,$web,0,0,"C");
    $pdf->Ln($newLine);

    //enc mail
    $pdf->SetFont($font,"",8);
    $pdf->Cell(200 + $width*$encMult,$height,$mail,0,0,"C");

    $pdf->Ln($newLine);

    $pdf->Ln("10");

    $getDetQuery = "
        SELECT 
            *
        FROM
            cot_emb_det
        WHERE
            ENC_ID = '$DOCID'
        AND
            BLOQUE = '1';
    ";

    $getDetResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getDetQuery);

    //Enc1
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($widthLarge,$height,"",$frame);
    $pdf->Cell($widthSmall * 3,$height,"Valores de Cotizacion",$frame, 0, "C");
    $pdf->Ln($newLine);

    $pdf->Cell($widthLarge,$height,"Descripcion",$frame,0,"C");
    $pdf->Cell($widthSmall,$height,"Precio",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"Cantidad",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"Total Costo",$frame, 0, "C");
    $pdf->Ln($newLine);

    while($getDetRow = mysqli_fetch_array($getDetResult)){
        //FECHA
        $pdf->SetFont($font,"",$size);
        $pdf->Cell($widthLarge,$height,$getDetRow["CODPROD"],$frame);
        $pdf->Cell($widthSmall,$height,"$ " . number_format($getDetRow["PRECIO"], 2),$frame,0,"R");
        $pdf->Cell($widthSmall,$height,$getDetRow["CANTIDAD"],$frame,0,"C");
        $pdf->Cell($widthSmall,$height,"$ " . number_format($getDetRow["COSTO"], 2),$frame,0,"R");
        $pdf->Ln($newLine);
        $b1Total += floatval($getDetRow["COSTO"]);
    }

    //Foot1
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($widthLarge,$height,"Sub Total Costos Operativos Origen",$frame);
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"$ " . number_format($b1Total, 2),$frame, 0, "R");
    $pdf->Ln($newLine);

    $pdf->Ln("5");

    $getDetQuery = "
        SELECT 
            *
        FROM
            cot_emb_det
        WHERE
            ENC_ID = '$DOCID'
        AND
            BLOQUE = '2';
    ";

    $getDetResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getDetQuery);

    /*
    //Enc1
    $pdf->Cell($widthLarge,$height,"",$frame);
    $pdf->Cell($widthSmall,$height,"Precio",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"Cantidad",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"Total Costo",$frame, 0, "C");
    $pdf->Ln($newLine);
    */
    while($getDetRow = mysqli_fetch_array($getDetResult)){
        //FECHA
        $pdf->SetFont($font,"",$size);
        $pdf->Cell($widthLarge,$height,$getDetRow["CODPROD"],$frame);
        $pdf->Cell($widthSmall,$height,"$ " . number_format($getDetRow["PRECIO"], 2),$frame,0,"R");
        $pdf->Cell($widthSmall,$height,$getDetRow["CANTIDAD"],$frame,0,"C");
        $pdf->Cell($widthSmall,$height,"$ " . number_format($getDetRow["COSTO"], 2),$frame,0,"R");
        $pdf->Ln($newLine);
        $b2Total += floatval($getDetRow["COSTO"]);
    }

    //Foot1
    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($widthLarge,$height,"Sub Total Costos Operativos USA",$frame);
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"$ " . number_format($b2Total, 2),$frame, 0, "R");
    $pdf->Ln($newLine);

    //Foot1
    $pdf->Ln("5");

    $pdf->SetFont($font,"B",$size);
    $pdf->Cell($widthLarge,$height,"Total Costos",$frame);
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"$ " . number_format(($b1Total + $b2Total),2),$frame, 0, "R");
    $pdf->Ln($newLine);
    if(intval($clientesValue) > 1){
        $pdf->Cell($widthLarge,$height,"Costo Empresario",$frame);
        $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
        $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
        $pdf->Cell($widthSmall,$height,"$ " . number_format(($b1Total + $b2Total) / $clientesValue,2),$frame, 0, "R");
        $pdf->Ln($newLine);
    }

    $tTotal = ($b1Total + $b2Total) / $cantidadValue;
    $pdf->Cell($widthLarge,$height,"Costo Pallet",$frame);
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"$ " . number_format($tTotal, 2),$frame, 0, "R");
    $pdf->Ln($newLine);

    if($descDirValue != '0.00'){
        $pdf->Cell($widthLarge,$height,"Descuento Directo",$frame);
        $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
        $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
        $pdf->Cell($widthSmall,$height,"- $ " . number_format(($descDirValue),2),$frame, 0, "R");
        $pdf->Ln($newLine);
    }
    if($descPorValue != '0.00'){
        $pdf->Cell($widthLarge,$height,"Descuento Porcentaje",$frame);
        $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
        $pdf->Cell($widthSmall,$height,"$descPorValue%",$frame, 0, "C");
        $pdf->Cell($widthSmall,$height,"- $ " . number_format(($tTotal * $descPorValue / 100),2),$frame, 0, "R");
        $pdf->Ln($newLine);
    }

/*
    $pdf->Cell($widthLarge,$height,"TOTAL",$frame);
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"",$frame, 0, "C");
    $pdf->Cell($widthSmall,$height,"$ " . number_format(($tTotal - $descDirValue - ($tTotal * $descPorValue / 100)),2),$frame, 0, "R");
    $pdf->Ln($newLine);
*/
    //Foot1
    $pdf->Ln("30");
    $frame = "0";
    //ID
    if($signatureValue != ""){
        if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/imagenes/firmas/$signatureValue.jpg")){
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . "/imagenes/firmas/$signatureValue.jpg",10,215,95);
            $pdf->Ln(30);
            //FECHA
            $pdf->SetFont($font,"B",$size);
            $pdf->Cell($width,$height,date("Y-m-d H:m:s"),$frame);
            $pdf->Ln($newLine);
        }
        else{
            /*
            $pdf->SetFont($font,"B",$size);
            $pdf->Cell($width,$height,$_SESSION["nomEmpresa"] . " - " . $_SESSION["pais"],$frame);
            $pdf->Ln($newLine);
            if($_SESSION["rol"] == "P"){
                //PROVEEDOR
                $pdf->SetFont($font,"B",$size);
                $pdf->Cell($width,$height,$_SESSION["nomEmpresa"],$frame);
                $pdf->Ln($newLine);
            }
            */
            $codUsua = $signatureValue;
            $infoQuery = "
            SELECT 
                NOMBRE, APELLIDO
            FROM
                sigef_usuarios
            WHERE
                CODUSUA = '$codUsua';
        ";

            $infoResult = mysqli_query(conexion(""), $infoQuery);
            $info = mysqli_fetch_array($infoResult);
            //USUARIO
            $pdf->SetFont($font,"B",$size);
            $pdf->Cell($width,$height,$info["NOMBRE"] . " " . $info["APELLIDO"],$frame);
            $pdf->Ln($newLine);

            //FECHA
            $pdf->SetFont($font,"B",$size);
            $pdf->Cell($width,$height,date("Y-m-d H:m:s"),$frame);
            $pdf->Ln($newLine);
        }
    }

    else{

            $pdf->SetFont($font,"B",$size);
            $pdf->Cell($width,$height,$_SESSION["nomEmpresa"] . " - " . $_SESSION["pais"],$frame);
            $pdf->Ln($newLine);
            if($_SESSION["rol"] == "P"){
                //PROVEEDOR
                $pdf->SetFont($font,"B",$size);
                $pdf->Cell($width,$height,$_SESSION["nomEmpresa"],$frame);
                $pdf->Ln($newLine);
            }
        //USUARIO
        $pdf->SetFont($font,"B",$size);
        $pdf->Cell($width,$height,$_SESSION["nom"] . " " . $_SESSION["apel"],$frame);
        $pdf->Ln($newLine);

        //FECHA
        $pdf->SetFont($font,"B",$size);
        $pdf->Cell($width,$height,date("Y-m-d H:m:s"),$frame);
        $pdf->Ln($newLine);
    }

    $pdf->Output("I", "$DOCID.pdf");
}

function searchID($term){
    $query = "
        SELECT ID FROM cot_emb_enc WHERE ID LIKE '%$term%';
    ";

    $result = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $query);

    while ($row = mysqli_fetch_array($result)) {
        $data[] = $row['ID'];
    }

    return json_encode($data);
}

function confirmSearch($docid){
    $query = "
        SELECT count(*) FROM cot_emb_enc WHERE ID = '$docid';
    ";
    $result = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $query);
    $response = mysqli_fetch_array($result)[0];
    return $response;
}

function getList(){
    $tbody = "";
    $codprov = $_SESSION["codprov"];
    $query = "
    SELECT 
        ID, FECHA, NOMBRE
    FROM
        cot_emb_enc
    WHERE
        CODPROV = '$codprov'
    ORDER BY FECHA DESC;
    ";

    $result = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $query);

    while($row = mysqli_fetch_array($result)){
        $id = $row["ID"];
        $nombre = $row["NOMBRE"];
        $fecha = explode(" ",$row["FECHA"])[0];
        $pdf = "pdf";
        $tbody .= "
            <tr>
                <td>$id</td>
                <td>$fecha</td>
                <td>$nombre</td>
                <td><image docid='$id' class='getPDF' src='../../images/down.png'></image></td>
            </tr>
        ";
    }

    $table = "    
        <table id='summaryTable' class='table'>
            <thead>
                <tr>
                    <td>
                        id
                    </td>
                    <td>
                        fecha
                    </td>
                    <td class='td50'>
                        nombre
                    </td>
                    <td>
                        pdf
                    </td>
                </tr>
            </thead>
            <tbody>
                $tbody
            </tbody>
        </table>
    ";

    $response = $table;

    return $response;
}

function getContInfo($id){
    $response = "";

    $titleTara = "Tara:";
    $titleCarga = "Carga:";
    $titleMax = "Max:";
    $titleCapacidad = "Capacidad:";
    $titleDescripcion = "Descripcion:";
    $titleLargo = "Largo:";
    $titleAncho = "Ancho:";
    $titleAltura = "Altura:";
    $titleInternas = "Internas";
    $titleApertura = "Apertura";
    $titleMedidas = "Medidas";

    $contInfoQuery = "
        SELECT 
            *
        FROM
            cat_cont_info
        WHERE
            ID = '$id';
    ";

    $contInfoResult = mysqli_query(conexion(""), $contInfoQuery);
    $contInfoRow = mysqli_fetch_array($contInfoResult);

    $valueTara = utf8_encode($contInfoRow["TARA"]);
    $valueCarga = utf8_encode($contInfoRow["CARGA"]);
    $valueMax = utf8_encode($contInfoRow["MAX"]);
    $valueCapacidad = utf8_encode($contInfoRow["CAPACIDAD"]);
    $valueDescripcion = utf8_encode($contInfoRow["DESCRIPCION"]);
    $valueLargoInterno = utf8_encode($contInfoRow["LARGO_INTERNO"]);
    $valueLargoApertura = utf8_encode($contInfoRow["LARGO_APERTURA"]);
    $valueAnchoInterno = utf8_encode($contInfoRow["ANCHO_INTERNO"]);
    $valueAnchoApertura = utf8_encode($contInfoRow["ANCHO_APERTURA"]);
    $valueAlturaInterna = utf8_encode($contInfoRow["ALTURA_INTERNA"]);
    $valueAlturaApertura = utf8_encode($contInfoRow["ALTURA_APERTURA"]);

    $response = "
        <div class='row'>
            <div class='stackHorizontally customLeft'>
                <image src='../../images/contenedores/".$id.".gif'>
            </div>
            <div class='stackHorizontally customRight'>
                <table id='contDescription'>
                    <tbody>
                        <tr>
                            <td class='bold alignRight smallCell'>$titleTara</td>
                            <td colspan='2' class=''>$valueTara</td>
                        </tr>
                        <tr>
                            <td class='bold alignRight smallCell'>$titleCarga</td>
                            <td colspan='2' class=''>$valueCarga</td>
                        </tr>
                        <tr>
                            <td class='bold alignRight smallCell'>$titleMax</td>
                            <td colspan='2' class=''>$valueMax</td>
                        </tr>
    
                    <tr>
                        <td class='bold smallCell alignRight'>$titleMedidas</td>
                        <td class='bold'>$titleInternas</td>
                        <td class='bold'>$titleApertura</td>
                    </tr>
                    <tr>
                        <td class='bold smallCell alignRight'>$titleLargo</td>
                        <td>$valueLargoInterno</td>
                        <td>$valueLargoApertura</td>
                    </tr>
                    <tr>
                        <td class='bold smallCell alignRight'>$titleAncho</td>
                        <td>$valueAnchoInterno</td>
                        <td>$valueAnchoApertura</td>
                    </tr>
                    <tr>
                        <td class='bold smallCell alignRight'>$titleAltura</td>
                        <td>$valueAlturaInterna</td>
                        <td>$valueAlturaApertura</td>
                    </tr>
    
                    <tr>
                        <td class='alignRight bold smallCell'>$titleCapacidad</td>
                        <td colspan='2' class=''>$valueCapacidad</td>
                    </tr>
                    <tr>
                        <td class='alignRight bold smallCell'>$titleDescripcion</td>
                        <td colspan='2' class=''>$valueDescripcion</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    ";
    return $response;
}

function loadCot($id){

    $tGrandTotalCountry = "";
    $tbodyCountry = "";
    $tGrandTotalUSA = "";
    $tbodyUSA = "";

    //labels
    $gastosOperativos = "Gastos Operativos";
    $precioTitle = "Precio";
    $cantidadTitle = "Cantidad";
    $totalCostoTitle = "Total Costo";
    $subtotalCostos = "Sub Total Costos Operativos";
    $valoresCotizacion = "Valores de Cotizacion";
    $totalCostos = "Total Costos";
    $costoEmpresario = "Costo Empresario";
    $costoPallet = "Costo Pallet";

    //enc
    $getEncQuery = "
        SELECT 
            *
        FROM
            cot_emb_enc
        WHERE ID = '$id';
    ";

    $getEncResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getEncQuery);
    $getEncRow = mysqli_fetch_array($getEncResult);
    $idValue = $getEncRow["ID"];

    $nombreValue = $getEncRow["NOMBRE"];
    $clientesValue = $getEncRow["CLIENTES"];
    $tipoValue = $getEncRow["TIPO"];
    $esPalletValue = ($getEncRow["ES_PALLET"] == "1") ? "Si" : "No";
    $esRefriValue = ($getEncRow["ES_REFRI"] == "1") ? "refrigerado" : "seco";
    $cantidadValue = $getEncRow["CANTIDAD"];
    $tarifaValue = ($getEncRow["TARIFA"] == "1") ? "Fijo" : "Descuento";
    $fechaValue = explode(" ", $getEncRow["FECHA"])[0];

    //det
    $getDetQuery = "
        SELECT 
            *
        FROM
            cot_emb_det
        WHERE
            ENC_ID = '$id'
        AND
            BLOQUE = '1';
    ";

    $getDetResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getDetQuery);

    while($getCargosRow = mysqli_fetch_array($getDetResult)){
        $tNombre = utf8_encode($getCargosRow["CODPROD"]);
        $tPrecio = $getCargosRow["PRECIO"];
        $tCantidad = $getCargosRow["CANTIDAD"];
        $tTotal = $getCargosRow["COSTO"];
        $tGrandTotalCountry += $tTotal;

        $tPrecio = number_format($tPrecio, 2);
        $tTotal = number_format($tTotal, 2);

        $tbodyCountry .= "
            <tr>
                <td>$tNombre</td>
                <td>$ $tPrecio</td>
                <td>$tCantidad</td>
                <td>$ $tTotal</td>
            </tr>
        ";
    }

    $tGrandTotalCountryValue = number_format($tGrandTotalCountry, 2);


    $country = "    
        <table id='countryExpensesTable' class='table'> 
            <thead>
                <tr>
                    <td>
                    
                    </td>
                    <td colspan='3'>
                        $valoresCotizacion    
                    </td>
                </tr>
                <tr>
                    <td>
                        $gastosOperativos
                    </td>
                    <td class='td10'>
                        $precioTitle
                    </td>
                    <td class='td10'>
                        $cantidadTitle
                    </td>
                    <td class='td10'>
                        $totalCostoTitle
                    </td>
                </tr>
            </thead>
            <tbody>
                $tbodyCountry
            </tbody>
            <tfoot>
                <tr>
                    <td class='bold'>
                        $subtotalCostos                        
                    </td>
                    <td></td>
                    <td></td>
                    <td class='bold'>$ $tGrandTotalCountryValue</td>
                </tr>
            </tfoot>
        </table>
    ";

    $getDetQuery = "
        SELECT 
            *
        FROM
            cot_emb_det
        WHERE
            ENC_ID = '$id'
        AND
            BLOQUE = '2';
    ";

    $getDetResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getDetQuery);

    while($getCargosRow = mysqli_fetch_array($getDetResult)){
        $tNombre = utf8_encode($getCargosRow["CODPROD"]);
        $tPrecio = $getCargosRow["PRECIO"];
        $tCantidad = $getCargosRow["CANTIDAD"];
        $tTotal = $getCargosRow["COSTO"];
        $tGrandTotalUSA += $tTotal;

        $tPrecio = number_format($tPrecio, 2);
        $tTotal = number_format($tTotal, 2);

        $tbodyUSA .= "
            <tr>
                <td>$tNombre</td>
                <td>$ $tPrecio</td>
                <td>$tCantidad</td>
                <td>$ $tTotal</td>
            </tr>
        ";
    }

    $tGrandTotalUSAValue = number_format($tGrandTotalUSA, 2);

    $usa = "    
        <table id='usaExpensesTable' class='table'>
            <thead>
                    <tr>    
                    <td>
                        $gastosOperativos
                    </td>
                    <td class='td10'>
                        $precioTitle
                    </td>
                    <td class='td10'>
                        $cantidadTitle
                    </td>
                    <td class='td10'>
                        $totalCostoTitle
                    </td>
                </tr>
            </thead>
            $tbodyUSA
            <tfoot>
                <tr>
                    <td class='bold'>
                        $subtotalCostos                        
                    </td>
                    <td></td>
                    <td></td>
                    <td class='bold'>$ $tGrandTotalUSAValue</td>
                </tr>
            </tfoot>
        </table>
    ";
    $showEmp = "";

    $tGrandTotal = $tGrandTotalCountry + $tGrandTotalUSA;

    $totalCostosValor = $tGrandTotal;
    $costoEmpresarioValor = $tGrandTotal / $clientesValue;
    $costoPalletValor = $tGrandTotal / $cantidadValue;

    $totalCostosValor = number_format($totalCostosValor, 2);
    $costoEmpresarioValor = number_format($costoEmpresarioValor, 2);
    $costoPalletValor = number_format($costoPalletValor, 2);

    if($_SESSION["rol"] == "U"){
        $showEmp = "
            <tr>
                <td>
                    $costoEmpresario
                </td>
                <td class='td10'></td>
                <td class='td10'></td>
                <td class='td10'>$ $costoEmpresarioValor</td>
            </tr>
        ";
    }
    $summary = "    
        <table id='summaryTable' class='table'>
            <thead>
                <tr>
                    <td>
                        $totalCostos
                    </td>
                    <td class='td10'></td>
                    <td class='td10'></td>
                    <td class='td10'>$ $totalCostosValor</td>
                </tr>
                $showEmp
                <tr>
                    <td>
                        $costoPallet
                    </td>
                    <td class='td10'></td>
                    <td class='td10'></td>
                    <td class='td10'>$ $costoPalletValor</td>
                </tr>
            </thead>
        </table>
    ";

    $response = "
        <div id='countryExpenses'>$country</div>
        <div id='usaExpenses'>$usa</div>
        <div id='summary'>$summary</div>
    ";
    return $response;
}

function loadCotEnc($id){
    $getEncQuery = "
        SELECT 
            *
        FROM
            cot_emb_enc
        WHERE ID = '$id';
    ";

    $getEncResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $getEncQuery);
    $getEncRow = mysqli_fetch_assoc($getEncResult);

    $response = json_encode($getEncRow);

    return $response;
}