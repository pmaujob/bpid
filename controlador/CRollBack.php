<?php

require_once '../modelo/MRollBack.php';

$op = $_POST['op'];
$idRad = $_POST['idRad'];
switch($op){
    
    case "2": //Regresar a la etapa 2        
        echo MRollBack::returnToMetas($idRad);        
        break;
    
    default:
        echo "Op no identificado.";
        
        break;
    
}

?>
