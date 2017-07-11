<?php

require_once '/../bpid_conf/configuracion.php';

class ConexionPDO
{

    private $motor;
    private $user;
    private $pass;
    private $host;
    private $db;
    private $pdo;
    
    private function conectarMySQL(){

        $this->motor = MYS_MOTOR;
        $this->user = MYS_USER;
        $this->pass = MYS_PASS;
        $this->host = MYS_HOST;
        $this->db = MYS_DB;

    }

    private function conectarPostgreSQL(){

        $this->motor = PG_MOTOR;
        $this->user = PG_USER;
        $this->pass = PG_PASS;
        $this->host = PG_HOST;
        $this->db = PG_DB;

    }

    public function conectar($gestor){
        
        if($gestor==="MS")
            $this->conectarMySQL();
        else if($gestor==="PG")
            $this->conectarPostgreSQL();

        try {
            
            $this->pdo = new PDO("$this->motor:host=$this->host;dbname=$this->db;", $this->user, $this->pass);
            $this->pdo->query("SET NAMES 'utf8'");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }catch(PDOException $e){
            echo 'Falló la conexión: ' . $e->getMessage();
        }

    }

    public function  consultarValor($sql){

        $rt = null;
        
        try
            {
            
            $query = $this->pdo->prepare($sql);
            $query->execute();
            if($res = $query->fetch(PDO::FETCH_OBJ))
                $rt=$rt.$res->numero_completo;
                    
        }catch(PDOException $e){
            error_log( $e->getMessage() ); 
        }
        
        return $rt;
        
    }
    
    public function consultar($sql){

        $rt = null;
    
        try {
            
            $query = $this->pdo->prepare($sql);
            $query->execute();
            $rt = $query;
               
        }catch(PDOException $e){
            error_log( $e->getMessage() ); 
        }
        
        return $rt;
        
    }

    public function afectar($sql){
      
        $res=0;       
      
        try {
       
            $this->pdo->exec($sql);
            $res=1;

        }catch(PDOException $e){
            error_log( $e->getMessage() ); 
        }
        
        return $res;
        
    } 
  
    public function cerrarConexion(){
        
        $this->pdo=null;
        
    }

}

?>