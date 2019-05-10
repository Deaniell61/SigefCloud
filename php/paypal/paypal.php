<?php

error_reporting(E_ERROR);
ini_set('display_errors', 'On');

require __DIR__ . '/autoload.php';

include_once("common.php");

use PayPal\Api\Address;
use PayPal\Api\BillingInfo;
use PayPal\Api\Currency;
use PayPal\Api\Invoice;
use PayPal\Api\InvoiceAddress;
use PayPal\Api\InvoiceItem;
use PayPal\Api\MerchantInfo;
use PayPal\Api\PaymentTerm;
use PayPal\Api\Phone;
use PayPal\Api\ShippingInfo;
use PayPal\Api\Notification;
use PayPal\Api\PaymentDetail;
use PayPal\Api\RefundDetail;
use PayPal\Api\CancelNotification;

class sigefPaypal
{

    var $apiContext;
    var $isSandbox;

    /**
     * sigefPaypal constructor.
     */
    function __construct($isSandbox = true)
    {
        $this->isSandbox = $isSandbox;

        if ($this->isSandbox) {
            //sandbox
            $credentials = new \PayPal\Auth\OAuthTokenCredential(
                "AV4FssRDb7LyIRlW5GX1Ids7cRTVQP7kKe9BmIjMSsoD2sVrPfn7dwF69Pyj9i87Gmew1szT5Y2V1LRE",
                "EBk_8yFaZELVG0FhT-G75oQ3hC5NFOvcFp2RXGeDlRJXCDq0PmUvscOW0Oe_5SgOPY3zQzNjQkKnwJtU"
            );
        } else {
            //live
            $credentials = new \PayPal\Auth\OAuthTokenCredential(
                "AVQQH8epazuMP3xzUS3EkS8esnAeOPa7tlEggoI8dTRLI2ib1ZkuGWUwEV-QtE9Z_j3mMOCwZNGXQHHf",
                "EIaEop66ujwvwfTj9wrMN_hBhU8AewenmrIcXqK3xuWv0roFQOwS3gynmd80WAC8pYbOnfmPtuU-NiX5"
            );
        }

        $this->apiContext = new \PayPal\Rest\ApiContext($credentials);

        if (!$this->isSandbox) {
            $this->apiContext->setConfig(
                array(
                    'mode' => 'live',
                )
            );
        }
    }

