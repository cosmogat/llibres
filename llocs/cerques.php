<?php
// 28-12-2017
// billy
// cerques.php

class LlocCerques {
    public $nomweb = "llibres | cerques";
    public $menu = "cerques";
    public $permisos = 10;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();
    
    public $estat = 0;
    public $text = "";
    public $llib = array();

    public function calculs() {
        if (Peticio::exis("cercar")) {
            $txt = trim(Peticio::obte("txt_cerca"));
            if (!empty($txt)) {
                if (cadValid($txt)) {
                    $this->estat = 3;
                    $this->text = $txt;
                    $this->llib = BaseDades::consVector(Consulta::cercarLlibres($this->text));
                    if (count($this->llib) == 0)
                        $this->estat = 4;
                }
                else
                    $this->estat = 2;
            }
            else
                $this->estat = 1;

        }
        $this->molles[] = array(Link::url("index"), icona_bootstrap("home"));
        $this->molles[] = array(Link::url("cerques"), icona_bootstrap("search"). "&nbsp;Cerques");
        if ($this->text != "")
            $this->molles[] = array("", $this->text);
    }
    public function imprimir() {
        $tpl = new Plantilla("./html");
         
        $tpl->carregar("cerques");
        $tpl->mostrar("barra");
        $tpl->set("ACTION", Link::url("cerques"));
        $tpl->set("CERCA_ANT", $this->text);
        $tpl->imprimir();


        
        if ($this->estat == 1) {
            $tpl->carregarMostrar("cerques", "estat1");
        }
        else if ($this->estat == 2) {
            $tpl->carregarMostrar("cerques", "estat2");
        }
        else if ($this->estat == 3) {
            $tpl->carregar("cerques");
            $tpl->mostrar("estat3");
            $tpl->set("NUM", count($this->llib));
            $tpl->imprimir();

            $tpl->carregarMostrar("cerques", "llibre_ini");
            foreach ($this->llib as $val) {
                $tpl->carregar("cerques");
                $tpl->mostrar("llibre_res");
                /* if ($val[15] == true) */
                /*     $tpl->set("TIPUS", "list-group-item-danger"); */
                /* else if ($val[14] == true) */
                /*     $tpl->set("TIPUS", "list-group-item-warning"); */
                /* else if ($val[16] == true) */
                /*     $tpl->set("TIPUS", "list-group-item-success"); */
                $tpl->set("LINK", Link::url("llibres", $val[13] . "-" . $val[0] . $val[2] . $val[4] . "-" . $val[6]. "-" . sprintf("%03d", $val[7])));
                $tpl->set("TITOL", $val[8]);
                $tpl->set("IMG", Link::img("llibres/" . $val[9]));
                $tpl->set("AUTOR", $val[10]);
                if ($val[11] != "")
                    $tpl->set("ANY", ", " . $val[11]);
                else
                    $tpl->set("ANY", "");
                $descr = descripcio($val[12]);               
                $tpl->set("DESCR1", $descr[0]);
                $tpl->set("DESCR2", $descr[1]);
                $tpl->imprimir();
            }
            $tpl->carregarMostrar("cerques", "llibre_fi");
            
        }
        else if ($this->estat == 4) {
            $tpl->carregarMostrar("cerques", "estat4");
        }
        
    }
}