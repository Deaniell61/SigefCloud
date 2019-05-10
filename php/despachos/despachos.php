<?php
session_start();
require_once('../coneccion.php');
require_once('../fecha.php');
$method = $_POST['method'];
$coddespa;
if ($method == 'getProduct') {
    $codItem = $_POST['codItem'];
    $query = "SELECT 
                product.CODPROD,
                product.PRODNAME, 
                product.PCOSTO,
                presentation.NOMBRE,
                product.NIVPALET,
                product.CAJANIVEL,
                product.UNIVENTA,
                product.PESO
              FROM cat_prod as product 
              INNER JOIN cat_pre_prod as presentation 
              ON product.CODPRES = presentation.CODPREPRO 
              WHERE product.MASTERSKU = '$codItem'
              AND CODPROV = '".$_SESSION['codprov']."';";
    $result = mysqli_query(conexion($_SESSION['pais']), $query);
    if ($result) {
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $response = [
                'status' => '1',
                //'query' => $query,
                'codItem' => $codItem,
                'prodName' => $row['PRODNAME'],
                'prodPresentation' => $row['NOMBRE'],
                'prodCosto' => number_format($row['PCOSTO'], 2),
                'unidadesCaja' => $row['UNIVENTA'],
                'cajasPallet' => ($row['CAJANIVEL'] * $row['NIVPALET']),
                'peso' => $row['PESO'],
                'codProd' => $row['CODPROD'],
            ];
            echo json_encode($response);
        } else {
            $response = [
                'status' => '0',
            ];
            echo json_encode($response);
        }
    }
} else if ($method == 'getList') {
    $urlparam_name = $_GET['name'] . "%";
    $query = "SELECT mastersku FROM cat_prod WHERE mastersku LIKE '$urlparam_name'";
    $result = mysqli_query(conexion($_SESSION['pais']), $query);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $array[] = $row;
            }
        }
    }
    echo json_encode($array);
} else if ($method == 'getDespachos') {
    $query = "SELECT proy.NOMBRE, proy.CODPROY, ped.CODPEDIDO FROM cat_proyectos as proy INNER JOIN tra_ped_enc as ped ON ped.codproy = proy.codproy WHERE proy.estatus = '1';";
    $result = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $array[] = $row;
            }
        }
    }
    echo json_encode($array);
} else if ($method == 'loadDespacho') {
    $coddespa = $_POST['coddespa'];
    $query = "SELECT * FROM tra_des_det WHERE coddespa = '$coddespa';";

    $result = mysqli_query(conexion($_SESSION['pais']), $query);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
            }
        }
    }
    echo json_encode($array);
} else if ($method == 'saveData') {

    $coddespa = $_POST['coddespa'];

    if ($coddespa == '-1') {
        $coddespa = sys2015();
    }
    saveEnc($coddespa);
    usleep(500000);

    $qd1 = "select * from tra_des_det where coddespa = '$coddespa'";
    $rqd1 = mysqli_query(conexion($_SESSION['pais']), $qd1);
    if($rqd1){
        if($rqd1->num_rows > 0){
            while($rwqd1 = mysqli_fetch_array($rqd1)){
                $qd2 = "delete from tra_ped_det where codpdet = '".$rwqd1['codddespa']."'";
                mysqli_query(conexionProveedorLocal($_SESSION['pais']), $qd2);
            }
        }
    }

    $queryDelete = "DELETE FROM tra_des_det WHERE coddespa = '$coddespa';";
    $resultDelete = mysqli_query(conexion($_SESSION['pais']), $queryDelete);

    $jsonText = $_POST['json'];
    $decodedText = html_entity_decode($jsonText);
    $data = json_decode($decodedText, true);

    for ($index = 0; $index < (count($data)); $index++) {
        if ($data[$index]['mastersku'] != ''
            && $data[$index]['mastersku'] != 'Codigo Item'
            && $data[$index]['mastersku'] != 'No data available in table'
        ) {
            $nSys = sys2015();

            $tcanpa = str_replace(',','',$data[$index]['canpa']);
            $tcanca = str_replace(',','',$data[$index]['canca']);
            $tcanun = str_replace(',','',$data[$index]['canun']);
            $tprecundes = str_replace(',','',$data[$index]['precundes']);
            $ttotaldes = str_replace(',','',$data[$index]['totaldes']);
            $tpeso = str_replace(',','',$data[$index]['peso']);

            $insert = "INSERT INTO tra_des_det(codddespa,coddespa,codprod,mastersku,nomprod,presprod,unidespa,canpa,canca,canun,precundes,totaldes,peso) VALUES
        ('" . $nSys . "', '" . $coddespa . "', '" . $data[$index]['codprod'] . "', '" . $data[$index]['mastersku'] . "', '" . $data[$index]['nomprod'] . "', '" . $data[$index]['presprod'] . "',
        '" . getUnidadDespachoCode($data[$index]['unidespa']) . "', '" . $tcanpa . "', '" . $tcanca . "', '" . $tcanun
                . "', '" . $tprecundes . "', '" . $ttotaldes . "', '" . $tpeso . "');";
            mysqli_query(conexion($_SESSION['pais']), $insert);
        }
    }

    echo $coddespa;
}

else if ($method == 'insertarPedidos') {

    include_once ('../updateData/updateData.php');
    $updateData = new updateData();

    $coddespa = $_POST['coddespa'];
    $codpedido = $_POST['codpedido'];

    //clean tra_ped_det
    $qryCleanTraPedDet = "select * from tra_des_det where coddespa = '$coddespa'";
    $resCleanTraPedDet = mysqli_query(conexion($_SESSION['pais']), $qryCleanTraPedDet);
    if($resCleanTraPedDet){
        if($resCleanTraPedDet->num_rows > 0){
            while($row = mysqli_fetch_array($resCleanTraPedDet)){
                $queryDelete1 = "DELETE FROM tra_ped_det WHERE CODPDET = '".$row['codddespa']."';";
                $resultDelete = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $queryDelete1);

                $nPQ = "SELECT codprod, nombre, modelo, peso, pventa FROM cat_prod_ven WHERE codprod = '".$row['codprod']."';";
                $rPQ = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $nPQ);
                $tCODPROD = '';
                $tNOMBRE = '';
                $tPRESENTA = '';
                $tPESO = '';
                $tPRECIO = '';

                if($rPQ){
                    if($rPQ->num_rows > 0){
                        $row1 = mysqli_fetch_row($rPQ);
                        $tCODPROD = $row1[0];
                        $tNOMBRE = $row1[1];
                        $tPRESENTA = $row1[2];
                        $tPESO = $row1[3];
                        $tPRECIO = $row1[4];
                    }
                }


                //aca validar si producto existe
                $updateData->check($updateData::PRODUCTO, $row['codprod']);

                $insert = "
            INSERT INTO tra_ped_det
            (CODPDET,
            CODPEDIDO,
            CODPROD,
            NOMBRE,
            PRESENTA,
            PESO,
            PRECIO,
            CODIGO,
            SURTIDO,
            TOTPRECIO,
            TOTPESO,
            CANTIDAD,
            CODPROV)
            values
            ('".$row['codddespa']."',
            '$codpedido',
            '".$tCODPROD."',
            '".$tNOMBRE."',
            '".$tPRESENTA."',
            '".$tPESO."',
            '".$tPRECIO."',
            '".$row['mastersku']."',
            '1',
            '".(floatval($row['CANCA']) *  floatval($tPRECIO))."',
            '".(floatval($row['CANCA']) * floatval($tPESO))."',
            '".$row['CANCA']."',
            '".$_SESSION['codprov']."');
        ";

                mysqli_query(conexionProveedorLocal($_SESSION['pais']), $insert);
            }
        }
    }

    $updatePedEnc = "UPDATE tra_ped_enc set VTOTAL=(SELECT sum(totprecio) from tra_ped_det where codpedido = '$codpedido'), TUNIDAD=(SELECT sum(cantidad) from tra_ped_det where codpedido = '$codpedido'), TPESO=(SELECT sum(totpeso) from tra_ped_det where codpedido = '$codpedido') WHERE codpedido = '$codpedido'";
    mysqli_query(conexionProveedorLocal($_SESSION['pais']), $updatePedEnc);
}

