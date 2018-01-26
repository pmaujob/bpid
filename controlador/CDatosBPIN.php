<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MDatosBPIN.php';

class CDatosBPIN {

    public function getDatosBPIN($idRad) {

        $array = [
            "numero" => MGetDatosBPIN::getDatosRadicacionBPIN($idRad)->fetch(PDO::FETCH_OBJ)->num,
            "nombre" => MGetDatosBPIN::getDatosRadicacionBPIN($idRad)->fetch(PDO::FETCH_OBJ)->nom
        ];

        return json_encode($array);
    }

    public static function registrarCodigoBPIN($idRad, $codBPIN) {
        
        return MGetDatosBPIN::registrarCodigoBPIN($idRad, $codBPIN);
        
    }

}

if (isset($_POST['op']) && !empty($_POST['op']) && isset($_POST['idRad']) && !empty($_POST['idRad'])) {

    $cDatosBPIN = new CDatosBPIN();
    if ($_POST['op'] == 1)
        echo $cDatosBPIN->getDatosBPIN($_POST['idRad']);
    else if($_POST['op'] == 2)
        echo $cDatosBPIN->registrarCodigoBPIN($_POST['idRad'], $_POST['codBPIN']);
    else
        echo '0';
}
