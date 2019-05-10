<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPExcel/PHPExcel.php");

if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "getReport":
            $id = ($_POST["id"] != -999) ? $_POST["id"] : $_SESSION["codprov"] ;
            $filterType = $_POST["filterType"];
            $dropFilter = $_POST["dropFilter"];
            echo getReport($id, $filterType, $dropFilter);
            break;
        case "getFilterDrop":
            $filterType = $_POST["filterType"];
            $emp = ($_POST["emp"] != -999) ? $_POST["emp"] : $_SESSION["codprov"];
            echo getFilterDrop($filterType, $emp);
            break;
        case "checkProvDesc":
            $prov = $_POST["prov"];
            echo checkProvDesc($prov);
            break;
        case "saveProvDesc":
            $prov = $_POST["prov"];
            $desc = $_POST["desc"];
            echo saveProvDesc($prov, $desc);
            break;
    }
}

if(isset($_GET["method"])){
    $method = $_GET["method"];
    switch ($method){
        case "downloadReport":
            $id = ($_GET["id"] != -999) ? $_GET["id"] : $_SESSION["codprov"] ;
            $filterType = $_GET["filterType"];
            $dropFilter = $_GET["dropFilter"];
            echo downloadReport($id, $filterType, $dropFilter, $_SESSION["codprov"]);
            break;
        case "downloadReportV2":
            $id = ($_GET["id"] != -999) ? $_GET["id"] : $_SESSION["codprov"] ;
            $filterType = $_GET["filterType"];
            $dropFilter = $_GET["dropFilter"];
            $pventa = $_GET["pventa"];
            $vend = $_GET["vend"];
            echo downloadReportV2($id, $filterType, $dropFilter, $_SESSION["codprov"], $pventa, $vend);
            break;
    }
}

