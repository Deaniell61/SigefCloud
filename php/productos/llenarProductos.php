<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('redimencion.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
session_start();
## usuario y clave pasados por el formulario
$sku = strtoupper($_POST['sku']);
$nombre = strtoupper($_POST['nombre']);
$marca = strtoupper($_POST['marca']);
$descripcion = strtoupper($_POST['desc']);
$codigoEmpresa = $_SESSION['codEmpresa'];
$prov = "";
$extra = "";
if ($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U') {
    $prov = " and cp.codprov='" . $_SESSION['codprov'] . "'";
}

if (isset($_POST['filtro'])) {
    switch ($_POST['filtro']) {
        case '1':
            {
                $extra = " and cp.imaurlbase='' ";
                break;

            }
        case '2':
            {
                $extra = " and cp.estatus='A' ";
                break;

            }
        case '3':
            {
                $extra = " and cp.estatus='B' ";
                break;

            }
        case '4':
            {
                $extra = " and cp.estatus='' ";
                break;

            }
        default:
            {
                $extra = "";
                break;

            }
    }

}

if ($nombre == NULL && $sku == NULL && $marca == NULL && $descripcion == NULL) {
    $squer = "SELECT cp.masterSKU,cp.codprod,cp.imaurlbase AS imagen,cp.itemCode,cp.prodName,cp.nombre,cp.nombri,(SELECT cm.nombre FROM cat_marcas cm WHERE cm.codmarca=cp.marca AND cm.codempresa='" . $_SESSION['codEmpresa'] . "') AS marca,(SELECT clp.prodline FROM cat_pro_lin clp WHERE clp.codprolin=cp.codProLin AND clp.codempresa='" . $_SESSION['codEmpresa'] . "') AS prolin,(SELECT ccp.nombre FROM cat_cat_pro ccp WHERE ccp.codcate=cp.categori AND ccp.codempresa='" . $_SESSION['codEmpresa'] . "') AS category, (SELECT tep.existencia FROM tra_exi_pro tep WHERE tep.codprod=cp.codprod ORDER BY tep.existencia DESC LIMIT 1) AS inventario FROM cat_prod cp WHERE cp.codempresa='" . $_SESSION['codEmpresa'] . "'" . $prov . "" . $extra . " ORDER BY mastersku";

} else {
    if ($nombre == NULL && !$sku == NULL && $marca == NULL && $descripcion == NULL) {
        $squer = "SELECT cp.masterSKU,cp.codprod,cp.imaurlbase AS imagen,cp.itemCode,cp.prodName,cp.nombre,cp.nombri,(SELECT cm.nombre FROM cat_marcas cm WHERE cm.codmarca=cp.marca AND cm.codempresa='" . $_SESSION['codEmpresa'] . "') AS marca,(SELECT clp.prodline FROM cat_pro_lin clp WHERE clp.codprolin=cp.codProLin AND clp.codempresa='" . $_SESSION['codEmpresa'] . "') AS prolin,(SELECT ccp.nombre FROM cat_cat_pro ccp WHERE ccp.codcate=cp.categori AND ccp.codempresa='" . $_SESSION['codEmpresa'] . "') AS category, (SELECT tep.existencia FROM tra_exi_pro tep WHERE tep.codprod=cp.codprod ORDER BY tep.existencia DESC LIMIT 1) AS inventario FROM cat_prod cp WHERE cp.codempresa='" . $_SESSION['codEmpresa'] . "'" . $prov . "" . $extra . " AND (cp.masterSKU LIKE '" . $sku . "%' OR (SELECT cm.nombre FROM cat_marcas cm WHERE cm.codmarca=cp.marca" . $prov . " AND cm.codempresa='" . $_SESSION['codEmpresa'] . "') LIKE '" . $sku . "%' OR cp.descSis LIKE '" . $sku . "%' OR cp.prodName LIKE '%" . $sku . "%') ORDER BY mastersku";
    }
}
//echo $squery;
## ejecución de la sentencia sql
$showEditTitle = "";
if ($_SESSION['rol'] == 'P') {
    $showEditTitle = "<th>" . $lang[$idioma]['copyProduct'] . "</th>";
}

echo "<center>
			<div>
        	<table id=\"tablas\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"hover tablas table\">
			
				<thead>
				<tr  class=\"titulo\">
                	<th width='3%' class=\"check\"><img src=\"../images/yes.jpg\" style=\"width:30px;height:30px;\"/></th>
					<th hidden=\"hidden\">" . $lang[$idioma]['Codigo'] . "</th>
					<th>" . $lang[$idioma]['MasterSKU'] . "</th>
					<th>" . $lang[$idioma]['Imagen'] . "</th>
					<th>" . $lang[$idioma]['ProdName'] . "</th>
                    <th>" . $lang[$idioma]['Marca'] . "</th>
                    <th>" . $lang[$idioma]['Category'] . "</th>
					<th>" . $lang[$idioma]['Inventario'] . "</th>"
    . $showEditTitle .
    "</tr> </thead>
                
            ";

$retornar = "";
$pref2 = "http://www.guatedirect.com/media/catalog/product";
$pref = "../imagenes/media/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . "";
$prefc = "../imagenes/media/cache/" . strtolower(limpiar_caracteres_especiales($_SESSION['nomEmpresa'])) . "";
$con = conexion($_SESSION['pais']);
$retornar = $retornar . "<tbody  style=\"overflow-y: scroll;height: 400px;\">
																	";
$bundle = "";
$ejecutar = $con->query($squer);
if ($ejecutar) {
    if ($ejecutar->num_rows > 0) {

        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            if (!file_exists("../" . $prefc . $row['imagen'])) {
                if (file_exists($pref2 . $row['imagen'])) {
                    if (!is_dir("../" . $prefc . substr($row['imagen'], 0, 1))) {
                        mkdir("../" . $prefc . substr($row['imagen'], 0, 1), 0777);
                    }
                    if (!is_dir("../" . $prefc . substr($row['imagen'], 0, 4))) {
                        mkdir("../" . $prefc . substr($row['imagen'], 0, 4), 0777);
                    }
                    redimencionImagen($pref2, "../" . $prefc, $row['imagen']);
                }
            }
            $contador++;

            $retornar = $retornar . "<tr style=\"height:30px;\" >
								<td><input type=\"checkbox\" id=\"" . strtoupper($_SESSION['codEmpresa']) . "\"  onClick=\"agregarAccesos(document.getElementById('" . strtoupper($_SESSION['codEmpresa']) . "').value)\"  value=\"" . strtoupper($_SESSION['codEmpresa']) . "\" /></td>
								<td hidden=\"hidden\">" . ($_SESSION['codEmpresa']) . "</td>
								<td onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\">" . ($row['masterSKU']) . "</td>";
            if ($row['imagen'] != "") {
                if (file_exists("../" . $prefc . $row['imagen'])) {
                    $retornar = $retornar . "<td width='15%' onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\"><center><div class=\"\"><img src=\"" . $prefc . $row['imagen'] . "\" class=\"imagenes\" width=\"100%\"/></div></center></td>";
                } else
                    if (file_exists("../" . $pref . $row['imagen'])) {
                        $retornar = $retornar . "<td width='15%' onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\"><center><div class=\"\"><img src=\"" . $pref . $row['imagen'] . "\" class=\"imagenes\" width=\"100%\"/></div></center></td>";
                    } else {
                        $retornar = $retornar . "<td width='15%' onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\"><center><div class=\"\"><img src=\"" . $pref2 . $row['imagen'] . "\" class=\"imagenes\" width=\"100%\"/></div></center></td>";
                    }
            } else {
                $retornar = $retornar . "<td width='15%' onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\"><center><div class=\"\"><img src=\"../images/silueta.jpg\" class=\"imagenes\" width=\"100%\"/></div></center></td>";
            }

            $showEditButton = "";
            if ($_SESSION['rol'] == 'P') {
                $showEditButton = "<td onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\"><image id='" . $row['masterSKU'] . "' class='copyProduct' style='width:21px; height:21px;' src='../../images/copiar.png'></td>";
            }

            $tName = limpiar_caracteres_sql($row['prodName']);
            $retornar = $retornar . "<td onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\">" . $tName . "</td>
								<td onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\">" . (($row['marca'])) . "</td>
								<td onClick=\"nuevoProducto('" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $row['masterSKU'] . "')\">" . ucwords(strtolower($row['category'])) . "</td>
                                <td onClick=\"abrirBodegasE('" . $row['codprod'] . "','" . $_SESSION['pais'] . "','" . $_SESSION['codprov'] . "')\">
                                    <div class=\"bodegaDeclara\">
                                        <a >" . intval(($row['inventario'])) . "
                                            
                                            <div class=\"globoFlotanteExistencia \">
                                                <div class=\"parrafoFlotanteExistencia\">
                                                    " . llenarBodegas($row['codprod']) . "
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </td>" .
                $showEditButton
                . "
							  </tr>";
        }
    } else {//en caso de no encontrarlo buscara si existe el bundle
        $query = "SELECT mastersku FROM tra_bun_det WHERE amazonsku='" . $sku . "' LIMIT 1";
        $ejecuta = $con->query($query);
        if ($ejecuta->num_rows > 0) {
            if ($fila = $ejecuta->fetch_row()) {
                $bundle = "2";
                $retornar .= "<script>setTimeout(function(){buscarProductosInicio('" . $fila[0] . "','','','','','" . $_SESSION['codEmpresa'] . "');},00);</script>";
            }
        } else {

            $retornar .= "<tr><td colspan=\"7\"><center><span style=\"font-size:25px;\">" . $lang[$idioma]['NoEncontrado'] . "</span></center></td></tr>";
        }
    }

} else {
    $retornar .= "<tr><td colspan=\"7\"><center><span style=\"font-size:25px;\">$squer<br> Error de llenado de tabla</span></center></td></tr>";
}
mysqli_close(conexion($_SESSION['pais']));
$retornar = $retornar . "</tbody></table></div></center><br>";

if ($bundle == "") {
    $retornar = $retornar . "<script>setTimeout(configuraTabla,100);</script>";
}
echo $retornar;

function encabezado()
{

}

function llenarBodegas($codigo)
{

    require_once('../coneccion.php');
    $sql = "select e.existencia,b.nombre from tra_exi_pro e inner join cat_bodegas b on e.codbodega=b.codbodega where e.codprod='$codigo'";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $sql);
    $res = "";
    if ($ejecutar) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "" . utf8_encode($row['nombre']) . ": " . intval(utf8_encode($row['existencia'])) . "<br>";
        }
    }
    return $res;
}

?>

<script>
    $(".copyProduct").click(function (e) {
        e.stopPropagation();
        nuevoProducto('<?=$_SESSION['codEmpresa']?>', '<?=$_SESSION['pais']?>', e.target.id, '1');
    })
</script>
