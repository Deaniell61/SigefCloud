<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
## usuario y clave pasados por el formulario
$codigo = $_POST['codigo'];
$pais = $_POST['pais'];
switch ($_POST['tipo']) {
    case "fact": {
        $direccion = $_POST['direccion'];
        $paisprov = $_POST['paisprov'];
        $ciudad = $_POST['ciudad'];
        $codpos = $_POST['codpos'];
        $nombreContacto = $_POST['nombreContacto'];
        $apellidoContacto = $_POST['apellidoContacto'];
        $emailContacto = $_POST['emailContacto'];
        $telefonoContacto = $_POST['telefonoContacto'];
        $cargoContacto = $_POST['cargoContacto'];
        $nit = $_POST['nit'];
        $ncomercial = $_POST['ncomercial'];
        $codcon = sys2015();
        $sql2 = "INSERT INTO cat_cont(codcont,nombre,apellido,email,direccion,pais,ciudad,codpos,telefono,puesto,form)
					VALUE('" . $codcon . "','" . $nombreContacto . "','" . $apellidoContacto . "','" . $emailContacto . "','" . $direccion . "','" . $paisprov . "','" . $ciudad . "','" . $codpos . "','" . $telefonoContacto . "','" . $cargoContacto . "','F')";
        $sql3 = "INSERT INTO tra_prov_cont(codcont,codigo) VALUES('" . $codcon . "','" . $codigo . "') ";
        $sql = "UPDATE cat_prov SET nit='" . $nit . "',ncomercial='" . $ncomercial . "',estatus=replace(estatus,'2','') WHERE codprov='" . $codigo . "'";
        break;
    }
    case "pago": {
        $direccion = "";
        $paisprov = "";
        $ciudad = "";
        $codpos = "";
        $formapago = $_POST['formapago'];
        $echeque = $_POST['echeque'];
        $banco = $_POST['banco'];
        $cuenta = $_POST['cuenta'];
        $paypalMail = $_POST['ppmail'];
        $nombreContacto = $_POST['nombreContacto'];
        $apellidoContacto = $_POST['apellidoContacto'];
        $emailContacto = $_POST['emailContacto'];
        $telefonoContacto = $_POST['telefonoContacto'];
        $cargoContacto = $_POST['cargoContacto'];
        $paypal1er = $_POST['paypal1er'];
        $swiftnum = $_POST['swiftnum'];
        $rounum = $_POST['rounum'];
        $codcon = sys2015();

        $exists = "
            SELECT 
                cont.codcont, prov.CODPROV, cont.EMAIL, cont.form
            FROM
                cat_prov AS prov
                    INNER JOIN
                tra_prov_cont AS piv ON prov.CODPROV = piv.codigo
                    INNER JOIN
                cat_cont AS cont ON piv.codcont = cont.codcont
            WHERE
                prov.CODPROV = '$codigo'
                    AND cont.form = 'P';
        ";

        $existsR = mysqli_query(conexion($pais), $exists);

        if($existsR->num_rows == 0){
            $sql2 = "INSERT INTO cat_cont(codcont,nombre,apellido,email,direccion,pais,ciudad,codpos,telefono,puesto,form)
					VALUE('" . $codcon . "','" . $nombreContacto . "','" . $apellidoContacto . "','" . $emailContacto . "','" . $direccion . "','" . $paisprov . "','" . $ciudad . "','" . $codpos . "','" . $telefonoContacto . "','" . $cargoContacto . "','P')";
            $sql3 = "INSERT INTO tra_prov_cont(codcont,codigo) VALUES('" . $codcon . "','" . $codigo . "') ";
        }
        else{
            $tcodcon = mysqli_fetch_array($existsR)["codcont"];
            $sql2 = "
                UPDATE cat_cont
                SET nombre = '$nombreContacto',apellido = '$apellidoContacto',email = '$emailContacto',direccion = '$direccion',pais = '$pais',ciudad = '$ciudad',codpos = '$codpos',telefono = '$telefonoContacto',puesto = '$cargoContacto',form = 'P' where codcont = '$tcodcon'";
            $sql3 = "";
        }



        $sql = "UPDATE cat_prov SET codbanco='" . $banco . "',estatus=replace(estatus,'3',''),echeque='" . $echeque . "',ctadepo='" . $cuenta . "',paypalmail='" . $paypalMail . "',fpago='" . $formapago . "', paypal1er = '$paypal1er', SWIFTNUM = '$swiftnum', ROUNUM = '$rounum' WHERE codprov='" . $codigo . "'";
//        echo "$sql";
        break;
    }
    case "cobro": {
        $direccion = "";
        $paisprov = "";
        $ciudad = "";
        $codpos = "";
        $tipoTarjeta = $_POST['tipoTarjeta'];
        $ntarjeta = $_POST['ntarjeta'];
        $titularTarjeta = $_POST['titularTarjeta'];
        $anioV = $_POST['anioV'];
        $mesV = $_POST['mesV'];
        $nombreContacto = $_POST['nombreContacto'];
        $apellidoContacto = $_POST['apellidoContacto'];
        $emailContacto = $_POST['emailContacto'];
        $telefonoContacto = $_POST['telefonoContacto'];
        $cargoContacto = $_POST['cargoContacto'];
        $codcon = sys2015();

        $exists = "
            SELECT 
                cont.codcont, prov.CODPROV, cont.EMAIL, cont.form
            FROM
                cat_prov AS prov
                    INNER JOIN
                tra_prov_cont AS piv ON prov.CODPROV = piv.codigo
                    INNER JOIN
                cat_cont AS cont ON piv.codcont = cont.codcont
            WHERE
                prov.CODPROV = '$codigo'
                    AND cont.form = 'C';
        ";

        $existsR = mysqli_query(conexion($pais), $exists);

        if($existsR->num_rows == 0){
            $sql2 = "INSERT INTO cat_cont(codcont,nombre,apellido,email,direccion,pais,ciudad,codpos,telefono,puesto,form)
					VALUE('" . $codcon . "','" . $nombreContacto . "','" . $apellidoContacto . "','" . $emailContacto . "','" . $direccion . "','" . $paisprov . "','" . $ciudad . "','" . $codpos . "','" . $telefonoContacto . "','" . $cargoContacto . "','C')";
            $sql3 = "INSERT INTO tra_prov_cont(codcont,codigo) VALUES('" . $codcon . "','" . $codigo . "') ";
        }
        else{
            $tcodcon = mysqli_fetch_array($existsR)["codcont"];
            $sql2 = "
                UPDATE cat_cont
                SET nombre = '$nombreContacto',apellido = '$apellidoContacto',email = '$emailContacto',direccion = '$direccion',pais = '$pais',ciudad = '$ciudad',codpos = '$codpos',telefono = '$telefonoContacto',puesto = '$cargoContacto',form = 'C' where codcont = '$tcodcon'";
            $sql3 = "";
        }

        $sql = "UPDATE cat_prov SET tipotar='" . $tipoTarjeta . "',estatus=replace(estatus,'4',''),ntar='" . $ntarjeta . "',titulartar='" . $titularTarjeta . "',mesvtar='" . $mesV . "',anvtar='" . $anioV . "' WHERE codprov='" . $codigo . "'";
        break;
    }
    case "Comercializa": {
        $codex = $_POST['codex'];
        /*$incre1=$_POST['incre1'];
        $incre2=$_POST['incre2'];
        $incre3=$_POST['incre3'];
        $incre4=$_POST['incre4'];
        $marmin=$_POST['marmin'];
        $marpro=$_POST['marpro'];
        $marmax=$_POST['marmax'];
        $marmincon=$_POST['marmincon'];*/
        $codcon = sys2015();
        $sql = "UPDATE cat_prov SET "/*marmin='".$marmin."*/ . "codex='" . $codex . "'"/*,marpro='".$marpro."',marmax='".$marmax."',marmincom='".$marmincon."',incre1='".$incre1."',incre2='".$incre2."',incre3='".$incre3."',incre4='".$incre4."'*/ . ",estatus=replace(estatus,'6','') WHERE codprov='" . $codigo . "'";
        break;
    }
}
if ($codigo == "" || $pais == "") {
    echo "<script>setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},500);</script><span>Debe completar todos los campos obligatorios</span>";
}
else {
    if (mysqli_query(conexion($pais), $sql)) {
        //echo $sql;
        if (isset($sql2)) {
            if (mysqli_query(conexion($pais), $sql2)) {
                if (isset($sql3)) {
                    if (mysqli_query(conexion($pais), $sql3)) {
                        echo "<script>window.opener.location.reload();setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},500);</script>" . $lang[$idioma]['ProveedorGuardado'] . "";
                    }
                    else {
                        echo $sql3;
                    }
                }
            }
            else {
                $sql2 = "UPDATE cat_cont SET nombre='" . $nombreContacto . "',apellido='" . $apellidoContacto . "',direccion='" . $direccion . "',pais='" . $paisprov . "',ciudad='" . $ciudad . "',codpos='" . $codpos . "',telefono='" . $telefonoContacto . "',puesto='" . $cargoContacto . "' WHERE email='" . $emailContacto . "'";
                if (mysqli_query(conexion($pais), $sql2)) {
                    echo "<script>window.opener.location.reload();setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},00);</script>" . $lang[$idioma]['ProveedorGuardado'] . "";
                }
                else {
                    echo $sql2;
                }
            }
        }
        else {
            echo "<script>window.opener.location.reload();setTimeout(function(){\$(\"#cargaLoad\").dialog(\"close\");},00);</script>" . $lang[$idioma]['ProveedorGuardado'] . "";
        }
    }
    else {
        echo "$sql";
    }
    mysqli_close(conexion($pais));
}
?>
