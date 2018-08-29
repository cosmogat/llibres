<?php
// 27-08-2018
// alex
// modllibres.php

class LlocModllibres {
    public $nomweb = "llibres";
    public $menu = "categories";
    public $permisos = 2;
    public $molles = array();
    public $jsc_cap = array("autocomp_autors.js", "data_compra.js", "afegir_autor.js", "subcat.js");
    public $jsc_peu = array();
    public $css = array();
    
    public $alert = 0;
    public $idiomes = array();
    public $categ = array();
    
    public function calculs() {
        $this->mod = intval(Peticio::obte("mode"));
        if (!preg_match("/^[0-2]$/", $this->mod))
            redireccionar(Link::url("index"));
        if ($this->mod == 0) {
            $this->idiomes = BaseDades::consVector(Consulta::idiomes());
            $vec_categ = BaseDades::consVector(Consulta::categories_completes());
            for ($i = 0; $i < count($vec_categ); $i++)
                $this->categ[] = array($vec_categ[$i][0], $vec_categ[$i][0] . " - " . $vec_categ[$i][1]);
        
        }
    }

    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {
            $tpl->carregar("modllibres");
            $tpl->mostrar("form_afegir_0");
            $tpl->set("ACTION", Link::url("afegir-llibres"));
            $tpl->imprimir();

            $tpl->carregar("modllibres");
            $tpl->setMatriu("cat_el", array("CAT_COD", "CAT_NOM"), $this->categ);
            $tpl->mostrar("cat_desp");
            $tpl->imprimir();

            $tpl->carregarMostrar("modllibres", "form_afegir_1");

            $tpl->carregar("modllibres");
            $tpl->setMatriu("idi_el", array("IDI_COD", "IDI_NOM"), $this->idiomes);
            $tpl->mostrar("idi_desp");
            $tpl->imprimir();
            
            $tpl->carregar("modllibres");
            $tpl->mostrar("form_afegir_2");
            $tpl->set("TORNAR", Link::url("index")); // canviar a menu de configuració
            $tpl->imprimir();
        }
        Peticio::impr();
    }

}