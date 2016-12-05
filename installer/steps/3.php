<?php
$title = "myCP Datenbank-Konfiguration (Benutzertabelle)";
$hideButton = true;
$host = $_SESSION["MySQLserver"] ;
$user = $_SESSION["MySQLuser"];
$password = $_SESSION["MySQLpassword"];
$database = $_SESSION["MySQLdatabase"];
$pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$statement = $pdo->prepare("select TABLE_NAME from information_schema.tables WHERE TABLE_SCHEMA = ?");
$statement->execute(array($database));
$tables_ =  $statement->fetchAll();
$tables = array();
foreach ($tables_ as $table) {
    $tables[] = $table["TABLE_NAME"];
}
if (sizeof($_POST)) {
    if (!in_array($_POST["accounts"], $tables)) {
        header("Location: index.php?step=3");
        die();
    }
    $_SESSION["table_accounts"] = $_POST["accounts"];
    header("Location: index.php?step=4");
    die();
}