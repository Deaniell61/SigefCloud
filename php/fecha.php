<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function sys2015() {

    $inicio = 10000 / 2020020;
    $diasDesdeInicio = 25;
    $diasTotales = $diasDesdeInicio + (date('y') * 367);
    $diasTotalesBase36 = base_convert($diasTotales, 10, 36);

    $horaMilisec = date('H') * 3600000;
    $minMilisec = date('i') * 60000;
    $secMilisec = date('s') * 1000;
    //$milisec = floor(gettimeofday(true) / 1000);

    $t = microtime(true);
    $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
    $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
    $milisec = $d->format("u");

    //TODO usar solo un date para calcular todo, este fix se hizo ya que el anterior producia repetidos

    $horaMilisegundos = $horaMilisec + $minMilisec + $secMilisec + $milisec;
    $horaBase36 = sprintf('%06s', base_convert($horaMilisegundos, 10, 36));
    $sys2015 = '_' . $diasTotalesBase36 . $horaBase36;
    $sys2015 = strtoupper($sys2015);
    return $sys2015;

}

function anio() {

    return date('Y');
}

function getFecha() {

    return date('Y') . "/" . date('m') . "/" . date('d');
}

function idioma() {

    $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    switch ($idioma) {
        case 'en': {
            return 'en';
            break;
        }
        default: {
            return 'es';
            break;
        }
    }
}

function verTiempo() {

    $inactivo = 7200;

    if (isset($_SESSION['tiempo'])) {
        $vida_session = time() - $_SESSION['tiempo'];
        if ($vida_session > $inactivo && $_SERVER['SERVER_NAME'] != 'desarrollo.sigefcloud.com') {
            $idioma = idioma();
            //include('../idiomas/' . $idioma . '.php');
            session_destroy();
            echo "<script>alert('Su sesion ha expirado');window.location.assign('../index.php');</script>";
        }
    }

    $_SESSION['tiempo'] = time();
}

function verTiempo2() {

    $inactivo = 7200;

    if (isset($_SESSION['tiempo'])) {
        $vida_session = time() - $_SESSION['tiempo'];
        if ($vida_session > $inactivo) {
            $idioma = idioma();
            include('../idiomas/' . $idioma . '.php');
            session_destroy();
            echo "<script>alert('Su sesion ha expirado');window.opener.location.reload();window.close();</script>";
        }
    }

    $_SESSION['tiempo'] = time();
}

function descubrePais($email) {

    require_once('coneccion.php');
    $pais = "";

    $squery = "SELECT p.nompais AS pais FROM direct p INNER JOIN cat_empresas e ON e.pais=p.codpais
	INNER JOIN acempresas a ON a.codempresa=e.codempresa 
	INNER JOIN sigef_usuarios u ON a.codusua=u.codusua
	WHERE u.email='" . $email . "' LIMIT 1";
    $ejecutar = mysqli_query(conexion(''), $squery);
    if ($ejecutar) {

        if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $pais = $row['pais'];
        }

    }
    return $pais;
}

function descubreProveedor($email) {

    require_once('coneccion.php');

    $pais = "";

    $squery = "SELECT nombre FROM cat_prov WHERE codprov='" . $email . "' LIMIT 1";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery);
    if ($ejecutar) {

        if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $pais = $row['nombre'];
        }

    }
    return $pais;
}

function verTiempo3() {

    $inactivo = 1800;

    if (isset($_SESSION['tiempo'])) {
        $vida_session = time() - $_SESSION['tiempo'];
        if ($vida_session > $inactivo) {
            $idioma = idioma();
            include('../idiomas/' . $idioma . '.php');
            session_destroy();
            echo "<script>alert('Su sesion ha expirado');location.reload();</script>";
        }
    }

    $_SESSION['tiempo'] = time();
}

