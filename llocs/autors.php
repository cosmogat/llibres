<?php
// 04-01-2018
// alex
// autors.php

class LlocAutors {
    public $nomweb = "llibres | Navegació per autors";
    public $menu = "autors";
    public $permisos = 10;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array("lightbox.js");
    public $css = array();
    
    public $tipus = 0;
    public $llib = array();
    public $autor = array();
    
    public function calculs() {
        $codi = "";
        if (Peticio::exis("aut")) {
            $codi = Peticio::obte("aut");
            $long = strlen($codi);
            if (($long == 1) and preg_match("/^[A-Z]{1}$/", $codi))
                $this->tipus = 1;
            else if (($long == 3) and preg_match("/^[A-Z]{3}$/", $codi))
                $this->tipus = 2;
            else if (($long == 5) and (preg_match("/^[A-Z]{3}$/", substr($codi, 0, 3))) and (preg_match("/^[0-9]{2}$/", substr($codi, 3, 5))))
                $this->tipus = 2;
            else
                redireccionar(Link::url("autors"));
                
        }
        
        $this->molles[] = array(Link::url("index"), icona_bootstrap("home"));
        if ($this->tipus == 0) {
            $this->llib = Basedades::consVector(Consulta::autors0());
            $this->molles[] = array(Link::url("autors"), "Autors");
           
        }
        else if ($this->tipus == 1) {
            $this->llib = Basedades::consVector(Consulta::autors1($codi));
            $this->molles[] = array(Link::url("autors"), "Autors");
            $this->molles[] = array(Link::url("autors", $codi), $codi);
           
        }
        else if ($this->tipus == 2) {
            $this->llib = Basedades::consVector(Consulta::autors2($codi));
            $this->autor = Basedades::consVector(Consulta::autor($codi))[0];
            $this->molles[] = array(Link::url("autors"), "Autors");
            $this->molles[] = array(Link::url("autors", $codi[0]), $codi[0]);
            $this->molles[] = array(Link::url("autors", $codi), $codi . " - " . $this->autor[1]);
            $this->nomweb = "llibres | " . $this->autor[1];
        }
        
        if (count($this->llib) == 0)
            redireccionar(Link::url("autors"));
    }
    
    public function imprimir() {
        $tpl = new Plantilla("./html");

        if ($this->tipus == 0) {
            $tpl->carregar("autors");
            $tpl->mostrar("autor_cap");
            $tpl->set("TITOL", "Autors");    
            $tpl->imprimir();
            foreach ($this->llib as $valor) {
                $tpl->carregar("autors");
                $tpl->mostrar("link");
                $tpl->set("LINK", Link::url("autors", $valor[0]));
                $tpl->set("TEXT", $valor[0]);
                $tpl->imprimir();
            }
            $tpl->carregarMostrar("autors", "autor_peus");
        }
        else if ($this->tipus == 1) {
            $tpl->carregar("autors");
            $tpl->mostrar("autor_cap");
            $tpl->set("TITOL", "Autors de la lletra " . $this->llib[0][2][0]);
            $tpl->imprimir();
            foreach ($this->llib as $valor) {
                $tpl->carregar("autors");
                if ($valor[3]) {
                    $tpl->mostrar("link");
                    $tpl->set("LINK", Link::url("autors", $valor[2]));
                }
                else
                    $tpl->mostrar("no_link");
                $tpl->set("TEXT", $valor[2] . " - " . $valor[1]);
                $tpl->imprimir();
            }
            $tpl->carregarMostrar("autors", "autor_peus");
        }
        else if ($this->tipus == 2) {
            $tpl->carregar("autors");
            if (($this->autor[3] != "") and ($this->autor[4] != ""))
                $tpl->mostrar("autor_0");
            else if (($this->autor[3] == "") and ($this->autor[4] != ""))
                $tpl->mostrar("autor_1");
            else if (($this->autor[3] != "") and ($this->autor[4] == ""))
                $tpl->mostrar("autor_2");
            else
                $tpl->mostrar("autor_3");           
            $tpl->set("AUTOR", $this->autor[1]);            
            $tpl->set("IMATG", Link::img("autors/" . $this->autor[3]));
            $tpl->set("DESCR", $this->autor[4]);
            $tpl->set("NUM_L", count($this->llib));
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
    }
}