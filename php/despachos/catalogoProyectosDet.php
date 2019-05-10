<?php
require_once('../../php/fecha.php');
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
?>

<div id="proyDetContainer">
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th><?= $lang[$idioma]['descripcionCargo'] ?></th>
            <th><?= $lang[$idioma]['monto'] ?></th>
            <th><?= $lang[$idioma]['qty'] ?></th>
            <th><?= $lang[$idioma]['valorCargo'] ?></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<style>
    #proyDetContainer{
        width: 100%;
        height: 100%;
        text-align: center;
    }
</style>