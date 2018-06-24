<?php
// 02-01-2018
// billy
// eixir.php

class LlocEixir {
    public $nomweb = "llibres";
    public $menu = "";
    public $permisos = 10;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();
    
    public function calculs() {
        Usuari::eixir();
    }
    public function imprimir() {}
}