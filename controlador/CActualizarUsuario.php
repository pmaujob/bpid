<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/modelo/MActualizarUsuario.php';

class CActualizarUsuario{
    
    public function setEstado($cedula,$estado){
        
        return MActualizarUsuario::setPermiso($cedula, ($estado=="true") ? 1 : 0);
        
    }
    
    public function actualizarPermisos(){
        
        
        
    }
    
}

if(isset($_POST['op']) && !empty($_POST['op'])){
    
    $act = new CActualizarUsuario();

    if($_POST['op']==1){
        if(isset($_POST['cedula']) && isset($_POST['estado']) && !empty($_POST['cedula']) && !empty($_POST['estado']))
            echo $act->setEstado($_POST['cedula'],$_POST['estado']);
        else
            echo "0";
    }else if($_POST['op']==2){
        echo "asdasdasdasdsd";
    }else{
        echo "0";
    }
    
}

?>