function verTiempo4() {

    $inactivo = 1800;

    if (isset($_SESSION['tiempo'])) {
        $vida_session = time() - $_SESSION['tiempo'];
        if ($vida_session > $inactivo) {
            $idioma = idioma();
            include('../idiomas/' . $idioma . '.php');
            session_destroy();
            echo "<script>alert('Su sesion ha expirado');window.opener.window.opener.location.reload();window.opener.window.close();window.close();</script>";
        }
    }

    $_SESSION['tiempo'] = time();
}

function logout(){
    session_destroy();
}

function verTiempo5() {

    $inactivo = 1800;

    if (isset($_SESSION['tiempo'])) {
        $vida_session = time() - $_SESSION['tiempo'];
        if ($vida_session > $inactivo) {
            $idioma = idioma();
            include('../idiomas/' . $idioma . '.php');
            session_destroy();
            echo "<script>alert('Su sesion ha expirado');window.opener.window.opener.window.opener.location.reload();window.opener.window.opener.window.close();window.opener.window.close();window.close();</script>";
        }
    }

    $_SESSION['tiempo'] = time();
}

function footer() {

    $res = "<span>©SIGEF " . anio() . "</span><br>
		";

    echo $res;
}

function nitificaciones($prov) {

    require_once('coneccion.php');
    $fecht = date("Y") . "-" . date("m") . "-" . date("d");
    $squery = "SELECT condicion,notifica,destino,fechaini,fechafin FROM cat_notificaciones WHERE estatus=1";
    $contador = 0;
    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $squery2 = "select estatus from cat_prov where codprov='$prov' and estatus like '%" . $row['condicion'] . "%'";

            if ($ejecutar2 = mysqli_query(conexion($_SESSION['pais']), $squery2)) {
                if ($ejecutar2->num_rows > 0) {
                    if ($row2 = mysqli_fetch_array($ejecutar2, MYSQLI_ASSOC)) {

                        if ($row['fechaini'] == 0 and $row['fechafin'] == 0) {
                            $_SESSION['notified1' . ($contador + 1)] = $row['notifica'];
                            $_SESSION['direccione1' . ($contador + 1)] = $row['destino'];
                            $contador++;
                        }
                        else if ($row['fechaini'] <= $fecht and $row['fechafin'] >= $fecht) {
                            $_SESSION['notified1' . ($contador + 1)] = $row['notifica'];
                            $_SESSION['direccione1' . ($contador + 1)] = $row['destino'];
                            $contador++;
                        }

                    }
                }
            }
            mysqli_close(conexion($_SESSION['pais']));
        }
        mysqli_close(conexion($_SESSION['pais']));
        return $contador;
    }

    /*$squery="select estatus from cat_prov where codprov='$prov'";
    $contador=0;
        if($ejecutar=mysqli_query(conexion($_SESSION['pais']),$squery))
        {
            if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
            {
                $largo=strlen($row['estatus']);
                for($i=0;$i<$largo;$i++)
                {
                    if($i==0)
                    {
                    $_SESSION['notified1'.($i+1)]=substr($row['estatus'],$i,$i+1);
                    }
                    else
                    {
                    $_SESSION['notified1'.($i+1)]=substr($row['estatus'],$i,$i);
                    }
                }
                return $largo;
            }
        }*/
}

