<?php
// 28-12-2017
// billy
// fnc.inc.php

function connexio_valida() {
    $tipus = Registre::lleg("conne");
    $igual = Registre::lleg("adr_r") == Registre::lleg("adr_s");
    $local = substr(Registre::lleg("adr_r"), 0, 10) == "192.168.0.";
    if (($tipus == 0) and $igual)
        return true;
    else if (($tipus == 1) and ($local or $igual))
        return true;
    else if ($tipus == 2)
        return true;
    return false;
}

function generarEtiqueta($nom) {
    $vector = explode(" ", $nom);
    $prova = "e00";
    // Tres primeres lletres de la segona paraula
    if ((sizeof($vector) > 1) and (strlen($vector[1]) > 2)) {
        $prova = strtoupper(substr($vector[1], 0, 3));
        if (preg_match("/^[A-Z]{3}$/", $prova))
            if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
                return $prova;
    }
    // Primera lletra de la primera paraula + dos primeres lletres de la segona paraula
    if ((sizeof($vector) > 1) and (strlen($vector[1]) > 2)) {
        $prova = strtoupper(substr($vector[0], 0, 1)) . strtoupper(substr($vector[1], 0, 2));
        if (preg_match("/^[A-Z]{3}$/", $prova))
            if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
                return $prova;
    }
    // Tres primeres lletres de l'última paraula
    if ((sizeof($vector) > 0) and (strlen($vector[sizeof($vector) - 1]) > 2)) {
        $prova = strtoupper(substr($vector[sizeof($vector) - 1], 0, 3));
        if (preg_match("/^[A-Z]{3}$/", $prova))
            if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0) 
                return $prova;
    }
    // Dos primeres lletres de la primera paraula + primera lletra de la segona paraula
    if ((sizeof($vector) > 1) and (strlen($vector[0]) > 2)) {
        $prova = strtoupper(substr($vector[0], 0, 2)) . strtoupper(substr($vector[1], 0, 1));
        if (preg_match("/^[A-Z]{3}$/", $prova))
            if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0)
                return $prova;
    }
    // Primera lletra de les tres primeres paraules
    if (sizeof($vector) > 2) {
        $prova = strtoupper($vector[0][0] . $vector[1][0] . $vector[2][0]);
        if (preg_match("/^[A-Z]{3}$/", $prova))
            if (BaseDades::consVector(Consulta::exisAutor_perCodi($prova))[0][0] == 0) 
                return $prova;
    }
    // Amb números
    if ((sizeof($vector) > 0) and (strlen($vector[sizeof($vector) - 1]) > 2))
        $prova = strtoupper(substr($vector[sizeof($vector) - 1], 0, 3));
    else 
        $prova = "AAA";
    if (!preg_match("/^[A-Z]{3}$/", $prova))
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

function pujarFoto($vec_info, $id, $tipus, &$nom_desti) {
    $ext = "";
    if ($vec_info["type"] == "image/jpeg")
        $ext = "jpg";
    else if ($vec_info["type"] == "image/png")
        $ext = "png";
    else if ($vec_info["type"] == "image/svg+xml")
        $ext = "svg";
    else
        return 0;
    if (($vec_info["size"] > 10485760) or ($vec_info["size"] < 10) or (!is_uploaded_file($vec_info['tmp_name'])))
        return 0;
    $nom_desti = $id . "." . $ext;
    $ruta_desti = Registre::lleg("direc") . "/img/" . ($tipus == 0 ? "autors" : "llibres") . "/" . $nom_desti;
    $sql = "";
    if ($tipus == 0)
        $sql = Consulta::canvAutorFoto($id, $nom_desti);
    else
        $sql = Consulta::canvLlibreFoto($id, $nom_desti);
    if (move_uploaded_file($vec_info["tmp_name"], $ruta_desti)) {
        if (BaseDades::consulta($sql))
            return 1;
    }
    return 0;
}

function eliminarFoto($nom_fitxer, $tipus) {
    $ruta_desti = Registre::lleg("direc") . "/img/" . ($tipus == 0 ? "autors" : "llibres") . "/" . $nom_fitxer;
    return unlink($ruta_desti);
}