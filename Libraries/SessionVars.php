<?php

class SessionVars {

    public function init() {
        @session_start();
    }

    public function destroy() {
        session_destroy();
    }

    public function getValue($id) {
        return $_SESSION[$id];
    }

    public function setValue($id, $val) {
        $_SESSION[$id] = $val;
    }

    public function unsetValue($id) {
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