function ayuda($dir, $si, $logos) {

    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if (strpos($url, 'paginaNuevoProducto') === false
    ) {
        $codProv = $_SESSION["codprov"];
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $balancesQuery = "
        SELECT 
            SALDO
        FROM
            tra_balances
        WHERE
            CODPROV = '$codProv'
        ORDER BY CODIGOBAL DESC
        LIMIT 2;
    ";
        $balancesResult = mysqli_query(conexion($_SESSION["pais"]), $balancesQuery);
        $balancesRow = mysqli_fetch_array($balancesResult);
        $label2 = $balancesRow[0];
        $balancesRow = mysqli_fetch_array($balancesResult);
        $label1 = $balancesRow[0];
        $var1 = "<div onclick='balanceLast()'>Ultimo balance: <a href='#'>$$label1</a></div>";
        $var2 = "<div onclick='balanceCurrent()'>Balance actual: <a href='#'>$$label2</a></div>";
        $lol = $si;

        $balancesDiv = "";

        if ($_SESSION["codprov"] != "") {
            $balancesDiv = "<div id='balances'><div id='balancesContent'>$var1 $var2</div></div>";
        }
    }

    echo "
        <img class=\"logopagina\" src=\"" . $logos . "\" />
        <img src=\"" . $dir . "\" onClick=\"" . $lol . "\" width=\"100%\" height=\"110\"/>
	    $balancesDiv
	    <a id=\"help\" href=\"" . direccion('es') . "\" target=\"_blank\">Contacto</a>
	    <a id=\"help\" href=\"" . direccion('ex') . "\" target=\"_blank\">Help</a>
	    
	    <script>
            $(\"#balCurrent\").click(function () {
                console.log($(\"#balCurrent\"));
            });
	    </script>
	    ";

//    echo 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];  //http://sigefcloud.com/wiki/
//    echo getcwd(); ///home/quintoso/public_html/sigefcloud.com/wiki
}

function direccion($es) {

    switch ($es) {
        case 'ex': {
            return "http://sigefcloud.com/wiki/";
            break;
        }
        case 'es': {
            if(isset($_SESSION["nomEmpresa"])){
                return "PagContacto.php";
            }else{
                $tPath = "/php/PagContacto.php";
                return  $tPath;
            }

            break;
        }
        default: {
            return "http://localhost/SIGEF/wiki/es/index.php";
            break;
        }
    }
}

function crypt_blowfish_bydinvaders($password, $digito = 7) {

    $set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $salt = sprintf('$2a$%02d$', $digito);
    for ($i = 0; $i < 22; $i++) {
        $salt .= $set_salt[mt_rand(0, 22)];
    }
    return crypt($password, $salt);
}

function moneda() {

    require 'lib/nusoap.php';

    $client = new nusoap_client('http://www.banguat.gob.gt/variables/ws/TipoCambio.asmx?WSDL', true);

    $error = $client->getError();

    if ($error) {
        echo $error;
    }
    else {
        $result = $client->call('TipoCambioDia');
        $res = "<div class=\"moneda\">
    Tipo de Cambio <br>
	Dolar($)= 1<br>
	Quetzal(Q)=" . $result['TipoCambioDiaResult']['CambioDolar']['VarDolar']['referencia'] . "<br>
	Fecha: " . $result['TipoCambioDiaResult']['CambioDolar']['VarDolar']['fecha'] . "
    </div>";
    }

    return $res;
}

function paises() {

    require_once('coneccion.php');
    $sql = "SELECT codpais,nompais FROM direct ORDER BY nompais";
    $ejecutar = mysqli_query(conexion(""), $sql);
    $res = "";
    if ($ejecutar) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codpais'] . "\">" . utf8_encode($row['nompais']) . "</option>";
        }
    }
    return $res;
}

function limpiar_caracteres_especiales($s) {

    $s = str_replace("@amp;", "&", $s);
    $s = str_replace("@amp", "&", $s);
    $s = str_replace("&", "_", $s);
    $s = str_replace(" ", "_", $s);
    $s = str_replace("%", "", $s);

    //para ampliar los caracteres a reemplazar agregar lineas de este tipo:
    //$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
    return ($s);
}

