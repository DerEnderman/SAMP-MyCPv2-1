<?php
$title = "MySQL-Verbindungsdaten";
$hideButton = true;
if (sizeof($_POST)) {
    $host = $_POST["MySQLserver"];
    $user = $_POST["MySQLuser"];
    $password = $_POST["MySQLpassword"];
    $database = $_POST["MySQLdatabase"];
    if (empty($database)) {
        echo "Der Datenbankname muss angegeben werden!";
        die();
    }

    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $_SESSION["MySQLserver"] = $host;
    $_SESSION["MySQLuser"] = $user;
    $_SESSION["MySQLpassword"] = $password;
    $_SESSION["MySQLdatabase"] = $database;
    echo 1;die();
}