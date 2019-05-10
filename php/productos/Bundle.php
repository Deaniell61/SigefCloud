<?php
session_start();
?>
<script>
    function openEditBundle(sender) {
        $("#editBundleForm").dialog({
            width: 900,
            height: 500,
            modal: true
        });
        var row = $("#tablas TR").eq(sender.id);
        var currentPrice = row.find('td').eq(7).html();
        var currentPriceMin = row.find('td').eq(13).html();
        var currentPriceMax = row.find('td').eq(14).html();
        currentPrice = currentPrice.replace(/[^\d.-]/g, '');
        currentPriceMin = currentPriceMin.replace(/[^\d.-]/g, '');
        currentPriceMax = currentPriceMax.replace(/[^\d.-]/g, '');
        var currentUtilities = row.find('td').eq(5).html();
        var currentUnitPrice = row.find('td').eq(8).html();
        var amazonSKU = row.find('td').eq(0).html();
        var prodName = row.find('td').eq(1).html();

        $("#cospriMin").val("");
        $("#channelFeeMin").val("");
        $("#shipping").val("");
        $("#shippingMin").val("");
        $("#netrevosspMin").val("");
        $("#sugsalpricMin").val("");
        $("#BUNUNIPRIMin").val("");
        $("#cospriMax").val("");
        $("#channelFeeMax").val("");
        $("#shippingMax").val("");
        $("#netrevosspMax").val("");
        $("#sugsalpricMax").val("");
        $("#BUNUNIPRIMax").val("");

        $("#newBundlePrice").val(currentPrice);
        $("#newBundlePriceMin").val(currentPriceMin);
        $("#newBundlePriceMax").val(currentPriceMax);
        $("#amazonSKU").val(amazonSKU);

        $("#cospri").val(row.find('td').eq(3).html());
        $("#channelFee").val(row.find('td').eq(4).text());
        $("#netrevossp").val(row.find('td').eq(5).text());
        $("#shipping").val(row.find('td').eq(6).find('a').html());
        $("#sugsalpric").val(row.find('td').eq(7).html());
        $("#BUNUNIPRI").val(row.find('td').eq(8).html());
        $("#marovessp").val(row.find('td').eq(9).html());

        $("#calcMasterSKU").val(amazonSKU);
        $("#calcProdName").val(prodName);
    }
    function saveBundleEdit(tempPrice) {
        ventana('cargaLoadGeneral', 300, 400);
        var newPrice = $("#newBundlePrice").val();
        var newPriceMin = $("#newBundlePriceMin").val();
        var newPriceMax = $("#newBundlePriceMax").val();
        var amazonSKU = $("#amazonSKU").val();
        var codCanal = $("#canal").val();
        // console.log(newPriceMin);
        // console.log(newPriceMax);
        // console.log(amazonSKU);
        if (tempPrice !== undefined) {
            newPrice = tempPrice;
        }
        var tData = 'method=updateBundlePrice&amazonSKU=' + amazonSKU + '&codCanal=' + codCanal + '&newPrice=' + newPrice;
        $.ajax({
            url: 'bundleOperations.php',
            type: 'POST',
            data: tData,
            success: function (resp) {

//                console.log('SU>' + resp);

                setTimeout(function () {
                    $("#cargaLoadGeneral").dialog("close");
                    $("#cargaLoadGeneral").remove();

                    $("#editBundleForm").dialog('close');
                    $("#editBundleForm").remove();

                }, 1000);

                setTimeout(function () {
                    actualizarPreciosBundlesN($("#masterSKU").val(), '<?=$_SESSION['codEmpresa']?>');
                }, 1250);

                $('#bundle').html('refrescando...');

            },
            error: function (resp) {
                console.log('ER>' + JSON.stringify(resp));

                setTimeout(function () {
                    $("#cargaLoadGeneral").dialog("close");
                    $("#cargaLoadGeneral").remove();

                    $("#editBundleForm").dialog('close');
                    $("#editBundleForm").remove();

                }, 1000);
            }
        });
        $.ajax({
            url:"bundleOperations.php",
            type:"POST",
            data:{
                method:"updateMinPP",
                id:amazonSKU,
                channel:codCanal,
                price:newPriceMin,
            },
            success:function (response) {
                // console.log(response);
            }
        });
        $.ajax({
            url:"bundleOperations.php",
            type:"POST",
            data:{
                method:"updateMaxPP",
                id:amazonSKU,
                channel:codCanal,
                price:newPriceMax,
            },
            success:function (response) {
                // console.log(response);
            }
        });
    }

    function calcBundle() {

        ventana('cargaLoadGeneral', 300, 400);
        actualizarPreciosBundlesC($("#masterSKU").val(), $("#amazonSKU").val(), $("#newBundlePrice").val());
        actualizarPreciosBundlesCMin($("#masterSKU").val(), $("#amazonSKU").val(), $("#newBundlePriceMin").val());
        actualizarPreciosBundlesCMax($("#masterSKU").val(), $("#amazonSKU").val(), $("#newBundlePriceMax").val());
    }

    function closeEditForm() {
        console.log("IDS:" + $('[editBundleForm]').length);
        $("#editBundleForm").dialog('close');
        // $("#editBundleForm").remove();
    }


    function resetBundle() {
        saveBundleEdit('0');
    }

    function batchReset(amazonSKU) {
        //ventana('cargaLoadGeneral', 300, 400);
        var newPrice = '0';
        var amazonSKU = amazonSKU;
        var codCanal = $("#canal").val();

        var tData = 'method=updateBundlePrice&amazonSKU=' + amazonSKU + '&codCanal=' + codCanal + '&newPrice=' + newPrice;
        $.ajax({
            url: 'bundleOperations.php',
            type: 'POST',
            data: tData,
            success: function (resp) {
                // console.log(resp);
            },
            error: function (resp) {
                console.log('ER>' + JSON.stringify(resp));
            }
        });
    }

    function updatePublish(tSKU, tValue) {

    }
