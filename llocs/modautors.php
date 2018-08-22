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
            if (Peticio::exis("afegir")) {

            }
        }
    }

    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {
            $tpl->carregar("modautors");
            $tpl->mostrar("form_afegir");
            $tpl->set("ACTION", Link::url(Peticio::obte("op"). "-autors", Peticio::obte("cat")));
            $tpl->set("ACCIO", "Afegir");
            $tpl->set("BOTO", "success");
            $tpl->imprimir();
        }
        Peticio::impr();
        imprVec($_FILES);
    }
}