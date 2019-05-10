<?php
/**
 * Created by chqs
 * Date: 8/4/2016
 */
session_start();
$_SESSION['isCopy'] = $_POST['copyProduct'];
$_SESSION['origSKU'] = $_POST['origSKU'];