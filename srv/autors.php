<?php
// 28-08-2018
// cosmogat
// autors.php
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
if ((cadValid($cons)) and ($cons != "")) {
    $sql = "SELECT idescriptor AS c0, codi AS c1, autor AS c2 FROM Escriptor WHERE autor LIKE '%" . $cons . "%' OR codi LIKE '%" . $cons . "%' ORDER BY c1 LIMIT 5";
    $res0 = @mysqli_query($bd, $sql);
    $ind = 0;
    echo "[";
    while ($res = @mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
        $ind++;
        $id = $res["c0"];
        $codi = $res["c1"];
        $autor = $res["c2"];
        if ($ind != 1)
            echo ",";
        echo "\"" . $codi . " - " . $autor . "\"";	
    }
    echo "]";
    @mysqli_free_result($res0);
}
mysqli_close($bd);