function getReport($id, $filterType, $dropFilter){
    $filter = "";
    if($filterType != "" && $dropFilter != ""){
        $filter = " AND $filterType = '$dropFilter'";
    }
    $productsQuery = "
        SELECT
            prod.CODPROD,
            prod.PRODNAME,
            prod.UPC AS UPC_U,
            prod.UPC_B,
            prod.UNIVENTA,
            prod.CAJANIVEL,
            prod.NIVPALET,
            prod.PCOSTO,
            prod.PESO_LBCA,
            prod.PROFUN_CA,
            prod.ANCHO_CA,
            prod.ALTO_CA,
            prod.PROFUN_PA,
            prod.ANCHO_PA,
            prod.ALTO_PA,
            prod.PESO_LBPA,
            prod.IMAURLBASE
        FROM
            cat_prod AS prod
        WHERE
            prod.CODPROV = '$id' AND prod.CODTPROD = 'PRO' 
             $filter;
    ";

//    echo "q:$productsQuery";
    $productsResult = mysqli_query(conexion($_SESSION["pais"]), $productsQuery);

    $PRODNAME_title = "DESCRIPTION";
    $UPC_U_title = "UPC";
    $UPC_B_title = "UPC BUNDLE";
    $UNIVENTA_title = "BOXES CASE";
    $CAJANIVEL_title = "PALLET TI";
    $NIVPALET_title = "PALLET HI";
    $PALLET_TOTAL_title = "PALLET TOTAL";
    $PCOSTO_title = "COST PER BOX";
    $PCOSTO_CA_title = "COST PER CASE"; //PCOSTO_CA
    $PCOSTO_PA_title = "COST PER PALLET"; //PCOSTO_PA
    $PESO_LBCA_title = "CASE WEIGHT (lb)"; //PESO LBCA
    $PROFUN_CA_title = "CASE LENGTH (in)"; //PROFUN CA
    $ANCHO_CA_title = "CASE WIDTH (in)"; //ANCHO CA
    $ALTO_CA_title = "CASE HEIGHT (in)"; //ALTO CA
    $PROFUN_PA_title = "PALLET LENGTH (in)"; //PROFUN PA
    $ANCHO_PA_title = "PALLET WIDTH (in)"; //ANCHO PA
    $ALTO_PA_title = "PALLET HEIGHT (in)"; //ALTO PA
    $PESO_LBPA_title = "PALLET WEIGHT (lb)"; //PESO LBPA
    $IMAURLBASE_title = "IMAGE";

    $table = "<table id='priceReportTable' class='cell-border'>";
    $table .= "
        <thead>
            <tr>
                <td>$PRODNAME_title</td>
                <td>$UPC_U_title</td>
                <td>$UPC_B_title</td>
                <td>$UNIVENTA_title</td>
                <td>$CAJANIVEL_title</td>
                <td>$NIVPALET_title</td>
                <td>$PALLET_TOTAL_title</td>
                <td>$PCOSTO_title</td>
                <td>$PCOSTO_CA_title</td>
                <td>$PCOSTO_PA_title</td>
                <td>$PESO_LBCA_title</td>
                <td>$PROFUN_CA_title</td>
                <td>$ANCHO_CA_title</td>
                <td>$ALTO_CA_title</td>
                <td>$PROFUN_PA_title</td>
                <td>$ANCHO_PA_title</td>
                <td>$ALTO_PA_title</td>
                <td>$PESO_LBPA_title</td>
                <td>$IMAURLBASE_title</td>
            </tr>
        </thead>
       ";

    $images = null;

    while($productsRow = mysqli_fetch_array($productsResult))   {
        $tCodProv = $productsRow["CODPROD"];
        $tUnitPrice = getUnitCost($tCodProv, $productsRow["UNIVENTA"]);
        $PRODNAME = $productsRow["PRODNAME"];
        $UPC_U = $productsRow["UPC_U"];
        $UPC_B = $productsRow["UPC_B"];
        $UNIVENTA = $productsRow["UNIVENTA"];
        $CAJANIVEL = $productsRow["CAJANIVEL"];
        $NIVPALET = $productsRow["NIVPALET"];
        $PALLET_TOTAL = ($CAJANIVEL * $NIVPALET);
        $PCOSTO = ($tUnitPrice == "") ? "0" : $tUnitPrice;
        $PCOSTO_CA = ($PCOSTO * $UNIVENTA);
        $PCOSTO_PA = ($PCOSTO_CA * $PALLET_TOTAL);
        $PESO_LBCA = $productsRow["PESO_LBCA"];
        $PROFUN_CA = $productsRow["PROFUN_CA"];
        $ANCHO_CA = $productsRow["ANCHO_CA"];
        $ALTO_CA = $productsRow["ALTO_CA"];
        $PROFUN_PA = $productsRow["PROFUN_PA"];
        $ANCHO_PA = $productsRow["ANCHO_PA"];
        $ALTO_PA = $productsRow["ALTO_PA"];
        $PESO_LBPA = $productsRow["PESO_LBPA"];
        $IMAURLBASE = "http://sigefcloud.com/imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . $productsRow["IMAURLBASE"];
        $images[] = [
            $PRODNAME,
            $UPC_U,
            $productsRow["IMAURLBASE"]
        ];

        $table .= "
            <tr>
                <td class='bold'>$PRODNAME</td>
                <td>$UPC_U</td>
                <td>$UPC_B</td>
                <td>$UNIVENTA</td>
                <td>$CAJANIVEL</td>
                <td>$NIVPALET</td>
                <td>$PALLET_TOTAL</td>
                <td>$PCOSTO</td>
                <td>$PCOSTO_CA</td>
                <td>$PCOSTO_PA</td>
                <td>$PESO_LBCA</td>
                <td>$PROFUN_CA</td>
                <td>$ANCHO_CA</td>
                <td>$ALTO_CA</td>
                <td>$PROFUN_PA</td>
                <td>$ANCHO_PA</td>
                <td>$ALTO_PA</td>
                <td>$PESO_LBPA</td>
                <td class='center'><img class='imagePreview' src='$IMAURLBASE'/></td>
            </tr>
        ";

        $getDistributionsQuery = "
            SELECT 
                *
            FROM
                tra_pre_dis
            WHERE
                codprod = '$tCodProv'
            ORDER BY FIELD(codunidades, 'UN', 'CA', 'PA') , de ASC;
        ";

        $getDistributionsResult = mysqli_query(conexion($_SESSION["pais"]), $getDistributionsQuery);

        while($getDistributionsRow = mysqli_fetch_array($getDistributionsResult)){
            $UNIVENTA = $getDistributionsRow["de"] . " - " . $getDistributionsRow["a"] . " " . $getDistributionsRow["codunidades"];
            $PCOSTO = $getDistributionsRow["precio"];
            $PCOSTO_CA = ($PCOSTO * $UNIVENTA);
            $PCOSTO_PA = ($PCOSTO_CA * $PALLET_TOTAL);
            $table .= "
                <tr class='grayCell'>
                    <td class='bold'>$PRODNAME</td>
                    <td>$UPC_U</td>
                    <td>$UPC_B</td>
                    <td>$UNIVENTA</td>
                    <td>$CAJANIVEL</td>
                    <td>$NIVPALET</td>
                    <td>$PALLET_TOTAL</td>
                    <td>$PCOSTO</td>
                    <td>$PCOSTO_CA</td>
                    <td>$PCOSTO_PA</td>
                    <td>$PESO_LBCA</td>
                    <td>$PROFUN_CA</td>
                    <td>$ANCHO_CA</td>
                    <td>$ALTO_CA</td>
                    <td>$PROFUN_PA</td>
                    <td>$ANCHO_PA</td>
                    <td>$ALTO_PA</td>
                    <td>$PESO_LBPA</td>
                    <td class='center'><img class='imagePreview' src='$IMAURLBASE'/></td>
                </tr>
            ";
        }
    }
    $table .= "</table>";

    $imagesTable = "
        <table id='imagesTable'>
            <tbody>
    ";

    foreach ($images as $image){
        $tImageUrl = "http://sigefcloud.com/imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . $image[2];
        $PRODNAME = $image[0];
        $UPC = $image[1];
        $imagesTable .= "
            <tr>
                <td class='fullCell center'>
                    <img class='imagePreview' src='$tImageUrl'/>
                    <br>$PRODNAME
                    <br>$UPC
                </td>
            </tr>
        ";
    }
    $imagesTable .= "
            </tbody>
        </table>
    ";

    $response = $table;

    return $response;
}

