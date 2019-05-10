<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function getEmpresas($user)
{

##  sentencia sql para consultar el usuario y contraseña
    $sql = "SELECT p.codempresa as codempresa,e.imagen as imagen,e.imagen1 as imagen1,e.nombre as empresa,p.rol as rol FROM acempresas p 
		inner join cat_empresas e on e.codempresa=p.codempresa
		inner join sigef_usuarios u on u.codusua=p.codusua
		WHERE p.codusua='" . strtoupper($user) . "' and u.codusua='" . strtoupper($user) . "' and (u.estado=1 or u.estado=21)";

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
            echo "<table id=\"tablaPaises\" style=\"margin-top:2%;\"> <br><tr>";
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

function getProveedor($user)
{

    include_once ("../php/fecha.php");

##  sentencia sql para consultar el usuario y contras   eña

    {
        $sql = "SELECT p.codprov as codprov,p.codusua,u.posicion as rol from acprov p inner join sigef_usuarios u on u.codusua=p.codusua 
		WHERE p.codempresa='" . $_SESSION['codEmpresa'] . "' and p.codusua='" . strtoupper($user) . "' and (u.estado=1 or u.estado=21)";
    }

## ejecución de la sentencia sql

    $ejecutar = mysqli_query(conexion(""), $sql);
## si existe inicia una sesion y guarda el nombre del usuario
    $res = $ejecutar->num_rows;
    if ($res > 0) {
        if ($res == 1) {
            $contador = 0;
            echo $_SESSION['pais'];
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                $_SESSION['codprov'] = $row['codprov'];
                $query = "select nombre from cat_prov where codprov='" . $row['codprov'] . "' and codempresa='" . $_SESSION['codEmpresa'] . "' and tipo=1 ";

                if ($ejecutar2 = mysqli_query(conexion($_SESSION['pais']), $query)) {
                    while ($row2 = mysqli_fetch_array($ejecutar2, MYSQLI_ASSOC)) {
                        echo "<script>abrirPaginaPrinProveedor('" . $row['codprov'] . "','" . $row['rol'] . "');</script>";
                    }
                }


            }
        } else {
            echo "<center><table id=\"tablaPaises\" style=\"margin-top:2%; margin-left:10%; width:700px;\"><tbody> <br><tr>";
            echo "<h2>".$_SESSION['pais']."</h2>";
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                $_SESSION['codprov'] = $row['codprov'];
                $t .= "'".$row['codprov']."',";

                $tRol[$row["codprov"]] = $row["rol"];
            }
            $t = substr($t, 0, -1);
//            var_dump($tRol);

            $query = "select codprov, nombre from cat_prov where codprov in ($t) and tipo=1 order by nombre;";

            if ($ejecutar2 = mysqli_query(conexion($_SESSION['pais']), $query)) {
                while ($row2 = mysqli_fetch_array($ejecutar2, MYSQLI_ASSOC)) {
//                    echo $row2["codprov"] . "<br>";
//                    echo $tRol[strtoupper($row2["codprov"])] . "<br>";
                    echo "
                        <tr style='text-align: left;'>
                            <td onClick=\"abrirPaginaPrinProveedor('" . $row2['codprov'] . "','" . $tRol[strtoupper($row2["codprov"])] . "')\" class=\"empresa\">
                                <span class=\"text\" style=\"font-size:12px;\" >" . strtoupper(limpiar_caracteres_sql($row2['nombre'])) . "</span>
                            </td>
                        </tr>
                    ";
                }
            }
        }

    } else {

        echo "<br><br>
       <img src=\"../images/logo.png\" width=\"600\" height=\"250\"/>
       <br><br><br>";

    }
    echo "</tr></tbody></table></center><br>";
}

function getPais($user)
{

    require_once('../php/coneccion.php');
    $sql = "select p.nompais as pais,p.codigo from direct p inner join cat_empresas e on e.pais=p.codpais
	inner join acempresas a on a.codempresa=e.codempresa 
	inner join sigef_usuarios u on a.codusua=u.codusua
	where u.codusua='" . $user . "'";
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