function limpiar_caracteres_sql($s) {

    $s = str_replace("@amp;", "&", $s);
    $s = str_replace("@amp", "&", $s);
    $s = str_replace("â‚¬","€", $s);
    $s = str_replace("â€š","‚", $s);
    $s = str_replace("â€ž","„", $s);
    $s = str_replace("â€¦","…", $s);
    $s = str_replace("Ë†" ,"ˆ", $s);
    $s = str_replace("â€¹","‹", $s);
    $s = str_replace("â€˜","‘", $s);
    $s = str_replace("â€™","’", $s);
    $s = str_replace("â€œ","“", $s);
    $s = str_replace("â€" ,"”", $s);
    $s = str_replace("â€¢","•", $s);
    $s = str_replace("â€“","–", $s);
    $s = str_replace("â€”","—", $s);
    $s = str_replace("Ëœ" ,"˜", $s);
    $s = str_replace("â„¢","™", $s);
    $s = str_replace("â€º","›", $s);
    $s = str_replace("Å“" ,"œ", $s);
    $s = str_replace("Å’" ,"Œ", $s);
    $s = str_replace("Å¾" ,"ž", $s);
    $s = str_replace("Å¸" ,"Ÿ", $s);
    $s = str_replace("Å¡" ,"š", $s);
    $s = str_replace("Å½" ,"Ž", $s);
    $s = str_replace("Â¡" ,"¡", $s);
    $s = str_replace("Â¢" ,"¢", $s);
    $s = str_replace("Â£" ,"£", $s);
    $s = str_replace("Â¤" ,"¤", $s);
    $s = str_replace("Â¥" ,"¥", $s);
    $s = str_replace("Â¦" ,"¦", $s);
    $s = str_replace("Â§" ,"§", $s);
    $s = str_replace("Â¨" ,"¨", $s);
    $s = str_replace("Â©" ,"©", $s);
    $s = str_replace("Âª" ,"ª", $s);
    $s = str_replace("Â«" ,"«", $s);
    $s = str_replace("Â¬" ,"¬", $s);
    $s = str_replace("Â®" ,"®", $s);
    $s = str_replace("Â¯" ,"¯", $s);
    $s = str_replace("Â°" ,"°", $s);
    $s = str_replace("Â±" ,"±", $s);
    $s = str_replace("Â²" ,"²", $s);
    $s = str_replace("Â³" ,"³", $s);
    $s = str_replace("Â´" ,"´", $s);
    $s = str_replace("Âµ" ,"µ", $s);
    $s = str_replace("Â¶" ,"¶", $s);
    $s = str_replace("Â·" ,"·", $s);
    $s = str_replace("Â¸" ,"¸", $s);
    $s = str_replace("Â¹" ,"¹", $s);
    $s = str_replace("Âº" ,"º", $s);
    $s = str_replace("Â»" ,"»", $s);
    $s = str_replace("Â¼" ,"¼", $s);
    $s = str_replace("Â½" ,"½", $s);
    $s = str_replace("Â¾" ,"¾", $s);
    $s = str_replace("Â¿" ,"¿", $s);
    $s = str_replace("Ã€" ,"À", $s);
    $s = str_replace("Ã‚" ,"Â", $s);
    $s = str_replace("Ãƒ" ,"Ã", $s);
    $s = str_replace("Ã„" ,"Ä", $s);
    $s = str_replace("Ã…" ,"Å", $s);
    $s = str_replace("Ã†" ,"Æ", $s);
    $s = str_replace("Ã‡" ,"Ç", $s);
    $s = str_replace("Ãˆ" ,"È", $s);
    $s = str_replace("Ã‰" ,"É", $s);
    $s = str_replace("ÃŠ" ,"Ê", $s);
    $s = str_replace("Ã‹" ,"Ë", $s);
    $s = str_replace("ÃŒ" ,"Ì", $s);
    $s = str_replace("ÃŽ" ,"Î", $s);
    $s = str_replace("Ã‘" ,"Ñ", $s);
    $s = str_replace("Ã’" ,"Ò", $s);
    $s = str_replace("Ã“" ,"Ó", $s);
    $s = str_replace("Ã”" ,"Ô", $s);
    $s = str_replace("Ã•" ,"Õ", $s);
    $s = str_replace("Ã–" ,"Ö", $s);
    $s = str_replace("Ã—" ,"×", $s);
    $s = str_replace("Ã˜" ,"Ø", $s);
    $s = str_replace("Ã™" ,"Ù", $s);
    $s = str_replace("Ãš" ,"Ú", $s);
    $s = str_replace("Ã›" ,"Û", $s);
    $s = str_replace("Ãœ" ,"Ü", $s);
    $s = str_replace("Ãž" ,"Þ", $s);
    $s = str_replace("ÃŸ" ,"ß", $s);
    $s = str_replace("Ã¡" ,"á", $s);
    $s = str_replace("Ã¢" ,"â", $s);
    $s = str_replace("Ã£" ,"ã", $s);
    $s = str_replace("Ã¤" ,"ä", $s);
    $s = str_replace("Ã¥" ,"å", $s);
    $s = str_replace("Ã¦" ,"æ", $s);
    $s = str_replace("Ã§" ,"ç", $s);
    $s = str_replace("Ã¨" ,"è", $s);
    $s = str_replace("Ã©" ,"é", $s);
    $s = str_replace("Ãª" ,"ê", $s);
    $s = str_replace("Ã«" ,"ë", $s);
    $s = str_replace("Ã¬" ,"ì", $s);
    $s = str_replace("Ã­"  ,"í", $s);
    $s = str_replace("Ã®" ,"î", $s);
    $s = str_replace("Ã¯" ,"ï", $s);
    $s = str_replace("Ã°" ,"ð", $s);
    $s = str_replace("Ã±" ,"ñ", $s);
    $s = str_replace("Ã²" ,"ò", $s);
    $s = str_replace("Ã³" ,"ó", $s);
    $s = str_replace("Ã´" ,"ô", $s);
    $s = str_replace("Ãµ" ,"õ", $s);
    $s = str_replace("Ã¶" ,"ö", $s);
    $s = str_replace("Ã·" ,"÷", $s);
    $s = str_replace("Ã¸" ,"ø", $s);
    $s = str_replace("Ã¹" ,"ù", $s);
    $s = str_replace("Ãº" ,"ú", $s);
    $s = str_replace("Ã»" ,"û", $s);
    $s = str_replace("Ã¼" ,"ü", $s);
    $s = str_replace("Ã½" ,"ý", $s);
    $s = str_replace("Ã¾" ,"þ", $s);
    $s = str_replace("Ã¿" ,"ÿ", $s);
    //$s = str_replace(" ","_",$s);

    //para ampliar los caracteres a reemplazar agregar lineas de este tipo:
    //$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
    return ($s);
}

