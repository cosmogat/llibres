<?php
// 28-12-2017
// alex
// modcategories.php

class LlocModcategories {
    public $nomweb = "llibres";
    public $menu = "categories";
    public $permisos = 1;
    public $molles = array();
    public $jsc_cap = array();
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
            if (Peticio::exis("afegir")) {
                $nou_nom = trim(Peticio::obte("nom"));
                $nou_num = trim(Peticio::obte("num"));
                if (strlen($nou_num) != $this->tipus)
                    $this->alert = 7;
                if (!cadValid($nou_nom))
                    $this->alert = 8;
                if (($nou_num == $this->cat) and ($nou_nom == $this->nom_cat))
                    $this->alert = 9;
                if ($this->alert == 0) {
                    if ($nou_nom != $this->nom_cat) {
                        if (!BaseDades::consulta(Consulta::editClassNom_perId($this->tipus, $vec[0][$this->tipus - 1], $nou_nom)))
                            $this->alert = 10;
                        else {
                            $this->nom_cat = $nou_nom;
                            $this->alert = 11;
                        }
                    }
                }
                if (($this->alert == 0) or ($this->alert == 11)) {
                    if ($nou_num != $this->cat) {
                        if (count(BaseDades::consVector(Consulta::categories2id($nou_num))) != 0)
                            $this->alert = 12;
                        else {
                            $exis = True;
                            for ($i = 0; $i <= $this->tipus - 2; $i++)
                                $exis = $exis & (BaseDades::consVector(Consulta::categories2id(substr($nou_num, 0, $i + 1))));
                            if ($exis == False)
                                $this->alert = 13;
                            else {
                                if (BaseDades::consulta(Consulta::editClassNum_perId($this->tipus, $vec[0][$this->tipus - 1], substr($nou_num, $this->tipus - 1, 1)))) {
                                    if ($this->tipus == 2) {
                                        if (!BaseDades::consulta(Consulta::editPareSubclass($nou_num[0], $vec[0][1])))
                                            $this->alert = 14;
                                    }
                                    else if ($this->tipus == 3) {
                                        if (!BaseDades::consulta(Consulta::editPareSubsubclass($nou_num[0], $nou_num[1], $vec[0][2])))
                                            $this->alert = 14;
                                    }
                                }
                                else 
                                    $this->alert = 14;
                                if ($this->alert != 14)
                                    redireccionar(Link::url("ed-categories", $nou_num));
                            }
                        }
                    }
                }
            }
        }
        else if ($this->mod == 2) {
            $vec = BaseDades::consVector(Consulta::categories2id($this->cat));
            if (BaseDades::consulta(Consulta::elimClass_perId($this->tipus, $vec[0][$this->tipus - 1])))
                $this->alert = 15;
            else
                $this->alert = 16;
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
            $tpl->set("VALOR1", $this->cat);
            $tpl->set("VALOR2", $this->nom_cat);
            $tpl->set("TORNAR", Link::url("categories", substr(Peticio::obte("cat"), 0, strlen(Peticio::obte("cat")) - 1)));
            $tpl->imprimir();            
        }
        if ($this->alert != 0)
            $tpl->carregarMostrar("modcategories", "ale_" . $this->alert);
        if ($this->mod == 1)
            $tpl->carregarMostrar("modcategories", "avis");
        if ($this->mod == 2) {
            $tpl->carregar("modcategories");
            $tpl->mostrar("el_tornar");
            $tpl->set("TORNAR", Link::url("categories", substr(Peticio::obte("cat"), 0, strlen(Peticio::obte("cat")) - 1)));
            $tpl->imprimir();   
        }
    }
}