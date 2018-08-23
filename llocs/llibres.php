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
    
    public $llib = array();
    public $cod_aut = "";
    public $crit = array();
    
    public function calculs() {
        $pro = Peticio::obte("propi");
        $cla = Peticio::obte("class");
        $aut = Peticio::obte("autor");
        $num = Peticio::obte("num_l");
        if ((preg_match("/^[a-z]{2}$/", $pro)) and (preg_match("/^[0-9]{3}$/", $cla)) and (preg_match("/^[A-Z0-9]{3,5}$/", $aut)) and (preg_match("/^[0-9]{3}$/", $num))) {
            $this->cod_aut = $aut;
            $v = BaseDades::consVector(Consulta::llibre_perEtiqueta($pro, $cla, $aut, $num))[0];
            if (count($v) != 0)
                array_push($this->llib, $pro . "-" . $cla . "-" . $aut . "-" . $num, $v[0], $v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $v[10], $v[11], $v[12], $v[13], $v[14], $v[15]);
            for ($ind = 0; $ind < count($this->llib); $ind++)
                $this->llib[$ind] = descodCad($this->llib[$ind]);
        }
        
        if (count($this->llib) > 0) {
            $this->nomweb = $this->nomweb . $this->llib[5] . " - " . $this->llib[7];
            $id_us = Usuari::idusuari();
            if ($id_us != -1)
                $this->crit = descodCad(BaseDades::consVector(Consulta::critiques($id_us, $this->llib[4]))[0]);
            $this->molles[] = array(Link::url("index"), icona_bootstrap("home"));
            $this->molles[] = array(Link::url("categories"), "Categories");
            for ($i = 1; $i <= 3; $i++)
                $this->molles[] = array(Link::url("categories", substr($this->llib[0], 3, $i)), $this->llib[$i]);
            $this->molles[] = array("", $this->llib[5]);
        }
        else
            redireccionar(Link::url("categories"));
        
    }
    public function imprimir() {
        if (count($this->llib) > 0) {            
            $tpl = new Plantilla("./html");
            
            $tpl->carregar("llibres");
            $tpl->mostrar("llibre_0");
            $tpl->set("TITOL", $this->llib[5]);
            $tpl->set("IMATG", Link::img("llibres/" . $this->llib[6]));
            $tpl->set("LNK_A", Link::url("autors", $this->cod_aut));
            $tpl->set("AUTOR", $this->llib[7]);
            $tpl->set("ETIQU", $this->llib[0]);
            $tpl->imprimir();
            if ($this->llib[10] != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_edit");
                $tpl->set("EDITO", $this->llib[10]);
                $tpl->imprimir();               
            }
            if ($this->llib[12] != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_anyp");
                $tpl->set("ANY_P", $this->llib[12]);
                $tpl->imprimir();               
            }
            if ($this->llib[11] != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_anye");
                $tpl->set("ANY_E", $this->llib[11]);
                $tpl->imprimir();               
            }
            if ($this->llib[9] != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_idio");
                $tpl->set("IDIOM", $this->llib[9]);
                $tpl->imprimir();               
            }
            if (($this->llib[13] != "") and ($this->llib[14] != "")) {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_comp");
                $tpl->set("LLOCC", $this->llib[14]);
                $tpl->set("DATAC", data_catala($this->llib[13]));
                $tpl->imprimir();               
            }
            if ($this->llib[8] != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_isbn");
                $tpl->set("ISBNN", $this->llib[8]);
                $tpl->imprimir();               
            }            
            if ($this->llib[15] != "") {
                $tpl->carregar("llibres");
                $tpl->mostrar("llibre_desc");
                $tpl->set("DESCR", $this->llib[15]);
                $tpl->imprimir();               
            }             
            $tpl->carregar("llibres");
            $tpl->mostrar("llibre_1");
            $tpl->set("MODIF", $this->llib[16]);
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