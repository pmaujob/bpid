<?php

@session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/ConexionPDO.php';

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

    public static function getMetas($idSecretaria) {

        $consulta = 'select cod, '//0
                . 'des, '//1
                . 'metas '//2
                . 'from get_metas('.$idSecretaria.') as ("cod" integer, "des" varchar, "metas" varchar)';
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}

if (isset($_POST['idSecretaria'])) {

    $sqlRes = CargarMetas::getMetas($_POST['idSecretaria']);
    $array = Array();
    foreach ($sqlRes as $fila) {
        $array[] = Array("cod" => $fila[0], "des" => $fila[1], "nums" => $fila[2]);
    }

    echo json_encode($array);
}
?>
