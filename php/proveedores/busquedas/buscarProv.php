<?php
function buscarRegistro($cod)
{
    $squer = "select nombre,direccion,telefono,fax,nomcontacto,apelcontacto,mailcontac,puestocont,website,estado,codempresa,telcontacto,codeco,ciudad,trademark,codpos from cat_prov where codprov='" . $cod . "'";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squer);
    if ($ejecutar) {
        if ($ejecutar->num_rows > 0) {
            $contador = 0;
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                echo "
                    <script>
                        document.getElementById('pais').value= '" . $_SESSION['codpais'] . "' ;
                        llenarCombo('Empresas',document.getElementById('pais'));
                        document.getElementById('nombre').value='" . $row['nombre'] . "';
                        document.getElementById('direccion').value='" . $row['direccion'] . "';
                        document.getElementById('telefono').value='" . $row['telefono'] . "';
                        document.getElementById('telefono2').value='" . $row['telcontacto'] . "';
                        document.getElementById('fax').value='" . $row['fax'] . "';
                        document.getElementById('web').value='" . $row['website'] . "';
                        document.getElementById('contactoNombre').value='" . $row['nomcontacto'] . "';
                        document.getElementById('contactoApellido').value='" . $row['apelcontacto'] . "';
                        document.getElementById('emailContacto').value='" . $row['mailcontac'] . "';
                        document.getElementById('estado').value='" . $row['estado'] . "';
                        document.getElementById('codpostal').value='" . $row['codpos'] . "';
                        document.getElementById('cargo').value='" . $row['puestocont'] . "';";
                if ($row['trademark'] == 1) {
                    echo "document.getElementById('terminos').checked=true;";
                } else {
                    echo "document.getElementById('terminos').checked=false;";
                }
                echo "setTimeout(function(){document.getElementById('paisprov').value='" . $row['codeco'] . "';},500);
                        document.getElementById('ciudadprov').value='" . $row['ciudad'] . "';
                    </script>
                ";
            }
        } else {
        }
    } else {
    }
}

function buscarFacturacion($cod)
{
    $squer = "select p.trademark as trademark,p.nombre as empresa,p.nit as nit,p.ncomercial as ncomercial,cc.nombre as nombre,cc.apellido as apellido,cc.telefono as telefono,cc.email as email,cc.puesto as puesto,cc.codpos as codpos,cc.ciudad as ciudad,cc.pais as paisprov,cc.direccion as direccion,cc.form as form from tra_prov_cont cp inner join cat_cont cc on cp.codcont=cc.codcont inner join cat_prov p on cp.codigo=p.codprov where p.codprov='" . $cod . "'";
    echo "
        <script>
            document.getElementById('pais').value= '" . $_SESSION['codpais'] . "' ;
            llenarCombo('Empresas',document.getElementById('pais'));</script>";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squer);
    if ($ejecutar) {
        if ($ejecutar->num_rows > 0) {
            $contador = 0;
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                echo "
                    <script>
                        document.getElementById('nombre').value='" . $row['empresa'] . "';
                        document.getElementById('nit').value='" . $row['nit'] . "';
                        document.getElementById('ncomercial').value='" . $row['ncomercial'] . "';";
                if ($row['form'] == "F") {
                    echo "
                        document.getElementById('telefono2').value='" . $row['telefono'] . "';
                        document.getElementById('contactoNombre').value='" . $row['nombre'] . "';
                        document.getElementById('contactoApellido').value='" . $row['apellido'] . "';
                        document.getElementById('emailContacto').value='" . $row['email'] . "';
                        document.getElementById('cargo').value='" . $row['puesto'] . "';
                        document.getElementById('codpostal').value='" . $row['codpos'] . "';
                        document.getElementById('direccion').value='" . $row['direccion'] . "';
                        setTimeout(function(){document.getElementById('paisprov').value='" . $row['paisprov'] . "';},500);
                        document.getElementById('ciudadprov').value='" . $row['ciudad'] . "';";
                }
                echo "			
                    </script>
                ";
            }
        }
    } else {
        echo $squer;
    }
}

