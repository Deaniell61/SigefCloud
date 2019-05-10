<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
$idioma = idioma();
@$tipo = $_POST['tipo'];

switch ($tipo) {
    case "subCategory":
        {
            echo comboSubCategorias($_POST['codempresa'], $_POST['pais'], $_POST['categoria']);
            break;
        }
    case "Empresas":
        {
            echo comboEmpresas($_POST['pais']);
            break;
        }
    case "marcas":
        {
            echo comboMarca($_POST['codempresa'], $_POST['pais'], '', $_POST['esmas']);
            break;
        }
    case "manufact":
        {
            echo comboManufacturadores($_POST['codempresa'], $_POST['pais'], $_POST['esmas']);
            break;
        }
    case "prolin":
        {
            echo comboProdLin($_POST['codempresa'], $_POST['pais'], '', $_POST['esmas']);
            break;
        }
    case "sabor":
        {
            echo comboFlavor($_POST['codempresa'], $_POST['pais'], $_POST['esmas']);
            break;
        }
    case "formula":
        {
            echo comboFormulas($_POST['codempresa'], $_POST['pais'], $_POST['esmas']);
            break;
        }
    case "cocina":
        {
            echo comboCocina($_POST['codempresa'], $_POST['pais'], $_POST['esmas']);
            break;
        }
    case "seller":
        {
            echo comboSeller($_POST['codempresa'], $_POST['pais'], $_POST['esmas']);
            break;
        }
    case "size":
        {
            echo comboSize($_POST['codempresa'], $_POST['pais'], $_POST['pres'], $_POST['esmas']);
            break;
        }
}
function comboCategorias($empresa, $pais)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codcate,nombre, nombri from cat_cat_pro order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            if ($idioma == "es") {
                $value = $row["nombre"];
            } else if ($idioma == "en") {
                $value = $row["nombri"];
            }
            $res = $res . "<option value=\"" . $row['codcate'] . "\">" . limpiar_caracteres_sql(utf8_encode($value)) . "</option>";
        }
    }
    return $res;
}

function comboSubCategorias($empresa, $pais, $categoria)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codscapro,nombre, nombri from cat_sca_pro where catparent='" . $categoria . "' and catparent!='' order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            if ($idioma == "es") {
                $value = $row["nombre"];
            } else if ($idioma == "en") {
                $value = $row["nombri"];
            }
            $res = $res . "<option value=\"" . $row['codscapro'] . "\">" . limpiar_caracteres_sql(utf8_encode($value)) . "</option><script>cat1=1;</script>";
        }

    }
    return $res;
}

function comboPaquetes($empresa, $pais)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codpack,nombre from cat_tip_emp order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codpack'] . "\">" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre'])))) . "</option>";
        }
    }
    return $res;
}

