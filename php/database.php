<?php
//TODO: escape inputs,
/**
 * Class database
 */
class database {
    const generalConnection = "generalConnection";
    const countryConnection = "countryConnection";
    const localConnection = "localConnection";

    const insertAction = "A";
    const updateAction = "M";
    const deleteAction = "E";

    private $jsonResponse;
    private $connection;
    private $currentConnection;
    private $currentTable;

    /**
     * database constructor.
     * @param $connectionType
     * @param $country
     * @param $tableName
     */
    function __construct($connectionType, $country, $tableName, $jsonResponse = false) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        $this->buildConnection($this->currentConnection, $country);
        $this->currentConnection = $connectionType;
        $this->currentTable = $tableName;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @param $connectionType
     * @param $country
     */
    private function buildConnection($connectionType, $country) {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
        include_once('/home/quintoso/etc/sigefcloud.com/config.php');
        session_start();
        $encrypt = new encrypt();
        $tDatabase = DB_DATABASE;
        switch ($connectionType) {
            case database::countryConnection:
                $query = "SELECT lpad(emp.CODIGO, '2', '0') as codigo FROM cat_empresas as emp INNER JOIN direct as dir ON emp.pais = dir.codPais WHERE dir.nomPais = '$country';";
                $result = mysqli_query(mysqli_connect(
                    $encrypt->decrypt(DB_HOST),
                    $encrypt->decrypt(DB_USER),
                    $encrypt->decrypt(DB_PASSWORD),
                    $encrypt->decrypt(DB_DATABASE)), $query);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $tDatabase = $encrypt->decrypt(DB_DATABASE) . $row['codigo'];
                break;
            case database::localConnection:
                $query = "SELECT prov.basedatos FROM cat_prov_local as prov INNER JOIN direct as dir ON prov.codproloc = dir.codproloc WHERE dir.nomPais = '$country';";
                $result = mysqli_query(mysqli_connect(
                    $encrypt->decrypt(DB_HOST),
                    $encrypt->decrypt(DB_USER),
                    $encrypt->decrypt(DB_PASSWORD),
                    $encrypt->decrypt(DB_DATABASE)), $query);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $tDatabase = $encrypt->decrypt(DB_DATABASE) . $row['codigo'];
                break;
        }

        $this->connection = mysqli_connect(
            $encrypt->decrypt(DB_HOST),
            $encrypt->decrypt(DB_USER),
            $encrypt->decrypt(DB_PASSWORD),
            $encrypt->decrypt($tDatabase));
    }

    /**
     * @param $connectionType
     */
    public function setConnectionType($connectionType) {
        $this->currentConnection = $connectionType;
    }

    /**
     * @param $tableName\
     */
    public function setTable($tableName) {
        $this->currentTable = $tableName;
    }

    /**
     * @param array $filters
     * @param array $fields
     * @param array $mods
     * @return string
     */
    public function select($filters = [], $fields = [], $mods = []) {

        $tFilters = "";
        $tFields = "*";
        $tMods = "";

        if ($filters != []) {
            $tFilters = "WHERE ";
            foreach ($filters as $filter) {
                $tFilters .= $filter[0] . " " . $filter[1] . " '" . $filter[2] . "' AND ";
            }
            $tFilters = substr($tFilters, 0, -5);
        }

        if ($fields != []) {
            $tFields = "";
            foreach ($fields as $field) {
                $tFields .= $field . ", ";
            }
            $tFields = substr($tFields, 0, -2);
        }

        if ($mods != []) {
            foreach ($mods as $mod) {
                $tMods .= $mod[0] . " " . $mod[1] . " " . $mod[2] . " ";
            }
            $tMods = substr($tMods, 0, -1);
        }

        $query = "SELECT $tFields FROM $this->currentTable $tFilters $tMods;";
        return $this->query($query);
    }

