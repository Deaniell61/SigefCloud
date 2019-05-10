<?php

namespace sigefcloud;

class product
{
    private $sku;
    private $country;
    private $isValid;

    private $sellercloud;

    const MSG_INVALID_PRODUCT = "invalid product.<br>";
    const MSG_INVALID_OPERATION = "invalid operation.<br>";
    const MSG_INVALID_CHANNEL = "invalid channel.<br>";

    //channels
    const CH_ALL = "ch_all";
    const CH_SELLERCLOUD = "ch_sellercloud";
    const CH_AMAZON = "ch_amazon";
    const CH_WALMART = "ch_walmart";
    const CH_EBAY = "ch_ebay";

    //operations
    const OP_CREATE_PRODUCT = "op_create";
    const OP_UPDATE_NAME = "op_update_name";
    const OP_UPDATE_DESCRIPTIONS = "op_update_descriptions";
    const OP_UPDATE_DIMENSIONS = "op_update_dimensions";
    const OP_UPDATE_WEIGHT = "op_update_weight";
    const OP_IMAGES = "op_images";
    const OP_SKU = "op_sku";

    public function __construct($sku, $country)
    {
        $this->sku = $sku;
        $this->country = $country;

        if (!isset($_SERVER["DOCUMENT_ROOT"])) {
            $_SERVER["DOCUMENT_ROOT"] = "/";
        }

        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $productQ = "
            SELECT 
                *
            FROM
                cat_prod
            WHERE
                mastersku = '$this->sku';
        ";

        $productR = mysqli_query(conexion($this->country), $productQ);
        $product = $productR->num_rows;

        if ($product == 1) {
            $this->isValid = true;
            $this->initializeChannels();
        } else {
            echo $this->sku . " - " . self::MSG_INVALID_PRODUCT;
            $this->isValid = false;
        }
    }

    public function sync($operation = self::OP_CREATE, array $channels = [self::CH_ALL])
    {
        if (!$this->isValid) {
            echo self::MSG_NOTVALID;
            return;
        }

        switch ($operation) {
            case self::OP_CREATE_PRODUCT:
                $this->createProductCH($channels);
                break;
            case self::OP_UPDATE_NAME:
                $this->updateNameCH($channels);
                break;
            case self::OP_UPDATE_DESCRIPTIONS:
                $this->updateDescriptionsCH($channels);
                break;
            case self::OP_UPDATE_DIMENSIONS:
                $this->updateDimensionsCH($channels);
                break;
            case self::OP_UPDATE_WEIGHT:
                echo $this->updateWeightCH($channels);
                break;
            case self::OP_SKU:
                $this->updateSKUCH($channels);
                break;
            default:
                return $operation . " - " . self::MSG_INVALID_OPERATION;
        }
    }

    private function createProductCH($channels)
    {

        foreach ($channels as $channel) {
            switch ($channel) {
                case self::CH_SELLERCLOUD:
                    $this->sellercloud->createProduct($this->sku, $this->country);
                    break;
                case self::CH_ALL:
                    break;
                default:
                    echo $channel . " - " . self::MSG_INVALID_CHANNEL;
                    break;
            }
        }
    }

    private function updateNameCH($channels)
    {

        foreach ($channels as $channel) {
            switch ($channel) {
                case self::CH_SELLERCLOUD:
                    $this->sellercloud->updateName($this->sku, $this->country);
                    break;
                case self::CH_ALL:
                    break;
                default:
                    echo $channel . " - " . self::MSG_INVALID_CHANNEL;
                    break;
            }
        }
    }

    private function updateDescriptionsCH($channels)
    {

        foreach ($channels as $channel) {
            switch ($channel) {
                case self::CH_SELLERCLOUD:
                    $this->sellercloud->updateDescriptions($this->sku, $this->country);
                    break;
                case self::CH_ALL:
                    break;
                default:
                    echo $channel . " - " . self::MSG_INVALID_CHANNEL;
                    break;
            }
        }
    }

    private function updateDimensionsCH($channels)
    {

        foreach ($channels as $channel) {
            switch ($channel) {
                case self::CH_SELLERCLOUD:
                    $this->sellercloud->updateDimensions($this->sku, $this->country);
                    break;
                case self::CH_ALL:
                    break;
                default:
                    echo $channel . " - " . self::MSG_INVALID_CHANNEL;
                    break;
            }
        }
    }


    private function updateWeightCH($channels)
    {

        foreach ($channels as $channel) {
            switch ($channel) {
                case self::CH_SELLERCLOUD:
                    echo $this->sellercloud->updateWeight($this->sku, $this->country);
                    break;
                case self::CH_ALL:
                    break;
                default:
                    echo $channel . " - " . self::MSG_INVALID_CHANNEL;
                    break;
            }
        }
    }

    private function updateSKUCH($channels)
    {

        foreach ($channels as $channel) {
            switch ($channel) {
                case self::CH_SELLERCLOUD:
                    $this->sellercloud->updateSKU($this->sku, $this->country);
                    break;
                case self::CH_ALL:
                    break;
                default:
                    echo $channel . " - " . self::MSG_INVALID_CHANNEL;
                    break;
            }
        }
    }

    private function initializeChannels()
    {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/channels/sellercloud/sellercloud.php");
        $this->sellercloud = new \channels\sellercloud();
    }
}
