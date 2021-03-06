<?php
// 28-08-2018
// cosmogat
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
    $permesos = "ABCÇDEFGHIJKLMNÑOPQRSTUVWXYZÁÀÄÉÈËÍÌÏÓÒÖÚÙÜabcçdefghijklmnñopqrstuvwxyzáàäéèëíìïóòöúùü0123456789?.·_-,:/\\ ";
    for ($i = 0; $i < strlen($cad); $i++)
        if (strpos($permesos, substr($cad, $i, 1)) === false)
            return false;
    return true;
}

function codiValid($codi) {
    if (strlen($codi) == 3)
        return preg_match("/^[A-Z]{3}$/", $codi);
    else if (strlen($codi) == 5) {
        $part1 = $codi[0] . $codi[1] . $codi[2];
        $part2 = $codi[3] . $codi[4];
        return (preg_match("/^[A-Z]{3}$/", $part1)) and (preg_match("/^[0-9]{2}$/", $part2));
    }
    return false;
}

function codCad($cad) {
    $orig = array("'", "\"", "@", "(", ")","&", "¡", "!", "¿", "\$", "€", "%",  ";", "º", "ª", "·", "<br />", "<li>", "<ol>", "<ul>", "</li>", "</ol>", "</ul>", "<strong>", "<em>", "<del>", "</strong>", "</em>", "</del>");
    $nous = array(":_c_:", ":_cc_:", ":_a_:", ":_po_:", ":_pt_:", ":_am_:", ":_eo_:", ":_et_:", ":_io_:", ":_d_:", ":_e_:", ":_1_:", ":_pc_:", ":_oo_:", ":_aa_:", ":_p_:", ":_br_:", ":_li_:", ":_ol_:", ":_ul_:", ":_/li_:", ":_/ol_:", ":_/ul_:", ":_st_:", ":_em_:", ":_de_:", ":_/st_:", ":_/em_:", ":_/de_:");
    return str_replace($orig, $nous, $cad);
}

function descodCad($cad) {
    $orig = array("'", "\"", "@", "(", ")","&", "¡", "!", "¿", "\$", "€", "%",  ";", "º", "ª", "·", "<br />", "<li>", "<ol>", "<ul>", "</li>", "</ol>", "</ul>", "<strong>", "<em>", "<del>", "</strong>", "</em>", "</del>");
    $nous = array(":_c_:", ":_cc_:", ":_a_:", ":_po_:", ":_pt_:", ":_am_:", ":_eo_:", ":_et_:", ":_io_:", ":_d_:", ":_e_:", ":_1_:", ":_pc_:", ":_oo_:", ":_aa_:", ":_p_:", ":_br_:", ":_li_:", ":_ol_:", ":_ul_:", ":_/li_:", ":_/ol_:", ":_/ul_:", ":_st_:", ":_em_:", ":_de_:", ":_/st_:", ":_/em_:", ":_/de_:");
    return str_replace($nous, $orig, $cad);
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