<?php
// 27-08-2018
// alex
// modllibres.php

class LlocModllibres {
    public $nomweb = "llibres";
    public $menu = "llibres";
    public $permisos = 2;
    public $molles = array();
    public $jsc_cap = array("autocomp_autors.js");
    public $jsc_peu = array();
    public $css = array();
    
    public $alert = 0;
    public $autor = array();
    
    public function calculs() {
        $this->mod = intval(Peticio::obte("mode"));
        if (!preg_match("/^[0-2]$/", $this->mod))
            redireccionar(Link::url("index"));
    }

    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {
            $tpl->carregar("modllibres");
            $tpl->mostrar("form_afegir");
            $tpl->set("ACTION", Link::url("afegir-llibres"));
            $tpl->set("TORNAR", Link::url("index")); // canviar a menu de configuració
            $tpl->imprimir();
        }
        Peticio::impr();
    }

}