function downloadReport($id, $filterType, $dropFilter, $codProv){
    $filter = "";
    if($filterType != "" && $dropFilter != ""){
        $filter = " AND $filterType = '$dropFilter'";
    }
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->setTitle('Wholesales');

    $productsQuery = "
        SELECT 
            prod.CODPROD,
            prod.PRODNAME,
            prod.UPC AS UPC_U,
            prod.UPC_B,
            prod.UNIVENTA,
            prod.CAJANIVEL,
            prod.NIVPALET,
            prod.PCOSTO,
            prod.PESO_LBCA,
            prod.PROFUN_CA,
            prod.ANCHO_CA,
            prod.ALTO_CA,
            prod.PROFUN_PA,
            prod.ANCHO_PA,
            prod.ALTO_PA,
            prod.PESO_LBPA,
            prod.IMAURLBASE
        FROM
            cat_prod AS prod
        WHERE
            prod.CODPROV = '$id'
            $filter
        ORDER BY prod.PRODNAME;
    ";

    $provNameQuery = "
        SELECT NOMBRE FROM cat_prov WHERE CODPROV = '$codProv';
    ";

    $provName = getSingleValue($provNameQuery, $_SESSION["pais"]);

    $productsResult = mysqli_query(conexion($_SESSION["pais"]), $productsQuery);
    $PRODNAME_title = "DESCRIPTION";
    $UPC_U_title = "UPC";
    $UPC_B_title = "UPC BUNDLE";
    $UNIVENTA_title = "BOXES CASE";
    $CAJANIVEL_title = "PALLET TI";
    $NIVPALET_title = "PALLET HI";
    $PALLET_TOTAL_title = "PALLET TOTAL";
    $PCOSTO_title = "COST PER BOX";
    $PCOSTO_CA_title = "COST PER CASE"; //PCOSTO_CA
    $PCOSTO_PA_title = "COST PER PALLET"; //PCOSTO_PA
    $PESO_LBCA_title = "CASE WEIGHT (lb)"; //PESO LBCA
    $PROFUN_CA_title = "CASE LENGTH (in)"; //PROFUN CA
    $ANCHO_CA_title = "CASE WIDTH (in)"; //ANCHO CA
    $ALTO_CA_title = "CASE HEIGHT (in)"; //ALTO CA
    $PROFUN_PA_title = "PALLET LENGTH (in)"; //PROFUN PA
    $ANCHO_PA_title = "PALLET WIDTH (in)"; //ANCHO PA
    $ALTO_PA_title = "PALLET HEIGHT (in)"; //ALTO PA
    $PESO_LBPA_title = "PALLET WEIGHT (lb)"; //PESO LBPA

    $startingRow = "A";
    $startingCell = "2";
    $cell = $startingCell;
    $row = $startingRow;
    
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PRODNAME_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UPC_U_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UPC_B_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UNIVENTA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $CAJANIVEL_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $NIVPALET_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PALLET_TOTAL_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_CA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_PA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBCA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_CA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_CA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_CA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_PA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_PA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_PA_title);
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBPA_title);

    $objPHPExcel->getActiveSheet()->getStyle("$startingRow$cell:$row$cell")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("$startingRow$cell:$row$cell")->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    );

    while($productsRow = mysqli_fetch_array($productsResult))   {
        $tCodProv = $productsRow["CODPROD"];
        $tUnitPrice = getUnitCost($tCodProv, $productsRow["UNIVENTA"]);
        $PRODNAME = $productsRow["PRODNAME"];
        $UPC_U = $productsRow["UPC_U"];
        $UPC_B = $productsRow["UPC_B"];
        $UNIVENTA = $productsRow["UNIVENTA"];
        $CAJANIVEL = $productsRow["CAJANIVEL"];
        $NIVPALET = $productsRow["NIVPALET"];
        $PALLET_TOTAL = ($CAJANIVEL * $NIVPALET);
        $PCOSTO = ($tUnitPrice == "") ? "0" : $tUnitPrice;
        $PCOSTO_CA = ($PCOSTO * $UNIVENTA);
        $PCOSTO_PA = ($PCOSTO_CA * $PALLET_TOTAL);
        $PESO_LBCA = $productsRow["PESO_LBCA"];
        $PROFUN_CA = $productsRow["PROFUN_CA"];
        $ANCHO_CA = $productsRow["ANCHO_CA"];
        $ALTO_CA = $productsRow["ALTO_CA"];
        $PROFUN_PA = $productsRow["PROFUN_PA"];
        $ANCHO_PA = $productsRow["ANCHO_PA"];
        $ALTO_PA = $productsRow["ALTO_PA"];
        $PESO_LBPA = $productsRow["PESO_LBPA"];
        $IMAURLBASE = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . $productsRow["IMAURLBASE"];

        $tUN = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . getSingleValue("SELECT FILE FROM cat_prod_img WHERE CODPROD = '$tCodProv' AND CARA = 'un';", $_SESSION["pais"]);
        $tCA = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . getSingleValue("SELECT FILE FROM cat_prod_img WHERE CODPROD = '$tCodProv' AND CARA = 'ca';", $_SESSION["pais"]);
        $tPA = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . getSingleValue("SELECT FILE FROM cat_prod_img WHERE CODPROD = '$tCodProv' AND CARA = 'pa';", $_SESSION["pais"]);
        $images[$tCodProv] = [
            $PRODNAME,
            $UPC_U,
            $IMAURLBASE,
            $tUN,
            $tCA,
            $tPA
        ];

        $cell++;
        $row = $startingRow;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PRODNAME);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UPC_U);
        $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UPC_B);
        $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UNIVENTA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $CAJANIVEL);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $NIVPALET);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PALLET_TOTAL);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_CA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_PA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBCA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_CA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_CA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_CA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_PA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_PA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_PA);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBPA);
        $row++;
//        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $IMAURLBASE);
        $getDistributionsQuery = "
            SELECT 
                *
            FROM
                tra_pre_dis
            WHERE
                codprod = '$tCodProv'
            ORDER BY FIELD(codunidades, 'UN', 'CA', 'PA') , de ASC;
        ";


//        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $getDistributionsQuery);
        $getDistributionsResult = mysqli_query(conexion($_SESSION["pais"]), $getDistributionsQuery);
        while($getDistributionsRow = mysqli_fetch_array($getDistributionsResult)){

            $UNIVENTA = $getDistributionsRow["de"] . " - " . $getDistributionsRow["a"] . " " . $getDistributionsRow["codunidades"];
            $PCOSTO = $getDistributionsRow["precio"];
            $PCOSTO_CA = ($PCOSTO * $UNIVENTA);
            $PCOSTO_PA = ($PCOSTO_CA * $PALLET_TOTAL);

            $cell++;
            $row = $startingRow;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, ""); //$PRODNAME
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, ""); //$UPC_U
            $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, ""); //$UPC_B
            $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UNIVENTA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $CAJANIVEL);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $NIVPALET);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PALLET_TOTAL);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBCA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBPA);
        }
    }

