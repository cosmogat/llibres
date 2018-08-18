<?php
// 28-12-2017
// alex
// modcategories.php

class LlocModcategories {
    public $nomweb = "llibres";
    public $menu = "categories";
    public $permisos = 1;
    public $molles = array();
    public $jsc_cap = array("buidar_camps.js");
    public $jsc_peu = array();
    public $css = array();

    public $mod = -1;
    public $cat = -1;
    public $nom_cat = "";
    public $tipus = -1;
    public $alert = 0;

    public $af_defecte = -1;
    
    public function calculs() {
        $opc = Peticio::obte("op");
        $this->cat = Peticio::obte("cat");
        $this->tipus = strlen($this->cat);
        if ($opc == "af")
            $this->mod = 0;
        else if ($opc == "ed")
            $this->mod = 1;
        else if ($opc == "el")
            $this->mod = 2;
        else
            redireccionar(Link::url("index"));
        if ($this->mod == 0) {
            if (($this->tipus < 1) or ($this->tipus > 2))
                redireccionar(Link::url("index"));
            if (Peticio::exis("afegir")) {
                $nom_cat = trim(Peticio::obte("nom"));
                $num_cat = trim(Peticio::obte("num"));
                if (($nom_cat == "") or ($num_cat == "") or (!cadValid($nom_cat)) or (!cadValid($num_cat)))
                    $this->alert = 1;
                else if ((strlen($num_cat) == 2)  or (strlen($num_cat) == 3)) {
                    $vec = BaseDades::consVector(Consulta::categories2id($num_cat));
                    if (count($vec) > 0)
                        $this->alert = 3;
                    else {
                        if (strlen($num_cat) == 2) {
                            $vect = BaseDades::consVector(Consulta::categories2id($num_cat[0]))[0];
                            if (count($vect) > 0) {
                                if (!BaseDades::consulta(Consulta::insert_subcategoria($vect[0], $nom_cat, $num_cat[1])))
                                    $this->alert = 5;
                                else
                                    $this->alert = 6;
                            }
                            else
                                $this->alert = 4;
                        }
                        else {
                            $vect = BaseDades::consVector(Consulta::categories2id($num_cat[0] . $num_cat[1]))[0];
                            if (count($vect) > 0) {
                                if (!BaseDades::consulta(Consulta::insert_subsubcategoria($vect[1], $nom_cat, $num_cat[2])))
                                    $this->alert = 5;
                                else
                                    $this->alert = 6;
                            }
                            else
                                $this->alert = 4;
                        }
                    }
                }
                else
                    $this->alert = 2;
            }
        }
        else if ($this->mod == 1) {
            $vec = BaseDades::consVector(Consulta::categories2id($this->cat));
            if (count($vec) == 0)
                redireccionar(Link::url("index"));
            $this->nom_cat = BaseDades::consVector(Consulta::class_perId($this->tipus, $vec[0][$this->tipus - 1]))[0][1];
           
        }
        
    }
    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {
            $tpl->carregar("modcategories");
            $tpl->mostrar("form_afegir");
            $tpl->set("ACTION", Link::url(Peticio::obte("op"). "-categories", Peticio::obte("cat")));
            $tpl->set("ACCIO", "Afegir");
            $tpl->set("BOTO", "success");
            if (Peticio::exis("afegir") and ($this->alert < 6) and ($this->alert > 0)) {
                $tpl->set("VALOR1", Peticio::obte("num"));
                $tpl->set("VALOR2", Peticio::obte("nom"));
            }
            else {
                $tpl->set("VALOR1", Peticio::obte("cat"));
                $tpl->set("VALOR2", "");
            }
            $tpl->set("TORNAR", Link::url("categories", substr(Peticio::obte("cat"), 0, strlen(Peticio::obte("cat")) - 1)));
            $tpl->imprimir();
        }
        else if ($this->mod == 1) {
            $tpl->carregar("modcategories");
            $tpl->mostrar("form_afegir");
            $tpl->set("ACTION", Link::url(Peticio::obte("op"). "-categories", Peticio::obte("cat")));
            $tpl->set("ACCIO", "Editar");
            $tpl->set("BOTO", "warning");
            if (Peticio::exis("afegir") and ($this->alert < 6) and ($this->alert > 0)) { }
            else {
                $tpl->set("VALOR1", $this->cat);
                $tpl->set("VALOR2", $this->nom_cat);
            }
            $tpl->set("TORNAR", Link::url("categories", substr(Peticio::obte("cat"), 0, strlen(Peticio::obte("cat")) - 1)));
            $tpl->imprimir();            
        }
        if ($this->alert != 0)
            $tpl->carregarMostrar("modcategories", "ale_" . $this->alert);
        Peticio::impr();
    }
}