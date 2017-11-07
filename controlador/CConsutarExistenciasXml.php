<?php

require_once '../librerias/ConexionPDO.php';
include_once '../librerias/SessionVars.php';
$sess = new SessionVars();
$sess->init();
if ($sess->exist() && $sess->varExist('cedula')) {

    //session_start();

    class ConsultasXml {

        private $con;
        public $rutaProyecto;
        public $nombreArchivo;
        public $extension;
        public $codigoControl;

        function __construct() {

            $this->con = new ConexionPDO();
            $this->con->conectar("PG");
        }

        public function asignar($ruta_tmp, $nombreArchivo, $extension) {
            $this->rutaProyecto = $ruta_tmp; //carpeta 
            $this->nombreArchivo = $nombreArchivo;
            $this->extension = $extension;
            $this->codigoControl = sha1_file($ruta_tmp);
        }

        public function getXml() {
            if ($this->validarExtension()) {

                $datos = simplexml_load_file($this->rutaProyecto);
                $numero_proyecto = utf8_decode($datos->Id);
                $this->codigoControl = sha1_file($this->rutaProyecto);
                $consulta = "select hash_num as numero from archivos where hash_num='$this->codigoControl'";

                try {
                    $res = $this->con->consultar($consulta);

                    if ($res->rowCount() > 0)
                        return 1;
                    else
                        return 0;
                } catch (ErrorException $e) {
                    echo 'Error: ' . $e;
                }
            } else
                return 2;
        }

        public function validarExtension() {

            if ($this->extension == "xml" or $this->extension == "XML")
                return true;
            else
                return false;
        }

        public function validarContenidoXml() {
            if ($archivo = fopen($this->rutaProyecto, "r")) {
                $palabra = "xml version";
                
                while (!feof($archivo)) {
                    $busca = fgets($archivo);
                    if (strpos($busca, $palabra)) {
                        return true;
                                 }
                    else
                    {
                        return false;
                    }
                    
                }

            } else {
                return false;
            }
        }

    }

    if (!empty($_FILES['frm_archivo'])) {
        $consultaxml = new ConsultasXml();
        $ruta_tmp = $_FILES['frm_archivo']['tmp_name']; //ruta temporal del archivo
        $nombreArchivo = $_FILES['frm_archivo']['name']; //verificar si el nombre esta bn escrito
        $trozos = explode(".", $nombreArchivo);
        $extension = end($trozos);
        $consultaxml->asignar($ruta_tmp, $nombreArchivo, $extension);
       
        if ($consultaxml->validarContenidoXml()) {
            echo $consultaxml->getXml();
        } else {
            echo "2"; //Error de contenido
        }
        //echo sha1_file($_FILES['frm_archivo']['tmp_name']);
    }
    ?>

    <?php

} else {
    header('http://' . $_SERVER['SERVER_NAME']);
}
?>