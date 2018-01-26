<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class MRadicar {

    public $con;

    public function __construc() {
        $this->con = new ConexionPDO();
        $this->con = $this->conectar("PG");
    }

    public function ingresarRadicar($numero_proyecto, $nombre_proyecto, $sector, $localizacion, $valor, $eje, $programa, $subprograma, $poai, $entidad_proponente, $entidad_ejecutante, $num_id_responsable, $nom_responsable, $cargo_responsable, $direccion_responsable, $telefono_responsable, $cel_responsable, $correo_responsable, $id_usuario, $nombre_usuario, $observaciones, $cod_usuario_ingreso, $cod_secretaria, $cod_activacion, $objetivosEspecificos, $fuentesFinanciamiento, $problema, $poblacion, $objetivog, $productos, $actividades, $resumen, $tipo_proyecto, $numero_proyecto_inversion) {

        $sess = new SessionVars();
        $cedula = $sess->getValue('cedula');

        $sql = "select from ing_radicacion($cod_activacion,$cod_usuario_ingreso,'$numero_proyecto','$sector','$localizacion','$valor','$programa','$subprograma',$poai,'$entidad_proponente','$entidad_ejecutante','$num_id_responsable',
                                    '$nom_responsable','$cargo_responsable','$direccion_responsable','$telefono_responsable','$cel_responsable','$correo_responsable','$id_usuario','$nombre_usuario','$observaciones',$cod_usuario_ingreso,'$nombre_proyecto','$eje',$cod_secretaria,$objetivosEspecificos,$fuentesFinanciamiento,'$problema',$poblacion,'$objetivog',$productos,$actividades,'$resumen','$tipo_proyecto',$numero_proyecto_inversion,'$cedula')";

        

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();
        return $resultado;
       // return $sql;
    }

    public function getDatosUsuario($cedula) {

        $sql = "select concat(nombres,' ',apellido,' ',segundoApellido) as nom, correo as correo, dependencia as dep, profesion as pro from servidorespublicosycontratistas where identificacion='" . $cedula . "'";

        $con = new ConexionPDO();
        $con->conectar("MS");
        $res = $con->consultar($sql);

        if (($res->rowCount() > 0)) {

            while ($resultado = $res->fetch(PDO::FETCH_OBJ)) {
                $array = [
                    "nombres" => $resultado->nom,
                    "cargo" => $resultado->pro,
                    "direccion" => $resultado->dep,
                    "telefono" => $resultado->dep,
                    "correo" => $resultado->correo,
                    "celular" => $resultado->correo,
                ];
                return json_encode($array);
            }
        } else {
            $cedula = "'" . $cedula . "'";
            $sql = 'select nombre,cargo,direccion,telefono,celular,correo from get_usuario_radicar(' . $cedula . ') as ("nombre" varchar,"cargo" varchar,"direccion" varchar, "telefono" varchar,"celular" varchar,"correo" varchar)';
            $con = new ConexionPDO();
            $con->conectar("PG");
            $res = $con->consultar($sql);
            if ($res->rowCount() > 0) {
                while ($resultado = $res->fetch(PDO::FETCH_OBJ)) {
                    $array = [
                        "nombres" => $resultado->nombre,
                        "cargo" => $resultado->cargo,
                        "direccion" => $resultado->direccion,
                        "telefono" => $resultado->telefono,
                        "correo" => $resultado->correo,
                        "celular" => $resultado->celular,
                    ];
                    return json_encode($array);
                }
            } else {
                return 'NoData';
            }
        }
    }

    public function getDatosProyectoPadre($secretaria, $op) {

        $sql = 'select cod,nom from get_datos_proyecto_inversion(' . $secretaria . ')as ("cod" integer, "nom" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        // return $sql;
         
        if ($op == 0) {
            return (string) json_encode($res->fetchAll(PDO::FETCH_OBJ));

            
        } else {
            return $res->rowCount();
        }
    }
    
    public function getControlSecretaria($secretaria)
    {
        
         $sql = 'select cod from  get_secretaria_dato_proyecto(' . $secretaria . ')as ("cod" integer);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
         return $res;
    }

    

}

?>