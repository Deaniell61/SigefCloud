<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/php/fecha.php');
    $idioma = idioma();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/php/idiomas/' . $idioma . '.php');
?>
<html>
    <div class="recordForm">
        <div>
            <div class="leftSide">
                <?= $lang[$idioma]['productid'] ?>
            </div>
            <div class="rightSide">
                <input disabled
                       type="text"
                       id="codigo" />
            </div>
        </div>
        <div>
            <div class="leftSide">
                <?= $lang[$idioma]['Nombre'] ?>
            </div>
            <div class="rightSide">
                <input type="text"
                       id="nombre" />
            </div>
        </div>
    </div>
</html>

<style>
    .recordForm{
        width: 75%;
        height:100%;
    }
</style>