//    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
//    $objPHPExcel->getActiveSheet()->calculateColumnWidths();

    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(125);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(35);
    $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle("A2:R2")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->mergeCells("B1:H1");
    $objPHPExcel->getActiveSheet()->setCellValue("B1", $provName);
    $objPHPExcel->getActiveSheet()->getStyle("B1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setSize(16);
    $cell+=2;
    $row = $startingRow;

    $tImageUrl = "../../imagenes/proveedores/" . $_SESSION["codprov"] . "/logo.jpg";

    if(file_exists($tImageUrl)){
        $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
        $objDrawing->setName('PRODUCT');        //set name to image
        $objDrawing->setDescription('PRODUCT'); //set description to image
        $signature = $tImageUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
        $objDrawing->setPath($signature);
        $tImagePosition = 250;
//        $tImagePosition = $tImagePosition * 3;
        $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
        $objDrawing->setOffsetY(10);                       //setOffsetY works properly
        $objDrawing->setCoordinates("A1");        //set image to cell
        $objDrawing->setWidth(128);                 //set width, height
        $objDrawing->setHeight(128);

        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

        $xOff = (90 * 2);
    }


    foreach ($images as $image){
        $PRODNAME = $image[0];
        $UPC = $image[1];
        $tImageUrl = $image[2];
        $tImageUNUrl = $image[3];
        $tImageCAUrl = $image[4];
        $tImagePAUrl = $image[5];

        if(file_exists($tImageUrl)){
            $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            $objDrawing->setName('PRODUCT');        //set name to image
            $objDrawing->setDescription('PRODUCT'); //set description to image
            $signature = $tImageUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
            $objDrawing->setPath($signature);
            $tImagePosition = 45;
//        $tImagePosition = $tImagePosition * 3;
            $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
            $objDrawing->setOffsetY(10);                       //setOffsetY works properly
            $objDrawing->setCoordinates($row.$cell);        //set image to cell
            $objDrawing->setWidth(128);                 //set width, height
            $objDrawing->setHeight(128);

            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

            $xOff = (90 * 2);
        }

        if($tImageUNUrl != ""){
            if(file_exists($tImageUNUrl)){
                $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                $objDrawing->setName('UNIT');        //set name to image
                $objDrawing->setDescription('UNIT'); //set description to image
                $signature = $tImageUNUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
                $objDrawing->setPath($signature);
                $tImagePosition = 45 + $xOff;
//        $tImagePosition = $tImagePosition * 3;
                $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
                $objDrawing->setOffsetY(10);                       //setOffsetY works properly
                $objDrawing->setCoordinates($row.$cell);        //set image to cell
                $objDrawing->setWidth(128);                 //set width, height
                $objDrawing->setHeight(128);

                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

                $xOff += (90*2);
            }
        }
        if($tImageCAUrl != ""){
            if(file_exists($tImageCAUrl)){
                $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                $objDrawing->setName('BOX');        //set name to image
                $objDrawing->setDescription('BOX'); //set description to image
                $signature = $tImageCAUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
                $objDrawing->setPath($signature);
                $tImagePosition = 45 + $xOff;
//        $tImagePosition = $tImagePosition * 3;
                $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
                $objDrawing->setOffsetY(10);                       //setOffsetY works properly
                $objDrawing->setCoordinates($row.$cell);        //set image to cell
                $objDrawing->setWidth(128);                 //set width, height
                $objDrawing->setHeight(128);

                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

                $xOff += (90*2);
            }
        }
        if($tImagePAUrl != ""){
            if(file_exists($tImagePAUrl)){
                $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                $objDrawing->setName('PALLET');        //set name to image
                $objDrawing->setDescription('PALLET'); //set description to image
                $signature = $tImagePAUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
                $objDrawing->setPath($signature);
                $tImagePosition = 45 + $xOff;
//        $tImagePosition = $tImagePosition * 3;
                $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
                $objDrawing->setOffsetY(10);                       //setOffsetY works properly
                $objDrawing->setCoordinates($row.$cell);        //set image to cell
                $objDrawing->setWidth(128);                 //set width, height
                $objDrawing->setHeight(128);

                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

                $xOff += (90*2);
            }
        }

        $cell+=7;
        $cell+=1;
        $objPHPExcel->getActiveSheet()->setCellValue($row.$cell, $PRODNAME);
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        );
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getFont()->setBold(true);
        $cell+=1;
        $objPHPExcel->getActiveSheet()->setCellValue($row.$cell, $UPC);
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        );
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $cell+=2;
    }

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(90);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('k')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('p')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $tFileName = $_SESSION['nomEmpresa'] ." Wholesales " . date("Y-m-d");
    header('Content-Disposition: attachment;filename="'.$tFileName.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

}

