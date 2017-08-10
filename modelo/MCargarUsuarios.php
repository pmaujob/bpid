<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class MCargarUsuarios {

    public static function getDatosUsuario($filter) {

        $sess = new SessionVars();

        $cedula = "'" . $sess->getValue('cedula') . "'";
        $filter = "'" . $filter . "'";

        $sql = 'select cedula, nombres, apellidos, correo, estado, secretaria from seguridad.get_usuario(' . $cedula . ',' . $filter . ') as ("cedula" varchar, "nombres" varchar, "apellidos" varchar, "correo" varchar, "estado" integer, "secretaria" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }

}

?>