function buscarPagos($cod)
{
    $squer = "select p.trademark as trademark,p.nombre as empresa,p.ctadepo as ctadepo,p.fpago as fpago,p.codbanco as codbanco,p.echeque as echeque,cc.nombre as nombre,cc.apellido as apellido,cc.telefono as telefono,cc.email as email,cc.puesto as puesto,cc.codpos as codpos,cc.ciudad as ciudad,cc.pais as paisprov,cc.form as form, p.SWIFTNUM, p.ROUNUM, p.paypal1er from tra_prov_cont cp inner join cat_cont cc on cp.codcont=cc.codcont inner join cat_prov p on cp.codigo=p.codprov where p.codprov='" . $cod . "'";
    echo "
        <script>
            document.getElementById('pais').value= '" . $_SESSION['codpais'] . "' ;
            llenarCombo('Empresas',document.getElementById('pais'));</script>";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squer);
    if ($ejecutar) {
        if ($ejecutar->num_rows > 0) {
            $contador = 0;
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                echo "
                    <script>
                        document.getElementById('nombre').value='" . $row['empresa'] . "';
                        document.getElementById('echeque').value='" . $row['echeque'] . "';
                        document.getElementById('banco').value='" . $row['codbanco'] . "';
                        document.getElementById('cuenta').value='" . $row['ctadepo'] . "';
                        document.getElementById('fPago').value='" . $row['fpago'] . "';
                        if(document.getElementById('fPago').value=='1')
                        {
                            document.getElementById('chequeLabel').hidden =false;
                            document.getElementById('cuentaLabel').hidden =true;
                        }
                        else
                        {
                            document.getElementById('chequeLabel').hidden =true;
                            document.getElementById('cuentaLabel').hidden =false;
										}";
                if ($row['form'] == "P") {
                    echo "
                        document.getElementById('telefono2').value='" . $row['telefono'] . "';
                        document.getElementById('contactoNombre').value='" . $row['nombre'] . "';
                        document.getElementById('contactoApellido').value='" . $row['apellido'] . "';
                        document.getElementById('emailContacto').value='" . $row['email'] . "';
                        document.getElementById('cargo').value='" . $row['puesto'] . "';
                        document.getElementById('swiftnum').value='" . $row['SWIFTNUM'] . "';
                        document.getElementById('rounum').value='" . $row['ROUNUM'] . "';
                        ";

                    if($row['paypal1er'] == 1){
                        echo "
                            $('#paypal1er').prop('checked', true);
                        ";
                    }else{
                        echo "
                            $('#paypal1er').prop('checked', false);
                        ";
                    }
                }
                echo "			
                    </script>
                ";
            }
        } else {
        }
    } else {
    }
}

function buscarCobros($cod)
{
    $squer = "select p.trademark as trademark,p.nombre as empresa,p.tipotar as tipotar,p.ntar as ntar,p.titulartar as titulartar,p.mesvtar as mesvtar,p.anvtar as anvtar,cc.nombre as nombre,cc.apellido as apellido,cc.telefono as telefono,cc.email as email,cc.puesto as puesto,cc.codpos as codpos,cc.ciudad as ciudad,cc.pais as paisprov,cc.form as form from tra_prov_cont cp inner join cat_cont cc on cp.codcont=cc.codcont inner join cat_prov p on cp.codigo=p.codprov where p.codprov='" . $cod . "'";
    echo "
        <script>
            document.getElementById('pais').value= '" . $_SESSION['codpais'] . "' ;
            llenarCombo('Empresas',document.getElementById('pais'));</script>";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squer);
    if ($ejecutar) {
        if ($ejecutar->num_rows > 0) {
            $contador = 0;
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                echo "
                    <script>
                        document.getElementById('nombre').value='" . $row['empresa'] . "';
                        document.getElementById('tipoTar').value='" . $row['tipotar'] . "';
                        document.getElementById('nTar').value='" . $row['ntar'] . "';
                        document.getElementById('TitTar').value='" . $row['titulartar'] . "';
                        document.getElementById('MesV').value='" . $row['mesvtar'] . "';
                        document.getElementById('AnioV').value='" . $row['anvtar'] . "';";
                if ($row['form'] == "C") {
                    echo "
                        document.getElementById('telefono2').value='" . $row['telefono'] . "';
                        document.getElementById('contactoNombre').value='" . $row['nombre'] . "';
                        document.getElementById('contactoApellido').value='" . $row['apellido'] . "';
                        document.getElementById('emailContacto').value='" . $row['email'] . "';
                        document.getElementById('cargo').value='" . $row['puesto'] . "';
                        ";
                }
                echo "			
                    </script>
                ";
            }
        } else {
        }
    } else {
    }
}

function buscarComercializa($cod)
{
    $squer = "select p.trademark as trademark,p.marmin,p.marpro,p.marmax,p.marmincom as marmincom1,p.nombre as empresa,p.codex,p.incre1,p.incre2,p.incre3,p.incre4 from cat_prov p where p.codprov='" . $cod . "'";
    echo "
									<script>
										document.getElementById('pais').value= '" . $_SESSION['codpais'] . "' ;
										llenarCombo('Empresas',document.getElementById('pais'));</script>";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squer);
    if ($ejecutar) {
        if ($ejecutar->num_rows > 0) {
            $contador = 0;
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                echo "
									<script>
										document.getElementById('nombre').value='" . $row['empresa'] . "';
										document.getElementById('codExport').value='" . $row['codex'] . "';/*
										document.getElementById('marmin').value='" . $row['marmin'] . "';
										document.getElementById('marpro').value='" . $row['marpro'] . "';
										document.getElementById('marmax').value='" . $row['marmax'] . "';
										document.getElementById('marmincon').value='" . $row['marmincom1'] . "';
										";
                if ($row['incre1'] != '0' and $row['incre1'] != NULL) {
                    echo "document.getElementById('incre1').value='" . $row['incre1'] . "';";
                }
                if ($row['incre2'] != '0' and $row['incre2'] != NULL) {
                    echo "document.getElementById('incre2').value='" . $row['incre2'] . "';";
                }
                if ($row['incre3'] != '0' and $row['incre3'] != NULL) {
                    echo "document.getElementById('incre3').value='" . $row['incre3'] . "';";
                }
                if ($row['incre4'] != '0' and $row['incre4'] != NULL) {
                    echo "document.getElementById('incre4').value='" . $row['incre4'] . "';";
                }
                echo "			
									*/</script>
							";
            }
        } else {
        }
    } else {
    }
}