function downloadReportV2($id, $filterType, $dropFilter, $codProv, $pventa, $vend){
    $filter = "";
    if($filterType != "" && $dropFilter != ""){
        $filter = " AND $filterType = '$dropFilter'";
    }
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->setTitle('Wholesales');

    $productsQuery = "
        SELECT 
            prod.CODPROD,
            prod.PRODNAME,
            prod.UPC AS UPC_U,
            prod.UPC_B,
            prod.UPC14,
            prod.UNIVENTA,
            prod.CAJANIVEL,
            prod.NIVPALET,
            prod.PCOSTO,
            prod.PESO_LBCA,
            prod.PROFUN_CA,
            prod.ANCHO_CA,
            prod.ALTO_CA,
            prod.PROFUN_PA,
            prod.ANCHO_PA,
            prod.ALTO_PA,
            prod.PESO_LBPA,
            prod.IMAURLBASE,
            CONCAT(PROFUN, ' x ', ANCHO, ' x ', ALTO, '\"') AS MEDIDAS,
            (((prod.PESO_LB * 16) + prod.PESO_OZ) * 28.35) AS PESO_GR,
            PALCONTENEDOR,
            CAJCONTENEDOR,
            PRODCAPACI
        FROM
            cat_prod AS prod
        WHERE
            prod.CODPROV = '$id' AND CODTPROD = 'PRO'
        ORDER BY prod.PRODNAME;
    ";

    $provNameQuery = "
        SELECT NOMBRE FROM cat_prov WHERE CODPROV = '$codProv';
    ";
    $provDescQuery = "
        SELECT rep_desc FROM cat_prov WHERE CODPROV = '$codProv';
    ";

    $provName = getSingleValue($provNameQuery, $_SESSION["pais"]);
    $provDesc = getSingleValue($provDescQuery, $_SESSION["pais"]);



    $productsResult = mysqli_query(conexion($_SESSION["pais"]), $productsQuery);
    $PRODNAME_title = "DESCRIPTION";
    $UPC_U_title = "UPC";
    $UPC_B_title = "UPC BUNDLE";
    $UNIVENTA_title = "BOXES CASE";
    $CAJANIVEL_title = "PALLET TI";
    $NIVPALET_title = "PALLET HI";
    $PALLET_TOTAL_title = "PALLET TOTAL";
    $PCOSTO_title = "COST PER BOX";
    $PCOSTO_CA_title = "COST PER CASE"; //PCOSTO_CA
    $PCOSTO_PA_title = "COST PER PALLET"; //PCOSTO_PA
    $PESO_LBCA_title = "CASE WEIGHT (lb)"; //PESO LBCA
    $PROFUN_CA_title = "CASE LENGTH (in)"; //PROFUN CA
    $ANCHO_CA_title = "CASE WIDTH (in)"; //ANCHO CA
    $ALTO_CA_title = "CASE HEIGHT (in)"; //ALTO CA
    $PROFUN_PA_title = "PALLET LENGTH (in)"; //PROFUN PA
    $ANCHO_PA_title = "PALLET WIDTH (in)"; //ANCHO PA
    $ALTO_PA_title = "PALLET HEIGHT (in)"; //ALTO PA
    $PESO_LBPA_title = "PALLET WEIGHT (lb)"; //PESO LBPA

    $startingRow = "A";
    $startingCell = "14";
    $cell = $startingCell;
    $row = $startingRow;

    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "#");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "DUN 14 / DUN 14");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "UPC Product / Codigo UPC del Producto");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Product Description / Descripcion del Producto");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Dimensions of Unit / Medidas del Producto");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Weight per Unit / Peso por Unidad");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Case Packs / Empaque - Caja");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Units per Case - Pack / Unidades por Empaque - Caja");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "TI / Cajas por Cama");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "HI / Cajas Verticales");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Cases per Pallet / Cajas por Palet");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Units per Pallet / Unidades por Palet");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Pallets per Container / Palets por Contenedor");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Cases per Container / Cajas por Contenedor");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Units per Container / Unidades por Contenedor");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Maximum Monthly Production (case) / Produccion Mensual Maxima (cajas)");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Pack - Case Cost / Costo de Caja - Empaque");
    $row++;
    $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "Unit Price / Precio Unitario");

    $objPHPExcel->getActiveSheet()->getStyle("$startingRow$cell:$row$cell")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("$startingRow$cell:$row$cell")->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    );

    $CONT = 0;
    while($productsRow = mysqli_fetch_array($productsResult))   {
        $CONT ++;
        $tCodProv = $productsRow["CODPROD"];
        $tUnitPrice = getUnitCost($tCodProv, $productsRow["UNIVENTA"]);
        $PRODNAME = $productsRow["PRODNAME"];
        $UPC_U = $productsRow["UPC_U"];
        $UPC_B = $productsRow["UPC_B"];
        $UPC14 = $productsRow["UPC14"];
        $UNIVENTA = $productsRow["UNIVENTA"];
        $CAJANIVEL = $productsRow["CAJANIVEL"];
        $NIVPALET = $productsRow["NIVPALET"];
        $PALLET_TOTAL = ($CAJANIVEL * $NIVPALET);
        $PCOSTO = ($tUnitPrice == "") ? "0" : $tUnitPrice;
        $PCOSTO = $productsRow["PCOSTO"];
        $PCOSTO_CA = ($PCOSTO * $UNIVENTA);
        $PCOSTO_PA = ($PCOSTO_CA * $PALLET_TOTAL);
        $PESO_LBCA = $productsRow["PESO_LBCA"];
        $PROFUN_CA = $productsRow["PROFUN_CA"];
        $ANCHO_CA = $productsRow["ANCHO_CA"];
        $ALTO_CA = $productsRow["ALTO_CA"];
        $PROFUN_PA = $productsRow["PROFUN_PA"];
        $ANCHO_PA = $productsRow["ANCHO_PA"];
        $ALTO_PA = $productsRow["ALTO_PA"];
        $PESO_LBPA = $productsRow["PESO_LBPA"];
        $IMAURLBASE = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . $productsRow["IMAURLBASE"];
        $MEDIDAS = $productsRow["MEDIDAS"];
        $PESO_GR = $productsRow["PESO_GR"];
        $PALCONTENEDOR = $productsRow["PALCONTENEDOR"];
        $CAJCONTENEDOR = $productsRow["CAJCONTENEDOR"];
        $PRODCAPACI = ($productsRow["PRODCAPACI"] != '') ? $productsRow["PRODCAPACI"] . " UNITS" : "";

        $tUN = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . getSingleValue("SELECT FILE FROM cat_prod_img WHERE CODPROD = '$tCodProv' AND CARA = 'un';", $_SESSION["pais"]);
        $tCA = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . getSingleValue("SELECT FILE FROM cat_prod_img WHERE CODPROD = '$tCodProv' AND CARA = 'ca';", $_SESSION["pais"]);
        $tPA = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . getSingleValue("SELECT FILE FROM cat_prod_img WHERE CODPROD = '$tCodProv' AND CARA = 'pa';", $_SESSION["pais"]);
        $images[$tCodProv] = [
            $PRODNAME,
            $UPC_U,
            $IMAURLBASE,
            $tUN,
            $tCA,
            $tPA
        ];

        $pventa = 1 + ($pventa / 100);

        $cell++;
        $row = $startingRow;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PRODNAME);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$CONT");
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UPC_U);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UPC14);
        $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UPC_B);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$UPC_U");
        $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UNIVENTA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$PRODNAME");
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $CAJANIVEL);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $MEDIDAS);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $NIVPALET);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_GR . " gr");
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PALLET_TOTAL);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "1");
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$UNIVENTA");
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_CA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$CAJANIVEL");
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_PA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$NIVPALET");
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBCA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$PALLET_TOTAL");
        $row++;

        $tval2 = intval($UNIVENTA) * intval($PALLET_TOTAL);
        $tval2 = number_format($tval2, "0", ".", ",");
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_CA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $tval2);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_CA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PALCONTENEDOR);
        $row++;

        $tval1 = $CAJCONTENEDOR;
        $tval1 = number_format($tval1, "0", ".", ",");
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_CA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $tval1);
        $row++;

        $tval = (intval($UNIVENTA) * intval($PALLET_TOTAL)) * intval($PALCONTENEDOR);
        $tval = number_format($tval, "0", ".", ",");
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_PA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $tval);
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_PA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PRODCAPACI);
        $row++;

        $tpcosto = ($PCOSTO * $UNIVENTA) * $pventa;
        $tpcosto = number_format($tpcosto, "2", ".", ",");
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_PA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$" . $tpcosto);
        $row++;

        $tpcosto1 = $PCOSTO * $pventa;
        $tpcosto1 = number_format($tpcosto1, "2", ".", ",");
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBPA);
        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, "$" . $tpcosto1);
        $row++;
