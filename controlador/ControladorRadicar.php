<?php

session_start();
$raiz = $_SESSION['raiz'];
require_once $raiz . '/modelo/MRadicar.php';
require_once $raiz . '/librerias/ValidarDatos.php';
require_once $raiz . '/librerias/SessionVars.php';
$sess = new SessionVars();
$sess->init();

//if ($sess->exist() && $sess->varExist('cedula')) {

class ControladorRadicar {

    private $radicar;
    private $banco;
    //atributos de la tabl radicar
    private $numero_proyecto;
    private $nombre_proyecto;
    private $sector;
    private $localizacion;
    private $valor;
    private $eje;
    private $programa;
    private $subprograma;
    private $poai;
    private $entidad_proponente;
    private $entidad_ejecutante;
    private $num_id_responsable;
    private $nom_responsable;
    private $cargo_responsable;
    private $direccion_responsable;
    private $telefono_responsable;
    private $cel_responsable;
    private $correo_responsable;
    private $id_usuario;
    private $nombre_usuario;
    private $observaciones;
    private $cod_usuario_ingreso;
    private $cod_activacion;
    private $cod_secretaria;
    private $objetivosEspecificos;
    private $fuentesFinanciamiento;
    private $problema;
    private $poblacion;
    private $objetivog;
    private $productos;
    private $actividades;

    public function iniciar($valores, $cedulaSession) {

        if ($this->validarVacios($valores)) {
            $this->asignar($valores, $cedulaSession);
            if ($this->validar())
                $this->radicar = new MRadicar();
            return $this->radicar->ingresarRadicar(
                            $this->numero_proyecto, $this->nombre_proyecto, $this->sector, $this->localizacion, $this->valor,$this->eje,$this->programa,$this->subprogr, $this->poai, $this->entidad_proponente, $this->entidad_ejecutante, $this->num_id_responsable, $this->nom_responsable, $this->cargo_responsable, $this->direccion_responsable, $this->telefono_responsable, $this->cel_responsable, $this->correo_responsable, $this->id_usuario, $this->nombre_usuario, $this->observaciones, $this->cod_usuario_ingreso, $this->cod_secretaria, $this->cod_activacion, $this->objetivosEspecificos, $this->fuentesFinanciamiento, $this->problema, $this->poblacion, $this->objetivog, $this->productos, $this->actividades);
        }
    }

    public function asignar($valores, $cedulaSession) {
        $sess = new SessionVars();
        $sess->init();
        $this->numero_proyecto = $valores[0];
        $this->nombre_proyecto = $valores[1];
        $this->sector = $valores[2];
        $this->localizacion = $valores[3];
        $this->valor = $valores[4];
        $this->eje = $valores[5];
        $this->programa = $valores[6];
        $this->subprograma = $valores[7];
        $this->poai = $valores[8];
        $this->entidad_proponente = $valores[9];
        $this->entidad_ejecutante = $valores[10];
        $this->num_id_responsable = $valores[11];
        $this->nom_responsable = $valores[12];
        $this->cargo_responsable = $valores[13];
        $this->direccion_responsable = $valores[14];
        $this->telefono_responsable = $valores[15];
        $this->cel_responsable = $valores[16];
        $this->correo_responsable = $valores[17];
        $this->id_usuario = $valores[18];
        $this->nombre_usuario = $valores[19];
        $this->observaciones = $valores[20];
        $this->objetivosEspecificos = $valores[21];
        $this->fuentesFinanciamiento = $valores[22];
        $this->problema = $valores[23];
        $this->poblacion = $valores[24];
        $this->objetivog = $valores[25];
        $this->productos = $valores[26];
        $this->actividades = $valores[27];
        $this->cod_usuario_ingreso = $cedulaSession; //variable de sesion
        $this->cod_activacion = 1;
        $this->cod_secretaria = $sess->getValue('idSec');
    }

    public function validarVacios($valores) {
        $cont = 0;
        foreach ($valores as $campo)
            if (empty($campo))
                $cont++;

        if ($cont > 0)
            return false;
        else
            return true;
    }

    public function validar() {

        $correo = new ValidarDatos();
        return $correo->validarEmail($this->correo_responsable);
    }

    public function getDatosUsuario($cedula) {

        $rad = new MRadicar();
        return $rad->getDatosUsuario($cedula);
    }

}

if (isset($_POST['op']) && !empty($_POST['op'])) {
    if ($_POST['op'] == 1) {//guardar datos
        
        $valores = trim(($_POST["value"]));
        $valores = explode("//", $valores);
        $radicar = new ControladorRadicar();
        echo $radicar->iniciar($valores, $sess->getValue('cedula'));
    } else if ($_POST['op'] == 2) {
        //consultar Datos
        $cedula = $_POST['cedula'];
        $radicar = new ControladorRadicar();
        echo $radicar->getDatosUsuario($cedula);
    }
}
//} else {
//    header('http://' . $_SERVER['SERVER_NAME']);
//}
?>