<?php
// 02-01-2018
// alex

class Sessio {
    private function __construct() {}

    static public function afeg($clau, $valor) {
        $_SESSION[$clau] = $valor;
    }
    static public function lleg($clau) {
        return $_SESSION[$clau];
    }
    static public function exis($clau) {
        return isset($_SESSION[$clau]);
    }
    static public function iniciar() {
        session_start();
    }
    static public function tancar() {
        session_start();
        session_destroy();
    }
}