<?php
require_once('../coneccion.php');
function buscarExtra($codigo, $formul)
{
    $formul = strtoupper($formul);
    switch ($formul) {
        case 'MARCA':
            {
                $cod = $codigo;
                $squery = "select nombre from cat_marcas where codmarca='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function(){ document.getElementById('Marca').value = '" . $row['nombre'] . "';},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        case 'PRODLIN':
            {
                $cod = $codigo;
                $squery = "select codigo,prodline from cat_pro_lin where codprolin='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function(){ document.getElementById('linea').value = '" . $row['prodline'] . "';},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        case 'SIZE':
            {
                $cod = $codigo;
                $squery = "select nombre,unidades,peso from cat_pre_prod where codprepro='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function(){ 
									document.getElementById('unidades').value = '" . $row['unidades'] . "';
									document.getElementById('peso').value = '" . $row['peso'] . "';
									document.getElementById('nombre').value = '" . $row['nombre'] . "';
									document.getElementById('medida').value = '" . (substr($row['nombre'], strlen($row['nombre']) - 2, strlen($row['nombre']))) . "';
									},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        case 'FLAVOR':
            {
                $cod = $codigo;
                $squery = "select nombre from cat_flavors where codflavor='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function(){ document.getElementById('Flavor').value = '" . $row['nombre'] . "';},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        case 'COCINA':
            {
                $cod = $codigo;
                $squery = "select nombre from cat_cocina where codcocina='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function(){ document.getElementById('cocina').value = '" . $row['nombre'] . "';},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        case 'SELLER':
            {
                $cod = $codigo;
                $squery = "select nombre from cat_marcas where codmarca='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function(){ document.getElementById('Marca').value = '" . $row['nombre'] . "';},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        case 'FORMULAS':
            {
                $cod = $codigo;
                $squery = "select nombre from cat_forms where codform='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function(){ document.getElementById('forms').value = '" . $row['nombre'] . "';},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        case 'MANUFACTURADORES':
            {
                $cod = $codigo;
                $squery = "select nombre,codigo,fda,direccion,ciudad,estado,codpos,pais from cat_manufacturadores where codmanufac='" . $cod . "'";
                if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                        echo "
								<script>
									setTimeout(function()
									{ 
									document.getElementById('manufact').value = '" . $row['nombre'] . "';
									document.getElementById('FDA').value = '" . $row['fda'] . "';
									document.getElementById('Direccion').value = '" . $row['direccion'] . "';
									document.getElementById('Ciudad').value = '" . $row['ciudad'] . "';
									document.getElementById('Estado').value = '" . $row['estado'] . "';
									document.getElementById('CodPos').value = '" . $row['codpos'] . "';
									document.getElementById('pais').value = '" . $row['pais'] . "';
									},300);
									</script>";
                    }
                }
                mysqli_close(conexion($_SESSION['pais']));
                break;
            }
        default:
            {
                $squery = "SELECT * FROM tra_bun_det";
                break;
            }
    }
}

?>
