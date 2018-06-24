<?php
// 24-06-2013
// alex

class Registre {
  static private $reg = array();

  private function __construct() {}
  
  static public function afeg($clau, $valor) {
    self::$reg[$clau] = $valor;
  }
  
  static public function exis($clau) {
    return (is_string($clau) && array_key_exists($clau, self::$reg));
  }

  static public function lleg($clau) {
    if (self::exis($clau))
      return self::$reg[$clau];
    return null;
  }

  static public function borr($clau) {
    if (self::exis($clau)) {
      unset(self::$reg[$clau]);
      return true;
    }
    return false;
  }

  static public function netj() {
    self::$reg = array();
  }

  static public function impr() {
      $tmp = self::$reg;
      ksort($tmp);
      echo "<pre>\n";
      print_r($tmp);
      echo "</pre>\n";
      $tmp = array();
  }

}