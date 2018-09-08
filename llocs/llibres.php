<?php
// 28-12-2017
// billy
// llibres.php

class LlocLlibres {
    public $nomweb = "llibres | ";
    public $menu = "categories";
    public $permisos = 10;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array("lightbox.js");
    public $css = array();
    
    public $llib;
    public $crit = array();
    
    public function calculs() {
        $pro = Peticio::obte("propi");
        $cla = Peticio::obte("class");
        $aut = Peticio::obte("autor");
        $num = Peticio::obte("num_l");
        $this->llib = new Llibre();
        if ((preg_match("/^[a-z]{2}$/", $pro)) and (preg_match("/^[0-9]{3}$/", $cla)) and (preg_match("/^[A-Z0-9]{3,5}$/", $aut)) and (preg_match("/^[0-9]{3}$/", $num)))
            $this->llib->agafPerEt($pro, $cla, $aut, $num);
        
        if ($this->llib->id != -1) {
            $this->nomweb = $this->nomweb . $this->llib->nom . " - " . $this->llib->autor->nom;
            $id_us = Usuari::idusuari();
            if ($id_us != -1) {
                $v_cri = BaseDades::consVector(Consulta::critiques($id_us, $this->llib->id));
                if (count($v_cri) > 0)
                    $this->crit = descodCad($v_cri[0]);
            }
            $this->molles[] = array(Link::url("index"), icona_bootstrap("home"));
            $this->molles[] = array(Link::url("categories"), "Categories");
            for ($i = 0; $i < 3; $i++)
                $this->molles[] = array(Link::url("categories", substr($this->llib->categ->codi, 0, $i + 1)), $this->llib->categ->nom[$i]);
            $this->molles[] = array("", $this->llib->nom);
        }
        else
            redireccionar(Link::url("categories"));
        
    }
    public function imprimir() {
        if (count($this->llib) > 0) {            
            $tpl = new Plantilla("./html");
            
            $tpl->carregar("llibres");
            $tpl->mostrar("llibre_0");
            $tpl->set("TITOL", $this->llib->nom);
            $tpl->set("IMATG", Link::img("llibres/" . $this->llib->imatg));
            $tpl->set("LNK_A", Link::url("autors", $this->llib->autor->codi));
            $tpl->set("AUTOR", $this->llib->autor->nom);
            $tpl->set("ETIQU", $this->llib->etiqueta());
            $tpl->imprimir();
            if ($this->llib->edito != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_edit");
                $tpl->set("EDITO", $this->llib->edito);
                $tpl->imprimir();               
            }
            if ($this->llib->anyPu != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_anyp");
                $tpl->set("ANY_P", $this->llib->anyPu);
                $tpl->imprimir();               
            }
            if ($this->llib->anyEd != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_anye");
                $tpl->set("ANY_E", $this->llib->anyEd);
                $tpl->imprimir();               
            }
            if ($this->llib->idiom->nom != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_idio");
                $tpl->set("IDIOM", $this->llib->idiom->nom);
                $tpl->imprimir();               
            }
            if (($this->llib->llocC != "") and ($this->llib->dataC != "")) {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_comp");
                $tpl->set("LLOCC", $this->llib->llocC);
                $tpl->set("DATAC", data_catala($this->llib->dataC));
                $tpl->imprimir();               
            }
            if ($this->llib->nisbn != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_isbn");
                $tpl->set("ISBNN", $this->llib->nisbn);
                $tpl->imprimir();               
            }            
            if ($this->llib->descr != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_desc");
                $tpl->set("DESCR", $this->llib->descr);
                $tpl->imprimir();               
            }             
            $tpl->carregar("llibres");
            $tpl->mostrar("llibre_1");
            $tpl->set("MODIF", $this->llib->dataM);
            $tpl->imprimir();

            if ((count($this->crit) != 0)  and ($this->crit[1] != "")) {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_crit");
                $tpl->set("CRITI", $this->crit[1]);
                $tpl->set("MODCR", $this->crit[2]);
                $tpl->imprimir();
            }
                
        }
    }
}