else if($method == 'loadEnc'){
    $coddespa = $_POST['coddespa'];
    $query = "SELECT 
                numdespa,
                embarque, 
                fechadesp,
                codproy
              FROM tra_des_enc 
              WHERE coddespa = '$coddespa';";
    //echo $query;
    $result = mysqli_query(conexion($_SESSION['pais']), $query);
    if ($result) {
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $response = [
                'numdespa' => $row['numdespa'],
                'embarque' => $row['embarque'],
                'fechadesp' => explode(' ', $row['fechadesp'])[0],
                'codproy' => $row['codproy'],
            ];
            echo json_encode($response);
        }
    }
}

else if($method == 'insertarEncPedidos'){

    $tValor = $_POST['valor'];
    $tPeso = $_POST['peso'];
    $tUnidad = $_POST['unidad'];
    $tCodProy = $_POST['codProy'];
    $tEmbarque = $_POST['embarque'];
    $tCodClie = $_SESSION['codprov'];
    $tCodDespa = $_SESSION['codDespa'];
    $tCodigoClie = '';
    
    $tValor = str_replace(',', '', $tValor);
    $tPeso = str_replace(',', '', $tPeso);
    $tUnidad = str_replace(',', '', $tUnidad);

    $qryCodProy = "SELECT * FROM tra_ped_enc WHERE CODPROY = '$tCodProy';";
    $resCodProy = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $qryCodProy);

    //echo $qryCodProy;

    if($resCodProy){
        if($resCodProy->num_rows < 1){
            $qryCliente = "SELECT codclie, codigo FROM cat_clie WHERE CODCATE = '_2NB0TMQ7D';";
            $resCliente = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $qryCliente);
            if($resCliente){
                if($resCliente->num_rows > 0){
                    $row = mysqli_fetch_assoc($resCliente);
                    $tCodClie = $row['codclie'];
                    $tCodigoClie = $row['codigo'];
                }
                else{
                    $qryCodigo = "SELECT (CODIGO + 1) as CODIGO FROM cat_clie ORDER BY CODIGO DESC LIMIT 1;";
                    $resCodigo = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $qryCodigo);
                    if($resCodigo){
                        if($resCodigo->num_rows > 0){
                            $row = mysqli_fetch_array($resCodigo);
                            $tCodClie = $_SESSION['codprov'];
                            $tCodigoClie = $row['codigo'];
                        }
                    }
                    $IC = "INSERT INTO cat_clie (CODCLIE, CODIGO) values ('".$_SESSION['codprov']."', '".$tCodigoClie."');";
                    mysqli_query(conexionProveedorLocal($_SESSION['pais']),$IC);
                }
            }

            $codPedido = sys2015();

            $pedEnc = "
        INSERT INTO tra_ped_enc (
          CODPEDIDO,
          NUMERO,
          FECHA,
          CODCLIE,
          CODSTAR,
          VTOTAL,
          TUNIDAD,
          TPESO,
          ESTATUS,
          SURTIDO,
          TASA,
          CODPROY,
          NOMPROY,
          CODMONE) 
        VALUES (
          '$codPedido',
          '".getPedNumero()."',
          '".date('Y-m-d')."',
          '".$tCodClie."',
          '".$tCodigoClie."',
          '".$tValor."',
          '".$tUnidad."',
          '".$tPeso."',
          'PROCESO',
          '1',
          '7.60',
          '".$tCodProy."',
          '".$tEmbarque."',
          '_2UZ0HQ6ZZ'
        );";
            $resPedEnc = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $pedEnc);
        }

        else{
            $row = mysqli_fetch_assoc($resCodProy);
            $codPedido = $row['CODPEDIDO'];
        }
    }

    $q1 = "UPDATE tra_des_enc set codpedido='$codpedido' where coddespa = '$tCodDespa'";
            $r1 = mysqli_query(conexion($_SESSION['pais']), $q1);

    echo $codPedido;
}