function calcularPPP($imagen) {

    $archivo = fopen($imagen, 'r');
    $cadena = fread($archivo, 50);
    fclose($archivo);
    $datos = bin2hex(substr($cadena, 14, 4));
    $ppp = substr($datos, 0, 4);
    return hexdec($ppp);
}

function noCache() {

    header("Expires: SAT, 21 May 2016 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

function toMoney($val, $symbol = '$', $r = 2) {

    $n = $val;
    $c = is_float($n) ? 1 : number_format($n, $r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n = number_format(abs($n), $r);
    $j = (($j = strlen($i) - 1) > 3) ? $j % 3 : 0;

    return $symbol . $sign . ($j ? substr($i, 0, $j) + $t : '') . preg_replace('/(\d{3})(?=\d)/', "$1" + $t, substr($i, $j));

}

function buscaNomEstado($estado, $puntos) {

    require_once($puntos . 'coneccion.php');
    require_once($puntos . 'fecha.php');
    $idioma = idioma();
    include($puntos . 'idiomas/' . $idioma . '.php');
    $pais = "";
    $squery = "SELECT nombre FROM cat_estados WHERE codigo='" . $estado . "'";
    $retornar = "";
    $total = 0;
    $retornar = $retornar . "<tbody>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        if ($ejecutar->num_rows > 0) {
            $contador = 0;
            if ($row = mysqli_fetch_array($ejecutar, MYSQLI_NUM)) {
                return $row['0'];
            }
        }
    }
    mysqli_close(conexion($pais));
}

function microtime_float() {

    list($useg, $seg) = explode(" ", microtime());
    return ((float)$useg + (float)$seg);
}