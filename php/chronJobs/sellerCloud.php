<?php
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
    $sellercloud = new sellercloud();
    $sellercloud->getClientName();
    mail(
        "solus.huargo@gmail.com",
        "tarea programada test",
        "se ejecuto la tarea programada exitosamente" . date("Y-m-d H:i:s")
    );