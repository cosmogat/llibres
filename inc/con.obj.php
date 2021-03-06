<?php
// 08-01-2018
// alex
// con.obj.php
class Consulta {
    
    private function __construct() {}
    
    private static function cercaInterna($txt, $prop, $codi1, $codi2, $codi3, $num, $escr) {
        $c0 = $prop;
        $c1 = intval($codi1);
        $c2 = intval($codi2);
        $c3 = intval($codi3);
        $c4 = intval($num);
        $tx = $txt;
        $au = $escr;
        if ($c0 == 0)
            $c0 = "%";
        if ($c4 == 0)
            $c4 = "%";
        if (($c1 == 0) and ($c2 == 0) and ($c3 == 0))
            $c1 = $c2 = $c3 = "_";
        if ($tx == "")
            $tx = "%";
        if ($au == "")
            $au = "%";
        $prestat = "((SELECT llibre FROM Prestec WHERE Prestec.llibre=Llibre.idllibre AND Prestec.tornat=FALSE LIMIT 1) IS NOT NULL)";
        $tres_mesos = "((SELECT llibre FROM Prestec WHERE Prestec.llibre=Llibre.idllibre AND Prestec.tornat=FALSE AND Prestec.data_prestec < '" . date("Y-m-d H:i:s", time() - (3600 * 24 * 90)) . "' LIMIT 1) IS NOT NULL)";
        $llegit = "((SELECT llegit FROM Critiques WHERE Llibre.idllibre=Critiques.llibre AND Critiques.llegit > 0 AND Critiques.usuari=" . Usuari::idusuari() . ") IS NOT NULL)";
        $sql = "SELECT Classificacio.codi AS c00, Classificacio.nom AS c01, Subclassificacio.codi AS c02, Subclassificacio.nom AS c03, Subsubclassificacio.codi AS c04, Subsubclassificacio.nom AS c05,
                   Escriptor.codi AS c06, Llibre.num_llibre AS c07,
                   Llibre.nom AS c08, Llibre.img_dir AS c09, Escriptor.autor AS c10,  
                   Llibre.any AS c11, Llibre.descripcio AS c12, Usuaris.codi AS c13, " . $prestat . " AS c14, " . $tres_mesos . " AS c15, " . $llegit . " AS c16
            FROM Classificacio
                   INNER JOIN Subclassificacio ON (Subclassificacio.classi = Classificacio.idcla)
                   INNER JOIN Subsubclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub)
                   INNER JOIN Llibre ON (Llibre.classi = Subsubclassificacio.idsubsub)
                   INNER JOIN Escriptor ON (Escriptor.idescriptor = Llibre.autor_principal)
                   INNER JOIN Usuaris ON (Usuaris.idusuari = Llibre.propietari)
            WHERE (Classificacio.codi LIKE '" . $c1 . "' AND Subclassificacio.codi LIKE '" . $c2 . "' AND Subsubclassificacio.codi LIKE '" . $c3 . "' AND Usuaris.codi LIKE '" . $c0 . "' AND Llibre.num_llibre LIKE '" . $c4 . "')
                  AND (Escriptor.autor LIKE '%" . $tx . "%' OR Llibre.nom LIKE '%" . $tx . "%' OR Llibre.descripcio LIKE '%" . $tx . "%')
                  AND (Escriptor.codi LIKE '" . $au . "')
            ORDER BY Classificacio.codi, Subclassificacio.codi, Subsubclassificacio.codi, Escriptor.codi, Llibre.num_llibre";
        return $sql;
    }
    
    static public function llibre_perEtiqueta($et0, $et1, $et2, $et3) {
        $sql = "SELECT Classificacio.nom AS c00, Subclassificacio.nom AS c01, Subsubclassificacio.nom AS c02, 
                       Classificacio.codi AS c03, Subclassificacio.codi AS c04, Subsubclassificacio.codi AS c05, 
                       Subsubclassificacio.idsubsub AS c06, Llibre.idllibre AS c07, Llibre.nom AS c08, Llibre.img_dir AS c09, 
                       Escriptor.idescriptor AS c10, Escriptor.autor AS c11, Escriptor.codi AS c12, Escriptor.es_colleccio AS c13,
                       Escriptor.img_dir AS c14, Escriptor.biografia AS c15, Llibre.ISBN AS c16, Idiomes.ididiomes AS c17, 
                       Idiomes.nom AS c18, Llibre.editorial AS c19, Llibre.any_edicio AS c20, Llibre.any AS c21, 
                       Llibre.data_compra AS c22, Llibre.lloc_compra AS c23,
                       Llibre.descripcio AS c24, Llibre.data_modificacio AS c25, Usuaris.idusuari AS c26, Usuaris.codi AS c27,
                       Usuaris.nom AS c28, Llibre.num_llibre AS c29, Llibre.pagines AS c30
            FROM Classificacio
                   INNER JOIN Subclassificacio ON (Subclassificacio.classi = Classificacio.idcla)
                   INNER JOIN Subsubclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub)
                   INNER JOIN Llibre ON (Llibre.classi = Subsubclassificacio.idsubsub)
                   INNER JOIN Escriptor ON (Escriptor.idescriptor = Llibre.autor_principal)
                   INNER JOIN Idiomes ON (Idiomes.ididiomes = Llibre.idioma)
                   INNER JOIN Usuaris ON (Usuaris.idusuari = Llibre.propietari)
            WHERE Classificacio.codi = " . intval($et1[0]) . "
                   AND Subclassificacio.codi = " . intval($et1[1]) . "
                   AND Subsubclassificacio.codi = " . intval($et1[2]) . "
                   AND Escriptor.codi = '" . $et2 . "'
                   AND Llibre.num_llibre = " . intval($et3) . "
                   AND Usuaris.codi = '" . $et0 . "'
            LIMIT 1";
        return $sql;
    }

    static public function llibre_perId($id) {
        $sql = "SELECT Classificacio.nom AS c00, Subclassificacio.nom AS c01, Subsubclassificacio.nom AS c02, 
                       Classificacio.codi AS c03, Subclassificacio.codi AS c04, Subsubclassificacio.codi AS c05, 
                       Subsubclassificacio.idsubsub AS c06, Llibre.idllibre AS c07, Llibre.nom AS c08, Llibre.img_dir AS c09, 
                       Escriptor.idescriptor AS c10, Escriptor.autor AS c11, Escriptor.codi AS c12, Escriptor.es_colleccio AS c13,
                       Escriptor.img_dir AS c14, Escriptor.biografia AS c15, Llibre.ISBN AS c16, Idiomes.ididiomes AS c17, 
                       Idiomes.nom AS c18, Llibre.editorial AS c19, Llibre.any_edicio AS c20, Llibre.any AS c21, 
                       Llibre.data_compra AS c22, Llibre.lloc_compra AS c23,
                       Llibre.descripcio AS c24, Llibre.data_modificacio AS c25, Usuaris.idusuari AS c26, Usuaris.codi AS c27,
                       Usuaris.nom AS c28, Llibre.num_llibre AS c29, Llibre.pagines AS c30
            FROM Classificacio
                   INNER JOIN Subclassificacio ON (Subclassificacio.classi = Classificacio.idcla)
                   INNER JOIN Subsubclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub)
                   INNER JOIN Llibre ON (Llibre.classi = Subsubclassificacio.idsubsub)
                   INNER JOIN Escriptor ON (Escriptor.idescriptor = Llibre.autor_principal)
                   INNER JOIN Idiomes ON (Idiomes.ididiomes = Llibre.idioma)
                   INNER JOIN Usuaris ON (Usuaris.idusuari = Llibre.propietari)
            WHERE Llibre.idllibre = " . intval($id) . "
            LIMIT 1";
        return $sql;
    }
    
    static public function categories() {
        $sql = "SELECT codi AS c00, nom AS c01, 
                    (SELECT COUNT(*) FROM Subclassificacio WHERE classi=Classificacio.idcla) AS c02
            FROM Classificacio 
            ORDER BY codi";
        return $sql;
    }
    
    static public function categories_completes() {
        $sql = "SELECT DISTINCT Classificacio.codi AS c00, Classificacio.nom AS c01 
                FROM Subsubclassificacio 
                       INNER JOIN Subclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub) 
                       INNER JOIN Classificacio ON (Subclassificacio.classi = Classificacio.idcla) 
                ORDER BY Classificacio.codi, Subclassificacio.codi, Subsubclassificacio.codi";
        return $sql;
    }

    static public function class_perCodi($codi) {
        $sql = "SELECT Classificacio.codi AS c00, Classificacio.nom AS c01, Subclassificacio.codi AS c02, Subclassificacio.nom AS c03, 
                   (SELECT COUNT(*) FROM Subsubclassificacio WHERE subclassi=Subclassificacio.idsub) AS c04
            FROM Subclassificacio 
                   INNER JOIN Classificacio ON (Subclassificacio.classi = Classificacio.idcla) 
            WHERE Classificacio.codi = " . intval($codi) . "
            ORDER BY Classificacio.codi, Subclassificacio.codi";
        return $sql;
    }

    static public function subclass_perCodi($codi0, $codi1) {
        $sql = "SELECT Classificacio.codi AS c00, Classificacio.nom AS c01, Subclassificacio.codi AS c02, Subclassificacio.nom AS c03, Subsubclassificacio.codi AS c04, Subsubclassificacio.nom AS c05, 
                  ((SELECT DISTINCT Llibre.classi FROM Llibre WHERE Subsubclassificacio.idsubsub=Llibre.classi) IS NOT NULL) AS c06 
            FROM Subsubclassificacio 
                   INNER JOIN Subclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub) 
                   INNER JOIN Classificacio ON (Subclassificacio.classi = Classificacio.idcla)  
            WHERE Classificacio.codi = " . intval($codi0) . " 
                   AND Subclassificacio.codi = " . intval($codi1) . " 
            ORDER BY Classificacio.codi, Subclassificacio.codi, Subsubclassificacio.codi";
        return $sql;
    }
    
    static public function subsubclass_perCodi($codi0, $codi1, $codi2) {
        return self::cercaInterna("", 0, $codi0, $codi1, $codi2, 0, "");
    }

    static public function cercarLlibres($txt) {
        return self::cercaInterna($txt, 0, 0, 0, 0, 0, "");
    }
    
    static public function class_perId($tipus, $id) {
        $taula = "";
        $colum = "";
        if ($tipus == 1) {
            $taula = "Classificacio";
            $colum = "idcla";
        }
        else if ($tipus == 2) {
            $taula = "Subclassificacio";
            $colum = "idsub";
        }
        else if ($tipus == 3) {
            $taula = "Subsubclassificacio";
            $colum = "idsubsub";
        }
        $sql = "SELECT codi AS c00, nom AS c01
                FROM  " . $taula . "
                WHERE " . $colum . " = " . intval($id);
        return $sql;
    }
    
    static public function editClassNom_perId($tipus, $id, $nou_nom) {
        $taula = "";
        $colum = "";
        if ($tipus == 1) {
            $taula = "Classificacio";
            $colum = "idcla";
        }
        else if ($tipus == 2) {
            $taula = "Subclassificacio";
            $colum = "idsub";
        }
        else if ($tipus == 3) {
            $taula = "Subsubclassificacio";
            $colum = "idsubsub";
        }
        $sql = "UPDATE " . $taula . " 
                SET nom = '" . $nou_nom .  "' 
                WHERE " . $colum . " = " . $id;
        return $sql;
    }

    static public function elimClass_perId($tipus, $id) {
        $taula = "";
        $colum = "";
        if ($tipus == 1) {
            $taula = "Classificacio";
            $colum = "idcla";
        }
        else if ($tipus == 2) {
            $taula = "Subclassificacio";
            $colum = "idsub";
        }
        else if ($tipus == 3) {
            $taula = "Subsubclassificacio";
            $colum = "idsubsub";
        }
        $sql = "DELETE FROM " . $taula . " 
                WHERE " . $colum . " = " . $id;
        return $sql;
    }
    
    static public function editClassNum_perId($tipus, $id, $nou_codi) {
        $taula = "";
        $colum = "";
        if ($tipus == 1) {
            $taula = "Classificacio";
            $colum = "idcla";
        }
        else if ($tipus == 2) {
            $taula = "Subclassificacio";
            $colum = "idsub";
        }
        else if ($tipus == 3) {
            $taula = "Subsubclassificacio";
            $colum = "idsubsub";
        }
        $sql = "UPDATE " . $taula . " 
                SET codi = " . $nou_codi .  "
                WHERE " . $colum . " = " . $id;
        return $sql;
    }

    static public function editPareSubclass($nou_codi_pare, $idsub) {
        $sql = "UPDATE Subclassificacio 
                SET classi = (SELECT idcla FROM Classificacio WHERE codi = " . intval($nou_codi_pare) . ") 
                WHERE idsub = " . intval($idsub);
        return $sql;
    }
    
    static public function editPareSubsubclass($nou_codi_pare1, $nou_codi_pare2, $idsubsub) {
        $sql = "UPDATE Subsubclassificacio 
                SET subclassi = (
                                SELECT Subclassificacio.idsub AS c00 
                                FROM Subclassificacio 
                                INNER JOIN Classificacio ON (Subclassificacio.classi = Classificacio.idcla) 
                                WHERE Classificacio.codi = " . intval($nou_codi_pare1) . " AND Subclassificacio.codi = " . intval($nou_codi_pare2) . "
                                )
                WHERE idsubsub = " . intval($idsubsub);
        return $sql;
    }
   
    static public function entrar($us, $co_sha1) {
        $sql = "SELECT idusuari FROM Usuaris WHERE nom = '" . $us . "' AND contrassenya = '" . $co_sha1 . "'";
        return $sql;
    }

    static public function usuari_nom($id) {
        $sql = "SELECT nom FROM Usuaris WHERE idusuari = " . intval($id);
        return $sql;
    }

    static public function usuari_codi($id) {
        $sql = "SELECT codi FROM Usuaris WHERE idusuari = " . intval($id);
        return $sql;
    }

    static public function usuari_cont($id) {
        $sql = "SELECT contrassenya FROM Usuaris WHERE idusuari = " . intval($id);
        return $sql;   
    }

    static public function usuari_perm($id) {
        $sql = "SELECT permisos FROM Usuaris WHERE idusuari = " . intval($id);
        return $sql;
    }

    static public function usuaris_id($id) {
        $sql = "SELECT idusuari, nom, codi FROM Usuaris WHERE idusuari = " . intval($id);
        return $sql;
    }

    static public function usuaris() {
        $sql = "SELECT idusuari AS c00, nom AS c01, codi AS c02, permisos AS c03 FROM Usuaris";
        return $sql;
    }
    
    static public function autor($codi) {
        $sql ="SELECT idescriptor AS c00, autor AS c01, codi AS c02, img_dir AS c03, biografia AS c04 , es_colleccio AS c05 FROM Escriptor WHERE codi = '" . $codi . "'";
        return $sql;
    }

    static public function autor_perId($id) {
        $sql ="SELECT idescriptor AS c00, autor AS c01, codi AS c02, img_dir AS c03, biografia AS c04 , es_colleccio AS c05 FROM Escriptor WHERE idescriptor = '" . $id . "'";
        return $sql;
    }

    static public function autors0() {
        $sql = "SELECT DISTINCT LEFT(codi, 1) AS c00 FROM Escriptor ORDER BY codi";
        return $sql;
    }

    static public function autors1($codi) {
        $sql = "SELECT idescriptor AS c00, autor AS c01, codi AS c02, 
                   ((SELECT DISTINCT Llibre.autor_principal FROM Llibre WHERE Llibre.autor_principal = Escriptor.idescriptor) IS NOT NULL) AS c03 
            FROM Escriptor 
            WHERE codi LIKE '" . $codi . "%'";
        return $sql;
    }

    static public function autors2($codi) {
        return self::cercaInterna("", 0, 0, 0, 0, 0, $codi);
    }

    static public function autorsSec($idllib) {
        $sql = "SELECT Autorssecundaris.Llibre_idllibre AS c00, Escriptor.idescriptor AS c01, Escriptor.autor AS c02, 
                       Escriptor.codi AS c03, Escriptor.es_colleccio AS c04, Escriptor.img_dir AS c05, Escriptor.biografia AS c06 
                FROM Autorssecundaris 
                       INNER JOIN Escriptor ON (Autorssecundaris.Escriptor_idescriptor = Escriptor.idescriptor) 
                WHERE Llibre_idllibre = " . intval($idllib);
        return $sql;
    }
    
    static public function critiques($us, $ll) {
        $sql = "SELECT llegit, critica, data_critica FROM Critiques WHERE usuari = " . intval($us) . " AND llibre = " . intval($ll);
        return $sql;
    }

    static public function categories2id($codis) {
        $sql = "";
        $tam = strlen($codis);
        if ($tam == 1) {
            $sql = "SELECT idcla AS c00 
                    FROM Classificacio 
                    WHERE Classificacio.codi = " . intval($codis[0]);
        }
        else if ($tam == 2) {
            $sql = "SELECT idcla AS c00, idsub AS c01 
                    FROM Classificacio INNER JOIN Subclassificacio ON (Subclassificacio.classi = Classificacio.idcla) 
                    WHERE Classificacio.codi = " . intval($codis[0]) . " AND Subclassificacio.codi = " . intval($codis[1]);
        }
        else if ($tam == 3) {
            $sql = "SELECT idcla AS c00, idsub AS c01, idsubsub AS c02 
                    FROM Classificacio INNER JOIN Subclassificacio ON (Subclassificacio.classi = Classificacio.idcla) INNER JOIN Subsubclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub) 
                    WHERE Classificacio.codi = " . intval($codis[0]) . " AND Subclassificacio.codi = " . intval($codis[1]) . " AND Subsubclassificacio.codi = " . intval($codis[2]);
        }
        return $sql;
            
    }
    
    static public function subsubcl($codi) {
        $sql = "SELECT idsubsub AS c00, CONCAT(Classificacio.codi, Subclassificacio.codi, Subsubclassificacio.codi) AS c01, Classificacio.nom AS c02, Subclassificacio.nom AS c03, Subsubclassificacio.nom AS c04
                FROM Classificacio 
                       INNER JOIN Subclassificacio ON (Subclassificacio.classi = Classificacio.idcla) 
                       INNER JOIN Subsubclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub) 
                WHERE Classificacio.codi = " . intval($codi[0]) . " AND Subclassificacio.codi = " . intval($codi[1]) . " AND Subsubclassificacio.codi = " . intval($codi[2]);
        return $sql;
    }

    static public function subsubcl_id($num) {
        $sql = "SELECT idsubsub AS c00, CONCAT(Classificacio.codi, Subclassificacio.codi, Subsubclassificacio.codi) AS c01, Classificacio.nom AS c02, Subclassificacio.nom AS c03, Subsubclassificacio.nom AS c04
                FROM Classificacio 
                       INNER JOIN Subclassificacio ON (Subclassificacio.classi = Classificacio.idcla) 
                       INNER JOIN Subsubclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub) 
                WHERE Subsubclassificacio.idsubsub = " . intval($num);
        return $sql;
    }
    
    static public function insert_subcategoria($cla, $cat, $num) {
        $sql = "INSERT INTO Subclassificacio (classi, nom, codi) VALUES (" . $cla . ", '" . $cat . "' , " . $num . ")";
        return $sql;
    }
    
    static public function insert_subsubcategoria($cla, $cat, $num) {
        $sql = "INSERT INTO Subsubclassificacio (subclassi, nom, codi) VALUES (" . $cla . ", '" . $cat . "' , " . $num . ")";
        return $sql;
    }

    static public function idiomes_id($num) {
        $sql = "SELECT ididiomes AS c00, nom AS c01 FROM Idiomes WHERE ididiomes = " . intval($num);
        return $sql;
    }
    
    static public function exisAutor_perNom($nom) {
        $sql = "SELECT COUNT(*) FROM Escriptor WHERE autor = '" . $nom . "'";
        return $sql;
    }
    
    static public function exisAutor_perCodi($codi) {
        $sql = "SELECT COUNT(*) FROM Escriptor WHERE codi = '" . $codi . "'";
        return $sql;
    }
    
    static public function insertAutor($codi, $nom, $colleccio, $bio) {
        if (trim($bio) == "")
            $sql = "INSERT INTO Escriptor (autor, codi, es_colleccio) VALUES ('" . $nom . "', '" . $codi . "' , " . $colleccio . ")";
        else
            $sql = "INSERT INTO Escriptor (autor, codi, es_colleccio, biografia) VALUES ('" . $nom . "', '" . $codi . "' , " . $colleccio . ", '" . $bio . "')";
        return $sql;
    }

    static public function editAutor($id, $codi, $nom, $colleccio, $bio) {
        if (trim($bio) == "")
            $sql = "UPDATE Escriptor SET autor = '" . $nom . "', codi = '" . $codi . "', es_colleccio = '" . $colleccio . "' WHERE idescriptor = " . $id;
        else            
            $sql = "UPDATE Escriptor SET autor = '" . $nom . "', codi = '" . $codi . "', es_colleccio = '" . $colleccio . "', biografia = '" . $bio . "' WHERE idescriptor = " . $id;
        return $sql;
    }
    
    static public function idautor_perCodi($codi) {
        $sql = "SELECT idescriptor FROM Escriptor WHERE codi = '" . $codi . "'";
        return $sql;
    }

    static public function canvAutorFoto($id, $ruta_foto) {
        $sql = "UPDATE Escriptor SET img_dir = '" . $ruta_foto . "' WHERE idescriptor = " . intval($id);
        return $sql;
    }

    static public function canvLlibreFoto($id, $ruta_foto) {
        $sql = "UPDATE Llibre SET img_dir = '" . $ruta_foto . "' WHERE idllibre = " . intval($id);
        return $sql;
    }
    
    static public function idiomes() {
        $sql = "SELECT * FROM Idiomes";
        return $sql;
    }

    static public function ultim_num($idclass, $idautor, $idpropi) {
        $sql = "SELECT num_llibre 
                FROM Llibre 
                WHERE autor_principal = " . $idautor . " 
                       AND classi = " . $idclass . " 
                       AND propietari = " . $idpropi . " 
                ORDER BY num_llibre DESC 
                LIMIT 1";
        return $sql;
    }

    static public function insertLlibre($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o) {
        $sql = "INSERT INTO Llibre 
                (classi, autor_principal, propietari, num_llibre, nom, data_modificacio, idioma, editorial, ISBN, any_edicio, any, data_compra, lloc_compra, descripcio, pagines) VALUES 
                (" . $a . ", " . $b . ", " . $c . ", " . $d . ", '" . $e . "', '" . $f . "', " . $g . ", '" . $h . "', '" . $i . "', " . $j . ", " . $k . ", '" . $l . "', '" . $m . "', '" . $n . "', " . $o . ")";

        return $sql;
    }
    
    static public function actualLlibre($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $idl) {
        $sql = "UPDATE Llibre 
                SET    classi = " . $a . ", autor_principal = " . $b . ", propietari = " . $c . ", num_llibre = " . $d . ", nom = '" . $e . "', data_modificacio = '" . $f . "', 
                       idioma = " . $g . ", editorial = '" . $h . "', ISBN = '" . $i . "', any_edicio = " . $j . ", any = " . $k . ", data_compra = '" . $l . "', lloc_compra = '" . $m . "', 
                       descripcio = '" . $n . "', pagines = " . $o . "
                WHERE idllibre = " . intval($idl);
        return $sql;
    }
    
    static public function max_id_llibre() {
        $sql = "SELECT MAX(idllibre) AS c00 FROM Llibre";
        return $sql;
    }
    
    static public function insertAutorsSec($idllib, $vec_aut) {
        $sql = "INSERT INTO Autorssecundaris (Llibre_idllibre, Escriptor_idescriptor) VALUES ";
        $tam = count($vec_aut);
        for ($i = 0; $i < $tam - 1; $i++)
            $sql = $sql . "(" . intval($idllib) . ", " . intval($vec_aut[$i]) . "), ";
        $sql = $sql . "(" . intval($idllib) . ", " . intval($vec_aut[$tam - 1]) . ")";
        return $sql;
    }
    
    static public function eliminAutorsSec($idllib) {
        $sql = "DELETE FROM Autorssecundaris WHERE Llibre_idllibre = " . intval($idllib);
        return $sql;
    }


    
}