    /**
     * @param $merchantInfo
     * @param $billingInfo
     * @param $shippingInfo
     * @param $itemsInfo
     * @param $reference
     * @param $logo
     * @param $pagoPar
     * @return array
     */
    public function createInvoice($merchantInfo, $billingInfo, $shippingInfo, $itemsInfo, $reference, $logo, $pagoPar)
    {
        //invoice
        $invoice = new Invoice();

        $merchantInfoEmail = $merchantInfo["email"];
        $merchantInfoFirstName = $merchantInfo["firstName"];
        $merchantInfoLastName = $merchantInfo["lastName"];
        $merchantInfoBusinessName = $merchantInfo["businessName"];
        $merchantInfoPhonePrefix = $merchantInfo["phonePrefix"];
        $merchantInfoPhoneNumber = $merchantInfo["phoneNumber"];
        $merchantInfoAddress = $merchantInfo["address"];
        $merchantInfoCity = $merchantInfo["city"];
        $merchantInfoState = $merchantInfo["state"];
        $merchantInfoPostalCode = $merchantInfo["postalCode"];
        $merchantInfoCountryCode = $merchantInfo["countryCode"];

        $invoice
            ->setMerchantInfo(new MerchantInfo())
            ->setBillingInfo(array(new BillingInfo()))
            ->setNote("")
            ->setPaymentTerm(new PaymentTerm())
            ->setShippingInfo(new ShippingInfo());

        //merchant info
        $invoice->getMerchantInfo()
//            ->setEmail($merchantInfoEmail)
            ->setFirstName($merchantInfoFirstName)
            ->setLastName($merchantInfoLastName)
            ->setbusinessName($merchantInfoBusinessName)
            ->setPhone(new Phone())
            ->setAddress(new Address());

        $invoice->getMerchantInfo()->getPhone()
            ->setCountryCode($merchantInfoPhonePrefix)
            ->setNationalNumber($merchantInfoPhoneNumber);

        $invoice->getMerchantInfo()->getAddress()
            ->setLine1($merchantInfoAddress)
            ->setCity($merchantInfoCity)
            ->setState($merchantInfoState)
            ->setPostalCode($merchantInfoPostalCode)
            ->setCountryCode($merchantInfoCountryCode);

        //billing info
        $billingInfoEmail = $billingInfo["email"];
        $billingInfoBusinessName = $billingInfo["businessName"];
        $billingInfoAddress = $billingInfo["address"];
        $billingInfoCity = $billingInfo["city"];
        $billingInfoState = $billingInfo["state"];
        $billingInfoPostalCode = $billingInfo["postalCode"];
        $billingInfoCountryCode = $billingInfo["countryCode"];

        $billing = $invoice->getBillingInfo();
        $billing[0]
            ->setEmail($billingInfoEmail);

        $billing[0]->setBusinessName($billingInfoBusinessName)
            ->setAddress(new InvoiceAddress());

        $billing[0]->getAddress()
            ->setLine1($billingInfoAddress)
            ->setCity($billingInfoCity)
            ->setState($billingInfoState)
            ->setPostalCode($billingInfoPostalCode)
            ->setCountryCode($billingInfoCountryCode);

        //shipping
        $shippingInfoEmail = $shippingInfo["email"];
        $shippingInfoFirstName = $shippingInfo["firstName"];
        $shippingInfoLastName = $shippingInfo["lastName"];
        $shippingInfoAddress = $shippingInfo["address"];
        $shippingInfoCity = $shippingInfo["city"];
        $shippingInfoState = $shippingInfo["state"];
        $shippingInfoPostalCode = $shippingInfo["postalCode"];
        $shippingInfoCountryCode = $shippingInfo["countryCode"];
        $shippingInfoPhone = $shippingInfo["phone"];
        $shippingInfoPhonePrefix = $shippingInfo["phonePrefix"];

        $invoice->getShippingInfo()
            ->setFirstName($shippingInfoFirstName)
            ->setLastName($shippingInfoLastName)
            ->setBusinessName("Not applicable")
            ->setPhone(new Phone())
            ->setAddress(new InvoiceAddress());

        $invoice->getShippingInfo()->getPhone()
            ->setCountryCode($shippingInfoPhonePrefix)
            ->setNationalNumber($shippingInfoPhone);

        $invoice->getShippingInfo()->getAddress()
            ->setLine1($shippingInfoAddress)
            ->setCity($shippingInfoCity)
            ->setState($shippingInfoState)
            ->setPostalCode($shippingInfoPostalCode)
            ->setCountryCode($shippingInfoCountryCode);

        $items = array();
        for ($cont = 0; $cont < count($itemsInfo); $cont++) {

            $itemName = $itemsInfo[$cont]["name"];
            $itemQuantity = $itemsInfo[$cont]["quantity"];
            $itemPrice = $itemsInfo[$cont]["price"];

            $items[$cont] = new InvoiceItem();
            $items[$cont]
                ->setName($itemName)
                ->setQuantity($itemQuantity)
                ->setUnitPrice(new Currency());
            $items[$cont]->getUnitPrice()
                ->setCurrency("USD")
                ->setValue($itemPrice);
        }

        //end
        $invoice->setItems($items);

        $invoice->getPaymentTerm()
            ->setTermType("DUE_ON_RECEIPT");

        //logo
        $invoice->setLogoUrl($logo);

        //reference
        $invoice->setNumber($reference);
        $invoice->setReference($reference);

        //pagopar
        $invoice->setAllowPartialPayment($pagoPar);

        //action
        $request = clone $invoice;

        try {
            $invoice->create($this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $data = json_decode($ex->getData());
            return $response = [
                "status" => "ERROR",
                "message" => $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue,
            ];
        }

        $status = $this->sendInvoice($invoice);

        if ($status != false) {
            return $response = [
                "status" => "SUCCESS",
                "message" => $invoice->getId(),
            ];
        }

        return $response = [
            "status" => "ERROR",
            "message" => $status,
        ];
    }

    /**
     * @param $invoice
     * @return string
     */
    function sendInvoice($invoice)
    {
        try {
            $sendStatus = $invoice->send($this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $data = json_decode($ex->getData());
            return $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue;
        }

        return $sendStatus;
    }

    /**
     * @param $id
     * @return array|Invoice
     */
    function getInvoice($id)
    {
        try {
            $invoice = Invoice::get($id, $this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $data = json_decode($ex->getData());

            return $response = [
                "status" => "ERROR",
                "message" => $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue,
            ];
        }

        return $invoice;
    }

    /**
     * @param $id
     * @return array|Invoice
     */
    public function statusInvoice($id)
    {

        $invoice = $this->getInvoice($id);

        if (gettype($invoice) == "array") {
            return $invoice;
        }

        return $response = [
            "status" => "SUCCESS",
            "message" => $invoice->getStatus(),
        ];
    }

    /**
     * @param $id
     * @return array|bool|Invoice|string
     */
    public function remindInvoice($id)
    {

        $invoice = $this->getInvoice($id);

        if (gettype($invoice) == "array") {
            return $invoice;
        }

        try {
            $notify = new Notification();
            $notify
                ->setSubject("Past due")
                ->setNote("Please pay soon")
                ->setSendToMerchant(true);
            $remindStatus = $invoice->remind($notify, $this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $data = json_decode($ex->getData());

            return $response = [
                "status" => "ERROR",
                "message" => $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue,
            ];
        }

        return $response = [
            "status" => "SUCCESS",
            "message" => $id,
        ];
    }

    /**
     * @param $id
     * @param $subject
     * @param $note
     * @param $notifyMerchant
     * @param $notifyPayer
     * @return array|Invoice
     */
    public function cancelInvoice($id, $subject, $note, $notifyMerchant, $notifyPayer)
    {

        $invoice = $this->getInvoice($id);

        if (gettype($invoice) == "array") {
            return $invoice;
        }

        try {
            $notify = new CancelNotification();
            $notify
                ->setSubject($subject)
                ->setNote($note)
                ->setSendToMerchant($notifyMerchant)
                ->setSendToPayer($notifyPayer);
            $cancelStatus = $invoice->cancel($notify, $this->apiContext);
        } catch (Exception $ex) {
            $data = json_decode($ex->getData());

            return $response = [
                "status" => "ERROR",
                "message" => $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue,
            ];
        }

        return $response = [
            "status" => "SUCCESS",
            "message" => $cancelStatus,
        ];
    }

    /**
     * @param $id
     * @return array|Invoice
     */
    public function deleteInvoice($id)
    {

        $invoice = $this->getInvoice($id);

        if (gettype($invoice) == "array") {
            return $invoice;
        }

        try {
            $deleteStatus = $invoice->delete($this->apiContext);
        } catch (Exception $ex) {
            $data = json_decode($ex->getData());

            return $response = [
                "status" => "ERROR",
                "message" => $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue,
            ];
        }

        return $response = [
            "status" => "SUCCESS",
            "message" => $deleteStatus,
        ];
    }

    /**
     * @param $id
     * @param $data
     * @return array|Invoice
     */
    public function addPayment($id, $data)
    {

        $invoice = $this->getInvoice($id);

        if (gettype($invoice) == "array") {
            return $invoice;
        }

        $amount = $data["amount"];
        $date = $data["date"];
        $reference = $data["reference"];

        $payment = new PaymentDetail();
        $payment->setMethod("CHECK");
        $payment->setDate($date);
        $payment->setNote($reference);
        $payment
            ->setAmount(new Currency());
        $payment->getAmount()
            ->setCurrency("USD")
            ->setValue($amount);

        try {
            $status = $invoice->recordPayment($payment, $this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $data = json_decode($ex->getData());
            return $response = [
                "status" => "ERROR",
                "message" => $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue,
            ];
        }

        return $response = [
            "status" => "SUCCESS",
            "message" => $status,
        ];
    }

    /**
     * @param $id
     * @param $data
     * @return array|Invoice
     */
    public function addRefund($id, $data)
    {

        $invoice = $this->getInvoice($id);

        if (gettype($invoice) == "array") {
            return $invoice;
        }

        $amount = $data["amount"];
        $date = $data["date"];
        $reference = $data["reference"];

        $refund = new RefundDetail();
        $refund->setDate($date);
        $refund->setNote($reference);
        $refund
            ->setAmount(new Currency());
        $refund->getAmount()
            ->setCurrency("USD")
            ->setValue($amount);

        try {
            $status = $invoice->recordRefund($refund, $this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $data = json_decode($ex->getData());
            return $response = [
                "status" => "ERROR",
                "message" => $data->message . " " . $data->error_description . " " . $data->details[0]->field . " " . $data->details[0]->issue,
            ];
        }

        return $response = [
            "status" => "SUCCESS",
            "message" => $status,
        ];
    }
}
