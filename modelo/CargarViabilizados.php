<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class CargarViabilizados {

    public static function getViabilizados($numBpid, $op) {

        switch ($op) {
            case 1:

                $consulta = 'select r,'//0
                        . 'nompro,'//1
                        . 'pro,'//2
                        . 'radobj,'//3
                        . 'despro,'//4
                        . 'pob,'//5
                        . 'dessubpro,'//6
                        . 'sec,'//7
                        . 'val,'//8
                        . 'loc,'//9
                        . 'resumen,'//10
                        . 'num,'//11
                        . 'fecvia ' //12
                        . 'from get_datos_viabilidad(' . $numBpid . ',' . $op . ') as ("r" integer, "nompro" varchar ,"pro" varchar,"radobj" varchar  ,"despro" varchar, "pob" integer, "dessubpro" varchar, "sec" varchar, "val" varchar, "loc" varchar,"resumen" varchar, "num" varchar, "fecvia" varchar);';
                break;
            case 2:
                $consulta = 'select obj '
                        . 'from get_datos_viabilidad(' . $numBpid . ',' . $op . ') as ("obj" varchar);';
                break;
            case 3:
                $consulta = 'select origen,'//0
                        . 'valor,'//1
                        . 'periodo,'//2
                        . 'etapa,' //3
                        . 'tend,' //4
                        . 'tentd ' //5
                        . 'from get_datos_viabilidad(' . $numBpid . ',' . $op . ') as ("origen" varchar, "valor" numeric, "periodo" integer,"etapa" varchar,"tend" varchar,"tentd" varchar );';
                break;
            case 4:
                $consulta = 'select id,'//0
                        . 'nump,'//1
                        . 'codr,'//2
                        . 'nom,'//3
                        . 'val,'//4
                        . 'idact,'//5
                        . 'des,'//6
                        . 'val,'//7
                        . 'mdes,'//8
                        . 'cant,'//9
                        . 'total '//10
                        . 'from get_datos_viabilidad(' . $numBpid . ',' . $op . ') as ("id" integer , "nump"  integer,"codr"  integer, "nom"  varchar,"idact"  integer,"des"  varchar,"val"  numeric, "mdes" varchar, "cant" numeric, "total" numeric);';
                break;

            default:
                # code...
                break;
        }

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        return $res;
    }

}

?>