//        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $IMAURLBASE);
        $getDistributionsQuery = "
            SELECT 
                *
            FROM
                tra_pre_dis
            WHERE
                codprod = '$id'
            ORDER BY FIELD(codunidades, 'UN', 'CA', 'PA') , de ASC;
        ";


//        $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $getDistributionsQuery);
        /*
        $getDistributionsResult = mysqli_query(conexion($_SESSION["pais"]), $getDistributionsQuery);
        while($getDistributionsRow = mysqli_fetch_array($getDistributionsResult)){

            $UNIVENTA = $getDistributionsRow["de"] . " - " . $getDistributionsRow["a"] . " " . $getDistributionsRow["codunidades"];
            $PCOSTO = $getDistributionsRow["precio"];
            $PCOSTO_CA = ($PCOSTO * $UNIVENTA);
            $PCOSTO_PA = ($PCOSTO_CA * $PALLET_TOTAL);

            $cell++;
            $row = $startingRow;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, ""); //$PRODNAME
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, ""); //$UPC_U
            $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, ""); //$UPC_B
            $objPHPExcel->getActiveSheet()->getStyle($row . $cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $UNIVENTA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $CAJANIVEL);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $NIVPALET);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PALLET_TOTAL);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PCOSTO_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBCA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_CA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PROFUN_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ANCHO_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $ALTO_PA);
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValue($row . $cell, $PESO_LBPA);
        }
        */
    }

//    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
//    $objPHPExcel->getActiveSheet()->calculateColumnWidths();