function saveEnc($coddespa)
{
    $date = new DateTime();

    $qryCheck = "SELECT coddespa FROM tra_des_enc WHERE coddespa = '".$coddespa."';";
    $resQryCheck = mysqli_query(conexion($_SESSION['pais']), $qryCheck);
    if($resQryCheck){
        if($resQryCheck->num_rows == 0){
            $insertEnc = "
            INSERT INTO tra_des_enc (coddespa, numdespa, fechadesp, codprov, codproy, embarque, codpedido, codhocar, valtotal, bitacora, estado) 
            VALUES ('" . $coddespa . "','" . getNumDespa() . "','" . $date->format('Y-m-d h:m:s') . "','" . $_SESSION['codprov'] . "','','','','','','','0');";

            mysqli_query(conexion($_SESSION['pais']), $insertEnc);
        }
    }

    $qryCheckProy = "SELECT codproy FROM tra_des_enc WHERE coddespa = '$coddespa';";

    $resQryCheckProy = mysqli_query(conexion($_SESSION['pais']), $qryCheckProy);
    if($resQryCheckProy){
        if($resQryCheckProy->num_rows > 0){
            $row = mysqli_fetch_row($resQryCheckProy);
            $t = $row[0];
            if($t == ''){
//                $query = "SELECT proy.NOMBRE, proy.CODPROY, ped.CODPEDIDO FROM cat_proyectos as proy INNER JOIN tra_ped_enc as ped ON ped.codproy = proy.codproy WHERE proy.estatus = '1';";
                $query = "SELECT * FROM cat_proyectos WHERE ESTATUS = 1;";
                $result = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
                if($result){
                    if($result->num_rows > 0){
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $updateEnc ="
            UPDATE tra_des_enc SET codproy = '".$row['CODPROY']."', embarque = '".$row['NOMBRE']."', codpedido = '".$row['CODPEDIDO']."' WHERE coddespa = '$coddespa'";

                        mysqli_query(conexion($_SESSION['pais']), $updateEnc);
                    }
                }
            }
        }
    }

    $updateEncTot =" UPDATE tra_des_enc SET VALTOTAL=(select totaldes from tra_des_det where coddespa = '$coddespa') WHERE coddespa = '$coddespa'";
    mysqli_query(conexion($_SESSION['pais']), $updateEncTot);
}

