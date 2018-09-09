<?php
// 03-01-2018
// alex
// usu.obj.php

class Usuari {
    private function __construct() {}

    static public function entrar($us, $co) {
        if (cadValid($us) and cadValid($co) and !empty($us) and !empty($co) and !self::dins()) {
            $id = BaseDades::consValor(Consulta::entrar($us, sha1($co)));
            if ($id !== "") {
                Sessio::afeg("login", true);
                Sessio::afeg("idusuari", $id);
                Sessio::afeg("nom", $us);
                Sessio::afeg("dispe", sha1($id . $us . sha1($co)));
                Sessio::afeg("temps", time());
                return true;
            }
        }
        return false;
    }
    
    static public function eixir($url = "") {
        Sessio::tancar();
        if ($url === "") {
            if (strpos(Registre::lleg("refer"), Link::url()) !== false)
                redireccionar(Registre::lleg("refer"));
            else
                redireccionar(Link::url("index"));
        }
        else
            redireccionar($url);
    }
    
    static public function actualitzar() {
        if (self::dins()) {
            if (Sessio::lleg("dispe") !== (sha1(Sessio::lleg("idusuari") . Sessio::lleg("nom") . self::contrassenya())))
                self::eixir(Link::url("index"));
            $temps0 = Sessio::lleg("temps");
            $temps1 = time();
            if (($temps1 - $temps0) > 900)
                self::eixir(Link::url("index"));
            Sessio::afeg("temps", time());
        }

    }
    
    static public function dins() {
        if (Sessio::exis("login"))
            return Sessio::lleg("login");
        return false;
    }
    
    static public function idusuari() {
        if (self::dins())
            return Sessio::lleg("idusuari");
        return -1;
    }
    
    static public function nom() {
        if (self::dins())
            return BaseDades::consValor(Consulta::usuari_nom(self::idusuari()));
        return "";
    }

    static public function codi() {
        if (self::dins())
            return BaseDades::consValor(Consulta::usuari_codi(self::idusuari()));
        return "";
    }
    
    static public function contrassenya() {
        if (self::dins())
            return BaseDades::consValor(Consulta::usuari_cont(self::idusuari()));
        return "";
    }
    
    static public function permisos() {
        if (self::dins())
            return BaseDades::consValor(Consulta::usuari_perm(self::idusuari()));
        return 10;
        // 0: afegir, editar i eliminar usuaris, categories i llibres (root)
        // 1: afegir, editar i eliminar categories propies
        // 2: afegir, editar i eliminar autors i llibres propis
        // 10: usuari sense permisos
    }
    
    static public function impr() {
        if (self::dins()) {
            echo "Usuari:<br />\n"; 
            echo "  (id_usuari) = " . Sessio::lleg("idusuari") . "<br />\n";
            echo "  (login) = " . Sessio::lleg("login") . "<br />\n";
            echo "  (nom) = " . Sessio::lleg("nom") . "<br />\n";
            echo "  (dispe) = " . Sessio::lleg("dispe") . "<br />\n";
            echo "  (temps) = " . Sessio::lleg("temps") . "<br />\n";
        }
        else
            echo "Usuari no connectat.<br />\n";
    }
}