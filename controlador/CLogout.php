<?php

/**
 * Description of CLogout
 *
 * @author MAURICIO
 */
require_once '../librerias/SessionVars.php';
require_once '../modelo/MLogout.php';

class CLogout {
    
    private $idLog;
    private $sess;
    
    public function setIdLog(){
        
        $this->sess = new SessionVars();
        
        $this->idLog = $this->sess->getValue('idLog');
        
        $this->unSetSessiion();
        
    }
    
    public function logOut(){
        
        try{
            MLogin::logOut($this->idLog);
            return "Ok";
        }catch(ErrorException $e){
            return "No";
        }
        
    }
    
    private function unSetSession(){
        
        if($this->sess->exist()){
            
            if($this->sess->varExist('usuario'))
                $this->sess->unsetValue('usuario');
            
            if($this->sess->varExist('cedula'))
                $this->sess->unsetValue('cedula');
            
            if($this->sess->varExist('correo'))
                $this->sess->unsetValue('correo');
            
            if($this->sess->varExist('idLog'))
                $this->sess->unsetValue('idLog');
            
            $this->sess->destroy();
            
        }
        
    }
    
}

$logOut = new CLogout();
$logOut->setIdLog();
echo $logOut->logOut();

?>
