<?php
// 07-01-2018
// alex
// lnk.obj.php

class Link {
    static private $url_b;
    private function __construct() {}

    static public function iniciar() {
        self::$url_b = Registre::lleg("url_b");
    }
    
    static public function url($lloc = "", $opt = "") {
        if ($lloc == "")
            return self::$url_b;
        if ($opt == "")
            return self::$url_b . "/" . $lloc . ".html";
        else
            return self::$url_b . "/" . $lloc . "-" . $opt . ".html";
    }

    static public function img($img) {
        return self::$url_b . "/img/" . $img;        
    }
}