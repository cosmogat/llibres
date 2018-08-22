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
            if ($this->alert == 0) {
                if (!BaseDades::consulta(Consulta::insertAutor($codi_autor, $nom, $colleccio, $des)))
                    $this->alert = 5;
            }

            
            $vec_puj = $_FILES["foto"];
            /* if ((trim($vec_puj["name"]) != "") and ($vec_puj["name"] == 0)) */
            /*     echo "si"; */
            /* else */
            /*     echo "no"; */
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

function generarEtiqueta($nom) {
    $vector = explode(" ", $nom);
    // Tres primeres lletres de la segona paraula
    if ((sizeof($vector) > 1) and (strlen($vector[1]) > 2)) {
        $prova = strtoupper(substr($vector[1], 0, 3));
        if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
            return $prova;
    }
    // Primera lletra de la primera paraula + dos primeres lletres de la segona paraula
    if ((sizeof($vector) > 1) and (strlen($vector[1]) > 2)) {
        $prova = strtoupper(substr($vector[0], 0, 1)) . strtoupper(substr($vector[1], 0, 2));
        if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
            return $prova;
    }
    // Tres primeres lletres de l'última paraula
    if ((sizeof($vector) > 0) and (strlen($vector[sizeof($vector) - 1]) > 2)) {
        $prova = strtoupper(substr($vector[sizeof($vector) - 1], 0, 3));
        if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
            return $prova;
    }
    // Dos primeres lletres de la primera paraula + primera lletra de la segona paraula
    if ((sizeof($vector) > 0) and (strlen($vector[0]) > 2)) {
        $prova = strtoupper(substr($vector[0], 0, 2)) . strtoupper(substr($vector[1], 0, 1));
        if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
            return $prova;
    }
    // Primera lletra de les tres primeres paraules
    if (sizeof($vector) > 2) {
        $prova = strtoupper($vector[0][0] . $vector[1][0] . $vector[2][0]);
        if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
            return $prova;
    }
    // Amb números
    if ((sizeof($vector) > 0) and (strlen($vector[sizeof($vector) - 1]) > 2))
        $prova = strtoupper(substr($vector[sizeof($vector) - 1], 0, 3));
    else 
        $prova = "AAA";
    $num = 0;
    $num_cad = sprintf("%02d", $num);
    $nom = $prova;
    $prova = $nom . $num_cad;
    while ((BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] != 0) and ($num < 100)) {
        $num++;
        $num_cad = sprintf("%02d", $num);
        $prova = $nom . $num_cad;
    }
    if ($num < 100)
        return $prova;
    // error
    return "e00";
}