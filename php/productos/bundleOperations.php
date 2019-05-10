<?php



$method = $_POST['method'];

switch ($method){

    case 'updateBundlePrice':



        $newPrice = $_POST['newPrice'];

        $amazonSKU = $_POST['amazonSKU'];

        $codCanal = $_POST['codCanal'];

        updateBundlePrice($newPrice, $amazonSKU, $codCanal);

        break;



    case 'calcNewValues':

        calcNewValues();

        break;



    case 'getCOSPRI':

        $masterSKU = $_POST['masterSKU'];

        getCOSPRI($masterSKU);

        break;



    case 'getFAC_VAL':

        $canal = $_POST['canal'];

        $columna = $_POST['columna'];

        getFAC_VAL($canal, $columna);

        break;

    case "updateMinPP":
        $id = $_POST["id"];
        $channel = $_POST["channel"];
        $price = $_POST["price"];
        updateMinPP($id,$channel, $price);
        break;

    case "updateMaxPP":
        $id = $_POST["id"];
        $channel = $_POST["channel"];
        $price = $_POST["price"];
        updateMaxPP($id,$channel, $price);
        break;

}

function updateMinPP($id, $channel, $price){
    session_start();
    require_once ('../coneccion.php');
    $query = "
        UPDATE
            tra_bun_det
        SET
            MINPRIP = '$price'
        WHERE
            AMAZONSKU = '$id' 
        AND
            CODCANAL = '$channel';";
    mysqli_query(conexion($_SESSION["pais"]), $query);
}

function updateMaxPP($id, $channel, $price){
    session_start();
    require_once ('../coneccion.php');
    $query = "
        UPDATE
            tra_bun_det
        SET
            MAXPRIP = '$price'
        WHERE
            AMAZONSKU = '$id' 
        AND
            CODCANAL = '$channel';";
    mysqli_query(conexion($_SESSION["pais"]), $query);
}


function updateBundlePrice($newPrice, $amazonSKU, $codCanal){



    session_start();

//    echo 'here:';

    require_once('../coneccion.php');

//    echo file_exists('../coneccion.php');

//    echo ':';



    $query = "UPDATE tra_bun_det SET CUSSALPRI = '$newPrice'  WHERE AMAZONSKU = '$amazonSKU' AND CODCANAL = '$codCanal';";

//    echo $query;

    if(mysqli_query(conexion($_SESSION['pais']), $query)){

        echo "-OK " + $query;

    }

    else{

        echo "-ERROR " + $query;

    }

}



function calcNewValues(){



    $resp = [

        'newUtilities' => 'nuevas utilidades',

        'newUnitPrice' => 'nuevo precio unitario',

    ];

    echo json_encode($resp);

}



function getCOSPRI($masterSKU){



    session_start();

    require_once ('../coneccion.php');

    $query = "SELECT PCOSTO FROM cat_prod WHERE MASTERSKU = '$masterSKU';";

    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $query)) {

        if (mysqli_num_rows($ejecutar) > 0) {

            if ($row = mysqli_fetch_array($ejecutar, MYSQLI_NUM)) {

                echo $row[0];

            }

        }

    }

}



function getFAC_VAL($canal, $columna){



    session_start();

    require_once ('../coneccion.php');

    $query = "SELECT tpc.FAC_VAL, tpc.CODPARAM as codparam FROM tra_par_cha as tpc INNER JOIN cat_par_pri as cpp ON tpc.CODPARAM = cpp.CODPARPRI WHERE CODCANAL = '$canal' and cpp.COLUMNA = '$columna';";

    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $query)) {

        if (mysqli_num_rows($ejecutar) > 0) {

            if ($row = mysqli_fetch_array($ejecutar, MYSQLI_NUM)) {

                echo $row[0];

            }

        }

    }

}