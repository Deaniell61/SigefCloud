<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/paypal/paypal.php");

checkPending();

function checkPending()
{
    $paypal = new sigefPaypal(false);

    $transactionsQ = "
        SELECT 
            id, fac_id, `transaction`, MAX(tries) AS tries, `status`
        FROM
            tra_pp_det
        WHERE
            type = 'INVOICE'
                AND `status` != 'PAID'
                AND `status` != 'REFUNDED'
        GROUP BY fac_id
        ORDER BY tries DESC, `date` DESC;
    ";

    $transactionsR = mysqli_query(rconexion04(), $transactionsQ);

    if ($transactionsR->num_rows > 0) {
        while ($transactionsRow = mysqli_fetch_array($transactionsR)) {
            $row = $transactionsRow["id"];
            $id = $transactionsRow["transaction"];
            $fac = $transactionsRow["fac_id"];

            $tInvoice = $paypal->getInvoice($id);

            if (gettype($tInvoice) == "object") {
                echo "<br>NEW<br>codfac - $fac:<br>";
                $tPaidAmount = $tInvoice->paid_amount->paypal->value;

                if ($tPaidAmount > 0) {
                    //status
                    $tStatus = $tInvoice->status;

                    //data
                    //check payed
                    $facDataQ = "
                        SELECT 
                            ABONOS, TOTAL
                        FROM
                            tra_fact_enc
                        WHERE
                            codfact = '$fac';
                    ";
                    $facDataR = mysqli_query(rconexion04(), $facDataQ);
                    $facDataRow = mysqli_fetch_array($facDataR);
                    $tFacTotal = $facDataRow["TOTAL"];
                    $tFacAbonos = $facDataRow["ABONOS"];

                    //enc
                    $tCodReca = sys2015();
                    $contQ = "
                        SELECT 
                            (numero + 1) AS numero
                        FROM
                            tra_rec_enc
                        ORDER BY numero DESC
                        LIMIT 1;
                    ";
                    $contR = mysqli_query(rconexion04(), $contQ);
                    $tCont = mysqli_fetch_array($contR)[0];
                    $tDate = date("Y-m-d H:i:s");

                    $tCodClieQ = "
                        SELECT 
                            codclie
                        FROM
                            tra_fact_enc
                        WHERE
                            codfact = '$fac';
                    ";
                    $tCodClieR = mysqli_query(rconexion04(), $tCodClieQ);
                    $tCodClie = mysqli_fetch_array($tCodClieR)[0];

                    $recEncQ = "
                        INSERT INTO
                            tra_rec_enc 
                            (codreca,
                            abono,
                            serie,
                            numero,
                            fecha,
                            codcobra,
                            moneda,
                            codclie,
                            tasacambio,
                            total_d,
                            total_q) 
                        VALUES
                            ('$tCodReca',
                            '$tPaidAmount',
                            'PP',
                            '$tCont',
                            '$tDate',
                            'PP',
                            '$',
                            '$tCodClie',
                            '1',
                            '$tPaidAmount',
                            '$tPaidAmount');
                    ";


                    $existsQ = "
                        SELECT 
                            *
                        FROM
                            tra_rec_det
                        WHERE
                            codfact = '$fac';
                    ";
                    $existsR = mysqli_query(rconexion04(), $existsQ);

                    if ($existsR->num_rows == 0) {
                        echo "<br>tra_rec_enc:<br>$recEncQ<br>";

                        mysqli_query(rconexion04(), $recEncQ);
                    }

                    //det
                    $ppDetQ = "
                        SELECT 
                            *
                        FROM
                            tra_pp_det
                        WHERE
                            fac_id = '$fac' AND `type` = 'PAYMENT';
                    ";

                    $ppDetR = mysqli_query(rconexion04(), $ppDetQ);

                    while ($ppDetRow = mysqli_fetch_array($ppDetR)) {

                        $tCoddReca = sys2015();
                        $tTransactionDate = $ppDetRow["date"];
                        $tTransactionId = $ppDetRow["transaction"];
                        $tPend = floatval($tFacTotal) - floatval($tFacAbonos);
                        $tAbono = $ppDetRow["amount"];

                        $recDetQ = "
                            INSERT INTO 
                                tra_rec_det
                                (coddreca,
                                codreca,
                                feccheque,
                                numdepo,
                                codfact,
                                valfact,
                                descuento,
                                valcobrar,
                                numcheque,
                                codbanc,
                                tasacambio,
                                valcobrado) 
                            VALUES
                                ('$tCoddReca',
                                '$tCodReca',
                                '$tTransactionDate',
                                '$tTransactionId',
                                '$fac',
                                '$tFacTotal',
                                '0',
                                '$tPend',
                                '$tTransactionId',
                                'PP',
                                '1',
                                '$tAbono');
                        ";

                        $existsDQ = "
                            SELECT 
                                *
                            FROM
                                tra_rec_det
                            WHERE
                                codfact = '' AND numdepo = '$tTransactionId';
                        ";
                        $existsDR = mysqli_query(rconexion04(), $existsDQ);

                        if ($existsDR->num_rows == 0) {
                            echo "<br>tra_rec_det:<br>$recDetQ<br>";

                            mysqli_query(rconexion04(), $recDetQ);
                        }


                        echo "$tStatus";

                        if ($tStatus == "MARKED_AS_PAID" || $tStatus == "PAID") {

                            //charge enc
                            $surchargeQ = "
                                SELECT RECVAL, RECPOR FROM cat_pay_mdo WHERE codpaymdo = '_4RH0QG4MH';
                            ";

                            $surchargeR = mysqli_query(conexion(""), $surchargeQ);
                            $surchargeRow = mysqli_fetch_array($surchargeR);

                            $tRecVal = $surchargeRow["RECVAL"];
                            $tRecPor = $surchargeRow["RECPOR"];
                            $tSurcharge = ($tRecVal + ($tFacTotal * $tRecPor));

                            $ttTotal = floatval($tFacTotal) + floatval($tSurcharge);

                            $surchargeUpdateEnc = "UPDATE tra_fact_enc SET TOTAL = '$ttTotal' WHERE CODFACT = '$fac';";

                            mysqli_query(rconexion04(), $surchargeUpdateEnc);

                            echo "<br>update tra_fact_enc:<br>$surchargeUpdateEnc<br>";

                            //charge det
                            $tCoddFact = sys2015();
                            $surchargeUpdateDet = "
                                INSERT INTO tra_fact_det (
                                    coddfact,
                                    codfact,
                                    orden,
                                    codprod,
                                    descrip,
                                    presenta,
                                    cantidad,
                                    precio,
                                    scobro,
                                    total,
                                    codtgasto) 
                                VALUES (
                                    '$tCoddFact',
                                    '$fac',
                                    '1850',
                                    'SERV1015',
                                    'Recargo por transaccion.',
                                    'UNIDAD',
                                    '1',
                                    '$tSurcharge',
                                    '$tSurcharge',
                                    '$tSurcharge',
                                    '_2LX0GQXI3');
                            ";

                            mysqli_query(rconexion04(), $surchargeUpdateDet);

                            echo "<br>update tra_fact_det:<br>$surchargeUpdateDet<br>";

                        }
                    }

                    $updateStatusQ = "
                        UPDATE tra_pp_det SET `status` = '$tStatus', `amount` = '$tPaidAmount' WHERE id = '$row';
                    ";
                    mysqli_query(rconexion04(), $updateStatusQ);

                    echo "<br>status:$tStatus<br>";

                    //payments
                    $tPayments = $tInvoice->payments;
                    foreach ($tPayments as $payment) {
                        $tPaymentId = $payment->transaction_id;
                        $tPaymentDate = $payment->date;
                        $tPaymentAmount = $payment->amount->value;

                        $checkPaymentQ = "
                        SELECT 
                            *
                        FROM
                            tra_pp_det
                        WHERE
                            type = 'PAYMENT' AND `transaction` = '$tPaymentId';
                    ";

                        $checkPaymentR = mysqli_query(rconexion04(), $checkPaymentQ);

                        if ($checkPaymentR->num_rows == 0) {
                            $insertPaymentQ = "
                            INSERT INTO tra_pp_det 
                                (`type`, `fac_id`, `date`, `transaction`, `amount`) 
                            VALUES
                                ('PAYMENT', '$fac', '$tPaymentDate', '$tPaymentId', '$tPaymentAmount');
                        ";
                            mysqli_query(rconexion04(), $insertPaymentQ);
                        }
                    }

                    //refunds
                    $tRefunds = $tInvoice->refunds;
                    foreach ($tRefunds as $refund) {
                        $tRefundId = $refund->transaction_id;
                        $tRefundDate = $refund->date;
                        $tRefundAmount = $refund->amount->value;

                        $checkRefundQ = "
                        SELECT 
                            *
                        FROM
                            tra_pp_det
                        WHERE
                            type = 'REFUND' AND `transaction` = '$tRefundId';
                    ";

                        $checkRefundR = mysqli_query(rconexion04(), $checkRefundQ);

                        if ($checkRefundR->num_rows == 0) {
                            $insertRefundQ = "
                            INSERT INTO tra_pp_det 
                                (`type`, `fac_id`, `date`, `transaction`, `amount`) 
                            VALUES
                                ('REFUND', '$fac', '$tRefundDate', '$tRefundId', '$tRefundAmount');
                        ";

                            mysqli_query(rconexion04(), $insertRefundQ);
                        }
                    }

                    //total
                    $updatePaymentQ = "
                        UPDATE tra_fact_enc SET ABONOS = '$tPaidAmount' WHERE CODFACT = '$fac';
                    ";
                    mysqli_query(rconexion04(), $updatePaymentQ);
                }
                else{
                    echo "NO PAYMENTS YET...<br>";
                }
            } else if (gettype($tInvoice) == "array") {

                $tStatus = $tInvoice["status"] . " - " . $tInvoice["message"];
                echo "<br>E:$tStatus<br>";
            }
        }
    }
}

