<?php
// 28-12-2017
// billy
// index.php

class LlocIndex {
    public $nomweb = "llibres";
    public $menu = "index";
    public $permisos = 10;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();
    
    public function calculs() { }
    public function imprimir() {
        Peticio::impr();
    }
}