<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class CargarUsuarios {

    public static function getUsuarios($value) {

        $sql = "select identificacion as iden, nombres as nom, concat(apellido,' ',segundoApellido) as ape, correo as correo, dependencia as dep from servidorespublicosycontratistas where identificacion like '%$value%' or concat(nombres,' ',apellido,' ',segundoApellido) like '%$value%';";

        $con = new ConexionPDO();
        $con->conectar("MS");
        $res = $con->consultar($sql);

        return $res;
    }

}

?>
