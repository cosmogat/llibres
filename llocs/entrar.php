<?php
// 02-01-2018
// billy
// entrar.php

class LlocEntrar {
    public $nomweb = "llibres";
    public $menu = "";
    public $permisos = 10;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();
    
    public $error = false;
    
    public function calculs() {
        if (Peticio::exis("entrar")) {
            $us = trim(Peticio::obte("usu"));
            $co = trim(Peticio::obte("con"));
            if (!Usuari::entrar($us, $co))
                $this->error = true;
        }
        if (Usuari::dins())
            redireccionar(Link::url("index"));
    }
    public function imprimir() {
        $tpl = new Plantilla("./html");
        $tpl->carregar("entrar");
        $tpl->mostrar("formulari");
        $tpl->set("ACTION", Link::url("entrar"));
        $tpl->set("USER", "alex");
        $tpl->imprimir();
        if ($this->error)
            $tpl->carregarMostrar("entrar", "error");
    }
}