//    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(125);
//    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(35);
//    $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle("A14:R14")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->setCellValue("A1", "NAME OF PRODUCTS");
    $objPHPExcel->getActiveSheet()->setCellValue("A2", $provDesc);
    $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->mergeCells("D1:O3");
    $objPHPExcel->getActiveSheet()->mergeCells("A1:C1");
    $objPHPExcel->getActiveSheet()->mergeCells("A2:C3");
    $objPHPExcel->getActiveSheet()->setCellValue("D1", "PRICE LIST");
    $objPHPExcel->getActiveSheet()->getStyle("A1:R14")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("A1:R14")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("D1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("D1")->getFont()->setSize(24);

    $objPHPExcel->getActiveSheet()->setBreak( 'A'.$cell , PHPExcel_Worksheet::BREAK_ROW);

    $cell+=2;
    $row = $startingRow;


    //logo
    $tImageUrl = $_SERVER["DOCUMENT_ROOT"] . "/images/logoweb.png";

    if(file_exists($tImageUrl)){
        $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
        $objDrawing->setName('LOGO');        //set name to image
        $objDrawing->setDescription('LOGO'); //set description to image
        $signature = $tImageUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
        $objDrawing->setPath($signature);
//        $tImagePosition = 250;
//        $tImagePosition = $tImagePosition * 3;
//        $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
//        $objDrawing->setOffsetY(10);                       //setOffsetY works properly
        $objDrawing->setCoordinates("Q1");        //set image to cell
        $objDrawing->setWidth(64);                 //set width, height
        $objDrawing->setHeight(64);

        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

        $xOff = (90 * 2);
    }

    $imagesQ = "
        SELECT 
            `file`
        FROM
            cat_prod AS prod
                LEFT JOIN
            cat_prod_img AS img ON prod.codprod = img.codprod
        WHERE
            codprov = '$id'
                AND codtprod = 'PRO'
                AND img.cara IN ('un' , 'ca', 'pa')
        LIMIT 3;
    ";

//    $objPHPExcel->getActiveSheet()->setCellValue("D1", $imagesQ);

    $imagesR = mysqli_query(conexion($_SESSION["pais"]), $imagesQ);

    $imagePrefix = "../../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa']))  . "/";
    while($imagesRow = mysqli_fetch_array($imagesR)){
        $image = $imagePrefix . $imagesRow["file"];
//        $objPHPExcel->getActiveSheet()->setCellValue("A1", $image);

        if(file_exists($image)){
//            $objPHPExcel->getActiveSheet()->setCellValue("D1", "SI");
            $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            $objDrawing->setName('UNIT');        //set name to image
            $objDrawing->setDescription('UNIT'); //set description to image
            $signature = $image;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
            $objDrawing->setPath($signature);
            $tImagePosition = 45 + $xOff;
//        $tImagePosition = $tImagePosition * 3;
            $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
            $objDrawing->setOffsetY(10);                       //setOffsetY works properly
            $objDrawing->setCoordinates("D5");        //set image to cell
            $objDrawing->setWidth(128);                 //set width, height
            $objDrawing->setHeight(128);

            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

            $xOff += (90*2);
        }
    }

    /*
    foreach ($images as $image){
        $PRODNAME = $image[0];
        $UPC = $image[1];
        $tImageUrl = $image[2];
        $tImageUNUrl = $image[3];
        $tImageCAUrl = $image[4];
        $tImagePAUrl = $image[5];

        if(file_exists($tImageUrl)){
            $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            $objDrawing->setName('PRODUCT');        //set name to image
            $objDrawing->setDescription('PRODUCT'); //set description to image
            $signature = $tImageUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
            $objDrawing->setPath($signature);
            $tImagePosition = 45;
//        $tImagePosition = $tImagePosition * 3;
            $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
            $objDrawing->setOffsetY(10);                       //setOffsetY works properly
            $objDrawing->setCoordinates($row.$cell);        //set image to cell
            $objDrawing->setWidth(128);                 //set width, height
            $objDrawing->setHeight(128);

            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

            $xOff = (90 * 2);
        }

        if($tImageUNUrl != ""){
            if(file_exists($tImageUNUrl)){
                $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                $objDrawing->setName('UNIT');        //set name to image
                $objDrawing->setDescription('UNIT'); //set description to image
                $signature = $tImageUNUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
                $objDrawing->setPath($signature);
                $tImagePosition = 45 + $xOff;
//        $tImagePosition = $tImagePosition * 3;
                $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
                $objDrawing->setOffsetY(10);                       //setOffsetY works properly
                $objDrawing->setCoordinates($row.$cell);        //set image to cell
                $objDrawing->setWidth(128);                 //set width, height
                $objDrawing->setHeight(128);

                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

                $xOff += (90*2);
            }
        }
        if($tImageCAUrl != ""){
            if(file_exists($tImageCAUrl)){
                $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                $objDrawing->setName('BOX');        //set name to image
                $objDrawing->setDescription('BOX'); //set description to image
                $signature = $tImageCAUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
                $objDrawing->setPath($signature);
                $tImagePosition = 45 + $xOff;
//        $tImagePosition = $tImagePosition * 3;
                $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
                $objDrawing->setOffsetY(10);                       //setOffsetY works properly
                $objDrawing->setCoordinates($row.$cell);        //set image to cell
                $objDrawing->setWidth(128);                 //set width, height
                $objDrawing->setHeight(128);

                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

                $xOff += (90*2);
            }
        }
        if($tImagePAUrl != ""){
            if(file_exists($tImagePAUrl)){
                $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                $objDrawing->setName('PALLET');        //set name to image
                $objDrawing->setDescription('PALLET'); //set description to image
                $signature = $tImagePAUrl;    //Path to signature .jpg file
//        $signature = "../../images/add.png";    //Path to signature .jpg file
                $objDrawing->setPath($signature);
                $tImagePosition = 45 + $xOff;
//        $tImagePosition = $tImagePosition * 3;
                $objDrawing->setOffsetX($tImagePosition);                       //setOffsetX works properly
                $objDrawing->setOffsetY(10);                       //setOffsetY works properly
                $objDrawing->setCoordinates($row.$cell);        //set image to cell
                $objDrawing->setWidth(128);                 //set width, height
                $objDrawing->setHeight(128);

                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

                $xOff += (90*2);
            }
        }

        $cell+=7;
        $cell+=1;
        $objPHPExcel->getActiveSheet()->setCellValue($row.$cell, $PRODNAME);
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        );
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getFont()->setBold(true);
        $cell+=1;
        $objPHPExcel->getActiveSheet()->setCellValue($row.$cell, $UPC);
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        );
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle($row.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $cell+=2;
    }
    */


    $initC = $cell;

    $footCol = "B";

    $vendQ = "select * from cat_vendedores where CODVENDE = '$vend';";
    $vendR = mysqli_query(conexion($_SESSION["pais"]), $vendQ);
    $vendRow = mysqli_fetch_array($vendR);

//    $objPHPExcel->getActiveSheet()->setCellValue("D1", $vendQ);

    $tSPName = $vendRow["NOMBRE"] . " " . $vendRow["APELLIDO"];
    $tSPCel = $vendRow["TELEFONO_1"];
    $tSPPhone = $vendRow["TELEFONO_2"];
    $tSPMail = $vendRow["EMAIL"];
    $tSPAddress = $vendRow["DIRECCION"];



    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Shipping cost:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "Not included.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Sales Contact:");
    $objPHPExcel->getActiveSheet()->setCellValue("M" . $cell, "$tSPName");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Costo de envio:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "No incluido.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Vendedor:");
    $tCell = intval($cell) - 1;
    $objPHPExcel->getActiveSheet()->mergeCells("M$tCell:P$cell");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Prices apply for:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "Delivery by pallets.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Mobile:");
    $objPHPExcel->getActiveSheet()->setCellValue("M" . $cell, "$tSPCel");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Precios aplican:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "Entregas por palet.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Celular:");
    $tCell = intval($cell) - 1;
    $objPHPExcel->getActiveSheet()->mergeCells("M$tCell:P$cell");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Inventory in:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "Atlanta, Georgia");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Office:");
    $objPHPExcel->getActiveSheet()->setCellValue("M" . $cell, "$tSPPhone");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Inventario en:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "Atlanta, Georgia");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Telefono oficina:");
    $tCell = intval($cell) - 1;
    $objPHPExcel->getActiveSheet()->mergeCells("M$tCell:P$cell");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Transit times:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "Usually SEVEN weeks after PO received.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Email:");
    $objPHPExcel->getActiveSheet()->setCellValue("M" . $cell, "$tSPMail");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Tiempo de entrega:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "Usualmente SIETE semanas luego de recibieda la orden.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Correo electronico:");
    $tCell = intval($cell) - 1;
    $objPHPExcel->getActiveSheet()->mergeCells("M$tCell:P$cell");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Minimum order:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "6 pallet.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Address:");
    $objPHPExcel->getActiveSheet()->setCellValue("M" . $cell, "$tSPAddress");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Pedido minimo:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "6 palet.");
    $objPHPExcel->getActiveSheet()->mergeCells("K$cell:L$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("M$cell:P$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $cell, "Direccion:");
    $tCell = intval($cell) - 1;
    $objPHPExcel->getActiveSheet()->mergeCells("M$tCell:P$cell");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Comments:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "After July 2019, monthly production would be of 50,000.");
    $cell++;
    $objPHPExcel->getActiveSheet()->mergeCells("B$cell:C$cell");
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:H$cell");
    $objPHPExcel->getActiveSheet()->setCellValue($footCol . $cell, "Comentarios:");
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $cell, "A partir de Julio de 2019, la capacidad de produccion mensual sera de 50,000 unidades.");

    $endC = $cell;

    $objPHPExcel->getActiveSheet()->getStyle("$footCol$initC:$footCol$endC")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("$footCol$initC:$footCol$endC")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle("K$initC:K$endC")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("K$initC:K$endC")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle("M$initC:M$endC")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//    $objPHPExcel->getActiveSheet()->setCellValue("D1", );


    /*
    $objPHPExcel->getActiveSheet()->mergeCells("D$cell:O$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("D$cell", "WORLDIRECT PRICE LIST / LISTADO DE PRECIOS DE WORLDIRECT");
    $objPHPExcel->getActiveSheet()->getStyle("D$cell")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("D$cell")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->mergeCells("Q$cell:R$cell");
    $objPHPExcel->getActiveSheet()->setCellValue("Q$cell", "PRICE LIST");
    $objPHPExcel->getActiveSheet()->getStyle("Q$cell")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    */

