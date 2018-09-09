<?php
// 27-08-2018
// alex
// modllibres.php

class LlocModllibres {
    public $nomweb = "llibres";
    public $menu = "categories";
    public $permisos = 2;
    public $molles = array();
    //public $jsc_cap = array("autocomp_autors.js", "data_compra.js", "afegir_autor.js", "subcat.js");
    public $jsc_cap = array("autocomp_autors.js", "afegir_autor.js", "subcat.js");
    public $jsc_peu = array();
    public $css = array();
    
    public $alert = 0;
    public $llib;
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
            if (Peticio::exis("afegir")) {
                $llib = new Llibre();
                $llib->nom = trim(Peticio::obte("nom"));
                if ($llib->nom == "")
                    $this->alert = 1;
                else {
                    $llib->edito = Peticio::obte("edit");
                    $llib->nisbn = Peticio::obte("isbn");
                    $llib->dataC = Peticio::obte("data");
                    $llib->llocC = Peticio::obte("lloc_c");
                    $llib->descr = Peticio::obte("desc");
                    $llib->dataM = date("Y-m-d H:i:s");
                    if (trim(Peticio::obte("any")) != "")
                        $llib->anyPu = intval(trim(Peticio::obte("any")));
                    if (trim(Peticio::obte("anye")) != "")
                        $llib->anyEd = intval(trim(Peticio::obte("anye")));
                    if (trim(Peticio::obte("pagi")) != "")
                        $llib->numpg = intval(trim(Peticio::obte("pagi")));                    
                }
                if ($this->alert == 0) {
                    $vec_autors = Peticio::obte("autor");
                    if (count($vec_autors) == 0)
                        $this->alert = 2;
                    else {
                        for ($i = 0; $i < count($vec_autors); $i++)
                            $vec_autors[$i] = explode(" ", $vec_autors[$i])[0];
                        $llib->autor->agafPerCod($vec_autors[0]);
                        for ($i = 1; $i < count($vec_autors); $i++) {
                            $cod_rep = 0;
                            if ($vec_autors[0] == $vec_autors[$i])
                                $cod_rep = 1;
                            else {
                                for ($j = 0; $j < count($llib->autSe); $j++) {
                                    $cod_rep = $cod_rep + ($llib->autSe[$j]->codi == $vec_autors[$i]);
                                }
                                $j = 0;
                            }
                            if ($cod_rep == 0) {
                                $secund = new Autora();
                                $secund->agafPerCod($vec_autors[$i]);
                                $llib->autSe[] = $secund;
                            }
                        }
                    }
                }
                if ($this->alert == 0)
                    if (!$llib->categ->agafPerCod(Peticio::obte("subsubcat")))
                        $this->alert = 3;

                if ($this->alert == 0) 
                    if (!$llib->idiom->agafPerId(intval(Peticio::obte("idio"))))
                        $this->alert = 4;

                if ($this->alert == 0) 
                    if (!$llib->propi->agafPerId(intval(Usuari::idusuari())))
                        $this->alert = 5;
                
                if ($this->alert == 0) {
                    $vec_puj = $_FILES["foto"];
                    $err = 0;
                    if ((trim($vec_puj["name"]) != "") and ($vec_puj["error"] == 0))
                        $err = $llib->desar($vec_puj);
                    else
                        $err = $llib->desar();
                    if ($err)
                        $this->alert = 6;
                    else
                        $this->alert = 7;
                    $this->llib = $llib;
                }
            }
        }
        else if ($this->mod == 1) {
            $this->idiomes = BaseDades::consVector(Consulta::idiomes());
            $vec_categ = BaseDades::consVector(Consulta::categories_completes());
            for ($i = 0; $i < count($vec_categ); $i++)
                $this->categ[] = array($vec_categ[$i][0], $vec_categ[$i][0] . " - " . $vec_categ[$i][1]);
            $pro = Peticio::obte("propi");
            $cla = Peticio::obte("class");
            $aut = Peticio::obte("autor");
            $num = Peticio::obte("num_l");
            $this->llib = new Llibre();
            if ((preg_match("/^[a-z]{2}$/", $pro)) and (preg_match("/^[0-9]{3}$/", $cla)) and (preg_match("/^[A-Z0-9]{3,5}$/", $aut)) and (preg_match("/^[0-9]{3}$/", $num)))
                $this->llib->agafPerEt($pro, $cla, $aut, $num);
            if ($this->llib->id != -1) {

            }
            else
                redireccionar(Link::url("categories"));
        }
    }

    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {
            $tpl->carregar("afllibres");
            $tpl->mostrar("form_afegir_0");
            $tpl->set("ACTION", Link::url("afegir-llibres"));
            $tpl->imprimir();

            $tpl->carregar("afllibres");
            $tpl->setMatriu("cat_el", array("CAT_COD", "CAT_NOM"), $this->categ);
            $tpl->mostrar("cat_desp");
            $tpl->imprimir();

            $tpl->carregarMostrar("afllibres", "form_afegir_1");

            $tpl->carregar("afllibres");
            $tpl->setMatriu("idi_el", array("IDI_COD", "IDI_NOM"), $this->idiomes);
            $tpl->mostrar("idi_desp");
            $tpl->imprimir();
            
            $tpl->carregar("afllibres");
            $tpl->mostrar("form_afegir_2");
            $tpl->set("TORNAR", Link::url("index")); // canviar a menu de configuració
            $tpl->imprimir();
            
            if ($this->alert != 0)
                $tpl->carregarMostrar("afllibres", "ale_" . $this->alert);
        }

        if ($this->mod == 1) {
            $tpl->carregar("edllibres");
            $tpl->mostrar("form_editar_0");
            $tpl->set("ACTION", Link::url("afegir-llibres"));
            $tpl->set("NOMLL", $this->llib->nom); 
            $tpl->imprimir();

            $tpl->carregar("edllibres");
            $tpl->setMatriu("cat_el", array("CAT_COD", "CAT_NOM"), $this->categ);
            $tpl->mostrar("cat_desp");
            $tpl->imprimir();

            $tpl->carregarMostrar("edllibres", "form_editar_1");

            $tpl->carregar("edllibres");
            $tpl->setMatriu("idi_el", array("IDI_COD", "IDI_NOM"), $this->idiomes);
            $tpl->mostrar("idi_desp");
            $tpl->imprimir();
            
            $tpl->carregar("edllibres");
            $tpl->mostrar("form_editar_2");
            $tpl->set("EDITO", $this->llib->edito); 
            $tpl->set("NISBN", $this->llib->nisbn); 
            $tpl->set("ANYPU", $this->llib->anyPu); 
            $tpl->set("ANYED", $this->llib->anyEd); 
            $tpl->set("DATAC", $this->llib->dataC); 
            $tpl->set("LLOCC", $this->llib->llocC); 
            $tpl->set("NPAGI", $this->llib->numpg); 
            $tpl->set("DESCR", $this->llib->descr); 
            $tpl->set("TORNAR", Link::url("index")); // canviar a menu de configuració
            $tpl->imprimir();
        }
        
        Peticio::impr();
        imprVec($this->llib);
    }

}