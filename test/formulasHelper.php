<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";

if(isset($_POST["method"])){
    $tMethod = $_POST["method"];

    switch ($tMethod){
        case "getCountriesDrop":
            echo getCountriesDrop($tCountry);
            break;
        case "getChannelsDrop":
            $tCountry = $_POST["country"];
            echo getChannelsDrop($tCountry);
            break;
    }
}

function getCountriesDrop(){
    $countryQuery = "
        SELECT 
            dir.nomPais
        FROM
            cat_empresas AS emp
                INNER JOIN
            direct AS dir ON emp.pais = dir.codPais
        WHERE
            emp.companyid != 0
        ORDER BY dir.nomPais;
    ";

    $countryResult = mysqli_query(conexion(""), $countryQuery);

    $options = "";
    while ($countryRow = mysqli_fetch_array($countryResult)){
        $value = $countryRow[0];
        $text = $countryRow[0];
        $options .= "
            <option value='$value'>$text</option>
        ";
    }

    $drop = "
        <select id='countriesDrop'>
            $options
        </select>
    ";

    return $drop;
}

function getChannelsDrop($mCountry){
    $channelsQuery = "
        SELECT 
            CODCHAN, CHANNEL
        FROM
            cat_sal_cha
        ORDER BY CHANNEL;
    ";

    $channelsResult = mysqli_query(conexion($mCountry), $channelsQuery);
    $options = "";
    while ($channelsRow = mysqli_fetch_array($channelsResult)){
        $value = $channelsRow[0];
        $text = $channelsRow[1];
        $options .= "
            <option value='$value'>$text</option>
        ";
    }

    $drop = "
        <select id='channelsDrop'>
            $options
        </select>
    ";

    return $drop;
}