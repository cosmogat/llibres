<?php
// 28-08-2018
// cosmogat
// autors.php
function quinPerfil() {
    $descr = fopen("../cnf/quinperfil.txt", "r");
    $estem = fread($descr, 1);
    if (!preg_match("/^[a-zA-Z0-9]$/", $estem))
        $estem = "0";
    fclose($descr);
    return $estem;
}
function cadValid($cad) {
    if (strpos($cad, "../") !== false)
        return false;
    $permesos = "ABCÇDEFGHIJKLMNÑOPQRSTUVWXYZÁÀÄÉÈËÍÌÏÓÒÖÚÙÜabcçdefghijklmnñopqrstuvwxyzáàäéèëíìïóòöúùü0123456789?._-,:/\\ ";
    for ($i = 0; $i < strlen($cad); $i++)
        if (strpos($permesos, substr($cad, $i, 1)) === false)
            return false;
    return true;
}
require_once("../cnf/conf_" . quinPerfil() . ".inc.php");
header('Content-type: application/json');
$host = $conf["bd"]["host"];
$usuari = $conf["bd"]["user"];
$contrasenya = $conf["bd"]["pass"];
$basedades = $conf["bd"]["bdad"];
$bd = @mysqli_connect($host, $usuari, $contrasenya, $basedades);
$cons = isset($_REQUEST['term']) ? $_REQUEST['term'] : "" ;
$items = array();
if (cadValid($cons)) {
    $sql = "SELECT idescriptor AS c0, codi AS c1, autor AS c2 FROM Escriptor WHERE autor LIKE '%" . $cons . "%' OR codi LIKE '%" . $cons . "%' LIMIT 5";
    $res0 = @mysqli_query($bd, $sql);
    $ind = 0;
    echo "[";
    while ($res = @mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
        $ind++;
        $id = $res["c0"];
        $codi = $res["c1"];
        $autor = $res["c2"];
        if ($ind != 1)
            echo ",{";
        else
            echo "{";
        echo "\"id\":"  . $id . ",\"codi\":\"" . $codi . "\",\"autor\":\"" . $autor . "\"";
        echo "}";
	
    }
    echo "]";
    @mysqli_free_result($res0);
}
mysqli_close($bd);
