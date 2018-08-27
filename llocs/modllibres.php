<?php
// 27-08-2018
// alex
// modllibres.php

class LlocModllibres {
    public $nomweb = "llibres";
    public $menu = "llibres";
    public $permisos = 2;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();
    
    public $alert = 0;
    public $autor = array();
    
    public function calculs() { }

    public function imprimir() {
        Peticio::impr();
    }

}