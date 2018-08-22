<?php
// 22-08-2018
// alex
// modautors.php

class LlocModautors {
    public $nomweb = "llibres";
    public $menu = "autors";
    public $permisos = 2;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();

    public function calculs() {
        $opc = Peticio::obte("op");
        if ($opc == "af") {
            $this->mod = 0;
            if (Peticio::obte("cat") != "AAA00")
                redireccionar(Link::url("af-autors", "AAA00")); 
        }
        else if ($opc == "ed")
            $this->mod = 1;
        else if ($opc == "el")
            $this->mod = 2;
        else
            redireccionar(Link::url("index"));

         if ($this->mod == 0) {
             
         }
    }

    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {

        }
        Peticio::impr();
    }
}