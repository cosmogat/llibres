<?php
// 21-06-2013
// alex

class BaseDades {
    static private $us;
    static private $co;
    static private $ho;
    static private $bd;
    static private $con;
    static private $encode;
  
    private function __construct() {}

    static public function agafarBD() {
        self::$us = Registre::lleg("bd_us");
        self::$co = Registre::lleg("bd_co");
        self::$ho = Registre::lleg("bd_ho");
        self::$bd = Registre::lleg("bd_bd");
        self::$encode = Registre::lleg("bd_en");
        self::$con = @mysqli_connect(self::$ho, self::$us, self::$co, self::$bd) or die("Error 0001: No s'ha pogut realitzar la connexió a la base de dades.");
    }
    static public function consVector($sql) {
        $vec = array();
        $cons = @mysqli_query(self::$con, $sql);
        $aux = array();
        while ($aux = (@mysqli_fetch_array($cons, MYSQLI_ASSOC))) {
            if (self::$encode) {
                foreach ($aux as $ind => $val)
                    $aux[$ind] = utf8_encode($val);
            }
            array_push($vec, array_values($aux));
        }
        @mysqli_free_result($cons);
        return $vec;
    }
    static public function consValor($sql) {
        $vec = array();
        $cons = @mysqli_query(self::$con, $sql);
        $vec = @mysqli_fetch_array($cons, MYSQLI_ASSOC);
        if (count($vec) != 0) {
            $vec = array_values($vec);
            @mysqli_free_result($cons);
            if (self::$encode)
                return utf8_encode($vec[0]);
            return $vec[0];
        }
        @mysqli_free_result($cons);
        return "";
    }
    static public function consFiles($sql) {
        $val = 0;
        $cons = @mysqli_query(self::$con, $sql);
        $val = @mysqli_num_rows($cons);
        @mysqli_free_result($cons);
        return $val;
    }
    static public function consulta($sql) {
        $return = False;
        $txt = $sql;
        if (self::$encode)
            $txt = utf8_decode($sql);
        if ($cons = @mysqli_query(self::$con, $txt))
            $return = True;
        @mysqli_free_result($cons);
        return $return;
    }
    static public function tancarBD() {
        @mysqli_close(self::$con);
    }
}