//    $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader("&L&\"-,Bold\" NAME OF PRODUCTS \n &\"-,Regular\"$provDesc");
    $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 14);
    $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter("&C WORLDIRECT PRICE LIST / LISTADO DE PRECIOS DE WORLDIRECT &R PRICE LIST");

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('k')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('p')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getRowDimension($startingCell)->setRowHeight(100);


    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $tFileName = $_SESSION['nomEmpresa'] ." Wholesales V2 " . date("Y-m-d");
    header('Content-Disposition: attachment;filename="'.$tFileName.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

}

function getFilterDrop($filterType, $emp){
    $dropQuery = "";
    switch ($filterType){
        case "MARCA":
            $dropQuery = "
                SELECT 
                    prod.MARCA AS SVALUE, mar.NOMBRE AS SNAME
                FROM
                    cat_prod AS prod
                        INNER JOIN
                    cat_marcas AS mar ON prod.MARCA = mar.CODMARCA
                WHERE
                    prod.CODPROV = '$emp'
                GROUP BY prod.MARCA;
            ";
            break;
        case "CODMANUFAC":
            $dropQuery = "
                SELECT 
                    prod.CODMANUFAC AS SVALUE, mar.NOMBRE AS SNAME
                FROM
                    cat_prod AS prod
                        INNER JOIN
                    cat_manufacturadores AS mar ON prod.CODMANUFAC = mar.CODMANUFAC
                WHERE
                    prod.CODPROV = '$emp'
                GROUP BY prod.CODMANUFAC;
            ";
            break;
        case "CODPROLIN":
            $dropQuery = "
                SELECT 
                    prod.CODPROLIN AS SVALUE, mar.PRODLINE AS SNAME
                FROM
                    cat_prod AS prod
                        INNER JOIN
                    cat_pro_lin AS mar ON prod.CODPROLIN = mar.CODPROLIN
                WHERE
                    prod.CODPROV = '$emp'
                GROUP BY prod.CODPROLIN;
            ";
            break;
    }
    $dropResult = mysqli_query(conexion($_SESSION["pais"]), $dropQuery);
    $drop = "<select id='dropFilter' class='entradaTexto fullInput'>";
    while ($dropRow = mysqli_fetch_array($dropResult)){
        $tValue = $dropRow["SVALUE"];
        $tName = $dropRow["SNAME"];

        $drop .= "<option value='$tValue'>$tName</option>";
    }
    $drop .="</select>";

    return $drop;
}

function getUnitCost($codProd, $units){
    $unitCostQuery = "
        SELECT 
            precio
        FROM
            tra_pre_dis
        WHERE
            codprod = '$codProd' AND codunidades = 'UN'
                AND '$units' BETWEEN de AND a
        ORDER BY precio DESC
        LIMIT 1;
    ";

    $unitCost = getSingleValue($unitCostQuery, $_SESSION["pais"]);

    return $unitCost;
}

function checkProvDesc($prov){
    $q = "
        SELECT 
            rep_desc
        FROM
            cat_prov
        WHERE
            codprov = '$prov';
    ";

    $r = mysqli_query(conexion($_SESSION["pais"]), $q);
    return (mysqli_fetch_array($r)[0] != "") ? true : false;
}

function saveProvDesc($prov, $desc){
    $q = "
        UPDATE 
            cat_prov
        SET
            rep_desc = '$desc'
        WHERE
            codprov = '$prov';
    ";

    $r = mysqli_query(conexion($_SESSION["pais"]), $q);
}