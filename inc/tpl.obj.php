<?php
// 23-06-2013
// alex

class Plantilla {
  private $dir = "";
  private $lle = "";
  private $cad = "";
  private $fit = "";
  private $con = array();
  private $num = 0;

  public function __construct($direc = "") {
    $this->imp = false;
    $this->dir = $direc;
    $this->num = 0;
    $this->con = array();
    
  }

  public function carregar($arxiu) {
    $this->con[$this->num] = "";
    $this->fit = $this->dir . "/" . $arxiu . ".html";
    $descriptor = fopen($this->fit, "r");
    $this->con[$this->num] = fread($descriptor, filesize($this->fit));
    fclose($descriptor);
  }

  public function set($htmlvar, $var) {
    $this->con = str_replace("{" . $htmlvar . "}", $var, $this->con);
  }

  public function setVector($bloc, $htmlvar, $vec) {
    $lon = strlen($bloc) + 13;
    $ini = strpos($this->con[$this->num], "<!-- INI " . $bloc . " -->") + $lon;
    $fin = strrpos($this->con[$this->num], "<!-- FIN " . $bloc . " -->");
    $contingut = substr($this->con[$this->num], $ini, $fin - $ini);
    $principi = substr($this->con[$this->num], 0, $ini - $lon);
    $final = substr($this->con[$this->num], $fin + $lon);
    $parsejat = "";
    foreach ($vec as $valor)
      $parsejat = $parsejat . str_replace("{" . $htmlvar . "}", $valor, $contingut);
    $this->con[$this->num] = $principi . $parsejat . $final;
  }

  public function setMatriu($bloc, $htmlvars, $mat) {
    $lon = strlen($bloc) + 13;
    $ini = strpos($this->con[$this->num], "<!-- INI " . $bloc . " -->") + $lon;
    $fin = strrpos($this->con[$this->num], "<!-- FIN " . $bloc . " -->");
    $contingut = substr($this->con[$this->num], $ini, $fin - $ini);
    $principi = substr($this->con[$this->num], 0, $ini - $lon);
    $final = substr($this->con[$this->num], $fin + $lon);
    $parsejat = "";
    foreach ($mat as $valor) {
      $tmp = $contingut;
      for ($i = 0; $i < count($htmlvars); $i++)
          $tmp = str_replace("{" . $htmlvars[$i] . "}", $valor[$i], $tmp);
      $parsejat = $parsejat . $tmp;
    }
    $this->con[$this->num] = $principi . $parsejat . $final;
  }

  public function mostrar($bloc) {
    $aux = strlen($bloc) + 13;
    $ini = strpos($this->con[$this->num], "<!-- INI " . $bloc . " -->") + $aux;
    $fin = strrpos($this->con[$this->num], "<!-- FIN " . $bloc . " -->");
    $this->con[$this->num] = substr($this->con[$this->num], $ini, $fin - $ini);
    $this->num++;
    $this->con[$this->num] = "";
  }


  public function imprimir() {
    for ($i = 0; $i < $this->num; $i++)
      echo $this->con[$i];
    $this->num = 0;
    $this->con = array();
  }

  public function carregarMostrar($arxiu, $bloc) {
    $this->carregar($arxiu);
    $this->mostrar($bloc);
    $this->imprimir();
  }
  
  public function __destruct() {
    $this->imp = null;
    $this->lle = null;
    $this->dir = null;
    $this->cad = null;
    $this->fit = null;
    $this->con = null;
    $this->num = null; 
  }
}
