<?php
    session_start();
    include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
    include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/fecha.php');
    $method = $_POST['method'];

    if($method == 'newOrder'){
//        echo "newOrder";
        $orderId = $_POST['orderid'];
        $date = $_POST['date'];
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $orderChannel = $_POST['orderChannel'];
        $paysta = $_POST['paysta'];
        $paymet = $_POST['paymet'];
        $payrefnum = $_POST['payrefnum'];

        $site = $_POST['site'];
        $paydat = $_POST['paydat'];
        $channel = $_POST['channel'];

        $shimetsel = $_POST['shimetsel'];
        $shista = $_POST['shista'];
        $shipdate = $_POST['shipdate'];
        $shifee = $_POST['shifee'];

        $shicou = $_POST['shicou'];
        $shipstate = $_POST['shipstate'];
        $shipcity = $_POST['shipcity'];
        $shizipcod = $_POST['shizipcod'];
        $shiadd1 = $_POST['shiadd1'];
        $shiadd2 = $_POST['shiadd2'];

        $tracking = $_POST['tracking'];
        $status = $_POST['status'];
        $shiamocar = $_POST['shiamocar'];

        $subtotal = $_POST['subtotal'];
        $shitot = $_POST['shitot'];
        $orddistot = $_POST['orddistot'];
        $grandtotal = $_POST['grandtotal'];

        $isrusord = $_POST['isrusord'];

        $codorden = sys2015();

        $codbod = $_POST["codbod"];
        $torden = $_POST["torden"];

        //echo ':this:'.$orderId;
        //echo $orderId . '-' . $codorden;
        if($orderId != ""){
            $tquery = "SELECT CODORDEN FROM tra_ord_enc WHERE ORDERID = '$orderId';";
            $tresult = mysqli_query(conexion($_SESSION['pais']), $tquery);
            $codorden = mysqli_fetch_array($tresult)[0];
            //echo ':'.$codorden .' - '. $tquery . ':';
        }
        else{
            $orderId = insertOrderEnc($codorden, $subtotal, $shitot, $orddistot, $status, $shista, $shipdate, $shifee, $paysta, $paydat, $payrefnum, $paymet,  $shipcity, $shipstate, $shizipcod, $shiadd1, $shiadd2, $shicou, $shimetsel, $shiamocar, $isrusord, $codbod, $username, $firstname, $lastname, $grandtotal, $torden);
        }

        time_nanosleep(0, 1000000000);

        if($codorden != ""){
            $cleanDetQuery = "DELETE FROM tra_ord_det WHERE CODORDEN = '$codorden';";
            //echo $cleanDetQuery;
            mysqli_query(conexion($_SESSION['pais']), $cleanDetQuery);
        }
        //echo 'CO2:'.$codorden;

        $jsonText = $_POST['json'];
        $decodedText = html_entity_decode($jsonText);
        $data = json_decode($decodedText, true);
        echo $_POST['json'];
        //[{"CODIGO":"","DESCRIPCION DEL PRODUCTO":"","CANTIDAD":"","PRECIO UNITARIO":"","TOTAL":""}]
        for ($index = 0; $index < (count($data)); $index++) {
            //echo $data[$index]["Codigo"];
            //echo 'CO3:'.$codorden;
            if($data[$index]["Codigo"] != "No data available in table"){
                //echo 'CO4:'.$codorden;
//                echo $codorden."-".$data[$index]["Descripcion del Producto"]."-".$data[$index]["Cantidad"]."<br>";
                insertOrderDet($codorden, $data[$index]["Codigo"], $data[$index]["Descripcion del Producto"], $data[$index]["Cantidad"], $data[$index]["Precio Unitario"]);
            }
        }

        echo $orderId;
    }

    function orderEncExists($mCodOrden){
        include_once ('../coneccion.php');
        $tOrderEncQry = "SELECT CODORDEN FROM tra_ord_enc WHERE CODORDEN = '$mCodOrden'";
        $tOrdenEncRes = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $tOrderEncQry);
        $tResponse = 0;
        if($tOrdenEncRes){
            if($tOrdenEncRes->num_rows > 0){
                $tResponse = 1;
            }
        }
        return $tResponse;
    }

    function orderDetExists($mCodOrden){
        include_once ('../coneccion.php');
        $tOrderEncQry = "SELECT CODDETORD FROM tra_ord_det WHERE CODDETORD = '$mCodOrden'";
        $tOrdenEncRes = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $tOrderEncQry);
        $tResponse = 0;
        if($tOrdenEncRes){
            if($tOrdenEncRes->num_rows > 0){
                $tResponse = 1;
            }
        }
        return $tResponse;
    }

    function orderEncLoad($mCodOrden){
        include_once ('../coneccion.php');
        $query  = "SELECT * FROM tra_ord_enc WHERE CODODEN = '$mCodOrden'";
        $res = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
        $resp = '';
        if($res){
            if($res->num_rows > 0){
                $resp = mysqli_fetch_array($res);
            }
        }
        return $resp;
    }

    function orderDetLoad($mCodOrden){
        include_once ('../coneccion.php');
        $query  = "SELECT * FROM tra_ord_det WHERE CODODEN = '$mCodOrden'";
        $res = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
        $resp = '';
        if($res){
            if($res->num_rows > 0){
                $resp = mysqli_fetch_array($res);
            }
        }
        return $resp;
    }

    function insertOrderEnc($CODORDEN, $SUBTOTAL, $SHITOT, $ORDDISTOT, $ESTATUS, $SHISTA, $SHIPDATE, $SHIFEE, $PAYSTA, $PAYDAT, $PAYREFNUM, $PAYMET, $SHIPCITY, $SHIPSTATE, $SHIZIPCOD, $SHIADD1, $SHIADD2, $SHICOU, $SHIMETSEL, $SHIAMOCAR, $ISRUSORD, $CODBOD, $USERNAME, $FIRSTNAME, $LASTNAME, $GRANDTOTAL, $torden){

        session_start();
        include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
        $KITITEMID = $SHIPHONUM = $EBAYSALREC = $INVPRI = $SHICAR = $COMPANYID = $STATIONID = $CUSSERSTA = $TAXRATE = $TAXTOTAL = $GOOORDNUM = $ISINDIS = $DISSTAON = $PAYFEETOT = $POSFEETOT = $FINVALTOT = $SHIWEITOTO = $TRANUM = $LOCNOT = $UPC = $MARSOU = $GIFTWRAP = $MARDISCOUN = $CODMOVBOD = $CODPOLIZA = $CODCOS = $CODAMADET = $CODAMABAL = $ORDERUNITS = $OLDSTATE = $LIQID = $LIQID2 = $LIQID3 = $LIQID4 = $LIQID5 = '';

        $ORDERID = $ORDSOUORDI = getNewOrderId();
        $SITECODE = 'LS';
        $TIMOFORD = $INVPRIDAT = date('Y-m-d H:i:s');

        $tCustomerInfo = getCustomerInfo();
        $USERID = $tCustomerInfo['ID'];
//        $USERNAME = $SHIFIRNAM = $tCustomerInfo['NAME'];
//        $FIRSTNAME = $SHILASNAM = $tCustomerInfo['FNAME'];
//        $LASTNAME = $tCustomerInfo['LNAME'];
        $SHIFIRNAM = $FIRSTNAME;
        $SHILASNAM = $LASTNAME;

//        $GRANDTOTAL = $ORDSOUORDT = ($SUBTOTAL + $SHITOT + $ORDDISTOT);

        $CODPROV = $_SESSION['codprov'];

        $ORDSOU = 'Local_Store';
        $CODTORDEN = $torden;

        $CREATOR = $_SESSION["user"];

        $query = "
        INSERT INTO tra_ord_enc (CODORDEN, ORDERID, KITITEMID, USERID, USERNAME, FIRSTNAME, LASTNAME, SITECODE, TIMOFORD, SUBTOTAL, SHITOT, ORDDISTOT, GRANDTOTAL, ESTATUS, PAYSTA, PAYDAT, PAYREFNUM, PAYMET, SHISTA, SHIPDATE, SHIFEE, SHIFIRNAM, SHILASNAM, SHIADD1, SHIADD2, SHIPCITY, SHIPSTATE, SHIZIPCOD, SHICOU, SHIPHONUM, ORDSOU, ORDSOUORDI, EBAYSALREC, SHIMETSEL, ISRUSORD, INVPRI, INVPRIDAT, SHICAR, COMPANYID, ORDSOUORDT, STATIONID, CUSSERSTA, TAXRATE, TAXTOTAL, GOOORDNUM, ISINDIS, DISSTAON, PAYFEETOT, POSFEETOT, FINVALTOT, SHIWEITOTO, TRANUM, LOCNOT, UPC, MARSOU, GIFTWRAP, MARDISCOUN, CODMOVBOD, CODPOLIZA, CODCOS, CODAMADET, CODAMABAL, ORDERUNITS, OLDSTATE, LIQID, SHIAMOCAR, LIQID2, LIQID3, LIQID4, LIQID5, CODPROVE, CODTORDEN, CODBOD, CREATOR) VALUES (
        '$CODORDEN',/*CODORDEN*/
        '$ORDERID',/*ORDERID*/
        '$KITITEMID',/*KITITEMID*/
        '$USERID',/*USERID*/
        '$USERNAME',/*USERNAME*/
        '$FIRSTNAME',/*FIRSTNAME*/
        '$LASTNAME',/*LASTNAME*/
        '$SITECODE',/*SITECODE*/
        '$TIMOFORD',/*TIMOFORD*/
        '$SUBTOTAL',/*SUBTOTAL*/
        '$SHITOT',/*SHITOT*/
        '$ORDDISTOT',/*ORDDISTOT*/
        '$GRANDTOTAL',/*GRANDTOTAL*/
        '$ESTATUS',/*ESTATUS*/
        '$PAYSTA',/*PAYSTA*/
        '$PAYDAT',/*PAYDAT*/
        '$PAYREFNUM',/*PAYREFNUM*/
        '$PAYMET',/*PAYMET*/
        '$SHISTA',/*SHISTA*/
        '$SHIPDATE',/*SHIPDATE*/
        '$SHIFEE',/*SHIFEE*/
        '$SHIFIRNAM',/*SHIFIRNAM*/
        '$SHILASNAM',/*SHILASNAM*/
        '$SHIADD1',/*SHIADD1*/
        '$SHIADD2',/*SHIADD2*/
        '$SHIPCITY',/*SHIPCITY*/
        '$SHIPSTATE',/*SHIPSTATE*/
        '$SHIZIPCOD',/*SHIZIPCOD*/
        '$SHICOU',/*SHICOU*/
        '$SHIPHONUM',/*SHIPHONUM*/
        '$ORDSOU',/*ORDSOU*/
        '$ORDSOUORDI',/*ORDSOUORDI*/
        '$EBAYSALREC',/*EBAYSALREC*/
        '$SHIMETSEL',/*SHIMETSEL*/
        '$ISRUSORD',/*ISRUSORD*/
        '$INVPRI',/*INVPRI*/
        '$INVPRIDAT',/*INVPRIDAT*/ 
        '$SHICAR',/*SHICAR*/
        '$COMPANYID',/*COMPANYID*/
        '$ORDSOUORDT',/*ORDSOUORDT*/
        '$STATIONID',/*STATIONID*/
        '$CUSSERSTA',/*CUSSERSTA*/
        '$TAXRATE',/*TAXRATE*/
        '$TAXTOTAL',/*TAXTOTAL*/
        '$GOOORDNUM',/*GOOORDNUM*/
        '$ISINDIS',/*ISINDIS*/
        '$DISSTAON',/*DISSTAON*/
        '$PAYFEETOT',/*PAYFEETOT*/
        '$POSFEETOT',/*POSFEETOT*/
        '$FINVALTOT',/*FINVALTOT*/
        '$SHIWEITOTO',/*SHIWEITOTO*/
        '$TRANUM',/*TRANUM*/
        '$LOCNOT',/*LOCNOT*/
        '$UPC',/*UPC*/
        '$MARSOU',/*MARSOU*/
        '$GIFTWRAP',/*GIFTWRAP*/
        '$MARDISCOUN',/*MARDISCOUN*/
        '$CODMOVBOD',/*CODMOVBOD*/
        '$CODPOLIZA',/*CODPOLIZA*/
        '$CODCOS',/*CODCOS*/
        '$CODAMADET',/*CODAMADET*/
        '$CODAMABAL',/*CODAMABAL*/
          '$ORDERUNITS',/*ORDERUNITS*/
        '$OLDSTATE',/*OLDSTATE*/
        '$LIQID',/*LIQID*/
        '$SHIAMOCAR',/*SHIAMOCAR*/
        '$LIQID2',/*LIQID2*/
        '$LIQID3',/*LIQID3*/
        '$LIQID4',/*LIQID4*/
        '$LIQID5',/*LIQID5*/
        '$CODPROV',/*CODPROV*/
        '$CODTORDEN',/*CODPROV*/
        '$CODBOD',/*CODBOD*/
        '$CREATOR'/*CREATOR*/
        );
        ";

        session_start();
        $_SESSION["CODORDEN"] = $CODORDEN;
        $_SESSION["CODBODEGA"] = $CODBOD;
        $tRes = mysqli_query(conexion($_SESSION['pais']), $query);
//        echo $query;
        return $ORDERID;
    }

    function insertOrderDet($CODORDEN, $PRODUCTID, $DISNAM, $QTY, $ORIUNIPRI){

        session_start();
        include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
        $ORDITEID = $EBAYITEMID = $BACORDQTY = $ORISHICOS = $ADJUNIPRI = $ADJSHICOS = $INVAVAQTY = $UPC = $CODAMABAL = $QUAPUR = $LIQID = $BUCLE = '';

        $CODDETORD = sys2015();

        $LINETOTAL = $QTY * $ORIUNIPRI;

        $query = "
        INSERT INTO tra_ord_det (CODDETORD, CODORDEN, ORDITEID, PRODUCTID, QTY, DISNAM, LINETOTAL, EBAYITEMID, BACORDQTY, ORIUNIPRI, ORISHICOS, ADJUNIPRI, ADJSHICOS, INVAVAQTY, UPC, CODAMABAL, QUAPUR, LIQID, BUCLE) VALUES (
        '$CODDETORD',/*CODDETORD*/
        '$CODORDEN',/*CODORDEN*/
        '$ORDITEID',/*ORDITEID*/
        '$PRODUCTID',/*PRODUCTID*/
        '$QTY',/*QTY*/
        '$DISNAM',/*DISNAM*/
        '$LINETOTAL',/*LINETOTAL*/
        '$EBAYITEMID',/*EBAYITEMID*/
        '$BACORDQTY',/*BACORDQTY*/
        '$ORIUNIPRI',/*ORIUNIPRI*/
        '$ORISHICOS',/*ORISHICOS*/
        '$ADJUNIPRI',/*ADJUNIPRI*/
        '$ADJSHICOS',/*ADJSHICOS*/
        '$INVAVAQTY',/*INVAVAQTY*/
        '$UPC',/*UPC*/ 
        '$CODAMABAL',/*CODAMABAL*/
        '$QUAPUR',/*QUAPUR*/
        '$LIQID',/*LIQID*/
        '$BUCLE'/*BUCLE*/
        );
        ";

        $tRes = mysqli_query(conexion($_SESSION['pais']), $query);
//        echo $query;
    }

    function getNewOrderId(){
        $qry = "SELECT CONT FROM cat_sal_cha WHERE CODCHAN = '_4EX0MEELT';";
        $res = mysqli_query(conexion($_SESSION['pais']), $qry);
        $response = '';
        if($res){
            if($res->num_rows > 0){
                $response = ((int)mysqli_fetch_array($res)[0]+ 1);
                mysqli_query(conexion($_SESSION["pais"]), "UPDATE cat_sal_cha SET CONT = '$response' WHERE CODCHAN = '_4EX0MEELT';");
            }
            else{
                $tCountryCodeQry = "SELECT CODIGO FROM direct WHERE nomPais = '".$_SESSION['pais']."';";
                $tCountryCodeRes = mysqli_query(conexion($_SESSION["pais"]), $tCountryCodeQry);
                $tCountryCode = '';
                if($tCountryCodeRes){
                    if($tCountryCodeRes->num_rows > 0){
                        $tCountryCode = mysqli_fetch_array($tCountryCodeRes)[0];
                    }
                }
                $response = str_pad($tCountryCode, (9), '0') . '1';
            }
        }
        return $response;
    }

    function getCustomerInfo(){
        $qry = "SELECT ID, NAME, FNAME, LNAME FROM cat_customer limit 1;";
        $res = mysqli_query(conexion($_SESSION['pais']), $qry);
        $response = '';
        if($res){
            if($res->num_rows > 0){
                $response = mysqli_fetch_array($res);
            }
        }
        return $response;
    }