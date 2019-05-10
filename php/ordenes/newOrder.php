<?php
    session_start();
    include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
    include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/fecha.php');
    $method = $_POST['method'];

    if($method == 'newOrder'){

        $subtotal = $_POST['subtotal'];
        $shitot = $_POST['shitot'];
        $orddistot = $_POST['orddistot'];
        $estatus = $_POST['estatus'];
        $paysta = $_POST['paysta'];
        $paydat = $_POST['paydat'];
        $payrefnum = $_POST['payrefnum'];
        $paymet = $_POST['paymet'];
        $shista = $_POST['shista'];
        $shipdate = $_POST['shipdate'];
        $shifee = $_POST['shifee'];
        $shipcity = $_POST['shipcity'];
        $shipstate = $_POST['shipstate'];
        $shizipcod = $_POST['shizipcod'];
        $shicou = $_POST['shicou'];
        $shimetsel = $_POST['shimetsel'];
        $isrusord = $_POST['isrusord'];

        insertOrderEnc($subtotal, $shitot, $orddistot, $estatus, $paysta, $paydat, $payrefnum, $paymet, $shista, $shipdate, $shifee, $shipcity, shipsta, $shizipcod, $shicou, $shimetsel, $isrusord);
        //echo sys2015();
        //getNewOrderId();
        /*
        if(orderEncExists($tCodOrden) == 0){
            insertOrderEnc();
        }

        updateOrderEnc();

        if(orderDetExists() == 0){
            insertOrderDet();
        }

        updateOrderDet();
        */
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

    function insertOrderEnc($SUBTOTAL, $SHITOT, $ORDDISTOT, $ESTATUS, $SHISTA, $SHIPDATE, $SHIFEE, $PAYSTA, $PAYDAT, $PAYREFNUM, $PAYMET, $SHIPCITY, $SHIPSTATE, $SHIZIPCOD, $SHICOU, $SHIMETSEL, $ISRUSORD){

        $KITITEMID = $SHIADD1 = $SHIADD2 = $SHIPHONUM = $EBAYSALREC = $INVPRI = $SHICAR = $COMPANYID = $STATIONID = $CUSSERSTA = $TAXRATE = $TAXTOTAL = $GOOORDNUM = $ISINDIS = $DISSTAON = $PAYFEETOT = $POSFEETOT = $FINVALTOT = $SHIWEITOTO = $TRANUM = $LOCNOT = $UPC = $MARSOU = $GIFTWRAP = $MARDISCOUN = $CODMOVBOD = $CODPOLIZA = $CODCOS = $CODAMADET = $CODAMABAL = $ORDERUNITS = $OLDSTATE = $LIQID = $SHIAMOCAR = $LIQID2 = $LIQID3 = $LIQID4 = $LIQID5 = 0;

        $CODORDEN = sys2015();
        $ORDERID = $ORDSOUORDI = getNewOrderId();
        $SITECODE = 'LS';
        $TIMOFORD = $INVPRIDAT = date('m-d-Y');

        $tCustomerInfo = getCustomerInfo();
        $USERID = $tCustomerInfo['ID'];
        $USERNAME = $SHIFIRNAM = $tCustomerInfo['NAME'];
        $FIRSTNAME = $SHILASNAM = $tCustomerInfo['FNAME'];
        $LASTNAME = $tCustomerInfo['LNAME'];

        $GRANDTOTAL = $ORDSOUORDT = ($SUBTOTAL + $SHITOT + $ORDDISTOT);

        $CODPROV = $_SESSION['codprov'];

        $ORDSOU = 'Local Store';

        $query = "
        INSERT INTO tra_ord_enc (CODORDEN, ORDERID, KITITEMID, USERID, USERNAME, FIRSTNAME, LASTNAME, SITECODE, TIMOFORD, SUBTOTAL, SHITOT, ORDDISTOT, GRANDTOTAL, ESTATUS, PAYSTA, PAYDAT, PAYREFNUM, PAYMET, SHISTA, SHIPDATE, SHIFEE, SHIFIRNAM, SHILASNAM, SHIADD1, SHIADD2, SHIPCITY, SHIPSTATE, SHIZIPCOD, SHICOU, SHIPHONUM, ORDSOU, ORDSOUORDI, EBAYSALREC, SHIMETSEL, ISRUSORD, INVPRI, INVPRIDAT, SHICAR, COMPANYID, ORDSOUORDT, STATIONID, CUSSERSTA, TAXRATE, TAXTOTAL, GOOORDNUM, ISINDIS, DISSTAON, PAYFEETOT, POSFEETOT, FINVALTOT, SHIWEITOTO, TRANUM, LOCNOT, UPC, MARSOU, GIFTWRAP, MARDISCOUN, CODMOVBOD, CODPOLIZA, CODCOS, CODAMADET, CODAMABAL, ORDERUNITS, OLDSTATE, LIQID, SHIAMOCAR, LIQID2, LIQID3, LIQID4, LIQID5, CODPROV) VALUES (
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
        '$CODPROV'/*CODPROV*/);
        ";

        //$tRes = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
        echo $query;
    }

    function updateOrderEnc(){

        $CODORDEN = $ORDERID = $KITITEMID = $USERID = $USERNAME = $FIRSTNAME = $LASTNAME = $SITECODE = $TIMOFORD = $SUBTOTAL = $SHITOT = $ORDDISTOT = $GRANDTOTAL = $ESTATUS = $PAYSTA = $PAYDAT = $PAYREFNUM = $PAYMET = $SHISTA = $SHIPDATE = $SHIFEE = $SHIFIRNAM = $SHILASNAM = $SHIADD1 = $SHIADD2 = $SHIPCITY = $SHIPSTATE = $SHIZIPCOD = $SHICOU = $SHIPHONUM = $ORDSOU = $ORDSOUORDI = $EBAYSALREC = $SHIMETSEL = $ISRUSORD = $INVPRI = $INVPRIDAT = $SHICAR = $COMPANYID = $ORDSOUORDT = $STATIONID = $CUSSERSTA = $TAXRATE = $TAXTOTAL = $GOOORDNUM = $ISINDIS = $DISSTAON = $PAYFEETOT = $POSFEETOT = $FINVALTOT = $SHIWEITOTO = $TRANUM = $LOCNOT = $UPC = $MARSOU = $GIFTWRAP = $MARDISCOUN = $CODMOVBOD = $CODPOLIZA = $CODCOS = $CODAMADET = $CODAMABAL = $ORDERUNITS = $OLDSTATE = $LIQID = $SHIAMOCAR = $LIQID2 = $LIQID3 = $LIQID4 = $LIQID5 = $CODPROV = 0;

        $query = "
        REPLACE INTO tra_ord_enc (CODORDEN, ORDERID, KITITEMID, USERID, USERNAME, FIRSTNAME, LASTNAME, SITECODE, TIMOFORD, SUBTOTAL, SHITOT, ORDDISTOT, GRANDTOTAL, ESTATUS, PAYSTA, PAYDAT, PAYREFNUM, PAYMET, SHISTA, SHIPDATE, SHIFEE, SHIFIRNAM, SHILASNAM, SHIADD1, SHIADD2, SHIPCITY, SHIPSTATE, SHIZIPCOD, SHICOU, SHIPHONUM, ORDSOU, ORDSOUORDI, EBAYSALREC, SHIMETSEL, ISRUSORD, INVPRI, INVPRIDAT, SHICAR, COMPANYID, ORDSOUORDT, STATIONID, CUSSERSTA, TAXRATE, TAXTOTAL, GOOORDNUM, ISINDIS, DISSTAON, PAYFEETOT, POSFEETOT, FINVALTOT, SHIWEITOTO, TRANUM, LOCNOT, UPC, MARSOU, GIFTWRAP, MARDISCOUN, CODMOVBOD, CODPOLIZA, CODCOS, CODAMADET, CODAMABAL, ORDERUNITS, OLDSTATE, LIQID, SHIAMOCAR, LIQID2, LIQID3, LIQID4, LIQID5, CODPROV) VALUES (
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
        '$CODPROV'/*CODPROV*/);
        ";

        $tRes = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
    }

    function insertOrderDet(){

        $CODDETORD = $CODORDEN = $ORDITEID = $PRODUCTID = $QTY = $DISNAM = $LINETOTAL = $EBAYITEMID = $BACORDQTY = $ORIUNIPRI = $ORISHICOS = $ADJUNIPRI = $ADJSHICOS = $INVAVAQTY = $UPC = $CODAMABAL = $QUAPUR = $LIQID = $BUCLE = 0;

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

        $tRes = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
    }


    function updateOrderDet(){

        $CODDETORD = $CODORDEN = $ORDITEID = $PRODUCTID = $QTY = $DISNAM = $LINETOTAL = $EBAYITEMID = $BACORDQTY = $ORIUNIPRI = $ORISHICOS = $ADJUNIPRI = $ADJSHICOS = $INVAVAQTY = $UPC = $CODAMABAL = $QUAPUR = $LIQID = $BUCLE = 0;

        $query = "
        REPLACE INTO tra_ord_det (CODDETORD, CODORDEN, ORDITEID, PRODUCTID, QTY, DISNAM, LINETOTAL, EBAYITEMID, BACORDQTY, ORIUNIPRI, ORISHICOS, ADJUNIPRI, ADJSHICOS, INVAVAQTY, UPC, CODAMABAL, QUAPUR, LIQID, BUCLE) VALUES (
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

        $tRes = mysqli_query(conexionProveedorLocal($_SESSION['pais']), $query);
    }

    function getNewOrderId(){
        $qry = "SELECT ORDERID FROM tra_ord_enc WHERE CODTORDEN = 'LOCALES' ORDER BY ORDERID DESC LIMIT 1;";
        $res = mysqli_query(conexion($_SESSION['pais']), $qry);
        $response = '';
        if($res){
            if($res->num_rows > 0){
                $response = ((int)mysqli_fetch_array($res)[0]) + 1;
            }
            else{
                $tCountryCodeQry = "SELECT CODIGO FROM direct WHERE nomPais = '".$_SESSION['pais']."';";
                $tCountryCodeRes = mysqli_query(conexion(), $tCountryCodeQry);
                $tCountryCode = '';
                if($tCountryCodeRes){
                    if($tCountryCodeRes->num_rows > 0){
                        $tCountryCode = mysqli_fetch_array($tCountryCodeRes)[0];
                    }
                }
                $response = str_pad($tCountryCode, 9, '0') . '1';
            }
        }
        return $response;
    }

    function getCustomerInfo($customerId){
        $qry = "SELECT ID, NAME, FNAME, LNAME FROM cat_customer WHERE '$customerId';";
        $res = mysqli_query(conexion($_SESSION['pais']), $qry);
        $response = '';
        if($res){
            if($res->num_rows > 0){
                $response = mysqli_fetch_array($res);
            }
        }
        return $response;
    }