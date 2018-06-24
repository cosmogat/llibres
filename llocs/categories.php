<?php
// 29-12-2017
// billy
// categories.php

class LlocCategories {
    public $nomweb = "llibres | Navegació per categories";
    public $menu = "categories";
    public $permisos = 10;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();
    
    public $tipus = 0;
    public $codi;
    public $llib = array();

    public function calculs() {
        $this->codi = "";
        if (Peticio::exis("cat")) {
            $this->codi = Peticio::obte("cat");
            $this->tipus = strlen($this->codi);
        }
        if ($this->tipus == 0)
            $this->llib = BaseDades::consVector(Consulta::categories());
        else {
            if (preg_match("/^[0-9]{1,3}$/", $this->codi)) {
                if ($this->tipus == 1) {
                    $v = BaseDades::consVector(Consulta::class_perCodi($this->codi));
                    if (count($v) != 0) {
                        $tmp1 = array($v[0][0], $v[0][1]);
                        $tmp2 = array();
                        for ($i = 0; $i < count($v); $i++)
                            $tmp2[] = array($v[$i][0] . $v[$i][2], $v[$i][3], $v[$i][4]);
                        array_push($this->llib, $tmp1, $tmp2);
                    }
                }
                else if ($this->tipus == 2) {
                    $v = BaseDades::consVector(Consulta::subclass_perCodi($this->codi[0], $this->codi[1]));
                    if (count($v) != 0) {
                        $tmp1 = array($v[0][0], $v[0][1], $v[0][0] . $v[0][2], $v[0][3]);
                        $tmp2 = array();
                        for ($i = 0; $i < count($v); $i++)
                            $tmp2[] = array($v[$i][0] . $v[$i][2] . $v[$i][4], $v[$i][5], $v[$i][6]);
                        array_push($this->llib, $tmp1, $tmp2);
                    }
                }
                else if ($this->tipus == 3) {
                    $v = BaseDades::consVector(Consulta::subsubclass_perCodi($this->codi[0], $this->codi[1], $this->codi[2]));
                    if (count($v) != 0) {
                        $tmp1 = array($v[0][0], $v[0][1], $v[0][0] . $v[0][2], $v[0][3], $v[0][0] . $v[0][2] . $v[0][4], $v[0][5]);
                        $tmp2 = array();
                        for ($i = 0; $i < count($v); $i++)
                            $tmp2[] = array($v[$i][13] . "-" . $v[$i][0] . $v[$i][2] . $v[$i][4] . "-" . $v[$i][6]. "-" . sprintf("%03d", $v[$i][7]), $v[$i][8], $v[$i][9], $v[$i][10], $v[$i][11], $v[$i][12], $v[$i][14], $v[$i][15], $v[$i][16]);
                        array_push($this->llib, $tmp1, $tmp2);
                    }
                }   
            }
        }
        if (count($this->llib) == 0)
            redireccionar(Link::url("categories"));
        $this->molles[] = array(Link::url("index"), icona_bootstrap("home"));
        /* molles no actives */
        if ($this->tipus > 0)
            $this->molles[] = array(Link::url("categories"), "Categories");  
        if ($this->tipus > 1)
            $this->molles[] = array(Link::url("categories", $this->llib[0][0]), $this->llib[0][1]);
        if ($this->tipus > 2)
            $this->molles[] = array(Link::url("categories", $this->llib[0][2]), $this->llib[0][3]);
        /* molla activa */
        if ($this->tipus == 0)
            $this->molles[] = array("", "Categories");  
        else if ($this->tipus == 1)
            $this->molles[] = array("", $this->llib[0][1]);            
        else if ($this->tipus == 2)
            $this->molles[] = array("", $this->llib[0][3]);
        else if ($this->tipus == 3)
            $this->molles[] = array("", $this->llib[0][5]);
    }
    
    public function imprimir() {
        $tpl = new Plantilla("./html");
        $res = array();
        if ($this->tipus > 0)
            $res = $this->llib[1];
        else
            $res = $this->llib;

        if ($this->tipus < 3) {
            $tpl->carregar("categories");
            $tpl->mostrar("taula_cap_0");
            if ($this->tipus == 0)
                $tpl->set("TITOL", "Categories");
            else
                $tpl->set("TITOL", $this->llib[0][count($this->llib[0]) - 1]);            
            $tpl->imprimir();
            $tpl->carregarMostrar("categories", "taula_cap_1");
            for ($i = 0; $i < count($res); $i++) {
                $tpl->carregarMostrar("categories", "linia_0");
                $tpl->carregar("categories");
                $tpl->mostrar("linia_1");
                $tpl->set("CAT", $res[$i][0]);
                $tpl->imprimir();
                $tpl->carregar("categories");
                if ($res[$i][2] == 0)
                    $tpl->mostrar("linia_2");
                else {
                    $tpl->mostrar("linia_3");
                    $tpl->set("LNK", Link::url("categories", $res[$i][0]));
                }
                $tpl->set("NOM", $res[$i][1]);
                $tpl->imprimir();
                if (Usuari::permisos() <= 1) {
                    $tpl->carregarMostrar("categories", "linia_4");
                    if (($res[$i][2] < 10) and ($this->tipus < 2)) {
                        $tpl->carregar("categories");
                        $tpl->mostrar("linia_5");
                        $tpl->set("AFEL", Link::url("af-categories", $res[$i][0]));
                        $tpl->imprimir();
                    }
                    $tpl->carregar("categories");
                    $tpl->mostrar("linia_6");
                    $tpl->set("EDIL", Link::url("ed-categories", $res[$i][0]));
                    $tpl->imprimir();
                    if ($res[$i][2] == 0) {
                        $tpl->carregar("categories");
                        $tpl->mostrar("linia_7");
                        $tpl->set("ELIL", Link::url("el-categories", $res[$i][0]));
                        $tpl->imprimir();
                    }
                    $tpl->carregarMostrar("categories", "linia_8");
                }
                $tpl->carregarMostrar("categories", "linia_9");
            }
            $tpl->carregarMostrar("categories", "taula_peus");
        }
        else if ($this->tipus == 3) {
            $tpl->carregarMostrar("cerques", "llibre_ini");
            foreach ($res as $val) {
                $tpl->carregar("cerques");
                $tpl->mostrar("llibre_res");
                /* if ($val[7] == true) */
                /*     $tpl->set("TIPUS", "list-group-item-danger"); */
                /* else if ($val[6] == true) */
                /*     $tpl->set("TIPUS", "list-group-item-warning"); */
                /* else if ($val[8] == true) */
                /*     $tpl->set("TIPUS", "list-group-item-success"); */
                $tpl->set("LINK", Link::url("llibres", $val[0]));
                $tpl->set("TITOL", $val[1]);
                $tpl->set("IMG", Link::img("llibres/" . $val[2]));
                $tpl->set("AUTOR", $val[3]);
                if ($val[11] != "")
                    $tpl->set("ANY", ", " . $val[4]);
                else
                    $tpl->set("ANY", "");
                $descr = descripcio($val[5]);               
                $tpl->set("DESCR1", $descr[0]);
                $tpl->set("DESCR2", $descr[1]);
                $tpl->imprimir();
            }
            $tpl->carregarMostrar("cerques", "llibre_fi");  
        }
    }
}