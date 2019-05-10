<?php

session_start();

/**
 * Class paypalOperations
 */
class paypalOperations
{

    var $paypal;
    var $isSandbox = false;

    /**
     * paypalOperations constructor.
     */
    public function __construct()
    {

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/paypal/paypal.php");
        $this->paypal = new sigefPaypal($this->isSandbox);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function generateOrderInvoice($id, $wd, $separator)
    {

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

        //order
        $orderQ = "
            SELECT
                enc.codfact,
                enc.codclie,
                enc.serie,
                enc.numero,
                enc.abonos,
                enc.total,
                enc.pagopar,
                enc.serie,
                enc.numero
            FROM
                tra_fact_enc AS enc
            WHERE
                enc.codfact = '$id';
        ";

        if ($wd == "wd") {
            $orderR = mysqli_query(rconexion04(), $orderQ);
        } else {
            $orderR = mysqli_query(conexion($wd), $orderQ);
        }
        $orderRow = mysqli_fetch_array($orderR);

        $tCodClie = $orderRow["codclie"];
        $tCodFact = $orderRow["codfact"];
        $tSerie = $orderRow["serie"];
        $tNumero = $orderRow["numero"];
//        $tReference = $orderRow["reference"];
        $tTotal = $orderRow["total"];
        $tAbonos = $orderRow["abonos"];
        $tSaldo = $tTotal - $tAbonos;
//        $tAbonos = 2;
        $tPagoPar = ($orderRow["pagopar"] == 1) ? true : false;
        $tPagoPar = true;

        //detail
        $detailQ = "
            SELECT 
                LEFT(CONCAT(det.codprod,
                            ' ',
                            det.descrip,
                            ' ',
                            det.detobser),
                    99) AS descrip,
                det.cantidad,
                det.precio
            FROM
                tra_fact_det AS det
            WHERE
                codfact = '$tCodFact';
        ";

        if ($wd == "wd") {
            $detailR = mysqli_query(rconexion04(), $detailQ);
        } else {
            $detailR = mysqli_query(conexion($wd), $detailQ);
        }

        $items = array();
        while ($detailRow = mysqli_fetch_array($detailR)) {

            $tName = utf8_encode($detailRow["descrip"]);
            $tQuantity = $detailRow["cantidad"];
//            $tQuantity = "14";
            $tPrice = $detailRow["precio"];
//            $tPrice = "1";
            $item = [
                "name" => $tName,
                "quantity" => $tQuantity,
                "price" => $tPrice,
            ];

            array_push($items, $item);
        }

        //surcharge
        $surchargeQ = "
            SELECT RECVAL, RECPOR FROM cat_pay_mdo WHERE codpaymdo = '_4RH0QG4MH';
        ";

        $surchargeR = mysqli_query(conexion(""), $surchargeQ);
        $surchargeRow = mysqli_fetch_array($surchargeR);

        $tRecVal = $surchargeRow["RECVAL"];
        $tRecPor = $surchargeRow["RECPOR"];
        $tSurcharge = $tRecVal + ($tSaldo * $tRecPor);

        $item = [
            "name" => "Recargo por transaccion.",
            "quantity" => 1,
            "price" => $tSurcharge,
        ];

        array_push($items, $item);

        //reference
        $reference = $tSerie.$separator.$tNumero;

        //billing info
        $billingQ = "
            SELECT 
                PAYPALMAIL, MAILCONTAC, NOMBRE, NOMCONTACTO, APELCONTACTO, DIRECCION, TELEFONO, NOMCONTACTO, APELCONTACTO, WEBSITE, CODECO, CIUDAD
            FROM
                cat_prov
            WHERE
                codprov = '$tCodClie';
        ";


        $tCountry = ($_SESSION["lastFactCountry"] != "") ? $_SESSION["lastFactCountry"] : "Costa Rica";
        $billingR = mysqli_query(conexion($tCountry), $billingQ);
        $billingRow = mysqli_fetch_array($billingR);

        $billingInfoEmail = ($billingRow["PAYPALMAIL"] != "") ? $billingRow["PAYPALMAIL"] : $billingRow["MAILCONTAC"];
        $billingInfoFirstName = $billingRow["NOMCONTACTO"];
        $billingInfoLastName = $billingRow["APELCONTACTO"];
        $billingInfoBusinessName = limpiar_caracteres_sql($billingRow["NOMBRE"]);
        $billingInfoAddress = $billingRow["DIRECCION"];
        $billingInfoCity = $billingRow["CIUDAD"];
        $billingInfoState = $billingRow["state"];
        $billingInfoPostalCode = $billingRow["postalCode"];
        $billingInfoCountryCode = $billingRow["CODECO"];
        $billingInfoPhone = substr($billingRow["TELEFONO"], 3);
        $billingInfoPhonePrefix = substr($billingRow["TELEFONO"], 0, 3);

        if ($this->isSandbox) {
//            $billingInfoEmail = "mauricio.aldana@guatedirect.com";
//            $billingInfoEmail = "francisco.sandoval@worldirect.com";
//            $billingInfoEmail = "solus.huargo@gmail.com";
            $billingInfoEmail = "paulo.armas-buyer@coexport.net";
        }

        $billingInfo = [
            "email" => $billingInfoEmail,
            "businessName" => $billingInfoBusinessName,
            "firstName" => $billingInfoFirstName,
            "lastName" => $billingInfoLastName,
            "address" => $billingInfoAddress,
            "city" => $billingInfoCity,
            "state" => $billingInfoState,
            "postalCode" => $billingInfoPostalCode,
            "countryCode" => $billingInfoCountryCode,
            "phone" => $billingInfoPhone,
            "phonePrefix" => $billingInfoPhonePrefix,
        ];

        $shippingInfo = $billingInfo;

        //merchant
        if ($tSerie = "WDCR") {
            $tCodigo = 04;
        } else {
            $tCodigo = 04;
        }

        $merchantInfoQ = "
                SELECT 
                    EMAIL, NOMBRE, RSOCIAL, TELEFONO, FAX, WWW, DIRECCION
                FROM
                    cat_empresas
                WHERE
                    codigo = 04;
            ";

        $merchantInfoR = mysqli_query(rconexion(), $merchantInfoQ);
        $merchantInfoRow = mysqli_fetch_array($merchantInfoR);

        $merchantEmail = $merchantInfoRow["EMAIL"];
        $merchantFirstName = $merchantInfoRow["NOMBRE"];
        $merchantLastName = $merchantInfoRow["NOMBRE"];
        $merchantBusinessName = $merchantInfoRow["NOMBRE"];
        $merchantPhonePrefix = str_replace(["(", ")"], "", explode("-", $merchantInfoRow["TELEFONO"])[0]);
        $tPhone = explode("-", $merchantInfoRow["TELEFONO"]);
        array_shift($tPhone);
        $merchantPhoneNumber = implode("-", $tPhone);
        $merchantAddress = $merchantInfoRow["DIRECCION"];
        $merchantCity = $merchantInfoRow["CITY"];
        $merchantState = $merchantInfoRow["STATE"];
        $merchantPostalCode = $merchantInfoRow["POSTALCODE"];
        $merchantCountryCode = $merchantInfoRow["COUNTRYCODE"];

        $merchantInfo = [
            "email" => $merchantEmail,
            "firstName" => $merchantFirstName,
            "lastName" => $merchantLastName,
            "businessName" => $merchantBusinessName,
            "phonePrefix" => $merchantPhonePrefix,
            "phoneNumber" => $merchantPhoneNumber,
            "address" => $merchantAddress,
            "city" => $merchantCity,
            "state" => $merchantState,
            "postalCode" => $merchantPostalCode,
            "countryCode" => $merchantCountryCode,
        ];

        $logo = "https://desarrollo.sigefcloud.com/images/logoweb.png";

        $createResponse = $this->paypal->createInvoice($merchantInfo, $billingInfo, $shippingInfo, $items, $reference, $logo, $tPagoPar);

        if ($createResponse["status"] == 'SUCCESS') {
            $id = $createResponse["message"];
            $query = "
                insert into tra_pp_det (`transaction`, fac_id) values ('$id', '$tCodFact');
            ";

//            echo "$query<br>";
            if ($wd == "wd") {
                mysqli_query(rconexion04(), $query);
            } else {
                mysqli_query(conexion($wd), $query);
            }

            if (floatval($tAbonos) > 0) {
                $this->addPayments($tCodFact, $id);
            }
        }

        return json_encode($createResponse);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function remindInvoice($id, $wd)
    {

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $remindResponse = $this->paypal->remindInvoice($id);

        if ($remindResponse["status"] == "SUCCESS") {
            $triesQ = "
                select (tries + 1) as tries, fac_id from tra_pp_det where `transaction` = '$id' order by tries desc limit 1;
            ";

//            echo $triesQ . "<br>";

            if ($wd == "wd") {
                $triesR = mysqli_query(rconexion04(), $triesQ);
            } else {
                $triesR = mysqli_query(conexion($wd), $triesQ);
            }

            $triesRow = mysqli_fetch_array($triesR);
            $tCodFact = $triesRow["fac_id"];
            $tTries = $triesRow["tries"];

            $query = "
                insert into tra_pp_det (`transaction`, fac_id, tries) values ('$id', '$tCodFact', '$tTries');
            ";

            if ($wd == "wd") {
                mysqli_query(rconexion04(), $query);
            } else {
                mysqli_query(conexion($wd), $query);
            }
        }

        return json_encode($remindResponse);
    }

    public function cleanInvoice($id, $wd)
    {

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $q = "DELETE FROM tra_pp_det WHERE `transaction` = '$id';";

        if ($wd == "wd") {
            mysqli_query(rconexion04(), $q);
        } else {
            mysqli_query(conexion($wd), $q);
        }

        $response = [
            "status" => "SUCCESS",
            "message" => "deleted from transactions record",
        ];

        return json_encode($response);
    }


    /**
     * @param $id
     * @return false|string
     */
    public function statusInvoice($id, $wd)
    {

        $status = $this->paypal->statusInvoice($id);

        return json_encode($status);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function detailInvoice($id, $wd)
    {

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $q = "
                SELECT 
                    *
                FROM
                    tra_pp_det AS det
                        INNER JOIN
                    tra_fact_enc AS enc ON det.fac_id = enc.codfact
                where transaction = '$id' order by id desc limit 1;
        ";

        if ($wd == "wd") {
            $r = mysqli_query(rconexion04(), $q);
        } else {
            $r = mysqli_query(conexion($wd), $q);
        }

        $row = mysqli_fetch_array($r);
        $tTransaction = $row["transaction"];
        $tTries = $row["tries"];
        $tDate = $row["date"];
        $tAbonos = "$" . number_format(floatval($row["ABONOS"]), 2, ".", "");
        $tTotal = "$" . number_format(floatval($row["TOTAL"]), 2, ".", "");

        $response = [
            "transaction" => $tTransaction,
            "tries" => $tTries,
            "date" => $tDate,
            "abonos" => $tAbonos,
            "total" => $tTotal,
        ];

        return json_encode($response);
    }

    /**
     * @param $id
     * @param $invoice
     */
    public function addPayments($id, $invoice)
    {

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $paymentsQ = "
            SELECT 
                valcobrado,
                numcheque,
                feccheque
            FROM
                tra_rec_det
            WHERE
                codfact = '$id';
        ";

        $paymentsR = mysqli_query(rconexion04(), $paymentsQ);

        while ($paymentsRow = mysqli_fetch_array($paymentsR)) {
            $tVal = $paymentsRow["valcobrado"];
            $tVal = number_format($tVal, 2, ".", "");
            $tDate = date("Y-m-d H:i:s", strtotime($paymentsRow["feccheque"])) . " CDT";
            $tNum = $paymentsRow["numcheque"];

            $data = [
                "amount" => $tVal,
                "date" => $tDate,
                "reference" => $tNum
            ];

            $this->paypal->addPayment($invoice, $data);
        }
    }

    /**
     * @param $id
     * @param $subject
     * @param $note
     * @param $notifyMerchant
     * @param $notifyPayer
     * @return false|string
     */
    public function cancelInvoice($id, $subject, $note, $notifyMerchant, $notifyPayer)
    {

        $refundResponse = $this->paypal->cancelInvoice($id, $subject, $note, $notifyMerchant, $notifyPayer);

        return json_encode($refundResponse);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function deleteInvoice($id)
    {

        $refundResponse = $this->paypal->deleteInvoice($id);

        return json_encode($refundResponse);
    }

    /**
     * @param $id
     * @param $amount
     * @return array|\PayPal\Api\Invoice
     */
    public function payInvoice($id, $amount)
    {

        $data = [
            "amount" => $amount,
            "date" => "",
            "reference" => ""
        ];

        $payResponse = $this->paypal->addPayment($id, $data);

        return json_encode($payResponse);
    }

    /**
     * @param $id
     * @param $amount
     * @return false|string
     */
    public function refundInvoice($id, $amount)
    {

        $data = [
            "amount" => $amount,
            "date" => "",
            "reference" => ""
        ];

        $refundResponse = $this->paypal->addRefund($id, $data);

        return json_encode($refundResponse);
    }
}