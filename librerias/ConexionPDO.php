<?php

class ConexionPDO {

    private $motor;
    private $user;
    private $pass;
    private $host;
    private $db;
    private $pdo;

    private function conectarMySQL() {

        $this->motor = 'mysql';
        $this->user = 'postgres';
        $this->pass = 'bpid2017';
        $this->host = '181.225.96.71';
        $this->db = 'bpid';
    }

    private function conectarPostgreSQL() {

        //Servidor
        $this->motor ='pgsql';
        $this->user = 'postgres';
        $this->pass = 'bpid2017';
        $this->host = '181.225.96.71';
        $this->db = 'bpid';

        //Local
//        $this->motor = 'pgsql';
//        $this->user = 'postgres';
//        $this->pass = '123456';
//        $this->host = '192.168.1.24';
//        $this->db = 'bpidl';
        
    }

    public function conectar($gestor) {

        if ($gestor === "MS")
            $this->conectarMySQL();
        else if ($gestor === "PG")
            $this->conectarPostgreSQL();

        try {

            $this->pdo = new PDO("$this->motor:host=$this->host;dbname=$this->db;", $this->user, $this->pass);
            $this->pdo->query("SET NAMES 'utf8'");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    public function consultarValor($sql) {

        $rt = null;

        try {

            $query = $this->pdo->prepare($sql);
            $query->execute();
            if ($res = $query->fetch(PDO::FETCH_OBJ))
                $rt = $res->numero_completo;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return $rt;
    }

    public function consultar($sql) {

        $rt = null;

        try {

            $query = $this->pdo->prepare($sql);
            $query->execute();
            $rt = $query;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return $rt;
    }

    public function afectar($sql) {

        $res = 0;

        try {

            $this->pdo->exec($sql);
            $res = 1;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return $res;
    }

    public function cerrarConexion() {

        $this->pdo = null;
    }

}

?>