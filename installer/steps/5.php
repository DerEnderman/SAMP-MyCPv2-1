<?php
$title = "myCP Datenbank-Konfiguration Hash-Funktion";
$hideButton = true;
if (sizeof($_POST)) {
    $algos = array(
        "md5" => "md5(",
        "sha1" => "sha1(",
        "whirlpool" => "hash('whirlpool', ",
        "gar keine" => "(",
    );
    $hashAlgo = $_POST["presetAlgo"];
    $hashFunction = "";
    if ($hashAlgo == "Benutzerdefiniert") {
        $hashFunction = $_POST["user-defined"]."\n\n";
    }
    else {
        $hashFunction = 'function getPasswordHash($passwort) {
            return '.$algos[strtolower($hashAlgo)].'$passwort);
        }';
    }
    $_SESSION["hashFunction"] = $hashFunction;
    header("Location: index.php?step=6");
    die();
}