<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/database.php");
echo "
<h1>database object</h1>
<h2>constructor</h2>
<b>connection type:</b> database::generalConnection => sigef, database::countryConnection => sigef01, database::localConection => rsigef01<br>
<b>country:</b> authenticated user's country (ie $ _SESSION['pais'])<br>
<b>table:</b> string table name<br>
<b>jsonResponse:</b> optional, response is json<br>
";
$database = new database(database::generalConnection, "Guatemala", "cat_empresas", true);

$selectAll = $database->select();
$selectFields = $database->select([], ["CODEMPRESA", "CODIGO", "COMPANYID", "NOMBRE"]);
$selectFilter = $database->select([["CODIGO", ">", "100"]], ["CODEMPRESA", "CODIGO", "COMPANYID", "NOMBRE"]);
$selectFilters = $database->select([["CODIGO", ">", "0"], ["NOMBRE", "LIKE", "cr%"]], ["CODEMPRESA", "CODIGO", "COMPANYID", "NOMBRE"]);
$selectMod = $database->select([["CODIGO", ">", "0"], ["NOMBRE", "LIKE", "%d%"]], ["CODEMPRESA", "CODIGO", "COMPANYID", "NOMBRE"], [["ORDER BY", "NOMBRE", "ASC"]]);
$selectMods = $database->select([["CODIGO", ">", "0"], ["NOMBRE", "LIKE", "%d%"]], ["CODEMPRESA", "CODIGO", "COMPANYID", "NOMBRE"], [["ORDER BY", "NOMBRE", "ASC"],["LIMIT", "1"]]);
echo "<h3>select</h3>";

echo "<br>all: select()<br>";
var_dump($selectAll);
echo "<br>";

echo "<br>fields: select([], [\"CODEMPRESA\", \"CODIGO\", \"COMPANYID\", \"NOMBRE\"])<br>";
var_dump($selectFields);
echo "<br>";


echo "<br>fields and filter: select([[\"CODIGO\", \"=\", \"1\"]], [\"CODEMPRESA\", \"CODIGO\", \"COMPANYID\", \"NOMBRE\"])<br>";
var_dump($selectFilter);
echo "<br>";

echo "<br>fields and filters: select([[\"CODIGO\", \">\", \"0\"], [\"NOMBRE\", \"LIKE\", \"cr%\"]], [\"CODEMPRESA\", \"CODIGO\", \"COMPANYID\", \"NOMBRE\"])<br>";
var_dump($selectFilters);
echo "<br>";

echo "<br>fields, filters and mod: select([[\"CODIGO\", \">\", \"0\"], [\"NOMBRE\", \"LIKE\", \"%d%\"]], [\"CODEMPRESA\", \"CODIGO\", \"COMPANYID\", \"NOMBRE\"], [[\"ORDER BY\", \"NOMBRE\", \"ASC\"]])<br>";
var_dump($selectMod);
echo "<br>";

echo "<br>fields, filters and mods: select([[\"CODIGO\", \">\", \"0\"], [\"NOMBRE\", \"LIKE\", \"%d%\"]], [\"CODEMPRESA\", \"CODIGO\", \"COMPANYID\", \"NOMBRE\"], [[\"ORDER BY\", \"NOMBRE\", \"ASC\"],[\"LIMIT\", \"1\"]])<br>";
var_dump($selectMods);
echo "<br>";


echo "<h3>insert</h3>";
$insertDatabase = new database(database::generalConnection, "Guatemala", "cat_pay_sta", true);
$insert = $insertDatabase->insert(["nombre" => "test"]);
echo "<br>insert([\"nombre\" => \"test\"])<br>";
var_dump($insert);
echo "<br>";

echo "<h3>update</h3>";
$updateFilter = $insertDatabase->update([["codpaysta", "=", "35"]], ["nombre" => "t1"]);
$updateFilters = $insertDatabase->update([["codpaysta", "=", "36"], ["nombre", "=", "UnNombre"]]);
echo "<br>update([[\"codigo\", \"=\", \"15\"]], [\"id\" => \"1\", \"codigo\" => \"UnCodigo\", \"nombre\" => \"UnNombre\"])<br>";
echo $updateFilter."<br>";
echo "<br>update([[\"codigo\", \"=\", \"15\"], [\"nombre\", \"=\", \"UnNombre\"]], [\"id\" => \"1\", \"codigo\" => \"UnCodigo\", \"nombre\" => \"UnNombre\"])<br>";
echo $updateFilters."<br>";