function getNumDespa()
{
    $query = "SELECT max(numdespa) as numdespa FROM tra_des_enc;";
    $result = mysqli_query(conexion($_SESSION['pais']), $query);
    if ($result) {
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $numdespa = $row['numdespa'];
            $year = substr($numdespa, 0, 4);
            if ($year != date('Y')) {
                return date('Y') . '001';
            } else {
                return ($numdespa + 1);
            }
        }
    }
}

function getUnidadDespachoCode($unidadDespacho)
{
    switch ($unidadDespacho) {
        case 'PALLETS':
        case 'PA':
            return 'PA';
        case 'CAJAS':
        case 'CA':
            return 'CA';
        case 'UNIDADES':
        case 'UN':
            return 'UN';
    }
}

function getPedNumero(){

    $currentCountryCode = getCountryCode($_SESSION['pais']);
    $response = $currentCountryCode . date('Y') . '1';
    $qry = "SELECT NUMERO FROM tra_ped_enc ORDER BY NUMERO DESC LIMIT 1;";
    $res = mysqli_query(conexionProveedorLocal($_SESSION['pais']),$qry);
    if($res){
        if($res->num_rows>0){
            $row = mysqli_fetch_array($res);
            $lastVal = $row[0];
            if($lastVal != ''){
                $lastValYear = substr($lastVal, count($currentCountryCode), 4);
                if($lastValYear == date('Y')){
                    $response = intval($lastVal) + 1;
                }
            }
        }
    }

    return $response;
}

function getCountryCode($countryName){
    require_once('../coneccion.php');
    $response = 0;
    $query = "SELECT CODIGO FROM direct WHERE nomPais = '$countryName';";
    $result = mysqli_query(conexion(""), $query);
    if($result){
        if($result->num_rows > 0){
            $row = mysqli_fetch_array($result);
            $response = $row[0];
        }
    }
    return $response;
}