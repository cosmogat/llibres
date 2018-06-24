<?php
// 28-12-2017
// billy
// fun.inc.php

function quinPerfil() {
  $descr = fopen("cnf/quinperfil.txt", "r");
  $estem = fread($descr, 1);
  if (!preg_match("/^[a-zA-Z0-9]$/", $estem))
    $estem = "0";
  fclose($descr);
  return $estem;
}

function cadValid($cad) {
    if (strpos($cad, "../") !== false)
        return false;
    $permesos = "ABCÇDEFGHIJKLMNÑOPQRSTUVWXYZÁÀÄÉÈËÍÌÏÓÒÖÚÙÜabcçdefghijklmnñopqrstuvwxyzáàäéèëíìïóòöúùü0123456789?._-,:/\\ ";
    for ($i = 0; $i < strlen($cad); $i++)
        if (strpos($permesos, substr($cad, $i, 1)) === false)
            return false;
    return true;
}

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

function redireccionar($url) {
    header("Location: " . $url);
}

function icona_bootstrap($icona) {
    return "<span class='glyphicon glyphicon-" . $icona . "' aria-hidden='true'></span>";
}

function descripcio($cadena) {
    $vec = array();
    $max1 = 940;
    $max2 = 300;
    $text = $cadena;
    $text1 = "";
    $text2 = "";
    $tam = strlen($text);
    if ($tam > $max1) {
        $text = substr($text, 0, $max1 + 1);
        $i = $max1;
        while ($i > 0 and $text[$i] != ".")
            $i--;
        $text = substr($text, 0, $i + 1);
    }
    $tam = strlen($text);
    if ($tam > $max2) {
        $i = $max2;
        while ($i > 0 and $text[$i] != ".")
            $i--;
        $text1 = substr($text, 0, $i + 1);
        $text2 = substr($text, $i + 1, $tam);
    }
    if ($text2 == "")
        $vec = array($text, "");
    else
        $vec = array($text1 , $text2);
    return $vec;
}

function data_catala($data) {
    $ret = "";
    $data_obj = new DateTime($data);
    $segons = date_format($data_obj, 'U') + 10;
    $dia_set = date('w', $segons);
    if ($dia_set == 0)
        $ret = "diumenge";
    else if ($dia_set == 1)
        $ret = "dilluns";
    else if ($dia_set == 2)
        $ret = "dimarts";
    else if ($dia_set == 3)
        $ret = "dimecres";
    else if ($dia_set == 4)
        $ret = "dijous";
    else if ($dia_set == 5)
        $ret = "divendres";
    else if ($dia_set == 6)
        $ret = "dissabte";
    $ret = $ret . " " . date('j', $segons);
    $mes = date('n', $segons);
    if ($mes == 1)
        $ret = $ret . " de gener";
    else if ($mes == 2)
        $ret = $ret . " de febrer";
    else if ($mes == 3)
        $ret = $ret . " de març";
    else if ($mes == 4)
        $ret = $ret . " d'abril";
    else if ($mes == 5)
        $ret = $ret . " de maig";
    else if ($mes == 6)
        $ret = $ret . " de juny";
    else if ($mes == 7)
        $ret = $ret . " de juliol";
    else if ($mes == 8)
        $ret = $ret . " d'agost";
    else if ($mes == 9)
        $ret = $ret . " de setembre";
    else if ($mes == 10)
        $ret = $ret . " d'octubre";
    else if ($mes == 11)
        $ret = $ret . " de novembre";
    else if ($mes == 12)
        $ret = $ret . " de desembre";
    $ret = $ret . " de " . date('Y', $segons);
    return $ret;
}

function imprVec($vec) {
    echo "<pre>";
    print_r($vec);
    echo "</pre>";
}