    /**
     * @param $filters
     * @param $fields
     * @return string
     */
    public function update($filters, $fields) {
        $tFields = "";
        foreach ($fields as $key => $field) {
            $tFields .= "$key='$field', ";
        }
        $tFields = substr($tFields, 0, -2);
        if ($filters != []) {
            $tFilters = "WHERE ";
            foreach ($filters as $filter) {
                $tFilters .= $filter[0] . " " . $filter[1] . " '" . $filter[2] . "' AND ";
            }
            $tFilters = substr($tFilters, 0, -5);
        }

        $query = "UPDATE $this->currentTable SET $tFields $tFilters;";
        return $this->query($query);
    }

    /**
     * @param $fields
     * @return string
     */
    public function insert($fields) {
        $tFields = "(";
        $tValues = "('";
        foreach ($fields as $key => $field) {
            $tFields .= $key . ", ";
            $tValues .= $field . "', '";
        }
        $tFields = substr($tFields, 0, -2);
        $tValues = substr($tValues, 0, -3);

        $tFields .= ")";
        $tValues .= ")";

        $query = "INSERT INTO $this->currentTable $tFields VALUES $tValues;";
        return $this->query($query);
    }

    /**
     * @param $query
     * @return array
     */
    public function sql($query) {
        return $this->query($query);
    }

    /**
     * @param $query
     * @return array
     */
    private function query($query) {
        $response = [];
        $result = mysqli_query($this->connection, $query);
        if ($result) {
            $response["estatus"] = "0";
            $tResponse = [];
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $tResponse[] = $row;
                }
                $response["response"] = $tResponse;
            } else {
                $response["estatus"] = "1";
                $response["message"] = "empty response";
                if ($this->connection->affected_rows > 0) {
                    $response["estatus"] = "0";
                    $response["message"] = "affected:" . $this->connection->affected_rows;
                    $this->binnacle($query);
                }
            }
        } else {
            $response["estatus"] = "-1";
            $response["message"] = "db error";
        }

        $response["query"] = $query;

        if ($this->jsonResponse) {
            $response = json_encode($response);
        }

        return $response;
    }

    private function binnacle($query) {

        session_start();
        $changes = "";
        $queryData = explode(" ", $query);
        switch ($queryData[0]) {
            case "INSERT":
                $tAction = database::insertAction;
                $strlen = strlen($query);
                $tIndex[] = [];
                for ($index = 0; $index <= $strlen; $index++) {
                    $char = substr($query, $index, 1);
                    if ($char == "(" || $char == ")") {
                        $tIndex[] = $index;
                    }
                }
                $tFields = substr($query, $tIndex[1] + 1, ($tIndex[2] - $tIndex[1]) - 1);
                $tValues = substr($query, $tIndex[3] + 1, ($tIndex[4] - $tIndex[3]) - 1);

                $tFieldsData = explode(",", $tFields);
                $tValuesData = explode(",", $tValues);

                for($index = 0; $index < count($tFieldsData); $index++){
                    $changes .= $tFieldsData[$index] . "=" . $tValuesData[$index];
                }
                break;
            case "UPDATE":
                $tAction = database::updateAction;
                break;
            case "DELETE":
                $tAction = database::deleteAction;
                break;
        }
        $CODBITA = sys2015();
        $CODEMPRESA = $_SESSION["codEmpresa"];
        $MODULO = "";
        $TABLA = $this->currentTable;
        $CODIGO = "";
        $ACCION = $tAction;
        $CAMBIOS = $changes;
        $USUARIO = $_SESSION["user"];
        $USUA_RED = $_SERVER['REMOTE_ADDR'];
        $EQUIPO = "";
        $FECHAHORA = date("Y-m-d h:m:s");
        $query = "
            INSERT INTO bitacora 
            (CODBITA, CODEMPRESA, MODULO, TABLA, CODIGO, ACCION, CAMBIOS, USUARIO, USUA_RED, EQUIPO, FECHAHORA)
            VALUES
            ('$CODBITA ', '$CODEMPRESA ', '$MODULO ', '$TABLA ', '$CODIGO ', '$ACCION ', '$CAMBIOS ', '$USUARIO ', '$USUA_RED ', '$EQUIPO ', '$FECHAHORA');
        ";

        echo "<br>!!" . $query . "!!<br >";
    }
}