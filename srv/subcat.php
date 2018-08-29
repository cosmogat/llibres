<?php
// 29-08-2018
// cosmogat
// subcat.php
require_once("../inc/fun.inc.php");
require_once("../cnf/conf_" . quinPerfil() . ".inc.php");
header('Content-type: application/json');
$host = $conf["bd"]["host"];
$usuari = $conf["bd"]["user"];
$contrasenya = $conf["bd"]["pass"];
$basedades = $conf["bd"]["bdad"];
$bd = @mysqli_connect($host, $usuari, $contrasenya, $basedades);
$cons = isset($_REQUEST['term']) ? $_REQUEST['term'] : "" ;
$items = array();
$cons = trim($cons);
if (preg_match("/^[0-9]{1,2}$/", $cons)) {
    $sql = "";
    if (strlen($cons) == 1) {
        $sql = "SELECT DISTINCT Classificacio.codi AS c00, '' AS c01, Subclassificacio.codi AS c02, Subclassificacio.nom AS c03
                FROM Subsubclassificacio 
                       INNER JOIN Subclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub) 
                       INNER JOIN Classificacio ON (Subclassificacio.classi = Classificacio.idcla) 
                WHERE Classificacio.codi = " . intval($cons) . "
                ORDER BY Classificacio.codi, Subclassificacio.codi, Subsubclassificacio.codi";
    }
    else if (strlen($cons) == 2) {
        $sql = "SELECT DISTINCT Classificacio.codi AS c00, Subclassificacio.codi AS c01, Subsubclassificacio.codi AS c02, Subsubclassificacio.nom AS c03
                FROM Subsubclassificacio 
                       INNER JOIN Subclassificacio ON (Subsubclassificacio.subclassi = Subclassificacio.idsub) 
                       INNER JOIN Classificacio ON (Subclassificacio.classi = Classificacio.idcla) 
                WHERE Classificacio.codi = " . intval($cons[0]) . "
                       AND Subclassificacio.codi = " . intval($cons[1]) . "
                ORDER BY Classificacio.codi, Subclassificacio.codi, Subsubclassificacio.codi";        
    }
    $res0 = @mysqli_query($bd, $sql);
    $ind = 0;
    echo "[";
    while ($res = @mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
        $ind++;
        $valor = $res["c00"] . $res["c01"] . $res["c02"];
        $nom = $valor . " - " . $res["c03"];
        if ($ind != 1)
            echo ",{";
        else
            echo "{";
        echo "\"label\":\"" . $valor . "\",\"value\":\"" . $nom . "\"";
        echo "}";
    }
    echo "]";
    @mysqli_free_result($res0);
}
mysqli_close($bd);
