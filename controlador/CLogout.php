<?php
@session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/SessionVars.php';
require_once $raiz . '/modelo/MLogout.php';

class CLogout {

    private $idLog;
    private $sess;

    public function setIdLog() {

        $this->sess = new SessionVars();
        $this->idLog = $this->sess->getValue('idLog');
        $this->unSetSession();
    }

    public function logOut() {

        try {
            MLogout::logOut($this->idLog);
            return "Ok";
        } catch (ErrorException $e) {
            return "No";
        }
    }

    private function unSetSession() {

        if ($this->sess->exist()) {

            if ($this->sess->varExist('usuario'))
                $this->sess->unsetValue('usuario');

            if ($this->sess->varExist('cedula'))
                $this->sess->unsetValue('cedula');

            if ($this->sess->varExist('correo'))
                $this->sess->unsetValue('correo');

            if ($this->sess->varExist('idLog'))
                $this->sess->unsetValue('idLog');

            $this->sess->destroy();
        }
    }

}

$logOut = new CLogout();
$logOut->setIdLog();
$logOut->logOut();

header('Location: ../index.php');

?>
