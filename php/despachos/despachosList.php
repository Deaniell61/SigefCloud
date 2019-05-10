<?php
require_once('../fecha.php');
$idioma = idioma();
echo file_exists('../php/idiomas/' . $idioma . '.php');
include('../idiomas/' . $idioma . '.php');
session_start();
include_once ('../coneccion.php');
include_once ('../bitacora/bitacora.php');
$bitacora = new bitacora();
require_once ('../updateData/updateData.php');
$updateData = new updateData();
$updateData->check($updateData::PROVEEDORES, $_SESSION['codprov']);
$updateData->check($updateData::CATEGORIAS, 'LOCALES');
$updateData->check($updateData::CLIENTES, $_SESSION['codprov']);
$updateData->check($updateData::EXPORTADORES, $_SESSION['codprov']);
$updateData->check($updateData::CATALOGS, '');
?>
<div id="mainContainer" class="mainContainer">
    <div><input type="button"
                class="cmd button button-highlight button-pill"
                onclick="loadDespacho(-1)"
                value="<?php echo $lang[$idioma]['Nuevo']; ?>"></div>
    <div class="container">
        <div class="tableHolder">
            <h3>Activos</h3>
            <table id="activos" class="dataTable">
                <thead>
                <tr>
                    <th>Numero de Despacho</th>
                    <th>Fecha</th>
                    <th>Embarque</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //TODO agregar filtro por codigo proveedor
                $getDespachosQuery = "SELECT * FROM tra_des_enc WHERE estado = '0' AND codprov = '".$_SESSION['codprov']."'";
                $ejecutarGetDespachosQuery = mysqli_query(conexion($_SESSION['pais']), $getDespachosQuery);

                if($ejecutarGetDespachosQuery){
                    if(mysqli_num_rows($ejecutarGetDespachosQuery) > 0){
                        while($row = mysqli_fetch_assoc($ejecutarGetDespachosQuery)){
                            echo '
                    <tr>
                        <td><a
                            id="'.$row['coddespa'].'"
                            onclick="loadDespacho(this.id)"
                            href="#">'.$row['numdespa'].'</a></td>
                            
                            <td><a
                            id="'.$row['coddespa'].'"
                            onclick="loadDespacho(this.id)"
                            href="#">'.explode(' ', $row['fechadesp'])[0].'</a></td>
                            
                            <td><a
                            id="'.$row['coddespa'].'"
                            onclick="loadDespacho(this.id)"
                            href="#">'.$row['embarque'].'</a></td>
                    </tr>
                    ';
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="tableHolder">
            <h3>Historico</h3>
            <table id="historial" class="dataTable">
                <thead>
                <tr>
                    <th>Numero de Despacho</th>
                    <th>Fecha</th>
                    <th>Embarque</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $getDespachosQuery = "SELECT * FROM tra_des_enc WHERE estado = '1'";
                $ejecutarGetDespachosQuery = mysqli_query(conexion($_SESSION['pais']), $getDespachosQuery);

                if($ejecutarGetDespachosQuery){
                    if(mysqli_num_rows($ejecutarGetDespachosQuery) > 0){
                        while($row = mysqli_fetch_assoc($ejecutarGetDespachosQuery)){
                            echo '
                    <tr>
                        <td><a
                            id="'.$row['coddespa'].'"
                            onclick="loadDespacho(this.id)"
                            href="#">'.$row['numdespa'].'</a></td>
                           
                            <td><a
                            id="'.$row['coddespa'].'"
                            onclick="loadDespacho(this.id)"
                            href="#">'.explode(' ', $row['fechadesp'])[0].'</a></td>
                            
                            <td><a
                            id="'.$row['coddespa'].'"
                            onclick="loadDespacho(this.id)"
                            href="#">'.$row['embarque'].'</a></td>
                    </tr>
                    ';
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function loadDespacho(coddespa) {
        $.ajax({
            type: 'POST',
            url: '../Inicio/formularios/formDespachos.php',
            data: {
                method: 'loadDespacho',
                coddespa: coddespa,
            },
            success: function (response) {
                $('#mainContainer').empty();
                $('#mainContainer').append(response);
            },
            error: function (response) {
                console.log('error: ' + JSON.stringify(response));
            }
        });
    }

    $('#activos,#historial').DataTable({
        "paging": false,
        "filter": false,
        "info": false,
        "scrollY": "150px",
        "scrollCollapse": true
    });
</script>

<style>
    .container{
        align-items: center;
        display: flex;
        justify-content: center;
    }
    .tableHolder{
        width: 700px;
        height: 200px;
    }
</style>