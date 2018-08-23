<?php
// 22-08-2018
// alex
// modautors.php

class LlocModautors {
    public $nomweb = "llibres";
    public $menu = "autors";
    public $permisos = 2;
    public $molles = array();
    public $jsc_cap = array();
    public $jsc_peu = array();
    public $css = array();
    
    public $alert = 0;

    public function calculs() {
        $opc = Peticio::obte("op");
        if ($opc == "af") {
            $this->mod = 0;
            if (Peticio::obte("cat") != "AAA00")
                redireccionar(Link::url("af-autors", "AAA00")); 
        }
        else if ($opc == "ed")
            $this->mod = 1;
        else if ($opc == "el")
            $this->mod = 2;
        else
            redireccionar(Link::url("index"));

        if (($this->mod == 0)  and (Peticio::exis("afegir"))) {
            $nom = ucwords(Peticio::obte("nom"));
            $des = Peticio::obte("desc");
            $colleccio = 0;
            $codi_autor = "";
            if (Peticio::exis("col"))
                $colleccio = 1;            
            if (!cadValid($nom) or trim($nom) == "")
                $this->alert = 1;
            else if (!cadValid($des))
                $this->alert = 2;
            if ($this->alert == 0) {
                $exis_nom = BaseDades::consVector(Consulta::exisAutor_perNom($nom));
                if ($exis_nom[0][0] != 0)
                    $this->alert = 3;
                else {
                    $codi_autor = generarEtiqueta($nom);
                    if ($codi_autor == "e00")
                        $this->alert = 4;
                }
            }
            if ($this->alert == 0)
                if (!BaseDades::consulta(Consulta::insertAutor($codi_autor, $nom, $colleccio, $des)))
                    $this->alert = 5;

            if ($this->alert == 0) {
                $vec_puj = $_FILES["foto"];
                if ((trim($vec_puj["name"]) != "") and ($vec_puj["name"] == 0)) {
                    $id_escr = BaseDades::consVector(Consulta::idautor_perCodi($codi_autor))[0][0];
                    $err_foto = pujarFoto($vec_puj, $id_escr, 0);
                    $this->alert = abs($err_foto - 8);
                    /* if ($err_foto == 1) */
                    /*     $this->alert = 7; */
                    /* else if ($err_foto == 0) */
                    /*     $this->alert = 8; */
                    /* else if ($err_foto == -1) */
                    /*     $this->alert = 9; */
                }
                else
                    $this->alert = 6;
            }
        }
    }

    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {
            $tpl->carregar("modautors");
            $tpl->mostrar("form_afegir");
            $tpl->set("ACTION", Link::url(Peticio::obte("op"). "-autors", Peticio::obte("cat")));
            $tpl->set("ACCIO", "Afegir");
            $tpl->set("BOTO", "success");
            $tpl->imprimir();
        }
        if ($this->alert != 0)
            $tpl->carregarMostrar("modautors", "ale_" . $this->alert);
               
        Peticio::impr();
        imprVec($_FILES);
    }
}
