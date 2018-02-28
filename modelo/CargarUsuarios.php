<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class CargarUsuarios {

    public static function getUsuarios($value) {

        $sql = "select identificacion as iden, "//0
                . "nombres as nom, "//1
                . "concat(apellido,' ',segundoApellido) as ape, "//2
                . "correo as correo, "//3
                . "dependencia as dep "//4
                . "from servidorespublicosycontratistas "//5
                . "where identificacion like '%$value%' or concat(nombres,' ',apellido,' ',segundoApellido) like '%$value%';";

        $con = new ConexionPDO();
        $con->conectar("MS");
        $res = $con->consultar($sql);

        return $res;
    }

}

?>
