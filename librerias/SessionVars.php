<?php

class SessionVars {

    public function init() {//iniciar sesion
        @session_start();
    }

    public function destroy() {//destriur sesion
        session_destroy();
    }

    public function getValue($id) {//obtener un valor de la variable sesion por id
        return $_SESSION[$id];
    }

    public function setValue($id, $val) {//establecer el id y valor de una variable de sesion
        $_SESSION[$id] = $val;
    }

    public function unsetValue($id) {//eliminar un valor de la variable sesion por su id
        if (isset($_SESSION[$id])) {
            unset($_SESSION[$id]);
        }
    }

    public function varExist($id) {
        if (isset($_SESSION[$id]) && !empty($_SESSION[$id])) {
            return true;
        } else {
            return false;
        }
    }

    public function exist() {//ver si existe la variable sesion
        if (sizeof($_SESSION) > 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>