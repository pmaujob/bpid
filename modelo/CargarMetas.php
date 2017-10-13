<?php

@session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class CargarMetas {

    public static function getSecretarias() {

        $consulta = 'select cod,'//0
                . 'nom '//1
                . 'from get_secretarias() as ("cod" integer, "nom" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getMetas($idSecretaria, $idRad) {

        $sess = new SessionVars();

        $consulta = 'select cod, '//0
                . 'des, '//1
                . 'metas, '//2
                . 'cr '//3
                . 'from get_metas(' . (!empty($idSecretaria) ? $idSecretaria : "null") . ',' . $idRad . ',\'' . $sess->getValue('cedula') . '\') as ("cod" integer, "des" varchar, "metas" varchar, "cr" integer)';
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }
    
    public static function getProyectMetas($numProyecto){
        
        $consulta = "select mp.cod_meta_producto as cod, "
                . "mp.descripcion as des, "
                . "array_agg(nmp.num_meta_producto) as metas "
                . "from num_meta_producto as nmp "
                . "join meta_producto as mp on nmp.cod_meta_producto = mp.cod_meta_producto "
                . "join radicacion_meta as met on met.cod_meta_producto = mp.cod_meta_producto "
                . "join radicacion as r on r.cod_radicacion = met.cod_radicacion "
                . "where r.num_proyecto = '$numProyecto' "
                . "group by mp.cod_meta_producto;";
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
        
    }

}

if (isset($_POST['idSecretaria'])) {

    $sqlRes = CargarMetas::getMetas($_POST['idSecretaria'], $_POST['idRad']);
    $array = Array();
    foreach ($sqlRes as $fila) {
        $array[] = Array("cod" => $fila[0], "des" => $fila[1], "nums" => $fila[2], "cr" => $fila[3]);
    }
    //echo $sqlRes;

    echo json_encode($array);
}
?>
