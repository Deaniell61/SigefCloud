<?php

class urlBuilder{

    public function feeds(){

        return "https://api-gateway.walmart.com/v3/feeds?feedType=SUPPLIER_FULL_ITEM";
    }

    public function orders($mNextCursor){

        if($mNextCursor == ""){
            return "https://api-gateway.walmart.com/v3/orders/?shipNode=85565302&limit=50&createdStartDate=2018-04-01";
        }
        else{
            return "https://api-gateway.walmart.com/v3/orders/$mNextCursor";
        }
    }

    public function order($order){

        return "https://api-gateway.walmart.com/v3/orders/$order?shipNode=85565302";
    }

    public function ordersReleased(){

        return "https://api-gateway.walmart.com/v3/orders/released?shipNode=85565302&limit=200&createdStartDate=2018-01-28";
    }

    public function updateInventory(){

        return "https://api-gateway.walmart.com/v3/inventory?shipNode=85565302";
    }

    public function item(){

        return "https://api-gateway.walmart.com/v3/items/85565302";
    }

    public function shipping($purchaseOrderId){

        return "https://api-gateway.walmart.com/v3/orders/$purchaseOrderId/shipping?shipNode=85565302";
    }

    public function cancelOrder($purchaseOrderId){

        return "https://api-gateway.walmart.com/v3/orders/$purchaseOrderId/cancel?shipNode=85565302";
    }
}