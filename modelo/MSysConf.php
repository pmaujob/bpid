<?php

require_once '../../librerias/ConexionPDO.php';

class MSysConf {

    private $codSysConf;
    private $filtrarDep;

    function __construct() {

        $consulta = 'SELECT cod_sys_conf, '//0
                . 'filtrar_dep '//1
                . 'FROM sys_conf;';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
                       
        foreach ($res as $fila) {
            $this->codSysConf = $fila[0];
            $this->filtrarDep = $fila[1];            
        }
        
    }

    function getCodSysConf() {
        return $this->codSysConf;
    }

    function getFiltrarDep() {
        return $this->filtrarDep;
    }

}

?>