</script>
<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('../formulas.php');
require_once('combosProductos.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
$itemCode = limpiar_caracteres_sql($_POST['codprod']);
$masterSKU = limpiar_caracteres_sql($_POST['masterSKU']);
$prodName = limpiar_caracteres_sql($_POST['prodName']);
$unidadesCaja = limpiar_caracteres_sql($_POST['unidadesCaja']);
$unidadesPaquete = intval(limpiar_caracteres_sql($_POST['unidadesPaquete']));
$uBundle = limpiar_caracteres_sql($_POST['uBundle']);
if ($_POST['canal'] != 'undefined') {
    $CanalDes = limpiar_caracteres_sql($_POST['canal']);
}
else {
    $CanalDes = '_4Q90XMVNL';
}

$codigoProveedor = limpiar_caracteres_sql($_POST['codprov']);

session_start();
$codigoEmpresa = $_SESSION['codEmpresa'];
$codEmp = $codigoEmpresa;

$squery = "SELECT masterSKU,
codempresa,prodName,amazondesc,unitcase,codbundle,amazonSKU,sugsalpric,unitbundle, shipping, basmar, netrevossp, cospri, MAROVEITEC, BUNUNIPRI, marovessp,(FBAORDHANF + FBAPICPACF + FBAWEIHANF + FBAINBSHI + PACMAT + FBAREFOSSP) AS channelFee, MAROVEITEC, publicar, UPC, MINPRI, MAXPRI, MINPRIP, MAXPRIP FROM tra_bun_det WHERE codempresa='" . $codigoEmpresa . "' AND mastersku='" . $masterSKU . "' AND codcanal='" . $CanalDes . "' ORDER BY unitbundle ";
//echo $squery;
if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
    if (mysqli_num_rows($ejecutar) > 0) {
        if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            ?>
            <div id="datos">
                <?php
                if ($row['amazonSKU'] != '') {
                    ?>
                    <script>document.getElementById('ubundle').disabled = true; </script>
                <?php } ?>
                <?php
                echo encabezado() . tabla($squery, $prodName, $masterSKU, $unidadesPaquete, $uBundle);
                ?>
            </div>
            <?php
        }
    }
    else {
        $contars = 1;
        $amSKU = "";
        $amazonQuery = "SELECT amazonsku FROM tra_bun_det ORDER BY amazonsku DESC LIMIT 1";
        if ($ejecutaAmazon = mysqli_query(conexion($_SESSION['pais']), $amazonQuery)) {
            if (mysqli_num_rows($ejecutaAmazon) > 0) {
                if ($row = mysqli_fetch_array($ejecutaAmazon, MYSQLI_ASSOC)) {
                    $amSKU = $row['amazonsku'];
                    if (strlen($amSKU) == 6) {
                        $amSKU = $_SESSION['CodSKUPais'] . intval($amSKU);
                    }
                    $amSKU = intval($amSKU) + 1;
                }
            }
            else {
                $amSKU = $_SESSION['CodSKUPais'] . "500001";
                $amSKU = intval($amSKU);
            }
        }
        $contadors = 0;

        #agregarParametrosBundle($row['codbundle'],$row['unitbundle'],$row['masterSKU'])
################################################33inicio
        $chanelQuery = "SELECT codchan FROM cat_sal_cha WHERE columna!='' AND channel = 'sales on line'";
        if ($ejecutaChanel = mysqli_query(conexion($_SESSION['pais']), $chanelQuery)) {
            if (mysqli_num_rows($ejecutaChanel) > 0) {
                while ($rowChanel = mysqli_fetch_array($ejecutaChanel, MYSQLI_ASSOC)) {
                    crearBundle($codigoEmpresa, $masterSKU, $prodName, $rowChanel['codchan'], 1, $amSKU, $unidadesCaja, $contars);
                }
                $contadors++;
            }
        }
        $contars++;
#####################################################fin
        $currentBundles = 1;
        $o = 1;
        for ($i = 1; $i <= $unidadesPaquete; $i++) {
            $amSKU++;
            $o = $uBundle * $i;
            $currentBundles[] = $o;
#######################################################3inicio
            $chanelQuery = "SELECT codchan FROM cat_sal_cha WHERE columna!='' AND channel = 'sales on line'";
            if ($ejecutaChanel = mysqli_query(conexion($_SESSION['pais']), $chanelQuery)) {
                if (mysqli_num_rows($ejecutaChanel) > 0) {
                    while ($rowChanel = mysqli_fetch_array($ejecutaChanel, MYSQLI_ASSOC)) {
                        if ($o != '1') {

                            crearBundle($codigoEmpresa, $masterSKU, $prodName, $rowChanel['codchan'], $o, $amSKU, $unidadesCaja, $contars);
                        }
                    }
                    $contadors++;
                }
            }
            $contars++;
###############################################################	fin
        }

        if (($o) != $unidadesCaja) {
            $amSKU++;
################################################inicio
            $chanelQuery = "SELECT codchan FROM cat_sal_cha WHERE columna!='' AND channel = 'sales on line'";
            if ($ejecutaChanel = mysqli_query(conexion($_SESSION['pais']), $chanelQuery)) {
                if (mysqli_num_rows($ejecutaChanel) > 0) {
                    while ($rowChanel = mysqli_fetch_array($ejecutaChanel, MYSQLI_ASSOC)) {
                        crearBundle($codigoEmpresa, $masterSKU, $prodName, $rowChanel['codchan'], $unidadesCaja, $amSKU, $unidadesCaja, $contars);
                    }
                    $contadors++;
                }
            }
            $contars++;
##################################################3fin
        }

        //COMPETENCIA
        $amSKU++;
        $getChannelsQuery = "SELECT codchan FROM cat_sal_cha WHERE columna != '' AND channel = 'sales on line'";
        if ($getChannels = mysqli_query(conexion($_SESSION['pais']), $getChannelsQuery)) {
            if (mysqli_num_rows($getChannels) > 0) {
                while ($channelRow = mysqli_fetch_array($getChannels, MYSQLI_ASSOC)) {
                    $tChanCod = $channelRow[0];
                    $getCompetitionQuery = "SELECT unidades, preciomax, shipping FROM tra_pre_com WHERE ((codempresa='$codigoEmpresa' AND codprod='$itemCode' AND CODCANAL <> (SELECT codchan FROM cat_sal_cha WHERE columna != '' and channel = 'sales on line')) OR (codempresa='$codigoEmpresa' and codprod='$itemCode' and codprov='' AND CODCANAL <> (SELECT codchan FROM cat_sal_cha WHERE columna != '' and channel = 'sales on line')))";
                    if ($getCompetiton = mysqli_query(conexion($_SESSION['pais']), $getCompetitionQuery)) {
                        if (mysqli_num_rows($getCompetiton) > 0) {
                            while ($row = mysqli_fetch_array($getCompetiton, MYSQLI_ASSOC)) {
                                $tUnits = $row['unidades'];
                                $tPrice = $row['preciomax'] + $row['shipping'];
                                if (!in_array($tUnits, $currentBundles)) {
                                    createCompetitionBundle($codigoEmpresa, $masterSKU, $prodName, $channelRow['codchan'], $tUnits, $amSKU, $tUnits, $tPrice);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    //echo $codigoEmpresa;
}

function tabla($squery, $prodName, $masterSKU, $unidadesPaquete, $uBundle) {

    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    $retornar = "";
    $contar = 1;
    $retornar = $retornar . "<tbody>";

    $ttCargos = 0;
    $ttUtilidades = 0;

    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            if ($contar == 1) {
                $retornar = $retornar . "<script>detalleBundle('" . $row['masterSKU'] . "','" . $row['prodName'] . "','" . $row['codbundle'] . "','" . $_SESSION['codEmpresa'] . "','" . $row['amazonSKU'] . "',document.getElementById('canal').value,'" . $_SESSION['codprov'] . "',1);document.getElementById('actualiza').disabled=false;</script>";
            }

            $isChecked = '';
            if ($row['publicar'] == 1) {
                $isChecked = 'checked';
            }
            $hasupc = "";
            if ($row["UPC"] == "") {
                $hasupc = "<td style='text-align:center !important;'>
                            <img id='$contar' style='text-align:center !important; width:21px !important; height:21px !important;' src='../../images/noUPC.png'></td>";
            }

            //onClick=\"detalleBundle('" . $row['masterSKU'] . "','" . $row['prodName'] . "','" . $row['codbundle'] . "','" . $_SESSION['codEmpresa'] . "','" . $row['amazonSKU'] . "',document.getElementById('canal').value,'" . $_SESSION['codprov'] . "',document.getElementById('lbundle" . $contar . "').value);\"

            $tMinPri = ($row["MINPRIP"] != 0.00000) ? $row["MINPRIP"] : $row["MINPRI"];
            $tMaxPri = ($row["MAXPRIP"] != 0.00000) ? $row["MAXPRIP"] : $row["MAXPRI"];

            $tCargo = number_format($row['channelFee'], 2, '.', '');
            $ttCargos += floatval($tCargo);

            $tUtilidad = number_format($row['netrevossp'], 2, '.', '');
            $ttUtilidades += floatval($tUtilidad);

            $tAmazonSKU = $row['amazonSKU'];

            $tShipping = number_format($row['shipping'], 2, '.', '');

            $retornar = $retornar . "
							<tr>
								<td style='text-align:center !important;'>" . $tAmazonSKU . "</td>
								<td style='text-align:center !important;'>" . $row['prodName'] . "</td>
								<td style='text-align:center !important;'>" . $row['unitbundle'] . "</td>
								<td style='text-align:center !important;'>$ " . number_format($row['cospri'], 2, '.', '') . "</td>
								<td id='cellCargo-$tAmazonSKU' style='text-align:center !important;'><a href='#' onclick='showPopupCargo(event, $tAmazonSKU)'>$ $tCargo</a></td>
								<td id='cellUtilidad-$tAmazonSKU'  style='text-align:center !important;'><a href='#' onclick='showPopupUtilidad(event, $tAmazonSKU)'>$ $tUtilidad</a></td>
								<td class='bodegaDeclara' style='text-align:center !important;'><a href='#' onmouseover='lastShippmentInfo($tAmazonSKU)' onmouseleave='cleanLastShippmentInfo()'>$ $tShipping</a></td>
								<td style='text-align:center !important;'>$ " . number_format($row['sugsalpric'], 2, '.', '') . "</td>
								<td style='text-align:center !important;'>$ " . number_format($row['BUNUNIPRI'], 2, '.', '') . "</td>
								<td style='text-align:center !important;'>% " . number_format($row['MAROVEITEC'], 2, '.', '') . "</td>
                                    <td style='text-align:center !important;'><img id='$contar' onclick='openEditBundle(this);' style='text-align:center !important; width:21px !important; height:21px !important;' src='../../images/editar.png'></td>
								<td style='text-align:center !important;'><input type=\"checkbox\" id = 'chkboxPublicar' class = 'chkboxPublicar' $isChecked onclick=\"document.getElementById('guardar2').disabled = false\"></td>
								<td style='text-align:center !important;'><input type=\"checkbox\" id = 'chkbox' onclick=\"document.getElementById('guardar2').disabled = false\"></td>
								$hasupc					
								<td hidden>$tMinPri</td>
								<td hidden>$tMaxPri</td>
							</tr>
							";
            $contar++;
        }

        $_SESSION["tBundleCargos"] = $ttCargos;
        $_SESSION["tBundleUtilidades"] = $ttUtilidades;
    }

    $retornar = $retornar . "</tbody></table></div>
					<script   type=\"text/javascript\">
           $(document).ready(function(){
   $('#tablas').DataTable( {
        \"scrollY\": \"300px\",
        \"scrollX\": true,
        \"paging\":  true,
        \"info\":     false,
        \"order\": [[ 2, \"asc\" ]],
        \"oLanguage\": {
      \"sLengthMenu\": \" _MENU_ \",      
    }
    
   
    } );
    
    $('.dataTables_scrollBody').on('scroll', function() {
        closePopup();
//        console.log(\"!\");
    });
    
  ejecutarpie();
});
           </script></center>";
    return $retornar;
}

#style=\"overflow: auto;height: 210px;\"

function encabezado() {

    require_once('../fecha.php');
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');
    return "<center>
	<link href=\"../../css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\">	
	<link href=\"../../css/datatables.min.css\" rel=\"stylesheet\" type=\"text/css\">
			<div >
        	<table id=\"tablas\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
				<thead>
				<tr  class=\"titulo\">
                	<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['amazonSKU'] . "</th>
					<th style=\"text-align: center !important;\" width=\"200px\">" . $lang[$idioma]['DescBundle'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['unitBundle'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['Cost'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['channelFees'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['utilities'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['shipp'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['sugsalpri'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['bununipri'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['marbase'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['EditarBundle'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['publicar'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['Reset'] . "</th>
					<th style=\"text-align: center !important;\" width=\"50px\">" . $lang[$idioma]['CODBAR'] . "</th>
					<th hidden=\"\">lBundle</th>		
                </tr> </thead>
            ";
}

?>
<div hidden id="editBundleForm" title="<?= $lang[$idioma]['editBundleTitle'] ?>">
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            Amazon SKU
        </div>
        <div class="twoThirdCell stackHorizontally">
            <input disabled
                   type="text"
                   id="calcMasterSKU"
                   class='entradaTextoBuscar fullInput'
                   placeholder="" value=""/>
        </div>
    </div>
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            Nombre del Producto
        </div>
        <div class="twoThirdCell stackHorizontally">
            <textarea disabled
                   id="calcProdName"
                      style="height: 45px;"
                   class='entradaTextoBuscar fullInput'
                   placeholder="" value=""/>
        </div>
    </div>
    <!--TITULOS-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally">
            &nbsp;
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="row">
                <div class="oneThirdCell stackHorizontally">
                    &nbsp;
                </div>
                <div class="oneThirdCell stackHorizontally bold alignCenter">
                    <?= $lang[$idioma]['minimo'] ?>
                </div>
                <div class="oneThirdCell stackHorizontally bold alignCenter">
                    <?= $lang[$idioma]['maximo'] ?>
                </div>
            </div>
        </div>
    </div>
    <!--NUEVO PRECIO-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['NewBundlePrice'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input type="text"
                       id="newBundlePrice"
                       class='entradaTextoBuscar fullInput'
                       placeholder="" value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input
                       type="text"
                       id="newBundlePriceMin"
                       class='entradaTextoBuscar fullInput'
                       placeholder="" value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input
                       type="text"
                       id="newBundlePriceMax"
                       class='entradaTextoBuscar fullInput'
                       placeholder="" value=""/>
            </div>
        </div>
    </div>
    <!--COSTO-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['Cost'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="cospri"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="cospriMin"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="cospriMax"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
        </div>
    </div>
    <!--CARGOS-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['channelFees'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="channelFee"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="channelFeeMin"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="channelFeeMax"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
        </div>
    </div>
    <!--ENVIO-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['shipp'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="shipping"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="shippingMin"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="shippingMax"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
        </div>
    </div>
    <!--UTILIDAD-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['utilities'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="netrevossp"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="netrevosspMin"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="netrevosspMax"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
        </div>
    </div>
    <!--PRECIO VENTA SUGERIDO-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['sugsalpri'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="sugsalpric"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="sugsalpricMin"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="sugsalpricMax"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
        </div>

    </div>
    <!--PRECIO UNITARIO-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['bununipri'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="BUNUNIPRI"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="BUNUNIPRIMin"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="BUNUNIPRIMax"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
        </div>
    </div>
    <!--UTILIDAD-->
    <div class="row">
        <div class="oneThirdCell stackHorizontally bold alignRight">
            <?= $lang[$idioma]['marbase'] ?>
        </div>
        <div class="twoThirdCell stackHorizontally">
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="marovessp"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="marovesspMin"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
            <div class="oneThirdCell stackHorizontally">
                <input disabled
                       type="text"
                       id="marovesspMax"
                       class='entradaTextoBuscar fullInput'
                       value=""/>
            </div>
        </div>
    </div>
    <div style="margin-top: 20px; display: flex; justify-content: center">
        <input style="float: left" type="button" class='cmd button button-highlight button-pill' onClick="calcBundle();"
               value="<?php echo $lang[$idioma]['Calcular']; ?>"/>
        <input style="float: left" type="button" class='cmd button button-highlight button-pill'
               onClick="resetBundle();" value="<?php echo $lang[$idioma]['Reset']; ?>"/>
    </div>
    <br>
    <div style="display: flex; justify-content: center">
        <input style="float: left" type="button" class='cmd button button-highlight button-pill'
               onClick="saveBundleEdit();" value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
        <input style="float: left" type="reset" class='cmd button button-highlight button-pill'
               onClick="closeEditForm()" value="<?php echo $lang[$idioma]['Cancelar']; ?>"/>
    </div>
    <div>
        <input hidden disabled type="text" id="amazonSKU" class='entradaTextoBuscar' value=""/>
        <input hidden disabled type="text" id="canal" class='entradaTextoBuscar' value="<?= $CanalDes ?>"/>
    </div>
</div>
<div id="cargaLoadGeneral"></div>
<style>
    .row {
        width: 100%;
    }
    .smallCell {
        width: 25%;
        padding: 0px 2px 0px 2px;
    }
    .mediumCell {
        width: 50%;
        padding: 0px 2px 0px 2px;
    }
    .largeCell {
        width: 75%;
        padding: 0px 2px 0px 2px;
    }
    .fullCell {
        width: 100%;
        padding: 0px 2px 0px 2px;
    }
    .oneThirdCell {
        width: 33%;
        padding: 0px 2px 0px 2px;
    }
    .twoThirdCell {
        width: 66%;
        padding: 0px 2px 0px 2px;
    }
    .smallInput {
        width: 25%;
    }
    .mediumInput {
        width: 50%;
    }
    .largeInput {
        width: 75%;
    }
    .fullInput {
        width: 100%;
    }
    .oneThirdInput {
        width: 33%;
    }
    .twoThirdInput {
        width: 66%;
    }
    .stackHorizontally {
        float: left;
    }
    .bold {
        font-weight: bold;
    }
    .alignRight {
        text-align: right;
    }
    .alignCenter {
        text-align: center;
    }

    .red{
        background-color: red;
    }

    .blue{
        background-color: blue;
    }

    .yellow{
        background-color: yellow;
    }

    .green{
        background-color: green;
    }

    .minicontainer{
        width: 100%;
        height: 100%;
        text-align: center;
    }

    .minirow{
        width: 95%;
        margin-left: 2.5%;
        max-height: 19px;
    }

    .minicell{
        width: 20%;
        float: left;
        border: solid 1px black;
    }
    .minicellL{
        width: 60%;
        float: left;
        border: solid 1px black;
        overflow: hidden;
        max-height: 19px;
    }

    .minititle{
        background-color: #0f74a8;
        color: black;
    }
</style>`