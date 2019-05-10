<?php
require_once('../../../php/fecha.php');
$idioma=idioma();
require_once('../../coneccion.php');
include('../../../php/idiomas/'.$idioma.'.php');
session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];
$pais=$_SESSION['pais'];

//$squery="select cc.coddpol as codigo,cc.debe as debe,cc.haber as haber, cc.cuenta as cuenta, (select cb.nombre from cat_nomenclatura cb where cb.codigo=cc.cuenta limit 1) as nombreconta from tra_pol_det cc;";
$squery="select cc.coddpol as codigo,cc.debe as debe,cc.haber as haber, cc.cuenta as cuenta, (select cb.nombre from cat_nomenclatura cb where cb.codigo=cc.cuenta limit 1) as nombreconta from tra_pol_det cc;";
?>



<div id="buscar">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table class="ajustesvarios23">
                <tr><div id="resultado"></div></tr>
            <tr>
                <td class="text"><span>Buscar</span></td>
                <td><input type="text2" style="width: 67%;" class='entradaTexto ajuestetam8' name="tipomone" id="tipomone" placeholder="buscar"></td>
                
            </tr>
            <tr>
            
            <td colspan="4">
              <?php   
                echo encabezado().tabla($squery);
            ?>
            </td>

            </tr> 
            
        </table>
        </center>
                </form>
                
</div>
<?php
        
        function tabla($squer)
{
    $retornar="";
    $retornar=$retornar."<tbody>";
    $ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer);

        if($ejecutar)
        {
            while($row=mysqli_fetch_array($ejecutar,MYSQL_ASSOC))
            {
                if($ejecutar->num_rows>0)
                {
                    $retornar.="<tr onclick=\"\";>
                    
                                                                                                              
                                    <td hidden>".$row['codigo']."</td>
                                    <td class='bode12'>".$row['cuenta']."</td>
                                    <td class='bode12'>".$row['nombreconta']."</td>
                                    <td class='bode12'>".$row['debe']."</td>
                                    <td class='bode12'>".$row['haber']."</td>
                                </tr>
                                ";
                }
            }

        }

        $retornar.="</tbody></table></div></center>
        <script type=\"text/javascript\"src=\"../../js/datatables.min.js\"> </script>
            <script   type=\"text/javascript\">
 
           $(document).ready(function(){
    
   $('#tablas1').DataTable( {

        \"scrollY\": \"500px\",
        \"scrollX\": true,
        \"paging\":  true,
        \"info\":     false,
        \"oLanguage\": {
      \"sLengthMenu\": \" MENU \",
      
  
        
      
    }
   
         
    } );
    

     
});
           </script>
           </div>";
        
                return $retornar;
}

function encabezado()
{
    return "
    <div id='datos1'>
    <center>
            <div>
            <table id=\"tablas1\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"hover tablas table\">
                <thead>
                <tr  class=\"titulo\">
                   
                    <th hidden=\"hidden\">Codigo</th>
                    <th>Cuenta</th>
                    <th>Nombre de la Cuenta</th>
                    <th>Debe</th>
                    <th>Haber</th>

                </tr> </thead>
            ";
}

?>
