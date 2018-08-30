<?php
// 30-08-2018
// alex
// orm.obj.php

class ClassCompleta {
    public $id = -1;
    public $codi = "";
    public $nom = array("", "", "");

    public function __construct() {}
    public function __destruct() {
        $this->id = null;
        $this->nom = null;
        $this->codi = null;      
    }    
    public function agafPerId($num) {}
    public function desar() {}
    public function esborrar() {}
}

class Autora {
    public $id = -1;
    public $nom = "";
    public $codi = "";
    public $cole = 0;
    public $imgR = "";
    public $biog = "";

    public function __construct() {}
    public function __destruct() {
        $this->id = null;
        $this->nom = null;
        $this->codi = null;
        $this->cole = null;
        $this->imgR = null;
        $this->biog = null;        
    }    
    public function agafPerId($num) {}
    public function desar() {}
    public function esborrar() {}
}

class Idioma {
    public $id = -1;
    public $nom = "";

    public function __construct() {}
    public function __destruct() {
        $this->id = null;
        $this->nom = null;      
    }
    public function agafPerId($num) {}
    public function desar() {}
    public function esborrar() {}
}

class Propietari {
    public $id = -1;
    public $nom = "";
    public $codi = "";

    public function __construct() {}
    public function __destruct() {
        $this->id = null;
        $this->nom = null;
        $this->codi = null;        
    }
    public function agafPerId($num) {}
    public function desar() {}
    public function esborrar() {}
}

class Llibre {
    public $id = -1;
    public $nom = "";
    public $categ;
    public $autor;
    public $idiom;
    public $propi;
    public $autSe = array();
    public $edito = "";
    public $nisbn = "";
    public $anyPu = 0;
    public $anyEd = 0;
    public $dataC = "";
    public $dataM = "";
    public $llocC = "";
    public $imatg = "";
    public $numpg = 0;
    public $descr = "";

    public function __construct() {
        $this->idiom = new Idioma();
        $this->categ = new ClassCompleta();
        $this->propi = new Propietari();
        $this->autor = new Autora();
    }

    public function __destruct() {
        $this->id = null;
        $this->nom = null;
        $this->edito = null;
        $this->nisbn = null;
        $this->anyPu = null;
        $this->anyEd = null;
        $this->dataC = null;
        $this->dataM = null;
        $this->llocC = null;
        $this->imatg = null;
        $this->numpg = null;
        $this->descr = null;
        $this->categ->__destruct();
        $this->autor->__destruct();
        $this->idiom->__destruct();
        $this->propi->__destruct();
        for ($i = 0; $i < count($this->autSe); $i++) {
            $this->autSe[$i]->__destruct();
        }
    }

    public function agafPerId($num) {
        if (is_numeric($num)) {
            $v = BaseDades::consVector(Consulta::llibre_perId(intval($num)));
            if (count($v) > 0) {
                $llib = $v[0];
                $this->categ->id = intval($llib[6]);
                $this->categ->nom = array($llib[0], $llib[1], $llib[2]);
                $this->categ->codi = $llib[3] . $llib[4] . $llib[5];
                $this->autor->id = intval($llib[10]);
                $this->autor->nom = $llib[11];
                $this->autor->codi = $llib[12];
                $this->autor->cole = intval($llib[13]);
                $this->autor->imgR = $llib[14];
                $this->autor->biog = $llib[15];
                $this->idiom->id = $llib[17];
                $this->idiom->nom = $llib[18];
                $this->propi->id = intval($llib[26]);
                $this->propi->nom = $llib[27];
                $this->propi->codi = $llib[28];
                $this->id = intval($llib[7]);
                $this->nom = $llib[8];
                $this->imatg = $llib[9];
                $this->nisbn = $llib[16];
                $this->edito = $llib[19];
                $this->anyEd = intval($llib[20]);
                $this->anyPu = intval($llib[21]);
                $this->dataC = $llib[22];
                $this->llocC = $llib[23];
                $this->descr = $llib[24];
                $this->dataM = $llib[25];
                $a = BaseDades::consVector(Consulta::autorsSec(intval($num)));
                for ($i = 0; $i < count($a); $i++) {
                    $secund = new Autora();
                    $secund->id = intval($a[$i][1]);
                    $secund->nom = $a[$i][2];
                    $secund->codi = $a[$i][3];
                    $secund->cole = intval($a[$i][4]);
                    $secund->imgR = $a[$i][5];
                    $secund->biog = $a[$i][6];
                    $this->autSe[] = $secund;
                }
                    
                return 1;
            }
        }
        return 0;
    }

    public function agafPerCodi($pro, $cla, $aut, $num) {
        $v = BaseDades::consVector(Consulta::llibre_perEtiqueta($pro, $cla, $aut, $num))[0];
        
    }
    
    public function desar() {}
    public function esborrar() {}
}