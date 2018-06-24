<?php
// 03-01-2018
// alex
// pet.obj.php

class Peticio {
    private function __construct() {}
    
    static public function exis($clau) {
        return isset($_REQUEST[$clau]);
    }
    
    static public function obte($clau) {
        if (self::exis($clau))
            return $_REQUEST[$clau];
    }

    static public function impr() {
        imprVec($_REQUEST);
    }
}