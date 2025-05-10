<?php

class SqlPro{
    public $conn;

    function __construct($conn){
        $this->conn = $conn;
    }
    
    /**
     * Summary of sql_log
     * @param mixed $sql
     * @param mixed $params
     * @param mixed $tipos
     * @return void
     */
    function sql_log($sql, $params, $tipos) {
        $tempDir = sys_get_temp_dir();
        $logDir = $tempDir . '/sql_logs';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . '/sql_log.txt';
        $fileHandle = fopen($logFile, 'a');
        $sqlWithParams = $sql;

        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $value = is_null($value) ? 'NULL' : $value;
                $value = is_string($value) ? "'".addslashes($value)."'" : $value;
                // Substitui o próximo marcador de parâmetro na consulta
                $sqlWithParams = preg_replace('/\?/', $value, $sqlWithParams, 1);
            }
        }

        $logEntry = sprintf(
            "[%s] SQL Query: %s\n",
            date('Y-m-d H:i:s'),
            $sqlWithParams
        );

        fwrite($fileHandle, $logEntry);
        fclose($fileHandle);
    }

    /**
     * Summary of sql_log_return
     * @param mixed $sql
     * @param mixed $params
     * @param mixed $tipos
     * @return string
     */
    function sql_log_return($sql, $params, $tipos) {
        $sqlWithParams = $sql;

        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $value = is_null($value) ? 'NULL' : $value;
                $value = is_string($value) ? "'".addslashes($value)."'" : $value;
                $sqlWithParams = preg_replace('/\?/', $value, $sqlWithParams, 1);
            }
        }
        
        return $sqlWithParams;
    }

    /**
     * Summary of sql_fetch_all
     * @param mixed $sql
     * @param mixed $params
     * @param mixed $tipos
     * @return object
     */
    function sql_fetch_all($sql, $params, $tipos){
        $stmt = $this->conn->prepare($sql);
        if(count($params) > 0){
            $stmt->bind_param($tipos, ...$params);
        }
        $stmt->execute();

        $resultado = $stmt->get_result();
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        $qtd = $resultado->num_rows;

        $stmt->close();

        return (object) [
            'sql' => $dados,
            'num_rows' => $qtd
        ];
    }

    /**
     * Summary of sql_fetch
     * @param mixed $sql
     * @param mixed $params
     * @param mixed $tipos
     * @return object
     */
    function sql_fetch($sql, $params, $tipos){
        $stmt = $this->conn->prepare($sql);
        if(count($params) > 0){
            $stmt->bind_param($tipos, ...$params);
        }
        $stmt->execute();

        $resultado = $stmt->get_result();
        $dados = $resultado->fetch_assoc();
        $qtd = $resultado->num_rows;

        $stmt->close();

        return (object) [
            'sql' => $dados,
            'num_rows' => $qtd
        ];
    }

    /**
     * Summary of sql_fetch_one
     * @param mixed $sql
     * @param mixed $params
     * @param mixed $tipos
     * @return object
     */
    function sql_update($sql, $params, $tipos){
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;
        $stmt->close();

        return (object) [
            'affected_rows' => $affected_rows,
            'status' => ($affected_rows > 0) ? 'success' : 'no_change',
            'error' => ($this->conn->error) ? $this->conn->error : null
        ];
    }

    /**
     * Summary of sql_fetch_one
     * @param mixed $sql
     * @param mixed $params
     * @param mixed $tipos
     * @return object
     */
    function sql_insert($sql, $params, $tipos){
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        $stmt->execute();

        $insert_id = $stmt->insert_id;
        $affected_rows = $stmt->affected_rows;
        $stmt->close();

        return (object) [
            'insert_id' => $insert_id,
            'affected_rows' => $affected_rows,
            'status' => ($affected_rows > 0) ? 'success' : 'failed',
            'error' => ($this->conn->error) ? $this->conn->error : null
        ];
    }

    /**
     * Summary of sql_fetch_one
     * @param mixed $sql
     * @param mixed $params
     * @param mixed $tipos
     * @return object
     */
    function sql_delete($sql, $params, $tipos){
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;
        $stmt->close();

        return (object) [
            'affected_rows' => $affected_rows,
            'status' => ($affected_rows > 0) ? 'success' : 'no_change',
            'error' => ($this->conn->error) ? $this->conn->error : null
        ];
    }
}
