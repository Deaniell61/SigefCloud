<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function getEmpresas($user) {
##  sentencia sql para consultar el usuario y contraseña
    $sql = "SELECT p.codempresa AS codempresa,e.imagen AS imagen,e.imagen1 AS imagen1,e.nombre AS empresa,p.rol AS rol FROM acempresas p 
		INNER JOIN cat_empresas e ON e.codempresa=p.codempresa
		INNER JOIN sigef_usuarios u ON u.codusua=p.codusua
		WHERE p.codusua='" . strtoupper($user) . "' AND u.codusua='" . strtoupper($user) . "' AND (u.estado=1 OR u.estado=21)";
## ejecución de la sentencia sql
    $ejecutar = mysqli_query(conexion(""), $sql);
## si existe inicia una sesion y guarda el nombre del usuario
    $res = $ejecutar->num_rows;
    if ($res > 0) {
        if ($res == 1) {
            $contador = 0;
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                $_SESSION['codEmpresa'] = $row['codempresa'];
                echo "<script>abrirPaginaProveedor('" . $row['codempresa'] . "','" . $row['rol'] . "');</script>";

            }

        } else {
            $contador = 0;
            echo "<table id=\"tablaPaises\" style=\"margin-top:2%\"> <br><tr>";
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                $contador++;
                echo "<td onClick=\"abrirPaginaProveedor('" . $row['codempresa'] . "','" . $row['rol'] . "')\" class=\"empresa\"><center><span class=\"text\">" . strtoupper($row['empresa']) . "</span><br><br><div class=\"imageninicio\"><img src=\"" . substr($row['imagen1'], 3) . "\" width=\"100%\"/></div></center></td>";
                if ($contador == 2) {
                    echo "</tr><tr>";
                    $contador = 0;
                }

            }

        }
    } else {
        echo "<br><br>
       <img src=\"../images/logo.png\" width=\"600\" height=\"250\"/>
       <br><br><br>";

    }
    echo "</tr></table><br>";
}

function getProveedor($user) {
    $contador = 0;
    echo "<center><table id=\"tablaPaises\" style=\"margin-top:2%; margin-left:10%;  width:500px;\"> <br><tr>";
    //empresas activadas inician con 2 los numeros siguientes indican diferentes estados de una empresa ya activa
    $query = "SELECT codprov,nombre FROM cat_prov WHERE codempresa='" . $_SESSION['codEmpresa'] . "' AND estado like '2%' AND tipo=1";
    echo $_SESSION['pais'];
//    echo "<br>$query";
    if ($ejecutar2 = mysqli_query(conexion($_SESSION['pais']), $query)) {
        if (1) {
            while ($row2 = mysqli_fetch_array($ejecutar2, MYSQLI_ASSOC)) {
                $contador++;
                echo "<td onClick=\"abrirPaginaPrinProveedor('" . $row2['codprov'] . "','" . $_SESSION['rol'] . "')\" class=\"empresa\"><center><span class=\"text\" style=\"font-size:25px;\">" . strtoupper($row2['nombre']) . "</span><br><br></center></td>";
                if ($contador == 1) {
                    echo "</tr><tr>";
                    $contador = 0;
                }
            }
        } else {
            echo "<br><br>
							   <img src=\"../images/logo.png\" width=\"600\" height=\"250\"/>
							   <br><br><br>";

        }
    }
    echo "</tr></table></center><br>";
}

function getPais($user) {
    require_once('../php/coneccion.php');
    $sql = "SELECT p.nompais AS pais,p.codigo FROM direct p INNER JOIN cat_empresas e ON e.pais=p.codpais
	INNER JOIN acempresas a ON a.codempresa=e.codempresa 
	INNER JOIN sigef_usuarios u ON a.codusua=u.codusua
	WHERE u.codusua='" . $user . "'";
    $ejecutar = mysqli_query(conexion(""), $sql);
    $res = "";
    if ($ejecutar) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $row['pais'];
            $_SESSION['CodSKUPais'] = $row['codigo'];
        }
    }
    return $res;


}

?>