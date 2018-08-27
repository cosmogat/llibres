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
    public $autor = array();
    
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
            $nom = codCad(ucwords(Peticio::obte("nom")));
            $des = codCad(Peticio::obte("desc"));
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
                if ((trim($vec_puj["name"]) != "") and ($vec_puj["error"] == 0)) {
                    $id_escr = BaseDades::consVector(Consulta::idautor_perCodi($codi_autor))[0][0];
                    $err_foto = pujarFoto($vec_puj, $id_escr, 0);
                    $this->alert = abs($err_foto - 8);
                }
                else
                    $this->alert = 6;
            }
        }
        if ($this->mod == 1) {
            $codi_vell = Peticio::obte("cat");
            $vector = BaseDades::consVector(Consulta::autor($codi_vell));
            if (count($vector) > 0) {
                $this->autor = $vector[0];
                $this->autor[1] = descodCad($this->autor[1]);
                $this->autor[4] = descodCad($this->autor[4]);
                if (Peticio::exis("afegir")) {
                    $nom = codCad(ucwords(Peticio::obte("nom")));
                    $des = codCad(Peticio::obte("desc"));
                    $colleccio = 0;
                    $codi_nou = Peticio::obte("cod");
                    $id_escr = BaseDades::consVector(Consulta::idautor_perCodi($codi_vell))[0][0];
                    if (Peticio::exis("col"))
                        $colleccio = 1;            
                    if (!cadValid($nom) or trim($nom) == "")
                        $this->alert = 1;
                    else if (!cadValid($des))
                        $this->alert = 2;
                    else if (!codiValid($codi_nou))
                        $this->alert = 14;
                    if ($this->alert == 0) {
                        $exis_nom = BaseDades::consVector(Consulta::exisAutor_perNom($nom));
                        if (($exis_nom[0][0] != 0) and ($nom != codCad($this->autor[1])))
                            $this->alert = 3;
                        else if ($codi_vell != $codi_nou) {
                            $exis_codi = BaseDades::consVector(Consulta::exisAutor_perCodi($codi_nou));
                            if ($exis_codi[0][0] != 0)
                                $this->alert = 15;
                        }
                    }
                    if ($this->alert == 0) {
                        if (!BaseDades::consulta(Consulta::editAutor($id_escr, $codi_nou, $nom, $colleccio, $des)))
                            $this->alert = 5;                   
                    }
                    if ($this->alert == 0) {
                        $vec_puj = $_FILES["foto"];
                        if ((trim($vec_puj["name"]) != "") and ($vec_puj["error"] == 0)) {
                            $err_foto = pujarFoto($vec_puj, $id_escr, 0);
                            $this->alert = abs($err_foto - 8);
                            if ($err_foto == 1) {
                                //eliminarFoto($this->autor[3], 0);
                            }
                        }
                    }
                    if ($this->alert == 0)
                        redireccionar(Link::url("ed-autors", $codi_nou));
                }
            }
            else
                redireccionar(Link::url("index"));
        }
    }

    public function imprimir() {
        $tpl = new Plantilla("./html");
        if ($this->mod == 0) {
            $tpl->carregar("modautors");
            $tpl->mostrar("form_afegir");
            $tpl->set("ACTION", Link::url(Peticio::obte("op"). "-autors", Peticio::obte("cat")));
            $tpl->set("TORNAR", Link::url("index")); // canviar a menu de configuració
            $tpl->imprimir();
        }
        else if ($this->mod == 1) {
            $tpl->carregar("modautors");
            $tpl->mostrar("form_editar");
            $tpl->set("ACTION", Link::url(Peticio::obte("op"). "-autors", Peticio::obte("cat")));
            $tpl->set("NOM", $this->autor[1]);
            $tpl->set("CODI", $this->autor[2]);
            $tpl->set("COL", $this->autor[5] == 0 ? "" : "checked");
            $tpl->set("DESC", $this->autor[4]);
            $tpl->set("TORNAR", Link::url("autors", Peticio::obte("cat")));
            $tpl->imprimir();
        }
        if ($this->alert != 0)
            $tpl->carregarMostrar("modautors", "ale_" . $this->alert);
    }
}
