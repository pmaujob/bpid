<?php

require_once '../../librerias/ConexionPDO.php';

class MSysConf {

    private $codSysConf;
    private $filtrarDep;

    function __construct() {

        $consulta = 'select cod, '//0
                . 'fsec '//1
                . 'from seguridad.get_sys_conf() as ("cod" integer, "fsec" boolean)';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        foreach ($res as $fila) {
            $this->codSysConf = $fila[0];
            $this->filtrarDep = (int) $fila[1];
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
