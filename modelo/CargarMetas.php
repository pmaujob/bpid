<?php

@session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/ConexionPDO.php';

class CargarMetas {

    public static function getProgramas($codRadicacion) {

        $consulta = 'select cod_programa, '//0
                . 'descripcion, '//1
                . 'eje, '//2
                . 'cod_radicacion '//3
                . 'from get_programas('.$codRadicacion.') as ("cod" integer, "des" varchar, "eje" varchar, "codRad" integer);';
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getSubprogramas($idPrograma) {

        $consulta = 'select cod, des from get_subprogramas(' . $idPrograma . ') as ("cod" integer, "des" varchar);';
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getMetas($idSubPrograma) {

        $consulta = 'select cod, des from get_metas(' . $idSubPrograma . ') as ("cod" integer, "des" varchar);';
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}

if (isset($_POST['opConsulta'])) {

    switch ($_POST['opConsulta']) {

        case 1:

            echo json_encode(convertiraJson(CargarMetas::getSubprogramas($_POST['idPrograma'])));

            break;

        case 2:

            echo json_encode(convertiraJson(CargarMetas::getMetas($_POST['idSubprograma'])));

            break;

        default:
            echo "Opción no reconocida";
            break;
    }
}

function convertiraJson($sqlRes) {
    $array = Array();
    foreach ($sqlRes as $fila) {
        $array[] = Array("cod" => $fila[0], "des" => $fila[1]);
    }

    return $array;
}

?>