function comboProdLin($empresa, $pais, $esmas, $prov)
{
    if ($prov != "") {
        $prov = " and t.codprov='$prov'";
    }
    require_once($esmas . '../coneccion.php');
    require_once($esmas . '../fecha.php');
    $idioma = idioma();
    include($esmas . '../idiomas/' . $idioma . '.php');
    $squery = "select p.codprolin,p.prodline from cat_pro_lin p inner join tra_cat_prov t on t.codcat=p.codprolin where p.codempresa='$empresa' and t.tipo=3$prov order by prodline";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codprolin'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['prodline'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboMarca($empresa, $pais, $esmas, $prov)
{
    if ($prov != "") {
        $prov = " and t.codprov='$prov'";
    }
    require_once($esmas . '../coneccion.php');
    require_once($esmas . '../fecha.php');
    $idioma = idioma();
    include($esmas . '../idiomas/' . $idioma . '.php');
    $squery = "select m.codmarca,m.nombre from cat_marcas m inner join tra_cat_prov t on t.codcat=m.codmarca where m.codempresa='$empresa'$prov and t.tipo=1 order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codmarca'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboSize($empresa, $pais, $presentacion, $prov)
{
    if ($prov != "") {
        $prov = " and t.codprov='$prov'";
    }
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');

    $squery = "select f.codprepro,f.nombre,f.unidades,f.peso from cat_pre_prod f inner join tra_cat_prov t on t.codcat=f.codprepro where f.codempresa='$empresa' and t.tipo=8$prov order by nombre";


    $res = "<option value=\"\" ></option>";


    if ($ejecutar = mysqli_query(conexion($pais), $squery)) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {

            $sel = "";
            if ($row['codprepro'] == $presentacion) {
                $sel = " selected ";
            }

            $peso = $row['peso'];
            $Med = substr($row['nombre'], strlen($row['nombre']) - 2, strlen($row['nombre']));
            $medida = "select abre,nombre,factor,opera from cat_uni_peso";
            if ($ejecuta = mysqli_query(conexion($pais), $medida)) {
                while ($rowM = mysqli_fetch_array($ejecuta, MYSQLI_ASSOC)) {
                    if ($rowM['abre'] == $Med) {
                        switch ($rowM['opera']) {
                            case "*":
                                {
                                    $peso = $peso * $rowM['factor'];
                                    break;
                                }
                            case "/":
                                {
                                    $peso = $peso / $rowM['factor'];
                                    break;
                                }
                        }
                        break;
                    }

                }
            }

            $res = $res . "<option peso=\"" . $peso . "\" medida=\"" . substr($row['nombre'], strlen($row['nombre']) - 2, strlen($row['nombre'])) . "\" unidades=\"" . $row['unidades'] . "\" value=\"" . $row['codprepro'] . "\"" . $sel . ">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }
    $res = $res . "<script>
setTimeout(function(){
		document.getElementById('size').value='" . $presentacion . "';
		},1000);
</script>";
    return $res;
}

function comboGenero($empresa, $pais)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codgender,namegender from cat_gender order by namegender";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codgender'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['namegender'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboFlavor($empresa, $pais, $prov)
{
    if ($prov != "") {
        $prov = " and t.codprov='$prov'";
    }
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select f.codflavor,f.nombre from cat_flavors f inner join tra_cat_prov t on t.codcat=f.codflavor where f.codempresa='$empresa' and t.tipo=4$prov order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codflavor'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboCanal($empresa, $pais, $esmas)
{
    require_once($esmas . '../coneccion.php');
    require_once($esmas . '../fecha.php');
    $idioma = idioma();
    include($esmas . '../idiomas/' . $idioma . '.php');
    $squery = "select codchan,channel from cat_sal_cha where columna!='' and CHANNEL = 'Sales on Line' order by channel";
    $res = "";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codchan'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['channel'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboCanal2($empresa, $pais, $esmas)
{
    require_once($esmas . '../coneccion.php');
    require_once($esmas . '../fecha.php');
    $idioma = idioma();
    include($esmas . '../idiomas/' . $idioma . '.php');
    $squery = "select codchan,channel from cat_sal_cha where columna!='' order by channel";
    $res = "";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codchan'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['channel'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboManufacturadores($empresa, $pais, $prov)
{
    if ($prov != "") {
        $prov = " and t.codprov='$prov'";
    }

    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select m.codmanufac,m.nombre from cat_manufacturadores m inner join tra_cat_prov t on t.codcat=m.codmanufac where m.codempresa='$empresa' and t.tipo=2$prov order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codmanufac'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboAgeSegment($empresa, $pais)
{
    //$pais="";
    //where codempresa='$empresa'
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codageseg,nameageseg as nombre from cat_agesegment order by nombre";
    $res = "";


    if ($ejecutar = mysqli_query(conexion($pais), $squery)) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $contador++;
            $res = $res . "<input type=\"checkbox\" id='$contador' value=\"" . substr(utf8_encode($row['nombre']), 0, 1) . "\" onChange=\"agregarValorAge(this)\"" . checkAgeSegment(substr(utf8_encode($row['nombre']), 0, 1), $pais) . "><label for='$contador'>" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre'])))) . "</label>";
            if (($contador % 3) == 0) {
                $res = $res . "<br>";
            }
        }
    } else {
        $res = $squery;
    }


    return $res;
}

function comboFormulas($empresa, $pais, $prov)
{
    if ($prov != "") {
        $prov = " and t.codprov='$prov'";
    }
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select f.codform,f.nombre from cat_forms f inner join tra_cat_prov t on t.codcat=f.codform where f.codempresa='$empresa' and t.tipo=5$prov order by nombre";
    $res = "<option value=\"Composicion\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codform'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboPaisOrigen($empresa, $pais)
{
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codeco as codcountry,nombre from cat_country order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion(''), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codcountry'] . "\">" . limpiar_caracteres_sql($row['nombre']) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboPaisOrigen2($empresa, $pais)
{
    require_once('../../php/coneccion.php');
    require_once('../../php/fecha.php');
    $idioma = idioma();
    include('../../php/idiomas/' . $idioma . '.php');
    $squery = "select codeco as codcountry,nombre from cat_country order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion(''), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codcountry'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboConcerns($empresa, $pais)
{
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codconcern,nombre from cat_concerns where codempresa='$empresa' order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codconcern'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboCocina($empresa, $pais, $prov)
{
    if ($prov != "") {
        $prov = " and t.codprov='$prov'";
    }
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select c.codcocina,c.nombre from cat_cocina c inner join tra_cat_prov t on t.codcat=c.codcocina where c.codempresa='$empresa' and t.tipo=6$prov order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codcocina'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

#################################################comos de Bundles

function comboWarehouse($empresa, $pais)
{
    require_once('../../coneccion.php');
    require_once('../../fecha.php');
    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    $squery = "select codbodega,nombre from cat_bodegas order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codbodega'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboAccount($empresa, $pais)
{
    require_once('../../coneccion.php');
    require_once('../../fecha.php');
    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    $squery = "select codcuenta,nombre from cat_nomenclatura order by nombre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codcuenta'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboCanalSeller($empresa, $pais)
{
    require_once('../../coneccion.php');
    require_once('../../fecha.php');
    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    $squery = "select codchan,channel from cat_sal_cha where columna!='' order by channel";
    $res = "";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codchan'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['channel'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboUnidadesTipo($empresa, $pais)
{
    require_once('../../coneccion.php');
    require_once('../../fecha.php');
    $idioma = idioma();
    include('../../idiomas/' . $idioma . '.php');
    $squery = "select codunides,nombre from cat_uni_des";
    $res = "";
    $ejecutar = mysqli_query(conexion(""), $squery);
    $res = $res . "<option value=\"\"></option>";
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codunides'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboSeller($empresa, $pais, $proveedor)
{
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codseller,nombre from cat_sellers where codempresa='" . $empresa . "' and codprov='" . $proveedor . "' order by nombre";
    $res = "<option value=''></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codseller'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboProducto($empresa, $pais, $esmas, $proveedor)
{
    require_once($esmas . '../coneccion.php');
    require_once($esmas . '../fecha.php');
    $idioma = idioma();
    include($esmas . '../idiomas/' . $idioma . '.php');
    $squery = "select codprod,prodname from cat_prod where codempresa='$empresa' and codprov='$proveedor' order by prodname";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codprod'] . "\">" . limpiar_caracteres_sql(utf8_encode($row['prodname'])) . "</option>";
        }
    } else {
        $res = $squery;
    }

    return $res;
}

function comboArancel($empresa, $pais)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codarancel,nombre,codigo from cat_par_arancel order by nombre,codigo";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            if ($row['nombre'] == '') {
                $gio = '';
            } else {
                $gio = '-';
            }
            $res = $res . "<option value=\"" . $row['codarancel'] . "\">" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre']))) . $gio . ((utf8_decode($row['codigo'])))) . "</option>";
        }
    }
    return $res;
}

function comboPeriodo($empresa, $pais)
{
    //$pais="";
    require_once($pais . '../coneccion.php');
    require_once($pais . '../fecha.php');
    $idioma = idioma();
    include($pais . '../idiomas/' . $idioma . '.php');
    $squery = "select codperi,nombre from cat_peri order by nombre desc";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion(""), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            if ($row['nombre'] == '') {
                $gio = '';
            } else {
                $gio = '-';
            }
            $res = $res . "<option value=\"" . $row['codperi'] . "\">" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre'])))) . "</option>";
        }
    }
    return $res;
}

function comboTransporte($empresa, $pais)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codtransporte,nombre from cat_transportes order by nombre";
    $res = "";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $contador++;
            $res = $res . "<input type=\"checkbox\" id='tra$contador' value=\"" . substr(utf8_encode($row['nombre']), 0, 2) . "\" onChange=\"agregarValorTransp(this);verificaImportantes('Exportar','guardar26');\"><label for='$contador'>" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre'])))) . "</label><script>CompruebaCheck('Transporte',document.getElementById('tra$contador'));</script>";
            if (($contador % 3) == 0) {
                $res = $res . "<br>";
            }
        }
    }
    return $res;
}

function comboExportacion($empresa, $pais)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codforexp,nombre,codigo from cat_for_exportar order by nombre";
    $res = "";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $contador++;
            $res = $res . "";
            $res = $res . "<input type=\"checkbox\" id='expo$contador' value=\"" . ($row['codigo']) . "\" onChange=\"agregarValorFormExport(this);verificaImportantes('Exportar','guardar26');\"><label for='$contador'>" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre'])))) . "</label><script>CompruebaCheck('formasExportacion',document.getElementById('expo$contador'));</script>";
            if (($contador % 1) == 0) {
                $res = $res . "<br>";
            }
        }
    }
    return $res;
}

function comboCanalComercializa($empresa, $pais)
{
    //$pais="";
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codcomcan,nombre,codigo from  cat_com_canales order by nombre";
    $res = "";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $contador++;
            $res = $res . "<input type=\"checkbox\" id='comer$contador' value=\"" . ($row['codigo']) . "\" onChange=\"agregarValorCanalesComercial(this);verificaImportantes('Exportar','guardar26');\"><label for='$contador'>" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre'])))) . "</label><script>CompruebaCheck('canalesComercializa',document.getElementById('comer$contador'));</script>";
            if (($contador % 1) == 0) {
                $res = $res . "<br>";
            }
        }
    }
    return $res;
}

function comboMedidas($empresa, $pais)
{
    require_once('../../php/coneccion.php');
    require_once('../../php/fecha.php');
    $idioma = idioma();
    include('../../php/idiomas/' . $idioma . '.php');
    $squery = "select abre,nombre,factor,opera from cat_uni_peso order by nombre,abre";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['abre'] . "\">" . limpiar_caracteres_sql(ucwords(strtolower(utf8_encode($row['nombre'])))) . "</option>";
        }
    }
    return $res;
}

function checkAgeSegment($busca, $pais)
{
    $squery = "select agesegment from cat_prod where mastersku='" . $_SESSION['mastersku'] . "' and agesegment like '%" . $busca . "%'";
    $res = "";

    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = " checked ";

        }
    }
    return $res;

}

function comboEmpresas($pais)
{
    require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $squery = "select codempresa,nombre from  cat_empresas where pais='$pais' order by nombre limit 1";
    $res = "";
    $ejecutar = mysqli_query(conexion(""), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codempresa'] . "\" selected>" . limpiar_caracteres_sql(utf8_encode($row['nombre'])) . "</option>";
        }
    } else {
        $res = $squery;
    }
    return $res;
}

?>
