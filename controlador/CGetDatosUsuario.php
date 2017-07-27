<?php

require_once '../modelo/MGetDatosUsuario.php';

class CGetDatosUsuario{
    
    public function getDatosUusario($cedula){
        
        $usuario = new MGetDatosUsuario();
        
        if($usuario->existeUsuarioEnBpid($cedula))
            return 'EBPID';
        else if(!$usuario->existeUsuarioEnGovernacion($cedula))
            return 'NEG';
        else{
            
            $usuario->setDatosUsuario($cedula);
            
            $array = [
                "nombres" => $usuario->getNombres(),
                "apellidos" => $usuario->getApellidos(),
                "correo" => $usuario->getCorreo(),
                "dependencia" => $usuario->getDependencia(),
            ];
            
            return json_encode($array);
            
        }
        
    }
    
}

if(isset($_POST['cedula']) && !empty($_POST['cedula'])){
    
    $datosUsuario = new CGetDatosUsuario();
    echo $datosUsuario->getDatosUusario($_POST['cedula']);
    
}

?>