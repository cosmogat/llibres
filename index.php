<?php
// 26-12-2017
// alex
// index.php
require_once("./inc/tpl.obj.php");
require_once("./inc/sql.obj.php");
require_once("./inc/reg.obj.php");
require_once("./inc/pet.obj.php");
require_once("./inc/ses.obj.php");
require_once("./inc/usu.obj.php");
require_once("./inc/lnk.obj.php");
require_once("./inc/con.obj.php");
require_once("./inc/fun.inc.php");
require_once("./cnf/conf_" . quinPerfil() . ".inc.php");
require_once("./cnf/menu.inc.php");

Sessio::iniciar();
Registre::netj();
Registre::afeg("bd_us", $conf["bd"]["user"]);
Registre::afeg("bd_co", $conf["bd"]["pass"]);
Registre::afeg("bd_ho", $conf["bd"]["host"]);
Registre::afeg("bd_bd", $conf["bd"]["bdad"]);
Registre::afeg("bd_en", $conf["bd"]["enco"]);
Registre::afeg("url_b", $conf["in"]["host"]);
Registre::afeg("conne", $conf["in"]["conn"]);
Registre::afeg("depur", $conf["in"]["depu"]);
Registre::afeg("refer", $_SERVER["HTTP_REFERER"]);
Registre::afeg("adr_r", $_SERVER["REMOTE_ADDR"]);
Registre::afeg("adr_s", $_SERVER["SERVER_ADDR"]);
Link::iniciar();

if (!connexio_valida())
    die();

if (Registre::lleg("depur")) {
  ini_set('display_errors', "On");
  ini_set('error_reporting', E_ALL);
}
else {
  ini_set('display_errors', "Off");
  ini_set('error_reporting', 0);
}

BaseDades::agafarBD();
Usuari::actualitzar();

if ((Peticio::exis("lloc") ) and (preg_match("/^[A-Za-z0-9]{2,45}$/", Peticio::obte("lloc"))) and (file_exists("./llocs/" . Peticio::obte("lloc") . ".php"))) {
    $lloc = Peticio::obte("lloc");
    $ruta = "./llocs/" . $lloc . ".php";
}
else
    redireccionar(Link::url("index"));

require_once($ruta);
$nomLloc = "Lloc" . ucfirst($lloc);
$objLloc = new $nomLloc();

if (!property_exists($objLloc, "permisos") or ($objLloc->permisos < Usuari::permisos()))
    redireccionar(Link::url("index"));

if ((method_exists($objLloc, "calculs")) and ($objLloc->permisos >= Usuari::permisos()))
    $objLloc->calculs();

$tpl = new Plantilla("./html");
$tpl->carregar("web");
$tpl->mostrar("comu_cap-1");
$tpl->set("URL_B", Link::url());
$tpl->imprimir();

if (property_exists($objLloc, "css") and count($objLloc->css) > 0) {
    for ($i = 0; $i < count($objLloc->css); $i++) {
        $tpl->carregar("web");
        $tpl->mostrar("css");
        $tpl->set("URL_CSS", Link::url() . "/js/" . $objLloc->css[$i]);
        $tpl->imprimir();
    }
}

if (property_exists($objLloc, "jsc_cap") and count($objLloc->jsc_cap) > 0) {
    for ($i = 0; $i < count($objLloc->jsc_cap); $i++) {
        $tpl->carregar("web");
        $tpl->mostrar("jsc_cap");
        $tpl->set("URL_JAV", Link::url() . "/js/" . $objLloc->jsc_cap[$i]);
        $tpl->imprimir();
    }
}

$tpl->carregar("web");
$tpl->mostrar("comu_cap0");
$tpl->set("LOGO", Link::img("llibres.png"));
$tpl->set("INDEX", Link::url("index"));
$tpl->set("LLOC", $objLloc->nomweb);
$tpl->imprimir();

if (count($menu) > 0) {
    $tpl->carregarMostrar("web", "menu_ini");
    for ($i = 0; $i < count($menu); $i++) {
        $tpl->carregar("web");
        $tpl->mostrar("menu_item");
        if (($objLloc->menu == $menu[$i]["lloc"]) or ($lloc == $menu[$i]["lloc"]))
            $tpl->set("MENU_ACTIU", "active");
        else
            $tpl->set("MENU_ACTIU", "");
        $tpl->set("MENU_LINK", Link::url($menu[$i]["lloc"]));
        $tpl->set("MENU_TEXT", $menu[$i]["text"]);
        $tpl->imprimir();
    }
    $tpl->carregarMostrar("web", "menu_fi");
}

$tpl->carregar("web");
$tpl->mostrar("comu_cap1");
$tpl->set("CERQUES", Link::url("cerques"));
$tpl->imprimir();
if (Usuari::dins()) {
    $tpl->carregar("web");
    $tpl->mostrar("logout");
    $tpl->set("EIXIR", Link::url("eixir"));
    $tpl->imprimir();
}
else {
    $tpl->carregar("web");
    $tpl->mostrar("login");
    $tpl->set("ENTRAR", Link::url("entrar"));
    $tpl->imprimir();    
}

$tpl->carregarMostrar("web", "comu_cap2");

if (count($objLloc->molles) > 0) {
    $tpl->carregarMostrar("web", "molles_ini");
    for ($i = 0; $i < count($objLloc->molles) - 1; $i++) {
        $tpl->carregar("web");
        $tpl->mostrar("molla_nact");
        $tpl->set("LINK", $objLloc->molles[$i][0]);
        $tpl->set("TXT_NACT", $objLloc->molles[$i][1]);
        $tpl->imprimir();
    }
    $tpl->carregar("web");
    $tpl->mostrar("molla_act");
    $tpl->set("TXT_ACT", $objLloc->molles[count($objLloc->molles) - 1][1]);
    $tpl->imprimir();
    $tpl->carregarMostrar("web", "molles_fi");
}

if (method_exists($objLloc, "imprimir"))
    $objLloc->imprimir();

if (property_exists($objLloc, "jsc_peu") and count($objLloc->jsc_peu) > 0) {
    for ($i = 0; $i < count($objLloc->jsc_peu); $i++) {
        $tpl->carregar("web");
        $tpl->mostrar("jsc_peu");
        $tpl->set("URL_JAV", Link::url() . "/js/" . $objLloc->jsc_peu[$i]);
        $tpl->imprimir();
    }
}

$tpl->carregarMostrar("web", "comu_peu");

BaseDades::tancarBD();
Registre::netj();
